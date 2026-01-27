<template>
  <div class="min-h-[80vh] flex items-center justify-center">
    <div class="bg-white border rounded-xl shadow-md p-6 w-full max-w-4xl">
      <h2 class="text-center font-bold text-lg mb-6">
        Validación de conexión a tanque {{ form.numero_orden || 'N/A' }}
      </h2>

      <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
  <div>
    <label class="text-sm font-medium">Fecha y hora</label>
    <input
      v-model="form.fecha_hora"
      type="datetime-local"
      class="form-control"
      :readonly="!isEditableProduccion && !modoEdicionSupervisor"
    />
  </div>

  <div>
    <label class="text-sm font-medium">Operaria de máquina</label>
    <input
      v-model="form.operaria"
      type="text"
      class="form-control"
      placeholder="Operaria"
      readonly
    />
  </div>

  <div>
    <label class="text-sm font-medium">Supervisor</label>
    <input
      v-model="form.supervisor"
      type="text"
      class="form-control"
      placeholder="Producción"
      readonly
    />
  </div>

  <div>
    <label class="text-sm font-medium">Control de calidad</label>
    <input
      v-model="form.controlCalidad"
      type="text"
      class="form-control"
      placeholder="Calidad"
      readonly
    />
  </div>

  <div>
    <label class="text-sm font-medium">LOTE</label>
    <input
      v-model="form.lote"
      type="text"
      class="form-control"
      :readonly="!isEditableProduccion && !modoEdicionSupervisor"
    />
  </div>

  <div>
    <label class="text-sm font-medium">N° Tanque</label>
    <input
      v-model="form.numeroTanque"
      type="text"
      class="form-control"
      placeholder="Número de tanque"
      :readonly="!isEditableProduccion && !modoEdicionSupervisor"
    />
  </div>
</div>


<div class="mt-6 w-full flex justify-end space-x-3">
  <!-- Botón Guardar para Producción -->
  <button
    v-if="has_cap('cap-produccion') && estado === 0 && !modoEdicionSupervisor"
    @click="guardarComoProduccion"
    class="btn btn-primary px-4"
  >
    <i class="bi bi-save"></i> Guardar
  </button>

  <!-- Botón Modificar para Supervisor (solo si no está en modo edición) -->
  <button
    v-if="has_cap('cap-supprod') && estado === 1 && !modoEdicionSupervisor"
    @click="activarModoEdicion"
    class="btn btn-warning px-4"
  >
    <i class="bi bi-pencil-square"></i> Modificar
  </button>

  <!-- Botones Guardar Cambios y Cancelar (solo en modo edición) -->
  <button
    v-if="has_cap('cap-supprod') && estado === 1 && modoEdicionSupervisor"
    @click="cancelarEdicion"
    class="btn btn-secondary px-4"
  >
    <i class="bi bi-x-circle"></i> Cancelar
  </button>

  <button
    v-if="has_cap('cap-supprod') && estado === 1 && modoEdicionSupervisor"
    @click="guardarCambiosSupervisor"
    class="btn btn-primary px-4"
  >
    <i class="bi bi-save"></i> Guardar Cambios
  </button>

  <!-- Botón Verificar (solo si no está en modo edición) -->
  <button
    v-if="has_cap('cap-supprod') && estado === 1 && !modoEdicionSupervisor"
    @click="verificarOrden"
    class="btn btn-success px-4"
  >
    <i class="bi bi-check2-circle"></i> Verificar
  </button>

  <!-- Botón Autorizar para Control de Calidad -->
  <!-- Botón Autorizar para Control de Calidad -->
  <!-- Visible si tiene permisos y el estado es >= 1. Bloqueado si no es 2 (Verificado) -->
  <button
    v-if="(has_cap('cap-auxcontrol-calidad') || has_cap('cap-jefecontrol-calidad')) && (estado === 1 || estado === 2)"
    @click="autorizarOrden"
    class="btn btn-success px-4"
    :disabled="estado !== 2"
    :title="estado !== 2 ? 'Debe ser verificado por un supervisor primero' : 'Autorizar orden'"
  >
    <i class="bi bi-shield-check"></i> Autorizar
  </button>

  <!-- Estado Finalizado -->
  <button v-if="estado === 3" disabled class="btn btn-secondary px-4">
    Información finalizada
  </button>
</div>


    </div>
  </div>
</template>

<script>
const {
   saveValidacionTanque,
   verificarValidacionTanque,
   autorizarValidacionTanque
} = require("../service.js");
export default {
  name: "ValidacionTanque",
  props: {
    validacionTanque: { type: Object, default: () => ({}) },
    modoLectura: { type: Boolean, default: false },
  },
  // data() {
  //   const v = this.validacionTanque || {};
  //   return {
  //     form: {
  //      fecha_hora:
  //       v.fecha_hora && estado !== 0
  //         ? this.formatFechaHora(v.fecha_hora)
  //         : this.getFechaHoraActualElSalvador(),
  //       operaria: v.operaria || '',
  //       supervisor: v.supervisor || '',
  //       controlCalidad: v.control_calidad || '',
  //       lote: v.lote || '',
  //       numeroTanque: v.numero_tanque || '',
  //       numero_orden: v.numero_orden || '',
  //       codigo_producto: v.codigo_producto || '',
  //       producto: v.producto || '',
  //       unidades_totales: v.unidades_totales || '',
  //       tamano_lote: v.tamano_lote || '',
  //       presentacion: v.presentacion || '',
  //       materiales: v.materiales || [],
  //     },
  //     estado: v.estado || 0,
  //   };
  // },
  // ✅ SOLUCIÓN 1: Corregir data()
  data() {
    const v = this.validacionTanque || {};
    return {
      form: {
        fecha_hora: v.fecha_hora 
          ? new Date(v.fecha_hora).toISOString().slice(0, 16)
          : this.getFechaHoraActualElSalvador(),
        operaria: v.operaria || '',
        supervisor: v.supervisor || '',
        controlCalidad: v.control_calidad || '',
        lote: v.lote || '',
        numeroTanque: v.numero_tanque || '',
        numero_orden: v.numero_orden || '',
        codigo_producto: v.codigo_producto || '',
        producto: v.producto || '',
        unidades_totales: v.unidades_totales || '',
        tamano_lote: v.tamano_lote || '',
        presentacion: v.presentacion || '',
        materiales: v.materiales || [],
      },
      estado: v.estado || 0,
      modoEdicionSupervisor: false, // 🔧 Controla si el supervisor está editando
      valoresOriginales: {}, // 🔧 Guarda los valores originales para restaurar al cancelar
    };
  },
  computed: {
    isEditableProduccion() {
      // Solo editable en estado 0 (sin guardar). Una vez guardado (estado 1), se bloquea
      return this.has_cap('cap-produccion') && this.estado === 0;
    }
  },
  watch: {
    validacionTanque: {
      handler(nuevo) {
        this.setForm(nuevo);
      },
      immediate: true,
      deep: true
    }
  },
  methods: {
    getCurrentUser() {
      if (typeof window.getCurrentUser === "function") {
          return window.getCurrentUser();
      }
      return { nombre: "Usuario desconocido", rol: "invitado" };
    },
    has_cap(e) {
      return window.has_cap == undefined ? false : window.has_cap(e);
    },
    getFechaHoraActualElSalvador() {
      const formatter = new Intl.DateTimeFormat('en-CA', {
        timeZone: 'America/El_Salvador',
        year: 'numeric',
        month: '2-digit',
        day: '2-digit',
        hour: '2-digit',
        minute: '2-digit',
        hour12: false,
      });

      const parts = formatter.formatToParts(new Date());
      const dateParts = Object.fromEntries(parts.map(p => [p.type, p.value]));

      return `${dateParts.year}-${dateParts.month}-${dateParts.day}T${dateParts.hour}:${dateParts.minute}`;
    },
   getData() {
      return {
        numero_orden: this.form.numero_orden,
        fecha_hora: this.form.fecha_hora,
        operaria: this.form.operaria,
        supervisor: this.form.supervisor,
        control_calidad: this.form.controlCalidad,
        lote: this.form.lote,
        numero_tanque: this.form.numeroTanque, // ✅ mapeado correctamente
        codigo_empaque: this.form.codigo_empaque || null,
        estado: this.estado,
      };
    },
    emitirCambioEstado(nuevoEstado) {
      this.estado = nuevoEstado;
      this.$emit("update", this.getData());
    },
    // setForm(data) {
    //   this.form = {
    //    fecha_hora: data.fecha_hora
    //     ? new Date(data.fecha_hora).toISOString().slice(0, 16)
    //     : this.getFechaHoraActualElSalvador(),
    //     operaria: data.operaria || '',
    //     supervisor: data.supervisor || '',
    //     controlCalidad: data.control_calidad || '',
    //     lote: data.lote || '',
    //     numeroTanque: data.numero_tanque || '',
    //     numero_orden: data.numero_orden || '',
    //     codigo_producto: data.codigo_producto || '',
    //     producto: data.producto || '',
    //     unidades_totales: data.unidades_totales || '',
    //     tamano_lote: data.tamano_lote || '',
    //     presentacion: data.presentacion || '',
    //     materiales: data.materiales || [],
    //   };
    //   this.estado = data.estado || 1;
    // },
    // ✅ SOLUCIÓN 2: Actualizar propiedades individualmente para mantener reactividad
    setForm(data) {
      if (!data) {
        // Reset case
        Object.assign(this.form, {
          fecha_hora: this.getFechaHoraActualElSalvador(),
          operaria: '',
          supervisor: '',
          controlCalidad: '',
          lote: '',
          numeroTanque: '',
          numero_orden: '',
          codigo_producto: '',
          producto: '',
          unidades_totales: '',
          tamano_lote: '',
          presentacion: '',
          materiales: [],
        });
        this.estado = 0;
        return;
      }

      // ✅ Actualizar propiedades individualmente para mantener reactividad
      this.form.fecha_hora = data.fecha_hora 
        ? new Date(data.fecha_hora).toISOString().slice(0, 16)
        : this.getFechaHoraActualElSalvador();
      this.form.operaria = data.operaria || '';
      this.form.supervisor = data.supervisor || '';
      this.form.controlCalidad = data.control_calidad || '';
      this.form.lote = data.lote || '';
      this.form.numeroTanque = data.numero_tanque || '';
      this.form.numero_orden = data.numero_orden || '';
      this.form.codigo_producto = data.codigo_producto || '';
      this.form.producto = data.producto || '';
      this.form.unidades_totales = data.unidades_totales || '';
      this.form.tamano_lote = data.tamano_lote || '';
      this.form.presentacion = data.presentacion || '';
      this.form.materiales = data.materiales || [];
      
      this.estado = data.estado || 0;

      // 🔍 Buscar orden de mezcla si lote y tanque están vacíos
      this.$nextTick(() => {
        this.buscarYAutocompletarOrdenMezcla();
      });
    },
    reset() {
      this.setForm({});
    },

    /**
     * 🔍 Busca la orden de mezcla en la tabla granel y auto-completa lote y tanque
     */
    async buscarYAutocompletarOrdenMezcla() {
      // Validar que haya número de orden
      if (!this.form.numero_orden || this.form.numero_orden.trim() === '') {
        return;
      }

      // Solo buscar si los campos están vacíos
      if ((this.form.lote && this.form.lote.trim() !== '') || 
          (this.form.numeroTanque && this.form.numeroTanque.trim() !== '')) {
        console.log('⏭️ Lote o Tanque ya tienen valor, no se busca orden de mezcla');
        return;
      }

      try {
        console.log('🔍 Buscando orden de mezcla para:', this.form.numero_orden);
        const { buscarOrdenMezcla } = require("../service.js");
        const response = await buscarOrdenMezcla(this.form.numero_orden);
        
        if (response.existe) {
          // Auto-completar los campos
          this.form.lote = response.lote || '';
          this.form.numeroTanque = response.tanque || '';
          
          console.log('✅ Datos de mezcla cargados automáticamente:', {
            lote: response.lote,
            tanque: response.tanque,
            orden_mezcla: response.orden_mezcla
          });
        } else {
          console.log('ℹ️ No se encontró orden de mezcla para:', this.form.numero_orden);
        }
      } catch (error) {
        console.error('❌ Error al buscar orden de mezcla:', error);
        // No mostrar error al usuario, solo log
      }
    },

    /**
     * 🔧 Activa el modo de edición para el supervisor
     */
    activarModoEdicion() {
      // Guardar valores originales para poder restaurar al cancelar
      this.valoresOriginales = {
        fecha_hora: this.form.fecha_hora,
        lote: this.form.lote,
        numeroTanque: this.form.numeroTanque
      };
      
      this.modoEdicionSupervisor = true;
      console.log('✏️ Modo edición activado para supervisor');
    },

    /**
     * 💾 Guarda los cambios realizados por el supervisor
     */
    async guardarCambiosSupervisor() {
      const confirmado = await StatusHandler.Confirm(
        "¿Está seguro de guardar los cambios?",
        "Esta acción guardará las modificaciones realizadas."
      );

      if (!confirmado) {
        return;
      }

      const payload = {
        ...this.getData(),
      };

      try {
        StatusHandler.LShow();

        const response = await saveValidacionTanque(payload);

        if (response?.data) {
          this.setForm(response.data);
          this.estado = response.data.estado;
        }

        // Desactivar modo edición
        this.modoEdicionSupervisor = false;
        this.valoresOriginales = {};

        StatusHandler.ShowStatus(
          "Cambios guardados correctamente",
          StatusHandler.OPERATION.UPDATE,
          StatusHandler.STATUS.SUCCESS
        );
      } catch (err) {
        StatusHandler.ShowStatus(
          "Error al guardar los cambios",
          StatusHandler.OPERATION.DEFAULT,
          StatusHandler.STATUS.FAIL
        );
      }
    },

    /**
     * ❌ Cancela la edición y restaura los valores originales
     */
    cancelarEdicion() {
      // Restaurar valores originales
      this.form.fecha_hora = this.valoresOriginales.fecha_hora;
      this.form.lote = this.valoresOriginales.lote;
      this.form.numeroTanque = this.valoresOriginales.numeroTanque;

      // Desactivar modo edición
      this.modoEdicionSupervisor = false;
      this.valoresOriginales = {};

      console.log('🔙 Edición cancelada, valores restaurados');
    },



    // async guardarComoProduccion() {
    //   const usuario = this.getCurrentUser();

    //   const payload = {
    //     ...this.getData(),
    //     operaria: usuario.nombre,
    //     supervisor: '',
    //     control_calidad: '',
    //   };

    //   try {
    //     StatusHandler.LShow();

    //     const response = await saveValidacionTanque(payload); // ⬅️ Obtener respuesta

    //     if (response?.data) {
    //       this.setForm(response.data);        // ⬅️ Actualiza form con backend
    //       this.estado = response.data.estado; // ⬅️ Asegura estado actualizado
    //     }

    //     StatusHandler.ShowStatus(
    //       "Información guardada correctamente",
    //       StatusHandler.OPERATION.CREATE,
    //       StatusHandler.STATUS.SUCCESS
    //     );
    //   } catch (err) {
    //     StatusHandler.ShowStatus(
    //       "Error al guardar correctamente",
    //       StatusHandler.OPERATION.DEFAULT,
    //       StatusHandler.STATUS.FAIL
    //     );
    //   } finally {
    //     // StatusHandler.LClose();
    //   }
    // },
    async guardarComoProduccion() {
      // ✅ PRIMERO: Pedir confirmación
      const confirmado = await StatusHandler.Confirm(
        "¿Está seguro de guardar los cambios?",
        "Esta acción guardará los datos ingresados."
      );

      // ✅ SEGUNDO: Si cancela, no hacer nada
      if (!confirmado) {
        return;
      }

      // ✅ TERCERO: Si acepta, ejecutar la acción
      const usuario = this.getCurrentUser();

      const payload = {
        ...this.getData(),
        operaria: usuario.nombre,
        supervisor: '',
        control_calidad: '',
        estado: 1, // ⬅️ Siempre establecer estado en 1 al guardar
      };

      try {
        StatusHandler.LShow();

        const response = await saveValidacionTanque(payload);

        if (response?.data) {
          this.setForm(response.data);        // ⬅️ Actualiza form con backend
          this.estado = response.data.estado; // ⬅️ Asegura estado actualizado
        }

        StatusHandler.ShowStatus(
          "Información guardada correctamente",
          StatusHandler.OPERATION.CREATE,
          StatusHandler.STATUS.SUCCESS
        );
      } catch (err) {
        StatusHandler.ShowStatus(
          "Error al guardar correctamente",
          StatusHandler.OPERATION.DEFAULT,
          StatusHandler.STATUS.FAIL
        );
      } finally {
        // StatusHandler.LClose(); // ✅ Siempre cerrar
      }
    },
          
    // ✅ SOLUCIÓN : También aplicar a verificarOrden y autorizarOrden
    async verificarOrden() {
      // ✅ PRIMERO: Pedir confirmación
      const confirmado = await StatusHandler.Confirm(
        "¿Está seguro de verificar esta orden?",
        "Esta acción validará la orden seleccionada."
      );

      // ✅ SEGUNDO: Si cancela, no hacer nada
      if (!confirmado) {
        return;
      }

      // ✅ TERCERO: Si acepta, ejecutar la acción
      try {
        StatusHandler.LShow();
        
        const response = await verificarValidacionTanque(this.form.numero_orden);
        
        if (response?.data) {
          this.setForm(response.data);
          this.estado = response.data.estado;
        }
        
        StatusHandler.ShowStatus(
          "Orden verificada correctamente.",
          StatusHandler.OPERATION.CREATE,
          StatusHandler.STATUS.SUCCESS
        );
      } catch (err) {
        StatusHandler.ShowStatus(
          "Error al verificar orden",
          StatusHandler.OPERATION.DEFAULT,
          StatusHandler.STATUS.FAIL
        );
      } finally {
        // StatusHandler.LClose(); // ✅ Siempre cerrar
      }
    },
      // async verificarOrden() {
      //   try {
      //     StatusHandler.LShow();

      //     const response = await verificarValidacionTanque(this.form.numero_orden);

      //     if (response?.data) {
      //       this.setForm(response.data);
      //       this.estado = response.data.estado;
      //     }

      //     StatusHandler.ShowStatus(
      //       "Orden verificada correctamente.",
      //       StatusHandler.OPERATION.CREATE,
      //       StatusHandler.STATUS.SUCCESS
      //     );
      //   } catch (err) {
      //     StatusHandler.ShowStatus(
      //       "Error al verificar orden",
      //       StatusHandler.OPERATION.DEFAULT,
      //       StatusHandler.STATUS.FAIL
      //     );
      //   } finally {
      //     // StatusHandler.LClose(); // ✅ Siempre cerrar
      //   }
      // },

     async autorizarOrden() {
        // ✅ PRIMERO: Pedir confirmación
        const confirmado = await StatusHandler.Confirm(
          "¿Está seguro de autorizar esta orden?",
          "Esta acción autorizará la orden seleccionada."
        );

        // ✅ SEGUNDO: Si cancela, no hacer nada
        if (!confirmado) {
          return;
        }

        // ✅ TERCERO: Si acepta, ejecutar la acción
        try {
          StatusHandler.LShow();
          
          const response = await autorizarValidacionTanque(this.form.numero_orden);

          if (response?.data) {
            this.setForm(response.data);
            this.estado = response.data.estado;
          }

          StatusHandler.ShowStatus(
            "Orden autorizada correctamente",
            StatusHandler.OPERATION.CREATE,
            StatusHandler.STATUS.SUCCESS
          );
        } catch (err) {
          StatusHandler.ShowStatus(
            "Error al autorizar orden",
            StatusHandler.OPERATION.DEFAULT,
            StatusHandler.STATUS.FAIL
          );
        } finally {
          // StatusHandler.LClose(); // ✅ Siempre cerrar
        }
      }



    // async autorizarOrden() {
    //   try {
    //     StatusHandler.LShow();

    //     const payload = {
    //       ...this.getData(),
    //       : 3,
    //     };

    //     await saveValidacionTanque(payload);
    //     await autorizarValidacionTanque(this.form.numero_orden);

    //     this.estado = 3;
    //     this.form.controlCalidad = payload.control_calidad;

    //     this.$forceUpdate(); // 👈 asegura que Vue reaccione

    //     StatusHandler.ShowStatus(
    //       "Orden autorizada correctamente",
    //       StatusHandler.OPERATION.UPDATE,
    //       StatusHandler.STATUS.SUCCESS
    //     );
    //   } catch (err) {
    //     StatusHandler.ShowStatus(
    //       "Error al autorizar orden",
    //       StatusHandler.OPERATION.UPDATE,
    //       StatusHandler.STATUS.FAIL
    //     );
    //   } finally {
    //     StatusHandler.LClose();
    //   }
    // }

    },
};
</script>


<style scoped>
/* .form-control {
  @apply w-full px-3 py-2 border border-gray-300 rounded-md text-sm;
} */
</style>