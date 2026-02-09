# Cambios en PackingComponent - Entregas y Recibido Independientes

## Fecha: 2026-02-07

## Problema Original
Las columnas "ENTREGAS A PRODUCTO TERMINADO" (cantidad) y "RECIBIDO" (recibe) estaban bloqueándose mutuamente. Cuando se llenaba una, la otra también se bloqueaba, impidiendo que los usuarios pudieran llenar el recibido después de las entregas.

**Problema adicional descubierto**: El backend estaba llenando automáticamente el campo `recibe` con nombres de usuarios (como "Jessica Córdova") cuando debería ser un campo numérico para cantidades (formato "cajas/unidades").

## Solución Implementada

### Archivos Modificados
1. `resources/js/components/PackingComponent.vue` (Frontend)
2. `app/Http/Controllers/EmpaqueController.php` (Backend)

### Cambios en el Frontend (`PackingComponent.vue`)

#### Función `isFieldLocked` (líneas 665-697)
Se modificó la lógica de bloqueo para que los campos sean **completamente independientes** y manejen datos mixtos:

```javascript
// ANTES: Solo manejaba formato numérico "cajas/unidades"
if (fieldName === 'cantidad' || fieldName === 'recibe') {
    if (strVal.includes('/')) {
        const parts = strVal.split('/');
        return part0 !== '' || part1 !== '';
    }
}

// AHORA: Maneja tanto formato numérico como texto (nombres)
if (fieldName === 'cantidad' || fieldName === 'recibe') {
    // Si contiene "/", es formato numérico "cajas/unidades"
    if (strVal.includes('/')) {
        const parts = strVal.split('/');
        return part0 !== '' || part1 !== '';
    }
    // Si NO contiene "/", podría ser texto (nombre de persona) - también bloquear
    // Esto maneja casos donde 'recibe' tiene nombres en lugar de números
    return strVal !== '';
}
```

### Cambios en el Backend (`EmpaqueController.php`)

#### Método `tracking` (líneas 785-793)
Se eliminó la lógica que automáticamente llenaba el campo `recibe` con el nombre del usuario:

```php
// ANTES: Firmaba automáticamente con el nombre del usuario
if (
    isset($existingEntregas[$index]['date'], 
        $existingEntregas[$index]['cantidad'], 
        $existingEntregas[$index]['entrega']) &&
    !empty($existingEntregas[$index]['date']) &&
    !empty($existingEntregas[$index]['cantidad']) &&
    !empty($existingEntregas[$index]['entrega']) &&
    (empty($existingEntregas[$index]['recibe']) || 
    $existingEntregas[$index]['recibe'] === null)
) {
    $existingEntregas[$index]['recibe'] = session('user_cur_fullname'); // ❌ INCORRECTO
}

// AHORA: Solo un comentario explicativo
// 🔹 NOTA: El campo 'recibe' es para cantidades numéricas (cajas/unidades)
// NO debe ser firmado automáticamente con nombres de usuario
// Se eliminó la lógica de firma automática que causaba confusión de datos
```

## Comportamiento Actual

### Columnas en "ENTREGAS A PRODUCTO TERMINADO"

1. **FECHA**: Siempre deshabilitada (solo lectura)

2. **CANTIDAD (C/U)**: 
   - Se habilita cuando: `canEditEntrega(index)` es true Y no está bloqueada Y no es rol bodega
   - Se bloquea cuando: Ya tiene valor guardado en la base de datos
   - **Independiente de RECIBIDO**

3. **ENTREGADO**: 
   - Campo de texto para el nombre de quien entrega
   - Se habilita cuando: `canEditEntrega(index)` es true Y no está bloqueada Y no es rol bodega
   - Se bloquea cuando: Ya tiene texto guardado en la base de datos
   - **Independiente de RECIBIDO**

4. **RECIBIDO (C/U)**: 
   - Campo numérico para cantidades recibidas (formato "cajas/unidades")
   - Se habilita cuando: `canEditEntrega(index)` es true Y no está bloqueada
   - Se bloquea cuando: Ya tiene valor guardado en la base de datos
   - **Independiente de CANTIDAD y ENTREGADO**
   - **NO tiene restricción de rol bodega** - puede ser llenado por producción después
   - **YA NO se llena automáticamente** con nombres de usuario

## Flujo de Trabajo Esperado

1. **Paso 1 - Bodega llena entregas**:
   - Bodega llena "CANTIDAD" y "ENTREGADO"
   - Guarda los cambios
   - Estos campos quedan bloqueados
   - **RECIBIDO permanece vacío** (ya no se llena con nombre automáticamente)

2. **Paso 2 - Producción puede llenar recibido después**:
   - Los campos "RECIBIDO" permanecen habilitados
   - Producción puede llenar "RECIBIDO" con cantidades numéricas (formato "cajas/unidades")
   - Cuando se guarda, "RECIBIDO" se bloquea

3. **Resultado**:
   - Cada columna se bloquea solo cuando tiene datos guardados
   - No hay dependencia entre las columnas
   - El flujo de trabajo es más flexible
   - Los datos son consistentes (números en campos numéricos, texto en campos de texto)

## Estructura de Datos Correcta

### JSON en la base de datos:
```json
[
  {
    "date": "06/02/2026",
    "cantidad": "10/2",           // ← Cajas/Unidades (numérico)
    "entrega": "Gabriela Vásquez", // ← Nombre quien entrega (texto)
    "recibe": "15/3"              // ← Cajas/Unidades recibidas (numérico) ✅
  }
]
```

### Datos incorrectos anteriores:
```json
[
  {
    "date": "06/02/2026",
    "cantidad": "10/2",
    "entrega": "Gabriela Vásquez",
    "recibe": "Jessica Córdova"    // ❌ INCORRECTO - debería ser numérico
  }
]
```

## Notas Técnicas

- La función `isFieldLocked` verifica el valor **original** de la base de datos (almacenado en `originalEntregas`)
- Los campos compuestos (cantidad/recibe) usan el formato "valor1/valor2"
- Un campo se considera "lleno" si cualquiera de sus partes tiene valor
- El bloqueo es por campo individual, no afecta a otros campos
- La función ahora maneja datos mixtos (texto y números) para compatibilidad con datos antiguos
- Los nuevos datos deben seguir el formato correcto: números en `recibe`, texto en `entrega`

