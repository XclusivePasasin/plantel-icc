


const {getOrderByCodeStrict} = require("../service.js");
const {formatOrderDB, formatOrderAPI, getJSONRevision} = require("../helpers.js");
Vue.component('mixorder', require('../components/MixOrderComponent.vue').default);
Vue.component('seach-order', require('../components/SearchComponent.vue').default);

const appApprove = new Vue({
    el: "#appApprove",
    data: {
        panels: {
            p1: true, //for list consolidated
        },
        order: [],
        app_vars: {}
    },
    created: function(){
        this.app_vars = window.AppVars;
    },
    mounted: function(){

    },
     methods: {
        loadOrder: function(order_code) {
            if (order_code.length <= 1) {
                StatusHandler.ValidationMsg("Codigo de orden no valido");
                return;
            }
            
            StatusHandler.LShow();
           getOrderByCodeStrict(order_code).then(result => {
                let response = result.data;
                console.log("RESOUES", response);

                if (response.code == 0) {
                    StatusHandler.ShowStatus(response.msg, StatusHandler.OPERATION.DEFAULT, StatusHandler.STATUS.FAIL);
                    StatusHandler.LClose();
                    return;
                }

                this.panels.p1 = false;
                this.order = []; // limpia antes de pushear

                // Selección de formateador según origen
                if (response.data.origin === "DB") {
                    this.order.push(formatOrderDB(response.data.order));
                } else if (response.data.origin === "API") {
                    this.order.push(formatOrderAPI(response.data.order));
                } else {
                    console.warn("⚠️ Origen desconocido:", response.data.origin);
                }
                
                if(this.order[0].status == 1){
                    this.order[0].revisiones.push(getJSONRevision());
                }

                // lógica de estados
                if (this.order.length && this.order[0].status == 2 && this.has_cap('cap-supcalidad')) {
                    this.order[0].auditor.verified_by = this.app_vars.current_user.user_fullname;
                    this.order[0].auditor.user_revision1 = this.app_vars.current_user.user_fullname;
                    this.order[0].auditor.user_revision2 = this.app_vars.current_user.user_fullname;
                }

                // futuro:
                // if (this.order[0].status == 3 && this.has_cap('cap-supcalidad')) {
                //     this.order[0].auditor.user_autoriza = this.app_vars.current_user.user_fullname;
                // }

                // if (this.order[0].status == 4 && this.has_cap('cap-mezcla')) {
                //     this.order[0].auditor.user_recibe = this.app_vars.current_user.user_fullname;
                // }

                StatusHandler.LClose();
            }).catch(ex => {
                StatusHandler.LClose();
                StatusHandler.Exception("Obtener Orden", ex);
            });


            // getOrderByCodeStrict(order_code).then(result => {
            //     let response = result.data;
            //     console.log("RESOUES",response)
            //     if (response.code == 0) {
            //         StatusHandler.ShowStatus(response.msg, StatusHandler.OPERATION.DEFAULT, StatusHandler.STATUS.FAIL);
            //         StatusHandler.LClose();
            //         return;
            //     }

            //     this.panels.p1 = false;

            //     this.order.push(formatOrderDB(response.data.order));

            //     if(this.order[0].status == 2 && this.has_cap('cap-supcalidad')){
            //         this.order[0].auditor.verified_by = this.app_vars.current_user.user_fullname;
            //         this.order[0].auditor.user_revision1 = this.app_vars.current_user.user_fullname;
            //         this.order[0].auditor.user_revision2 = this.app_vars.current_user.user_fullname;
            //     }

            //     // if(this.order[0].status == 3 && this.has_cap('cap-supcalidad')){
            //     //     this.order[0].auditor.user_autoriza = this.app_vars.current_user.user_fullname;
            //     // }

            //     // if(this.order[0].status == 4 && this.has_cap('cap-mezcla')){
            //     //     this.order[0].auditor.user_recibe = this.app_vars.current_user.user_fullname;
            //     // }      
            //     StatusHandler.LClose();          
                
            // }).catch(ex => {
            //     StatusHandler.LClose();
            //     StatusHandler.Exception("Obtener Orden",ex);
            // });
        },
        has_cap(e){
            return window.has_cap == undefined ? false : window.has_cap(e);
        }         
     }
    
});