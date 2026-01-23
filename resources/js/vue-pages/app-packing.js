
const {getPackingByCodeStrict} = require("../service.js");
const { formatPackingDB,getJSONEntregas,getJSONTimes,getJSONOperarios} = require("../helpers.js");

Vue.component('seach-order', require('../components/SearchComponent.vue').default);
Vue.component('packing', require('../components/PackingComponent.vue').default);



const appPackingTracking = new Vue({
    el: "#appPackingTracking",
    data: {
        flags: {
            F1: true
        },
        app_vars: {},
        order: []
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

            getPackingByCodeStrict(order_code).then(result=>{
                let response = result.data;
                if (response.code == 0) {
                    StatusHandler.LClose();
                    StatusHandler.ShowStatus(response.msg, StatusHandler.OPERATION.DEFAULT, StatusHandler.STATUS.FAIL);
                    return;
                }

                this.flags.F1 = false;
                this.order.push(formatPackingDB(response.data));

                if(this.order[0].status == 2 && (this.has_cap('cap-supcalidad') || this.has_cap('cap-auxcontrol-calidad'))){
                    this.order[0].auditor.user_autoriza = this.app_vars.current_user.user_fullname;
                }

                StatusHandler.LClose();
            }).catch(ex=>{
                StatusHandler.LClose();
                StatusHandler.Exception("Cargar orden",ex);
            });

        },
        has_cap(e){
            return window.has_cap == undefined ? false : window.has_cap(e);
        }
    }
});
