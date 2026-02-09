# Restricción de Edición de Materiales - Estado < 4

## Fecha: 2026-02-07

## Cambio Realizado

### Archivo Modificado
`resources/js/components/PackingComponent.vue` (líneas 594-603)

### Función Actualizada: `canEditMaterialsField()`

**Antes**:
```javascript
canEditMaterialsField() {
     return this.edit_mode && (
        (this.has_cap('cap-bodega') && this.data.status <= 3) ||
        (this.has_cap('cap-supcalidad') && this.data.status == 1)
     );
}
```

**Ahora**:
```javascript
canEditMaterialsField() {
     // Solo permitir edición si el estado es menor a 4 (no finalizado)
     if (this.data.status >= 4) {
         return false;
     }
     
     return this.edit_mode && (
        (this.has_cap('cap-bodega') && this.data.status <= 3) ||
        (this.has_cap('cap-supcalidad') && this.data.status == 1)
     );
}
```

## Campos Afectados

Esta función controla la edición de los siguientes campos en la tabla de materiales:

1. **LOTE** (`e.lot1`)
2. **PRIMERA ENTREGA** (`e.entrega1`)
3. **SEGUNDA ENTREGA** (`e.entrega2`)
4. **DEVOLUCIÓN** (`e.return`)

## Lógica de Edición

### Estados de la Orden
- **Estado 1**: Orden creada
- **Estado 2**: Pendiente de aprobación
- **Estado 3**: En proceso
- **Estado 4**: **Finalizada** ❌ (NO EDITABLE)

### Permisos por Rol

#### Bodega (`cap-bodega`)
- ✅ Puede editar en estados 1, 2, 3
- ❌ NO puede editar en estado 4 (finalizada)

#### Supervisor de Calidad (`cap-supcalidad`)
- ✅ Puede editar en estado 1
- ❌ NO puede editar en estados 2, 3, 4

### Condiciones para Editar

Para que un campo sea editable, **TODAS** estas condiciones deben cumplirse:

1. ✅ `edit_mode` debe ser `true` (usuario activó modo edición)
2. ✅ `data.status` debe ser **< 4** (orden NO finalizada)
3. ✅ Usuario debe tener uno de los roles permitidos:
   - `cap-bodega` con estado <= 3
   - `cap-supcalidad` con estado == 1

## Flujo de Trabajo

### Escenario 1: Bodega en Estado 3
```
Estado: 3 (En proceso)
Rol: Bodega
edit_mode: true

Verificación:
1. ¿Estado >= 4? NO (3 < 4) ✅
2. ¿edit_mode? SÍ ✅
3. ¿Bodega Y estado <= 3? SÍ ✅

Resultado: PUEDE EDITAR ✅
```

### Escenario 2: Bodega en Estado 4
```
Estado: 4 (Finalizada)
Rol: Bodega
edit_mode: true

Verificación:
1. ¿Estado >= 4? SÍ (4 >= 4) ❌

Resultado: NO PUEDE EDITAR ❌
```

### Escenario 3: SupCalidad en Estado 2
```
Estado: 2 (Pendiente aprobación)
Rol: SupCalidad
edit_mode: true

Verificación:
1. ¿Estado >= 4? NO (2 < 4) ✅
2. ¿edit_mode? SÍ ✅
3. ¿SupCalidad Y estado == 1? NO (2 != 1) ❌

Resultado: NO PUEDE EDITAR ❌
```

## Impacto en la UI

Cuando `canEditMaterialsField()` retorna `false`, los campos se deshabilitan:

```html
<input 
    type="text" 
    :disabled="!canEditMaterialsField"  <!-- Se deshabilita -->
    v-model="e.lot1" 
    placeholder="Ingresar valor ..." 
    class="form-control form-control-sm defblue1" 
/>
```

### Apariencia Visual
- **Habilitado**: Campo blanco, cursor de texto, puede escribir
- **Deshabilitado**: Campo gris, cursor no permitido, no puede escribir

## Casos de Uso

### ✅ Caso 1: Bodega trabaja en orden nueva
1. Bodega crea orden (estado 1)
2. Activa modo edición
3. Llena materiales (LOTE, ENTREGAS, DEVOLUCIÓN)
4. Guarda → estado cambia a 2
5. Puede seguir editando (estado 2 < 4)

### ✅ Caso 2: Orden en proceso
1. Orden en estado 3 (en proceso)
2. Bodega activa modo edición
3. Puede editar materiales (estado 3 < 4)
4. Guarda cambios

### ❌ Caso 3: Orden finalizada
1. Orden en estado 4 (finalizada)
2. Bodega intenta activar modo edición
3. Campos de materiales permanecen deshabilitados
4. NO puede editar (estado 4 >= 4)

## Seguridad

Esta validación es solo en el **frontend**. Para seguridad completa, el backend también debe validar:

```php
// En EmpaqueController.php - método saveOrUpdate()
if ($order->status >= 4) {
    throw new \Exception("No se pueden editar materiales de una orden finalizada");
}
```

## Notas Técnicas

- La verificación `if (this.data.status >= 4)` se ejecuta **primero** para optimización
- Si el estado es >= 4, retorna `false` inmediatamente sin verificar roles
- La condición `status <= 3` en Bodega es redundante ahora, pero se mantiene para claridad
- La función es reactiva: si `data.status` cambia, los campos se habilitan/deshabilitan automáticamente

## Testing Recomendado

### Test 1: Bodega en Estado 3
1. Iniciar sesión como Bodega
2. Abrir orden en estado 3
3. Activar modo edición
4. ✅ Verificar que campos de materiales están habilitados

### Test 2: Bodega en Estado 4
1. Iniciar sesión como Bodega
2. Abrir orden en estado 4 (finalizada)
3. Intentar activar modo edición
4. ✅ Verificar que campos de materiales están deshabilitados

### Test 3: SupCalidad en Estado 1
1. Iniciar sesión como SupCalidad
2. Abrir orden en estado 1
3. Activar modo edición
4. ✅ Verificar que campos de materiales están habilitados

### Test 4: SupCalidad en Estado 2
1. Iniciar sesión como SupCalidad
2. Abrir orden en estado 2
3. Activar modo edición
4. ✅ Verificar que campos de materiales están deshabilitados

### Test 5: Transición de Estado
1. Abrir orden en estado 3 con campos habilitados
2. Finalizar orden (cambiar a estado 4)
3. ✅ Verificar que campos se deshabilitan automáticamente
