const { getEstandaresByOrderCode } = require("../service.js");
import { getAllEstandaresByOrderCode, getEstandarById , getJsonModelEstandares} from '../services/estandaresService';

Vue.component('estandares', require('../components/EstandaresComponent.vue').default);
Vue.component('seach-order', require('../components/SearchTurnosOrdenComponent.vue').default);

const estandaresLoader = new Vue({
    el: "#estandaresLoader",
    data: {
        helpers: {
            h1: false,
            bandera: false,
            estado: 0,
        },
        panels: {
            p1: true, //for panel search 
        },
        order: [],
        listEstandares: [],
        turnoSelected: null,
        codeOrdenSelected: null
    },
    methods: {
        loadEstandares: function(params){
            const order_code = params.split(',')[0];
            const turno = params.split(',')[1];
            if (order_code.length <= 1) {
                StatusHandler.ValidationMsg("Numero de Orden Invalido");
                return;
            }
            
            this.codeOrdenSelected = order_code;
            this.turnoSelected = turno;

            StatusHandler.LShow();            
            getAllEstandaresByOrderCode(order_code, turno).then(result => {
                const response = result.data;
                if (response.code == 0) {
                    StatusHandler.ShowStatus("La orden no se encuentra registrada en el sistema", StatusHandler.OPERATION.DEFAULT, StatusHandler.STATUS.FAIL);
                    return;
                }
                this.listEstandares.splice(0);
                response.data.forEach((element, index) => {
                    this.listEstandares.push(element);
                });

                document.getElementById('pnlSecondary').classList.remove('d-none');
                StatusHandler.LClose();
            }).catch(ex => {
                StatusHandler.LClose();
                StatusHandler.Exception("Buscar Estandares", ex);
            });
        },
        cargarEstandar: async function(estandarId){

            getEstandarById(estandarId).then(result => {
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
        crearNuevoEstandar: async function(){
            console.log("Creando nuevo estandar");
            
            var confirm = await StatusHandler.Confirm("¿Desea realizar esta acción?");
            if(!confirm)return;
            StatusHandler.LShow();  

            getJsonModelEstandares(this.codeOrdenSelected, this.turnoSelected).then(result => {
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
                StatusHandler.Exception("Buscar Estandares");
            });
        },
        loadEstandares2: function(params) {
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
                StatusHandler.Exception("Buscar Estandares", ex);
            })
        },
        has_cap(e){
            return window.has_cap == undefined ? false : window.has_cap(e);
        }        
    }
});