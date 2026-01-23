
Vue.component('seach-order', require('../components/SearchComponent.vue').default);
Vue.component('packing', require('../components/PackingComponent.vue').default);

const {fetchOrderEmpaque} = require("../service.js");
const { formatPackingAPI,formatPackingDB,getJSONEntregas,getJSONTimes,getJSONOperarios} = require("../helpers.js");

const appPackingFetch = new Vue({
    el: "#appPackingFetch",
    data: {
        flags: {
            F1: true
        },
        order: [],
        app_vars: {}
    },
    created: function(){
        this.app_vars = window.AppVars;
    },
    methods: {
        loadOrder: function(order_code){
            if (order_code.length <= 1) {
                StatusHandler.ValidationMsg("Codigo de orden no valido");
                return;
            }

            StatusHandler.LShow();
            fetchOrderEmpaque(order_code).then(result=>{
                let response = result.data;
                if (response.code == 0) {
                    StatusHandler.LClose();
                    StatusHandler.ShowStatus(response.msg, StatusHandler.OPERATION.DEFAULT, StatusHandler.STATUS.FAIL);
                    return;
                }
                //Formating json tree
                this.order = [];
                if (response.data.origin == "DB") {
                    this.order.push(formatPackingDB(response.data.order));
                } else if (response.data.origin == "API") {
                    this.order.push(formatPackingAPI(response.data.order));
                }

                if(this.order[0].status == 1 && (this.has_cap('cap-bodega') || this.has_cap('cap-produccion') || this.has_cap('cap-auxcontrol-calidad'))){
                    this.order[0].times.push(getJSONTimes());
                    this.order[0].times.push(getJSONTimes());
                    this.order[0].times.push(getJSONTimes());

                    this.order[0].operarios.push(getJSONOperarios());
                    this.order[0].operarios.push(getJSONOperarios());
                    this.order[0].operarios.push(getJSONOperarios());

                    this.order[0].entregas.push(getJSONEntregas());
                    this.order[0].entregas.push(getJSONEntregas());
                    this.order[0].entregas.push(getJSONEntregas());
                }

                this.flags.F1 = false;
                StatusHandler.LClose();
            }).catch(ex=>{
                StatusHandler.LClose();
                StatusHandler.Exception("Obtener orden empaque",ex);
            });
        },
        has_cap(e){
            return window.has_cap == undefined ? false : window.has_cap(e);
        }
    }
});
