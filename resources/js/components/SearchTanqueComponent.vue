<template>
  <div class="px-4 py-5 my-5">
    <div class="col-lg-6 mx-auto text-center text-dark shadow-none p-0 p-md-3">
      <span class="d-block brand-fix3">
        <i class="bi bi-funnel-fill" style="font-size: 2.4rem;"></i>
      </span>
      <h5 class="fw-bold m-0">CARGAR VALIDACIÓN DE TANQUE</h5>
      <p class="lead mb-4">Ingrese número de orden o código de empaque</p>

      <div class="input-group mb-2">
        <span class="input-group-text"><i class="bi bi-search"></i></span>
        <input
          @keydown.enter="emitirOrden"
          v-model="search_val"
          type="text"
          class="form-control"
          placeholder="Número de orden o código de empaque..."
        />
      </div>

      <div class="d-grid gap-2 d-sm-flex justify-content-sm-center mb-4 mt-3">
        <button @click="emitirOrden" type="button" class="btnfix1" :disabled="loading">
          <template v-if="loading">
            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
            Cargando...
          </template>
          <template v-else>
            <i class="bi bi-upload"></i> Cargar
          </template>
        </button>
      </div>

      <!-- 🧾 Cards de órdenes -->
      <div v-if="ordenesPendientes.length" class="mt-4 text-start">
        <h6 class="fw-bold">Órdenes pendientes</h6>
        <div class="row">
          <div
            v-for="orden in ordenesPendientes"
            :key="orden.numero_orden"
            :class="getColClass"
            class="mx-auto mb-3 text-center"
          >
            <a href="#" @click.prevent="emitirOrdenDesdeLista(orden.numero_orden)" class="info-box">
              <div class="info-box-icon pendiente-aprobacion-pesaje">
                <i class="bi bi-file-text-fill"></i>
              </div>
              <div class="info-box-content">
                <span class="info-box-text">
                  <strong>#{{ orden.numero_orden }}</strong>
                </span>
                <span class="info-box-number">
                  Estado: {{ getEstadoDescripcion(orden.estado) }}
                </span>
              </div>
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { getOrdenesValidacionTanquePendientes, buscarOrdenValidacionTanque } from '../service.js';

export default {
  emits: ['load-order'],
  data() {
    return {
      search_val: '',
      loading: false,
      ordenesPendientes: []
    };
  },
  mounted() {
    this.cargarOrdenesPendientes();
  },
  methods: {
    async cargarOrdenesPendientes() {
      try {
        const data = await getOrdenesValidacionTanquePendientes();
        console.log('📦 Órdenes cargadas:', data);
        this.ordenesPendientes = Array.isArray(data) ? data : [];
      } catch (error) {
        console.error('Error al cargar órdenes de tanque:', error);
      }
    },
   // En el método emitirOrden, mapear correctamente los datos
    async emitirOrden() {
      const codigo = this.search_val.trim();
      if (!codigo || codigo.length < 2) {
        StatusHandler.ValidationMsg('Debe ingresar un número de orden válido');
        return;
      }

      this.loading = true;
      StatusHandler.LShow();

      try {
        const response = await buscarOrdenValidacionTanque(codigo);

        if (response.data?.existe) {
          let ordenFormateada;

          if (response.data.origen === 'SAP') {
            // 🆕 Orden nueva de SAP - siempre estado 0 para permitir edición inicial
            ordenFormateada = {
              numero_orden: response.data.orden.num,
              codigo_producto: response.data.orden.code_product,
              producto: response.data.orden.product,
              unidades_totales: response.data.orden.total_units,
              tamano_lote: response.data.orden.lot_size,
              presentacion: response.data.orden.presentacion,
              materiales: response.data.orden.materials,
              operaria: response.data.orden.operaria || '',
              supervisor: response.data.orden.supervisor || '',
              control_calidad: response.data.orden.control_calidad || '',
              lote: response.data.orden.lote || '',
              numero_tanque: response.data.orden.numero_tanque || '',
              estado: 0 // ⬅️ Siempre 0 para órdenes nuevas de SAP
            };
          } else {
            // 💾 Orden existente en BD - respetar el estado guardado
            const v = response.data.orden;
            ordenFormateada = {
              numero_orden: v.numero_orden,
              fecha_hora: v.fecha_hora,
              operaria: v.operaria || '',
              supervisor: v.supervisor || '',
              control_calidad: v.control_calidad || '',
              lote: v.lote || '',
              numero_tanque: v.numero_tanque || '',
              estado: v.estado ?? 1, // ⬅️ Respetar estado guardado (por defecto 1 si no existe)
              codigo_empaque: v.codigo_empaque || ''
            };
          }

          this.$emit('load-order', {
            orden: ordenFormateada,
            origen: response.data.origen
          });
          this.loading = false;
          StatusHandler.LClose();
        } else {
          await StatusHandler.Alert({
            title: 'Orden no encontrada',
            message: 'La orden ingresada no existe en el sistema.',
            confirmText: 'OK'
          });
        }
         this.loading = false;
      } catch (error) {
        console.error("Error al buscar la orden:", error);
        StatusHandler.ShowStatus(
          "Error al consultar la orden",
          StatusHandler.OPERATION.DEFAULT,
          StatusHandler.STATUS.FAIL
        );
        this.loading = false;
      } 
    },
    emitirOrdenDesdeLista(numero_orden) {
      const orden = this.ordenesPendientes.find(o => o.numero_orden === numero_orden);
      if (!orden) {
        StatusHandler.ValidationMsg("Orden no encontrada.");
        return;
      }
      this.$emit('load-order', {
        orden: orden
      });
    },
    getEstadoDescripcion(estado) {
      switch (estado) {
        case 0: return 'Sin iniciar';
        case 1: return 'Pendiente';
        case 2: return 'Verificado';
        case 3: return 'Autorizado';
        default: return 'Desconocido';
      }
    },
    getColClass() {
      const count = this.ordenesPendientes.length;
      if (count <= 1) return 'col-lg-12';
      if (count === 2) return 'col-lg-6';
      return 'col-lg-4';
    }
  }
};
</script>

<style scoped>
.btnfix1 {
  background-color: #343a40;
  color: white;
  border: none;
  padding: 8px 20px;
  border-radius: 50px;
  font-weight: 500;
  transition: all 0.3s;
}
.btnfix1:hover {
  background-color: #23272b;
  transform: translateY(-1px);
}
.btnfix1:disabled {
  opacity: 0.7;
  cursor: not-allowed;
}
.info-box {
  display: flex;
  align-items: center;
  background: #fff;
  padding: 12px;
  border-radius: 8px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
  transition: 0.3s;
  text-decoration: none;
  color: inherit;
}
.info-box:hover {
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
}
.info-box-icon {
  width: 65px;
  height: 50px;
  display: flex;
  align-items: center;
  justify-content: center;
  border-radius: 6px;
  margin-right: 15px;
  font-size: 24px;
  color: white;
  background-color: #ffc107;
}
.info-box-content {
  flex-grow: 1;
}
.info-box-text {
  font-size: 14px;
  color: #666;
}
.info-box-number {
  font-size: 16px;
  font-weight: bold;
}
</style>
