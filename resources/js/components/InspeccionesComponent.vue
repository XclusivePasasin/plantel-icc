<template>

  <div class="container pb-6">
    <!--HERE INIT CONTENT SECTION-->
    <div class="py-5">
      <div class="row g-4 align-items-center">
        <div class="col">
          <h1 class="h3 m-0">
            Orden de Producción #{{data[0].order.num_id }}
          </h1>
        </div>
      </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <h4 class="py-4" style="text-align:center;">DISTRIBUIDORA CUSCATLAN, S.A. DE C.V. <br> HOJA DE INSPECCIONES (PRODUCCIÓN)</h4>
                     <div class="sa-divider"></div>
                    <div class="card" style="padding:2%;">
                        <div class="col-10 col-md-6">
                            <h5 style="text-align:center;">Validación de conexión a tanque</h5>
<table class="table table-sm mb-0">
  <tbody>
    <tr>
      <th>Fecha y hora</th>
      <td>
        <input
          type="datetime-local"
          placeholder="DD/MM/YYYY HH:MM"
          class="form-control form-control-sm"
          :value="formatDateTimeLocal(data[0].inspecciones.fechahoraconxtanque1)"
          @input="data[0].inspecciones.fechahoraconxtanque1 = $event.target.value"
          :disabled="true"
        />
      </td>
    </tr>
    <tr>
      <th>Operaria de máquina</th>
      <td>
        <input
          type="text"
          placeholder="Operaria"
          class="form-control form-control-sm"
          v-model="data[0].inspecciones.opmaquinaconxtanque1"
          :disabled="true"
        />
      </td>
    </tr>
    <tr>
      <th>Supervisor</th>
      <td>
        <input
          type="text"
          placeholder="Producción"
          class="form-control form-control-sm"
          v-model="data[0].inspecciones.supervisorconxtanque1"
          :disabled="true"
        />
      </td>
    </tr>
    <tr>
      <th>Control de calidad</th>
      <td>
        <input
          type="text"
          placeholder="Calidad"
          class="form-control form-control-sm"
          v-model="data[0].inspecciones.ctrlcalidadconxtanque1"
          :disabled="true"
        />
      </td>
    </tr>
  </tbody>
</table>

                        </div>

                        <div class="sa-divider py-4"></div>

                        <div style="padding-left:1%;">
                            <div class="row">
                                <div class="col-4">
                                    <table class="table table-sm mb-0" style="margin-bottom: 0;">
                                        <tbody>
                                            <tr>
                                                <th class="align-middle" style="width: 8%; padding-right: 5px; white-space: nowrap;">LOTE</th>
                                                <td style="width: 20%; padding-left: 5px;">
                                                    <input type="text"
                                                    placeholder="Número de lote"
                                                    class="form-control form-control-sm"
                                                    style="width: auto; margin-right: 10px;"
                                                    :disabled="data[0].user.rolname != 'PROD' || !isEnabledSection('A')"
                                                    v-model="data[0].inspecciones.lote"
                                                    />
                                                </td>
                                                <th class="align-middle" style="width: 10%; padding-right: 10px; white-space: nowrap;">N° Tanque</th>
                                                <td style="width: 20%; padding-left: 5px;">
                                                    <input type="text"
                                                    placeholder="Número de tanque"
                                                    class="form-control form-control-sm"
                                                    style="width: auto;"
                                                    :disabled="data[0].user.rolname != 'PROD' || !isEnabledSection('A')"
                                                    v-model="data[0].inspecciones.tanque"
                                                    />
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="sa-divider py-4"></div>

                        <div class="row">
                            <div class="col-5 col-md-6">
                                <h5 style="text-align:center;">RECHAZADOS</h5>
                                <table class="table table-sm mb-0">
                                    <thead>
                                        <tr>
                                            <th>FECHAS</th>
                                            <th>CANTIDAD UND</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <input type="date"
                                                placeholder="DD/MM/YYYY"
                                                class="form-control form-control-sm"
                                                :disabled="data[0].user.rolname != 'PROD'"
                                                :value="formatDate(data[0].inspecciones.rechazadosfecha1)"
                                                @input="data[0].inspecciones.rechazadosfecha1 = $event.target.value"
                                            />

                                            </td>
                                            <td>
                                                <input type="text"
                                                placeholder="Unidades"
                                                class="form-control form-control-sm"
                                                :disabled="data[0].user.rolname != 'PROD'"
                                                @input="sumarcantidad"
                                                v-model="data[0].inspecciones.rechazadoscantidadund1"/>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>
                                                <input type="date"
                                                placeholder="DD/MM/YYYY"
                                                class="form-control form-control-sm"
                                               :disabled="data[0].user.rolname != 'PROD'"
                                                :value="formatDate(data[0].inspecciones.rechazadosfecha2)"
                                                @input="data[0].inspecciones.rechazadosfecha2 = $event.target.value"/>
                                            </td>
                                            <td>
                                                <input type="text"
                                                placeholder="Unidades"
                                                class="form-control form-control-sm"
                                                :disabled="data[0].user.rolname != 'PROD'"
                                                @input="sumarcantidad"
                                                v-model="data[0].inspecciones.rechazadoscantidadund2"/>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>
                                                <input type="date"
                                                placeholder="DD/MM/YYYY"
                                                class="form-control form-control-sm"
                                                :disabled="data[0].user.rolname != 'PROD'"
                                                :value="formatDate(data[0].inspecciones.rechazadosfecha3)"
                                                @input="data[0].inspecciones.rechazadosfecha3 = $event.target.value"/>
                                            </td>
                                            <td>
                                                <input type="text"
                                                placeholder="Unidades"
                                                class="form-control form-control-sm"
                                                :disabled="data[0].user.rolname != 'PROD'"
                                                @input="sumarcantidad"
                                                v-model="data[0].inspecciones.rechazadoscantidadund3"/>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>
                                                <input type="date"
                                                placeholder="DD/MM/YYYY"
                                                class="form-control form-control-sm"
                                                :disabled="data[0].user.rolname != 'PROD'"
                                                :value="formatDate(data[0].inspecciones.rechazadosfecha4)"
                                                @input="data[0].inspecciones.rechazadosfecha4 = $event.target.value"/>
                                            </td>
                                            <td>
                                                <input type="text"
                                                placeholder="Unidades"
                                                class="form-control form-control-sm"
                                                @input="sumarcantidad"
                                                :disabled="data[0].user.rolname != 'PROD' "
                                                v-model="data[0].inspecciones.rechazadoscantidadund4"/>
                                            </td>
                                        </tr>

                                         <tr>
                                            <th>Total</th>
                                            <td>
                                                <input type="text"
                                                style="text-align:center; font-weight:bold;"
                                                placeholder="Total unidades"
                                                class="form-control form-control-sm"
                                                id="totalunidades"
                                                disabled
                                                v-model="data[0].inspecciones.totalunidadesrechazadas"/>
                                            </td>
                                            <!-- <td>
                                                <input type="text"
                                                style="text-align:center; font-weight:bold;"
                                                placeholder="Total unidades"
                                                class="form-control form-control-sm"
                                                id="totalunidades"
                                                :disabled="data[0].user.rolname != 'PROD' || !isEnabledSection('B')"
                                                v-model="data[0].inspecciones.totalunidadesrechazadas"/>
                                            </td> -->
                                        </tr>

                                    </tbody>
                                </table>
                            </div>

                            <div class="col-5 col-md-6">
                                <h5 style="text-align:center;">VACÍOS</h5>
                                <table class="table table-sm mb-0">
                                    <thead>
                                        <tr>
                                            <th>FECHAS</th>
                                            <th>CANTIDAD KGS</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <input type="date"
                                                placeholder="DD/MM/YYYY"
                                                class="form-control form-control-sm"
                                                :disabled="data[0].user.rolname != 'PROD'"
                                                :value="formatDate(data[0].inspecciones.vaciosfecha1)"
                                                @input="data[0].inspecciones.vaciosfecha1 = $event.target.value"/>
                                            </td>
                                            <!-- <td>
                                                <input type="date"
                                                placeholder="DD/MM/YYYY"
                                                class="form-control form-control-sm"
                                                :disabled="data[0].user.rolname != 'PROD' || !isEnabledSection('B')"
                                                :value="formatDate(data[0].inspecciones.rechazadosfecha4)"
                                                @input="data[0].inspecciones.rechazadosfecha4 = $event.target.value"/>
                                            </td> -->
                                            <td>
                                                <input type="text"
                                                placeholder="Kilogramos"
                                                class="form-control form-control-sm"
                                                @input="sumarkilogramos"
                                                :disabled="data[0].user.rolname != 'PROD' "
                                                v-model="data[0].inspecciones.vacioscantidadkgs1"/>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>
                                                <input type="date"
                                                placeholder="DD/MM/YYYY"
                                                class="form-control form-control-sm"
                                                :disabled="data[0].user.rolname != 'PROD'"
                                                :value="formatDate(data[0].inspecciones.vaciosfecha2)"
                                                @input="data[0].inspecciones.vaciosfecha2 = $event.target.value"/>
                                            </td>
                                            <td>
                                                <input type="text"
                                                placeholder="Kilogramos"
                                                class="form-control form-control-sm"
                                                @input="sumarkilogramos"
                                                :disabled="data[0].user.rolname != 'PROD'"
                                                v-model="data[0].inspecciones.vacioscantidadkgs2"/>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>
                                                <input type="date"
                                                placeholder="DD/MM/YYYY"
                                                class="form-control form-control-sm"
                                                :disabled="data[0].user.rolname != 'PROD'"
                                                :value="formatDate(data[0].inspecciones.vaciosfecha3)"
                                                @input="data[0].inspecciones.vaciosfecha3 = $event.target.value"/>
                                            </td>
                                            <td>
                                                <input type="text"
                                                placeholder="Kilogramos"
                                                class="form-control form-control-sm"
                                                @input="sumarkilogramos"
                                                :disabled="data[0].user.rolname != 'PROD' "
                                                v-model="data[0].inspecciones.vacioscantidadkgs3"/>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>
                                                <input type="date"
                                                placeholder="DD/MM/YYYY"
                                                class="form-control form-control-sm"
                                                :disabled="data[0].user.rolname != 'PROD'"
                                                :value="formatDate(data[0].inspecciones.vaciosfecha4)"
                                                @input="data[0].inspecciones.vaciosfecha4 = $event.target.value"/>
                                            </td>
                                            <td>
                                                <input type="text"
                                                placeholder="Kilogramos"
                                                class="form-control form-control-sm"
                                                @input="sumarkilogramos"
                                                :disabled="data[0].user.rolname != 'PROD' "
                                                v-model="data[0].inspecciones.vacioscantidadkgs4"/>
                                            </td>
                                        </tr>

                                         <tr>
                                            <th>Total</th>
                                            <td>
                                                <input type="text"
                                                style="text-align:center; font-weight:bold;"
                                                placeholder="Total kilogramos"
                                                class="form-control form-control-sm"
                                                id="totalkilogramos"
                                                disabled
                                                v-model="data[0].inspecciones.totalkilogramosvacios"/>
                                            </td>
                                            <!-- <td>
                                                <input type="text"
                                                style="text-align:center; font-weight:bold;"
                                                placeholder="Total kilogramos"
                                                class="form-control form-control-sm"
                                                id="totalkilogramos"
                                                :disabled="data[0].user.rolname != 'PROD' || !isEnabledSection('B')"
                                                v-model="data[0].inspecciones.totalkilogramosvacios"/>
                                            </td> -->
                                        </tr>

                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="sa-divider py-4"></div>

                        <div style="padding-left:1%;">
                            <div class="row">
                                <div class="col-6">
                                    <table class="table table-sm mb-0">
                                        <tbody>
                                            <tr>
                                                <th>PRODUCTO TERMINADO</th>
                                                <td>Cajas</td>
                                                <td>
                                                    <input type="text"
                                                    placeholder=""
                                                    class="form-control form-control-sm"
                                                    disabled
                                                    v-model="data[0].inspecciones.productoterminado1"/>
                                                </td>
                                                <td>Unidades</td>
                                                <td>
                                                    <input type="text"
                                                    placeholder=""
                                                    class="form-control form-control-sm"
                                                    disabled
                                                    v-model="data[0].inspecciones.productoterminado2"/>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="sa-divider py-4"></div>

                        <div style="padding-left:1%;">
                            <div class="row">
                                <div class="col-2">
                                    <table class="table table-sm mb-0">
                                        <tbody>
                                            <tr>
                                                <th>PT+</th>
                                                <td>
                                                    <input
                                                        type="text"
                                                        placeholder="Terminados" 
                                                        disabled
                                                        class="form-control form-control-sm"
                                                        @input="totalproductos"
                                                        v-model.number="data[0].inspecciones.pt"
                                                    />

                                                    <!-- <input type="text"
                                                    placeholder="Terminados"
                                                    class="form-control form-control-sm"
                                                    :disabled="data[0].user.rolname != 'PROD' "
                                                    v-model="data[0].inspecciones.pt"/> -->

                                                </td>
                                            </tr>
                                            <tr>
                                                <th>PR</th>
                                                <td>
                                                    <input
                                                        type="text"
                                                        id="prodrechazado"
                                                        disabled
                                                        placeholder="Rechazados"
                                                        class="form-control form-control-sm"
                                                        @input="totalproductos"
                                                        v-model.number="data[0].inspecciones.totalunidadesrechazadas"
                                                    />

                                                    <!-- <input type="text"
                                                    id="prodrechazado"
                                                    placeholder="Rechazados"
                                                    class="form-control form-control-sm"
                                                    @change="totalproductos"
                                                    :disabled="data[0].user.rolname != 'PROD'"
                                                    v-model="data[0].inspecciones.totalunidadesrechazadas"/> -->

                                                </td>
                                            </tr>
                                             <tr>
                                                <th>=</th>
                                                <td>
                                                    <input type="text"
                                                    placeholder="Total"
                                                    id="totalprods"
                                                    disabled
                                                    class="form-control form-control-sm"
                                                    v-model="data[0].inspecciones.ptotal"/>

                                                </td>
                                            </tr>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="sa-divider py-4"></div>

                         <div style="padding-left:1%;">
                            <div class="row">
                                <div class="col-6">
                                    <table class="table table-sm mb-0">
                                        <tbody>
                                            <tr>
                                                <th>RENDIMIENTO DE MEZCLA</th>
                                                <td>
                                                    <input type="text"
                                                    @change="rendimientomezcla"
                                                    disabled
                                                    class="form-control form-control-sm"
                                                    v-model="data[0].inspecciones.ptotal"/>
                                                </td>
                                                <td>X</td>
                                                <td>
                                                    <input type="text"
                                                    @change="rendimientomezcla"
                                                    disabled
                                                    class="form-control form-control-sm"
                                                    v-model="porcentaje" />
                                                </td>
                                                <td>/</td>
                                                <td>
                                                    <input type="text"
                                                    @change="rendimientomezcla"
                                                    disabled
                                                    class="form-control form-control-sm"
                                                    v-model="capacidad" />
                                                </td>
                                                <td>=</td>
                                                <td>
                                                    <input type="text"
                                                    disabled
                                                    class="form-control form-control-sm"
                                                    v-model="data[0].inspecciones.rendimientomezcla" />
                                                </td>
                                                <td>%</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                         <div class="sa-divider py-4"></div>

                         <div style="padding-left:1%;">
                            <div class="row">
                                <div class="col-4">
                                    <table class="table table-sm mb-0">
                                        <tbody>
                                            <tr>
                                                <th>CONSUMO DE BOBINA  </th>
                                                <td>
                                                    <input type="text"
                                                    placeholder="Automático desde Empaque"
                                                    class="form-control form-control-sm"
                                                    disabled
                                                    v-model="data[0].inspecciones.consumobobina" />
                                                </td>
                                            </tr>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                         <div class="text-end">
                            <div class="col-auto">
                                <button type="button" v-if="data[0].inspecciones.estado == 5" class="btn btn-dark" @click="generatedReport"><i class="bi bi-file-earmark-pdf"></i> Generar Reporte</button>
                                <button
                                  type="button"
                                  :disabled="(data[0].inspecciones.estado != 0 && data[0].inspecciones.estado != 2) || isSaving"
                                  v-if="data[0].user.rolname=='PROD'"
                                  @click="saveOrUpdate"
                                  class="btn btn-success"
                                  :title="data[0].inspecciones.estado == 1 ? 'Esperando verificación del supervisor' : (data[0].inspecciones.estado == 3 ? 'Esperando finalización de calidad' : 'Guardar')"
                                >Guardar</button>
                                <!-- <button type="button" :disabled="data[0].inspecciones.estado != 1 && data[0].inspecciones.estado != 3" v-if="data[0].user.rolname=='CL' || data[0].user.rolname=='SPROD'" @click="approved('verificar')" class="btn btn-success">Verificar</button>
                                <button type="button" :disabled="data[0].inspecciones.estado != 2 && data[0].inspecciones.estado != 4" v-if="data[0].user.rolname=='CL' || data[0].user.rolname=='ACL'" @click="approved('finalizar')" class="btn btn-warning">Finalizar</button> -->
                                <button type="button" :disabled="data[0].inspecciones.estado != 1 && data[0].inspecciones.estado != 3" v-if="data[0].user.rolname=='SPROD'" @click="approved('verificar')" class="btn btn-success">Verificar</button>
                                <button type="button" :disabled="data[0].inspecciones.estado != 2 && data[0].inspecciones.estado != 4" v-if="data[0].user.rolname=='ACL'" @click="approved('finalizar')" class="btn btn-warning">Finalizar</button>
                                <!-- <button type="button" :disabled="data[0].inspecciones.estado != 5" v-if="data[0].user.rolname=='CL' || data[0].user.rolname=='SPROD'" @click="approved('autorizar')" class="btn btn-secondary">Autorizar</button> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
</template>

<script>
const { upsertInspecciones, approveInspecciones } = require("../service.js");
   import { VueMaskDirective } from 'v-mask'
    Vue.directive('mask', VueMaskDirective);
export default {
  props: {
    source: { type: [Object, Array], required: true },
  },
  data: function () {
    return {
      data: Array.isArray(this.source) ? this.source : [],
      reporte:false,
      porcentaje: 100,
      capacidad: 0,
      isSaving: false,
      FLAGS: {
        PACKING_AUTORIZED: 3,
        PACKING_FINALIZED: 4
      }
    };
  },

    mounted(){

        this.cargarDatosTanque();
         // 🔹 Establecer capacidad desde el backend si existe
        if (this.data[0].inspecciones && this.data[0].inspecciones.capacidad) {
            this.capacidad = parseInt(this.data[0].inspecciones.capacidad);
        }

        // 🔹 Asegurar que uxc esté presente
        if (!this.data[0].inspecciones.uxc) {
            this.data[0].inspecciones.uxc = 0;
        }
        if(this.data[0].user.rolname == 'PROD' && this.data[0].inspecciones.estado == 0 ){
            this.data[0].inspecciones.opmaquinaconxtanque1 = this.data[0].user.username
        }
        if(this.data[0].user.rolname == 'PROD' && this.data[0].inspecciones.estado == 2 ){
            this.data[0].inspecciones.opmaquinaconxtanque2 = this.data[0].user.username
        }
        if(this.data[0].user.rolname == 'ACL' && !this.data[0].inspecciones.ctrlcalidadconxtanque1 ){
            this.data[0].inspecciones.ctrlcalidadconxtanque1 = this.data[0].user.username
        }
        if(this.data[0].user.rolname == 'ACL' && !this.data[0].inspecciones.ctrlcalidadconxtanque2 && this.data[0].inspecciones.estado >=3 ){
            this.data[0].inspecciones.ctrlcalidadconxtanque2 = this.data[0].user.username
        }
        if(this.data[0].user.rolname == 'SPROD' && !this.data[0].inspecciones.supervisorconxtanque1){
            this.data[0].inspecciones.supervisorconxtanque1 = this.data[0].user.username
        }
        if(this.data[0].user.rolname == 'SPROD' && !this.data[0].inspecciones.supervisorconxtanque2 && this.data[0].inspecciones.estado >= 3 ){
            this.data[0].inspecciones.supervisorconxtanque2 = this.data[0].user.username
        }
    },


    methods: {
    cargarDatosTanque() {
        if (!this.data[0].tanque) return;
        const t = this.data[0].tanque;

        // 🔄 Si hay una reconexión autorizada (estado 3), se usan esos datos como primordiales
        const usaReconexion = (t.reconexion_estado === 3);

        this.data[0].inspecciones = {
            ...this.data[0].inspecciones,
            fechahoraconxtanque1: this.formatDateTimeLocal(usaReconexion ? t.reconexion_fecha_hora : t.fecha_hora),
            lote: (usaReconexion ? t.reconexion_lote : t.lote) || '',
            tanque: (usaReconexion ? t.reconexion_numero_tanque : t.numero_tanque) || '',
            opmaquinaconxtanque1: (usaReconexion ? t.reconexion_operaria : t.operaria) || '',
            supervisorconxtanque1: (usaReconexion ? t.reconexion_supervisor : t.supervisor) || '',
            ctrlcalidadconxtanque1: (usaReconexion ? t.reconexion_control_calidad : t.control_calidad) || '',
        };
    },

    formatDateTimeLocal(dateStr) {
        if (!dateStr) return "";
        const date = new Date(dateStr);
        if (isNaN(date)) return ""; // Fecha inválida
        const year = date.getFullYear();
        const month = String(date.getMonth() + 1).padStart(2, '0');
        const day = String(date.getDate()).padStart(2, '0');
        const hours = String(date.getHours()).padStart(2, '0');
        const minutes = String(date.getMinutes()).padStart(2, '0');
        return `${year}-${month}-${day}T${hours}:${minutes}`;
    },

    // formatDate(dateStr) {
    //     if (!dateStr) return "";
    //     let date = new Date(dateStr);
    //     return date.toISOString().split("T")[0]; // Devuelve "YYYY-MM-DD"
    // },

    formatDate(dateStr) {
      if (!dateStr) return "";
      try {
        // Handle different date formats
        let date;
        
        // Check if it's in DD-MM-YYYY format
        if (typeof dateStr === 'string' && dateStr.includes('-') && dateStr.split('-')[0].length === 2) {
          const parts = dateStr.split('-');
          if (parts.length === 3) {
            // Convert DD-MM-YYYY to YYYY-MM-DD
            date = new Date(parts[2], parts[1] - 1, parts[0]);
          } else {
            date = new Date(dateStr);
          }
        } else {
          date = new Date(dateStr);
        }
        
        if (isNaN(date.getTime())) return ""; // Invalid date
        return date.toISOString().split("T")[0]; // Returns "YYYY-MM-DD"
      } catch (error) {
        console.error('Error formatting date:', error);
        return "";
      }
    },

        isEnabledSection: function(section){
            if(section == 'A'){
                return this.data[0].order.status == this.FLAGS.PACKING_AUTORIZED;
            }else if(section == 'B'){
                return this.data[0].order.status == this.FLAGS.PACKING_FINALIZED;
            }else{
                return false;
            }
        },
            sumarcantidad(){
               var pt = this.data[0].inspecciones.pt ? parseInt(this.data[0].inspecciones.pt) : 0;
               var valor1 = this.data[0].inspecciones.rechazadoscantidadund1 ? parseInt(this.data[0].inspecciones.rechazadoscantidadund1) : 0;
               var valor2 = this.data[0].inspecciones.rechazadoscantidadund2 ? parseInt(this.data[0].inspecciones.rechazadoscantidadund2) : 0;
               var valor3 = this.data[0].inspecciones.rechazadoscantidadund3 ? parseInt(this.data[0].inspecciones.rechazadoscantidadund3) : 0;
               var valor4 = this.data[0].inspecciones.rechazadoscantidadund4 ? parseInt(this.data[0].inspecciones.rechazadoscantidadund4) : 0;
               var suma = valor1 + valor2 + valor3 + valor4;
               this.data[0].inspecciones.totalunidadesrechazadas = suma;
               this.data[0].inspecciones.ptotal = suma + pt;
               this.rendimientomezcla();
            },

            sumarkilogramos(){
               var valor1 = this.data[0].inspecciones.vacioscantidadkgs1 ? parseFloat(this.data[0].inspecciones.vacioscantidadkgs1) : 0;
               var valor2 = this.data[0].inspecciones.vacioscantidadkgs2 ? parseFloat(this.data[0].inspecciones.vacioscantidadkgs2) : 0;
               var valor3 = this.data[0].inspecciones.vacioscantidadkgs3 ? parseFloat(this.data[0].inspecciones.vacioscantidadkgs3) : 0;
               var valor4 = this.data[0].inspecciones.vacioscantidadkgs4 ? parseFloat(this.data[0].inspecciones.vacioscantidadkgs4) : 0;
               var suma = valor1 + valor2 + valor3 + valor4;
               this.data[0].inspecciones.totalkilogramosvacios = suma;
            },
        //    totalproductos() {
        //         const insp = this.data[0].inspecciones;

        //         const cajas = insp.productoterminado1 ? parseInt(insp.productoterminado1) : 0;
        //         const unidadesSueltas = insp.productoterminado2 ? parseInt(insp.productoterminado2) : 0;
        //         const rechazados = insp.totalunidadesrechazadas ? parseInt(insp.totalunidadesrechazadas) : 0;
        //         const uxc = insp.uxc ? parseFloat(insp.uxc) : 0;

        //         // 🔹 Calcular PT real: Cajas * uxc + unidades sueltas
        //         const pt = (cajas * uxc) + unidadesSueltas;
        //         insp.pt = pt;

        //         // 🔹 Calcular total (PT + Rechazados)
        //         insp.ptotal = pt + rechazados;

        //         this.rendimientomezcla();
        //     },


            totalproductos(){
               var pr = this.data[0].inspecciones.totalunidadesrechazadas ? parseInt(this.data[0].inspecciones.totalunidadesrechazadas) : 0;
               var pt = this.data[0].inspecciones.pt ? parseInt(this.data[0].inspecciones.pt) : 0;
               var suma = pt + pr;
               this.data[0].inspecciones.ptotal = suma;
               this.rendimientomezcla();
            },
            rendimientomezcla(){
               var productos = this.data[0].inspecciones.ptotal ? parseInt(this.data[0].inspecciones.ptotal) : 0;
               var capacidad = parseInt(this.capacidad);
               var porcentaje = parseInt(this.porcentaje);
               this.data[0].inspecciones.rendimientomezcla = Number((productos*porcentaje)/capacidad).toFixed(2);
            },

            saveOrUpdate: async function(){

                if (this.isSaving) return;

                var data = {
                    num_id : this.data[0].order.num_id,
                    packing_id : this.data[0].order.id,
                    lote : this.data[0].order.lot_num,
                    tanque : this.data[0].inspecciones.tanque,
                    fechahoraconxtanque1 : this.data[0].inspecciones.fechahoraconxtanque1,
                    fechahoraconxtanque2 : this.data[0].inspecciones.fechahoraconxtanque2,
                    supervisorconxtanque1 : this.data[0].inspecciones.supervisorconxtanque1,
                    supervisorconxtanque2 : this.data[0].inspecciones.supervisorconxtanque2,
                    ctrlcalidadconxtanque1 : this.data[0].inspecciones.ctrlcalidadconxtanque1,
                    ctrlcalidadconxtanque2 : this.data[0].inspecciones.ctrlcalidadconxtanque2,
                    opmaquinaconxtanque1 : this.data[0].inspecciones.opmaquinaconxtanque1,
                    opmaquinaconxtanque2 : this.data[0].inspecciones.opmaquinaconxtanque2,
                    rechazadosfecha1 : this.data[0].inspecciones.rechazadosfecha1,
                    rechazadosfecha2 : this.data[0].inspecciones.rechazadosfecha2,
                    rechazadosfecha3 : this.data[0].inspecciones.rechazadosfecha3,
                    rechazadosfecha4 : this.data[0].inspecciones.rechazadosfecha4,
                    rechazadoscantidadund1 : this.data[0].inspecciones.rechazadoscantidadund1,
                    rechazadoscantidadund2 : this.data[0].inspecciones.rechazadoscantidadund2,
                    rechazadoscantidadund3 : this.data[0].inspecciones.rechazadoscantidadund3,
                    rechazadoscantidadund4 : this.data[0].inspecciones.rechazadoscantidadund4,
                    totalunidadesrechazadas : this.data[0].inspecciones.totalunidadesrechazadas,
                    vaciosfecha1 : this.data[0].inspecciones.vaciosfecha1,
                    vaciosfecha2 : this.data[0].inspecciones.vaciosfecha2,
                    vaciosfecha3 : this.data[0].inspecciones.vaciosfecha3,
                    vaciosfecha4 : this.data[0].inspecciones.vaciosfecha4,
                    vacioscantidadkgs1 : this.data[0].inspecciones.vacioscantidadkgs1,
                    vacioscantidadkgs2 : this.data[0].inspecciones.vacioscantidadkgs2,
                    vacioscantidadkgs3 : this.data[0].inspecciones.vacioscantidadkgs3,
                    vacioscantidadkgs4 : this.data[0].inspecciones.vacioscantidadkgs4,
                    totalkilogramosvacios : this.data[0].inspecciones.totalkilogramosvacios,
                    productoterminado1 : this.data[0].inspecciones.productoterminado1,
                    productoterminado2 : this.data[0].inspecciones.productoterminado2,
                    pt : this.data[0].inspecciones.pt,
                    ptotal : this.data[0].inspecciones.ptotal,
                    capacidad : this.capacidad,
                    rendimientomezcla : this.data[0].inspecciones.rendimientomezcla,
                    consumobobina : this.data[0].inspecciones.consumobobina
                }


                // 🛑 Bloquear si hay reconexión en curso
                if (this.data[0].tanque && this.data[0].tanque.reconexion_estado > 0 && this.data[0].tanque.reconexion_estado < 3) {
                    StatusHandler.ShowStatus("No se puede guardar la inspección mientras hay una reconexión a tanque en proceso de autorización.", StatusHandler.OPERATION.DEFAULT, StatusHandler.STATUS.FAIL);
                    return;
                }

                const confirm = await StatusHandler.Confirm("¿Desea realizar esta acción?");
                if (!confirm) return;

                this.isSaving = true;
                StatusHandler.LShow();

                upsertInspecciones(data).then(result=>{
                    let response = result.data;
                    if(response.code == 0){
                        this.isSaving = false;
                        StatusHandler.ShowStatus(response.msg,StatusHandler.OPERATION.DEFAULT,StatusHandler.STATUS.FAIL);
                        return;
                    }else{
                        this.data[0].inspecciones.estado = 1;
                    }
                    //this.data = response.data;
                    StatusHandler.LClose();
                    StatusHandler.ShowStatus("!Acción Existosa!",StatusHandler.OPERATION.CREATE,StatusHandler.STATUS.SUCCESS);
                }).catch(ex=>{
                    this.isSaving = false;
                    StatusHandler.LClose();
                    StatusHandler.Exception("Ocurrió un error",ex);
                })
            },

            approved: async function(action){
               var confirm = await StatusHandler.Confirm("¿Desea realizar esta acción?");
                if(!confirm)return;

                // 🛑 Bloquear si hay reconexión en curso
                if (this.data[0].tanque && this.data[0].tanque.reconexion_estado > 0 && this.data[0].tanque.reconexion_estado < 3) {
                    StatusHandler.ShowStatus("No se puede realizar esta acción mientras hay una reconexión a tanque en proceso de autorización.", StatusHandler.OPERATION.DEFAULT, StatusHandler.STATUS.FAIL);
                    return;
                }

                StatusHandler.LShow();

                approveInspecciones(this.data[0].order.id, action).then(result=>{
                    let response = result.data;
                    if(response.code == 0){
                        StatusHandler.ShowStatus(response.msg,StatusHandler.OPERATION.DEFAULT,StatusHandler.STATUS.FAIL);
                        return;
                    }else{
                        if(this.data[0].inspecciones.estado == 1 && action == 'verificar'){
                            this.data[0].inspecciones.estado = 2;
                        }else if(this.data[0].inspecciones.estado == 3 && action == 'verificar'){
                            this.data[0].inspecciones.estado = 4;
                        }else if((this.data[0].inspecciones.estado == 2 || this.data[0].inspecciones.estado == 4) && action == 'finalizar'){
                            this.data[0].inspecciones.estado = 5;
                            this.data[0].inspecciones.ctrlcalidadconxtanque1 = this.data[0].user.username;
                        }else if(this.data[0].inspecciones.estado == 5 && action == 'autorizar'){
                            this.data[0].inspecciones.estado = 6;
                        }else{
                            this.data[0].inspecciones.estado = this.data[0].inspecciones.estado;
                        }
                    }
                    //this.data = response.data;
                    StatusHandler.LClose();
                    StatusHandler.ShowStatus("!Acción Existosa!",StatusHandler.OPERATION.CREATE,StatusHandler.STATUS.SUCCESS);
                }).catch(ex=>{
                    StatusHandler.LClose();
                    StatusHandler.Exception("Ocurrió un error",ex);
                })
            },

            generatedReport: function(){
            var open_url = window.location.origin + `/report/inspeccionescalidad/${this.data[0].order.num_id}`;
            window.open(open_url, '_blank').focus();
            },
  },
};
</script>
