<style scoped>
.table-responsive {
    display: block;
    width: 100%;
    overflow-x: auto;
  }

  table {
    width: 100%;
    border-collapse: collapse;
  }

  th, td {
    white-space: nowrap;
    text-align: center;
  }

  @media screen and (max-width: 768px) {
    th, td {
      font-size: 8px;
    }

    input {
      max-width: 50px;
      font-size: 8px;
    }
  }

table, th {
  border: 1px solid black;
  border-collapse: collapse;
}

input[type="checkbox"] {
  cursor: pointer;
  -webkit-appearance: none;
  -moz-appearance: none;
  appearance: none;
  outline: 0;
  background: lightgray;
  height: 16px;
  width: 16px;
  border: 1px solid white;
}

input[type="checkbox"]:checked {
  background: #2aa1c0;
}

input[type="checkbox"]:hover {
  filter: brightness(90%);
}

input[type='checkbox'][disabled][checked] {
  background: #2aa1c0;
}



input[type="checkbox"]:after {
  content: '';
  position: relative;
  left: 40%;
  top: 20%;
  width: 15%;
  height: 40%;
  border: solid #fff;
  border-width: 0 2px 2px 0;
  transform: rotate(45deg);
  display: none;
}

input[type="checkbox"]:checked:after {
  display: block;
}

input[type="checkbox"]:disabled:after {
  border-color: #7b7b7b;
}
</style>


<template>

  <div class="container pb-6">
    <!--HERE INIT CONTENT SECTION-->
    <div class="py-5">
      <div class="row g-4 align-items-center">
        <div class="col">
          <h1 class="h3 m-0">
            Orden de Producción #{{ data[0].order.num_id }}
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

          <div class="row">
            <div class="col">
              <u><h4 class=" m-0" style="text-align:center;">ICC LABORATORIES</h4></u>
              <br>
              <u><h4 class=" m-0" style="text-align:center;">HOJA DE CONTROLES EN PROCESO (PESO Y VOLUMEN)</h4></u>
            </div>
          </div>


        <table style="border:none; width:100%">

          <tr>

            <td><label for="nomprod" class="form-label">NOMBRE DEL PRODUCTO:</label><input type="text" :disabled="true"  v-model="data[0].order.product_name"  class="form-control" id="nomprod"></td>

            <td><label for="lote" class="form-label">LOTE:</label><input type="text" :disabled="true"  v-model="data[0].order.lot_num"  class="form-control" id="lote"></td>

            <td><label for="oproduccion" class="form-label">ORDEN DE PRODUCCIÓN:</label><input type="text" :disabled="true"   v-model="data[0].order.num_id"  class="form-control" id="oproduccion"></td>
            <!-- <td><label for="presentacion" class="form-label">PRESENTACION:</label><input type="text" :disabled="data[0].controles.seccion == 25 || data[0].user.rolname!='PROD'"   v-model="data[0].order.presentacion_sap"  class="form-control" id="presentacion"></td> -->
            <td><label for="presentacion" class="form-label">PRESENTACION:</label>
            <input type="text"
              disabled
              v-model="presentacionValue"
              class="form-control"
              id="presentacion">

            </td>

          </tr>

          <!-- <tr>
            <td><label for="vmaximo" class="form-label">VOLUMEN MÁXIMO:</label><input type="text" :disabled="data[0].controles.seccion == 50 || data[0].user.rolname!='PROD'"   placeholder="##.##"   v-model="data[0].controles.vmaximo"  class="form-control" id="vmaximo"></td>
            <td><label for="voptimo" class="form-label">VOLUMEN ÓPTIMO:</label><input type="text" :disabled="data[0].controles.seccion == 50 || data[0].user.rolname!='PROD'"   placeholder="##.##"  v-model="data[0].controles.voptimo"  class="form-control" id="voptimo"></td>
            <td><label for="vminimo" class="form-label">VOLUMEN MÍNIMO:</label><input type="text" :disabled="data[0].controles.seccion == 50 || data[0].user.rolname!='PROD'"   placeholder="##.##"  v-model="data[0].controles.vminimo"  class="form-control" id="vminimo"></td>
          </tr> -->

          <tr>
            <td><label for="vmaximo" class="form-label">VOLUMEN MÁXIMO:</label><input type="text" disabled placeholder="##.##"   v-model="data[0].controles.vmaximo"  class="form-control" id="vmaximo"></td>
            <td><label for="voptimo" class="form-label">VOLUMEN ÓPTIMO:</label><input type="text" disabled placeholder="##.##"  v-model="data[0].controles.voptimo"  class="form-control" id="voptimo"></td>
            <td><label for="vminimo" class="form-label">VOLUMEN MÍNIMO:</label><input type="text" disabled placeholder="##.##"  v-model="data[0].controles.vminimo"  class="form-control" id="vminimo"></td>
          </tr>

          <tr>
            <td><label for="pmaximo" class="form-label">PESO MÁXIMO:</label><input type="text" :disabled="data[0].controles.seccion == 25 || data[0].user.rolname!='PROD'"   placeholder="##.##"  v-model="data[0].controles.pmaximo"  class="form-control" id="pmaximo"></td>
            <td><label for="poptimo" class="form-label">PESO ÓPTIMO:</label><input type="text" :disabled="data[0].controles.seccion == 25 || data[0].user.rolname!='PROD'"   placeholder="##.##"  v-model="data[0].controles.poptimo"  class="form-control" id="poptimo"></td>
            <td><label for="pminimo" class="form-label">PESO MÍNIMO:</label><input type="text" :disabled="data[0].controles.seccion == 25 || data[0].user.rolname!='PROD'"   placeholder="##.##"  v-model="data[0].controles.pminimo"  class="form-control" id="pminimo"></td>
          </tr>

          <tr>

                    <label for="fecharealizada" class="form-label"
                      >FECHA: </label
                    ><input
                      type="text"
                      class="form-control"
                      :disabled="data[0].controles.seccion == 25 || data[0].user.rolname!='PROD'"
                      v-model="data[0].controles.fecharealizada"
                      v-mask="'##/##/####'"
                      placeholder="DD/MM/YYYY"
                      id="fecharealizada"
                    />

          </tr>
          <br>


        </table>
        <!-- Grafica -->
          <div class="card mb-4">
            <div class="card-body h-[300px]">
              <canvas id="pesoChart" class="w-full h-full"></canvas>
            </div>
          </div>

<br>
          <div class="card p-4">
            <div class="table-responsive p-8">
          <table >

            <thead>

              <tr>

                <th style="font-size:11px;">Hora</th>
                <th v-for="index in 25" :key="'h-' + index" style="text-align:center; font-size:9px;">
                    <input style="width: 90%;" type="text" v-model="data[0].controles.horas[index-1]"
                     v-mask="'##:##'"
                    @input="validateTimeFormat(index - 1)"
                    :disabled="data[0].user.rolname !== 'PROD' || data[0].controles.seccion !== (index - 1) || index === 25"
                    maxlength="5" placeholder="HH:MM" />
                </th>

              </tr>

              <!-- <tr>

                <th style="text-align:center; font-size:11px;" colspan="26">PESO/VOLUMEN</th>

              </tr> -->

              <!-- <tr>
                <th style="text-align:center; font-size:9px;" rowspan="2">MÁXIMO<br>{{data[0].controles.pmaximo}}</th>
                <th style="text-align:center; font-size:9px;" v-for="index in 25" :key="index" >
                    <input style="width: 90%;" v-if="data[0].controles.seccion == (index-1)" type="text" size="1" :disabled="data[0].user.rolname!='PROD'" v-bind:style=" (data[0].controles.m1[index-1] >= data[0].controles.pminimo && data[0].controles.m1[index-1] <= data[0].controles.pmaximo) ? 'color: black;' : 'color: red;' "  v-model="data[0].controles.m1[index-1]">
                    <h1 style="font-size:10px; color: #0000FF; font-weight: bold;" v-else-if="data[0].controles.seccion != (index-1) && data[0].controles.m1[index-1]!=null">{{data[0].controles.m1[index-1]}}</h1>
                    <h1 style="font-size:10px; color: #0000FF;" v-else></h1>
                </th>
              </tr>
              <tr>
                  <th style="text-align:center; font-size:9px;" v-for="index in 25" :key="index" >
                    <input style="width: 90%;" v-if="data[0].controles.seccion == (index-1)" type="text" size="1" :disabled="data[0].user.rolname!='PROD'" v-bind:style=" (data[0].controles.m2[index-1] >= data[0].controles.vminimo && data[0].controles.m2[index-1] <= data[0].controles.vmaximo) ? 'color: black;' : 'color: red;' "   v-model="data[0].controles.m2[index-1]">
                    <h1 style="font-size:10px; color: #0000FF; font-weight: bold;" v-else-if="data[0].controles.seccion != (index-1) && data[0].controles.m2[index-1]!=null">{{data[0].controles.m2[index-1]}}</h1>
                    <h1 style="font-size:10px; color: #0000FF;" v-else></h1>
                  </th>
              </tr>

              <tr>
                <th style="text-align:center; font-size:9px;" rowspan="2">ÓPTIMO<br>{{data[0].controles.poptimo}}</th>
                <th style="text-align:center; font-size:9px;" v-for="index in 25" :key="index" >
                    <input style="width: 90%;" v-if="data[0].controles.seccion == (index-1)" type="text" size="1" :disabled="data[0].user.rolname!='PROD'"  v-bind:style=" (data[0].controles.m3[index-1] >= data[0].controles.pminimo && data[0].controles.m3[index-1] <= data[0].controles.pmaximo) ? 'color: black;' : 'color: red;' "  v-model="data[0].controles.m3[index-1]">
                    <h1 style="font-size:10px; color: #0000FF; font-weight: bold;" v-else-if="data[0].controles.seccion != (index-1) && data[0].controles.m3[index-1]!=null">{{data[0].controles.m3[index-1]}}</h1>
                    <h1 style="font-size:10px; color: #0000FF;" v-else></h1>
                </th>
              </tr>
              <tr>
                  <th style="text-align:center; font-size:9px;" v-for="index in 25" :key="index" >
                    <input style="width: 90%;" v-if="data[0].controles.seccion == (index-1)" type="text" size="1" :disabled="data[0].user.rolname!='PROD'" v-bind:style=" (data[0].controles.m4[index-1] >= data[0].controles.vminimo && data[0].controles.m4[index-1] <= data[0].controles.vmaximo) ? 'color: black;' : 'color: red;' "   v-model="data[0].controles.m4[index-1]">
                    <h1 style="font-size:10px; color: #0000FF; font-weight: bold;" v-else-if="data[0].controles.seccion != (index-1) && data[0].controles.m4[index-1]!=null">{{data[0].controles.m4[index-1]}}</h1>
                    <h1 style="font-size:10px; color: #0000FF;" v-else></h1>
                  </th>
              </tr>

              <tr>
                <th style="text-align:center; font-size:9px;" rowspan="2">MÍNIMO<br>{{data[0].controles.pminimo}}</th>
                <th style="text-align:center; font-size:9px;" v-for="index in 25" :key="index" >
                    <input style="width: 90%;" v-if="data[0].controles.seccion == (index-1)" type="text" size="1" :disabled="data[0].user.rolname!='PROD'" v-bind:style=" (data[0].controles.m5[index-1] >= data[0].controles.pminimo && data[0].controles.m5[index-1] <= data[0].controles.pmaximo) ? 'color: black;' : 'color: red;' "   v-model="data[0].controles.m5[index-1]">
                    <h1 style="font-size:10px; color: #0000FF; font-weight: bold;" v-else-if="data[0].controles.seccion != (index-1) && data[0].controles.m5[index-1]!=null">{{data[0].controles.m5[index-1]}}</h1>
                    <h1 style="font-size:10px; color: #0000FF;" v-else></h1>
                </th>
              </tr> -->
              <!-- <tr>
                  <th style="text-align:center; font-size:9px;" v-for="index in 25" :key="index" >
                    <input style="width: 90%;" v-if="data[0].controles.seccion == (index-1)" type="text" size="1" :disabled="data[0].user.rolname!='PROD'" v-bind:style=" (data[0].controles.m6[index-1] >= data[0].controles.vminimo && data[0].controles.m6[index-1] <= data[0].controles.vmaximo) ? 'color: black;' : 'color: red;' "   v-model="data[0].controles.m6[index-1]">
                    <h1 style="font-size:10px; color: #0000FF; font-weight: bold;" v-else-if="data[0].controles.seccion != (index-1) && data[0].controles.m6[index-1]!=null">{{data[0].controles.m6[index-1]}}</h1>
                    <h1 style="font-size:10px; color: #0000FF;" v-else></h1>
                  </th>
              </tr> -->

              <tr>
                <th style="text-align:center; font-size:9px;">PESO/VOLUMEN REAL</th>
                <th style="text-align:center; font-size:9px;" v-for="index in 25" :key="index" >
                    <!-- <input style="width: 90%;" v-if="data[0].controles.seccion == (index-1)" type="text" size="1" :disabled="data[0].user.rolname!='PROD'"   v-model="data[0].controles.m7[index-1]"> -->
                     <input
                        style="width: 90%;"
                        v-if="data[0].controles.seccion == (index-1) && index !== 25"
                        type="text"
                        size="1"
                        :disabled="data[0].user.rolname!='PROD'"
                        v-model="data[0].controles.m7[index-1]"
                        @input="actualizarPesosPorHora(index - 1)"
                      >
                    <h1 style="font-size:10px; color: #0000FF; font-weight: bold;" v-else-if="data[0].controles.seccion != (index-1) && data[0].controles.m7[index-1]!=null">{{data[0].controles.m7[index-1]}}</h1>
                    <h1 style="font-size:10px; color: #0000FF;" v-else></h1>
                </th>
              </tr>

              <tr>
                <th style="text-align:center; font-size:9px;">REALIZÓ</th>
                <th style="text-align:center; font-size:9px;" v-for="index in 25" :key="index">
                    <input type="text" v-model="data[0].controles.realizo[index-1]" readonly
                           style="min-width: 20px; width: auto; text-align: center; font-size: 9px; border: 1px solid #ddd;">
                </th>
            </tr>

            <tr>
                <th style="text-align:center; font-size:9px;">VERIFICÓ</th>
                <th style="text-align:center; font-size:9px;" v-for="index in 25" :key="index">
                    <input type="text" v-model="data[0].controles.verifico[index-1]" readonly
                           style="min-width: 20px; width: auto; text-align: center; font-size: 9px; border: 1px solid #ddd;">
                </th>
            </tr>

            </thead>

            <tbody>

            </tbody>

          </table>
            </div>
          <br>

                    <!-- <label for="fecharealizada2" class="form-label"
                      >FECHA: </label
                    ><input
                      type="text"
                      class="form-control"
                      :disabled="data[0].controles.seccion == 50 || data[0].user.rolname!='PROD'"
                      v-model="data[0].controles.fecharealizada2"
                      v-mask="'##/##/####'"
                      placeholder="DD/MM/YYYY"
                      id="fecharealizada2"
                    /> -->
          <br>
          <div class="table-responsive">
          <table>

            <thead>

              <!-- <tr>

                <th style="font-size:11px;">Hora</th>
                <th v-for="index in 25" :key="'h2-' + (index + 25)" style="text-align:center; font-size:9px;">
                    <input style="width: 90%;" type="text" v-model="data[0].controles.horas[index + 24]"
                    v-mask="'##:##'"
                    @input="validateTimeFormat(index + 24)"
                    :disabled="data[0].user.rolname !== 'PROD' || data[0].controles.seccion !== (index + 24)"
                    maxlength="5" placeholder="HH:MM" />
                </th>

              </tr>

              <tr>

                <th style="text-align:center; font-size:11px;" colspan="26">PESO/VOLUMEN</th>

              </tr>

              <tr>
                <th style="text-align:center; font-size:9px;" rowspan="2">MÁXIMO</th>
                <th style="text-align:center; font-size:9px;" v-for="index in 25" :key="index" >
                    <input style="width: 90%;" v-if="data[0].controles.seccion == (index+24)" type="text" size="1" :disabled="data[0].user.rolname!='PROD'" v-bind:style=" (data[0].controles.t1[index-1] >= data[0].controles.pminimo && data[0].controles.t1[index-1] <= data[0].controles.pmaximo) ? 'color: black;' : 'color: red;' "   v-model="data[0].controles.t1[index-1]">
                    <h1 style="font-size:10px; color: #0000FF; font-weight: bold;" v-else-if="data[0].controles.seccion != (index+24) && data[0].controles.t1[index-1]!=null">{{data[0].controles.t1[index-1]}}</h1>
                    <h1 style="font-size:10px; color: #0000FF;" v-else></h1>
                </th>
              </tr>
              <tr>
                  <th style="text-align:center; font-size:9px;" v-for="index in 25" :key="index" >
                    <input style="width: 90%;" v-if="data[0].controles.seccion == (index+24)" type="text" size="1" :disabled="data[0].user.rolname!='PROD'" v-bind:style=" (data[0].controles.t2[index-1] >= data[0].controles.vminimo && data[0].controles.t2[index-1] <= data[0].controles.vmaximo) ? 'color: black;' : 'color: red;' "   v-model="data[0].controles.t2[index-1]">
                    <h1 style="font-size:10px; color: #0000FF; font-weight: bold;" v-else-if="data[0].controles.seccion != (index+24) && data[0].controles.t2[index-1]!=null">{{data[0].controles.t2[index-1]}}</h1>
                    <h1 style="font-size:10px; color: #0000FF;" v-else></h1>
                  </th>
              </tr>

              <tr>
                <th style="text-align:center; font-size:9px;" rowspan="2">ÓPTIMO</th>
                <th style="text-align:center; font-size:9px;" v-for="index in 25" :key="index" >
                    <input style="width: 90%;" v-if="data[0].controles.seccion == (index+24)" type="text" size="1" :disabled="data[0].user.rolname!='PROD'" v-bind:style=" (data[0].controles.t3[index-1] >= data[0].controles.pminimo && data[0].controles.t3[index-1] <= data[0].controles.pmaximo) ? 'color: black;' : 'color: red;' "    v-model="data[0].controles.t3[index-1]">
                    <h1 style="font-size:10px; color: #0000FF; font-weight: bold;" v-else-if="data[0].controles.seccion != (index+24) && data[0].controles.t3[index-1]!=null">{{data[0].controles.t3[index-1]}}</h1>
                    <h1 style="font-size:10px; color: #0000FF;" v-else></h1>
                </th>
              </tr>
              <tr>
                  <th style="text-align:center; font-size:9px;" v-for="index in 25" :key="index" >
                    <input style="width: 90%;" v-if="data[0].controles.seccion == (index+24)" type="text" size="1" :disabled="data[0].user.rolname!='PROD'" v-bind:style=" (data[0].controles.t4[index-1] >= data[0].controles.vminimo && data[0].controles.t4[index-1] <= data[0].controles.vmaximo) ? 'color: black;' : 'color: red;' "    v-model="data[0].controles.t4[index-1]">
                    <h1 style="font-size:10px; color: #0000FF; font-weight: bold;" v-else-if="data[0].controles.seccion != (index+24) && data[0].controles.t4[index-1]!=null">{{data[0].controles.t4[index-1]}}</h1>
                    <h1 style="font-size:10px; color: #0000FF;" v-else></h1>
                  </th>
              </tr>

              <tr>
                <th style="text-align:center; font-size:9px;" rowspan="2">MÍNIMO</th>
                <th style="text-align:center; font-size:9px;" v-for="index in 25" :key="index" >
                    <input style="width: 90%;" v-if="data[0].controles.seccion == (index+24)" type="text" size="1" :disabled="data[0].user.rolname!='PROD'" v-bind:style=" (data[0].controles.t5[index-1] >= data[0].controles.pminimo && data[0].controles.t5[index-1] <= data[0].controles.pmaximo) ? 'color: black;' : 'color: red;' "    v-model="data[0].controles.t5[index-1]">
                    <h1 style="font-size:10px; color: #0000FF; font-weight: bold;" v-else-if="data[0].controles.seccion != (index+24) && data[0].controles.t5[index-1]!=null">{{data[0].controles.t5[index-1]}}</h1>
                    <h1 style="font-size:10px; color: #0000FF;" v-else></h1>
                </th>
              </tr>
              <tr>
                  <th style="text-align:center; font-size:9px;" v-for="index in 25" :key="index" >
                    <input style="width: 90%;" v-if="data[0].controles.seccion == (index+24)" type="text" size="1" :disabled="data[0].user.rolname!='PROD'" v-bind:style=" (data[0].controles.t6[index-1] >= data[0].controles.vminimo && data[0].controles.t6[index-1] <= data[0].controles.vmaximo) ? 'color: black;' : 'color: red;' "    v-model="data[0].controles.t6[index-1]">
                    <h1 style="font-size:10px; color: #0000FF; font-weight: bold;" v-else-if="data[0].controles.seccion != (index+24) && data[0].controles.t6[index-1]!=null">{{data[0].controles.t6[index-1]}}</h1>
                    <h1 style="font-size:10px; color: #0000FF;" v-else></h1>
                  </th>
              </tr>

              <tr>
                <th style="text-align:center; font-size:9px;">PESO/VOLUMEN REAL</th>
                <th style="text-align:center; font-size:9px;" v-for="index in 25" :key="index" >
                    <input style="width: 90%;" v-if="data[0].controles.seccion == (index+24)" type="text" size="1" :disabled="data[0].user.rolname!='PROD'"   v-model="data[0].controles.t7[index-1]">
                    <h1 style="font-size:10px; color: #0000FF; font-weight: bold;" v-else-if="data[0].controles.seccion != (index+24) && data[0].controles.t7[index-1]!=null">{{data[0].controles.t7[index-1]}}</h1>
                    <h1 style="font-size:10px; color: #0000FF;" v-else></h1>
                </th>
              </tr>

              <tr>
                <th style="text-align:center; font-size:9px;">REALIZÓ</th>
                <th style="text-align:center; font-size:9px;" v-for="index in 25" :key="index">
                    <input type="text" v-model="data[0].controles.realizo2[index-1]" readonly
                           style="min-width: 20px; width: auto; text-align: center; font-size: 9px;">
                </th>
            </tr>

            <tr>
                <th style="text-align:center; font-size:9px;">VERIFICÓ</th>
                <th style="text-align:center; font-size:9px;" v-for="index in 25" :key="index">
                    <input type="text" v-model="data[0].controles.verifico2[index-1]" readonly
                           style="min-width: 20px; width: auto; text-align: center; font-size: 9px;">
                </th>
            </tr> -->

              <tr>
                <th style="text-align:center; font-size:9px;" colspan="3">ESPECIFICACIONES</th>
                <th style="text-align:center; font-size:9px;" colspan="23">OBSERVACIONES</th>
              </tr>
              <tr>
                <th style="text-align:center; font-size:9px;" >COLOR</th>
                <th style="text-align:center; font-size:9px;" >OLOR</th>
                <th style="text-align:center; font-size:9px;" >CONSISTENCIA</th>
                <th colspan="23" rowspan="3">
                  <textarea :disabled="data[0].user.rolname!='PROD' || data[0].controles.supervisado!=null" v-model="data[0].controles.observaciones" style="width:100%"></textarea>
                </th>
              </tr>

              <tr>
                <th style="text-align:center; font-size:12px;" v-for="(item, index) in 3" :key="index">
                  <template v-if="index < 2">
                    <input style="width: 90%;" type="text" size="5"
                           :disabled="true"
                           v-model="data[0].controles.e1[index]">
                  </template>
                  <template v-else>
                    <select style="width: 90%;" v-model="data[0].controles.e1[index]"
                            :disabled="data[0].user.rolname !== 'PROD'">
                      <option value="" disabled selected>Seleccione un item</option>
                      <option value="Semi-sólido">Semi-sólido</option>
                      <option value="Viscoso">Viscoso</option>
                    </select>
                  </template>
                </th>
              </tr>
              <!-- <tr>
                <th style="text-align:center; font-size:9px;" v-for="index in 3" :key="index" >
                    <input style="width: 90%;" type="text" size="5" :disabled="data[0].user.rolname!='PROD' || data[0].controles.supervisado!=null"   v-model="data[0].controles.e2[index-1]">
                </th>
              </tr> -->
            </thead>

            <tbody>

            </tbody>

          </table>
          </div>
          <br>
          <br>
          <table style="border:none; width:100%">
          <tr>
            <td><label for="llenado" class="form-label">LLENADO POR:</label><input type="text" :disabled="true"  v-model="data[0].controles.llenado"  class="form-control  text-center" id="llenado"></td>

            <td><label for="supervisado" class="form-label">SUPERVISADO POR:</label><input type="text" :disabled="true"  v-model="data[0].controles.supervisado"  class="form-control  text-center" id="supervisado"></td>

            <td><label for="autorizado" class="form-label">AUTORIZADO POR:</label><input type="text" :disabled="true"   v-model="data[0].controles.autorizado"  class="form-control  text-center" id="autorizado"></td>

          </tr>
          </table>
          <br>
          <br>
            <div class="text-end">
              <div class="col-auto">
                <button type="button" v-if="data[0].controles.seccion ==25" @click="generatedReport" class="btn btn-dark"><i class="bi bi-file-earmark-pdf"></i> Generar Reporte</button>
                <button type="button" :disabled="data[0].controles.seccion >=25" v-if="data[0].user.rolname=='PROD'" @click="saveOrUpdate" class="btn btn-success">Guardar</button>
                <!-- <button type="button" :disabled="data[0].controles.seccion !=50" v-if="data[0].user.rolname=='SPROD'" @click="saveOrUpdate" class="btn btn-success">Confirmar</button> -->
                <!-- <button type="button" :disabled="data[0].controles.seccion !=25" v-if="data[0].user.rolname=='SPROD'" @click="saveOrUpdate" class="btn btn-success">Confirmar</button> -->
                 <button
                  type="button"
                  :disabled="data[0].controles.seccion != 25"
                  v-if="data[0].user.rolname === 'SPROD' && !data[0].controles.supervisado"
                  @click="saveOrUpdate"
                  class="btn btn-success"
                >
                  Confirmar
                </button>

                <button type="button" :disabled="data[0].controles.seccion >=24" v-if="data[0].user.rolname=='CL'" @click="saveOrUpdate" class="btn btn-success">Verificar</button>
                <button type="button" :disabled="data[0].controles.seccion >=24" v-if="data[0].user.rolname=='CL'" @click="aprovedControles('finalizar')" class="btn btn-primary">Finalizar Control</button>
                <!-- <button type="button" :disabled="data[0].controles.seccion >=25" v-if="data[0].user.rolname=='CL'" @click="finTurnoMatutino" class="btn btn-primary">Cambiar Sección</button> -->
                <button type="button" :disabled="data[0].controles.seccion ==25" v-if="data[0].user.rolname=='CL'" @click="aprovedControles('autorizar')" class="btn btn-secondary">Autorizar</button>
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

const { validateDate2, validateDateNow, convertServerDate2 } = require("../helpers.js");
const { upsertControles } = require("../service.js");
import { VueMaskDirective } from 'v-mask'
import Chart from 'chart.js';
Vue.directive('mask', VueMaskDirective);

export default {
  props: {
    source: { type: Array, required: true },
  },
  data: function () {
    return {
      data: Array.isArray(this.source) ? this.source : [this.source],
      edit_mode: false,
      reporte: false,
      horaInvalida: false,
      pesos_por_hora: [],
    };
  },
  computed: {
      presentacionValue: {
        get() {
          console.log("Presentacion: ", this.data[0].controles.presentacion);
          return this.data[0].controles.presentacion?.trim() || this.data[0].order.presentacion_sap?.trim() || '';
        },
        set(val) {
          this.data[0].order.presentacion = val; 
        }
      }
  },
  mounted() {
      try {
        const pesos = this.data[0].controles.pesos_por_hora;

        // Validación más robusta
        if (Array.isArray(pesos)) {
          this.pesos_por_hora = pesos;
        } else if (typeof pesos === 'string') {
          this.pesos_por_hora = JSON.parse(pesos);
        } else {
          this.pesos_por_hora = [];
        }
      } catch (e) {
        console.error('Error al parsear pesos_por_hora', e);
        this.pesos_por_hora = [];
      }

      this.$nextTick(() => {
        this.renderChart(); // canvas ya está en el DOM
      });
    },
  watch: {
       pesos_por_hora(newVal) {
        if (Array.isArray(newVal) && newVal.length > 0) {
          this.renderChart();
        }
      }
    },
  methods: {
    // validateTimeFormat(index) {
    //   const hora = this.data[0].controles.horas[index] || '';
    //   const regex = /^([01]\d|2[0-3]):([0-5]\d)$/
    //   if (!regex.test(hora)) {
    //     this.horaInvalida = true;
    //     StatusHandler.ShowStatus("Formato de hora inválido (HH:MM)", StatusHandler.OPERATION.DEFAULT, StatusHandler.STATUS.FAIL);
    //   } else {
    //     this.horaInvalida = false;
    //   }
    // },
    actualizarPesosPorHora(index) {
      const hora = this.data[0].controles.horas[index];
      const peso = this.data[0].controles.m7[index];

      if (!hora || peso === '' || peso === null || isNaN(peso)) return;

      const existente = this.pesos_por_hora.find(p => p.index === index);
      if (existente) {
        existente.hora = hora;
        existente.peso = parseFloat(peso);
      } else {
        this.pesos_por_hora.push({
          index,
          hora,
          peso: parseFloat(peso)
        });
      }

      this.updateChartFromJson();
    },

  updateChartFromJson() {
    if (!window.pesoChart) return;

    const labels = this.pesos_por_hora.map(p => p.hora);
    const data = this.pesos_por_hora.map(p => p.peso);

    window.pesoChart.data.labels = labels;
    window.pesoChart.data.datasets[0].data = data;
    window.pesoChart.update();
  },
 renderChart() {
      const controles = this.data?.[0]?.controles;

      if (!controles) {
        console.warn("No se encontró controles en this.data[0]");
        return;
      }

      const horas = controles.horas;
      const m7 = controles.m7;

      if (!Array.isArray(horas) || !Array.isArray(m7)) {
        console.warn("horas o m7 no son arreglos válidos.");
        return;
      }

      // Etiquetas: 25 horas o espacios en blanco
      const labels = Array.from({ length: 25 }, (_, i) => horas[i] || ` `);

      // Datos: 25 valores o null si no hay dato
      const data = Array.from({ length: 25 }, (_, i) => {
        const val = parseFloat(m7[i]);
        return !isNaN(val) ? val : null;
      });

      const pmax = parseFloat(controles.pmaximo);
      const popt = parseFloat(controles.poptimo);
      const pmin = parseFloat(controles.pminimo);

      // 🔧 Línea horizontal fija de 25 valores
      const fullLine = (value) => Array(25).fill(value);

      const ctx = document.getElementById('pesoChart')?.getContext('2d');
      if (!ctx) {
        console.error("No se encontró el canvas con id 'pesoChart'");
        return;
      }

      window.pesoChart = new Chart(ctx, {
        type: 'line',
        data: {
          labels,
          datasets: [
            {
              label: 'Peso Real',
              data,
              borderColor: '#007bff',
              backgroundColor: 'rgba(0,123,255,0.3)',
              fill: false,
              pointRadius: 4,
              borderWidth: 2,
              tension: 0,
              pointStyle: 'circle'
            },
            {
              label: 'Máximo',
              data: fullLine(pmax), // ✅ Línea completa
              borderColor: 'red',
              borderDash: [5, 5],
              fill: false,
              pointRadius: 0,
              pointStyle: 'circle'
            },
            {
              label: 'Óptimo',
              data: fullLine(popt), // ✅ Línea completa
              borderColor: 'green',
              borderDash: [5, 5],
              fill: false,
              pointRadius: 0,
              pointStyle: 'circle'
            },
            {
              label: 'Mínimo',
              data: fullLine(pmin), // ✅ Línea completa
              borderColor: 'orange',
              borderDash: [5, 5],
              fill: false,
              pointRadius: 0,
              pointStyle: 'circle'
            }
          ]
        },
        options: {
          responsive: true,
          plugins: {
            title: {
              display: true,
              text: 'Control de Peso por Hora'
            }
          },
          scales: {
            y: {
              beginAtZero: false,
              title: { display: true, text: 'Peso (g)' }
            },
            x: {
              title: { display: true, text: 'Hora' },
              ticks: {
                callback: (value, index) => labels[index] || '',
                autoSkip: false,
                maxRotation: 0,
                minRotation: 0
              }
            }
          },
          layout: {
            padding: {
              left: 50,
              right: 50
            }
          }
        }
      });
    },


   saveOrUpdate: async function(){
      let msg = "";
      let msgfecha = "";
      let msgHora = "";

    
    // ✅ Validación de hora y peso para la sección activa y siguiente
    if (['PROD', 'CL'].includes(this.data[0].user.rolname)) {
      const seccion = this.data[0].controles.seccion;

      // Limpieza de valores
      const limpiar = (v) => String(v || '').trim().replace(/[^0-9:]/g, '');
      const horaActual = limpiar(this.data[0].controles.horas[seccion]);
      const pesoActual = String(this.data[0].controles.m7[seccion] || '').trim();

      const horaSiguiente = limpiar(this.data[0].controles.horas[seccion + 1]);
      const pesoSiguiente = String(this.data[0].controles.m7[seccion + 1] || '').trim();

      const horaRegex = /^([01]\d|2[0-3]):([0-5]\d)$/;

      // Validación sección actual
      if (!horaActual) {
        msgHora += "\n • Ingrese hora en sección actual\n";
      } else if (!horaRegex.test(horaActual)) {
        msgHora += "\n • Hora inválida en sección actual (formato HH:MM 24h)\n";
      }

      if (!pesoActual) {
        msgHora += "\n • Ingrese peso real en sección actual\n";
      }

    }

      if (msgHora.length > 0) {
        StatusHandler.ShowStatus(msgHora, StatusHandler.OPERATION.DEFAULT, StatusHandler.STATUS.FAIL);
        return;
      }

      if(this.data[0].user.rolname == 'PROD'){
        // Validaciones de campos
        let lvminimo = this.data[0].controles.vminimo ? this.data[0].controles.vminimo.length : "";
        let lvoptimo = this.data[0].controles.voptimo ? this.data[0].controles.voptimo.length : "";
        let lvmaximo = this.data[0].controles.vmaximo ? this.data[0].controles.vmaximo.length : "";
        let lpminimo = this.data[0].controles.pminimo ? this.data[0].controles.pminimo.length : "";
        let lpoptimo = this.data[0].controles.poptimo ? this.data[0].controles.poptimo.length : "";
        let lpmaximo = this.data[0].controles.pmaximo ? this.data[0].controles.pmaximo.length : "";
        let lpresentacion = this.data[0].controles.presentacion ? this.data[0].controles.presentacion.length : "";
        let lfecha = this.data[0].controles.fecharealizada ? this.data[0].controles.fecharealizada.length : "";
        let lfecha2 = this.data[0].controles.fecharealizada2 ? this.data[0].controles.fecharealizada2.length : "";

        // Validación de campos obligatorios
        if(!lpminimo) msg += "Peso mínimo \n";
        if(!lpoptimo) msg += "Peso óptimo \n";
        if(!lpmaximo) msg += "Peso máximo \n";
        // if(!lpresentacion) msg += "Presentación \n";
        if(lfecha < 10) msg += "Fecha de la primera sección \n";

        // Validación de fechas
        if(lfecha === 10){
          let fec1 = validateDate2(this.data[0].controles.fecharealizada);
          if(!fec1) msgfecha += "La fecha de la primera sección es inválida \n";
          else if(!validateDateNow(convertServerDate2(fec1))) msgfecha += "La fecha de la primera sección no puede ser menor que hoy \n";
        }
      }

      // Mostrar advertencias y confirmar
      if(msg.length > 0) msg = "Los campos: \n" + msg + "están vacíos \n¿Desea realizar esta acción?";
      else msg = "¿Desea realizar esta acción?";

      if(msgfecha.length > 0) {
        StatusHandler.ShowStatus(msgfecha, StatusHandler.OPERATION.DEFAULT, StatusHandler.STATUS.FAIL);
        return;
      }

      let confirm = await StatusHandler.Confirm(msg);
      if(!confirm) return;

      StatusHandler.LShow();

      if(this.data[0].user.rolname == 'CL') this.data[0].controles.seccion += 1;
      if(this.data[0].user.rolname == 'SPROD') this.data[0].controles.supervisado = this.data[0].user.username;
      // Asignar presentación desde SAP si está vacía
      if (!this.data[0].controles.presentacion || !this.data[0].controles.presentacion.trim()) {
        this.data[0].controles.presentacion = this.data[0].order.presentacion_sap || '';
      }
      this.data[0].controles.pesos_por_hora = JSON.parse(JSON.stringify(this.pesos_por_hora));

      // Guardar datos en el servidor
      upsertControles(this.data[0]).then(result => {
        let response = result.data;
        if(response.code == 0){
          if(this.data[0].user.rolname == 'CL') this.data[0].controles.seccion -= 1;
          if(this.data[0].user.rolname == 'SPROD') this.data[0].controles.supervisado = this.data[0].user.username;
          StatusHandler.ShowStatus(response.msg, StatusHandler.OPERATION.DEFAULT, StatusHandler.STATUS.FAIL);
          return;
        }

        this.data = response.data;
        this.edit_mode = false;
        StatusHandler.LClose();
        StatusHandler.ShowStatus("¡Acción Exitosa!", StatusHandler.OPERATION.CREATE, StatusHandler.STATUS.SUCCESS);
      }).catch(ex => {
        if(this.data[0].user.rolname == 'CL') this.data[0].controles.seccion -= 1;
        if(this.data[0].user.rolname == 'SPROD') this.data[0].controles.supervisado = "";
        StatusHandler.LClose();
        StatusHandler.Exception("Ocurrió un error", ex);
      });
    },

    finTurnoMatutino: async function(){
      let confirm = await StatusHandler.Confirm("¿Desea realizar esta acción?");
      if(!confirm) return;

      StatusHandler.LShow();

      let statusactual = this.data[0].controles.seccion;
      if(this.data[0].controles.seccion < 25){
        this.data[0].controles.seccion = 25;
      } else {
        StatusHandler.ShowStatus("El turno ya fue finalizado", StatusHandler.OPERATION.DEFAULT, StatusHandler.STATUS.FAIL);
        return;
      }

      upsertControles(this.data[0]).then(result => {
        let response = result.data;
        if(response.code == 0){
          this.data[0].controles.seccion = statusactual;
          StatusHandler.ShowStatus(response.msg, StatusHandler.OPERATION.DEFAULT, StatusHandler.STATUS.FAIL);
          return;
        }

        this.data = response.data;
        this.edit_mode = false;
        StatusHandler.LClose();
        StatusHandler.ShowStatus("¡Acción Exitosa!", StatusHandler.OPERATION.DEFAULT, StatusHandler.STATUS.SUCCESS);
      }).catch(ex => {
        this.data[0].controles.seccion = statusactual;
        StatusHandler.LClose();
        StatusHandler.Exception("Ocurrió un error", ex);
      });
    },

    aprovedControles: async function(action) {
      let confirmMessage = action === 'finalizar' ? "¿Desea finalizar este control?" : "¿Desea autorizar este control?";
      let confirm = await StatusHandler.Confirm(confirmMessage);
      if (!confirm) return;

      StatusHandler.LShow();

      let statusactual = this.data[0].controles.seccion;
      let rolautorizado = this.data[0].controles.autorizado;
      let seccionActual = this.data[0].controles.seccion;

      // ✅ Verificación obligatoria antes de finalizar
      if (action === 'finalizar') {
          const controles = this.data[0].controles;
          const verifico = controles.verifico || [];
          const horas = controles.horas || [];
          const pesos = controles.m7 || [];

          const indexSeccion = parseInt(seccionActual);
          const verificador = verifico[indexSeccion];
          const horaActual = (horas[indexSeccion] || '').trim();
          const pesoActual = (pesos[indexSeccion] || '').toString().trim();

          const horaSiguiente = (horas[indexSeccion + 1] || '').trim();
          const pesoSiguiente = (pesos[indexSeccion + 1] || '').toString().trim();

          const seccionEstaLlena = horaActual && pesoActual;
          const siguienteEstaVacia = !horaSiguiente && !pesoSiguiente;

          // Solo valida "verificó" si hay datos en la sección actual y la siguiente está vacía
          if (seccionEstaLlena && siguienteEstaVacia && (!verificador || verificador.trim() === '')) {
            StatusHandler.LClose();
            StatusHandler.ShowStatus(
              `Debe completar el campo 'VERIFICÓ' para la sección ${indexSeccion + 1} antes de finalizar.`,
              StatusHandler.OPERATION.DEFAULT,
              StatusHandler.STATUS.FAIL
            );
            return;
          }

          // Avanzar
          if (indexSeccion != 24) {
            this.data[0].controles.seccion = 24;
          } else {
            this.data[0].controles.autorizado = this.data[0].user.username;
            this.data[0].controles.seccion = 25;
          }
        }



      // ✅ Autorizar directamente si está en sección 24
      else if (action === 'autorizar') {
        if (seccionActual == 24) {
          this.data[0].controles.autorizado = this.data[0].user.username;
          this.data[0].controles.seccion = 25;
        }
      }

      // 📨 Enviar cambios al servidor
      let payload = {
        ...this.data[0],
        accion: action
      };

      upsertControles(payload).then(result => {
        let response = result.data;
        if (response.code == 0) {
          this.data[0].controles.seccion = statusactual;
          StatusHandler.ShowStatus(response.msg, StatusHandler.OPERATION.DEFAULT, StatusHandler.STATUS.FAIL);
          return;
        }

        this.data = response.data;
        this.edit_mode = false;
        StatusHandler.LClose();
        StatusHandler.ShowStatus("¡Acción Exitosa!", StatusHandler.OPERATION.CREATE, StatusHandler.STATUS.SUCCESS);
      }).catch(ex => {
        this.data[0].controles.seccion = statusactual;
        this.data[0].controles.autorizado = rolautorizado;
        StatusHandler.LClose();
        StatusHandler.Exception("Ocurrió un error", ex);
      });
    },



    // aprovedControles: async function(action) {
    // let confirmMessage = action === 'finalizar' ? "¿Desea finalizar este control?" : "¿Desea autorizar este control?";
    // let confirm = await StatusHandler.Confirm(confirmMessage);
    // if (!confirm) return;

    // StatusHandler.LShow();

    // let statusactual = this.data[0].controles.seccion;
    // let rolautorizado = this.data[0].controles.autorizado;

    // if (action === 'finalizar') {
    //     if (this.data[0].controles.seccion != 24) {
    //         this.data[0].controles.seccion = 24;
    //     } else if(this.data[0].controles.seccion == 24){
    //         this.data[0].controles.autorizado = this.data[0].user.username;
    //         this.data[0].controles.seccion = 25;
    //     }
    // } else if (action === 'autorizar') {
    //     if (this.data[0].controles.seccion == 24) {
    //         this.data[0].controles.autorizado = this.data[0].user.username;
    //         this.data[0].controles.seccion = 25;
    //     }
    // }

    // let payload = {
    //     ...this.data[0],
    //     accion: action // Se agrega explícitamente 'accion'
    // };

    // upsertControles(payload).then(result => {
    //     let response = result.data;
    //     if (response.code == 0) {
    //         this.data[0].controles.seccion = statusactual;
    //         StatusHandler.ShowStatus(response.msg, StatusHandler.OPERATION.DEFAULT, StatusHandler.STATUS.FAIL);
    //         return;
    //     }
    //     console.log(response.data);

    //     this.data = response.data;
    //     this.edit_mode = false;
    //     StatusHandler.LClose();
    //     StatusHandler.ShowStatus("¡Acción Exitosa!", StatusHandler.OPERATION.DEFAULT, StatusHandler.STATUS.SUCCESS);
    // }).catch(ex => {
    //     this.data[0].controles.seccion = statusactual;
    //     this.data[0].controles.autorizado = rolautorizado;
    //     StatusHandler.LClose();
    //     StatusHandler.Exception("Ocurrió un error", ex);
    // });
    // },

    generatedReport: function(){
      var open_url = window.location.origin + `/report/controlescalidad/${this.data[0].order.num_id}/${this.data[0].controles.turno}`;
      window.location.href = open_url;
    },
  },
};
</script>

