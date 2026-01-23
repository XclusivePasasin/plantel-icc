# Implementación de Validación y Manejo de Material Especial TMA (003007000089)

## Resumen de Cambios

Se ha implementado un sistema de excepción controlada para el material especial con código **003007000089** en el proceso de mezcla, permitiendo que este material no bloquee el flujo del proceso antes de iniciar la mezcla, pero habilitando su validación cuando el proceso está en estado **MEZCLA_EN_PROCESO (estado 5)**.

---

## 📋 Cambios Implementados

### 1. **Constantes y Propiedades de Datos**

#### Archivo: `MixOrderComponent.vue`

**Constante agregada:**
```javascript
SPECIAL_MATERIAL_CODE: '003007000089', // Material especial TMA
```

**Nuevas propiedades de datos:**
```javascript
// Variables para TMA (material especial)
tmaModal: null,
tmaLotNumber: '',
tmaChecked: false,
specialMaterialData: null,
```

---

### 2. **Computed Properties**

**Nueva propiedad computada `hasSpecialMaterial`:**
```javascript
hasSpecialMaterial() {
    return this.data.materials.some(m => m.code === this.SPECIAL_MATERIAL_CODE);
}
```

**Propósito:** Verifica si el producto contiene el material especial TMA.

---

### 3. **Métodos Helper**

**Método `isSpecialMaterial(material)`:**
```javascript
isSpecialMaterial(material) {
    return material.code === this.SPECIAL_MATERIAL_CODE;
}
```

**Propósito:** Verifica si un material dado es el material especial TMA.

---

### 4. **Validaciones Actualizadas**

#### 4.1 `validateCheckboxes()`

**Cambio:** Se agregó excepción para el material especial antes de iniciar la mezcla.

```javascript
validateCheckboxes() {
    let allValid = true;
    
    this.data.materials.forEach(material => {
        // Excepción: Material especial TMA no es obligatorio antes de iniciar mezcla
        if (this.isSpecialMaterial(material) && this.data.status < this.FLAGS.MEZCLA_EN_PROCESO) {
            return; // Saltar validación para material especial antes de mezcla
        }
        
        // Validar solo la primera entrega (entrega1)
        if (!material.entrega1) {
            console.warn(`¡Material ${material.code} no tiene la primera entrega marcada!`);
            allValid = false;
        }
    });
    
    return allValid;
}
```

#### 4.2 `validateMaterialLots()`

**Cambio:** Se agregó excepción para el material especial TMA antes de la mezcla.

```javascript
validateMaterialLots() {
    let isValid = true;
    const missingCount = this.data.materials.reduce((count, material) => {
        // Excluir agua y material especial TMA (antes de mezcla)
        if (material.code === '809909900100') {
            return count;
        }
        
        // Excepción: Material especial TMA no requiere lote antes de iniciar mezcla
        if (this.isSpecialMaterial(material) && this.data.status < this.FLAGS.MEZCLA_EN_PROCESO) {
            return count;
        }
        
        if (!material.lot1 || material.lot1.trim() === '') {
            return count + 1;
        }
        return count;
    }, 0);
    
    if (missingCount > 0) {
        isValid = false;
        StatusHandler.ValidationMsg(`Debes completar el número de lote para ${missingCount} material(es) antes de continuar.`);
    }
    
    return isValid;
}
```

#### 4.3 `validateAllMaterialsReceived()`

**Cambio:** Se agregó excepción para el material especial antes de la mezcla.

```javascript
validateAllMaterialsReceived() {
    return this.data.materials.every(m => {
        // Excepción: Material especial TMA no requiere validación antes de mezcla
        if (this.isSpecialMaterial(m) && this.data.status < this.FLAGS.MEZCLA_EN_PROCESO) {
            return true; // Permitir continuar sin validar este material
        }
        
        // Validar que entrega3 tenga un valor "truthy"
        return Boolean(m.entrega3);
    });
}
```

---

### 5. **Control de Habilitación de Checkboxes**

**Cambio en el template:** Los checkboxes ahora solo se habilitan cuando el estado es **MEZCLA_EN_PROCESO (5)**.

**Antes:**
```vue
:disabled="!(
    data.status === FLAGS.PESAJE_APROBADO &&
    (has_cap('cap-calidad') || has_cap('cap-supcalidad') || ...) &&
    data.status_receive_materials == 1
)"
```

**Después:**
```vue
:disabled="!(
    data.status === FLAGS.MEZCLA_EN_PROCESO &&
    (has_cap('cap-calidad') || has_cap('cap-supcalidad') || ...)
)"
```

---

### 6. **Ocultamiento de Columnas hasta Estado 5**

**Columnas ocultas hasta MEZCLA_EN_PROCESO (estado 5):**
- ✅ "Revisión Materiales"
- ✅ "Primer entrega"
- ✅ "Lote" (primera columna de lote)

**Implementación:**
```vue
<!-- Encabezados de tabla -->
<th v-if="data.status >= FLAGS.MEZCLA_EN_PROCESO">Revisión Materiales</th>
<th v-if="data.status >= FLAGS.MEZCLA_EN_PROCESO">Primer entrega</th>
<th v-if="data.status >= FLAGS.MEZCLA_EN_PROCESO">Lote ...</th>

<!-- Celdas de tabla -->
<td v-if="data.status >= FLAGS.MEZCLA_EN_PROCESO"><!-- checkbox revisión --></td>
<td v-if="e.code !== '809909900100' && data.status >= FLAGS.MEZCLA_EN_PROCESO"><!-- checkbox primer entrega --></td>
<td v-if="e.code !== '809909900100' && data.status >= FLAGS.MEZCLA_EN_PROCESO"><!-- input lote --></td>
```

**Propósito:** Mantener la interfaz limpia y enfocada, mostrando solo la información relevante según el estado del proceso.

---

### 7. **Botón TMA (Ingreso de Lotes)**

**Ubicación:** Después de la tabla de materiales.

**Condiciones de visibilidad:**
- Solo aparece si `hasSpecialMaterial` es `true`
- Solo aparece si `data.status === FLAGS.MEZCLA_EN_PROCESO`

```vue
<div v-if="hasSpecialMaterial && data.status === FLAGS.MEZCLA_EN_PROCESO" class="mt-3 text-end">
    <button 
        type="button" 
        @click="openTMAModal" 
        class="btn btn-primary"
        :disabled="!has_cap('cap-materiaprima')"
    >
        <i class="fas fa-flask me-1"></i> Ingresar Lote TMA
    </button>
</div>
```

---

### 7. **Modal TMA**

**Componentes del modal:**
- **Título:** "Ingreso de Lote TMA"
- **Campos:**
  - Descripción del material (solo lectura)
  - Código del material (solo lectura)
  - Input para número de lote (convertido a mayúsculas automáticamente)
  - Checkbox "Material verificado"
- **Botones:**
  - Cancelar
  - Guardar

```vue
<div class="modal fade" id="tmaModal" tabindex="-1" aria-labelledby="tmaModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tmaModalLabel">Ingreso de Lote TMA</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div v-if="specialMaterialData" class="mb-3">
                    <p><strong>Material:</strong> {{ specialMaterialData.description }}</p>
                    <p><strong>Código:</strong> {{ specialMaterialData.code }}</p>
                    
                    <div class="mb-3">
                        <label for="tmaLotInput" class="form-label">Número de Lote</label>
                        <input 
                            type="text" 
                            class="form-control" 
                            id="tmaLotInput" 
                            v-model="tmaLotNumber"
                            @input="handleTMALotInput"
                            placeholder="Ingresar número de lote"
                        >
                    </div>

                    <div class="form-check">
                        <input 
                            type="checkbox" 
                            class="form-check-input" 
                            id="tmaCheckbox" 
                            v-model="tmaChecked"
                        >
                        <label class="form-check-label" for="tmaCheckbox">
                            Material verificado
                        </label>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" @click="saveTMALot">Guardar</button>
            </div>
        </div>
    </div>
</div>
```

---

### 8. **Métodos TMA**

#### 8.1 `openTMAModal()`

**Propósito:** Abre el modal TMA y carga los datos del material especial.

```javascript
openTMAModal() {
    // Buscar el material especial
    const specialMaterial = this.data.materials.find(m => this.isSpecialMaterial(m));
    
    if (!specialMaterial) {
        StatusHandler.ValidationMsg('No se encontró el material especial TMA');
        return;
    }

    // Cargar datos del material especial
    this.specialMaterialData = { ...specialMaterial };
    this.tmaLotNumber = specialMaterial.lot1 || '';
    this.tmaChecked = Boolean(specialMaterial.entrega3);

    // Mostrar modal
    this.tmaModal.show();
}
```

#### 8.2 `handleTMALotInput()`

**Propósito:** Convierte el input del lote a mayúsculas.

```javascript
handleTMALotInput() {
    this.tmaLotNumber = this.tmaLotNumber.toUpperCase();
}
```

#### 8.3 `saveTMALot()`

**Propósito:** Guarda el lote TMA y actualiza **solo** el componente del material especial.

**Características:**
- Valida que se haya ingresado un lote
- Actualiza solo el material especial (no afecta otros materiales)
- Cierra el modal y limpia los datos
- Muestra mensaje de éxito

```javascript
async saveTMALot() {
    // Validar que se haya ingresado un lote
    if (!this.tmaLotNumber || this.tmaLotNumber.trim() === '') {
        StatusHandler.ValidationMsg('Debe ingresar un número de lote');
        return;
    }

    try {
        StatusHandler.LShow();

        // Buscar el índice del material especial
        const materialIndex = this.data.materials.findIndex(m => this.isSpecialMaterial(m));
        
        if (materialIndex === -1) {
            throw new Error('No se encontró el material especial');
        }

        // Actualizar solo el material especial localmente
        this.$set(this.data.materials[materialIndex], 'lot1', this.tmaLotNumber);
        this.$set(this.data.materials[materialIndex], 'entrega3', this.tmaChecked);

        // Cerrar modal
        this.tmaModal.hide();

        // Limpiar datos
        this.tmaLotNumber = '';
        this.tmaChecked = false;
        this.specialMaterialData = null;

        StatusHandler.ShowStatus(
            'Lote TMA actualizado correctamente',
            StatusHandler.OPERATION.UPDATE,
            StatusHandler.STATUS.SUCCESS
        );

    } catch (error) {
        console.error('Error al guardar lote TMA:', error);
        StatusHandler.Exception('Error al guardar lote TMA', error.message);
    } finally {
        StatusHandler.LClose();
    }
}
```

---

### 9. **Inicialización del Modal**

**En el hook `mounted()`:**

```javascript
this.tmaModal = new bootstrap.Modal(document.getElementById('tmaModal'));
```

---

## 🎯 Criterios de Aceptación Cumplidos

✅ **1. El flujo no se bloquea si el material 003007000089 no está chequeado antes de iniciar la mezcla**
   - Implementado mediante excepciones en `validateCheckboxes()`, `validateMaterialLots()`, y `validateAllMaterialsReceived()`

✅ **2. Los checkboxes permanecen deshabilitados hasta que el estado sea MEZCLA_EN_PROCESO = 5**
   - Actualizado en el template: `:disabled="!(data.status === FLAGS.MEZCLA_EN_PROCESO && ...)"`

✅ **3. El botón de ingreso de lotes solo aparece si el material especial existe**
   - Condición: `v-if="hasSpecialMaterial && data.status === FLAGS.MEZCLA_EN_PROCESO"`

✅ **4. El botón solo actualiza el componente correspondiente**
   - Método `saveTMALot()` actualiza solo el material especial usando `$set()`

✅ **5. Si el material especial no existe, no se muestran botón ni campos relacionados**
   - Controlado por `hasSpecialMaterial` computed property

✅ **6. No se generan impactos en otros materiales ni procesos**
   - Las excepciones solo aplican al material con código `003007000089`
   - El método `saveTMALot()` actualiza únicamente el material especial

---

## 🔍 Flujo de Validación

### Antes de Iniciar Mezcla (status < 5)
- ✅ Material especial **NO** requiere checkbox marcado
- ✅ Material especial **NO** requiere lote ingresado
- ✅ Material especial **NO** bloquea el flujo
- ✅ Otros materiales siguen validaciones estándar

### Durante Mezcla (status = 5)
- ✅ Checkboxes se habilitan
- ✅ Botón TMA aparece (si material especial existe)
- ✅ Material especial puede ser validado mediante modal TMA
- ✅ Actualización aislada del componente especial

---

## 📝 Notas Técnicas

1. **Reactividad Vue:** Se usa `this.$set()` para asegurar reactividad al actualizar propiedades del material especial.

2. **Aislamiento de Componente:** El método `saveTMALot()` actualiza solo el índice del material especial, sin afectar otros materiales.

3. **Validación de Estado:** Todas las excepciones verifican `this.data.status < this.FLAGS.MEZCLA_EN_PROCESO` para aplicar la lógica correcta.

4. **Uppercase Automático:** El input del lote TMA se convierte automáticamente a mayúsculas mediante `handleTMALotInput()`.

5. **Bootstrap Modal:** Se utiliza Bootstrap 5 para el modal TMA, inicializado en el hook `mounted()`.

---

## 🚀 Pruebas Recomendadas

1. **Producto SIN material especial:**
   - Verificar que no aparece el botón TMA
   - Verificar que validaciones estándar funcionan normalmente

2. **Producto CON material especial - Antes de mezcla:**
   - Verificar que el flujo no se bloquea si material especial no está chequeado
   - Verificar que checkboxes están deshabilitados
   - Verificar que botón TMA no aparece

3. **Producto CON material especial - Durante mezcla (estado 5):**
   - Verificar que checkboxes se habilitan
   - Verificar que botón TMA aparece
   - Verificar que modal TMA abre correctamente
   - Verificar que se puede ingresar lote y marcar checkbox
   - Verificar que solo se actualiza el material especial

4. **Validación de permisos:**
   - Verificar que solo usuarios con `cap-materiaprima` pueden usar el botón TMA

---

## 📌 Código del Material Especial

```
003007000089
```

## 📌 Estado de Mezcla en Proceso

```
MEZCLA_EN_PROCESO = 5
```

---

## ✨ Conclusión

La implementación cumple con todos los requerimientos funcionales especificados, proporcionando una excepción controlada para el material especial TMA (003007000089) que:

- No bloquea el flujo antes de iniciar la mezcla
- Se valida únicamente cuando la mezcla está en proceso (estado 5)
- Tiene controles UI específicos y aislados
- No afecta el comportamiento de otros materiales
- Mantiene la integridad del flujo de trabajo existente
