<style scoped>
tr, td {
  border: 1px solid black;
  border-collapse: collapse;
}
        .collapsetable {
            border-collapse: collapse;
            border: 3px solid black;
        }

        .page-break {
            page-break-after: always;
        }

        /*START styles comunes */
        .text-center {
            text-align: center;
        }

        .fw-b1 {
            font-weight: bold;
        }

        .bb-1 {
            border-bottom: 1px solid #b5afaf;
        }

        .m-0 {
            margin: 0px !important;
        }

        .p-0 {
            padding: 0px !important;
        }

        .pt-5 {
            padding-top: 5px;
        }

        .pl-5 {
            padding-left: 5px;
        }

        .mt-1 {
            margin-top: 15px;
        }

        .dw100 {
            width: 100%;
        }

        .fsm1 {
            font-size: 80%;
        }

        .fsm2 {
            font-size: 78%;
        }

        .fsm3 {
            font-size: 65%;
        }

        /*END styles comunes */

        .lumbral1 {
            width: 22%;
        }

        .lumbral2 {
            width: 3%;
        }

        .lumbral3 {
            width: 75%;
        }

        .lumbral4 {
            width: 22%;
        }

        .lumbral5 {
            width: 3%;
        }

        .lumbral6 {
            width: 25%;
        }

        .lumbral7 {
            width: 22%;
        }

        .lumbral8 {
            width: 3%;
        }

        .lumbral9 {
            width: 25%;
        }

        .dtl-header th {
            border-top: 2px solid black;
            border-bottom: 2px solid black;
        }

        .border-r1 {
            border: 2px solid black;
            padding: 5px;
            border-radius: 10px;
        }

        .separator1 {
            border-bottom: 1px dashed black;
            border-top: 1px dashed black;
            height: 3px;
        }
</style>

<template>

    <div class="container pb-6">
        <!--HERE INIT CONTENT SECTION-->
        <div class="py-5">
            <div v-if="data[0].analisis.status==0 && data[0].analisis.observaciones !=null"
                class="alert alert-sa-danger-card alert-sa-has-icon alert-dismissible fade show"
                role="alert"
            >
                <div class="alert-sa-icon">
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        width="1em"
                        height="1em"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        class="feather feather-info"
                    >
                        <circle cx="12" cy="12" r="10"></circle>
                        <line x1="12" y1="16" x2="12" y2="12"></line>
                        <line x1="12" y1="8" x2="12.01" y2="8"></line>
                    </svg>
                </div>
                <div class="alert-sa-content">
                    Tienes <a href="#observaciones" class="alert-link">Observaciones</a>.
                    referente al turno #{{data[0].analisis.turno}}
                </div>
                <button
                    type="button"
                    class="sa-close"
                    data-bs-dismiss="alert"
                    aria-label="Close"
                ></button>
            </div>
            <div class="row g-4 align-items-center">
                <div class="col">
                    <h1 class="h3 m-0">Turno #{{data[0].analisis.turno}}</h1>
                </div>
            </div>
            <br>
        </div>


                        <div class="sa-entity-layout sa-entity-layout--size--md" data-sa-container-query="{&quot;920&quot;:&quot;sa-entity-layout--size--md&quot;,&quot;1100&quot;:&quot;sa-entity-layout--size--lg&quot;}">
                            <div class="sa-entity-layout__body">
                                <div class="sa-entity-layout__main">
                                    <div class="card">
                                        <p class="text-center fw-b1 p-0 m-0">DISTRIBUIDORA CUSCATLAN, S.A. DE C.V.</p>
                                        <p class="text-center fw-b1 p-0 m-0">ICC LABORATORIES</p>
                                        <p class="text-center fw-b1 p-0 m-0">ORDEN DE PRODUCCIÓN</p><br>

                                        <table border="1" class="collapsetable dw100">
                                            <tbody>
                                                <tr>
                                                    <td colspan="3" class="text-center fw-b1">CONTROL DEL AGUA</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-center fw-b1">CONTROL</td>
                                                    <td class="text-center fw-b1">ESPECIFICACION</td>
                                                    <td class="text-center fw-b1">RESULTADO</td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-b1">PH</td>
                                                    <td class="text-center">{{data[0].especificacion.phagua}}</td>
                                                    <td class="text-center">
                                                        <input type="text" :disabled="data[0].analisis.status!=0 || !has_cap('cap-calidad')" v-model="data[0].analisis.phagua" class="form-control" id="ph">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-b1">CONDUCTIVIDAD</td>
                                                    <td class="text-center">{{data[0].especificacion.conductividad}}</td>
                                                    <td class="text-center">
                                                        <input type="text" :disabled="data[0].analisis.status!=0 || !has_cap('cap-calidad')" v-model="data[0].analisis.conductividad" class="form-control" id="conductividad">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-b1">CLORO LIBRE</td>
                                                    <td class="text-center">{{data[0].especificacion.clorolibre}}</td>
                                                    <td class="text-center">
                                                        <input type="text" :disabled="data[0].analisis.status!=0 || !has_cap('cap-calidad')" v-model="data[0].analisis.clibre" class="form-control" id="clibre">
                                                    </td>
                                                </tr>
                                                <tr v-if="(data[0].analisis.status == 2 || data[0].analisis.status == 3)"> 
                                                    <td colspan="3" class="text-center fw-b1">CONTROL DEL PRODUCTO</td>
                                                </tr>
                                                <tr v-if="(data[0].analisis.status == 2 || data[0].analisis.status == 3)">
                                                    <td class="fw-b1">PH</td>
                                                    <td class="text-center">
                                                        <input type="text"    v-model="data[0].especificacion.phproducto" class="form-control" id="cph1">
                                                    </td>
                                                    <td class="text-center">
                                                        <input type="text"  v-model="data[0].analisis.phproducto" class="form-control" id="cph">
                                                    </td>
                                                </tr>
                                                <tr v-if="(data[0].analisis.status == 2 || data[0].analisis.status == 3)">
                                                    <td class="fw-b1">VISCOSIDAD</td>
                                                    <td class="text-center">
                                                        <input type="text"    v-model="data[0].especificacion.viscosidad" class="form-control" id="vis1">
                                                    </td>
                                                    <td class="text-center">
                                                        <input type="text"  v-model="data[0].analisis.viscosidad" class="form-control" id="vis">
                                                    </td>
                                                </tr>
                                                <tr v-if="(data[0].analisis.status == 2 || data[0].analisis.status == 3)">
                                                    <td class="fw-b1">DENSIDAD</td>
                                                    <td class="text-center">
                                                        <input type="text"   v-model="data[0].especificacion.densidad" class="form-control" id="den1">
                                                    </td>
                                                    <td class="text-center">
                                                        <input type="text"  v-model="data[0].analisis.densidad" class="form-control" id="den">
                                                    </td>
                                                </tr>
                                                <tr v-if="(data[0].analisis.status == 2 || data[0].analisis.status == 3)">
                                                    <td class="fw-b1">APARIENCIA</td>
                                                    <td class="text-center">{{data[0].especificacion.apariencia}}</td>
                                                    <td class="text-center">
                                                        <input type="text"  v-model="data[0].analisis.apariencia" class="form-control" id="apa">
                                                    </td>
                                                </tr>
                                                <tr v-if="(data[0].analisis.status == 2 || data[0].analisis.status == 3)">
                                                    <td class="fw-b1">COLOR</td>
                                                    <td class="text-center">{{data[0].especificacion.color}}</td>
                                                    <td class="text-center">
                                                        <input type="text"  v-model="data[0].analisis.color" class="form-control" id="color">
                                                    </td>
                                                </tr>
                                                <tr v-if="(data[0].analisis.status == 2 || data[0].analisis.status == 3)">
                                                    <td class="fw-b1">OLOR</td>
                                                    <td class="text-center">{{data[0].especificacion.olor}}</td>
                                                    <td class="text-center">
                                                        <input type="text"  v-model="data[0].analisis.olor" class="form-control" id="olor">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="text-center fw-b1">OBSERVACIONES</td>
                                                    <td colspan="2" class="text-center fw-b1">
                                                        <textarea id="observaciones"  v-model="data[0].analisis.observaciones" class="form-control" rows="4"></textarea>
                                                    </td>
                                                </tr>
                                                <tr v-if="(data[0].analisis.status == 2 || data[0].analisis.status == 3)">
                                                    <td colspan="3" class="text-center fw-b1">AUTORIZACIONES</td>
                                                </tr>
                                                <tr v-if="(data[0].analisis.status == 2 || data[0].analisis.status == 3)">
                                                    <td class="text-center fw-b1">REALIZO</td>
                                                    <td class="text-center fw-b1">VERIFICO</td>
                                                    <td class="text-center fw-b1">AUTORIZO</td>
                                                </tr>
                                                <tr v-if="(data[0].analisis.status == 2 || data[0].analisis.status == 3)">
                                                    <td class="text-center">{{data[0].analisis.user_crea}}</td>
                                                    <td class="text-center">{{data[0].analisis.user_verifica}}</td>
                                                    <td class="text-center">{{data[0].analisis.user_autoriza}}</td>
                                                </tr>
                                                <tr v-if="(data[0].analisis.status == 2 || data[0].analisis.status == 3)">
                                                    <td class="text-center fw-b1">FIRMA</td>
                                                    <td class="text-center fw-b1">FIRMA</td>
                                                    <td class="text-center fw-b1">FIRMA</td>
                                                </tr>
                                                <tr v-if="(data[0].analisis.status == 2 || data[0].analisis.status == 3)">
                                                    <td class="text-center">{{data[0].analisis.user_crea}}</td>
                                                    <td class="text-center">{{data[0].analisis.user_verifica}}</td>
                                                    <td class="text-center">{{data[0].analisis.user_autoriza}}</td>
                                                </tr>
                                                <tr v-if="(data[0].analisis.status == 2 || data[0].analisis.status == 3)">
                                                    <td class="text-center fw-b1">NOMBRE</td>
                                                    <td class="text-center fw-b1">NOMBRE</td>
                                                    <td class="text-center fw-b1">NOMBRE</td>
                                                </tr>
                                                <tr v-if="(data[0].analisis.status == 2 || data[0].analisis.status == 3)">
                                                    <td class="text-center">{{data[0].analisis.rol_crea}}</td>
                                                    <td class="text-center">{{data[0].analisis.rol_verifica}}</td>
                                                    <td class="text-center">{{data[0].analisis.rol_autoriza}}</td>
                                                </tr>
                                                <tr v-if="(data[0].analisis.status == 2 || data[0].analisis.status == 3)">
                                                    <td class="text-center fw-b1">CARGO</td>
                                                    <td class="text-center fw-b1">CARGO</td>
                                                    <td class="text-center fw-b1">CARGO</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <br>
                                        <div class="text-end">
                                            <div class="col-auto">
                                                <button type="button" v-if="data[0].analisis.status == 3" @click="generatedReport" class="btn btn-dark"><i class="bi bi-file-earmark-pdf"></i> Generar Reporte</button>
                                                <button type="button"  v-if="data[0].analisis.status == 1"  @click="aprobAut" class="btn btn-primary">Aprobar</button>
                                                <button type="button" v-if="(f('cap-jefecontrol-calidad')) && data[0].analisis.status == 2"  @click="aprobAut" class="btn btn-success">Autorizar</button>
                                                <button type="button" :disabled="data[0].analisis.status > 2" v-if="has_cap('cap-supcalidad') || has_cap('cap-calidad')" @click="saveOrUpdate" class="btn btn-success">Guardar</button>
                                                <!-- <button type="button" :disabled="data[0].analisis.status > 3" v-if="has_cap('cap-calidad') && data[0].analisis.status == 3" @click="aprobAut" class="btn btn-success">Confir</button> -->
                                            </div>
                                        </div>

                                    </div>
                                </div>
                </div>
            </div>

        <!--HERE END CONTENT SECTION-->
    </div>

</template>

<script>
    const {upsertAnalisis} = require("../service.js");
    export default {
        props: {
            source: {type: Object,required: true}
        },
        data: function(){
            return {
                data: this.source,
                edit_mode: false,
                show_control_producto: has_cap('cap-mezcla') && true,
                show_firmas: has_cap('cap-mezcla') && true
            }
        },
        created: function(){
            this.app_vars = window.AppVars;
        },
       methods: {

            saveOrUpdate: async function(){
                //Validation here 
                //alert(JSON.stringify(this.data));
                

                this.data[0].analisis.especificacion = this.getEspecificaciones();


                var confirm = await StatusHandler.Confirm("¿Desea realizar esta acción?");
                if(!confirm)return;
                StatusHandler.LShow();
                if(this.data[0].analisis.status == 0 && this.has_cap('cap-calidad')){
                    this.data[0].analisis.status=1;
                    
                }
                
                if(this.data[0].analisis.status == 2 && (this.has_cap('cap-supcalidad') || this.has_cap('cap-calidad'))){
                    this.data[0].analisis.status= 2;
                }

                
                
                upsertAnalisis(this.data[0]).then(result=>{
                    let response = result.data;
                    if(response.code == 0){
                        // if(this.has_cap('cap-calidad')){
                        //     this.data[0].analisis.status=0;
                        // }
                        StatusHandler.ShowStatus(response.msg,StatusHandler.OPERATION.DEFAULT,StatusHandler.STATUS.FAIL);
                        return;
                    }

                    this.data = response.data;
                    this.edit_mode = false;
                    StatusHandler.LClose();
                    StatusHandler.ShowStatus("!Acción Existosa!",StatusHandler.OPERATION.DEFAULT,StatusHandler.STATUS.SUCCESS);
                }).catch(ex=>{
                    if(this.has_cap('cap-calidad')){
                        this.data[0].analisis.status=0;
                    }
                    StatusHandler.LClose();
                    StatusHandler.Exception("Ocurrió un error",ex);
                })
            },
            aprobAut: async function(){
                //Validation here 
                //Validation here 
                
                var confirm = await StatusHandler.Confirm("¿Desea realizar esta acción?");
                if(!confirm)return;
                StatusHandler.LShow();

                if(this.data[0].analisis.status == 1 && this.has_cap('cap-calidad')){
                    this.data[0].analisis.status=2;
                }
                
                //unicamente el jefe de ctrl de calidad puede autorizar
                if(this.data[0].analisis.status == 2 && (this.has_cap('cap-jefecontrol-calidad'))){
                    this.data[0].analisis.status=3;
                    this.data[0].analisis.especificacion = this.getEspecificaciones();
                }

                upsertAnalisis(this.data[0]).then(result=>{
                    let response = result.data;
                    console.log("RESP AGUA APROB", response)
                    if(response.code == 0){
                        // if(this.has_cap('cap-supcalidad')){
                        //     this.data[0].analisis.status=1;
                        // }
                        // if(this.has_cap('cap-jefecontrol-calidad') || this.has_cap('cap-calidad')){
                        //     this.data[0].analisis.status=2;
                        // }
                        
                        StatusHandler.ShowStatus(response.msg,StatusHandler.OPERATION.DEFAULT,StatusHandler.STATUS.FAIL);
                        return;
                    }

                    this.data = response.data;
                    this.edit_mode = false;
                    StatusHandler.LClose();
                    StatusHandler.ShowStatus("!Acción Existosa!",StatusHandler.OPERATION.DEFAULT,StatusHandler.STATUS.SUCCESS);
                }).catch(ex=>{
                        if(this.has_cap('cap-supcalidad')){
                            this.data[0].analisis.status=1;
                        }
                        if(this.has_cap('cap-jefecontrol-calidad')){
                            this.data[0].analisis.status=2;
                        }
                        if(this.has_cap('cap-mezcla')){
                            this.data[0].analisis.status=3;
                        }
                    StatusHandler.LClose();
                    StatusHandler.Exception("Ocurrió un error",ex);
                })
            },
            generatedReport:  function(){
                //StatusHandler.LShow();
                var open_url = window.location.origin + `/report/analisisagua/${this.data[0].analisis.turno}`;
                window.open(open_url, '_blank').focus();
                //StatusHandler.LClose();
            },
            has_cap(e){
                return window.has_cap == undefined ? false : window.has_cap(e);
            },
            
            getEspecificaciones: function(){
                let especificacion = "CONTROL DE AGUA \n" + 
                    "PH: " + this.data[0].especificacion.phagua + "\n" +
                    "CONDUCTIVIDAD: " + this.data[0].especificacion.conductividad + "\n" +
                    "CLORO LIBRE: " + this.data[0].especificacion.clorolibre + "\n" +
                    "---------------------------------------------------- \n"+ 
            "CONTROL DE PRODUCTO \n"+
                    "PH: " + this.data[0].especificacion.phproducto + "\n" +
                    "VISCOSIDAD: " + this.data[0].especificacion.viscosidad + "\n" +
                    "DENSIDAD: " + this.data[0].especificacion.densidad + "\n" +
                    "APARIENCIA: " + this.data[0].especificacion.apariencia + "\n" +
                    "COLOR: " + this.data[0].especificacion.color + "\n" +
                    "OLOR: " + this.data[0].especificacion.olor + "\n";

                return especificacion;
            }

        }

    }
</script>
