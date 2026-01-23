const { statusProgressMix } = require("../service.js");
Vue.component('seach-order', require('../components/SearchComponent.vue').default);


const appMixStatus = new Vue({
    el: "#appMixStatus",
    data: {
        flags: {
            F1: true
        },
        item: []
    } ,  
    methods: {
        loadOrder: function(code_order){
            StatusHandler.LShow();
            statusProgressMix(code_order).then(result=>{
                let response = result.data;
                if (response.code == 0) {
                    StatusHandler.LClose();
                    StatusHandler.ShowStatus(response.msg, StatusHandler.OPERATION.DEFAULT, StatusHandler.STATUS.FAIL);
                    return;
                }          

                this.flags.F1 = false;                
                this.item = [];
                response.data.master.msgs = response.data.master.msgs || "";
                response.data.granel.msgs = response.data.granel.msgs || "";
                response.data.water.msgs = response.data.water.msgs || "";

                response.data.master.msgs = response.data.master.msgs.replace(/\n/g,"<br>");
                response.data.granel.msgs = response.data.granel.msgs.replace(/\n/g,"<br>");
                response.data.water.msgs = response.data.water.msgs.replace(/\n/g,"<br>");

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