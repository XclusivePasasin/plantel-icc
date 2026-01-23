const { getGranelByOrderCode } = require("../service.js");

Vue.component('granel', require('../components/GranelComponent.vue').default);
Vue.component('seach-order', require('../components/SearchComponent.vue').default);

const granelLoader = new Vue({
    el: "#granelLoader",
    data: {
        helpers: {
            h1: false,
            bandera: false,
            estado: 0,
        },
        panels: {
            p1: true, //for panel search 
        },
        order: []
    },
    methods: {
        loadGranel: function(order_code) {
            if (order_code.length <= 1) {
                StatusHandler.ValidationMsg("Numero de Orden Invalido");
                return;
            }
            StatusHandler.LShow();
            getGranelByOrderCode(order_code).then(result => {
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
                StatusHandler.Exception("Buscar Granel", ex);
            })
        }
    }
});