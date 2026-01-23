# Lista de Verificación - Material Especial TMA (003007000089)

## 📋 Checklist de Implementación

### ✅ Archivos Modificados
- [x] `resources/js/components/MixOrderComponent.vue`
- [x] Documentación creada: `IMPLEMENTACION_MATERIAL_ESPECIAL_TMA.md`
- [x] Resumen creado: `RESUMEN_MATERIAL_ESPECIAL_TMA.md`

### ✅ Cambios en Código

#### Constantes y Datos
- [x] Constante `SPECIAL_MATERIAL_CODE` agregada
- [x] Variables TMA agregadas (`tmaModal`, `tmaLotNumber`, `tmaChecked`, `specialMaterialData`)
- [x] Computed property `hasSpecialMaterial` agregada

#### Métodos Helper
- [x] Método `isSpecialMaterial()` implementado
- [x] Método `openTMAModal()` implementado
- [x] Método `handleTMALotInput()` implementado
- [x] Método `saveTMALot()` implementado

#### Validaciones
- [x] `validateCheckboxes()` actualizado con excepción
- [x] `validateMaterialLots()` actualizado con excepción
- [x] `validateAllMaterialsReceived()` actualizado con excepción

#### UI/Template
- [x] Checkbox habilitación actualizada (estado 5)
- [x] Botón TMA agregado
- [x] Modal TMA agregado
- [x] Modal TMA inicializado en `mounted()`

---

## 🧪 Plan de Pruebas

### Escenario 1: Producto SIN Material Especial

#### Pasos:
1. Abrir orden de producción sin material 003007000089
2. Navegar por todos los estados del proceso

#### Verificaciones:
- [ ] Botón "Ingresar Lote TMA" NO aparece en ningún estado
- [ ] Validaciones estándar funcionan normalmente
- [ ] No hay errores en consola
- [ ] Flujo completo funciona sin problemas

---

### Escenario 2: Producto CON Material Especial - Estado < 5

#### Estados a probar:
- Estado 2: PENDIENTE_APROVACION_PESAJE
- Estado 3: PESAJE_APROBADO
- Estado 4: PESAJE_AUTORIZADO

#### Pasos:
1. Abrir orden con material 003007000089
2. Verificar en cada estado antes de MEZCLA_EN_PROCESO

#### Verificaciones:
- [ ] Material especial aparece en tabla de materiales
- [ ] Columnas OCULTAS (no visibles):
  - [ ] "Revisión Materiales" NO aparece
  - [ ] "Primer entrega" NO aparece
  - [ ] "Lote" (primera columna) NO aparece
- [ ] Columnas VISIBLES:
  - [ ] "Código"
  - [ ] "Descripción"
  - [ ] "Cantidad Requerida"
  - [ ] "Unidad"
  - [ ] "Almacen"
  - [ ] "Segunda entrega"
  - [ ] "Lote" (segunda columna)
- [ ] Flujo NO se bloquea si material especial no tiene:
  - [ ] Checkbox marcado
  - [ ] Lote ingresado
- [ ] Otros materiales siguen requiriendo validación
- [ ] Se puede aprobar pesaje sin validar material especial
- [ ] Se puede autorizar sin validar material especial

---

### Escenario 3: Producto CON Material Especial - Estado 5 (MEZCLA_EN_PROCESO)

#### Pasos:
1. Abrir orden con material 003007000089
2. Avanzar hasta estado MEZCLA_EN_PROCESO (5)

#### Verificaciones Generales:
- [ ] Columnas VISIBLES (ahora aparecen):
  - [ ] "Revisión Materiales" VISIBLE
  - [ ] "Primer entrega" VISIBLE
  - [ ] "Lote" (primera columna) VISIBLE
- [ ] Checkboxes de todos los materiales están HABILITADOS
- [ ] Botón "Ingresar Lote TMA" APARECE
- [ ] Botón tiene icono de flask
- [ ] Botón está habilitado (usuario con `cap-materiaprima`)

#### Verificaciones del Modal TMA:
1. **Abrir Modal:**
   - [ ] Click en "Ingresar Lote TMA" abre modal
   - [ ] Modal muestra título "Ingreso de Lote TMA"
   - [ ] Descripción del material se muestra correctamente
   - [ ] Código 003007000089 se muestra correctamente

2. **Input de Lote:**
   - [ ] Campo de lote está vacío inicialmente (si no hay lote previo)
   - [ ] Campo de lote muestra lote existente (si ya hay uno)
   - [ ] Texto ingresado se convierte a MAYÚSCULAS automáticamente
   - [ ] Placeholder "Ingresar número de lote" visible

3. **Checkbox:**
   - [ ] Checkbox "Material verificado" presente
   - [ ] Estado inicial refleja `entrega3` del material
   - [ ] Se puede marcar/desmarcar

4. **Botones del Modal:**
   - [ ] Botón "Cancelar" cierra modal sin guardar
   - [ ] Botón "Guardar" está habilitado

5. **Validación al Guardar:**
   - [ ] Intentar guardar sin lote muestra mensaje de error
   - [ ] Mensaje: "Debe ingresar un número de lote"
   - [ ] Modal NO se cierra si hay error

6. **Guardar Exitoso:**
   - [ ] Ingresar lote válido
   - [ ] Click en "Guardar"
   - [ ] Modal se cierra
   - [ ] Mensaje de éxito aparece: "Lote TMA actualizado correctamente"
   - [ ] Material especial en tabla muestra nuevo lote
   - [ ] Checkbox del material refleja estado guardado

7. **Actualización Aislada:**
   - [ ] Solo el material 003007000089 se actualiza
   - [ ] Otros materiales NO se modifican
   - [ ] Lotes de otros materiales permanecen igual
   - [ ] Checkboxes de otros materiales permanecen igual

8. **Reabrir Modal:**
   - [ ] Abrir modal nuevamente
   - [ ] Lote guardado aparece en el campo
   - [ ] Checkbox refleja estado guardado
   - [ ] Se puede modificar y guardar nuevamente

---

### Escenario 4: Permisos de Usuario

#### Usuario SIN permiso `cap-materiaprima`:
- [ ] Botón "Ingresar Lote TMA" está DESHABILITADO
- [ ] No puede abrir modal TMA

#### Usuario CON permiso `cap-materiaprima`:
- [ ] Botón "Ingresar Lote TMA" está HABILITADO
- [ ] Puede abrir modal TMA
- [ ] Puede ingresar y guardar lote

#### Usuario CON permisos de calidad (cap-calidad, cap-supcalidad, etc.):
- [ ] Checkboxes habilitados en estado 5
- [ ] Puede marcar/desmarcar checkboxes

---

### Escenario 5: Validaciones de Flujo

#### Antes de Iniciar Mezcla (Estado < 5):
- [ ] Aprobar pesaje SIN validar material especial → ✅ Permitido
- [ ] Autorizar SIN validar material especial → ✅ Permitido
- [ ] Iniciar mezcla SIN validar material especial → ✅ Permitido

#### Durante Mezcla (Estado = 5):
- [ ] Material especial SIN lote → Validación debe aplicar
- [ ] Material especial SIN checkbox → Validación debe aplicar
- [ ] Finalizar mezcla requiere material especial validado

---

### Escenario 6: Casos Edge

#### Múltiples Materiales Especiales:
- [ ] Si hay más de un material 003007000089
- [ ] Botón TMA aparece
- [ ] Modal muestra el primero encontrado
- [ ] Actualización afecta solo al primero

#### Material Especial con Lote Duplicado:
- [ ] Ingresar lote con "/" en modal TMA
- [ ] Verificar comportamiento
- [ ] Guardar correctamente

#### Cambios Concurrentes:
- [ ] Modificar lote en tabla principal
- [ ] Abrir modal TMA
- [ ] Verificar que muestra lote actualizado
- [ ] Guardar desde modal
- [ ] Verificar actualización correcta

---

## 🐛 Verificación de Errores

### Consola del Navegador:
- [ ] No hay errores de JavaScript
- [ ] No hay warnings de Vue
- [ ] No hay errores de compilación

### Red/Network:
- [ ] No hay llamadas API fallidas
- [ ] Respuestas del servidor son correctas

### UI/UX:
- [ ] No hay elementos superpuestos
- [ ] Modal se centra correctamente
- [ ] Botones tienen estilos correctos
- [ ] Iconos se muestran correctamente

---

## 📊 Matriz de Estados vs Comportamiento

| Estado | Valor | Columnas Visibles | Checkbox Habilitado | Botón TMA Visible | Validación Requerida |
|--------|-------|-------------------|---------------------|-------------------|---------------------|
| PENDIENTE_APROVACION_PESAJE | 2 | ❌ | ❌ | ❌ | ❌ |
| PESAJE_APROBADO | 3 | ❌ | ❌ | ❌ | ❌ |
| PESAJE_AUTORIZADO | 4 | ❌ | ❌ | ❌ | ❌ |
| **MEZCLA_EN_PROCESO** | **5** | ✅ | ✅ | ✅ | ✅ |
| MEZCLA_FINALIZADA | 6 | ✅ | ❌ | ❌ | ✅ |
| MEZCLA_AUTORIZADA | 7 | ✅ | ❌ | ❌ | ✅ |

**Nota:** "Columnas Visibles" se refiere a "Revisión Materiales", "Primer entrega" y "Lote" (primera columna).

---

## 🔍 Puntos Críticos a Verificar

### 1. Excepción de Validación
```javascript
// Verificar que esta lógica funciona en:
// - validateCheckboxes()
// - validateMaterialLots()
// - validateAllMaterialsReceived()

if (this.isSpecialMaterial(material) && 
    this.data.status < this.FLAGS.MEZCLA_EN_PROCESO) {
    return true; // Debe permitir continuar
}
```

### 2. Habilitación de Checkbox
```vue
<!-- Verificar en template -->
:disabled="!(
    data.status === FLAGS.MEZCLA_EN_PROCESO &&
    (has_cap('cap-calidad') || ...)
)"
```

### 3. Visibilidad de Botón TMA
```vue
<!-- Verificar condición -->
v-if="hasSpecialMaterial && data.status === FLAGS.MEZCLA_EN_PROCESO"
```

### 4. Actualización Aislada
```javascript
// Verificar que solo actualiza índice específico
this.$set(this.data.materials[materialIndex], 'lot1', this.tmaLotNumber);
this.$set(this.data.materials[materialIndex], 'entrega3', this.tmaChecked);
```

---

## ✅ Criterios de Aceptación Final

- [ ] **CA1:** Flujo no se bloquea si material 003007000089 no está chequeado antes de mezcla
- [ ] **CA2:** Checkboxes deshabilitados hasta estado MEZCLA_EN_PROCESO = 5
- [ ] **CA3:** Botón TMA solo aparece si existe material especial
- [ ] **CA4:** Botón solo actualiza componente del material especial
- [ ] **CA5:** Si no existe material especial, no se muestran controles
- [ ] **CA6:** No hay impacto en otros materiales ni procesos

---

## 📝 Notas de Prueba

### Ambiente de Prueba:
- **URL:** http://localhost:8000 (o según configuración)
- **Usuario de Prueba:** _________________
- **Permisos del Usuario:** _________________

### Productos de Prueba:
- **Producto SIN material especial:** _________________
- **Producto CON material especial:** _________________

### Resultados:
```
Fecha de Prueba: _________________
Probado por: _________________
Estado: [ ] Aprobado  [ ] Rechazado  [ ] Pendiente

Observaciones:
_______________________________________________
_______________________________________________
_______________________________________________
```

---

## 🚀 Checklist de Despliegue

Antes de desplegar a producción:

- [ ] Todas las pruebas pasaron exitosamente
- [ ] No hay errores en consola
- [ ] Documentación completa y revisada
- [ ] Código revisado por otro desarrollador
- [ ] Assets compilados correctamente (`npm run production`)
- [ ] Backup de base de datos realizado
- [ ] Plan de rollback preparado
- [ ] Usuarios finales notificados del cambio

---

**Versión:** 1.0  
**Fecha:** 2025-12-27  
**Responsable:** _________________  
**Aprobado por:** _________________
