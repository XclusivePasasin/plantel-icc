const { getControlProductoByNumeroOrden, getResultadoAgua  } = require("../service.js");

Vue.component('control-producto', require('../components/ControlProductoComponent.vue').default);
Vue.component('search-orden', require('../components/SearchControlProductoComponent.vue').default);

const appControlProducto = new Vue({
    el: "#appControlProducto",
    data: {
        helpers: {
            h1: false,
            bandera: false,
            estado: 0,
            loading: false
        },
        panels: {
            p1: true,
            p2: false
        },
        ordenActual: null,
        historialOrdenes: [] 
    },
    methods: {
        async loadProducto(orderData) {
            if (!orderData || !orderData.numero_orden) {
                StatusHandler.ValidationMsg("Datos de orden inválidos");
                return;
            }

            this.helpers.loading = true;
            StatusHandler.LShow();

            try {
                // 🚨 Validación previa: Verificar análisis de agua
                try {
                    const resultadoAgua = await getResultadoAgua();

                    if (!resultadoAgua.data || Object.keys(resultadoAgua.data).length === 0) {
                        throw new Error("No se puede continuar: falta el análisis de agua.");
                    }
                } catch (errorAgua) {
                    const mensajeAgua = errorAgua?.response?.data?.message || "Error desconocido";

                    // Cierra cualquier estado anterior
                    StatusHandler.LClose();

                    // Muestra el mensaje con estado de advertencia
                    StatusHandler.ShowStatus(
                    mensajeAgua,
                    StatusHandler.OPERATION.DEFAULT,
                    StatusHandler.STATUS.FAIL
                    );

                    return;
                }

                // Verificar si ya tenemos datos completos
                if (!orderData.producto) {
                    const response = await getControlProductoByNumeroOrden(orderData.numero_orden);
                    if (response.data.existe) {
                        orderData.producto = response.data.producto;
                        orderData.origen = response.data.origen || 'API';
                    } else {
                        throw new Error("No se encontraron datos para esta orden");
                    }
                }

                this.historialOrdenes.unshift({
                    ...orderData,
                    fechaConsulta: new Date().toISOString()
                });

                if (this.historialOrdenes.length > 5) {
                    this.historialOrdenes.pop();
                }

                this.ordenActual = orderData;
                this.panels.p1 = false;
                this.panels.p2 = true;
                this.helpers.bandera = true;

                StatusHandler.LClose();
                // StatusHandler.ShowStatus(
                //     `Orden cargada desde ${orderData.origen}`,
                //     StatusHandler.OPERATION.DEFAULT,
                //     StatusHandler.STATUS.SUCCESS
                // );

            } catch (error) {
                console.error("Error al cargar producto:", error);

                const mensajeError =
                    error.response && error.response.data && error.response.data.message
                        ? error.response.data.message
                        : error.message || "Error al cargar los datos del producto";

                StatusHandler.LClose();
                StatusHandler.ShowStatus(
                    mensajeError,
                    StatusHandler.OPERATION.DEFAULT,
                    StatusHandler.STATUS.FAIL
                );
            } finally {
                this.helpers.loading = false;
            }
        },

        volverABuscar() {
            this.panels.p1 = true;
            this.panels.p2 = false;
            this.ordenActual = null;
            this.helpers.bandera = false;
        },

        cargarDesdeHistorial(orden) {
            this.loadProducto(orden);
        }
    },
});
