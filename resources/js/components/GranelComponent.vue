<template>
  <div class="container pb-6">
    <!--HERE INIT CONTENT SECTION-->
    <div class="py-5">
      <div class="row g-4 align-items-center">
        <div class="col">
          <h1 class="h3 m-0">
            Etiqueta de identificación de granel
          </h1>
        </div>
      </div>
    </div>

    <div
      class="sa-entity-layout sa-entity-layout--size--md"
      data-sa-container-query='{"920":"sa-entity-layout--size--md","1100":"sa-entity-layout--size--lg"}'
    >
      <div class="sa-entity-layout__body">
        <div class="sa-entity-layout__main">
          <div class="card">
            <div class="card-body p-5">
              <div class="alert alert-danger" role="alert" v-if="data[0].order.status != FLAGS.MIX_FINALIZED">
                El estado de la mezcla no ha finalizado para esta orden
              </div>
              <div class="row">
                <div class="mb-4">
                  <label for="producto" class="form-label">Producto: </label
                  ><input
                    type="text"
                    disabled="true"
                    class="form-control"
                    v-model="data[0].granel.producto"
                    id="producto"
                  />
                </div>
              </div>
              <div class="row">
                <div class="col-md-3">
                  <div class="mb-4">
                    <label for="lote" class="form-label">Lote: </label
                    ><input
                      type="text"
                      class="form-control"
                      disabled="true"
                      v-model="data[0].granel.lote"
                      id="lote"
                    />
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="mb-4">
                    <label for="batch" class="form-label">N° Batch: </label
                    ><input
                      :disabled="isBatchEditable()"
                      type="text"
                      class="form-control"
                      v-model="data[0].granel.batch"
                      id="batch"
                    />
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="mb-4">
                    <label for="orden" class="form-label">N° Tanque: </label
                    ><input
                      :disabled="isBatchEditable()"
                      type="text"
                      class="form-control"
                      v-model="data[0].granel.tanque"
                      id="orden"
                    />
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="mb-4">
                    <label for="orden" class="form-label">N° Orden: </label
                    ><input
                      type="text"
                      class="form-control"
                      disabled="true"
                      v-model="data[0].granel.orden"
                      id="orden"
                    />
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="mb-4">
                    <label for="datefabricacion" class="form-label"
                      >Fecha de Fabricación: </label
                    ><!-- Fecha de Fabricación -->
                    <input
                      type="text"
                      class="form-control"
                      disabled="true"
                      v-model="data[0].granel.fecha_fabricacion"
                      v-mask="'##/##/####'"
                      placeholder="DD/MM/YYYY"
                      id="datefabricacion"
                    />

                  </div>
                </div>
                <div class="col-md-6">
                  <div class="mb-4">
                    <label for="cantidad" class="form-label">Cantidad: </label
                    ><input
                      type="number"
                      
                      disabled="true"
                      class="form-control"
                      v-model="data[0].order.lot_size"
                      id="cantidad"
                    />
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-4">
                  <div class="mb-4">
                    <label for="dateexpiracion" class="form-label"
                      >Fecha de Expiración: </label
                    ><input
                      :disabled="isBatchEditable()"
                      type="text"
                      class="form-control"
                      v-model="data[0].granel.fecha_expiracion"
                      v-mask="'##/##/####'"
                      placeholder="DD/MM/YYYY"
                      id="dateexpiracion"
                    />

                  </div>
                </div>
                <div class="col-md-4">
                  <div class="mb-4">
                    <label for="proceso" class="form-label">Proceso: </label
                    ><input
                      type="text"
                      class="form-control"
                      disabled="true"
                      value="Fabricación"
                      id="proceso"
                    />
                  </div>
                </div>
                <div class="col-md-4">
                  <div style="margin-top: 45px;">
                    <!-- <label for="cv1" class="form-label"
                      >Color igual a patrón:
                    </label>
                    <div class="input-group">
                      <input
                        type="text"
                        class="form-control"
                        v-model="data[0].granel.cv1"
                        id="cv1"
                      /><input
                        type="text"
                        class="form-control"
                        v-model="data[0].granel.cv2"
                        id="cv2"
                      />
                    </div> -->
                    <div class="input-group">
                      <div class="form-check form-check-inline">
                        <input
                          class="form-check-input"
                          type="checkbox" id="cv1"
                          v-model="data[0].granel.cv1"
                          :disabled="!canEditCVFields()"
                          true-value="1"
                          false-value="0">
                        <label class="form-check-label" for="inlineCheckbox1">Color igual a patrón:</label>
                      </div>
                      <div class="form-check form-check-inline">
                        <input
                          class="form-check-input"
                          type="checkbox" id="cv2"
                          v-model="data[0].granel.cv2"
                          :disabled="!canEditCVFields()"
                          true-value="1"
                          false-value="0">
                        <label class="form-check-label" for="inlineCheckbox2">Olor igual a patrón:</label>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div  v-if="has_cap('cap-calidad') || has_cap('cap-supcalidad') || has_cap('cap-auxcontrol-calidad') || has_cap('cap-jefecontrol-calidad')">
                <div class="row">
                <div class="mb-5">
                  <h2 class="mb-0 fs-exact-18" style="font-weight: bold">
                    PARÁMETROS DE PRODUCTO DE GRANEL
                  </h2>
                </div>
              </div>
              <div class="row">
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th scope="col"></th>
                      <th scope="col">Temperatura °C</th>
                      <th scope="col">Especificaciones</th>
                      <th scope="col">Resultados</th>
                      <th scope="col">F. Realizo</th>
                    </tr>
                  </thead>
                  <tbody>


                    <tr v-for="e in ((data[0].granel.parametros))" :key="e.id">
                      <th scope="row"> {{ getTextGranelId(e.id) }}</th>
                      <td>
                        <input class="form-control text-center" disabled v-model="e.values.temp"/>
                      </td>
                      <td>
                        <input class="form-control text-center" disabled v-model="e.values.especification"/>
                      </td>
                      <td>
                        <input class="form-control defblue1" v-model="e.values.results" disabled />
                      </td>
                      <!-- <td>
                        <input class="form-control defblue1" :disabled="data[0].granel.status >= 3" v-model="e.values.results"/>
                      </td> -->
                      <td>
                        <input disabled="true" class="form-control" v-model="e.values.create_by"/>
                      </td>
                    </tr>
                  </tbody>
                </table>

                <div></div>

              </div>

              </div>

              <div class="row">
                <div class="col-md-6">
                  <div class="mb-4">
                    <label for="responsables" class="form-label"
                      >Responsables:
                    </label>
                    <textarea
                      id="responsables"
                      class="form-control"
                      rows="4"
                      v-model="data[0].granel.responsables"
                      disabled="true"
                    ></textarea>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="mb-4">
                    <label for="equipo" class="form-label">Equipo: </label
                    ><input
                      type="text"
                      :disabled="isBatchEditable()"
                      class="form-control"
                      v-model="data[0].granel.equipo"
                      id="equipo"
                    />
                  </div>
                </div>
              </div>
              <div class="text-end">
                <div class="col-auto">
                
                  <!-- Guardar: Solo cuando status es 1 y el usuario tiene algún permiso relevante -->
                  <button 
                    v-if="has_cap('cap-mezcla') && data[0].granel.status == 1"
                    type="button" 
                    @click="saveOrUpdate('save')" 
                    :disabled="data[0].order.status !== FLAGS.MIX_FINALIZED"
                    class="btn btn-success me-2">
                    Guardar
                  </button>

                  <!-- Generar Reporte: cuando ya está guardado o confirmado -->
                  <button 
                    v-if="data[0].granel.status == 2 || data[0].granel.status == 3"
                    type="button"
                    @click="generatedReport"
                    class="btn btn-dark">
                    <i class="bi bi-file-earmark-pdf"></i> Generar Reporte
                  </button>

                   <!-- Confirmar: Solo para cap-calidad o cap-supcalidad y cuando status es 2 -->
                  <button 
                    v-if="(has_cap('cap-calidad') || has_cap('cap-supcalidad') || has_cap('cap-jefecontrol-calidad') || has_cap('cap-auxcontrol-calidad')) && data[0].granel.status == 2"
                    type="button" 
                    @click="saveOrUpdate('confirm')" 
                    :disabled="data[0].order.status !== FLAGS.MIX_FINALIZED"
                    class="btn btn-success me-2">
                    Confirmar
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!--HERE END MODALS-->

    <!--HERE END CONTENT SECTION-->
  </div>
</template>

<script>
const { upsertGranel, getOrderSpecs  } = require("../service.js");
const { validateDate2, validateDateNow, convertServerDate2 } = require("../helpers.js");
   import { VueMaskDirective } from 'v-mask'
    Vue.directive('mask', VueMaskDirective);
export default {
  props: {
    source: { type: Array, required: true },
    userData: { type: Object, required: true },
  },
  data: function () {
    return {
      data: this.source,
      edit_mode: false,
      reporte:false,
      FLAGS: {
        MIX_FINALIZED: 7
      },
      fechaExpiracionInput: "", // lo que escribe el usuario en el input fecha de expiracion
      fechaFabricacionInput: ""
    };
  },
  mounted() {
    // Fabricación
    if (this.data[0].granel.fecha_fabricacion) {
      const [y, m, d] = this.data[0].granel.fecha_fabricacion.split("-");
      this.fechaFabricacionInput = `${d.padStart(2,"0")}/${m.padStart(2,"0")}/${y}`;
    }

    // Expiración
    if (this.data[0].granel.fecha_expiracion) {
      const [y, m, d] = this.data[0].granel.fecha_expiracion.split("-");
      this.fechaExpiracionInput = `${d.padStart(2,"0")}/${m.padStart(2,"0")}/${y}`;
    }
  },


 computed: {

   fechaFabricacion: {
      get() {
        let raw = this.data[0].granel.fecha_fabricacion;
        if (!raw) return "";

        // Soporta tanto YYYY-MM-DD como DD/MM/YYYY
        let parts = raw.includes("-") ? raw.split("-") : raw.split("/");
        if (parts.length !== 3) return "";

        if (raw.includes("-")) {
          const [y, m, d] = parts;
          return `${d.padStart(2, "0")}/${m.padStart(2, "0")}/${y}`;
        } else {
          const [d, m, y] = parts;
          return `${d.padStart(2, "0")}/${m.padStart(2, "0")}/${y}`;
        }
      },
      set(val) {
        if (!val) {
          this.data[0].granel.fecha_fabricacion = null;
          return;
        }
        const [d, m, y] = val.split("/");
        this.data[0].granel.fecha_fabricacion = `${y}-${m}-${d}`;
      }
    }

  },
  methods: {
    canEditCVFields() {
      return (
        (this.has_cap('cap-calidad') || this.has_cap('cap-supcalidad') || this.has_cap('cap-jefecontrol-calidad') || this.has_cap('cap-auxcontrol-calidad')) &&
        this.data[0].granel.status === 2
      );
    },
    isBatchEditable() {
      return !this.has_cap('cap-mezcla') || this.data[0].granel.status >= 2;
    },
    getTextGranelId: function(id){
      const valores = {};
      valores['VISCOSIDAD'] = 'Viscosidad';
      valores['PH']         = 'PH';
      valores['DENSIDAD']   = 'Densidad';
      return valores[id];
    },
  // setSAPDefaultsIfEmpty(orderCode) {
  //     getOrderSpecs(orderCode).then(apiData => {
  //       const order = apiData.data || {};

  //       const sapDefaults = {
  //         VISCOCIDAD: {
  //           temp: order.temperatura_viscosidad || "0  ",
  //           especification: order.especificaciones_viscosidad || "0"
  //         },
  //         PH: {
  //           temp: order.temperatura_ph || "0",
  //           especification: order.especificaciones_ph || "0"
  //         },
  //         DENSIDAD: {
  //           temp: order.temperatura_densidad || "0",
  //           especification: order.especificaciones_densidad || "0"
  //         }
  //       };

  //       this.data[0].granel.parametros.forEach(param => {
  //         const def = sapDefaults[param.id];
  //         if (def) {
  //           if (!param.values.temp || param.values.temp === "") {
  //             param.values.temp = def.temp;
  //           }
  //           if (!param.values.especification || param.values.especification === "") {
  //             param.values.especification = def.especification;
  //           }
  //         }
  //       });
  //     }).catch(e => {
  //       console.error("Error obteniendo especificaciones desde API", e);
  //     });
  //   },

  // saveOrUpdate: async function(action) {
  //   let msg = "";
  //   let msgfecha = "";

  //   // ✅ Validaciones solo si rol es MEZCLA
  //   if (this.data[0].user.rolname === 'MEZCLA') {
  //       let g = this.data[0].granel;

  //       if (!g.batch) msg += "Batch \n";
  //       if (!g.tanque) msg += "Tanque \n";
  //       if (!g.cantidad) msg += "Cantidad \n";
  //       if (!g.proceso) msg += "Proceso \n";
  //       if (!g.equipo) msg += "Equipo \n";

  //       // =============================
  //       // 🔹 Normalizar fechas a timestamp válido
  //       // =============================
  //       if (g.fecha_fabricacion) {
  //         // Convierte a YYYY-MM-DD HH:mm:ss
  //         g.fecha_fabricacion = moment(g.fecha_fabricacion, ["YYYY-MM-DD","DD/MM/YYYY"])
  //                                 .format("YYYY-MM-DD HH:mm:ss");
  //       }

  //       if (g.fecha_expiracion) {
  //         g.fecha_expiracion = moment(g.fecha_expiracion, ["YYYY-MM-DD","DD/MM/YYYY"])
  //                                 .format("YYYY-MM-DD HH:mm:ss");
  //       }

  //       // =============================
  //       // 🔹 Validaciones de fechas
  //       // =============================
  //       if (!g.fecha_fabricacion || !moment(g.fecha_fabricacion, "YYYY-MM-DD HH:mm:ss").isValid()) {
  //           msgfecha += "La fecha de fabricación es inválida \n";
  //       }

  //       if (g.fecha_expiracion) {
  //         const exp = moment(g.fecha_expiracion, "YYYY-MM-DD HH:mm:ss");
  //         const today = moment().startOf("day"); // hoy sin horas

  //         if (!exp.isValid()) {
  //           msgfecha += "La fecha de expiración es inválida \n";
  //         } else if (exp.isBefore(today)) {
  //           msgfecha += "La fecha de expiración no puede ser menor que hoy \n";
  //         }
  //       }

  //       if (msgfecha.length > 0) {
  //           StatusHandler.ShowStatus(msgfecha, StatusHandler.OPERATION.DEFAULT, StatusHandler.STATUS.FAIL);
  //           return;
  //       }
  //   }

  //   // Mensajes de confirmación
  //   if (msg.length > 0) {
  //       msg = "Los campos: \n" + msg + "están vacíos \n\n¿Desea realizar esta acción?";
  //   } else {
  //       msg = "¿Desea realizar esta acción?";
  //   }

  //   let confirm = await StatusHandler.Confirm(msg);
  //   if (!confirm) return;

  //   // ✅ Cambiar estado según rol/acción
  //   if ((has_cap('cap-mezcla') || has_cap('cap-supcalidad')) && action === 'save') {
  //       this.data[0].granel.status = 2;
  //   }
  //   if ((has_cap('cap-calidad') || has_cap('cap-supcalidad')) && action === 'confirm') {
  //       this.data[0].granel.status = 3;
  //   }

  //   // ✅ Asignar usuario en create_by si rol = calidad
  //   if (this.has_cap('cap-calidad') && this.userData.name) {
  //       this.data[0].granel.parametros.forEach((param) => {
  //           if (!param.values.create_by || param.values.create_by.trim() === "") {
  //               param.values.create_by = this.userData.name;
  //           }
  //       });
  //   }

  //   // ✅ Sincronizar cantidad con order.lot_size
  //   this.data[0].granel.cantidad = this.data[0].order.lot_size;

  //   // Llamada al backend
  //   StatusHandler.LShow();
  //   upsertGranel(this.data[0])
  //       .then(result => {
  //           let response = result.data;
  //           if (response.code === 0) {
  //               StatusHandler.ShowStatus(response.msg, StatusHandler.OPERATION.DEFAULT, StatusHandler.STATUS.FAIL);
  //               return;
  //           }

  //           // ⚠️ Ahora backend ya devuelve parametros como array → no JSON.parse
  //           this.data = [response.data];
  //           this.edit_mode = false;

  //           StatusHandler.LClose();
  //           StatusHandler.ShowStatus("¡Acción Exitosa!", StatusHandler.OPERATION.CREATE, StatusHandler.STATUS.SUCCESS);
  //       })
  //       .catch(ex => {
  //           StatusHandler.LClose();
  //           StatusHandler.Exception("Ocurrió un error", ex);
  //       });
  // },

   saveOrUpdate: async function (action) {
      let msg = "";
      let msgfecha = "";
      let g = this.data[0].granel;
      let lfecha=this.data[0].granel.fecha_fabricacion==null?"":this.data[0].granel.fecha_fabricacion.length;
      let lfecha2=this.data[0].granel.fecha_expiracion==null?"":this.data[0].granel.fecha_expiracion.length;
      // ✅ Validaciones obligatorias (solo rol MEZCLA)
      if (this.data[0].user.rolname === 'MEZCLA') {
        if (!g.batch) msg += "Batch \n";
        if (!g.tanque) msg += "Tanque \n";
        if (!g.cantidad) msg += "Cantidad \n";
        if (!g.proceso) msg += "Proceso \n";
        if (!g.equipo) msg += "Equipo \n";

      if(lfecha <= 10){
                      let fec1= validateDate2(this.data[0].granel.fecha_fabricacion);
                      if (fec1==null) {

                        msgfecha = msgfecha + "La fecha de fabricacion es inválida \n";
                      }
                      // else if(!validateDateNow(convertServerDate2(fec1))){
                      //   msgfecha = msgfecha + "La fecha de fabricacion no puede ser menor que hoy \n";
                      // }
                   }

        if(lfecha2 <= 10){
                      let fec2= validateDate2(this.data[0].granel.fecha_expiracion);
                      if (fec2==null) {

                        msgfecha = msgfecha + "La fecha de expiracion es inválida \n";
                      }
                      else if(!validateDateNow(convertServerDate2(fec2))){
                        msgfecha = msgfecha + "La fecha de expiracion no puede ser menor que hoy \n";
                      }
                   }

        // Mostrar errores de fechas
        if (msgfecha.length > 0) {
          StatusHandler.ShowStatus(
            msgfecha,
            StatusHandler.OPERATION.DEFAULT,
            StatusHandler.STATUS.FAIL
          );
          return;
        }
      }

      // ✅ Mensaje de confirmación
      msg =
        msg.length > 0
          ? "Los campos: \n" + msg + "están vacíos \n\n¿Desea realizar esta acción?"
          : "¿Desea realizar esta acción?";

      let confirm = await StatusHandler.Confirm(msg);
      if (!confirm) return;

      // ✅ Cambiar estado
      if ((has_cap("cap-mezcla") || has_cap("cap-supcalidad")) && action === "save") {
        g.status = 2;
      }
      if ((has_cap("cap-calidad") || has_cap("cap-supcalidad") || has_cap("cap-jefecontrol-calidad") || has_cap("cap-auxcontrol-calidad")) && action === "confirm") {
        g.status = 3;
      }

      // ✅ Asignar usuario en create_by
      if (this.has_cap("cap-calidad") && this.userData.name) {
        g.parametros.forEach((param) => {
          if (!param.values.create_by || param.values.create_by.trim() === "") {
            param.values.create_by = this.userData.name;
          }
        });
      }

      // ✅ Sincronizar cantidad
      g.cantidad = this.data[0].order.lot_size;

      // ✅ Guardar en backend
      StatusHandler.LShow();
      upsertGranel(this.data[0])
        .then((result) => {
          let response = result.data;
          if (response.code === 0) {
            StatusHandler.ShowStatus(
              response.msg,
              StatusHandler.OPERATION.DEFAULT,
              StatusHandler.STATUS.FAIL
            );
            return;
          }
          this.data = [response.data];
          this.edit_mode = false;

          StatusHandler.LClose();
          StatusHandler.ShowStatus(
            "¡Acción Exitosa!",
            StatusHandler.OPERATION.CREATE,
            StatusHandler.STATUS.SUCCESS
          );
        })
        .catch((ex) => {
          StatusHandler.LClose();
          StatusHandler.Exception("Ocurrió un error", ex);
        });
    },
    generatedReport: function(){
      var open_url = window.location.origin + `/report/granel/${this.data[0].order.num_id}`;
      window.open(open_url).focus();
    },
    has_cap(e){
                return window.has_cap == undefined ? false : window.has_cap(e);
    },

  },
};
</script>
