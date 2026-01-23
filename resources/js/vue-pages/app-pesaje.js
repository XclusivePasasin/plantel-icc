const { getOrderByCode } = require("../service.js");
const { formatOrderAPI, formatOrderDB,getJSONRevision } = require("../helpers.js");

Vue.component('seach-order', require('../components/SearchComponent.vue').default);
Vue.component('mixorder', require('../components/MixOrderComponent.vue').default);



const appGeneral = new Vue({
    el: "#appGeneral",
    data: {
        search_val: "",
        helpers: {
            h1: false
        },
        panels: {
            p1: true, //for panel search 
        },
        order: []
    },
    methods: {
        loadOrder: function(order_code) {
            if (order_code.length <= 1) {
                StatusHandler.ValidationMsg("Codigo de orden no valido");
                return;
            }

            StatusHandler.LShow();
            getOrderByCode(order_code).then(result => {
                let response = result.data;
                if (response.code == 0) {
                    StatusHandler.LClose();
                    StatusHandler.ShowStatus(response.msg, StatusHandler.OPERATION.DEFAULT, StatusHandler.STATUS.FAIL);
                    return;
                }
                if (response.data.order == null) { this.helpers.h1 = true; return; } else { this.helpers.h1 = false; }

                this.order = [];
                this.panels.p1 = false;
                if (response.data.origin == "DB") {
                    this.order.push(formatOrderDB(response.data.order));//Formating json tree
                } else if (response.data.origin == "API") {
                    this.order.push(formatOrderAPI(response.data.order));//Formating json tree
                }

                if(this.order[0].status == 1 && this.has_cap('cap-materiaprima')){
                    this.order[0].revisiones.push(getJSONRevision());
                    this.order[0].revisiones.push(getJSONRevision());
                }

                StatusHandler.LClose();
            }).catch(ex => {
                StatusHandler.LClose();
                StatusHandler.Exception("Obtener orden",ex);
            });
        },
        has_cap(e){
            return window.has_cap == undefined ? false : window.has_cap(e);
        }           
    }
});
