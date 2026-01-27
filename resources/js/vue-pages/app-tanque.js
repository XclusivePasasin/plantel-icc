const { saveValidacionTanque } = require("../service.js");

Vue.component('validacion-tanque', require('../components/InformacionTanqueComponent.vue').default);
Vue.component('search-validacion-tanque', require('../components/SearchTanqueComponent.vue').default);

const appValidacionTanque = new Vue({
    el: "#appValidacionTanque",
    data: {
        helpers: { loading: false, estado: 0 },
        panels: { buscar: true, formulario: false },
        ordenActual: null,
        historial: [],
    },

    methods: {
        async cargarValidacion(orderData) {
            if (!orderData || !orderData.orden?.numero_orden) {
                StatusHandler.ValidationMsg("Orden no válida.");
                return;
            }

            this.helpers.loading = true;
            StatusHandler.LShow();

            try {
                // ✅ Ensamblamos TODOS los campos que necesita el hijo
                const combinedData = {
                    numero_orden: orderData.orden.numero_orden,
                    fecha_hora: orderData.orden.fecha_hora,
                    codigo_producto: orderData.orden.codigo_producto,
                    producto: orderData.orden.producto,
                    unidades_totales: orderData.orden.unidades_totales,
                    tamano_lote: orderData.orden.tamano_lote,
                    presentacion: orderData.orden.presentacion,
                    materiales: orderData.orden.materials,
                    operaria: orderData.orden.operaria || '',
                    supervisor: orderData.orden.supervisor || '',
                    control_calidad: orderData.orden.control_calidad || '',
                    lote: orderData.orden.lote || '',
                    numero_tanque: orderData.orden.numero_tanque || '',
                    estado: orderData.orden.estado ?? 0, // ⬅️ Usar ?? 0 para respetar el estado 0
                    ...(orderData.validacion || {}), // si hay datos locales
                };

                // Historial
                this.historial.unshift({ ...orderData, fechaConsulta: new Date().toISOString() });
                if (this.historial.length > 5) this.historial.pop();

                // Pasamos todo al hijo
                this.ordenActual = {
                    orden: orderData.orden,
                    validacionTanque: combinedData,
                    origen: orderData.origen
                };
                this.helpers.estado = combinedData.estado ?? 0; // ⬅️ Usar ?? 0
                this.panels.buscar = false;
                this.panels.formulario = true;

            } catch (error) {
                console.error("Error al cargar validación:", error);
                StatusHandler.ShowStatus(
                    error.response?.data?.message || "No se pudo cargar la validación",
                    StatusHandler.OPERATION.DEFAULT,
                    StatusHandler.STATUS.FAIL
                );
            } finally {
                this.helpers.loading = false;
                StatusHandler.LClose();
            }
        },

        async guardarValidacion() {
            if (!this.ordenActual?.numero_orden) {
                StatusHandler.ValidationMsg("Orden no cargada.");
                return;
            }

            const datosFormulario = this.$refs.validacionTanque.getData();
            const payload = { ...datosFormulario, numero_orden: this.ordenActual.numero_orden };

            this.helpers.loading = true;
            StatusHandler.LShow();

            try {
                const response = await saveValidacionTanque(payload);
                if ([200, 201].includes(response.status)) {
                    StatusHandler.ShowStatus(
                        "Validación de tanque guardada correctamente.",
                        StatusHandler.OPERATION.SAVE,
                        StatusHandler.STATUS.SUCCESS
                    );
                } else throw new Error("Respuesta inesperada del servidor");

            } catch (error) {
                StatusHandler.ShowStatus(
                    error.response?.data?.message || "Error al guardar la validación",
                    StatusHandler.OPERATION.SAVE,
                    StatusHandler.STATUS.FAIL
                );
            } finally {
                this.helpers.loading = false;
                StatusHandler.LClose();
            }
        },

        volverABuscar() {
            this.ordenActual = null;
            this.panels.buscar = true;
            this.panels.formulario = false;
        },

        cargarDesdeHistorial(orden) {
            this.cargarValidacion(orden);
        }
    }
});