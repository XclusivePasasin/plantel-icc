const { getInspeccionesByOrderCode } = require("../service.js");

Vue.component('inspecciones', require('../components/InspeccionesComponent.vue').default);
Vue.component('seach-order', require('../components/SearchComponent.vue').default);

const inspeccionesLoader = new Vue({
    el: "#inspeccionesLoader",
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
        loadInspecciones: function(order_code) {
            if (order_code.length <= 1) {
                StatusHandler.ValidationMsg("Numero de Orden Invalido");
                return;
            }

            StatusHandler.LShow();

            getInspeccionesByOrderCode(order_code).then(result => {
                let response = result.data;
                if (response.code == 0) {
                    StatusHandler.LClose();
                    StatusHandler.ShowStatus("La orden ingresada no se encuentra registrada. Por favor verifique si la validación del tanque ha sido finalizada (autorizada) o si la orden de empaque correspondiente ya ha sido creada", StatusHandler.OPERATION.DEFAULT, StatusHandler.STATUS.FAIL);
                    return;
                } else {
                    StatusHandler.LClose();
                    let datos = response.data;
                    this.panels.p1 = false;
                    this.helpers.bandera = true;
                    this.order.push(response.data);
                }
                StatusHandler.LClose();
            }).catch(ex => {
                StatusHandler.LClose();
            })
        }
    }
});
