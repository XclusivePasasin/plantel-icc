const { getControlesByOrderCode } = require("../service.js");
import { getAllControlesByOrderCode, getControlById , getJsonModelControles} from '../services/controlesService.js';

Vue.component('controles', require('../components/ControlesComponent.vue').default);
Vue.component('seach-order', require('../components/SearchTurnosOrdenComponent.vue').default);

const controlesLoader = new Vue({
    el: "#controlesLoader",
    data: {
        helpers: {
            h1: false,
            bandera: false,
            estado: 0,
        },
        panels: {
            p1: true, // Panel de búsqueda
        },
        order: [],
        listControles: [], // Asegúrate de que este campo esté en tu plantilla
        turnoSelected: null,
        codeOrdenSelected: null
    },
    methods: {
        loadControles: function(params) {
            const [order_code, turno] = params.split(',');
            if (order_code.length <= 1) {
                StatusHandler.ValidationMsg("Número de Orden Inválido");
                return;
            }

            this.codeOrdenSelected = order_code;
            this.turnoSelected = turno;

            StatusHandler.LShow();
            getAllControlesByOrderCode(order_code, turno).then(result => {
                const response = result.data;
                if (response.code === 0) {
                    StatusHandler.ShowStatus("La orden no se encuentra registrada en el sistema", StatusHandler.OPERATION.DEFAULT, StatusHandler.STATUS.FAIL);
                    return;
                }
                this.listControles.splice(0);
                response.data.forEach((element, index) => {
                    this.listControles.push(element);
                });

                document.getElementById('pnlSecondary').classList.remove('d-none');
                StatusHandler.LClose();
            }).catch(ex => {
                StatusHandler.LClose();
                StatusHandler.Exception("Buscar Controles", ex);
            });
        },

        cargarControl: async function(controlId){

            getControlById(controlId).then(result => {
                let response = result.data;
                if (response.code == 0) {
                    StatusHandler.ShowStatus(response.msg, StatusHandler.OPERATION.DEFAULT, StatusHandler.STATUS.FAIL);
                    return;
                } else {
                    let datos = response.data;
                    //alert(JSON.stringify(datos));
                    //this.helpers.estado = datos[0].analisis.status;
                    this.panels.p1 = false;
                    this.helpers.bandera = true;
                    this.order.push(response.data);
                    //alert(JSON.stringify(response.data));
                }

                StatusHandler.LClose();

            }).catch(ex => {
                StatusHandler.LClose();
                StatusHandler.Exception("Buscar Estandares", ex);
            });
        },

        crearNuevoControl: async function(){
            console.log("Creando nuevo control");

            const confirm = await StatusHandler.Confirm("¿Desea realizar esta acción?");
            if (!confirm) return;

            StatusHandler.LShow();

            getJsonModelControles(this.codeOrdenSelected, this.turnoSelected).then(result => {
                console.log("Cargando el modelo");
                const response = result.data;
                if (response.code == 0) {
                    StatusHandler.ShowStatus(response.msg, StatusHandler.OPERATION.DEFAULT, StatusHandler.STATUS.FAIL);
                    return;
                }

                this.panels.p1 = false;
                this.helpers.bandera = true;
                this.order = [];
                this.order.push(response.data);

                StatusHandler.LClose();
            }).catch(ex => {
                StatusHandler.LClose();
                StatusHandler.Exception("Buscar Controles");
            });
        },

        loadControles2: function(params) {
            order_code = params.split(',')[0];
            turno = params.split(',')[1];
            if (order_code.length <= 1) {
                StatusHandler.ValidationMsg("Numero de Orden Invalido");
                return;
            }
            StatusHandler.LShow();
            getEstandaresByOrderCode(order_code, turno).then(result => {
                let response = result.data;
                if (response.code == 0) {
                    StatusHandler.ShowStatus("La orden no se encuentra registrada en el sistema", StatusHandler.OPERATION.DEFAULT, StatusHandler.STATUS.FAIL);
                    return;
                } else {
                    let datos = response.data;
                    //alert(JSON.stringify(datos));
                    //this.helpers.estado = datos[0].analisis.status;
                    this.panels.p1 = false;
                    this.helpers.bandera = true;

                    this.order.push(response.data);
                    //alert(JSON.stringify(response.data));
                }

                StatusHandler.LClose();

            }).catch(ex => {
                StatusHandler.LClose();
                StatusHandler.Exception("Buscar Controles", ex);
            })
        },
        has_cap(e){
            return window.has_cap == undefined ? false : window.has_cap(e);
        }
    }
});
