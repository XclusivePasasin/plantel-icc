const { statusProgressPacking } = require("../service.js");
Vue.component('seach-order', require('../components/SearchComponent.vue').default);

const appPackingStatus = new Vue({
    el: "#appPackingStatus",
    data: {
        flags: {
            F1: true
        },
        item: []
    },
    methods: {
        loadOrder: function(code_order){
            StatusHandler.LShow();
            statusProgressPacking(code_order).then(result=>{
                let response = result.data;
                if (response.code == 0) {
                    StatusHandler.LClose();
                    StatusHandler.ShowStatus(response.msg, StatusHandler.OPERATION.DEFAULT, StatusHandler.STATUS.FAIL);
                    return;
                }

                this.flags.F1 = false;
                this.item = [];
                response.data.master.msgs = response.data.master.msgs || "";
                response.data.estandares.msgs = response.data.estandares.msgs || "";
                response.data.controles.msgs = response.data.controles.msgs || "";
                response.data.inspecciones.msgs = response.data.inspecciones.msgs || "";

                response.data.master.msgs = response.data.master.msgs.replace(/\n/g,"<br>");
                response.data.estandares.msgs = response.data.estandares.msgs.replace(/\n/g,"<br>");
                response.data.controles.msgs = response.data.controles.msgs.replace(/\n/g,"<br>");
                response.data.inspecciones.msgs = response.data.inspecciones.msgs.replace(/\n/g,"<br>");

                this.item.push(response.data);
                $("#parentWrappen").removeClass("d-none");
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
