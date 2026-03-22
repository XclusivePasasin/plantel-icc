# Sistema de Bloqueo Inmediato para Campos de Entregas

## Fecha: 2026-02-07

## Problema
Los campos de "ENTREGAS A PRODUCTO TERMINADO" solo se bloqueaban después de guardar en la base de datos y recargar la página. Los usuarios podían seguir editando campos que ya habían llenado hasta que guardaran explícitamente.

## Solución: Bloqueo en Memoria (Inmediato)

Se implementó un sistema de **bloqueo en memoria** que bloquea los campos **inmediatamente** cuando el usuario los llena, sin necesidad de guardar primero.

### Archivo Modificado
`resources/js/components/PackingComponent.vue`

## Cambios Implementados

### 1. Nuevo Estado en Data (línea 531)
```javascript
data: function(){
    return {
        // ... otros estados
        lockedEntregas: [], // 🔒 Locks en memoria para bloqueo inmediato
    }
}
```

### 2. Inicialización en Mounted (línea 539)
```javascript
mounted() {
    this.reloadOriginalTimes();
    this.reloadOriginalOperarios();
    this.reloadOriginalEntregas();
    this.initializeLockedEntregas(); // 🔒 Inicializar locks en memoria
    this.checkIfEndDateFilled();
}
```

### 3. Función `initializeLockedEntregas()` (líneas 1320-1369)
Inicializa los locks basándose en los valores existentes cuando se carga el componente:

```javascript
initializeLockedEntregas() {
    this.lockedEntregas = this.data.entregas.map(entrega => {
        const locks = {
            cantidad: false,
            entrega: false,
            recibe: false
        };
        
        // Bloquear 'cantidad' si ya tiene valor
        if (entrega.cantidad) {
            const strVal = String(entrega.cantidad).trim();
            if (strVal !== '' && strVal !== '/') {
                const parts = strVal.split('/');
                const part0 = parts[0] ? parts[0].trim() : '';
                const part1 = parts[1] ? parts[1].trim() : '';
                if (part0 !== '' || part1 !== '') {
                    locks.cantidad = true;
                }
            }
        }
        
        // Similar para 'entrega' y 'recibe'...
        
        return locks;
    });
}
```

### 4. Función `lockFieldIfFilled()` (líneas 1370-1410)
Bloquea un campo específico cuando se detecta que tiene valor:

```javascript
lockFieldIfFilled(index, fieldName) {
    // Asegurar que existe el objeto de locks para este índice
    if (!this.lockedEntregas[index]) {
        this.$set(this.lockedEntregas, index, {
            cantidad: false,
            entrega: false,
            recibe: false
        });
    }
    
    const currentValue = this.data.entregas[index][fieldName];
    
    if (!currentValue) {
        return; // No bloquear si está vacío
    }
    
    const strVal = String(currentValue).trim();
    
    // Para campos compuestos (cantidad, recibe)
    if (fieldName === 'cantidad' || fieldName === 'recibe') {
        if (strVal !== '' && strVal !== '/') {
            if (strVal.includes('/')) {
                const parts = strVal.split('/');
                const part0 = parts[0] ? parts[0].trim() : '';
                const part1 = parts[1] ? parts[1].trim() : '';
                // Bloquear si cualquiera de las partes tiene valor
                if (part0 !== '' || part1 !== '') {
                    this.$set(this.lockedEntregas[index], fieldName, true);
                }
            }
        }
    } else {
        // Para campos simples (entrega)
        if (strVal !== '') {
            this.$set(this.lockedEntregas[index], fieldName, true);
        }
    }
}
```

### 5. Actualización de `isFieldLocked()` (líneas 667-672)
Ahora verifica primero los locks en memoria antes de verificar la base de datos:

```javascript
isFieldLocked(index, fieldName) {
    // 🔒 NUEVO: Primero verificar locks en memoria (bloqueo inmediato)
    if (this.lockedEntregas[index] && this.lockedEntregas[index][fieldName]) {
        return true;
    }

    // Luego verificar si existe el índice en los datos originales (bloqueo desde BD)
    if (!this.originalEntregas || !this.originalEntregas[index]) {
        return false;
    }
    
    // ... resto de la lógica original
}
```

### 6. Llamadas a `lockFieldIfFilled()` en Inputs

#### Campo "CANTIDAD" (línea 634)
```javascript
updateCompositeField(index, field, partIndex, newValue) {
    // ... lógica de actualización
    
    // 🔒 NUEVO: Bloquear el campo si ahora tiene valor
    this.lockFieldIfFilled(index, field);
    
    this.$forceUpdate(); 
}
```

#### Campo "ENTREGADO" (línea 361)
```html
<input 
    v-model="eg.entrega"
    @input="lockFieldIfFilled(index, 'entrega')"
/>
```

### 7. Reinicialización después de Guardar

Se agregó `initializeLockedEntregas()` después de cada operación que recarga datos:

- **takeOrder()** (línea 928) - Después de guardar orden
- **handleVerifyLot()** (línea 984) - Después de verificar lote
- **authorize()** (línea 1023) - Después de autorizar
- **updateTracking()** (línea 1109) - Después de actualizar tracking

## Flujo de Trabajo

### Escenario 1: Usuario llena un campo por primera vez

1. Usuario escribe en "CANTIDAD" → `@input` dispara `updateCompositeField()`
2. `updateCompositeField()` actualiza el valor → llama `lockFieldIfFilled()`
3. `lockFieldIfFilled()` detecta que el campo tiene valor → establece `lockedEntregas[index].cantidad = true`
4. `isFieldLocked()` retorna `true` → el campo se deshabilita **inmediatamente**

### Escenario 2: Usuario carga una orden existente

1. `mounted()` se ejecuta → llama `initializeLockedEntregas()`
2. `initializeLockedEntregas()` revisa todos los campos de `data.entregas`
3. Para cada campo con valor, establece el lock correspondiente en `lockedEntregas`
4. Los campos con valores existentes aparecen deshabilitados desde el inicio

### Escenario 3: Usuario guarda cambios

1. Usuario hace clic en "Guardar" → se ejecuta `takeOrder()` o `updateTracking()`
2. Se envían los datos al backend → backend responde con datos actualizados
3. Se llama `formatPackingDB()` → actualiza `this.data`
4. Se llama `reloadOriginalEntregas()` → actualiza valores originales desde BD
5. Se llama `initializeLockedEntregas()` → **reinicializa locks** basándose en los nuevos valores guardados
6. Los locks ahora reflejan el estado guardado en la base de datos

## Ventajas del Sistema

1. ✅ **Bloqueo Inmediato**: Los campos se bloquean tan pronto como el usuario los llena
2. ✅ **No Requiere Guardar**: El bloqueo ocurre en memoria, sin necesidad de comunicación con el servidor
3. ✅ **Independencia de Campos**: Cada campo (`cantidad`, `entrega`, `recibe`) se bloquea independientemente
4. ✅ **Sincronización con BD**: Después de guardar, los locks se sincronizan con los valores de la base de datos
5. ✅ **Compatibilidad**: Funciona tanto con datos nuevos como con datos existentes
6. ✅ **Persistencia**: Los locks se mantienen incluso después de recargar datos desde el servidor

## Notas Técnicas

- Se usa `this.$set()` para asegurar reactividad de Vue en objetos dinámicos
- Los locks en memoria tienen prioridad sobre los locks desde BD
- Los campos compuestos (`cantidad`, `recibe`) se bloquean si **cualquiera** de sus partes tiene valor
- Los campos de texto (`entrega`) se bloquean si tienen cualquier texto no vacío
- La reinicialización de locks es crucial después de cada operación de guardado para mantener sincronización

## Estructura de Datos

### lockedEntregas
```javascript
[
  {
    cantidad: true,   // Bloqueado porque tiene "10/2"
    entrega: true,    // Bloqueado porque tiene "Gabriela Vásquez"
    recibe: false     // No bloqueado, aún vacío
  },
  {
    cantidad: false,  // No bloqueado, vacío
    entrega: false,   // No bloqueado, vacío
    recibe: false     // No bloqueado, vacío
  }
]
```

### data.entregas
```javascript
[
  {
    date: "06/02/2026",
    cantidad: "10/2",
    entrega: "Gabriela Vásquez",
    recibe: ""  // Vacío, puede ser llenado después
  },
  {
    date: "07/02/2026",
    cantidad: "",
    entrega: "",
    recibe: ""
  }
]
```
