<template>
  <div class="min-h-[80vh] flex items-center justify-center">
    <div class="bg-white border rounded-xl shadow-md p-6 w-full max-w-4xl">
      <h4 class="text-xl font-bold text-indigo-700 flex items-center gap-2 mb-6">
        <i class="bi bi-shield-check"></i> Monitoreo de Tanque {{ form.numero_orden || 'N/A' }}
      </h4>

      <!-- SECCIÓN 1: CONEXIÓN INICIAL (Siempre visible) -->
      <div class="mb-8">
        <h3 class="font-bold text-md mb-4 text-gray-600 uppercase tracking-wider border-b pb-2">
          Conexión Inicial
        </h3>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
          <div>
            <label class="text-sm font-medium text-gray-500 text-uppercase">Fecha y hora</label>
            <input
              v-model="form.fecha_hora"
              type="datetime-local"
              class="form-control"
              :readonly="!isEditableProduccion && !modoEdicionSupervisor"
            />
          </div>

          <div>
            <label class="text-sm font-medium text-gray-500 text-uppercase">Operaria de máquina</label>
            <input
              v-model="form.operaria"
              type="text"
              class="form-control"
              placeholder="Operaria"
              readonly
            />
          </div>

          <div>
            <label class="text-sm font-medium text-gray-500 text-uppercase">Supervisor</label>
            <input
              v-model="form.supervisor"
              type="text"
              class="form-control"
              placeholder="Producción"
              readonly
            />
          </div>

          <div>
            <label class="text-sm font-medium text-gray-500 text-uppercase">Control de calidad</label>
            <input
              v-model="form.controlCalidad"
              type="text"
              class="form-control"
              placeholder="Calidad"
              readonly
            />
          </div>

          <div>
            <label class="text-sm font-medium text-gray-500 text-uppercase">LOTE</label>
            <input
              v-model="form.lote"
              type="text"
              class="form-control"
              :readonly="!isEditableProduccion && !modoEdicionSupervisor"
            />
          </div>

          <div>
            <label class="text-sm font-medium text-gray-500 text-uppercase">N° Tanque</label>
            <input
              v-model="form.numeroTanque"
              type="text"
              class="form-control"
              placeholder="Número de tanque"
              :readonly="!isEditableProduccion && !modoEdicionSupervisor"
            />
          </div>
        </div>

        <div class="mt-4 w-full flex justify-end space-x-3">
          <!-- Botón Guardar para Producción -->
          <button
            v-if="has_cap('cap-produccion') && estado === 0 && !modoEdicionSupervisor"
            @click="guardarComoProduccion"
            class="btn btn-primary px-4"
          >
            <i class="bi bi-save"></i> Guardar
          </button>

          <!-- Botón Modificar para Auxiliar de Calidad -->
          <button
            v-if="has_cap('cap-auxcontrol-calidad') && estado === 1 && !modoEdicionSupervisor"
            @click="activarModoEdicion"
            class="btn btn-warning px-4"
          >
            <i class="bi bi-pencil-square"></i> Modificar
          </button>

          <!-- Botones Guardar Cambios y Cancelar -->
          <button
            v-if="has_cap('cap-auxcontrol-calidad') && estado === 1 && modoEdicionSupervisor"
            @click="cancelarEdicion"
            class="btn btn-secondary px-4"
          >
            <i class="bi bi-x-circle"></i> Cancelar
          </button>

          <button
            v-if="has_cap('cap-auxcontrol-calidad') && estado === 1 && modoEdicionSupervisor"
            @click="guardarCambiosSupervisor"
            class="btn btn-primary px-4"
          >
            <i class="bi bi-save"></i> Guardar Cambios
          </button>

          <!-- Botón Verificar -->
          <button
            v-if="(has_cap('cap-jefecontrol-calidad') || has_cap('cap-supproduccion')) && estado === 1 && !modoEdicionSupervisor"
            @click="verificarOrden"
            class="btn btn-success px-4"
          >
            <i class="bi bi-check2-circle"></i> Verificar
          </button>

          <!-- Botón Autorizar -->
          <button
            v-if="(has_cap('cap-auxcontrol-calidad') || has_cap('cap-jefecontrol-calidad')) && (estado === 1 || estado === 2)"
            @click="autorizarOrden"
            class="btn btn-success px-4"
            :disabled="estado !== 2"
            :title="estado !== 2 ? 'Debe ser verificado por Control de Calidad primero' : 'Autorizar orden'"
          >
            <i class="bi bi-shield-check"></i> Autorizar
          </button>

          <!-- Botón de Reconexión -->
          <button v-if="has_cap('cap-produccion') && reconexion_estado == 0 && estado > 0" class="btn btn-warning px-4" @click="activarReconexion">
            <i class="bi bi-arrow-repeat"></i> Nueva Reconexión
          </button>
        </div>
      </div>

<!-- SECCIÓN DE RECONEXIÓN -->
<div v-if="reconexion_estado > 0" class="mt-8 pt-6 border-t">
  <h3 class="text-center font-bold text-md mb-4 text-blue-700">
    <i class="bi bi-arrow-clockwise"></i> Reconexión a tanque
  </h3>
  
  <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
    <div>
      <label class="text-sm font-medium">Fecha y hora (Reconexión)</label>
      <input
        v-model="form.reconexion_fecha_hora"
        type="datetime-local"
        class="form-control"
        :readonly="!isEditableReconexion"
      />
    </div>

    <div>
      <label class="text-sm font-medium">Operaria (Reconexión)</label>
      <input v-model="form.reconexion_operaria" type="text" class="form-control" readonly />
    </div>

    <div>
      <label class="text-sm font-medium">Supervisor (Reconexión)</label>
      <input v-model="form.reconexion_supervisor" type="text" class="form-control" readonly />
    </div>

    <div>
      <label class="text-sm font-medium">Control de calidad (Reconexión)</label>
      <input v-model="form.reconexion_control_calidad" type="text" class="form-control" readonly />
    </div>

    <div>
      <label class="text-sm font-medium">LOTE (Reconexión)</label>
      <input
        v-model="form.reconexion_lote"
        type="text"
        class="form-control"
        :readonly="!isEditableReconexion"
      />
    </div>

    <div>
      <label class="text-sm font-medium">N° Tanque (Reconexión)</label>
      <input
        v-model="form.reconexion_numero_tanque"
        type="text"
        class="form-control"
        :readonly="!isEditableReconexion"
      />
    </div>
  </div>

  <div class="mt-6 w-full flex justify-end space-x-3">
    <!-- Botón Guardar para Producción (Reconexión) -->
    <button
      v-if="has_cap('cap-produccion') && reconexion_estado === 1"
      @click="guardarReconexion"
      class="btn btn-primary px-4"
    >
      <i class="bi bi-save"></i> Guardar Reconexión
    </button>

    <!-- Botón Modificar para Auxiliar de Calidad (Reconexión) -->
    <button
      v-if="has_cap('cap-auxcontrol-calidad') && reconexion_estado === 1 && !modoEdicionReconexion"
      @click="activarEdicionReconexion"
      class="btn btn-warning px-4"
    >
      <i class="bi bi-pencil-square"></i> Modificar Reconexión
    </button>

    <!-- Botones Guardar Cambios y Cancelar (Reconexión) -->
    <button
      v-if="has_cap('cap-auxcontrol-calidad') && reconexion_estado === 1 && modoEdicionReconexion"
      @click="cancelarEdicionReconexion"
      class="btn btn-secondary px-4"
    >
      <i class="bi bi-x-circle"></i> Cancelar
    </button>

    <button
      v-if="has_cap('cap-auxcontrol-calidad') && reconexion_estado === 1 && modoEdicionReconexion"
      @click="guardarCambiosReconexion"
      class="btn btn-primary px-4"
    >
      <i class="bi bi-save"></i> Guardar Cambios Reconexión
    </button>

    <!-- Botón Verificar para Supervisor de Producción o Jefe de Control de Calidad (Reconexión) -->
    <button
      v-if="(has_cap('cap-supproduccion')) && reconexion_estado === 1 && !modoEdicionReconexion"
      @click="verificarReconexion"
      class="btn btn-success px-4"
    >
      <i class="bi bi-check2-circle"></i> Verificar Reconexión
    </button>

    <!-- Botón Autorizar para Auxiliar y Jefe de Control de Calidad (Reconexión) -->
    <button
      v-if="(has_cap('cap-auxcontrol-calidad') || has_cap('cap-jefecontrol-calidad')) && reconexion_estado === 2"
      @click="autorizarReconexion"
      class="btn btn-success px-4"
    >
      <i class="bi bi-shield-check"></i> Autorizar Reconexión
    </button>

    <!-- ✅ Indicador de Finalización -->
    <button
      v-if="reconexion_estado === 3"
      class="btn btn-secondary px-4"
      disabled
    >
      <i class="bi bi-check-all"></i> Finalizada orden de reconexión
    </button>
  </div>
</div>


    </div>
  </div>
</template>

<script>
const {
   saveValidacionTanque,
   verificarValidacionTanque,
   autorizarValidacionTanque,
   verificarReconexionTanque,
   autorizarReconexionTanque,
   buscarOrdenMezcla
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
        // Reconexión
        reconexion_fecha_hora: v.reconexion_fecha_hora 
          ? new Date(v.reconexion_fecha_hora).toISOString().slice(0, 16)
          : '',
        reconexion_operaria: v.reconexion_operaria || '',
        reconexion_supervisor: v.reconexion_supervisor || '',
        reconexion_control_calidad: v.reconexion_control_calidad || '',
        reconexion_lote: v.reconexion_lote || '',
        reconexion_numero_tanque: v.reconexion_numero_tanque || '',
      },
      estado: v.estado || 0,
      reconexion_estado: v.reconexion_estado || 0,
      modoEdicionSupervisor: false, // 🔧 Controla si Carolina/Auxiliar está editando
      modoEdicionReconexion: false, // 🔧 Controla si Carolina/Auxiliar está editando reconexión
      valoresOriginales: {}, // 🔧 Guarda los valores originales para restaurar al cancelar
      valoresOriginalesReconexion: {}, // 🔧 Guarda valores para reconexión
    };
  },
  computed: {
    isEditableProduccion() {
      // Solo editable en estado 0 (sin guardar). Una vez guardado (estado 1), se bloquea
      return this.has_cap('cap-produccion') && this.estado === 0;
    },
    /**
     * 🛡️ Controla si los campos de RECONEXIÓN son editables
     */
    isEditableReconexion() {
      // 1. Si está en modo edición explícito (por el botón Modificar de Calidad)
      if (this.modoEdicionReconexion) return true;
      
      // 2. Si es Producción y apenas está iniciando la reconexión (estado 1)
      if (this.has_cap('cap-produccion') && this.reconexion_estado === 1) return true;

      return false;
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
      if (window.AppVars && window.AppVars.current_user) {
        return {
          nombre: window.AppVars.current_user.user_fullname || "Usuario",
          rol: "usuario"
        };
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
        // Reconexión
        reconexion_fecha_hora: this.form.reconexion_fecha_hora,
        reconexion_lote: this.form.reconexion_lote,
        reconexion_numero_tanque: this.form.reconexion_numero_tanque,
        reconexion_operaria: this.form.reconexion_operaria,
        reconexion_estado: this.reconexion_estado,
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
          reconexion_fecha_hora: '',
          reconexion_operaria: '',
          reconexion_supervisor: '',
          reconexion_control_calidad: '',
          reconexion_lote: '',
          reconexion_numero_tanque: '',
        });
        this.estado = 0;
        this.reconexion_estado = 0;
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
      
      // Reconexión
      this.form.reconexion_fecha_hora = data.reconexion_fecha_hora 
        ? new Date(data.reconexion_fecha_hora).toISOString().slice(0, 16)
        : '';
      this.form.reconexion_operaria = data.reconexion_operaria || '';
      this.form.reconexion_supervisor = data.reconexion_supervisor || '';
      this.form.reconexion_control_calidad = data.reconexion_control_calidad || '';
      this.form.reconexion_lote = data.reconexion_lote || '';
      this.form.reconexion_numero_tanque = data.reconexion_numero_tanque || '';

      this.estado = data.estado || 0;
      this.reconexion_estado = (data.reconexion_estado != undefined) ? Number(data.reconexion_estado) : 0;
      
      console.log('📦 Reconexión Estado Detectado:', this.reconexion_estado);

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
      },

      /**
       * 🔄 Activa la sección de reconexión
       */
      async activarReconexion() {
        this.reconexion_estado = 1;
        this.form.reconexion_fecha_hora = this.getFechaHoraActualElSalvador();
        this.form.reconexion_operaria = this.getCurrentUser().nombre;

        try {
          console.log('🔍 Extrayendo datos originales para reconexión...');
          const response = await buscarOrdenMezcla(this.form.numero_orden);

          if (response.existe) {
            this.form.reconexion_lote = response.lote || this.form.lote;
            this.form.reconexion_numero_tanque = response.tanque || this.form.numeroTanque;
          } else {
            this.form.reconexion_lote = this.form.lote;
            this.form.reconexion_numero_tanque = this.form.numeroTanque;
          }
        } catch (error) {
          console.error('❌ Error al extraer datos para reconexión:', error);
          this.form.reconexion_lote = this.form.lote;
          this.form.reconexion_numero_tanque = this.form.numeroTanque;
        }

        console.log('🔄 Reconexión activada');
      },

      /**
       * 💾 Guarda los datos de reconexión
       */
      async guardarReconexion() {
        const confirmado = await StatusHandler.Confirm(
          "¿Está seguro de guardar la reconexión?",
          "Esta acción registrará los datos de reconexión."
        );

        if (!confirmado) return;

        try {
          StatusHandler.LShow();
          const response = await saveValidacionTanque(this.getData());
          if (response?.data) {
            this.setForm(response.data);
          }
          StatusHandler.ShowStatus(
            "Reconexión guardada correctamente.",
            StatusHandler.OPERATION.CREATE,
            StatusHandler.STATUS.SUCCESS
          );
        } catch (err) {
          StatusHandler.ShowStatus("Error al guardar reconexión", StatusHandler.OPERATION.DEFAULT, StatusHandler.STATUS.FAIL);
        }
      },

      /**
       * ✅ Verifica la reconexión
       */
      async verificarReconexion() {
        const confirmado = await StatusHandler.Confirm(
          "¿Está seguro de verificar la reconexión?",
          "Esta acción validará la reconexión."
        );

        if (!confirmado) return;

        try {
          StatusHandler.LShow();
          const response = await verificarReconexionTanque(this.form.numero_orden);
          if (response?.data) {
            this.setForm(response.data);
          }
          StatusHandler.ShowStatus("Reconexión verificada correctamente.", StatusHandler.OPERATION.CREATE, StatusHandler.STATUS.SUCCESS);
        } catch (err) {
          StatusHandler.ShowStatus("Error al verificar reconexión", StatusHandler.OPERATION.DEFAULT, StatusHandler.STATUS.FAIL);
        }
      },

      /**
       * 🛡️ Autoriza la reconexión
       */
      async autorizarReconexion() {
        const confirmado = await StatusHandler.Confirm(
          "¿Está seguro de autorizar la reconexión?",
          "Esta acción autorizará la reconexión final."
        );

        if (!confirmado) return;

        try {
          StatusHandler.LShow();
          const response = await autorizarReconexionTanque(this.form.numero_orden);
          if (response?.data) {
            this.setForm(response.data);
          }
          StatusHandler.ShowStatus("Reconexión autorizada correctamente.", StatusHandler.OPERATION.CREATE, StatusHandler.STATUS.SUCCESS);
        } catch (err) {
          StatusHandler.ShowStatus("Error al autorizar reconexión", StatusHandler.OPERATION.DEFAULT, StatusHandler.STATUS.FAIL);
        }
      },

      /**
       * 🔧 Activa modo edición para Reconexión
       */
      activarEdicionReconexion() {
        this.modoEdicionReconexion = true;
        this.valoresOriginalesReconexion = {
          fecha_hora: this.form.reconexion_fecha_hora,
          lote: this.form.reconexion_lote,
          numero_tanque: this.form.reconexion_numero_tanque
        };
      },

      /**
       * ❌ Cancela edición para Reconexión
       */
      cancelarEdicionReconexion() {
        this.modoEdicionReconexion = false;
        this.form.reconexion_fecha_hora = this.valoresOriginalesReconexion.fecha_hora;
        this.form.reconexion_lote = this.valoresOriginalesReconexion.lote;
        this.form.reconexion_numero_tanque = this.valoresOriginalesReconexion.numero_tanque;
      },

      /**
       * 💾 Guarda cambios de edición para Reconexión
       */
      async guardarCambiosReconexion() {
        const confirmado = await StatusHandler.Confirm("¿Desea guardar los cambios en la reconexión?");
        if (!confirmado) return;

        try {
          StatusHandler.LShow();
          const response = await saveValidacionTanque(this.getData());
          if (response?.data) {
            this.setForm(response.data);
            this.modoEdicionReconexion = false;
          }
          StatusHandler.ShowStatus("Cambios guardados correctamente", StatusHandler.OPERATION.UPDATE, StatusHandler.STATUS.SUCCESS);
        } catch (err) {
          StatusHandler.ShowStatus("Error al guardar cambios", StatusHandler.OPERATION.DEFAULT, StatusHandler.STATUS.FAIL);
        }
      }

    },
};
</script>


<style scoped>
/* .form-control {
  @apply w-full px-3 py-2 border border-gray-300 rounded-md text-sm;
} */
</style>