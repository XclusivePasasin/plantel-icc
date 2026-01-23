<template>
  <div class="px-4 py-5 my-5">
    <div class="col-lg-6 mx-auto text-center text-dark shadow-none p-0 p-md-3">
      <span class="d-block brand-fix3">
        <i class="bi bi-file-earmark-ruled" style="font-size: 2.4rem;"></i>
      </span>
      <h5 class="fw-bold m-0">CARGAR ORDEN</h5>
      <p class="lead mb-4">Ingrese número de orden para realizar la carga</p>

      <div class="input-group mb-2">
        <span class="input-group-text"><i class="bi bi-search"></i></span>
        <input
          @keydown.enter="emitirOrden"
          v-model="search_val"
          type="text"
          class="form-control"
          placeholder="Código de orden . . "
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
                  <strong>#{{ orden.numero_orden }}</strong> — {{ orden.nombre_producto }}
                </span>
                <span class="info-box-number">{{ orden.estado_descripcion }}</span>
              </div>
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { getOrdenesControlProductoPendientes } from '../service.js';

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
        this.ordenesPendientes = await getOrdenesControlProductoPendientes();
        console.log('📦 Órdenes cargadas:', this.ordenesPendientes);
      } catch (error) {
        console.error('Error al cargar órdenes pendientes:', error);
      }
    },
    emitirOrden() {
      const codigo = this.search_val.trim();

      if (!codigo || codigo.length < 2) {
        StatusHandler.ValidationMsg('Debe ingresar un número de orden válido');
        return;
      }

      this.$emit('load-order', { numero_orden: codigo }); // 🔧 Corrección clave
    },
    emitirOrdenDesdeLista(numero_orden) {
      this.search_val = numero_orden;
      this.emitirOrden();
    },
    getColClass() {
      const count = this.ordenesPendientes.length;
      if (count <= 1) return 'col-lg-14';
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
  background-color: #ffc107; /* Amarillo: pendiente */
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
