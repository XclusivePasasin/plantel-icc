<style scoped>
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
  height: 18px;
  width: 18px;
  border: 1px solid white;
}

input[type="checkbox"]:checked {
  background: #2aa1c0;
}


input[type="checkbox"]:hover {
  filter: brightness(90%);
}

input[type='checkbox'][disabled] {
  background: white;
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

.grd_input-code{
  width: 20px;
}

/* Ocultar la flecha del select cuando no está en foco */
.select-wrapper {
    position: relative;
    display: inline-block;
  }

  .custom-select {
    appearance: none;
    -webkit-appearance: none;
    -moz-appearance: none;
    background-color: transparent;
    border: 1px solid #ccc;
    text-align: center;
    font-weight: bold;
    color: #0000FF;
    width: 100%;
    cursor: pointer;
    position: absolute;
    left: 0;
    top: 0;
    opacity: 0;
  }

  /* Mostrar el valor seleccionado encima del select */
  .selected-value {
    display: block;
    text-align: center;
    font-weight: bold;
    color: #0000FF;
    border: 1px solid #ccc;
    background-color: white;
  }

  /* Cuando el select está en foco, mostrar la flecha y ocultar el texto */
  .custom-select:focus {
    opacity: 1;
  }
</style>


<template>
    <div class="container bg-white p-6">
      <!--HERE INIT CONTENT SECTION-->
      <div class="py-2">
        <div class="row g-4 align-items-center">
          <div class="col">
            <h1 class="h3 m-0">
              Orden de Producción #{{ data[0].order.num_id }} / Turno #{{ data[0].estandares.turno }}
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
                <br>
                <u>
                  <h4 class="m-0 mb-6" style="text-align:center;">
                    ESTÁNDARES DE CALIDAD RELEVANTES PARA EL CONSUMIDOR (CRQS SACHETS)
                  </h4>
                </u>
              </div>
            </div>

            <table style="border:none; width:100%">
              <tr>
                <td>
                  <label for="nomprod" class="form-label">NOMBRE DEL PRODUCTO:</label>
                  <input type="text" :disabled="true" v-model="data[0].order.product_name" class="form-control" id="nomprod">
                </td>
                <td>
                  <label for="lote" class="form-label">LOTE:</label>
                  <input type="text" :disabled="true" v-model="data[0].order.lot_num" class="form-control" id="lote">
                </td>
                <td>
                  <label for="presentacion" class="form-label">PRESENTACION:</label>
                  <input
                    type="text"
                    disabled
                    v-model="data[0].estandares.presentacion"
                    class="form-control"
                    id="presentacion">
                  <!-- <input
                    type="text"
                    :disabled="data[0].estandares.seccion >= 8 || data[0].user.rolname != 'PROD'"
                    v-model="data[0].estandares.presentacion"
                    class="form-control"
                    id="presentacion"> -->
                </td>
                <td>
                    <!-- Se cambió el input de fecha a tipo date (sin máscara ni placeholder) -->
                    <label for="fecharealizada" class="form-label">FECHA:</label>
                    <input
                      type="date"
                      class="form-control"
                      :disabled="data[0].estandares.seccion >= 8 || data[0].user.rolname!='PROD'"
                      v-model="data[0].estandares.fecharealizada"
                      id="fecharealizada"
                    />
                </td>
              </tr>
              <tr>
                 <td colspan="4" style="text-align:center;">
                  <div style="display:flex; justify-content:center; gap:1rem;">
                    <div>
                      <label for="opresponsable" class="form-label">OPERARIO RESPONSABLE:</label>
                      <input type="text" :disabled="true" v-model="data[0].estandares.opresponsable" class="form-control" id="opresponsable">
                    </div>
                    <div>
                      <label for="supervisado" class="form-label">SUPERVISADO POR:</label>
                      <input type="text" :disabled="true" v-model="data[0].estandares.supervisado" class="form-control" id="supervisado">
                    </div>
                    <div>
                      <label for="autorizado" class="form-label">AUTORIZADO POR:</label>
                      <input type="text" :disabled="true" v-model="data[0].estandares.autorizado" class="form-control" id="autorizado">
                    </div>
                  </div>
                </td>
              </tr>
              <br>
              <br>
              <br>
            </table>
            

            <div>
              <table>
                <thead>
                  <tr>
                    <th>Defecto</th>
                    <th style="text-align:center" v-for="index in 8" :key="index + 'head'" colspan="6">
                      Hora
                      <!-- Se cambió el input de hora a tipo time -->
                      <input
                        type="time"
                        class="form-control"
                        :disabled="(index-1) != data[0].estandares.seccion || data[0].user.rolname!='PROD'"
                        v-model="data[0].estandares.horas[index-1]"
                      />
                    </th>
                  </tr>

                  <tr>
                    <th>Numeracion</th>
                      <th v-for="n in 6" :key="'sec0-' + n" style="text-align: center;">{{ n }}</th>
                      <th v-for="n in 6" :key="'sec1-' + n" style="text-align: center;">{{ n }}</th>
                      <th v-for="n in 6" :key="'sec2-' + n" style="text-align: center;">{{ n }}</th>
                      <th v-for="n in 6" :key="'sec3-' + n" style="text-align: center;">{{ n }}</th>
                      <th v-for="n in 6" :key="'sec4-' + n" style="text-align: center;">{{ n }}</th>
                      <th v-for="n in 6" :key="'sec5-' + n" style="text-align: center;">{{ n }}</th>
                      <th v-for="n in 6" :key="'sec6-' + n" style="text-align: center;">{{ n }}</th>
                      <th v-for="n in 6" :key="'sec7-' + n" style="text-align: center;">{{ n }}</th>
                  </tr>

            <tr>
                <th scope="col">Color de la impresión es correcta</th>
                <!-- Sección 0 -->
                <th style="text-align: center;" v-for="index in 6" :key="index + 's1h1'">
                <div style="text-align: center;" class="select-wrapper" v-if="data[0].estandares.seccion === 0">
                    <select class="custom-select"
                            :disabled="data[0].user.rolname !== 'PROD'"
                            v-model="data[0].estandares.a1[index - 1]">
                    <option value="">--</option> <!-- Permite quitar la selección -->
                    <option value="A">A</option>
                    <option value="V">V</option>
                    <option value="R">R</option>
                    </select>
                    <span class="selected-value">{{ data[0].estandares.a1[index - 1] || "--" }}</span>
                </div>

                <!-- <input v-if="data[0].estandares.seccion === 0"
                         class="grd_input-code"
                         :disabled="data[0].user.rolname !== 'PROD'"
                         v-model="data[0].estandares.a1[index - 1]"
                         maxlength="1"> -->
                <h1 v-else-if="data[0].estandares.seccion !== 0 && data[0].estandares.a1[index - 1]"
                    style="font-size:10px; color: #0000FF; font-weight: bold;">
                    {{ data[0].estandares.a1[index - 1] }}
                </h1>
                <h1 v-else style="font-size:10px; color: #0000FF;">NA</h1>
                </th>

                <!-- Sección 1 -->
                <th style="text-align: center;" v-for="index in 6" :key="index + 's1h2'">
                    <div style="text-align: center;" class="select-wrapper" v-if="data[0].estandares.seccion === 1">
                        <select class="custom-select"
                                :disabled="data[0].user.rolname !== 'PROD'"
                                v-model="data[0].estandares.a1[(index + 6) - 1]">
                        <option value="">--</option> <!-- Permite quitar la selección -->
                        <option value="A">A</option>
                        <option value="V">V</option>
                        <option value="R">R</option>
                        </select>
                        <span class="selected-value">{{ data[0].estandares.a1[(index + 6) - 1] || "--" }}</span>
                    </div>
                  <!-- <input v-if="data[0].estandares.seccion === 1"
                         class="grd_input-code"
                         :disabled="data[0].user.rolname !== 'PROD'"
                         v-model="data[0].estandares.a1[(index + 6) - 1]"
                         maxlength="1"> -->
                  <h1 v-else-if="data[0].estandares.seccion !== 1 && data[0].estandares.a1[(index + 6) - 1]"
                      style="font-size:10px; color: #0000FF; font-weight: bold;">
                    {{ data[0].estandares.a1[(index + 6) - 1] }}
                  </h1>
                  <h1 v-else style="font-size:10px; color: #0000FF;">NA</h1>
                </th>

                <!-- Sección 2 -->
                <th style="text-align: center;" v-for="index in 6" :key="index + 's1h3'">
                    <div style="text-align: center;" class="select-wrapper" v-if="data[0].estandares.seccion === 2">
                        <select class="custom-select"
                                :disabled="data[0].user.rolname !== 'PROD'"
                                v-model="data[0].estandares.a1[(index + 12) - 1]">
                        <option value="">--</option> <!-- Permite quitar la selección -->
                        <option value="A">A</option>
                        <option value="V">V</option>
                        <option value="R">R</option>
                        </select>
                        <span class="selected-value">{{ data[0].estandares.a1[(index + 12) - 1] || "--" }}</span>
                    </div>
                  <!-- <input v-if="data[0].estandares.seccion === 2"
                         class="grd_input-code"
                         :disabled="data[0].user.rolname !== 'PROD'"
                         v-model="data[0].estandares.a1[(index + 12) - 1]"
                         maxlength="1"> -->
                  <h1 v-else-if="data[0].estandares.seccion !== 2 && data[0].estandares.a1[(index + 12) - 1]"
                      style="font-size:10px; color: #0000FF; font-weight: bold;">
                    {{ data[0].estandares.a1[(index + 12) - 1] }}
                  </h1>
                  <h1 v-else style="font-size:10px; color: #0000FF;">NA</h1>
                </th>

                <!-- Sección 3 -->
                <th style="text-align: center;" v-for="index in 6" :key="index + 's1h4'">
                    <div style="text-align: center;" class="select-wrapper" v-if="data[0].estandares.seccion === 3">
                        <select class="custom-select"
                                :disabled="data[0].user.rolname !== 'PROD'"
                                v-model="data[0].estandares.a1[(index + 18) - 1]">
                        <option value="">--</option> <!-- Permite quitar la selección -->
                        <option value="A">A</option>
                        <option value="V">V</option>
                        <option value="R">R</option>
                        </select>
                        <span class="selected-value">{{ data[0].estandares.a1[(index + 18) - 1] || "--" }}</span>
                    </div>
                  <!-- <input v-if="data[0].estandares.seccion === 3"
                         class="grd_input-code"
                         :disabled="data[0].user.rolname !== 'PROD'"
                         v-model="data[0].estandares.a1[(index + 18) - 1]"
                         maxlength="1"> -->
                  <h1 v-else-if="data[0].estandares.seccion !== 3 && data[0].estandares.a1[(index + 18) - 1]"
                      style="font-size:10px; color: #0000FF; font-weight: bold;">
                    {{ data[0].estandares.a1[(index + 18) - 1] }}
                  </h1>
                  <h1 v-else style="font-size:10px; color: #0000FF;">NA</h1>
                </th>

                <!-- Sección 4 -->
                <th style="text-align: center;" v-for="index in 6" :key="index + 's1h5'">
                    <div style="text-align: center;" class="select-wrapper" v-if="data[0].estandares.seccion === 4">
                        <select class="custom-select"
                                :disabled="data[0].user.rolname !== 'PROD'"
                                v-model="data[0].estandares.a1[(index + 24) - 1]">
                        <option value="">--</option> <!-- Permite quitar la selección -->
                        <option value="A">A</option>
                        <option value="V">V</option>
                        <option value="R">R</option>
                        </select>
                        <span class="selected-value">{{ data[0].estandares.a1[(index + 24) - 1] || "--" }}</span>
                    </div>
                  <!-- <input v-if="data[0].estandares.seccion === 4"
                         class="grd_input-code"
                         :disabled="data[0].user.rolname !== 'PROD'"
                         v-model="data[0].estandares.a1[(index + 24) - 1]"
                         maxlength="1"> -->
                  <h1 v-else-if="data[0].estandares.seccion !== 4 && data[0].estandares.a1[(index + 24) - 1]"
                      style="font-size:10px; color: #0000FF; font-weight: bold;">
                    {{ data[0].estandares.a1[(index + 24) - 1] }}
                  </h1>
                  <h1 v-else style="font-size:10px; color: #0000FF;">NA</h1>
                </th>

                <!-- Sección 5 -->
                <th style="text-align: center;" v-for="index in 6" :key="index + 's1h6'">
                    <div style="text-align: center;" class="select-wrapper" v-if="data[0].estandares.seccion === 5">
                        <select class="custom-select"
                                :disabled="data[0].user.rolname !== 'PROD'"
                                v-model="data[0].estandares.a1[(index + 30) - 1]">
                        <option value="">--</option> <!-- Permite quitar la selección -->
                        <option value="A">A</option>
                        <option value="V">V</option>
                        <option value="R">R</option>
                        </select>
                        <span class="selected-value">{{ data[0].estandares.a1[(index + 30) - 1] || "--" }}</span>
                    </div>
                  <!-- <input v-if="data[0].estandares.seccion === 5"
                         class="grd_input-code"
                         :disabled="data[0].user.rolname !== 'PROD'"
                         v-model="data[0].estandares.a1[(index + 30) - 1]"
                         maxlength="1"> -->
                  <h1 v-else-if="data[0].estandares.seccion !== 5 && data[0].estandares.a1[(index + 30) - 1]"
                      style="font-size:10px; color: #0000FF; font-weight: bold;">
                    {{ data[0].estandares.a1[(index + 30) - 1] }}
                  </h1>
                  <h1 v-else style="font-size:10px; color: #0000FF;">NA</h1>
                </th>

                <!-- Sección 6 -->
                <th style="text-align: center;" v-for="index in 6" :key="index + 's1h7'">
                    <div style="text-align: center;" class="select-wrapper" v-if="data[0].estandares.seccion === 6">
                        <select class="custom-select"
                                :disabled="data[0].user.rolname !== 'PROD'"
                                v-model="data[0].estandares.a1[(index + 36) - 1]">
                        <option value="">--</option> <!-- Permite quitar la selección -->
                        <option value="A">A</option>
                        <option value="V">V</option>
                        <option value="R">R</option>
                        </select>
                        <span class="selected-value">{{ data[0].estandares.a1[(index + 36) - 1] || "--" }}</span>
                    </div>
                  <!-- <input v-if="data[0].estandares.seccion === 6"
                         class="grd_input-code"
                         :disabled="data[0].user.rolname !== 'PROD'"
                         v-model="data[0].estandares.a1[(index + 36) - 1]"
                         maxlength="1"> -->
                  <h1 v-else-if="data[0].estandares.seccion !== 6 && data[0].estandares.a1[(index + 36) - 1]"
                      style="font-size:10px; color: #0000FF; font-weight: bold;">
                    {{ data[0].estandares.a1[(index + 36) - 1] }}
                  </h1>
                  <h1 v-else style="font-size:10px; color: #0000FF;">NA</h1>
                </th>

                <!-- Sección 7 -->
                <th style="text-align: center;" v-for="index in 6" :key="index + 's1h8'">
                    <div style="text-align: center;" class="select-wrapper" v-if="data[0].estandares.seccion === 7">
                        <select class="custom-select"
                                :disabled="data[0].user.rolname !== 'PROD'"
                                v-model="data[0].estandares.a1[(index + 42) - 1]">
                        <option value="">--</option> <!-- Permite quitar la selección -->
                        <option value="A">A</option>
                        <option value="V">V</option>
                        <option value="R">R</option>
                        </select>
                        <span class="selected-value">{{ data[0].estandares.a1[(index + 42) - 1] || "--" }}</span>
                    </div>
                  <!-- <input v-if="data[0].estandares.seccion === 7"
                         class="grd_input-code"
                         :disabled="data[0].user.rolname !== 'PROD'"
                         v-model="data[0].estandares.a1[(index + 42) - 1]"
                         maxlength="1"> -->
                  <h1 v-else-if="data[0].estandares.seccion !== 7 && data[0].estandares.a1[(index + 42) - 1]"
                      style="font-size:10px; color: #0000FF; font-weight: bold;">
                    {{ data[0].estandares.a1[(index + 42) - 1] }}
                  </h1>
                  <h1 v-else style="font-size:10px; color: #0000FF;">NA</h1>
                </th>
              </tr>

              <tr>
                <th scope="col">Calidad de la impresión del texto</th>

                <!-- Sección 0 -->
                <th style="text-align: center;" v-for="index in 6" :key="index + 's2h1'">
                    <div style="text-align: center;" class="select-wrapper" v-if="data[0].estandares.seccion === 0">
                        <select class="custom-select"
                                :disabled="data[0].user.rolname !== 'PROD'"
                                v-model="data[0].estandares.a2[index - 1]">
                        <option value="">--</option> <!-- Permite quitar la selección -->
                        <option value="A">A</option>
                        <option value="V">V</option>
                        <option value="R">R</option>
                        </select>
                        <span class="selected-value">{{ data[0].estandares.a2[index - 1] || "--" }}</span>
                    </div>
                  <!-- <input v-if="data[0].estandares.seccion === 0"
                         class="grd_input-code"
                         :disabled="data[0].user.rolname !== 'PROD'"
                         v-model="data[0].estandares.a2[index - 1]"
                         maxlength="1"> -->
                  <h1 v-else-if="data[0].estandares.seccion !== 0 && data[0].estandares.a2[index - 1]"
                      style="font-size:10px; color: #0000FF; font-weight: bold;">
                    {{ data[0].estandares.a2[index - 1] }}
                  </h1>
                  <h1 v-else style="font-size:10px; color: #0000FF;">NA</h1>
                </th>

                <!-- Sección 1 -->
                <th style="text-align: center;" v-for="index in 6" :key="index + 's2h2'">
                    <div style="text-align: center;" class="select-wrapper" v-if="data[0].estandares.seccion === 1">
                        <select class="custom-select"
                                :disabled="data[0].user.rolname !== 'PROD'"
                                v-model="data[0].estandares.a2[(index + 6) - 1]">
                        <option value="">--</option> <!-- Permite quitar la selección -->
                        <option value="A">A</option>
                        <option value="V">V</option>
                        <option value="R">R</option>
                        </select>
                        <span class="selected-value">{{ data[0].estandares.a2[(index + 6) - 1] || "--" }}</span>
                    </div>
                  <!-- <input v-if="data[0].estandares.seccion === 1"
                         class="grd_input-code"
                         :disabled="data[0].user.rolname !== 'PROD'"
                         v-model="data[0].estandares.a2[(index + 6) - 1]"
                         maxlength="1"> -->
                  <h1 v-else-if="data[0].estandares.seccion !== 1 && data[0].estandares.a2[(index + 6) - 1]"
                      style="font-size:10px; color: #0000FF; font-weight: bold;">
                    {{ data[0].estandares.a2[(index + 6) - 1] }}
                  </h1>
                  <h1 v-else style="font-size:10px; color: #0000FF;">NA</h1>
                </th>

                <!-- Sección 2 -->
                <th style="text-align: center;" v-for="index in 6" :key="index + 's2h3'">
                    <div style="text-align: center;" class="select-wrapper" v-if="data[0].estandares.seccion === 2">
                        <select class="custom-select"
                                :disabled="data[0].user.rolname !== 'PROD'"
                                v-model="data[0].estandares.a2[(index + 12) - 1]">
                        <option value="">--</option> <!-- Permite quitar la selección -->
                        <option value="A">A</option>
                        <option value="V">V</option>
                        <option value="R">R</option>
                        </select>
                        <span class="selected-value">{{ data[0].estandares.a2[(index + 12) - 1] || "--" }}</span>
                    </div>

                  <!-- <input v-if="data[0].estandares.seccion === 2"
                         class="grd_input-code"
                         :disabled="data[0].user.rolname !== 'PROD'"
                         v-model="data[0].estandares.a2[(index + 12) - 1]"
                         maxlength="1"> -->
                  <h1 v-else-if="data[0].estandares.seccion !== 2 && data[0].estandares.a2[(index + 12) - 1]"
                      style="font-size:10px; color: #0000FF; font-weight: bold;">
                    {{ data[0].estandares.a2[(index + 12) - 1] }}
                  </h1>
                  <h1 v-else style="font-size:10px; color: #0000FF;">NA</h1>
                </th>

                <!-- Sección 3 -->
                <th style="text-align: center;" v-for="index in 6" :key="index + 's2h4'">
                    <div style="text-align: center;" class="select-wrapper" v-if="data[0].estandares.seccion === 3">
                        <select class="custom-select"
                                :disabled="data[0].user.rolname !== 'PROD'"
                                v-model="data[0].estandares.a2[(index + 18) - 1]">
                        <option value="">--</option> <!-- Permite quitar la selección -->
                        <option value="A">A</option>
                        <option value="V">V</option>
                        <option value="R">R</option>
                        </select>
                        <span class="selected-value">{{ data[0].estandares.a2[(index + 18) - 1] || "--" }}</span>
                    </div>

                  <!-- <input v-if="data[0].estandares.seccion === 3"
                         class="grd_input-code"
                         :disabled="data[0].user.rolname !== 'PROD'"
                         v-model="data[0].estandares.a2[(index + 18) - 1]"
                         maxlength="1"> -->
                  <h1 v-else-if="data[0].estandares.seccion !== 3 && data[0].estandares.a2[(index + 18) - 1]"
                      style="font-size:10px; color: #0000FF; font-weight: bold;">
                    {{ data[0].estandares.a2[(index + 18) - 1] }}
                  </h1>
                  <h1 v-else style="font-size:10px; color: #0000FF;">NA</h1>
                </th>

                <!-- Sección 4 -->
                <th style="text-align: center;" v-for="index in 6" :key="index + 's2h5'">
                    <div style="text-align: center;"  class="select-wrapper" v-if="data[0].estandares.seccion === 4">
                        <select class="custom-select"
                                :disabled="data[0].user.rolname !== 'PROD'"
                                v-model="data[0].estandares.a2[(index + 24) - 1]">
                        <option value="">--</option> <!-- Permite quitar la selección -->
                        <option value="A">A</option>
                        <option value="V">V</option>
                        <option value="R">R</option>
                        </select>
                        <span class="selected-value">{{ data[0].estandares.a2[(index + 24) - 1] || "--" }}</span>
                    </div>

                  <!-- <input v-if="data[0].estandares.seccion === 4"
                         class="grd_input-code"
                         :disabled="data[0].user.rolname !== 'PROD'"
                         v-model="data[0].estandares.a2[(index + 24) - 1]"
                         maxlength="1"> -->
                  <h1 v-else-if="data[0].estandares.seccion !== 4 && data[0].estandares.a2[(index + 24) - 1]"
                      style="font-size:10px; color: #0000FF; font-weight: bold;">
                    {{ data[0].estandares.a2[(index + 24) - 1] }}
                  </h1>
                  <h1 v-else style="font-size:10px; color: #0000FF;">NA</h1>
                </th>

                <!-- Sección 5 -->
                <th style="text-align: center;" v-for="index in 6" :key="index + 's2h6'">
                    <div style="text-align: center;" class="select-wrapper" v-if="data[0].estandares.seccion === 5">
                        <select class="custom-select"
                                :disabled="data[0].user.rolname !== 'PROD'"
                                v-model="data[0].estandares.a2[(index + 30) - 1]">
                        <option value="">--</option> <!-- Permite quitar la selección -->
                        <option value="A">A</option>
                        <option value="V">V</option>
                        <option value="R">R</option>
                        </select>
                        <span class="selected-value">{{ data[0].estandares.a2[(index + 30) - 1] || "--" }}</span>
                    </div>

                  <!-- <input v-if="data[0].estandares.seccion === 5"
                         class="grd_input-code"
                         :disabled="data[0].user.rolname !== 'PROD'"
                         v-model="data[0].estandares.a2[(index + 30) - 1]"
                         maxlength="1"> -->
                  <h1 v-else-if="data[0].estandares.seccion !== 5 && data[0].estandares.a2[(index + 30) - 1]"
                      style="font-size:10px; color: #0000FF; font-weight: bold;">
                    {{ data[0].estandares.a2[(index + 30) - 1] }}
                  </h1>
                  <h1 v-else style="font-size:10px; color: #0000FF;">NA</h1>
                </th>

                <!-- Sección 6 -->
                <th style="text-align: center;" v-for="index in 6" :key="index + 's2h7'">
                    <div style="text-align: center;" class="select-wrapper" v-if="data[0].estandares.seccion === 6">
                        <select class="custom-select"
                                :disabled="data[0].user.rolname !== 'PROD'"
                                v-model="data[0].estandares.a2[(index + 36) - 1]">
                        <option value="">--</option> <!-- Permite quitar la selección -->
                        <option value="A">A</option>
                        <option value="V">V</option>
                        <option value="R">R</option>
                        </select>
                        <span class="selected-value">{{ data[0].estandares.a2[(index + 36) - 1] || "--" }}</span>
                    </div>

                  <!-- <input v-if="data[0].estandares.seccion === 6"
                         class="grd_input-code"
                         :disabled="data[0].user.rolname !== 'PROD'"
                         v-model="data[0].estandares.a2[(index + 36) - 1]"
                         maxlength="1"> -->
                  <h1 v-else-if="data[0].estandares.seccion !== 6 && data[0].estandares.a2[(index + 36) - 1]"
                      style="font-size:10px; color: #0000FF; font-weight: bold;">
                    {{ data[0].estandares.a2[(index + 36) - 1] }}
                  </h1>
                  <h1 v-else style="font-size:10px; color: #0000FF;">NA</h1>
                </th>

                <!-- Sección 7 -->
                <th style="text-align: center;" v-for="index in 6" :key="index + 's2h8'">
                    <div style="text-align: center;" class="select-wrapper" v-if="data[0].estandares.seccion === 7">
                        <select class="custom-select"
                                :disabled="data[0].user.rolname !== 'PROD'"
                                v-model="data[0].estandares.a2[(index + 42) - 1]">
                        <option value="">--</option> <!-- Permite quitar la selección -->
                        <option value="A">A</option>
                        <option value="V">V</option>
                        <option value="R">R</option>
                        </select>
                        <span class="selected-value">{{ data[0].estandares.a2[(index + 42) - 1] || "--" }}</span>
                    </div>

                  <!-- <input v-if="data[0].estandares.seccion === 7"
                         class="grd_input-code"
                         :disabled="data[0].user.rolname !== 'PROD'"
                         v-model="data[0].estandares.a2[(index + 42) - 1]"
                         maxlength="1"> -->
                  <h1 v-else-if="data[0].estandares.seccion !== 7 && data[0].estandares.a2[(index + 42) - 1]"
                      style="font-size:10px; color: #0000FF; font-weight: bold;">
                    {{ data[0].estandares.a2[(index + 42) - 1] }}
                  </h1>
                  <h1 v-else style="font-size:10px; color: #0000FF;">NA</h1>
                </th>
              </tr>


              <tr>
                <th scope="col">Impresión Lote y venoe/corte/orientación</th>

                <!-- Sección 0 -->
                <th style="text-align: center;" v-for="index in 6" :key="index + 's3h1'">
                    <div style="text-align: center;" class="select-wrapper" v-if="data[0].estandares.seccion === 0">
                        <select class="custom-select"
                                :disabled="data[0].user.rolname !== 'PROD'"
                                v-model="data[0].estandares.a3[index - 1]">
                        <option value="">--</option> <!-- Permite quitar la selección -->
                        <option value="A">A</option>
                        <option value="V">V</option>
                        <option value="R">R</option>
                        </select>
                        <span class="selected-value">{{ data[0].estandares.a3[index - 1] || "--" }}</span>
                    </div>

                  <!-- <input v-if="data[0].estandares.seccion === 0"
                         class="grd_input-code"
                         :disabled="data[0].user.rolname !== 'PROD'"
                         v-model="data[0].estandares.a3[index - 1]"
                         maxlength="1"> -->
                  <h1 v-else-if="data[0].estandares.seccion !== 0 && data[0].estandares.a3[index - 1]"
                      style="font-size:10px; color: #0000FF; font-weight: bold;">
                    {{ data[0].estandares.a3[index - 1] }}
                  </h1>
                  <h1 v-else style="font-size:10px; color: #0000FF;">NA</h1>
                </th>

                <!-- Sección 1 -->
                <th style="text-align: center;" v-for="index in 6" :key="index + 's3h2'">
                    <div style="text-align: center;" class="select-wrapper" v-if="data[0].estandares.seccion === 1">
                        <select class="custom-select"
                                :disabled="data[0].user.rolname !== 'PROD'"
                                v-model="data[0].estandares.a3[(index + 6) - 1]">
                        <option value="">--</option> <!-- Permite quitar la selección -->
                        <option value="A">A</option>
                        <option value="V">V</option>
                        <option value="R">R</option>
                        </select>
                        <span class="selected-value">{{ data[0].estandares.a3[(index + 6) - 1] || "--" }}</span>
                    </div>

                  <!-- <input v-if="data[0].estandares.seccion === 1"
                         class="grd_input-code"
                         :disabled="data[0].user.rolname !== 'PROD'"
                         v-model="data[0].estandares.a3[(index + 6) - 1]"
                         maxlength="1"> -->
                  <h1 v-else-if="data[0].estandares.seccion !== 1 && data[0].estandares.a3[(index + 6) - 1]"
                      style="font-size:10px; color: #0000FF; font-weight: bold;">
                    {{ data[0].estandares.a3[(index + 6) - 1] }}
                  </h1>
                  <h1 v-else style="font-size:10px; color: #0000FF;">NA</h1>
                </th>

                <!-- Sección 2 -->
                <th style="text-align: center;" v-for="index in 6" :key="index + 's3h3'">
                    <div style="text-align: center;" class="select-wrapper" v-if="data[0].estandares.seccion === 2">
                        <select class="custom-select"
                                :disabled="data[0].user.rolname !== 'PROD'"
                                v-model="data[0].estandares.a3[(index + 12) - 1]">
                        <option value="">--</option> <!-- Permite quitar la selección -->
                        <option value="A">A</option>
                        <option value="V">V</option>
                        <option value="R">R</option>
                        </select>
                        <span class="selected-value">{{ data[0].estandares.a3[(index + 12) - 1] || "--" }}</span>
                    </div>

                  <!-- <input v-if="data[0].estandares.seccion === 2"
                         class="grd_input-code"
                         :disabled="data[0].user.rolname !== 'PROD'"
                         v-model="data[0].estandares.a3[(index + 12) - 1]"
                         maxlength="1"> -->
                  <h1 v-else-if="data[0].estandares.seccion !== 2 && data[0].estandares.a3[(index + 12) - 1]"
                      style="font-size:10px; color: #0000FF; font-weight: bold;">
                    {{ data[0].estandares.a3[(index + 12) - 1] }}
                  </h1>
                  <h1 v-else style="font-size:10px; color: #0000FF;">NA</h1>
                </th>

                <!-- Sección 3 -->
                <th style="text-align: center;" v-for="index in 6" :key="index + 's3h4'">
                    <div style="text-align: center;" class="select-wrapper" v-if="data[0].estandares.seccion === 3">
                        <select class="custom-select"
                                :disabled="data[0].user.rolname !== 'PROD'"
                                v-model="data[0].estandares.a3[(index + 18) - 1]">
                        <option value="">--</option> <!-- Permite quitar la selección -->
                        <option value="A">A</option>
                        <option value="V">V</option>
                        <option value="R">R</option>
                        </select>
                        <span class="selected-value">{{ data[0].estandares.a3[(index + 18) - 1] || "--" }}</span>
                    </div>

                  <!-- <input v-if="data[0].estandares.seccion === 3"
                         class="grd_input-code"
                         :disabled="data[0].user.rolname !== 'PROD'"
                         v-model="data[0].estandares.a3[(index + 18) - 1]"
                         maxlength="1"> -->
                  <h1 v-else-if="data[0].estandares.seccion !== 3 && data[0].estandares.a3[(index + 18) - 1]"
                      style="font-size:10px; color: #0000FF; font-weight: bold;">
                    {{ data[0].estandares.a3[(index + 18) - 1] }}
                  </h1>
                  <h1 v-else style="font-size:10px; color: #0000FF;">NA</h1>
                </th>

                <!-- Sección 4 -->
                <th style="text-align: center;" v-for="index in 6" :key="index + 's3h5'">
                    <div style="text-align: center;" class="select-wrapper" v-if="data[0].estandares.seccion === 4">
                        <select class="custom-select"
                                :disabled="data[0].user.rolname !== 'PROD'"
                                v-model="data[0].estandares.a3[(index + 24) - 1]">
                        <option value="">--</option> <!-- Permite quitar la selección -->
                        <option value="A">A</option>
                        <option value="V">V</option>
                        <option value="R">R</option>
                        </select>
                        <span class="selected-value">{{ data[0].estandares.a3[(index + 24) - 1] || "--" }}</span>
                    </div>

                  <!-- <input v-if="data[0].estandares.seccion === 4"
                         class="grd_input-code"
                         :disabled="data[0].user.rolname !== 'PROD'"
                         v-model="data[0].estandares.a3[(index + 24) - 1]"
                         maxlength="1"> -->
                  <h1 v-else-if="data[0].estandares.seccion !== 4 && data[0].estandares.a3[(index + 24) - 1]"
                      style="font-size:10px; color: #0000FF; font-weight: bold;">
                    {{ data[0].estandares.a3[(index + 24) - 1] }}
                  </h1>
                  <h1 v-else style="font-size:10px; color: #0000FF;">NA</h1>
                </th>

                <!-- Sección 5 -->
                <th style="text-align: center;" v-for="index in 6" :key="index + 's3h6'">
                    <div style="text-align: center;" class="select-wrapper" v-if="data[0].estandares.seccion === 5">
                        <select class="custom-select"
                                :disabled="data[0].user.rolname !== 'PROD'"
                                v-model="data[0].estandares.a3[(index + 30) - 1]">
                        <option value="">--</option> <!-- Permite quitar la selección -->
                        <option value="A">A</option>
                        <option value="V">V</option>
                        <option value="R">R</option>
                        </select>
                        <span class="selected-value">{{ data[0].estandares.a3[(index + 30) - 1] || "--" }}</span>
                    </div>

                  <!-- <input v-if="data[0].estandares.seccion === 5"
                         class="grd_input-code"
                         :disabled="data[0].user.rolname !== 'PROD'"
                         v-model="data[0].estandares.a3[(index + 30) - 1]"
                         maxlength="1"> -->
                  <h1 v-else-if="data[0].estandares.seccion !== 5 && data[0].estandares.a3[(index + 30) - 1]"
                      style="font-size:10px; color: #0000FF; font-weight: bold;">
                    {{ data[0].estandares.a3[(index + 30) - 1] }}
                  </h1>
                  <h1 v-else style="font-size:10px; color: #0000FF;">NA</h1>
                </th>

                <!-- Sección 6 -->
                <th style="text-align: center;" v-for="index in 6" :key="index + 's3h7'">
                    <div style="text-align: center;" class="select-wrapper" v-if="data[0].estandares.seccion === 6">
                        <select class="custom-select"
                                :disabled="data[0].user.rolname !== 'PROD'"
                                v-model="data[0].estandares.a3[(index + 36) - 1]">
                        <option value="">--</option> <!-- Permite quitar la selección -->
                        <option value="A">A</option>
                        <option value="V">V</option>
                        <option value="R">R</option>
                        </select>
                        <span class="selected-value">{{ data[0].estandares.a3[(index + 36) - 1] || "--" }}</span>
                    </div>

                  <!-- <input v-if="data[0].estandares.seccion === 6"
                         class="grd_input-code"
                         :disabled="data[0].user.rolname !== 'PROD'"
                         v-model="data[0].estandares.a3[(index + 36) - 1]"
                         maxlength="1"> -->
                  <h1 v-else-if="data[0].estandares.seccion !== 6 && data[0].estandares.a3[(index + 36) - 1]"
                      style="font-size:10px; color: #0000FF; font-weight: bold;">
                    {{ data[0].estandares.a3[(index + 36) - 1] }}
                  </h1>
                  <h1 v-else style="font-size:10px; color: #0000FF;">NA</h1>
                </th>

                <!-- Sección 7 -->
                <th style="text-align: center;" v-for="index in 6" :key="index + 's3h8'">
                    <div style="text-align: center;" class="select-wrapper" v-if="data[0].estandares.seccion === 7">
                        <select class="custom-select"
                                :disabled="data[0].user.rolname !== 'PROD'"
                                v-model="data[0].estandares.a3[(index + 42) - 1]">
                        <option value="">--</option> <!-- Permite quitar la selección -->
                        <option value="A">A</option>
                        <option value="V">V</option>
                        <option value="R">R</option>
                        </select>
                        <span class="selected-value">{{ data[0].estandares.a3[(index + 42) - 1] || "--" }}</span>
                    </div>

                  <!-- <input v-if="data[0].estandares.seccion === 7"
                         class="grd_input-code"
                         :disabled="data[0].user.rolname !== 'PROD'"
                         v-model="data[0].estandares.a3[(index + 42) - 1]"
                         maxlength="1"> -->
                  <h1 v-else-if="data[0].estandares.seccion !== 7 && data[0].estandares.a3[(index + 42) - 1]"
                      style="font-size:10px; color: #0000FF; font-weight: bold;">
                    {{ data[0].estandares.a3[(index + 42) - 1] }}
                  </h1>
                  <h1 v-else style="font-size:10px; color: #0000FF;">NA</h1>
                </th>
              </tr>


              <tr>
                <th scope="col">Polvo en el empaque proveniente del ambiente</th>

                <!-- Sección 0 -->
                <th style="text-align: center;" v-for="index in 6" :key="index + 's4h1'">
                    <div style="text-align: center;" class="select-wrapper" v-if="data[0].estandares.seccion === 0">
                        <select class="custom-select"
                                :disabled="data[0].user.rolname !== 'PROD'"
                                v-model="data[0].estandares.a4[index - 1]">
                        <option value="">--</option> <!-- Permite quitar la selección -->
                        <option value="A">A</option>
                        <option value="V">V</option>
                        <option value="R">R</option>
                        </select>
                        <span class="selected-value">{{ data[0].estandares.a4[index - 1] || "--" }}</span>
                    </div>

                  <!-- <input v-if="data[0].estandares.seccion === 0"
                         class="grd_input-code"
                         :disabled="data[0].user.rolname !== 'PROD'"
                         v-model="data[0].estandares.a4[index - 1]"
                         maxlength="1"> -->
                  <h1 v-else-if="data[0].estandares.seccion !== 0 && data[0].estandares.a4[index - 1]"
                      style="font-size:10px; color: #0000FF; font-weight: bold;">
                    {{ data[0].estandares.a4[index - 1] }}
                  </h1>
                  <h1 v-else style="font-size:10px; color: #0000FF;">NA</h1>
                </th>

                <!-- Sección 1 -->
                <th style="text-align: center;" v-for="index in 6" :key="index + 's4h2'">
                    <div style="text-align: center;" class="select-wrapper" v-if="data[0].estandares.seccion === 1">
                        <select class="custom-select"
                                :disabled="data[0].user.rolname !== 'PROD'"
                                v-model="data[0].estandares.a4[(index + 6) - 1]">
                        <option value="">--</option> <!-- Permite quitar la selección -->
                        <option value="A">A</option>
                        <option value="V">V</option>
                        <option value="R">R</option>
                        </select>
                        <span class="selected-value">{{ data[0].estandares.a4[(index + 6) - 1] || "--" }}</span>
                    </div>

                  <!-- <input v-if="data[0].estandares.seccion === 1"
                         class="grd_input-code"
                         :disabled="data[0].user.rolname !== 'PROD'"
                         v-model="data[0].estandares.a4[(index + 6) - 1]"
                         maxlength="1"> -->
                  <h1 v-else-if="data[0].estandares.seccion !== 1 && data[0].estandares.a4[(index + 6) - 1]"
                      style="font-size:10px; color: #0000FF; font-weight: bold;">
                    {{ data[0].estandares.a4[(index + 6) - 1] }}
                  </h1>
                  <h1 v-else style="font-size:10px; color: #0000FF;">NA</h1>
                </th>

                <!-- Sección 2 -->
                <th style="text-align: center;" v-for="index in 6" :key="index + 's4h3'">
                    <div style="text-align: center;" class="select-wrapper" v-if="data[0].estandares.seccion === 2">
                        <select class="custom-select"
                                :disabled="data[0].user.rolname !== 'PROD'"
                                v-model="data[0].estandares.a4[(index + 12) - 1]">
                        <option value="">--</option> <!-- Permite quitar la selección -->
                        <option value="A">A</option>
                        <option value="V">V</option>
                        <option value="R">R</option>
                        </select>
                        <span class="selected-value">{{ data[0].estandares.a4[(index + 12) - 1] || "--" }}</span>
                    </div>

                  <!-- <input v-if="data[0].estandares.seccion === 2"
                         class="grd_input-code"
                         :disabled="data[0].user.rolname !== 'PROD'"
                         v-model="data[0].estandares.a4[(index + 12) - 1]"
                         maxlength="1"> -->
                  <h1 v-else-if="data[0].estandares.seccion !== 2 && data[0].estandares.a4[(index + 12) - 1]"
                      style="font-size:10px; color: #0000FF; font-weight: bold;">
                    {{ data[0].estandares.a4[(index + 12) - 1] }}
                  </h1>
                  <h1 v-else style="font-size:10px; color: #0000FF;">NA</h1>
                </th>

                <!-- Sección 3 -->
                <th style="text-align: center;" v-for="index in 6" :key="index + 's4h4'">
                    <div style="text-align: center;" class="select-wrapper" v-if="data[0].estandares.seccion === 3">
                        <select class="custom-select"
                                :disabled="data[0].user.rolname !== 'PROD'"
                                v-model="data[0].estandares.a4[(index + 18) - 1]">
                        <option value="">--</option> <!-- Permite quitar la selección -->
                        <option value="A">A</option>
                        <option value="V">V</option>
                        <option value="R">R</option>
                        </select>
                        <span class="selected-value">{{ data[0].estandares.a4[(index + 18) - 1] || "--" }}</span>
                    </div>

                  <!-- <input v-if="data[0].estandares.seccion === 3"
                         class="grd_input-code"
                         :disabled="data[0].user.rolname !== 'PROD'"
                         v-model="data[0].estandares.a4[(index + 18) - 1]"
                         maxlength="1"> -->
                  <h1 v-else-if="data[0].estandares.seccion !== 3 && data[0].estandares.a4[(index + 18) - 1]"
                      style="font-size:10px; color: #0000FF; font-weight: bold;">
                    {{ data[0].estandares.a4[(index + 18) - 1] }}
                  </h1>
                  <h1 v-else style="font-size:10px; color: #0000FF;">NA</h1>
                </th>

                <!-- Sección 4 -->
                <th style="text-align: center;" v-for="index in 6" :key="index + 's4h5'">
                    <div style="text-align: center;" class="select-wrapper" v-if="data[0].estandares.seccion === 4">
                        <select class="custom-select"
                                :disabled="data[0].user.rolname !== 'PROD'"
                                v-model="data[0].estandares.a4[(index + 24) - 1]">
                        <option value="">--</option> <!-- Permite quitar la selección -->
                        <option value="A">A</option>
                        <option value="V">V</option>
                        <option value="R">R</option>
                        </select>
                        <span class="selected-value">{{ data[0].estandares.a4[(index + 24) - 1] || "--" }}</span>
                    </div>

                  <!-- <input v-if="data[0].estandares.seccion === 4"
                         class="grd_input-code"
                         :disabled="data[0].user.rolname !== 'PROD'"
                         v-model="data[0].estandares.a4[(index + 24) - 1]"
                         maxlength="1"> -->
                  <h1 v-else-if="data[0].estandares.seccion !== 4 && data[0].estandares.a4[(index + 24) - 1]"
                      style="font-size:10px; color: #0000FF; font-weight: bold;">
                    {{ data[0].estandares.a4[(index + 24) - 1] }}
                  </h1>
                  <h1 v-else style="font-size:10px; color: #0000FF;">NA</h1>
                </th>

                <!-- Sección 5 -->
                <th style="text-align: center;" v-for="index in 6" :key="index + 's4h6'">
                    <div style="text-align: center;" class="select-wrapper" v-if="data[0].estandares.seccion === 5">
                        <select class="custom-select"
                                :disabled="data[0].user.rolname !== 'PROD'"
                                v-model="data[0].estandares.a4[(index + 30) - 1]">
                        <option value="">--</option> <!-- Permite quitar la selección -->
                        <option value="A">A</option>
                        <option value="V">V</option>
                        <option value="R">R</option>
                        </select>
                        <span class="selected-value">{{ data[0].estandares.a4[(index + 30) - 1] || "--" }}</span>
                    </div>

                  <!-- <input v-if="data[0].estandares.seccion === 5"
                         class="grd_input-code"
                         :disabled="data[0].user.rolname !== 'PROD'"
                         v-model="data[0].estandares.a4[(index + 30) - 1]"
                         maxlength="1"> -->
                  <h1 v-else-if="data[0].estandares.seccion !== 5 && data[0].estandares.a4[(index + 30) - 1]"
                      style="font-size:10px; color: #0000FF; font-weight: bold;">
                    {{ data[0].estandares.a4[(index + 30) - 1] }}
                  </h1>
                  <h1 v-else style="font-size:10px; color: #0000FF;">NA</h1>
                </th>

                <!-- Sección 6 -->
                <th style="text-align: center;" v-for="index in 6" :key="index + 's4h7'">
                    <div style="text-align: center;" class="select-wrapper" v-if="data[0].estandares.seccion === 6">
                        <select class="custom-select"
                                :disabled="data[0].user.rolname !== 'PROD'"
                                v-model="data[0].estandares.a4[(index + 36) - 1]">
                        <option value="">--</option> <!-- Permite quitar la selección -->
                        <option value="A">A</option>
                        <option value="V">V</option>
                        <option value="R">R</option>
                        </select>
                        <span class="selected-value">{{ data[0].estandares.a4[(index + 36) - 1] || "--" }}</span>
                    </div>

                  <!-- <input v-if="data[0].estandares.seccion === 6"
                         class="grd_input-code"
                         :disabled="data[0].user.rolname !== 'PROD'"
                         v-model="data[0].estandares.a4[(index + 36) - 1]"
                         maxlength="1"> -->
                  <h1 v-else-if="data[0].estandares.seccion !== 6 && data[0].estandares.a4[(index + 36) - 1]"
                      style="font-size:10px; color: #0000FF; font-weight: bold;">
                    {{ data[0].estandares.a4[(index + 36) - 1] }}
                  </h1>
                  <h1 v-else style="font-size:10px; color: #0000FF;">NA</h1>
                </th>

                <!-- Sección 7 -->
                <th style="text-align: center;" v-for="index in 6" :key="index + 's4h8'">
                    <div style="text-align: center;" class="select-wrapper" v-if="data[0].estandares.seccion === 7">
                        <select class="custom-select"
                                :disabled="data[0].user.rolname !== 'PROD'"
                                v-model="data[0].estandares.a4[(index + 42) - 1]">
                        <option value="">--</option> <!-- Permite quitar la selección -->
                        <option value="A">A</option>
                        <option value="V">V</option>
                        <option value="R">R</option>
                        </select>
                        <span class="selected-value">{{ data[0].estandares.a4[(index + 42) - 1] || "--" }}</span>
                    </div>

                  <!-- <input v-if="data[0].estandares.seccion === 7"
                         class="grd_input-code"
                         :disabled="data[0].user.rolname !== 'PROD'"
                         v-model="data[0].estandares.a4[(index + 42) - 1]"
                         maxlength="1"> -->
                  <h1 v-else-if="data[0].estandares.seccion !== 7 && data[0].estandares.a4[(index + 42) - 1]"
                      style="font-size:10px; color: #0000FF; font-weight: bold;">
                    {{ data[0].estandares.a4[(index + 42) - 1] }}
                  </h1>
                  <h1 v-else style="font-size:10px; color: #0000FF;">NA</h1>
                </th>
              </tr>



              <tr>
                <th scope="col">Manchado de producto, grasa o cualquier suciedad</th>

                <!-- Sección 0 -->
                <th style="text-align: center;" v-for="index in 6" :key="index + 's5h1'">
                    <div style="text-align: center;" class="select-wrapper" v-if="data[0].estandares.seccion === 0">
                        <select class="custom-select"
                                :disabled="data[0].user.rolname !== 'PROD'"
                                v-model="data[0].estandares.a5[index - 1]">
                        <option value="">--</option> <!-- Permite quitar la selección -->
                        <option value="A">A</option>
                        <option value="V">V</option>
                        <option value="R">R</option>
                        </select>
                        <span class="selected-value">{{ data[0].estandares.a5[index - 1] || "--" }}</span>
                    </div>

                  <!-- <input v-if="data[0].estandares.seccion === 0"
                         class="grd_input-code"
                         :disabled="data[0].user.rolname !== 'PROD'"
                         v-model="data[0].estandares.a5[index - 1]"
                         maxlength="1"> -->
                  <h1 v-else-if="data[0].estandares.seccion !== 0 && data[0].estandares.a5[index - 1]"
                      style="font-size:10px; color: #0000FF; font-weight: bold;">
                    {{ data[0].estandares.a5[index - 1] }}
                  </h1>
                  <h1 v-else style="font-size:10px; color: #0000FF;">NA</h1>
                </th>

                <!-- Sección 1 -->
                <th style="text-align: center;" v-for="index in 6" :key="index + 's5h2'">
                    <div style="text-align: center;" class="select-wrapper" v-if="data[0].estandares.seccion === 1">
                        <select class="custom-select"
                                :disabled="data[0].user.rolname !== 'PROD'"
                                v-model="data[0].estandares.a5[(index + 6) - 1]">
                        <option value="">--</option> <!-- Permite quitar la selección -->
                        <option value="A">A</option>
                        <option value="V">V</option>
                        <option value="R">R</option>
                        </select>
                        <span class="selected-value">{{ data[0].estandares.a5[(index + 6) - 1] || "--" }}</span>
                    </div>

                  <!-- <input v-if="data[0].estandares.seccion === 1"
                         class="grd_input-code"
                         :disabled="data[0].user.rolname !== 'PROD'"
                         v-model="data[0].estandares.a5[(index + 6) - 1]"
                         maxlength="1"> -->
                  <h1 v-else-if="data[0].estandares.seccion !== 1 && data[0].estandares.a5[(index + 6) - 1]"
                      style="font-size:10px; color: #0000FF; font-weight: bold;">
                    {{ data[0].estandares.a5[(index + 6) - 1] }}
                  </h1>
                  <h1 v-else style="font-size:10px; color: #0000FF;">NA</h1>
                </th>

                <!-- Sección 2 -->
                <th style="text-align: center;" v-for="index in 6" :key="index + 's5h3'">
                    <div style="text-align: center;" class="select-wrapper" v-if="data[0].estandares.seccion === 2">
                        <select class="custom-select"
                                :disabled="data[0].user.rolname !== 'PROD'"
                                v-model="data[0].estandares.a5[(index + 12) - 1]">
                        <option value="">--</option> <!-- Permite quitar la selección -->
                        <option value="A">A</option>
                        <option value="V">V</option>
                        <option value="R">R</option>
                        </select>
                        <span class="selected-value">{{ data[0].estandares.a5[(index + 12) - 1] || "--" }}</span>
                    </div>

                  <!-- <input v-if="data[0].estandares.seccion === 2"
                         class="grd_input-code"
                         :disabled="data[0].user.rolname !== 'PROD'"
                         v-model="data[0].estandares.a5[(index + 12) - 1]"
                         maxlength="1"> -->
                  <h1 v-else-if="data[0].estandares.seccion !== 2 && data[0].estandares.a5[(index + 12) - 1]"
                      style="font-size:10px; color: #0000FF; font-weight: bold;">
                    {{ data[0].estandares.a5[(index + 12) - 1] }}
                  </h1>
                  <h1 v-else style="font-size:10px; color: #0000FF;">NA</h1>
                </th>

                <!-- Sección 3 -->
                <th style="text-align: center;" v-for="index in 6" :key="index + 's5h4'">
                    <div style="text-align: center;" class="select-wrapper" v-if="data[0].estandares.seccion === 3">
                        <select class="custom-select"
                                :disabled="data[0].user.rolname !== 'PROD'"
                                v-model="data[0].estandares.a5[(index + 18) - 1]">
                        <option value="">--</option> <!-- Permite quitar la selección -->
                        <option value="A">A</option>
                        <option value="V">V</option>
                        <option value="R">R</option>
                        </select>
                        <span class="selected-value">{{ data[0].estandares.a5[(index + 18) - 1] || "--" }}</span>
                    </div>

                  <!-- <input v-if="data[0].estandares.seccion === 3"
                         class="grd_input-code"
                         :disabled="data[0].user.rolname !== 'PROD'"
                         v-model="data[0].estandares.a5[(index + 18) - 1]"
                         maxlength="1"> -->
                  <h1 v-else-if="data[0].estandares.seccion !== 3 && data[0].estandares.a5[(index + 18) - 1]"
                      style="font-size:10px; color: #0000FF; font-weight: bold;">
                    {{ data[0].estandares.a5[(index + 18) - 1] }}
                  </h1>
                  <h1 v-else style="font-size:10px; color: #0000FF;">NA</h1>
                </th>

                <!-- Sección 4 -->
                <th style="text-align: center;" v-for="index in 6" :key="index + 's5h5'">
                    <div style="text-align: center;" class="select-wrapper" v-if="data[0].estandares.seccion === 4">
                        <select class="custom-select"
                                :disabled="data[0].user.rolname !== 'PROD'"
                                v-model="data[0].estandares.a5[(index + 24) - 1]">
                        <option value="">--</option> <!-- Permite quitar la selección -->
                        <option value="A">A</option>
                        <option value="V">V</option>
                        <option value="R">R</option>
                        </select>
                        <span class="selected-value">{{ data[0].estandares.a5[(index + 24) - 1] || "--" }}</span>
                    </div>

                  <!-- <input v-if="data[0].estandares.seccion === 4"
                         class="grd_input-code"
                         :disabled="data[0].user.rolname !== 'PROD'"
                         v-model="data[0].estandares.a5[(index + 24) - 1]"
                         maxlength="1"> -->
                  <h1 v-else-if="data[0].estandares.seccion !== 4 && data[0].estandares.a5[(index + 24) - 1]"
                      style="font-size:10px; color: #0000FF; font-weight: bold;">
                    {{ data[0].estandares.a5[(index + 24) - 1] }}
                  </h1>
                  <h1 v-else style="font-size:10px; color: #0000FF;">NA</h1>
                </th>

                <!-- Sección 5 -->
                <th style="text-align: center;" v-for="index in 6" :key="index + 's5h6'">
                    <div style="text-align: center;" class="select-wrapper" v-if="data[0].estandares.seccion === 5">
                        <select class="custom-select"
                                :disabled="data[0].user.rolname !== 'PROD'"
                                v-model="data[0].estandares.a5[(index + 30) - 1]">
                        <option value="">--</option> <!-- Permite quitar la selección -->
                        <option value="A">A</option>
                        <option value="V">V</option>
                        <option value="R">R</option>
                        </select>
                        <span class="selected-value">{{ data[0].estandares.a5[(index + 30) - 1] || "--" }}</span>
                    </div>

                  <!-- <input v-if="data[0].estandares.seccion === 5"
                         class="grd_input-code"
                         :disabled="data[0].user.rolname !== 'PROD'"
                         v-model="data[0].estandares.a5[(index + 30) - 1]"
                         maxlength="1"> -->
                  <h1 v-else-if="data[0].estandares.seccion !== 5 && data[0].estandares.a5[(index + 30) - 1]"
                      style="font-size:10px; color: #0000FF; font-weight: bold;">
                    {{ data[0].estandares.a5[(index + 30) - 1] }}
                  </h1>
                  <h1 v-else style="font-size:10px; color: #0000FF;">NA</h1>
                </th>

                <!-- Sección 6 -->
                <th style="text-align: center;" v-for="index in 6" :key="index + 's5h7'">
                    <div style="text-align: center;" class="select-wrapper" v-if="data[0].estandares.seccion === 6">
                        <select class="custom-select"
                                :disabled="data[0].user.rolname !== 'PROD'"
                                v-model="data[0].estandares.a5[(index + 36) - 1]">
                        <option value="">--</option> <!-- Permite quitar la selección -->
                        <option value="A">A</option>
                        <option value="V">V</option>
                        <option value="R">R</option>
                        </select>
                        <span class="selected-value">{{ data[0].estandares.a5[(index + 36) - 1] || "--" }}</span>
                    </div>

                  <!-- <input v-if="data[0].estandares.seccion === 6"
                         class="grd_input-code"
                         :disabled="data[0].user.rolname !== 'PROD'"
                         v-model="data[0].estandares.a5[(index + 36) - 1]"
                         maxlength="1"> -->
                  <h1 v-else-if="data[0].estandares.seccion !== 6 && data[0].estandares.a5[(index + 36) - 1]"
                      style="font-size:10px; color: #0000FF; font-weight: bold;">
                    {{ data[0].estandares.a5[(index + 36) - 1] }}
                  </h1>
                  <h1 v-else style="font-size:10px; color: #0000FF;">NA</h1>
                </th>

                <!-- Sección 7 -->
                <th style="text-align: center;" v-for="index in 6" :key="index + 's5h8'">
                    <div style="text-align: center;" class="select-wrapper" v-if="data[0].estandares.seccion === 7">
                        <select class="custom-select"
                                :disabled="data[0].user.rolname !== 'PROD'"
                                v-model="data[0].estandares.a5[(index + 42) - 1]">
                        <option value="">--</option> <!-- Permite quitar la selección -->
                        <option value="A">A</option>
                        <option value="V">V</option>
                        <option value="R">R</option>
                        </select>
                        <span class="selected-value">{{ data[0].estandares.a5[(index + 42) - 1] || "--" }}</span>
                    </div>

                  <!-- <input v-if="data[0].estandares.seccion === 7"
                         class="grd_input-code"
                         :disabled="data[0].user.rolname !== 'PROD'"
                         v-model="data[0].estandares.a5[(index + 42) - 1]"
                         maxlength="1"> -->
                  <h1 v-else-if="data[0].estandares.seccion !== 7 && data[0].estandares.a5[(index + 42) - 1]"
                      style="font-size:10px; color: #0000FF; font-weight: bold;">
                    {{ data[0].estandares.a5[(index + 42) - 1] }}
                  </h1>
                  <h1 v-else style="font-size:10px; color: #0000FF;">NA</h1>
                </th>

              </tr>



              <tr>
                <th scope="col">Producto Obviamente bajo de peso</th>

                <!-- Sección 0 -->
                <th style="text-align: center;" v-for="index in 6" :key="index + 's6h1'">
                    <div style="text-align: center;" class="select-wrapper" v-if="data[0].estandares.seccion === 0">
                        <select class="custom-select"
                                :disabled="data[0].user.rolname !== 'PROD'"
                                v-model="data[0].estandares.a6[index - 1]">
                        <option value="">--</option> <!-- Permite quitar la selección -->
                        <option value="A">A</option>
                        <option value="V">V</option>
                        <option value="R">R</option>
                        </select>
                        <span class="selected-value">{{ data[0].estandares.a6[index - 1] || "--" }}</span>
                    </div>

                  <!-- <input v-if="data[0].estandares.seccion === 0"
                         class="grd_input-code"
                         :disabled="data[0].user.rolname !== 'PROD'"
                         v-model="data[0].estandares.a6[index - 1]"
                         maxlength="1"> -->
                  <h1 v-else-if="data[0].estandares.seccion !== 0 && data[0].estandares.a6[index - 1]"
                      style="font-size:10px; color: #0000FF; font-weight: bold;">
                    {{ data[0].estandares.a6[index - 1] }}
                  </h1>
                  <h1 v-else style="font-size:10px; color: #0000FF;">NA</h1>
                </th>

                <!-- Sección 1 -->
                <th style="text-align: center;" v-for="index in 6" :key="index + 's6h2'">
                    <div style="text-align: center;" class="select-wrapper" v-if="data[0].estandares.seccion === 1">
                        <select class="custom-select"
                                :disabled="data[0].user.rolname !== 'PROD'"
                                v-model="data[0].estandares.a6[(index + 6) - 1]">
                        <option value="">--</option> <!-- Permite quitar la selección -->
                        <option value="A">A</option>
                        <option value="V">V</option>
                        <option value="R">R</option>
                        </select>
                        <span class="selected-value">{{ data[0].estandares.a6[(index + 6) - 1] || "--" }}</span>
                    </div>

                  <!-- <input v-if="data[0].estandares.seccion === 1"
                         class="grd_input-code"
                         :disabled="data[0].user.rolname !== 'PROD'"
                         v-model="data[0].estandares.a6[(index + 6) - 1]"
                         maxlength="1"> -->
                  <h1 v-else-if="data[0].estandares.seccion !== 1 && data[0].estandares.a6[(index + 6) - 1]"
                      style="font-size:10px; color: #0000FF; font-weight: bold;">
                    {{ data[0].estandares.a6[(index + 6) - 1] }}
                  </h1>
                  <h1 v-else style="font-size:10px; color: #0000FF;">NA</h1>
                </th>

                <!-- Sección 2 -->
                <th style="text-align: center;" v-for="index in 6" :key="index + 's6h3'">
                    <div style="text-align: center;" class="select-wrapper" v-if="data[0].estandares.seccion === 2">
                        <select class="custom-select"
                                :disabled="data[0].user.rolname !== 'PROD'"
                                v-model="data[0].estandares.a6[(index + 12) - 1]">
                        <option value="">--</option> <!-- Permite quitar la selección -->
                        <option value="A">A</option>
                        <option value="V">V</option>
                        <option value="R">R</option>
                        </select>
                        <span class="selected-value">{{ data[0].estandares.a6[(index + 12) - 1] || "--" }}</span>
                    </div>

                  <!-- <input v-if="data[0].estandares.seccion === 2"
                         class="grd_input-code"
                         :disabled="data[0].user.rolname !== 'PROD'"
                         v-model="data[0].estandares.a6[(index + 12) - 1]"
                         maxlength="1"> -->
                  <h1 v-else-if="data[0].estandares.seccion !== 2 && data[0].estandares.a6[(index + 12) - 1]"
                      style="font-size:10px; color: #0000FF; font-weight: bold;">
                    {{ data[0].estandares.a6[(index + 12) - 1] }}
                  </h1>
                  <h1 v-else style="font-size:10px; color: #0000FF;">NA</h1>
                </th>

                <!-- Sección 3 -->
                <th style="text-align: center;" v-for="index in 6" :key="index + 's6h4'">
                    <div style="text-align: center;" class="select-wrapper" v-if="data[0].estandares.seccion === 3">
                        <select class="custom-select"
                                :disabled="data[0].user.rolname !== 'PROD'"
                                v-model="data[0].estandares.a6[(index + 18) - 1]">
                        <option value="">--</option> <!-- Permite quitar la selección -->
                        <option value="A">A</option>
                        <option value="V">V</option>
                        <option value="R">R</option>
                        </select>
                        <span class="selected-value">{{ data[0].estandares.a6[(index + 18) - 1] || "--" }}</span>
                    </div>

                  <!-- <input v-if="data[0].estandares.seccion === 3"
                         class="grd_input-code"
                         :disabled="data[0].user.rolname !== 'PROD'"
                         v-model="data[0].estandares.a6[(index + 18) - 1]"
                         maxlength="1"> -->
                  <h1 v-else-if="data[0].estandares.seccion !== 3 && data[0].estandares.a6[(index + 18) - 1]"
                      style="font-size:10px; color: #0000FF; font-weight: bold;">
                    {{ data[0].estandares.a6[(index + 18) - 1] }}
                  </h1>
                  <h1 v-else style="font-size:10px; color: #0000FF;">NA</h1>
                </th>

                <!-- Sección 4 -->
                <th style="text-align: center;" v-for="index in 6" :key="index + 's6h5'">
                    <div style="text-align: center;" class="select-wrapper" v-if="data[0].estandares.seccion === 4">
                        <select class="custom-select"
                                :disabled="data[0].user.rolname !== 'PROD'"
                                v-model="data[0].estandares.a6[(index + 24) - 1]">
                        <option value="">--</option> <!-- Permite quitar la selección -->
                        <option value="A">A</option>
                        <option value="V">V</option>
                        <option value="R">R</option>
                        </select>
                        <span class="selected-value">{{ data[0].estandares.a6[(index + 24) - 1] || "--" }}</span>
                    </div>

                  <!-- <input v-if="data[0].estandares.seccion === 4"
                         class="grd_input-code"
                         :disabled="data[0].user.rolname !== 'PROD'"
                         v-model="data[0].estandares.a6[(index + 24) - 1]"
                         maxlength="1"> -->
                  <h1 v-else-if="data[0].estandares.seccion !== 4 && data[0].estandares.a6[(index + 24) - 1]"
                      style="font-size:10px; color: #0000FF; font-weight: bold;">
                    {{ data[0].estandares.a6[(index + 24) - 1] }}
                  </h1>
                  <h1 v-else style="font-size:10px; color: #0000FF;">NA</h1>
                </th>

                <!-- Sección 5 -->
                <th style="text-align: center;" v-for="index in 6" :key="index + 's6h6'">
                    <div style="text-align: center;" class="select-wrapper" v-if="data[0].estandares.seccion === 5">
                        <select class="custom-select"
                                :disabled="data[0].user.rolname !== 'PROD'"
                                v-model="data[0].estandares.a6[(index + 30) - 1]">
                        <option value="">--</option> <!-- Permite quitar la selección -->
                        <option value="A">A</option>
                        <option value="V">V</option>
                        <option value="R">R</option>
                        </select>
                        <span class="selected-value">{{ data[0].estandares.a6[(index + 30) - 1] || "--" }}</span>
                    </div>

                  <!-- <input v-if="data[0].estandares.seccion === 5"
                         class="grd_input-code"
                         :disabled="data[0].user.rolname !== 'PROD'"
                         v-model="data[0].estandares.a6[(index + 30) - 1]"
                         maxlength="1"> -->
                  <h1 v-else-if="data[0].estandares.seccion !== 5 && data[0].estandares.a6[(index + 30) - 1]"
                      style="font-size:10px; color: #0000FF; font-weight: bold;">
                    {{ data[0].estandares.a6[(index + 30) - 1] }}
                  </h1>
                  <h1 v-else style="font-size:10px; color: #0000FF;">NA</h1>
                </th>

                <!-- Sección 6 -->
                <th style="text-align: center;" v-for="index in 6" :key="index + 's6h7'">
                    <div style="text-align: center;" class="select-wrapper" v-if="data[0].estandares.seccion === 6">
                        <select class="custom-select"
                                :disabled="data[0].user.rolname !== 'PROD'"
                                v-model="data[0].estandares.a6[(index + 36) - 1]">
                        <option value="">--</option> <!-- Permite quitar la selección -->
                        <option value="A">A</option>
                        <option value="V">V</option>
                        <option value="R">R</option>
                        </select>
                        <span class="selected-value">{{ data[0].estandares.a6[(index + 36) - 1] || "--" }}</span>
                    </div>

                  <!-- <input v-if="data[0].estandares.seccion === 6"
                         class="grd_input-code"
                         :disabled="data[0].user.rolname !== 'PROD'"
                         v-model="data[0].estandares.a6[(index + 36) - 1]"
                         maxlength="1"> -->
                  <h1 v-else-if="data[0].estandares.seccion !== 6 && data[0].estandares.a6[(index + 36) - 1]"
                      style="font-size:10px; color: #0000FF; font-weight: bold;">
                    {{ data[0].estandares.a6[(index + 36) - 1] }}
                  </h1>
                  <h1 v-else style="font-size:10px; color: #0000FF;">NA</h1>
                </th>

                <!-- Sección 7 -->
                <th style="text-align: center;" v-for="index in 6" :key="index + 's6h8'">
                    <div style="text-align: center;" class="select-wrapper" v-if="data[0].estandares.seccion === 7">
                        <select class="custom-select"
                                :disabled="data[0].user.rolname !== 'PROD'"
                                v-model="data[0].estandares.a6[(index + 42) - 1]">
                        <option value="">--</option> <!-- Permite quitar la selección -->
                        <option value="A">A</option>
                        <option value="V">V</option>
                        <option value="R">R</option>
                        </select>
                        <span class="selected-value">{{ data[0].estandares.a6[(index + 42) - 1] || "--" }}</span>
                    </div>

                  <!-- <input v-if="data[0].estandares.seccion === 7"
                         class="grd_input-code"
                         :disabled="data[0].user.rolname !== 'PROD'"
                         v-model="data[0].estandares.a6[(index + 42) - 1]"
                         maxlength="1"> -->
                  <h1 v-else-if="data[0].estandares.seccion !== 7 && data[0].estandares.a6[(index + 42) - 1]"
                      style="font-size:10px; color: #0000FF; font-weight: bold;">
                    {{ data[0].estandares.a6[(index + 42) - 1] }}
                  </h1>
                  <h1 v-else style="font-size:10px; color: #0000FF;">NA</h1>
                </th>

              </tr>


              <tr>
                <th scope="col">Cualquier componente del producto no corresponda con el estandar</th>

                <!-- Sección 0 -->
                <th style="text-align: center;" v-for="index in 6" :key="index + 's7h1'">
                    <div style="text-align: center;" class="select-wrapper" v-if="data[0].estandares.seccion === 0">
                        <select class="custom-select"
                                :disabled="data[0].user.rolname !== 'PROD'"
                                v-model="data[0].estandares.a7[index - 1]">
                        <option value="">--</option> <!-- Permite quitar la selección -->
                        <option value="A">A</option>
                        <option value="V">V</option>
                        <option value="R">R</option>
                        </select>
                        <span class="selected-value">{{ data[0].estandares.a7[index - 1] || "--" }}</span>
                    </div>

                  <!-- <input v-if="data[0].estandares.seccion === 0"
                         class="grd_input-code"
                         :disabled="data[0].user.rolname !== 'PROD'"
                         v-model="data[0].estandares.a7[index - 1]"
                         maxlength="1"> -->
                  <h1 v-else-if="data[0].estandares.seccion !== 0 && data[0].estandares.a7[index - 1]"
                      style="font-size:10px; color: #0000FF; font-weight: bold;">
                    {{ data[0].estandares.a7[index - 1] }}
                  </h1>
                  <h1 v-else style="font-size:10px; color: #0000FF;">NA</h1>
                </th>

                <!-- Sección 1 -->
                <th style="text-align: center;" v-for="index in 6" :key="index + 's7h2'">
                    <div style="text-align: center;" class="select-wrapper" v-if="data[0].estandares.seccion === 1">
                        <select class="custom-select"
                                :disabled="data[0].user.rolname !== 'PROD'"
                                v-model="data[0].estandares.a7[(index + 6) - 1]">
                        <option value="">--</option> <!-- Permite quitar la selección -->
                        <option value="A">A</option>
                        <option value="V">V</option>
                        <option value="R">R</option>
                        </select>
                        <span class="selected-value">{{ data[0].estandares.a7[(index + 6) - 1] || "--" }}</span>
                    </div>

                  <!-- <input v-if="data[0].estandares.seccion === 1"
                         class="grd_input-code"
                         :disabled="data[0].user.rolname !== 'PROD'"
                         v-model="data[0].estandares.a7[(index + 6) - 1]"
                         maxlength="1"> -->
                  <h1 v-else-if="data[0].estandares.seccion !== 1 && data[0].estandares.a7[(index + 6) - 1]"
                      style="font-size:10px; color: #0000FF; font-weight: bold;">
                    {{ data[0].estandares.a7[(index + 6) - 1] }}
                  </h1>
                  <h1 v-else style="font-size:10px; color: #0000FF;">NA</h1>
                </th>

                <!-- Sección 2 -->
                <th style="text-align: center;" v-for="index in 6" :key="index + 's7h3'">
                    <div style="text-align: center;" class="select-wrapper" v-if="data[0].estandares.seccion === 2">
                        <select class="custom-select"
                                :disabled="data[0].user.rolname !== 'PROD'"
                                v-model="data[0].estandares.a7[(index + 12) - 1]">
                        <option value="">--</option> <!-- Permite quitar la selección -->
                        <option value="A">A</option>
                        <option value="V">V</option>
                        <option value="R">R</option>
                        </select>
                        <span class="selected-value">{{ data[0].estandares.a7[(index + 12) - 1] || "--" }}</span>
                    </div>

                  <!-- <input v-if="data[0].estandares.seccion === 2"
                         class="grd_input-code"
                         :disabled="data[0].user.rolname !== 'PROD'"
                         v-model="data[0].estandares.a7[(index + 12) - 1]"
                         maxlength="1"> -->
                  <h1 v-else-if="data[0].estandares.seccion !== 2 && data[0].estandares.a7[(index + 12) - 1]"
                      style="font-size:10px; color: #0000FF; font-weight: bold;">
                    {{ data[0].estandares.a7[(index + 12) - 1] }}
                  </h1>
                  <h1 v-else style="font-size:10px; color: #0000FF;">NA</h1>
                </th>

                <!-- Sección 3 -->
                <th style="text-align: center;" v-for="index in 6" :key="index + 's7h4'">
                    <div style="text-align: center;" class="select-wrapper" v-if="data[0].estandares.seccion === 3">
                        <select class="custom-select"
                                :disabled="data[0].user.rolname !== 'PROD'"
                                v-model="data[0].estandares.a7[(index + 18) - 1]">
                        <option value="">--</option> <!-- Permite quitar la selección -->
                        <option value="A">A</option>
                        <option value="V">V</option>
                        <option value="R">R</option>
                        </select>
                        <span class="selected-value">{{ data[0].estandares.a7[(index + 18) - 1] || "--" }}</span>
                    </div>

                  <!-- <input v-if="data[0].estandares.seccion === 3"
                         class="grd_input-code"
                         :disabled="data[0].user.rolname !== 'PROD'"
                         v-model="data[0].estandares.a7[(index + 18) - 1]"
                         maxlength="1"> -->
                  <h1 v-else-if="data[0].estandares.seccion !== 3 && data[0].estandares.a7[(index + 18) - 1]"
                      style="font-size:10px; color: #0000FF; font-weight: bold;">
                    {{ data[0].estandares.a7[(index + 18) - 1] }}
                  </h1>
                  <h1 v-else style="font-size:10px; color: #0000FF;">NA</h1>
                </th>

                <!-- Sección 4 -->
                <th style="text-align: center;" v-for="index in 6" :key="index + 's7h5'">
                    <div style="text-align: center;" class="select-wrapper" v-if="data[0].estandares.seccion === 4">
                        <select class="custom-select"
                                :disabled="data[0].user.rolname !== 'PROD'"
                                v-model="data[0].estandares.a7[(index + 24) - 1]">
                        <option value="">--</option> <!-- Permite quitar la selección -->
                        <option value="A">A</option>
                        <option value="V">V</option>
                        <option value="R">R</option>
                        </select>
                        <span class="selected-value">{{ data[0].estandares.a7[(index + 24) - 1] || "--" }}</span>
                    </div>

                  <!-- <input v-if="data[0].estandares.seccion === 4"
                         class="grd_input-code"
                         :disabled="data[0].user.rolname !== 'PROD'"
                         v-model="data[0].estandares.a7[(index + 24) - 1]"
                         maxlength="1"> -->
                  <h1 v-else-if="data[0].estandares.seccion !== 4 && data[0].estandares.a7[(index + 24) - 1]"
                      style="font-size:10px; color: #0000FF; font-weight: bold;">
                    {{ data[0].estandares.a7[(index + 24) - 1] }}
                  </h1>
                  <h1 v-else style="font-size:10px; color: #0000FF;">NA</h1>
                </th>

                <!-- Sección 5 -->
                <th style="text-align: center;" v-for="index in 6" :key="index + 's7h6'">
                    <div style="text-align: center;" class="select-wrapper" v-if="data[0].estandares.seccion === 5">
                        <select class="custom-select"
                                :disabled="data[0].user.rolname !== 'PROD'"
                                v-model="data[0].estandares.a7[(index + 30) - 1]">
                        <option value="">--</option> <!-- Permite quitar la selección -->
                        <option value="A">A</option>
                        <option value="V">V</option>
                        <option value="R">R</option>
                        </select>
                        <span class="selected-value">{{ data[0].estandares.a7[(index + 30) - 1] || "--" }}</span>
                    </div>

                  <!-- <input v-if="data[0].estandares.seccion === 5"
                         class="grd_input-code"
                         :disabled="data[0].user.rolname !== 'PROD'"
                         v-model="data[0].estandares.a7[(index + 30) - 1]"
                         maxlength="1"> -->
                  <h1 v-else-if="data[0].estandares.seccion !== 5 && data[0].estandares.a7[(index + 30) - 1]"
                      style="font-size:10px; color: #0000FF; font-weight: bold;">
                    {{ data[0].estandares.a7[(index + 30) - 1] }}
                  </h1>
                  <h1 v-else style="font-size:10px; color: #0000FF;">NA</h1>
                </th>

                <!-- Sección 6 -->
                <th style="text-align: center;" v-for="index in 6" :key="index + 's7h7'">
                    <div style="text-align: center;" class="select-wrapper" v-if="data[0].estandares.seccion === 6">
                        <select class="custom-select"
                                :disabled="data[0].user.rolname !== 'PROD'"
                                v-model="data[0].estandares.a7[(index + 36) - 1]">
                        <option value="">--</option> <!-- Permite quitar la selección -->
                        <option value="A">A</option>
                        <option value="V">V</option>
                        <option value="R">R</option>
                        </select>
                        <span class="selected-value">{{ data[0].estandares.a7[(index + 36) - 1] || "--" }}</span>
                    </div>

                  <!-- <input v-if="data[0].estandares.seccion === 6"
                         class="grd_input-code"
                         :disabled="data[0].user.rolname !== 'PROD'"
                         v-model="data[0].estandares.a7[(index + 36) - 1]"
                         maxlength="1"> -->
                  <h1 v-else-if="data[0].estandares.seccion !== 6 && data[0].estandares.a7[(index + 36) - 1]"
                      style="font-size:10px; color: #0000FF; font-weight: bold;">
                    {{ data[0].estandares.a7[(index + 36) - 1] }}
                  </h1>
                  <h1 v-else style="font-size:10px; color: #0000FF;">NA</h1>
                </th>

                <!-- Sección 7 -->
                <th style="text-align: center;" v-for="index in 6" :key="index + 's7h8'">
                    <div style="text-align: center;" class="select-wrapper" v-if="data[0].estandares.seccion === 7">
                        <select class="custom-select"
                                :disabled="data[0].user.rolname !== 'PROD'"
                                v-model="data[0].estandares.a7[(index + 42) - 1]">
                        <option value="">--</option> <!-- Permite quitar la selección -->
                        <option value="A">A</option>
                        <option value="V">V</option>
                        <option value="R">R</option>
                        </select>
                        <span class="selected-value">{{ data[0].estandares.a7[(index + 42) - 1] || "--" }}</span>
                    </div>

                  <!-- <input v-if="data[0].estandares.seccion === 7"
                         class="grd_input-code"
                         :disabled="data[0].user.rolname !== 'PROD'"
                         v-model="data[0].estandares.a7[(index + 42) - 1]"
                         maxlength="1"> -->
                  <h1 v-else-if="data[0].estandares.seccion !== 7 && data[0].estandares.a7[(index + 42) - 1]"
                      style="font-size:10px; color: #0000FF; font-weight: bold;">
                    {{ data[0].estandares.a7[(index + 42) - 1] }}
                  </h1>
                  <h1 v-else style="font-size:10px; color: #0000FF;">NA</h1>
                </th>
              </tr>

              <tr>
                <th scope="col">Delaminacion</th>

                <!-- Sección 0 -->
                <th style="text-align: center;" v-for="index in 6" :key="index + 's8h1'">
                    <div style="text-align: center;" class="select-wrapper" v-if="data[0].estandares.seccion === 0">
                        <select class="custom-select"
                                :disabled="data[0].user.rolname !== 'PROD'"
                                v-model="data[0].estandares.a8[index - 1]">
                        <option value="">--</option> <!-- Permite quitar la selección -->
                        <option value="A">A</option>
                        <option value="V">V</option>
                        <option value="R">R</option>
                        </select>
                        <span class="selected-value">{{ data[0].estandares.a8[index - 1] || "--" }}</span>
                    </div>

                  <!-- <input v-if="data[0].estandares.seccion === 0"
                         class="grd_input-code"
                         :disabled="data[0].user.rolname !== 'PROD'"
                         v-model="data[0].estandares.a8[index - 1]"
                         maxlength="1"> -->
                  <h1 v-else-if="data[0].estandares.seccion !== 0 && data[0].estandares.a8[index - 1]"
                      style="font-size:10px; color: #0000FF; font-weight: bold;">
                    {{ data[0].estandares.a8[index - 1] }}
                  </h1>
                  <h1 v-else style="font-size:10px; color: #0000FF;">NA</h1>
                </th>

                <!-- Sección 1 -->
                <th style="text-align: center;" v-for="index in 6" :key="index + 's8h2'">
                    <div style="text-align: center;" class="select-wrapper" v-if="data[0].estandares.seccion === 1">
                        <select class="custom-select"
                                :disabled="data[0].user.rolname !== 'PROD'"
                                v-model="data[0].estandares.a8[(index + 6) - 1]">
                        <option value="">--</option> <!-- Permite quitar la selección -->
                        <option value="A">A</option>
                        <option value="V">V</option>
                        <option value="R">R</option>
                        </select>
                        <span class="selected-value">{{ data[0].estandares.a8[(index + 6) - 1] || "--" }}</span>
                    </div>

                  <!-- <input v-if="data[0].estandares.seccion === 1"
                         class="grd_input-code"
                         :disabled="data[0].user.rolname !== 'PROD'"
                         v-model="data[0].estandares.a8[(index + 6) - 1]"
                         maxlength="1"> -->
                  <h1 v-else-if="data[0].estandares.seccion !== 1 && data[0].estandares.a8[(index + 6) - 1]"
                      style="font-size:10px; color: #0000FF; font-weight: bold;">
                    {{ data[0].estandares.a8[(index + 6) - 1] }}
                  </h1>
                  <h1 v-else style="font-size:10px; color: #0000FF;">NA</h1>
                </th>

                <!-- Sección 2 -->
                <th style="text-align: center;" v-for="index in 6" :key="index + 's8h3'">
                    <div style="text-align: center;" class="select-wrapper" v-if="data[0].estandares.seccion === 2">
                        <select class="custom-select"
                                :disabled="data[0].user.rolname !== 'PROD'"
                                v-model="data[0].estandares.a8[(index + 12) - 1]">
                        <option value="">--</option> <!-- Permite quitar la selección -->
                        <option value="A">A</option>
                        <option value="V">V</option>
                        <option value="R">R</option>
                        </select>
                        <span class="selected-value">{{ data[0].estandares.a8[(index + 12) - 1] || "--" }}</span>
                    </div>

                  <!-- <input v-if="data[0].estandares.seccion === 2"
                         class="grd_input-code"
                         :disabled="data[0].user.rolname !== 'PROD'"
                         v-model="data[0].estandares.a8[(index + 12) - 1]"
                         maxlength="1"> -->
                  <h1 v-else-if="data[0].estandares.seccion !== 2 && data[0].estandares.a8[(index + 12) - 1]"
                      style="font-size:10px; color: #0000FF; font-weight: bold;">
                    {{ data[0].estandares.a8[(index + 12) - 1] }}
                  </h1>
                  <h1 v-else style="font-size:10px; color: #0000FF;">NA</h1>
                </th>

                <!-- Sección 3 -->
                <th style="text-align: center;" v-for="index in 6" :key="index + 's8h4'">
                    <div style="text-align: center;" class="select-wrapper" v-if="data[0].estandares.seccion === 3">
                        <select class="custom-select"
                                :disabled="data[0].user.rolname !== 'PROD'"
                                v-model="data[0].estandares.a8[(index + 18) - 1]">
                        <option value="">--</option> <!-- Permite quitar la selección -->
                        <option value="A">A</option>
                        <option value="V">V</option>
                        <option value="R">R</option>
                        </select>
                        <span class="selected-value">{{ data[0].estandares.a8[(index + 18) - 1] || "--" }}</span>
                    </div>

                  <!-- <input v-if="data[0].estandares.seccion === 3"
                         class="grd_input-code"
                         :disabled="data[0].user.rolname !== 'PROD'"
                         v-model="data[0].estandares.a8[(index + 18) - 1]"
                         maxlength="1"> -->
                  <h1 v-else-if="data[0].estandares.seccion !== 3 && data[0].estandares.a8[(index + 18) - 1]"
                      style="font-size:10px; color: #0000FF; font-weight: bold;">
                    {{ data[0].estandares.a8[(index + 18) - 1] }}
                  </h1>
                  <h1 v-else style="font-size:10px; color: #0000FF;">NA</h1>
                </th>

                <!-- Sección 4 -->
                <th style="text-align: center;" v-for="index in 6" :key="index + 's8h5'">
                    <div style="text-align: center;" class="select-wrapper" v-if="data[0].estandares.seccion === 4">
                        <select class="custom-select"
                                :disabled="data[0].user.rolname !== 'PROD'"
                                v-model="data[0].estandares.a8[(index + 24) - 1]">
                        <option value="">--</option> <!-- Permite quitar la selección -->
                        <option value="A">A</option>
                        <option value="V">V</option>
                        <option value="R">R</option>
                        </select>
                        <span class="selected-value">{{ data[0].estandares.a8[(index + 24) - 1] || "--" }}</span>
                    </div>

                  <!-- <input v-if="data[0].estandares.seccion === 4"
                         class="grd_input-code"
                         :disabled="data[0].user.rolname !== 'PROD'"
                         v-model="data[0].estandares.a8[(index + 24) - 1]"
                         maxlength="1"> -->
                  <h1 v-else-if="data[0].estandares.seccion !== 4 && data[0].estandares.a8[(index + 24) - 1]"
                      style="font-size:10px; color: #0000FF; font-weight: bold;">
                    {{ data[0].estandares.a8[(index + 24) - 1] }}
                  </h1>
                  <h1 v-else style="font-size:10px; color: #0000FF;">NA</h1>
                </th>

                <!-- Sección 5 -->
                <th style="text-align: center;" v-for="index in 6" :key="index + 's8h6'">
                    <div style="text-align: center;" class="select-wrapper" v-if="data[0].estandares.seccion === 5">
                        <select class="custom-select"
                                :disabled="data[0].user.rolname !== 'PROD'"
                                v-model="data[0].estandares.a8[(index + 30) - 1]">
                        <option value="">--</option> <!-- Permite quitar la selección -->
                        <option value="A">A</option>
                        <option value="V">V</option>
                        <option value="R">R</option>
                        </select>
                        <span class="selected-value">{{ data[0].estandares.a8[(index + 30) - 1] || "--" }}</span>
                    </div>

                  <!-- <input v-if="data[0].estandares.seccion === 5"
                         class="grd_input-code"
                         :disabled="data[0].user.rolname !== 'PROD'"
                         v-model="data[0].estandares.a8[(index + 30) - 1]"
                         maxlength="1"> -->
                  <h1 v-else-if="data[0].estandares.seccion !== 5 && data[0].estandares.a8[(index + 30) - 1]"
                      style="font-size:10px; color: #0000FF; font-weight: bold;">
                    {{ data[0].estandares.a8[(index + 30) - 1] }}
                  </h1>
                  <h1 v-else style="font-size:10px; color: #0000FF;">NA</h1>
                </th>

                <!-- Sección 6 -->
                <th style="text-align: center;" v-for="index in 6" :key="index + 's8h7'">
                    <div style="text-align: center;" class="select-wrapper" v-if="data[0].estandares.seccion === 6">
                        <select class="custom-select"
                                :disabled="data[0].user.rolname !== 'PROD'"
                                v-model="data[0].estandares.a8[(index + 36) - 1]">
                        <option value="">--</option> <!-- Permite quitar la selección -->
                        <option value="A">A</option>
                        <option value="V">V</option>
                        <option value="R">R</option>
                        </select>
                        <span class="selected-value">{{ data[0].estandares.a8[(index + 36) - 1] || "--" }}</span>
                    </div>

                  <!-- <input v-if="data[0].estandares.seccion === 6"
                         class="grd_input-code"
                         :disabled="data[0].user.rolname !== 'PROD'"
                         v-model="data[0].estandares.a8[(index + 36) - 1]"
                         maxlength="1"> -->
                  <h1 v-else-if="data[0].estandares.seccion !== 6 && data[0].estandares.a8[(index + 36) - 1]"
                      style="font-size:10px; color: #0000FF; font-weight: bold;">
                    {{ data[0].estandares.a8[(index + 36) - 1] }}
                  </h1>
                  <h1 v-else style="font-size:10px; color: #0000FF;">NA</h1>
                </th>

                <!-- Sección 7 -->
                <th style="text-align: center;" v-for="index in 6" :key="index + 's8h8'">
                    <div style="text-align: center;" class="select-wrapper" v-if="data[0].estandares.seccion === 7">
                        <select class="custom-select"
                                :disabled="data[0].user.rolname !== 'PROD'"
                                v-model="data[0].estandares.a8[(index + 42) - 1]">
                        <option value="">--</option> <!-- Permite quitar la selección -->
                        <option value="A">A</option>
                        <option value="V">V</option>
                        <option value="R">R</option>
                        </select>
                        <span class="selected-value">{{ data[0].estandares.a8[(index + 42) - 1] || "--" }}</span>
                    </div>

                  <!-- <input v-if="data[0].estandares.seccion === 7"
                         class="grd_input-code"
                         :disabled="data[0].user.rolname !== 'PROD'"
                         v-model="data[0].estandares.a8[(index + 42) - 1]"
                         maxlength="1"> -->
                  <h1 v-else-if="data[0].estandares.seccion !== 7 && data[0].estandares.a8[(index + 42) - 1]"
                      style="font-size:10px; color: #0000FF; font-weight: bold;">
                    {{ data[0].estandares.a8[(index + 42) - 1] }}
                  </h1>
                  <h1 v-else style="font-size:10px; color: #0000FF;">NA</h1>
                </th>
              </tr>

              <tr>
                <th scope="col">Sello alineado</th>

                <!-- Sección 0 -->
                <th style="text-align: center;" v-for="index in 6" :key="index + 's9h1'">
                    <div style="text-align: center;" class="select-wrapper" v-if="data[0].estandares.seccion === 0">
                        <select class="custom-select"
                                :disabled="data[0].user.rolname !== 'PROD'"
                                v-model="data[0].estandares.a9[index - 1]">
                        <option value="">--</option> <!-- Permite quitar la selección -->
                        <option value="A">A</option>
                        <option value="V">V</option>
                        <option value="R">R</option>
                        </select>
                        <span class="selected-value">{{ data[0].estandares.a9[index - 1] || "--" }}</span>
                    </div>

                  <!-- <input v-if="data[0].estandares.seccion === 0"
                         class="grd_input-code"
                         :disabled="data[0].user.rolname !== 'PROD'"
                         v-model="data[0].estandares.a9[index - 1]"
                         maxlength="1"> -->
                  <h1 v-else-if="data[0].estandares.seccion !== 0 && data[0].estandares.a9[index - 1]"
                      style="font-size:10px; color: #0000FF; font-weight: bold;">
                    {{ data[0].estandares.a9[index - 1] }}
                  </h1>
                  <h1 v-else style="font-size:10px; color: #0000FF;">NA</h1>
                </th>

                <!-- Sección 1 -->
                <th style="text-align: center;" v-for="index in 6" :key="index + 's9h2'">
                    <div style="text-align: center;" class="select-wrapper" v-if="data[0].estandares.seccion === 1">
                        <select class="custom-select"
                                :disabled="data[0].user.rolname !== 'PROD'"
                                v-model="data[0].estandares.a9[(index + 6) - 1]">
                        <option value="">--</option> <!-- Permite quitar la selección -->
                        <option value="A">A</option>
                        <option value="V">V</option>
                        <option value="R">R</option>
                        </select>
                        <span class="selected-value">{{ data[0].estandares.a9[(index + 6) - 1] || "--" }}</span>
                    </div>

                  <!-- <input v-if="data[0].estandares.seccion === 1"
                         class="grd_input-code"
                         :disabled="data[0].user.rolname !== 'PROD'"
                         v-model="data[0].estandares.a9[(index + 6) - 1]"
                         maxlength="1"> -->
                  <h1 v-else-if="data[0].estandares.seccion !== 1 && data[0].estandares.a9[(index + 6) - 1]"
                      style="font-size:10px; color: #0000FF; font-weight: bold;">
                    {{ data[0].estandares.a9[(index + 6) - 1] }}
                  </h1>
                  <h1 v-else style="font-size:10px; color: #0000FF;">NA</h1>
                </th>

                <!-- Sección 2 -->
                <th style="text-align: center;" v-for="index in 6" :key="index + 's9h3'">
                    <div style="text-align: center;" class="select-wrapper" v-if="data[0].estandares.seccion === 2">
                        <select class="custom-select"
                                :disabled="data[0].user.rolname !== 'PROD'"
                                v-model="data[0].estandares.a9[(index + 12) - 1]">
                        <option value="">--</option> <!-- Permite quitar la selección -->
                        <option value="A">A</option>
                        <option value="V">V</option>
                        <option value="R">R</option>
                        </select>
                        <span class="selected-value">{{ data[0].estandares.a9[(index + 12) - 1] || "--" }}</span>
                    </div>

                  <!-- <input v-if="data[0].estandares.seccion === 2"
                         class="grd_input-code"
                         :disabled="data[0].user.rolname !== 'PROD'"
                         v-model="data[0].estandares.a9[(index + 12) - 1]"
                         maxlength="1"> -->
                  <h1 v-else-if="data[0].estandares.seccion !== 2 && data[0].estandares.a9[(index + 12) - 1]"
                      style="font-size:10px; color: #0000FF; font-weight: bold;">
                    {{ data[0].estandares.a9[(index + 12) - 1] }}
                  </h1>
                  <h1 v-else style="font-size:10px; color: #0000FF;">NA</h1>
                </th>

                <!-- Sección 3 -->
                <th style="text-align: center;" v-for="index in 6" :key="index + 's9h4'">
                    <div style="text-align: center;" class="select-wrapper" v-if="data[0].estandares.seccion === 3">
                        <select class="custom-select"
                                :disabled="data[0].user.rolname !== 'PROD'"
                                v-model="data[0].estandares.a9[(index + 18) - 1]">
                        <option value="">--</option> <!-- Permite quitar la selección -->
                        <option value="A">A</option>
                        <option value="V">V</option>
                        <option value="R">R</option>
                        </select>
                        <span class="selected-value">{{ data[0].estandares.a9[(index + 18) - 1] || "--" }}</span>
                    </div>

                  <!-- <input v-if="data[0].estandares.seccion === 3"
                         class="grd_input-code"
                         :disabled="data[0].user.rolname !== 'PROD'"
                         v-model="data[0].estandares.a9[(index + 18) - 1]"
                         maxlength="1"> -->
                  <h1 v-else-if="data[0].estandares.seccion !== 3 && data[0].estandares.a9[(index + 18) - 1]"
                      style="font-size:10px; color: #0000FF; font-weight: bold;">
                    {{ data[0].estandares.a9[(index + 18) - 1] }}
                  </h1>
                  <h1 v-else style="font-size:10px; color: #0000FF;">NA</h1>
                </th>

                <!-- Sección 4 -->
                <th style="text-align: center;" v-for="index in 6" :key="index + 's9h5'">
                    <div style="text-align: center;" class="select-wrapper" v-if="data[0].estandares.seccion === 4">
                        <select class="custom-select"
                                :disabled="data[0].user.rolname !== 'PROD'"
                                v-model="data[0].estandares.a9[(index + 24) - 1]">
                        <option value="">--</option> <!-- Permite quitar la selección -->
                        <option value="A">A</option>
                        <option value="V">V</option>
                        <option value="R">R</option>
                        </select>
                        <span class="selected-value">{{ data[0].estandares.a9[(index + 24) - 1] || "--" }}</span>
                    </div>

                  <!-- <input v-if="data[0].estandares.seccion === 4"
                         class="grd_input-code"
                         :disabled="data[0].user.rolname !== 'PROD'"
                         v-model="data[0].estandares.a9[(index + 24) - 1]"
                         maxlength="1"> -->
                  <h1 v-else-if="data[0].estandares.seccion !== 4 && data[0].estandares.a9[(index + 24) - 1]"
                      style="font-size:10px; color: #0000FF; font-weight: bold;">
                    {{ data[0].estandares.a9[(index + 24) - 1] }}
                  </h1>
                  <h1 v-else style="font-size:10px; color: #0000FF;">NA</h1>
                </th>

                <!-- Sección 5 -->
                <th style="text-align: center;" v-for="index in 6" :key="index + 's9h6'">
                    <div style="text-align: center;" class="select-wrapper" v-if="data[0].estandares.seccion === 5">
                        <select class="custom-select"
                                :disabled="data[0].user.rolname !== 'PROD'"
                                v-model="data[0].estandares.a9[(index + 30) - 1]">
                        <option value="">--</option> <!-- Permite quitar la selección -->
                        <option value="A">A</option>
                        <option value="V">V</option>
                        <option value="R">R</option>
                        </select>
                        <span class="selected-value">{{ data[0].estandares.a9[(index + 30) - 1] || "--" }}</span>
                    </div>

                  <!-- <input v-if="data[0].estandares.seccion === 5"
                         class="grd_input-code"
                         :disabled="data[0].user.rolname !== 'PROD'"
                         v-model="data[0].estandares.a9[(index + 30) - 1]"
                         maxlength="1"> -->
                  <h1 v-else-if="data[0].estandares.seccion !== 5 && data[0].estandares.a9[(index + 30) - 1]"
                      style="font-size:10px; color: #0000FF; font-weight: bold;">
                    {{ data[0].estandares.a9[(index + 30) - 1] }}
                  </h1>
                  <h1 v-else style="font-size:10px; color: #0000FF;">NA</h1>
                </th>

                <!-- Sección 6 -->
                <th style="text-align: center;" v-for="index in 6" :key="index + 's9h7'">
                    <div style="text-align: center;" class="select-wrapper" v-if="data[0].estandares.seccion === 6">
                        <select class="custom-select"
                                :disabled="data[0].user.rolname !== 'PROD'"
                                v-model="data[0].estandares.a9[(index + 36) - 1]">
                        <option value="">--</option> <!-- Permite quitar la selección -->
                        <option value="A">A</option>
                        <option value="V">V</option>
                        <option value="R">R</option>
                        </select>
                        <span class="selected-value">{{ data[0].estandares.a9[(index + 36) - 1] || "--" }}</span>
                    </div>

                  <!-- <input v-if="data[0].estandares.seccion === 6"
                         class="grd_input-code"
                         :disabled="data[0].user.rolname !== 'PROD'"
                         v-model="data[0].estandares.a9[(index + 36) - 1]"
                         maxlength="1"> -->
                  <h1 v-else-if="data[0].estandares.seccion !== 6 && data[0].estandares.a9[(index + 36) - 1]"
                      style="font-size:10px; color: #0000FF; font-weight: bold;">
                    {{ data[0].estandares.a9[(index + 36) - 1] }}
                  </h1>
                  <h1 v-else style="font-size:10px; color: #0000FF;">NA</h1>
                </th>

                <!-- Sección 7 -->
                <th style="text-align: center;" v-for="index in 6" :key="index + 's9h8'">
                    <div style="text-align: center;" class="select-wrapper" v-if="data[0].estandares.seccion === 7">
                        <select class="custom-select"
                                :disabled="data[0].user.rolname !== 'PROD'"
                                v-model="data[0].estandares.a9[(index + 42) - 1]">
                        <option value="">--</option> <!-- Permite quitar la selección -->
                        <option value="A">A</option>
                        <option value="V">V</option>
                        <option value="R">R</option>
                        </select>
                        <span class="selected-value">{{ data[0].estandares.a9[(index + 42) - 1] || "--" }}</span>
                    </div>

                  <!-- <input v-if="data[0].estandares.seccion === 7"
                         class="grd_input-code"
                         :disabled="data[0].user.rolname !== 'PROD'"
                         v-model="data[0].estandares.a9[(index + 42) - 1]"
                         maxlength="1"> -->
                  <h1 v-else-if="data[0].estandares.seccion !== 7 && data[0].estandares.a9[(index + 42) - 1]"
                      style="font-size:10px; color: #0000FF; font-weight: bold;">
                    {{ data[0].estandares.a9[(index + 42) - 1] }}
                  </h1>
                  <h1 v-else style="font-size:10px; color: #0000FF;">NA</h1>
                </th>
              </tr>



              <tr>
                <th scope="col">Sello quemado</th>

                <!-- Sección 0 -->
                <th style="text-align: center;" v-for="index in 6" :key="index + 's10h1'">
                    <div style="text-align: center;" class="select-wrapper" v-if="data[0].estandares.seccion === 0">
                        <select class="custom-select"
                                :disabled="data[0].user.rolname !== 'PROD'"
                                v-model="data[0].estandares.a10[index - 1]">
                        <option value="">--</option> <!-- Permite quitar la selección -->
                        <option value="A">A</option>
                        <option value="V">V</option>
                        <option value="R">R</option>
                        </select>
                        <span class="selected-value">{{ data[0].estandares.a10[index - 1] || "--" }}</span>
                    </div>

                  <!-- <input v-if="data[0].estandares.seccion === 0"
                         class="grd_input-code"
                         :disabled="data[0].user.rolname !== 'PROD'"
                         v-model="data[0].estandares.a10[index - 1]"
                         maxlength="1"> -->
                  <h1 v-else-if="data[0].estandares.seccion !== 0 && data[0].estandares.a10[index - 1]"
                      style="font-size:10px; color: #0000FF; font-weight: bold;">
                    {{ data[0].estandares.a10[index - 1] }}
                  </h1>
                  <h1 v-else style="font-size:10px; color: #0000FF;">NA</h1>
                </th>

                <!-- Sección 1 -->
                <th style="text-align: center;" v-for="index in 6" :key="index + 's10h2'">
                    <div style="text-align: center;" class="select-wrapper" v-if="data[0].estandares.seccion === 1">
                        <select class="custom-select"
                                :disabled="data[0].user.rolname !== 'PROD'"
                                v-model="data[0].estandares.a10[(index + 6) - 1]">
                        <option value="">--</option> <!-- Permite quitar la selección -->
                        <option value="A">A</option>
                        <option value="V">V</option>
                        <option value="R">R</option>
                        </select>
                        <span class="selected-value">{{ data[0].estandares.a10[(index + 6) - 1] || "--" }}</span>
                    </div>

                  <!-- <input v-if="data[0].estandares.seccion === 1"
                         class="grd_input-code"
                         :disabled="data[0].user.rolname !== 'PROD'"
                         v-model="data[0].estandares.a10[(index + 6) - 1]"
                         maxlength="1"> -->
                  <h1 v-else-if="data[0].estandares.seccion !== 1 && data[0].estandares.a10[(index + 6) - 1]"
                      style="font-size:10px; color: #0000FF; font-weight: bold;">
                    {{ data[0].estandares.a10[(index + 6) - 1] }}
                  </h1>
                  <h1 v-else style="font-size:10px; color: #0000FF;">NA</h1>
                </th>

                <!-- Sección 2 -->
                <th style="text-align: center;" v-for="index in 6" :key="index + 's10h3'">
                    <div style="text-align: center;" class="select-wrapper" v-if="data[0].estandares.seccion === 2">
                        <select class="custom-select"
                                :disabled="data[0].user.rolname !== 'PROD'"
                                v-model="data[0].estandares.a10[(index + 12) - 1]">
                        <option value="">--</option> <!-- Permite quitar la selección -->
                        <option value="A">A</option>
                        <option value="V">V</option>
                        <option value="R">R</option>
                        </select>
                        <span class="selected-value">{{ data[0].estandares.a10[(index + 12) - 1] || "--" }}</span>
                    </div>

                  <!-- <input v-if="data[0].estandares.seccion === 2"
                         class="grd_input-code"
                         :disabled="data[0].user.rolname !== 'PROD'"
                         v-model="data[0].estandares.a10[(index + 12) - 1]"
                         maxlength="1"> -->
                  <h1 v-else-if="data[0].estandares.seccion !== 2 && data[0].estandares.a10[(index + 12) - 1]"
                      style="font-size:10px; color: #0000FF; font-weight: bold;">
                    {{ data[0].estandares.a10[(index + 12) - 1] }}
                  </h1>
                  <h1 v-else style="font-size:10px; color: #0000FF;">NA</h1>
                </th>

                <!-- Sección 3 -->
                <th style="text-align: center;" v-for="index in 6" :key="index + 's10h4'">
                    <div style="text-align: center;" class="select-wrapper" v-if="data[0].estandares.seccion === 3">
                        <select class="custom-select"
                                :disabled="data[0].user.rolname !== 'PROD'"
                                v-model="data[0].estandares.a10[(index + 18) - 1]">
                        <option value="">--</option> <!-- Permite quitar la selección -->
                        <option value="A">A</option>
                        <option value="V">V</option>
                        <option value="R">R</option>
                        </select>
                        <span class="selected-value">{{ data[0].estandares.a10[(index + 18) - 1] || "--" }}</span>
                    </div>

                  <!-- <input v-if="data[0].estandares.seccion === 3"
                         class="grd_input-code"
                         :disabled="data[0].user.rolname !== 'PROD'"
                         v-model="data[0].estandares.a10[(index + 18) - 1]"
                         maxlength="1"> -->
                  <h1 v-else-if="data[0].estandares.seccion !== 3 && data[0].estandares.a10[(index + 18) - 1]"
                      style="font-size:10px; color: #0000FF; font-weight: bold;">
                    {{ data[0].estandares.a10[(index + 18) - 1] }}
                  </h1>
                  <h1 v-else style="font-size:10px; color: #0000FF;">NA</h1>
                </th>

                <!-- Sección 4 -->
                <th style="text-align: center;" v-for="index in 6" :key="index + 's10h5'">
                    <div style="text-align: center;" class="select-wrapper" v-if="data[0].estandares.seccion === 4">
                        <select class="custom-select"
                                :disabled="data[0].user.rolname !== 'PROD'"
                                v-model="data[0].estandares.a10[(index + 24) - 1]">
                        <option value="">--</option> <!-- Permite quitar la selección -->
                        <option value="A">A</option>
                        <option value="V">V</option>
                        <option value="R">R</option>
                        </select>
                        <span class="selected-value">{{ data[0].estandares.a10[(index + 24) - 1] || "--" }}</span>
                    </div>

                  <!-- <input v-if="data[0].estandares.seccion === 4"
                         class="grd_input-code"
                         :disabled="data[0].user.rolname !== 'PROD'"
                         v-model="data[0].estandares.a10[(index + 24) - 1]"
                         maxlength="1"> -->
                  <h1 v-else-if="data[0].estandares.seccion !== 4 && data[0].estandares.a10[(index + 24) - 1]"
                      style="font-size:10px; color: #0000FF; font-weight: bold;">
                    {{ data[0].estandares.a10[(index + 24) - 1] }}
                  </h1>
                  <h1 v-else style="font-size:10px; color: #0000FF;">NA</h1>
                </th>

                <!-- Sección 5 -->
                <th style="text-align: center;" v-for="index in 6" :key="index + 's10h6'">
                    <div style="text-align: center;" class="select-wrapper" v-if="data[0].estandares.seccion === 5">
                        <select class="custom-select"
                                :disabled="data[0].user.rolname !== 'PROD'"
                                v-model="data[0].estandares.a10[(index + 30) - 1]">
                        <option value="">--</option> <!-- Permite quitar la selección -->
                        <option value="A">A</option>
                        <option value="V">V</option>
                        <option value="R">R</option>
                        </select>
                        <span class="selected-value">{{ data[0].estandares.a10[(index + 30) - 1] || "--" }}</span>
                    </div>

                  <!-- <input v-if="data[0].estandares.seccion === 5"
                         class="grd_input-code"
                         :disabled="data[0].user.rolname !== 'PROD'"
                         v-model="data[0].estandares.a10[(index + 30) - 1]"
                         maxlength="1"> -->
                  <h1 v-else-if="data[0].estandares.seccion !== 5 && data[0].estandares.a10[(index + 30) - 1]"
                      style="font-size:10px; color: #0000FF; font-weight: bold;">
                    {{ data[0].estandares.a10[(index + 30) - 1] }}
                  </h1>
                  <h1 v-else style="font-size:10px; color: #0000FF;">NA</h1>
                </th>

                <!-- Sección 6 -->
                <th style="text-align: center;" v-for="index in 6" :key="index + 's10h7'">
                    <div style="text-align: center;" class="select-wrapper" v-if="data[0].estandares.seccion === 6">
                        <select class="custom-select"
                                :disabled="data[0].user.rolname !== 'PROD'"
                                v-model="data[0].estandares.a10[(index + 36) - 1]">
                        <option value="">--</option> <!-- Permite quitar la selección -->
                        <option value="A">A</option>
                        <option value="V">V</option>
                        <option value="R">R</option>
                        </select>
                        <span class="selected-value">{{ data[0].estandares.a10[(index + 36) - 1] || "--" }}</span>
                    </div>

                  <!-- <input v-if="data[0].estandares.seccion === 6"
                         class="grd_input-code"
                         :disabled="data[0].user.rolname !== 'PROD'"
                         v-model="data[0].estandares.a10[(index + 36) - 1]"
                         maxlength="1"> -->
                  <h1 v-else-if="data[0].estandares.seccion !== 6 && data[0].estandares.a10[(index + 36) - 1]"
                      style="font-size:10px; color: #0000FF; font-weight: bold;">
                    {{ data[0].estandares.a10[(index + 36) - 1] }}
                  </h1>
                  <h1 v-else style="font-size:10px; color: #0000FF;">NA</h1>
                </th>

                <!-- Sección 7 -->
                <th style="text-align: center;" v-for="index in 6" :key="index + 's10h8'">
                    <div style="text-align: center;" class="select-wrapper" v-if="data[0].estandares.seccion === 7">
                        <select class="custom-select"
                                :disabled="data[0].user.rolname !== 'PROD'"
                                v-model="data[0].estandares.a10[(index + 42) - 1]">
                        <option value="">--</option> <!-- Permite quitar la selección -->
                        <option value="A">A</option>
                        <option value="V">V</option>
                        <option value="R">R</option>
                        </select>
                        <span class="selected-value">{{ data[0].estandares.a10[(index + 42) - 1] || "--" }}</span>
                    </div>

                  <!-- <input v-if="data[0].estandares.seccion === 7"
                         class="grd_input-code"
                         :disabled="data[0].user.rolname !== 'PROD'"
                         v-model="data[0].estandares.a10[(index + 42) - 1]"
                         maxlength="1"> -->
                  <h1 v-else-if="data[0].estandares.seccion !== 7 && data[0].estandares.a10[(index + 42) - 1]"
                      style="font-size:10px; color: #0000FF; font-weight: bold;">
                    {{ data[0].estandares.a10[(index + 42) - 1] }}
                  </h1>
                  <h1 v-else style="font-size:10px; color: #0000FF;">NA</h1>
                </th>
              </tr>



              <tr>
                <th scope="col">Sello Dañado</th>

                <!-- Sección 0 -->
                <th style="text-align: center;" v-for="index in 6" :key="index + 's11h1'">
                    <div style="text-align: center;" class="select-wrapper" v-if="data[0].estandares.seccion === 0">
                        <select class="custom-select"
                                :disabled="data[0].user.rolname !== 'PROD'"
                                v-model="data[0].estandares.a11[index - 1]">
                        <option value="">--</option> <!-- Permite quitar la selección -->
                        <option value="A">A</option>
                        <option value="V">V</option>
                        <option value="R">R</option>
                        </select>
                        <span class="selected-value">{{ data[0].estandares.a11[index - 1] || "--" }}</span>
                    </div>

                  <!-- <input v-if="data[0].estandares.seccion === 0"
                         class="grd_input-code"
                         :disabled="data[0].user.rolname !== 'PROD'"
                         v-model="data[0].estandares.a11[index - 1]"
                         maxlength="1"> -->
                  <h1 v-else-if="data[0].estandares.seccion !== 0 && data[0].estandares.a11[index - 1]"
                      style="font-size:10px; color: #0000FF; font-weight: bold;">
                    {{ data[0].estandares.a11[index - 1] || 'NA' }}
                  </h1>
                  <h1 v-else style="font-size:10px; color: #0000FF;">NA</h1>
                </th>

                <!-- Sección 1 -->
                <th style="text-align: center;" v-for="index in 6" :key="index + 's11h2'">
                    <div style="text-align: center;" class="select-wrapper" v-if="data[0].estandares.seccion === 1">
                        <select class="custom-select"
                                :disabled="data[0].user.rolname !== 'PROD'"
                                v-model="data[0].estandares.a11[(index + 6) - 1]">
                        <option value="">--</option> <!-- Permite quitar la selección -->
                        <option value="A">A</option>
                        <option value="V">V</option>
                        <option value="R">R</option>
                        </select>
                        <span class="selected-value">{{ data[0].estandares.a11[(index + 6) - 1] || "--" }}</span>
                    </div>

                  <!-- <input v-if="data[0].estandares.seccion === 1"
                         class="grd_input-code"
                         :disabled="data[0].user.rolname !== 'PROD'"
                         v-model="data[0].estandares.a11[(index + 6) - 1]"
                         maxlength="1"> -->
                  <h1 v-else-if="data[0].estandares.seccion !== 1 && data[0].estandares.a11[(index + 6) - 1]"
                      style="font-size:10px; color: #0000FF; font-weight: bold;">
                    {{ data[0].estandares.a11[(index + 6) - 1] || 'NA' }}
                  </h1>
                  <h1 v-else style="font-size:10px; color: #0000FF;">NA</h1>
                </th>

                <!-- Sección 2 -->
                <th style="text-align: center;" v-for="index in 6" :key="index + 's11h3'">
                    <div style="text-align: center;" class="select-wrapper" v-if="data[0].estandares.seccion === 2">
                        <select class="custom-select"
                                :disabled="data[0].user.rolname !== 'PROD'"
                                v-model="data[0].estandares.a11[(index + 12) - 1]">
                        <option value="">--</option> <!-- Permite quitar la selección -->
                        <option value="A">A</option>
                        <option value="V">V</option>
                        <option value="R">R</option>
                        </select>
                        <span class="selected-value">{{ data[0].estandares.a11[(index + 12) - 1] || "--" }}</span>
                    </div>

                  <!-- <input v-if="data[0].estandares.seccion === 2"
                         class="grd_input-code"
                         :disabled="data[0].user.rolname !== 'PROD'"
                         v-model="data[0].estandares.a11[(index + 12) - 1]"
                         maxlength="1"> -->
                  <h1 v-else-if="data[0].estandares.seccion !== 2 && data[0].estandares.a11[(index + 12) - 1]"
                      style="font-size:10px; color: #0000FF; font-weight: bold;">
                    {{ data[0].estandares.a11[(index + 12) - 1] || 'NA' }}
                  </h1>
                  <h1 v-else style="font-size:10px; color: #0000FF;">NA</h1>
                </th>

                <!-- Sección 3 -->
                <th style="text-align: center;" v-for="index in 6" :key="index + 's11h4'">
                    <div style="text-align: center;" class="select-wrapper" v-if="data[0].estandares.seccion === 3">
                        <select class="custom-select"
                                :disabled="data[0].user.rolname !== 'PROD'"
                                v-model="data[0].estandares.a11[(index + 18) - 1]">
                        <option value="">--</option> <!-- Permite quitar la selección -->
                        <option value="A">A</option>
                        <option value="V">V</option>
                        <option value="R">R</option>
                        </select>
                        <span class="selected-value">{{ data[0].estandares.a11[(index + 18) - 1] || "--" }}</span>
                    </div>

                  <!-- <input v-if="data[0].estandares.seccion === 3"
                         class="grd_input-code"
                         :disabled="data[0].user.rolname !== 'PROD'"
                         v-model="data[0].estandares.a11[(index + 18) - 1]"
                         maxlength="1"> -->
                  <h1 v-else-if="data[0].estandares.seccion !== 3 && data[0].estandares.a11[(index + 18) - 1]"
                      style="font-size:10px; color: #0000FF; font-weight: bold;">
                    {{ data[0].estandares.a11[(index + 18) - 1] || 'NA' }}
                  </h1>
                  <h1 v-else style="font-size:10px; color: #0000FF;">NA</h1>
                </th>

                <!-- Sección 4 -->
                <th style="text-align: center;" v-for="index in 6" :key="index + 's11h5'">
                    <div style="text-align: center;" class="select-wrapper" v-if="data[0].estandares.seccion === 4">
                        <select class="custom-select"
                                :disabled="data[0].user.rolname !== 'PROD'"
                                v-model="data[0].estandares.a11[(index + 24) - 1]">
                        <option value="">--</option> <!-- Permite quitar la selección -->
                        <option value="A">A</option>
                        <option value="V">V</option>
                        <option value="R">R</option>
                        </select>
                        <span class="selected-value">{{ data[0].estandares.a11[(index + 24) - 1] || "--" }}</span>
                    </div>

                  <!-- <input v-if="data[0].estandares.seccion === 4"
                         class="grd_input-code"
                         :disabled="data[0].user.rolname !== 'PROD'"
                         v-model="data[0].estandares.a11[(index + 24) - 1]"
                         maxlength="1"> -->
                  <h1 v-else-if="data[0].estandares.seccion !== 4 && data[0].estandares.a11[(index + 24) - 1]"
                      style="font-size:10px; color: #0000FF; font-weight: bold;">
                    {{ data[0].estandares.a11[(index + 24) - 1] || 'NA' }}
                  </h1>
                  <h1 v-else style="font-size:10px; color: #0000FF;">NA</h1>
                </th>

                <!-- Sección 5 -->
                <th style="text-align: center;" v-for="index in 6" :key="index + 's11h6'">
                    <div style="text-align: center;" class="select-wrapper" v-if="data[0].estandares.seccion === 5">
                        <select class="custom-select"
                                :disabled="data[0].user.rolname !== 'PROD'"
                                v-model="data[0].estandares.a11[(index + 30) - 1]">
                        <option value="">--</option> <!-- Permite quitar la selección -->
                        <option value="A">A</option>
                        <option value="V">V</option>
                        <option value="R">R</option>
                        </select>
                        <span class="selected-value">{{ data[0].estandares.a11[(index + 30) - 1] || "--" }}</span>
                    </div>

                  <!-- <input v-if="data[0].estandares.seccion === 5"
                         class="grd_input-code"
                         :disabled="data[0].user.rolname !== 'PROD'"
                         v-model="data[0].estandares.a11[(index + 30) - 1]"
                         maxlength="1"> -->
                  <h1 v-else-if="data[0].estandares.seccion !== 5 && data[0].estandares.a11[(index + 30) - 1]"
                      style="font-size:10px; color: #0000FF; font-weight: bold;">
                    {{ data[0].estandares.a11[(index + 30) - 1] || 'NA' }}
                  </h1>
                  <h1 v-else style="font-size:10px; color: #0000FF;">NA</h1>
                </th>

                <!-- Sección 6 -->
                <th style="text-align: center;" v-for="index in 6" :key="index + 's11h7'">
                    <div style="text-align: center;" class="select-wrapper" v-if="data[0].estandares.seccion === 6">
                        <select class="custom-select"
                                :disabled="data[0].user.rolname !== 'PROD'"
                                v-model="data[0].estandares.a11[(index + 36) - 1]">
                        <option value="">--</option> <!-- Permite quitar la selección -->
                        <option value="A">A</option>
                        <option value="V">V</option>
                        <option value="R">R</option>
                        </select>
                        <span class="selected-value">{{ data[0].estandares.a11[(index + 36) - 1] || "--" }}</span>
                    </div>

                  <!-- <input v-if="data[0].estandares.seccion === 6"
                         class="grd_input-code"
                         :disabled="data[0].user.rolname !== 'PROD'"
                         v-model="data[0].estandares.a11[(index + 36) - 1]"
                         maxlength="1"> -->
                  <h1 v-else-if="data[0].estandares.seccion !== 6 && data[0].estandares.a11[(index + 36) - 1]"
                      style="font-size:10px; color: #0000FF; font-weight: bold;">
                    {{ data[0].estandares.a11[(index + 36) - 1] || 'NA' }}
                  </h1>
                  <h1 v-else style="font-size:10px; color: #0000FF;">NA</h1>
                </th>

                <!-- Sección 7 -->
                <th style="text-align: center;" v-for="index in 6" :key="index + 's11h8'">
                    <div style="text-align: center;" class="select-wrapper" v-if="data[0].estandares.seccion === 7">
                        <select class="custom-select"
                                :disabled="data[0].user.rolname !== 'PROD'"
                                v-model="data[0].estandares.a11[(index + 42) - 1]">
                        <option value="">--</option> <!-- Permite quitar la selección -->
                        <option value="A">A</option>
                        <option value="V">V</option>
                        <option value="R">R</option>
                        </select>
                        <span class="selected-value">{{ data[0].estandares.a11[(index + 42) - 1] || "--" }}</span>
                    </div>

                  <!-- <input v-if="data[0].estandares.seccion === 7"
                         class="grd_input-code"
                         :disabled="data[0].user.rolname !== 'PROD'"
                         v-model="data[0].estandares.a11[(index + 42) - 1]"
                         maxlength="1"> -->
                  <h1 v-else-if="data[0].estandares.seccion !== 7 && data[0].estandares.a11[(index + 42) - 1]"
                      style="font-size:10px; color: #0000FF; font-weight: bold;">
                    {{ data[0].estandares.a11[(index + 42) - 1] || 'NA' }}
                  </h1>
                  <h1 v-else style="font-size:10px; color: #0000FF;">NA</h1>
                </th>
              </tr>



              <tr>
                <th scope="col">Mal Sellado</th>

                <!-- Sección 0 -->
                <th style="text-align: center;" v-for="index in 6" :key="index + 's12h1'">
                    <div style="text-align: center;" class="select-wrapper" v-if="data[0].estandares.seccion === 0">
                        <select class="custom-select"
                                :disabled="data[0].user.rolname !== 'PROD'"
                                v-model="data[0].estandares.a12[index - 1]">
                        <option value="">--</option> <!-- Permite quitar la selección -->
                        <option value="A">A</option>
                        <option value="V">V</option>
                        <option value="R">R</option>
                        </select>
                        <span class="selected-value">{{ data[0].estandares.a12[index - 1] || "--" }}</span>
                    </div>

                  <!-- <input v-if="data[0].estandares.seccion === 0"
                         class="grd_input-code"
                         :disabled="data[0].user.rolname !== 'PROD'"
                         v-model="data[0].estandares.a12[index - 1]"
                         maxlength="1"> -->
                  <h1 v-else-if="data[0].estandares.seccion !== 0 && data[0].estandares.a12[index - 1]"
                      style="font-size:10px; color: #0000FF; font-weight: bold;">
                    {{ data[0].estandares.a12[index - 1] }}
                  </h1>
                  <h1 v-else style="font-size:10px; color: #0000FF;">NA</h1>
                </th>

                <!-- Sección 1 -->
                <th style="text-align: center;" v-for="index in 6" :key="index + 's12h2'">
                    <div style="text-align: center;" class="select-wrapper" v-if="data[0].estandares.seccion === 1">
                        <select class="custom-select"
                                :disabled="data[0].user.rolname !== 'PROD'"
                                v-model="data[0].estandares.a12[(index + 6) - 1]">
                        <option value="">--</option> <!-- Permite quitar la selección -->
                        <option value="A">A</option>
                        <option value="V">V</option>
                        <option value="R">R</option>
                        </select>
                        <span class="selected-value">{{ data[0].estandares.a12[(index + 6) - 1] || "--" }}</span>
                    </div>

                  <!-- <input v-if="data[0].estandares.seccion === 1"
                         class="grd_input-code"
                         :disabled="data[0].user.rolname !== 'PROD'"
                         v-model="data[0].estandares.a12[(index + 6) - 1]"
                         maxlength="1"> -->
                  <h1 v-else-if="data[0].estandares.seccion !== 1 && data[0].estandares.a12[(index + 6) - 1]"
                      style="font-size:10px; color: #0000FF; font-weight: bold;">
                    {{ data[0].estandares.a12[(index + 6) - 1] }}
                  </h1>
                  <h1 v-else style="font-size:10px; color: #0000FF;">NA</h1>
                </th>

                <!-- Sección 2 -->
                <th style="text-align: center;" v-for="index in 6" :key="index + 's12h3'">
                    <div style="text-align: center;" class="select-wrapper" v-if="data[0].estandares.seccion === 2">
                        <select class="custom-select"
                                :disabled="data[0].user.rolname !== 'PROD'"
                                v-model="data[0].estandares.a12[(index + 12) - 1]">
                        <option value="">--</option> <!-- Permite quitar la selección -->
                        <option value="A">A</option>
                        <option value="V">V</option>
                        <option value="R">R</option>
                        </select>
                        <span class="selected-value">{{ data[0].estandares.a12[(index + 12) - 1] || "--" }}</span>
                    </div>

                  <!-- <input v-if="data[0].estandares.seccion === 2"
                         class="grd_input-code"
                         :disabled="data[0].user.rolname !== 'PROD'"
                         v-model="data[0].estandares.a12[(index + 12) - 1]"
                         maxlength="1"> -->
                  <h1 v-else-if="data[0].estandares.seccion !== 2 && data[0].estandares.a12[(index + 12) - 1]"
                      style="font-size:10px; color: #0000FF; font-weight: bold;">
                    {{ data[0].estandares.a12[(index + 12) - 1] }}
                  </h1>
                  <h1 v-else style="font-size:10px; color: #0000FF;">NA</h1>
                </th>

                <!-- Sección 3 -->
                <th style="text-align: center;" v-for="index in 6" :key="index + 's12h4'">
                    <div style="text-align: center;" class="select-wrapper" v-if="data[0].estandares.seccion === 3">
                        <select class="custom-select"
                                :disabled="data[0].user.rolname !== 'PROD'"
                                v-model="data[0].estandares.a12[(index + 18) - 1]">
                        <option value="">--</option> <!-- Permite quitar la selección -->
                        <option value="A">A</option>
                        <option value="V">V</option>
                        <option value="R">R</option>
                        </select>
                        <span class="selected-value">{{ data[0].estandares.a12[(index + 18) - 1] || "--" }}</span>
                    </div>

                  <!-- <input v-if="data[0].estandares.seccion === 3"
                         class="grd_input-code"
                         :disabled="data[0].user.rolname !== 'PROD'"
                         v-model="data[0].estandares.a12[(index + 18) - 1]"
                         maxlength="1"> -->
                  <h1 v-else-if="data[0].estandares.seccion !== 3 && data[0].estandares.a12[(index + 18) - 1]"
                      style="font-size:10px; color: #0000FF; font-weight: bold;">
                    {{ data[0].estandares.a12[(index + 18) - 1] }}
                  </h1>
                  <h1 v-else style="font-size:10px; color: #0000FF;">NA</h1>
                </th>

                <!-- Sección 4 -->
                <th style="text-align: center;" v-for="index in 6" :key="index + 's12h5'">
                    <div style="text-align: center;" class="select-wrapper" v-if="data[0].estandares.seccion === 4">
                        <select class="custom-select"
                                :disabled="data[0].user.rolname !== 'PROD'"
                                v-model="data[0].estandares.a12[(index + 24) - 1]">
                        <option value="">--</option> <!-- Permite quitar la selección -->
                        <option value="A">A</option>
                        <option value="V">V</option>
                        <option value="R">R</option>
                        </select>
                        <span class="selected-value">{{ data[0].estandares.a12[(index + 24) - 1] || "--" }}</span>
                    </div>

                  <!-- <input v-if="data[0].estandares.seccion === 4"
                         class="grd_input-code"
                         :disabled="data[0].user.rolname !== 'PROD'"
                         v-model="data[0].estandares.a12[(index + 24) - 1]"
                         maxlength="1"> -->
                  <h1 v-else-if="data[0].estandares.seccion !== 4 && data[0].estandares.a12[(index + 24) - 1]"
                      style="font-size:10px; color: #0000FF; font-weight: bold;">
                    {{ data[0].estandares.a12[(index + 24) - 1] }}
                  </h1>
                  <h1 v-else style="font-size:10px; color: #0000FF;">NA</h1>
                </th>

                <!-- Sección 5 -->
                <th style="text-align: center;" v-for="index in 6" :key="index + 's12h6'">
                    <div style="text-align: center;" class="select-wrapper" v-if="data[0].estandares.seccion === 5">
                        <select class="custom-select"
                                :disabled="data[0].user.rolname !== 'PROD'"
                                v-model="data[0].estandares.a12[(index + 30) - 1]">
                        <option value="">--</option> <!-- Permite quitar la selección -->
                        <option value="A">A</option>
                        <option value="V">V</option>
                        <option value="R">R</option>
                        </select>
                        <span class="selected-value">{{ data[0].estandares.a12[(index + 30) - 1] || "--" }}</span>
                    </div>

                  <!-- <input v-if="data[0].estandares.seccion === 5"
                         class="grd_input-code"
                         :disabled="data[0].user.rolname !== 'PROD'"
                         v-model="data[0].estandares.a12[(index + 30) - 1]"
                         maxlength="1"> -->
                  <h1 v-else-if="data[0].estandares.seccion !== 5 && data[0].estandares.a12[(index + 30) - 1]"
                      style="font-size:10px; color: #0000FF; font-weight: bold;">
                    {{ data[0].estandares.a12[(index + 30) - 1] }}
                  </h1>
                  <h1 v-else style="font-size:10px; color: #0000FF;">NA</h1>
                </th>

                <!-- Sección 6 -->
                <th style="text-align: center;" v-for="index in 6" :key="index + 's12h7'">
                    <div style="text-align: center;" class="select-wrapper" v-if="data[0].estandares.seccion === 6">
                        <select class="custom-select"
                                :disabled="data[0].user.rolname !== 'PROD'"
                                v-model="data[0].estandares.a12[(index + 36) - 1]">
                        <option value="">--</option> <!-- Permite quitar la selección -->
                        <option value="A">A</option>
                        <option value="V">V</option>
                        <option value="R">R</option>
                        </select>
                        <span class="selected-value">{{ data[0].estandares.a12[(index + 36) - 1] || "--" }}</span>
                    </div>

                  <!-- <input v-if="data[0].estandares.seccion === 6"
                         class="grd_input-code"
                         :disabled="data[0].user.rolname !== 'PROD'"
                         v-model="data[0].estandares.a12[(index + 36) - 1]"
                         maxlength="1"> -->
                  <h1 v-else-if="data[0].estandares.seccion !== 6 && data[0].estandares.a12[(index + 36) - 1]"
                      style="font-size:10px; color: #0000FF; font-weight: bold;">
                    {{ data[0].estandares.a12[(index + 36) - 1] }}
                  </h1>
                  <h1 v-else style="font-size:10px; color: #0000FF;">NA</h1>
                </th>

                <!-- Sección 7 -->
                <th style="text-align: center;" v-for="index in 6" :key="index + 's12h8'">
                    <div style="text-align: center;" class="select-wrapper" v-if="data[0].estandares.seccion === 7">
                        <select class="custom-select"
                                :disabled="data[0].user.rolname !== 'PROD'"
                                v-model="data[0].estandares.a12[(index + 42) - 1]">
                        <option value="">--</option> <!-- Permite quitar la selección -->
                        <option value="A">A</option>
                        <option value="V">V</option>
                        <option value="R">R</option>
                        </select>
                        <span class="selected-value">{{ data[0].estandares.a12[(index + 42) - 1] || "--" }}</span>
                    </div>

                  <!-- <input v-if="data[0].estandares.seccion === 7"
                         class="grd_input-code"
                         :disabled="data[0].user.rolname !== 'PROD'"
                         v-model="data[0].estandares.a12[(index + 42) - 1]"
                         maxlength="1"> -->
                  <h1 v-else-if="data[0].estandares.seccion !== 7 && data[0].estandares.a12[(index + 42) - 1]"
                      style="font-size:10px; color: #0000FF; font-weight: bold;">
                    {{ data[0].estandares.a12[(index + 42) - 1] }}
                  </h1>
                  <h1 v-else style="font-size:10px; color: #0000FF;">NA</h1>
                </th>
              </tr>


              <tr>
                <th scope="col">Empaque sin producto</th>

                <!-- Sección 0 -->
                <th style="text-align: center;" v-for="index in 6" :key="index + 's13h1'">
                    <div style="text-align: center;" class="select-wrapper" v-if="data[0].estandares.seccion === 0">
                        <select class="custom-select"
                                :disabled="data[0].user.rolname !== 'PROD'"
                                v-model="data[0].estandares.a13[index - 1]">
                        <option value="">--</option> <!-- Permite quitar la selección -->
                        <option value="A">A</option>
                        <option value="V">V</option>
                        <option value="R">R</option>
                        </select>
                        <span class="selected-value">{{ data[0].estandares.a13[index - 1] || "--" }}</span>
                    </div>

                  <!-- <input v-if="data[0].estandares.seccion === 0"
                         class="grd_input-code"
                         :disabled="data[0].user.rolname !== 'PROD'"
                         v-model="data[0].estandares.a13[index - 1]"
                         maxlength="1"> -->
                  <h1 v-else-if="data[0].estandares.seccion !== 0 && data[0].estandares.a13[index - 1]"
                      style="font-size:10px; color: #0000FF; font-weight: bold;">
                    {{ data[0].estandares.a13[index - 1] }}
                  </h1>
                  <h1 v-else style="font-size:10px; color: #0000FF;">NA</h1>
                </th>

                <!-- Sección 1 -->
                <th style="text-align: center;" v-for="index in 6" :key="index + 's13h2'">
                    <div style="text-align: center;" class="select-wrapper" v-if="data[0].estandares.seccion === 1">
                        <select class="custom-select"
                                :disabled="data[0].user.rolname !== 'PROD'"
                                v-model="data[0].estandares.a13[(index + 6) - 1]">
                        <option value="">--</option> <!-- Permite quitar la selección -->
                        <option value="A">A</option>
                        <option value="V">V</option>
                        <option value="R">R</option>
                        </select>
                        <span class="selected-value">{{ data[0].estandares.a13[(index + 6) - 1] || "--" }}</span>
                    </div>

                  <!-- <input v-if="data[0].estandares.seccion === 1"
                         class="grd_input-code"
                         :disabled="data[0].user.rolname !== 'PROD'"
                         v-model="data[0].estandares.a13[(index + 6) - 1]"
                         maxlength="1"> -->
                  <h1 v-else-if="data[0].estandares.seccion !== 1 && data[0].estandares.a13[(index + 6) - 1]"
                      style="font-size:10px; color: #0000FF; font-weight: bold;">
                    {{ data[0].estandares.a13[(index + 6) - 1] }}
                  </h1>
                  <h1 v-else style="font-size:10px; color: #0000FF;">NA</h1>
                </th>

                <!-- Sección 2 -->
                <th style="text-align: center;" v-for="index in 6" :key="index + 's13h3'">
                    <div style="text-align: center;" class="select-wrapper" v-if="data[0].estandares.seccion === 2">
                        <select class="custom-select"
                                :disabled="data[0].user.rolname !== 'PROD'"
                                v-model="data[0].estandares.a13[(index + 12) - 1]">
                        <option value="">--</option> <!-- Permite quitar la selección -->
                        <option value="A">A</option>
                        <option value="V">V</option>
                        <option value="R">R</option>
                        </select>
                        <span class="selected-value">{{ data[0].estandares.a13[(index + 12) - 1] || "--" }}</span>
                    </div>

                  <!-- <input v-if="data[0].estandares.seccion === 2"
                         class="grd_input-code"
                         :disabled="data[0].user.rolname !== 'PROD'"
                         v-model="data[0].estandares.a13[(index + 12) - 1]"
                         maxlength="1"> -->
                  <h1 v-else-if="data[0].estandares.seccion !== 2 && data[0].estandares.a13[(index + 12) - 1]"
                      style="font-size:10px; color: #0000FF; font-weight: bold;">
                    {{ data[0].estandares.a13[(index + 12) - 1] }}
                  </h1>
                  <h1 v-else style="font-size:10px; color: #0000FF;">NA</h1>
                </th>

                <!-- Sección 3 -->
                <th style="text-align: center;" v-for="index in 6" :key="index + 's13h4'">
                    <div style="text-align: center;" class="select-wrapper" v-if="data[0].estandares.seccion === 3">
                        <select class="custom-select"
                                :disabled="data[0].user.rolname !== 'PROD'"
                                v-model="data[0].estandares.a13[(index + 18) - 1]">
                        <option value="">--</option> <!-- Permite quitar la selección -->
                        <option value="A">A</option>
                        <option value="V">V</option>
                        <option value="R">R</option>
                        </select>
                        <span class="selected-value">{{ data[0].estandares.a13[(index + 18) - 1] || "--" }}</span>
                    </div>

                  <!-- <input v-if="data[0].estandares.seccion === 3"
                         class="grd_input-code"
                         :disabled="data[0].user.rolname !== 'PROD'"
                         v-model="data[0].estandares.a13[(index + 18) - 1]"
                         maxlength="1"> -->
                  <h1 v-else-if="data[0].estandares.seccion !== 3 && data[0].estandares.a13[(index + 18) - 1]"
                      style="font-size:10px; color: #0000FF; font-weight: bold;">
                    {{ data[0].estandares.a13[(index + 18) - 1] }}
                  </h1>
                  <h1 v-else style="font-size:10px; color: #0000FF;">NA</h1>
                </th>

                <!-- Sección 4 -->
                <th style="text-align: center;" v-for="index in 6" :key="index + 's13h5'">
                    <div style="text-align: center;" class="select-wrapper" v-if="data[0].estandares.seccion === 4">
                        <select class="custom-select"
                                :disabled="data[0].user.rolname !== 'PROD'"
                                v-model="data[0].estandares.a13[(index + 24) - 1]">
                        <option value="">--</option> <!-- Permite quitar la selección -->
                        <option value="A">A</option>
                        <option value="V">V</option>
                        <option value="R">R</option>
                        </select>
                        <span class="selected-value">{{ data[0].estandares.a13[(index + 24) - 1] || "--" }}</span>
                    </div>

                  <!-- <input v-if="data[0].estandares.seccion === 4"
                         class="grd_input-code"
                         :disabled="data[0].user.rolname !== 'PROD'"
                         v-model="data[0].estandares.a13[(index + 24) - 1]"
                         maxlength="1"> -->
                  <h1 v-else-if="data[0].estandares.seccion !== 4 && data[0].estandares.a13[(index + 24) - 1]"
                      style="font-size:10px; color: #0000FF; font-weight: bold;">
                    {{ data[0].estandares.a13[(index + 24) - 1] }}
                  </h1>
                  <h1 v-else style="font-size:10px; color: #0000FF;">NA</h1>
                </th>

                <!-- Sección 5 -->
                <th style="text-align: center;" v-for="index in 6" :key="index + 's13h6'">
                    <div style="text-align: center;" class="select-wrapper" v-if="data[0].estandares.seccion === 5">
                        <select class="custom-select"
                                :disabled="data[0].user.rolname !== 'PROD'"
                                v-model="data[0].estandares.a13[(index + 30) - 1]">
                        <option value="">--</option> <!-- Permite quitar la selección -->
                        <option value="A">A</option>
                        <option value="V">V</option>
                        <option value="R">R</option>
                        </select>
                        <span class="selected-value">{{ data[0].estandares.a13[(index + 30) - 1] || "--" }}</span>
                    </div>

                  <!-- <input v-if="data[0].estandares.seccion === 5"
                         class="grd_input-code"
                         :disabled="data[0].user.rolname !== 'PROD'"
                         v-model="data[0].estandares.a13[(index + 30) - 1]"
                         maxlength="1"> -->
                  <h1 v-else-if="data[0].estandares.seccion !== 5 && data[0].estandares.a13[(index + 30) - 1]"
                      style="font-size:10px; color: #0000FF; font-weight: bold;">
                    {{ data[0].estandares.a13[(index + 30) - 1] }}
                  </h1>
                  <h1 v-else style="font-size:10px; color: #0000FF;">NA</h1>
                </th>

                <!-- Sección 6 -->
                <th style="text-align: center;" v-for="index in 6" :key="index + 's13h7'">
                    <div style="text-align: center;" class="select-wrapper" v-if="data[0].estandares.seccion === 6">
                        <select class="custom-select"
                                :disabled="data[0].user.rolname !== 'PROD'"
                                v-model="data[0].estandares.a13[(index + 36) - 1]">
                        <option value="">--</option> <!-- Permite quitar la selección -->
                        <option value="A">A</option>
                        <option value="V">V</option>
                        <option value="R">R</option>
                        </select>
                        <span class="selected-value">{{ data[0].estandares.a13[(index + 36) - 1] || "--" }}</span>
                    </div>

                  <!-- <input v-if="data[0].estandares.seccion === 6"
                         class="grd_input-code"
                         :disabled="data[0].user.rolname !== 'PROD'"
                         v-model="data[0].estandares.a13[(index + 36) - 1]"
                         maxlength="1"> -->
                  <h1 v-else-if="data[0].estandares.seccion !== 6 && data[0].estandares.a13[(index + 36) - 1]"
                      style="font-size:10px; color: #0000FF; font-weight: bold;">
                    {{ data[0].estandares.a13[(index + 36) - 1] }}
                  </h1>
                  <h1 v-else style="font-size:10px; color: #0000FF;">NA</h1>
                </th>

                <!-- Sección 7 -->
                <th style="text-align: center;" v-for="index in 6" :key="index + 's13h8'">
                    <div style="text-align: center;" class="select-wrapper" v-if="data[0].estandares.seccion === 7">
                        <select class="custom-select"
                                :disabled="data[0].user.rolname !== 'PROD'"
                                v-model="data[0].estandares.a13[(index + 42) - 1]">
                        <option value="">--</option> <!-- Permite quitar la selección -->
                        <option value="A">A</option>
                        <option value="V">V</option>
                        <option value="R">R</option>
                        </select>
                        <span class="selected-value">{{ data[0].estandares.a13[(index + 42) - 1] || "--" }}</span>
                    </div>

                  <!-- <input v-if="data[0].estandares.seccion === 7"
                         class="grd_input-code"
                         :disabled="data[0].user.rolname !== 'PROD'"
                         v-model="data[0].estandares.a13[(index + 42) - 1]"
                         maxlength="1"> -->
                  <h1 v-else-if="data[0].estandares.seccion !== 7 && data[0].estandares.a13[(index + 42) - 1]"
                      style="font-size:10px; color: #0000FF; font-weight: bold;">
                    {{ data[0].estandares.a13[(index + 42) - 1] }}
                  </h1>
                  <h1 v-else style="font-size:10px; color: #0000FF;">NA</h1>
                </th>
              </tr>



              <tr>
                <th scope="col">Empaque deforme</th>

                <!-- Sección 0 -->
                <th style="text-align: center;" v-for="index in 6" :key="index + 's14h1'">
                    <div style="text-align: center;" class="select-wrapper" v-if="data[0].estandares.seccion === 0">
                        <select class="custom-select"
                                :disabled="data[0].user.rolname !== 'PROD'"
                                v-model="data[0].estandares.a14[index - 1]">
                        <option value="">--</option> <!-- Permite quitar la selección -->
                        <option value="A">A</option>
                        <option value="V">V</option>
                        <option value="R">R</option>
                        </select>
                        <span class="selected-value">{{ data[0].estandares.a14[index - 1] || "--" }}</span>
                    </div>

                  <!-- <input v-if="data[0].estandares.seccion === 0"
                         class="grd_input-code"
                         :disabled="data[0].user.rolname !== 'PROD'"
                         v-model="data[0].estandares.a14[index - 1]"
                         maxlength="1"> -->
                  <h1 v-else-if="data[0].estandares.seccion !== 0 && data[0].estandares.a14[index - 1]"
                      style="font-size:10px; color: #0000FF; font-weight: bold;">
                    {{ data[0].estandares.a14[index - 1] }}
                  </h1>
                  <h1 v-else style="font-size:10px; color: #0000FF;">NA</h1>
                </th>

                <!-- Sección 1 -->
                <th style="text-align: center;" v-for="index in 6" :key="index + 's14h2'">
                    <div style="text-align: center;" class="select-wrapper" v-if="data[0].estandares.seccion === 1">
                        <select class="custom-select"
                                :disabled="data[0].user.rolname !== 'PROD'"
                                v-model="data[0].estandares.a14[(index + 6) - 1]">
                        <option value="">--</option> <!-- Permite quitar la selección -->
                        <option value="A">A</option>
                        <option value="V">V</option>
                        <option value="R">R</option>
                        </select>
                        <span class="selected-value">{{ data[0].estandares.a14[(index + 6) - 1] || "--" }}</span>
                    </div>

                  <!-- <input v-if="data[0].estandares.seccion === 1"
                         class="grd_input-code"
                         :disabled="data[0].user.rolname !== 'PROD'"
                         v-model="data[0].estandares.a14[(index + 6) - 1]"
                         maxlength="1"> -->
                  <h1 v-else-if="data[0].estandares.seccion !== 1 && data[0].estandares.a14[(index + 6) - 1]"
                      style="font-size:10px; color: #0000FF; font-weight: bold;">
                    {{ data[0].estandares.a14[(index + 6) - 1] }}
                  </h1>
                  <h1 v-else style="font-size:10px; color: #0000FF;">NA</h1>
                </th>

                <!-- Sección 2 -->
                <th style="text-align: center;" v-for="index in 6" :key="index + 's14h3'">
                    <div style="text-align: center;" class="select-wrapper" v-if="data[0].estandares.seccion === 2">
                        <select class="custom-select"
                                :disabled="data[0].user.rolname !== 'PROD'"
                                v-model="data[0].estandares.a14[(index + 12) - 1]">
                        <option value="">--</option> <!-- Permite quitar la selección -->
                        <option value="A">A</option>
                        <option value="V">V</option>
                        <option value="R">R</option>
                        </select>
                        <span class="selected-value">{{ data[0].estandares.a14[(index + 12) - 1] || "--" }}</span>
                    </div>

                  <!-- <input v-if="data[0].estandares.seccion === 2"
                         class="grd_input-code"
                         :disabled="data[0].user.rolname !== 'PROD'"
                         v-model="data[0].estandares.a14[(index + 12) - 1]"
                         maxlength="1"> -->
                  <h1 v-else-if="data[0].estandares.seccion !== 2 && data[0].estandares.a14[(index + 12) - 1]"
                      style="font-size:10px; color: #0000FF; font-weight: bold;">
                    {{ data[0].estandares.a14[(index + 12) - 1] }}
                  </h1>
                  <h1 v-else style="font-size:10px; color: #0000FF;">NA</h1>
                </th>

                <!-- Sección 3 -->
                <th style="text-align: center;" v-for="index in 6" :key="index + 's14h4'">
                    <div style="text-align: center;" class="select-wrapper" v-if="data[0].estandares.seccion === 3">
                        <select class="custom-select"
                                :disabled="data[0].user.rolname !== 'PROD'"
                                v-model="data[0].estandares.a14[(index + 18) - 1]">
                        <option value="">--</option> <!-- Permite quitar la selección -->
                        <option value="A">A</option>
                        <option value="V">V</option>
                        <option value="R">R</option>
                        </select>
                        <span class="selected-value">{{ data[0].estandares.a14[(index + 18) - 1] || "--" }}</span>
                    </div>

                  <!-- <input v-if="data[0].estandares.seccion === 3"
                         class="grd_input-code"
                         :disabled="data[0].user.rolname !== 'PROD'"
                         v-model="data[0].estandares.a14[(index + 18) - 1]"
                         maxlength="1"> -->
                  <h1 v-else-if="data[0].estandares.seccion !== 3 && data[0].estandares.a14[(index + 18) - 1]"
                      style="font-size:10px; color: #0000FF; font-weight: bold;">
                    {{ data[0].estandares.a14[(index + 18) - 1] }}
                  </h1>
                  <h1 v-else style="font-size:10px; color: #0000FF;">NA</h1>
                </th>

                <!-- Sección 4 -->
                <th style="text-align: center;" v-for="index in 6" :key="index + 's14h5'">
                    <div style="text-align: center;" class="select-wrapper" v-if="data[0].estandares.seccion === 4">
                        <select class="custom-select"
                                :disabled="data[0].user.rolname !== 'PROD'"
                                v-model="data[0].estandares.a14[(index + 24) - 1]">
                        <option value="">--</option> <!-- Permite quitar la selección -->
                        <option value="A">A</option>
                        <option value="V">V</option>
                        <option value="R">R</option>
                        </select>
                        <span class="selected-value">{{ data[0].estandares.a14[(index + 24) - 1] || "--" }}</span>
                    </div>

                  <!-- <input v-if="data[0].estandares.seccion === 4"
                         class="grd_input-code"
                         :disabled="data[0].user.rolname !== 'PROD'"
                         v-model="data[0].estandares.a14[(index + 24) - 1]"
                         maxlength="1"> -->
                  <h1 v-else-if="data[0].estandares.seccion !== 4 && data[0].estandares.a14[(index + 24) - 1]"
                      style="font-size:10px; color: #0000FF; font-weight: bold;">
                    {{ data[0].estandares.a14[(index + 24) - 1] }}
                  </h1>
                  <h1 v-else style="font-size:10px; color: #0000FF;">NA</h1>
                </th>

                <!-- Sección 5 -->
                <th style="text-align: center;" v-for="index in 6" :key="index + 's14h6'">
                    <div style="text-align: center;" class="select-wrapper" v-if="data[0].estandares.seccion === 5">
                        <select class="custom-select"
                                :disabled="data[0].user.rolname !== 'PROD'"
                                v-model="data[0].estandares.a14[(index + 30) - 1]">
                        <option value="">--</option> <!-- Permite quitar la selección -->
                        <option value="A">A</option>
                        <option value="V">V</option>
                        <option value="R">R</option>
                        </select>
                        <span class="selected-value">{{ data[0].estandares.a14[(index + 30) - 1] || "--" }}</span>
                    </div>

                  <!-- <input v-if="data[0].estandares.seccion === 5"
                         class="grd_input-code"
                         :disabled="data[0].user.rolname !== 'PROD'"
                         v-model="data[0].estandares.a14[(index + 30) - 1]"
                         maxlength="1"> -->
                  <h1 v-else-if="data[0].estandares.seccion !== 5 && data[0].estandares.a14[(index + 30) - 1]"
                      style="font-size:10px; color: #0000FF; font-weight: bold;">
                    {{ data[0].estandares.a14[(index + 30) - 1] }}
                  </h1>
                  <h1 v-else style="font-size:10px; color: #0000FF;">NA</h1>
                </th>

                <!-- Sección 6 -->
                <th style="text-align: center;" v-for="index in 6" :key="index + 's14h7'">
                    <div style="text-align: center;" class="select-wrapper" v-if="data[0].estandares.seccion === 6">
                        <select class="custom-select"
                                :disabled="data[0].user.rolname !== 'PROD'"
                                v-model="data[0].estandares.a14[(index + 36) - 1]">
                        <option value="">--</option> <!-- Permite quitar la selección -->
                        <option value="A">A</option>
                        <option value="V">V</option>
                        <option value="R">R</option>
                        </select>
                        <span class="selected-value">{{ data[0].estandares.a14[(index + 36) - 1] || "--" }}</span>
                    </div>

                  <!-- <input v-if="data[0].estandares.seccion === 6"
                         class="grd_input-code"
                         :disabled="data[0].user.rolname !== 'PROD'"
                         v-model="data[0].estandares.a14[(index + 36) - 1]"
                         maxlength="1"> -->
                  <h1 v-else-if="data[0].estandares.seccion !== 6 && data[0].estandares.a14[(index + 36) - 1]"
                      style="font-size:10px; color: #0000FF; font-weight: bold;">
                    {{ data[0].estandares.a14[(index + 36) - 1] }}
                  </h1>
                  <h1 v-else style="font-size:10px; color: #0000FF;">NA</h1>
                </th>

                <!-- Sección 7 -->
                <th style="text-align: center;" v-for="index in 6" :key="index + 's14h8'">
                    <div style="text-align: center;" class="select-wrapper" v-if="data[0].estandares.seccion === 7">
                        <select class="custom-select"
                                :disabled="data[0].user.rolname !== 'PROD'"
                                v-model="data[0].estandares.a14[(index + 42) - 1]">
                        <option value="">--</option> <!-- Permite quitar la selección -->
                        <option value="A">A</option>
                        <option value="V">V</option>
                        <option value="R">R</option>
                        </select>
                        <span class="selected-value">{{ data[0].estandares.a14[(index + 42) - 1] || "--" }}</span>
                    </div>

                  <!-- <input v-if="data[0].estandares.seccion === 7"
                         class="grd_input-code"
                         :disabled="data[0].user.rolname !== 'PROD'"
                         v-model="data[0].estandares.a14[(index + 42) - 1]"
                         maxlength="1"> -->
                  <h1 v-else-if="data[0].estandares.seccion !== 7 && data[0].estandares.a14[(index + 42) - 1]"
                      style="font-size:10px; color: #0000FF; font-weight: bold;">
                    {{ data[0].estandares.a14[(index + 42) - 1] }}
                  </h1>
                  <h1 v-else style="font-size:10px; color: #0000FF;">NA</h1>
                </th>
              </tr>



              <tr>
                <th scope="col">Empaque perforado</th>

                <!-- Sección 0 -->
                <th style="text-align: center;" v-for="index in 6" :key="index + 's15h1'">
                    <div style="text-align: center;" class="select-wrapper" v-if="data[0].estandares.seccion === 0">
                        <select class="custom-select"
                                :disabled="data[0].user.rolname !== 'PROD'"
                                v-model="data[0].estandares.a15[index - 1]">
                        <option value="">--</option> <!-- Permite quitar la selección -->
                        <option value="A">A</option>
                        <option value="V">V</option>
                        <option value="R">R</option>
                        </select>
                        <span class="selected-value">{{ data[0].estandares.a15[index - 1] || "--" }}</span>
                    </div>

                  <!-- <input v-if="data[0].estandares.seccion === 0"
                         class="grd_input-code"
                         :disabled="data[0].user.rolname !== 'PROD'"
                         v-model="data[0].estandares.a15[index - 1]"
                         maxlength="1"> -->
                  <h1 v-else-if="data[0].estandares.seccion !== 0 && data[0].estandares.a15[index - 1]"
                      style="font-size:10px; color: #0000FF; font-weight: bold;">
                    {{ data[0].estandares.a15[index - 1] }}
                  </h1>
                  <h1 v-else style="font-size:10px; color: #0000FF;">NA</h1>
                </th>

                <!-- Sección 1 -->
                <th style="text-align: center;" v-for="index in 6" :key="index + 's15h2'">
                    <div style="text-align: center;" class="select-wrapper" v-if="data[0].estandares.seccion === 1">
                        <select class="custom-select"
                                :disabled="data[0].user.rolname !== 'PROD'"
                                v-model="data[0].estandares.a15[(index + 6) - 1]">
                        <option value="">--</option> <!-- Permite quitar la selección -->
                        <option value="A">A</option>
                        <option value="V">V</option>
                        <option value="R">R</option>
                        </select>
                        <span class="selected-value">{{ data[0].estandares.a15[(index + 6) - 1] || "--" }}</span>
                    </div>

                  <!-- <input v-if="data[0].estandares.seccion === 1"
                         class="grd_input-code"
                         :disabled="data[0].user.rolname !== 'PROD'"
                         v-model="data[0].estandares.a15[(index + 6) - 1]"
                         maxlength="1"> -->
                  <h1 v-else-if="data[0].estandares.seccion !== 1 && data[0].estandares.a15[(index + 6) - 1]"
                      style="font-size:10px; color: #0000FF; font-weight: bold;">
                    {{ data[0].estandares.a15[(index + 6) - 1] }}
                  </h1>
                  <h1 v-else style="font-size:10px; color: #0000FF;">NA</h1>
                </th>

                <!-- Sección 2 -->
                <th style="text-align: center;" v-for="index in 6" :key="index + 's15h3'">
                    <div style="text-align: center;" class="select-wrapper" v-if="data[0].estandares.seccion === 2">
                        <select class="custom-select"
                                :disabled="data[0].user.rolname !== 'PROD'"
                                v-model="data[0].estandares.a15[(index + 12) - 1]">
                        <option value="">--</option> <!-- Permite quitar la selección -->
                        <option value="A">A</option>
                        <option value="V">V</option>
                        <option value="R">R</option>
                        </select>
                        <span class="selected-value">{{ data[0].estandares.a15[(index + 12) - 1] || "--" }}</span>
                    </div>

                  <!-- <input v-if="data[0].estandares.seccion === 2"
                         class="grd_input-code"
                         :disabled="data[0].user.rolname !== 'PROD'"
                         v-model="data[0].estandares.a15[(index + 12) - 1]"
                         maxlength="1"> -->
                  <h1 v-else-if="data[0].estandares.seccion !== 2 && data[0].estandares.a15[(index + 12) - 1]"
                      style="font-size:10px; color: #0000FF; font-weight: bold;">
                    {{ data[0].estandares.a15[(index + 12) - 1] }}
                  </h1>
                  <h1 v-else style="font-size:10px; color: #0000FF;">NA</h1>
                </th>

                <!-- Sección 3 -->
                <th style="text-align: center;" v-for="index in 6" :key="index + 's15h4'">
                    <div style="text-align: center;" class="select-wrapper" v-if="data[0].estandares.seccion === 3">
                        <select class="custom-select"
                                :disabled="data[0].user.rolname !== 'PROD'"
                                v-model="data[0].estandares.a15[(index + 18) - 1]">
                        <option value="">--</option> <!-- Permite quitar la selección -->
                        <option value="A">A</option>
                        <option value="V">V</option>
                        <option value="R">R</option>
                        </select>
                        <span class="selected-value">{{ data[0].estandares.a15[(index + 18) - 1] || "--" }}</span>
                    </div>

                  <!-- <input v-if="data[0].estandares.seccion === 3"
                         class="grd_input-code"
                         :disabled="data[0].user.rolname !== 'PROD'"
                         v-model="data[0].estandares.a15[(index + 18) - 1]"
                         maxlength="1"> -->
                  <h1 v-else-if="data[0].estandares.seccion !== 3 && data[0].estandares.a15[(index + 18) - 1]"
                      style="font-size:10px; color: #0000FF; font-weight: bold;">
                    {{ data[0].estandares.a15[(index + 18) - 1] }}
                  </h1>
                  <h1 v-else style="font-size:10px; color: #0000FF;">NA</h1>
                </th>

                <!-- Sección 4 -->
                <th style="text-align: center;" v-for="index in 6" :key="index + 's15h5'">
                    <div style="text-align: center;" class="select-wrapper" v-if="data[0].estandares.seccion === 4">
                        <select class="custom-select"
                                :disabled="data[0].user.rolname !== 'PROD'"
                                v-model="data[0].estandares.a15[(index + 24) - 1]">
                        <option value="">--</option> <!-- Permite quitar la selección -->
                        <option value="A">A</option>
                        <option value="V">V</option>
                        <option value="R">R</option>
                        </select>
                        <span class="selected-value">{{ data[0].estandares.a15[(index + 24) - 1] || "--" }}</span>
                    </div>

                  <!-- <input v-if="data[0].estandares.seccion === 4"
                         class="grd_input-code"
                         :disabled="data[0].user.rolname !== 'PROD'"
                         v-model="data[0].estandares.a15[(index + 24) - 1]"
                         maxlength="1"> -->
                  <h1 v-else-if="data[0].estandares.seccion !== 4 && data[0].estandares.a15[(index + 24) - 1]"
                      style="font-size:10px; color: #0000FF; font-weight: bold;">
                    {{ data[0].estandares.a15[(index + 24) - 1] }}
                  </h1>
                  <h1 v-else style="font-size:10px; color: #0000FF;">NA</h1>
                </th>

                <!-- Sección 5 -->
                <th style="text-align: center;" v-for="index in 6" :key="index + 's15h6'">
                    <div style="text-align: center;" class="select-wrapper" v-if="data[0].estandares.seccion === 5">
                        <select class="custom-select"
                                :disabled="data[0].user.rolname !== 'PROD'"
                                v-model="data[0].estandares.a15[(index + 30) - 1]">
                        <option value="">--</option> <!-- Permite quitar la selección -->
                        <option value="A">A</option>
                        <option value="V">V</option>
                        <option value="R">R</option>
                        </select>
                        <span class="selected-value">{{ data[0].estandares.a15[(index + 30) - 1] || "--" }}</span>
                    </div>

                  <!-- <input v-if="data[0].estandares.seccion === 5"
                         class="grd_input-code"
                         :disabled="data[0].user.rolname !== 'PROD'"
                         v-model="data[0].estandares.a15[(index + 30) - 1]"
                         maxlength="1"> -->
                  <h1 v-else-if="data[0].estandares.seccion !== 5 && data[0].estandares.a15[(index + 30) - 1]"
                      style="font-size:10px; color: #0000FF; font-weight: bold;">
                    {{ data[0].estandares.a15[(index + 30) - 1] }}
                  </h1>
                  <h1 v-else style="font-size:10px; color: #0000FF;">NA</h1>
                </th>

                <!-- Sección 6 -->
                <th style="text-align: center;" v-for="index in 6" :key="index + 's15h7'">
                    <div style="text-align: center;" class="select-wrapper" v-if="data[0].estandares.seccion === 6">
                        <select class="custom-select"
                                :disabled="data[0].user.rolname !== 'PROD'"
                                v-model="data[0].estandares.a15[(index + 36) - 1]">
                        <option value="">--</option> <!-- Permite quitar la selección -->
                        <option value="A">A</option>
                        <option value="V">V</option>
                        <option value="R">R</option>
                        </select>
                        <span class="selected-value">{{ data[0].estandares.a15[(index + 36) - 1] || "--" }}</span>
                    </div>

                  <!-- <input v-if="data[0].estandares.seccion === 6"
                         class="grd_input-code"
                         :disabled="data[0].user.rolname !== 'PROD'"
                         v-model="data[0].estandares.a15[(index + 36) - 1]"
                         maxlength="1"> -->
                  <h1 v-else-if="data[0].estandares.seccion !== 6 && data[0].estandares.a15[(index + 36) - 1]"
                      style="font-size:10px; color: #0000FF; font-weight: bold;">
                    {{ data[0].estandares.a15[(index + 36) - 1] }}
                  </h1>
                  <h1 v-else style="font-size:10px; color: #0000FF;">NA</h1>
                </th>

                <!-- Sección 7 -->
                <th style="text-align: center;" v-for="index in 6" :key="index + 's15h8'">
                    <div style="text-align: center;" class="select-wrapper" v-if="data[0].estandares.seccion === 7">
                        <select class="custom-select"
                                :disabled="data[0].user.rolname !== 'PROD'"
                                v-model="data[0].estandares.a15[(index + 42) - 1]">
                        <option value="">--</option> <!-- Permite quitar la selección -->
                        <option value="A">A</option>
                        <option value="V">V</option>
                        <option value="R">R</option>
                        </select>
                        <span class="selected-value">{{ data[0].estandares.a15[(index + 42) - 1] || "--" }}</span>
                    </div>

                  <!-- <input v-if="data[0].estandares.seccion === 7"
                         class="grd_input-code"
                         :disabled="data[0].user.rolname !== 'PROD'"
                         v-model="data[0].estandares.a15[(index + 42) - 1]"
                         maxlength="1"> -->
                  <h1 v-else-if="data[0].estandares.seccion !== 7 && data[0].estandares.a15[(index + 42) - 1]"
                      style="font-size:10px; color: #0000FF; font-weight: bold;">
                    {{ data[0].estandares.a15[(index + 42) - 1] }}
                  </h1>
                  <h1 v-else style="font-size:10px; color: #0000FF;">NA</h1>
                </th>
              </tr>




              <tr>
                <th scope="col">Empaque rasguñado o rayado</th>

                <!-- Sección 0 -->
                <th style="text-align: center;" v-for="index in 6" :key="index + 's16h1'">
                    <div style="text-align: center;" class="select-wrapper" v-if="data[0].estandares.seccion === 0">
                        <select class="custom-select"
                                :disabled="data[0].user.rolname !== 'PROD'"
                                v-model="data[0].estandares.a16[index - 1]">
                        <option value="">--</option> <!-- Permite quitar la selección -->
                        <option value="A">A</option>
                        <option value="V">V</option>
                        <option value="R">R</option>
                        </select>
                        <span class="selected-value">{{ data[0].estandares.a16[index - 1] || "--" }}</span>
                    </div>

                  <!-- <input v-if="data[0].estandares.seccion === 0"
                         class="grd_input-code"
                         :disabled="data[0].user.rolname !== 'PROD'"
                         v-model="data[0].estandares.a16[index - 1]"
                         maxlength="1"> -->
                  <h1 v-else-if="data[0].estandares.seccion !== 0 && data[0].estandares.a16[index - 1]"
                      style="font-size:10px; color: #0000FF; font-weight: bold;">
                    {{ data[0].estandares.a16[index - 1] }}
                  </h1>
                  <h1 v-else style="font-size:10px; color: #0000FF;">NA</h1>
                </th>

                <!-- Sección 1 -->
                <th style="text-align: center;" v-for="index in 6" :key="index + 's16h2'">
                    <div style="text-align: center;" class="select-wrapper" v-if="data[0].estandares.seccion === 1">
                        <select class="custom-select"
                                :disabled="data[0].user.rolname !== 'PROD'"
                                v-model="data[0].estandares.a16[(index + 6) - 1]">
                        <option value="">--</option> <!-- Permite quitar la selección -->
                        <option value="A">A</option>
                        <option value="V">V</option>
                        <option value="R">R</option>
                        </select>
                        <span class="selected-value">{{ data[0].estandares.a16[(index + 6) - 1] || "--" }}</span>
                    </div>

                  <!-- <input v-if="data[0].estandares.seccion === 1"
                         class="grd_input-code"
                         :disabled="data[0].user.rolname !== 'PROD'"
                         v-model="data[0].estandares.a16[(index + 6) - 1]"
                         maxlength="1"> -->
                  <h1 v-else-if="data[0].estandares.seccion !== 1 && data[0].estandares.a16[(index + 6) - 1]"
                      style="font-size:10px; color: #0000FF; font-weight: bold;">
                    {{ data[0].estandares.a16[(index + 6) - 1] }}
                  </h1>
                  <h1 v-else style="font-size:10px; color: #0000FF;">NA</h1>
                </th>

                <!-- Sección 2 -->
                <th style="text-align: center;" v-for="index in 6" :key="index + 's16h3'">
                    <div style="text-align: center;" class="select-wrapper" v-if="data[0].estandares.seccion === 2">
                        <select class="custom-select"
                                :disabled="data[0].user.rolname !== 'PROD'"
                                v-model="data[0].estandares.a16[(index + 12) - 1]">
                        <option value="">--</option> <!-- Permite quitar la selección -->
                        <option value="A">A</option>
                        <option value="V">V</option>
                        <option value="R">R</option>
                        </select>
                        <span class="selected-value">{{ data[0].estandares.a16[(index + 12) - 1] || "--" }}</span>
                    </div>

                  <!-- <input v-if="data[0].estandares.seccion === 2"
                         class="grd_input-code"
                         :disabled="data[0].user.rolname !== 'PROD'"
                         v-model="data[0].estandares.a16[(index + 12) - 1]"
                         maxlength="1"> -->
                  <h1 v-else-if="data[0].estandares.seccion !== 2 && data[0].estandares.a16[(index + 12) - 1]"
                      style="font-size:10px; color: #0000FF; font-weight: bold;">
                    {{ data[0].estandares.a16[(index + 12) - 1] }}
                  </h1>
                  <h1 v-else style="font-size:10px; color: #0000FF;">NA</h1>
                </th>

                <!-- Sección 3 -->
                <th style="text-align: center;" v-for="index in 6" :key="index + 's16h4'">
                    <div style="text-align: center;" class="select-wrapper" v-if="data[0].estandares.seccion === 3">
                        <select class="custom-select"
                                :disabled="data[0].user.rolname !== 'PROD'"
                                v-model="data[0].estandares.a16[(index + 18) - 1]">
                        <option value="">--</option> <!-- Permite quitar la selección -->
                        <option value="A">A</option>
                        <option value="V">V</option>
                        <option value="R">R</option>
                        </select>
                        <span class="selected-value">{{ data[0].estandares.a16[(index + 18) - 1] || "--" }}</span>
                    </div>

                  <!-- <input v-if="data[0].estandares.seccion === 3"
                         class="grd_input-code"
                         :disabled="data[0].user.rolname !== 'PROD'"
                         v-model="data[0].estandares.a16[(index + 18) - 1]"
                         maxlength="1"> -->
                  <h1 v-else-if="data[0].estandares.seccion !== 3 && data[0].estandares.a16[(index + 18) - 1]"
                      style="font-size:10px; color: #0000FF; font-weight: bold;">
                    {{ data[0].estandares.a16[(index + 18) - 1] }}
                  </h1>
                  <h1 v-else style="font-size:10px; color: #0000FF;">NA</h1>
                </th>

                <!-- Sección 4 -->
                <th style="text-align: center;" v-for="index in 6" :key="index + 's16h5'">
                    <div style="text-align: center;" class="select-wrapper" v-if="data[0].estandares.seccion === 4">
                        <select class="custom-select"
                                :disabled="data[0].user.rolname !== 'PROD'"
                                v-model="data[0].estandares.a16[(index + 24) - 1]">
                        <option value="">--</option> <!-- Permite quitar la selección -->
                        <option value="A">A</option>
                        <option value="V">V</option>
                        <option value="R">R</option>
                        </select>
                        <span class="selected-value">{{ data[0].estandares.a16[(index + 24) - 1] || "--" }}</span>
                    </div>

                  <!-- <input v-if="data[0].estandares.seccion === 4"
                         class="grd_input-code"
                         :disabled="data[0].user.rolname !== 'PROD'"
                         v-model="data[0].estandares.a16[(index + 24) - 1]"
                         maxlength="1"> -->
                  <h1 v-else-if="data[0].estandares.seccion !== 4 && data[0].estandares.a16[(index + 24) - 1]"
                      style="font-size:10px; color: #0000FF; font-weight: bold;">
                    {{ data[0].estandares.a16[(index + 24) - 1] }}
                  </h1>
                  <h1 v-else style="font-size:10px; color: #0000FF;">NA</h1>
                </th>

                <!-- Sección 5 -->
                <th style="text-align: center;" v-for="index in 6" :key="index + 's16h6'">
                    <div style="text-align: center;" class="select-wrapper" v-if="data[0].estandares.seccion === 5">
                        <select class="custom-select"
                                :disabled="data[0].user.rolname !== 'PROD'"
                                v-model="data[0].estandares.a16[(index + 30) - 1]">
                        <option value="">--</option> <!-- Permite quitar la selección -->
                        <option value="A">A</option>
                        <option value="V">V</option>
                        <option value="R">R</option>
                        </select>
                        <span class="selected-value">{{ data[0].estandares.a16[(index + 30) - 1] || "--" }}</span>
                    </div>

                  <!-- <input v-if="data[0].estandares.seccion === 5"
                         class="grd_input-code"
                         :disabled="data[0].user.rolname !== 'PROD'"
                         v-model="data[0].estandares.a16[(index + 30) - 1]"
                         maxlength="1"> -->
                  <h1 v-else-if="data[0].estandares.seccion !== 5 && data[0].estandares.a16[(index + 30) - 1]"
                      style="font-size:10px; color: #0000FF; font-weight: bold;">
                    {{ data[0].estandares.a16[(index + 30) - 1] }}
                  </h1>
                  <h1 v-else style="font-size:10px; color: #0000FF;">NA</h1>
                </th>

                <!-- Sección 6 -->
                <th style="text-align: center;" v-for="index in 6" :key="index + 's16h7'">
                    <div style="text-align: center;" class="select-wrapper" v-if="data[0].estandares.seccion === 6">
                        <select class="custom-select"
                                :disabled="data[0].user.rolname !== 'PROD'"
                                v-model="data[0].estandares.a16[(index + 36) - 1]">
                        <option value="">--</option> <!-- Permite quitar la selección -->
                        <option value="A">A</option>
                        <option value="V">V</option>
                        <option value="R">R</option>
                        </select>
                        <span class="selected-value">{{ data[0].estandares.a16[(index + 36) - 1] || "--" }}</span>
                    </div>

                  <!-- <input v-if="data[0].estandares.seccion === 6"
                         class="grd_input-code"
                         :disabled="data[0].user.rolname !== 'PROD'"
                         v-model="data[0].estandares.a16[(index + 36) - 1]"
                         maxlength="1"> -->
                  <h1 v-else-if="data[0].estandares.seccion !== 6 && data[0].estandares.a16[(index + 36) - 1]"
                      style="font-size:10px; color: #0000FF; font-weight: bold;">
                    {{ data[0].estandares.a16[(index + 36) - 1] }}
                  </h1>
                  <h1 v-else style="font-size:10px; color: #0000FF;">NA</h1>
                </th>

                <!-- Sección 7 -->
                <th style="text-align: center;" v-for="index in 6" :key="index + 's16h8'">
                    <div style="text-align: center;" class="select-wrapper" v-if="data[0].estandares.seccion === 7">
                        <select class="custom-select"
                                :disabled="data[0].user.rolname !== 'PROD'"
                                v-model="data[0].estandares.a16[(index + 42) - 1]">
                        <option value="">--</option> <!-- Permite quitar la selección -->
                        <option value="A">A</option>
                        <option value="V">V</option>
                        <option value="R">R</option>
                        </select>
                        <span class="selected-value">{{ data[0].estandares.a16[(index + 42) - 1] || "--" }}</span>
                    </div>

                  <!-- <input v-if="data[0].estandares.seccion === 7"
                         class="grd_input-code"
                         :disabled="data[0].user.rolname !== 'PROD'"
                         v-model="data[0].estandares.a16[(index + 42) - 1]"
                         maxlength="1"> -->
                  <h1 v-else-if="data[0].estandares.seccion !== 7 && data[0].estandares.a16[(index + 42) - 1]"
                      style="font-size:10px; color: #0000FF; font-weight: bold;">
                    {{ data[0].estandares.a16[(index + 42) - 1] }}
                  </h1>
                  <h1 v-else style="font-size:10px; color: #0000FF;">NA</h1>
                </th>
              </tr>



              <tr>
                <th scope="col">Codigo de Barra o Lote Ilegible, posición incorrecta en sachel o corrugado</th>

                <!-- Sección 0 -->
                <th style="text-align: center;" v-for="index in 6" :key="index + 's17h1'">
                    <div style="text-align: center;" class="select-wrapper" v-if="data[0].estandares.seccion === 0">
                        <select class="custom-select"
                                :disabled="data[0].user.rolname !== 'PROD'"
                                v-model="data[0].estandares.a17[index - 1]">
                        <option value="">--</option> <!-- Permite quitar la selección -->
                        <option value="A">A</option>
                        <option value="V">V</option>
                        <option value="R">R</option>
                        </select>
                        <span class="selected-value">{{ data[0].estandares.a17[index - 1] || "--" }}</span>
                    </div>

                  <!-- <input v-if="data[0].estandares.seccion === 0"
                         class="grd_input-code"
                         :disabled="data[0].user.rolname !== 'PROD'"
                         v-model="data[0].estandares.a17[index - 1]"
                         maxlength="1"> -->
                  <h1 v-else-if="data[0].estandares.seccion !== 0 && data[0].estandares.a17[index - 1]"
                      style="font-size:10px; color: #0000FF; font-weight: bold;">
                    {{ data[0].estandares.a17[index - 1] }}
                  </h1>
                  <h1 v-else style="font-size:10px; color: #0000FF;">NA</h1>
                </th>

                <!-- Sección 1 -->
                <th style="text-align: center;" v-for="index in 6" :key="index + 's17h2'">
                    <div style="text-align: center;" class="select-wrapper" v-if="data[0].estandares.seccion === 1">
                        <select class="custom-select"
                                :disabled="data[0].user.rolname !== 'PROD'"
                                v-model="data[0].estandares.a17[(index + 6) - 1]">
                        <option value="">--</option> <!-- Permite quitar la selección -->
                        <option value="A">A</option>
                        <option value="V">V</option>
                        <option value="R">R</option>
                        </select>
                        <span class="selected-value">{{ data[0].estandares.a17[(index + 6) - 1] || "--" }}</span>
                    </div>

                  <!-- <input v-if="data[0].estandares.seccion === 1"
                         class="grd_input-code"
                         :disabled="data[0].user.rolname !== 'PROD'"
                         v-model="data[0].estandares.a17[(index + 6) - 1]"
                         maxlength="1"> -->
                  <h1 v-else-if="data[0].estandares.seccion !== 1 && data[0].estandares.a17[(index + 6) - 1]"
                      style="font-size:10px; color: #0000FF; font-weight: bold;">
                    {{ data[0].estandares.a17[(index + 6) - 1] }}
                  </h1>
                  <h1 v-else style="font-size:10px; color: #0000FF;">NA</h1>
                </th>

                <!-- Sección 2 -->
                <th style="text-align: center;" v-for="index in 6" :key="index + 's17h3'">
                    <div style="text-align: center;" class="select-wrapper" v-if="data[0].estandares.seccion === 2">
                        <select class="custom-select"
                                :disabled="data[0].user.rolname !== 'PROD'"
                                v-model="data[0].estandares.a17[(index + 12) - 1]">
                        <option value="">--</option> <!-- Permite quitar la selección -->
                        <option value="A">A</option>
                        <option value="V">V</option>
                        <option value="R">R</option>
                        </select>
                        <span class="selected-value">{{ data[0].estandares.a17[(index + 12) - 1] || "--" }}</span>
                    </div>

                  <!-- <input v-if="data[0].estandares.seccion === 2"
                         class="grd_input-code"
                         :disabled="data[0].user.rolname !== 'PROD'"
                         v-model="data[0].estandares.a17[(index + 12) - 1]"
                         maxlength="1"> -->
                  <h1 v-else-if="data[0].estandares.seccion !== 2 && data[0].estandares.a17[(index + 12) - 1]"
                      style="font-size:10px; color: #0000FF; font-weight: bold;">
                    {{ data[0].estandares.a17[(index + 12) - 1] }}
                  </h1>
                  <h1 v-else style="font-size:10px; color: #0000FF;">NA</h1>
                </th>

                <!-- Sección 3 -->
                <th style="text-align: center;" v-for="index in 6" :key="index + 's17h4'">
                    <div style="text-align: center;" class="select-wrapper" v-if="data[0].estandares.seccion === 3">
                        <select class="custom-select"
                                :disabled="data[0].user.rolname !== 'PROD'"
                                v-model="data[0].estandares.a17[(index + 18) - 1]">
                        <option value="">--</option> <!-- Permite quitar la selección -->
                        <option value="A">A</option>
                        <option value="V">V</option>
                        <option value="R">R</option>
                        </select>
                        <span class="selected-value">{{ data[0].estandares.a17[(index + 18) - 1] || "--" }}</span>
                    </div>

                  <!-- <input v-if="data[0].estandares.seccion === 3"
                         class="grd_input-code"
                         :disabled="data[0].user.rolname !== 'PROD'"
                         v-model="data[0].estandares.a17[(index + 18) - 1]"
                         maxlength="1"> -->
                  <h1 v-else-if="data[0].estandares.seccion !== 3 && data[0].estandares.a17[(index + 18) - 1]"
                      style="font-size:10px; color: #0000FF; font-weight: bold;">
                    {{ data[0].estandares.a17[(index + 18) - 1] }}
                  </h1>
                  <h1 v-else style="font-size:10px; color: #0000FF;">NA</h1>
                </th>

                <!-- Sección 4 -->
                <th style="text-align: center;" v-for="index in 6" :key="index + 's17h5'">
                    <div style="text-align: center;" class="select-wrapper" v-if="data[0].estandares.seccion === 4">
                        <select class="custom-select"
                                :disabled="data[0].user.rolname !== 'PROD'"
                                v-model="data[0].estandares.a17[(index + 24) - 1]">
                        <option value="">--</option> <!-- Permite quitar la selección -->
                        <option value="A">A</option>
                        <option value="V">V</option>
                        <option value="R">R</option>
                        </select>
                        <span class="selected-value">{{ data[0].estandares.a17[(index + 24) - 1] || "--" }}</span>
                    </div>

                  <!-- <input v-if="data[0].estandares.seccion === 4"
                         class="grd_input-code"
                         :disabled="data[0].user.rolname !== 'PROD'"
                         v-model="data[0].estandares.a17[(index + 24) - 1]"
                         maxlength="1"> -->
                  <h1 v-else-if="data[0].estandares.seccion !== 4 && data[0].estandares.a17[(index + 24) - 1]"
                      style="font-size:10px; color: #0000FF; font-weight: bold;">
                    {{ data[0].estandares.a17[(index + 24) - 1] }}
                  </h1>
                  <h1 v-else style="font-size:10px; color: #0000FF;">NA</h1>
                </th>

                <!-- Sección 5 -->
                <th style="text-align: center;" v-for="index in 6" :key="index + 's17h6'">
                    <div style="text-align: center;" class="select-wrapper" v-if="data[0].estandares.seccion === 5">
                        <select class="custom-select"
                                :disabled="data[0].user.rolname !== 'PROD'"
                                v-model="data[0].estandares.a17[(index + 30) - 1]">
                        <option value="">--</option> <!-- Permite quitar la selección -->
                        <option value="A">A</option>
                        <option value="V">V</option>
                        <option value="R">R</option>
                        </select>
                        <span class="selected-value">{{ data[0].estandares.a17[(index + 30) - 1] || "--" }}</span>
                    </div>

                  <!-- <input v-if="data[0].estandares.seccion === 5"
                         class="grd_input-code"
                         :disabled="data[0].user.rolname !== 'PROD'"
                         v-model="data[0].estandares.a17[(index + 30) - 1]"
                         maxlength="1"> -->
                  <h1 v-else-if="data[0].estandares.seccion !== 5 && data[0].estandares.a17[(index + 30) - 1]"
                      style="font-size:10px; color: #0000FF; font-weight: bold;">
                    {{ data[0].estandares.a17[(index + 30) - 1] }}
                  </h1>
                  <h1 v-else style="font-size:10px; color: #0000FF;">NA</h1>
                </th>

                <!-- Sección 6 -->
                <th style="text-align: center;" v-for="index in 6" :key="index + 's17h7'">
                    <div style="text-align: center;" class="select-wrapper" v-if="data[0].estandares.seccion === 6">
                        <select class="custom-select"
                                :disabled="data[0].user.rolname !== 'PROD'"
                                v-model="data[0].estandares.a17[(index + 36) - 1]">
                        <option value="">--</option> <!-- Permite quitar la selección -->
                        <option value="A">A</option>
                        <option value="V">V</option>
                        <option value="R">R</option>
                        </select>
                        <span class="selected-value">{{ data[0].estandares.a17[(index + 36) - 1] || "--" }}</span>
                    </div>

                  <!-- <input v-if="data[0].estandares.seccion === 6"
                         class="grd_input-code"
                         :disabled="data[0].user.rolname !== 'PROD'"
                         v-model="data[0].estandares.a17[(index + 36) - 1]"
                         maxlength="1"> -->
                  <h1 v-else-if="data[0].estandares.seccion !== 6 && data[0].estandares.a17[(index + 36) - 1]"
                      style="font-size:10px; color: #0000FF; font-weight: bold;">
                    {{ data[0].estandares.a17[(index + 36) - 1] }}
                  </h1>
                  <h1 v-else style="font-size:10px; color: #0000FF;">NA</h1>
                </th>

                <!-- Sección 7 -->
                <th style="text-align: center;" v-for="index in 6" :key="index + 's17h8'">
                    <div style="text-align: center;" class="select-wrapper" v-if="data[0].estandares.seccion === 7">
                        <select class="custom-select"
                                :disabled="data[0].user.rolname !== 'PROD'"
                                v-model="data[0].estandares.a17[(index + 42) - 1]">
                        <option value="">--</option> <!-- Permite quitar la selección -->
                        <option value="A">A</option>
                        <option value="V">V</option>
                        <option value="R">R</option>
                        </select>
                        <span class="selected-value">{{ data[0].estandares.a17[(index + 42) - 1] || "--" }}</span>
                    </div>

                  <!-- <input v-if="data[0].estandares.seccion === 7"
                         class="grd_input-code"
                         :disabled="data[0].user.rolname !== 'PROD'"
                         v-model="data[0].estandares.a17[(index + 42) - 1]"
                         maxlength="1"> -->
                  <h1 v-else-if="data[0].estandares.seccion !== 7 && data[0].estandares.a17[(index + 42) - 1]"
                      style="font-size:10px; color: #0000FF; font-weight: bold;">
                    {{ data[0].estandares.a17[(index + 42) - 1] }}
                  </h1>
                  <h1 v-else style="font-size:10px; color: #0000FF;">NA</h1>
                </th>
              </tr>


              <tr>
                <th scope="col">Fuga del producto</th>

                <!-- Sección 0 -->
                <th style="text-align: center;" v-for="index in 6" :key="index + 's18h1'">
                    <div style="text-align: center;" class="select-wrapper" v-if="data[0].estandares.seccion === 0">
                        <select class="custom-select"
                                :disabled="data[0].user.rolname !== 'PROD'"
                                v-model="data[0].estandares.a18[index - 1]">
                        <option value="">--</option> <!-- Permite quitar la selección -->
                        <option value="A">A</option>
                        <option value="V">V</option>
                        <option value="R">R</option>
                        </select>
                        <span class="selected-value">{{ data[0].estandares.a18[index - 1] || "--" }}</span>
                    </div>

                  <!-- <input v-if="data[0].estandares.seccion === 0"
                         class="grd_input-code"
                         :disabled="data[0].user.rolname !== 'PROD'"
                         v-model="data[0].estandares.a18[index - 1]"
                         maxlength="1"> -->
                  <h1 v-else-if="data[0].estandares.seccion !== 0 && data[0].estandares.a18[index - 1]"
                      style="font-size:10px; color: #0000FF; font-weight: bold;">
                    {{ data[0].estandares.a18[index - 1] }}
                  </h1>
                  <h1 v-else style="font-size:10px; color: #0000FF;">NA</h1>
                </th>

                <!-- Sección 1 -->
                <th style="text-align: center;" v-for="index in 6" :key="index + 's18h2'">
                    <div style="text-align: center;" class="select-wrapper" v-if="data[0].estandares.seccion === 1">
                        <select class="custom-select"
                                :disabled="data[0].user.rolname !== 'PROD'"
                                v-model="data[0].estandares.a18[(index + 6) - 1]">
                        <option value="">--</option> <!-- Permite quitar la selección -->
                        <option value="A">A</option>
                        <option value="V">V</option>
                        <option value="R">R</option>
                        </select>
                        <span class="selected-value">{{ data[0].estandares.a18[(index + 6) - 1] || "--" }}</span>
                    </div>

                  <!-- <input v-if="data[0].estandares.seccion === 1"
                         class="grd_input-code"
                         :disabled="data[0].user.rolname !== 'PROD'"
                         v-model="data[0].estandares.a18[(index + 6) - 1]"
                         maxlength="1"> -->
                  <h1 v-else-if="data[0].estandares.seccion !== 1 && data[0].estandares.a18[(index + 6) - 1]"
                      style="font-size:10px; color: #0000FF; font-weight: bold;">
                    {{ data[0].estandares.a18[(index + 6) - 1] }}
                  </h1>
                  <h1 v-else style="font-size:10px; color: #0000FF;">NA</h1>
                </th>

                <!-- Sección 2 -->
                <th style="text-align: center;" v-for="index in 6" :key="index + 's18h3'">
                    <div style="text-align: center;" class="select-wrapper" v-if="data[0].estandares.seccion === 2">
                        <select class="custom-select"
                                :disabled="data[0].user.rolname !== 'PROD'"
                                v-model="data[0].estandares.a18[(index + 12) - 1]">
                        <option value="">--</option> <!-- Permite quitar la selección -->
                        <option value="A">A</option>
                        <option value="V">V</option>
                        <option value="R">R</option>
                        </select>
                        <span class="selected-value">{{ data[0].estandares.a18[(index + 12) - 1] || "--" }}</span>
                    </div>

                  <!-- <input v-if="data[0].estandares.seccion === 2"
                         class="grd_input-code"
                         :disabled="data[0].user.rolname !== 'PROD'"
                         v-model="data[0].estandares.a18[(index + 12) - 1]"
                         maxlength="1"> -->
                  <h1 v-else-if="data[0].estandares.seccion !== 2 && data[0].estandares.a18[(index + 12) - 1]"
                      style="font-size:10px; color: #0000FF; font-weight: bold;">
                    {{ data[0].estandares.a18[(index + 12) - 1] }}
                  </h1>
                  <h1 v-else style="font-size:10px; color: #0000FF;">NA</h1>
                </th>

                <!-- Sección 3 -->
                <th style="text-align: center;" v-for="index in 6" :key="index + 's18h4'">
                    <div style="text-align: center;" class="select-wrapper" v-if="data[0].estandares.seccion === 3">
                        <select class="custom-select"
                                :disabled="data[0].user.rolname !== 'PROD'"
                                v-model="data[0].estandares.a18[(index + 18) - 1]">
                        <option value="">--</option> <!-- Permite quitar la selección -->
                        <option value="A">A</option>
                        <option value="V">V</option>
                        <option value="R">R</option>
                        </select>
                        <span class="selected-value">{{ data[0].estandares.a18[(index + 18) - 1] || "--" }}</span>
                    </div>

                  <!-- <input v-if="data[0].estandares.seccion === 3"
                         class="grd_input-code"
                         :disabled="data[0].user.rolname !== 'PROD'"
                         v-model="data[0].estandares.a18[(index + 18) - 1]"
                         maxlength="1"> -->
                  <h1 v-else-if="data[0].estandares.seccion !== 3 && data[0].estandares.a18[(index + 18) - 1]"
                      style="font-size:10px; color: #0000FF; font-weight: bold;">
                    {{ data[0].estandares.a18[(index + 18) - 1] }}
                  </h1>
                  <h1 v-else style="font-size:10px; color: #0000FF;">NA</h1>
                </th>

                <!-- Sección 4 -->
                <th style="text-align: center;" v-for="index in 6" :key="index + 's18h5'">
                    <div style="text-align: center;" class="select-wrapper" v-if="data[0].estandares.seccion === 4">
                        <select class="custom-select"
                                :disabled="data[0].user.rolname !== 'PROD'"
                                v-model="data[0].estandares.a18[(index + 24) - 1]">
                        <option value="">--</option> <!-- Permite quitar la selección -->
                        <option value="A">A</option>
                        <option value="V">V</option>
                        <option value="R">R</option>
                        </select>
                        <span class="selected-value">{{ data[0].estandares.a18[(index + 24) - 1] || "--" }}</span>
                    </div>

                  <!-- <input v-if="data[0].estandares.seccion === 4"
                         class="grd_input-code"
                         :disabled="data[0].user.rolname !== 'PROD'"
                         v-model="data[0].estandares.a18[(index + 24) - 1]"
                         maxlength="1"> -->
                  <h1 v-else-if="data[0].estandares.seccion !== 4 && data[0].estandares.a18[(index + 24) - 1]"
                      style="font-size:10px; color: #0000FF; font-weight: bold;">
                    {{ data[0].estandares.a18[(index + 24) - 1] }}
                  </h1>
                  <h1 v-else style="font-size:10px; color: #0000FF;">NA</h1>
                </th>

                <!-- Sección 5 -->
                <th style="text-align: center;" v-for="index in 6" :key="index + 's18h6'">
                    <div style="text-align: center;" class="select-wrapper" v-if="data[0].estandares.seccion === 5">
                        <select class="custom-select"
                                :disabled="data[0].user.rolname !== 'PROD'"
                                v-model="data[0].estandares.a18[(index + 30) - 1]">
                        <option value="">--</option> <!-- Permite quitar la selección -->
                        <option value="A">A</option>
                        <option value="V">V</option>
                        <option value="R">R</option>
                        </select>
                        <span class="selected-value">{{ data[0].estandares.a18[(index + 30) - 1] || "--" }}</span>
                    </div>

                  <!-- <input v-if="data[0].estandares.seccion === 5"
                         class="grd_input-code"
                         :disabled="data[0].user.rolname !== 'PROD'"
                         v-model="data[0].estandares.a18[(index + 30) - 1]"
                         maxlength="1"> -->
                  <h1 v-else-if="data[0].estandares.seccion !== 5 && data[0].estandares.a18[(index + 30) - 1]"
                      style="font-size:10px; color: #0000FF; font-weight: bold;">
                    {{ data[0].estandares.a18[(index + 30) - 1] }}
                  </h1>
                  <h1 v-else style="font-size:10px; color: #0000FF;">NA</h1>
                </th>

                <!-- Sección 6 -->
                <th style="text-align: center;" v-for="index in 6" :key="index + 's18h7'">
                    <div style="text-align: center;" class="select-wrapper" v-if="data[0].estandares.seccion === 6">
                        <select class="custom-select"
                                :disabled="data[0].user.rolname !== 'PROD'"
                                v-model="data[0].estandares.a18[(index + 36) - 1]">
                        <option value="">--</option> <!-- Permite quitar la selección -->
                        <option value="A">A</option>
                        <option value="V">V</option>
                        <option value="R">R</option>
                        </select>
                        <span class="selected-value">{{ data[0].estandares.a18[(index + 36) - 1] || "--" }}</span>
                    </div>

                  <!-- <input v-if="data[0].estandares.seccion === 6"
                         class="grd_input-code"
                         :disabled="data[0].user.rolname !== 'PROD'"
                         v-model="data[0].estandares.a18[(index + 36) - 1]"
                         maxlength="1"> -->
                  <h1 v-else-if="data[0].estandares.seccion !== 6 && data[0].estandares.a18[(index + 36) - 1]"
                      style="font-size:10px; color: #0000FF; font-weight: bold;">
                    {{ data[0].estandares.a18[(index + 36) - 1] }}
                  </h1>
                  <h1 v-else style="font-size:10px; color: #0000FF;">NA</h1>
                </th>

                <!-- Sección 7 -->
                <th style="text-align: center;" v-for="index in 6" :key="index + 's18h8'">
                    <div style="text-align: center;" class="select-wrapper" v-if="data[0].estandares.seccion === 7">
                        <select class="custom-select"
                                :disabled="data[0].user.rolname !== 'PROD'"
                                v-model="data[0].estandares.a18[(index + 42) - 1]">
                        <option value="">--</option> <!-- Permite quitar la selección -->
                        <option value="A">A</option>
                        <option value="V">V</option>
                        <option value="R">R</option>
                        </select>
                        <span class="selected-value">{{ data[0].estandares.a18[(index + 42) - 1] || "--" }}</span>
                    </div>

                  <!-- <input v-if="data[0].estandares.seccion === 7"
                         class="grd_input-code"
                         :disabled="data[0].user.rolname !== 'PROD'"
                         v-model="data[0].estandares.a18[(index + 42) - 1]"
                         maxlength="1"> -->
                  <h1 v-else-if="data[0].estandares.seccion !== 7 && data[0].estandares.a18[(index + 42) - 1]"
                      style="font-size:10px; color: #0000FF; font-weight: bold;">
                    {{ data[0].estandares.a18[(index + 42) - 1] }}
                  </h1>
                  <h1 v-else style="font-size:10px; color: #0000FF;">NA</h1>
                </th>
              </tr>

              <tr>
                <th scope="col">Resultado</th>

                <!-- Sección 0 -->
                <th style="text-align: center;" v-for="index in 6" :key="index + 's19h1'">
                    <div style="text-align: center;" class="select-wrapper" v-if="data[0].estandares.seccion === 0">
                        <select class="custom-select"
                                :disabled="data[0].user.rolname !== 'PROD'"
                                v-model="data[0].estandares.a19[index - 1]">
                        <option value="">--</option> <!-- Permite quitar la selección -->
                        <option value="A">A</option>
                        <option value="V">V</option>
                        <option value="R">R</option>
                        </select>
                        <span class="selected-value">{{ data[0].estandares.a19[index - 1] || "--" }}</span>
                    </div>

                  <!-- <input v-if="data[0].estandares.seccion === 0"
                         class="grd_input-code"
                         :disabled="data[0].user.rolname !== 'PROD'"
                         v-model="data[0].estandares.a19[index - 1]"
                         maxlength="1"> -->
                  <h1 v-else-if="data[0].estandares.seccion !== 0 && data[0].estandares.a19[index - 1]"
                      style="font-size:10px; color: #0000FF; font-weight: bold;">
                    {{ data[0].estandares.a19[index - 1] }}
                  </h1>
                  <h1 v-else style="font-size:10px; color: #0000FF;">NA</h1>
                </th>

                <!-- Sección 1 -->
                <th style="text-align: center;" v-for="index in 6" :key="index + 's19h2'">
                    <div style="text-align: center;" class="select-wrapper" v-if="data[0].estandares.seccion === 1">
                        <select class="custom-select"
                                :disabled="data[0].user.rolname !== 'PROD'"
                                v-model="data[0].estandares.a19[(index + 6) - 1]">
                        <option value="">--</option> <!-- Permite quitar la selección -->
                        <option value="A">A</option>
                        <option value="V">V</option>
                        <option value="R">R</option>
                        </select>
                        <span class="selected-value">{{ data[0].estandares.a19[(index + 6) - 1] || "--" }}</span>
                    </div>

                  <!-- <input v-if="data[0].estandares.seccion === 1"
                         class="grd_input-code"
                         :disabled="data[0].user.rolname !== 'PROD'"
                         v-model="data[0].estandares.a19[(index + 6) - 1]"
                         maxlength="1"> -->
                  <h1 v-else-if="data[0].estandares.seccion !== 1 && data[0].estandares.a19[(index + 6) - 1]"
                      style="font-size:10px; color: #0000FF; font-weight: bold;">
                    {{ data[0].estandares.a19[(index + 6) - 1] }}
                  </h1>
                  <h1 v-else style="font-size:10px; color: #0000FF;">NA</h1>
                </th>

                <!-- Sección 2 -->
                <th style="text-align: center;" v-for="index in 6" :key="index + 's19h3'">
                    <div style="text-align: center;" class="select-wrapper" v-if="data[0].estandares.seccion === 2">
                        <select class="custom-select"
                                :disabled="data[0].user.rolname !== 'PROD'"
                                v-model="data[0].estandares.a19[(index + 12) - 1]">
                        <option value="">--</option> <!-- Permite quitar la selección -->
                        <option value="A">A</option>
                        <option value="V">V</option>
                        <option value="R">R</option>
                        </select>
                        <span class="selected-value">{{ data[0].estandares.a19[(index + 12) - 1] || "--" }}</span>
                    </div>

                  <!-- <input v-if="data[0].estandares.seccion === 2"
                         class="grd_input-code"
                         :disabled="data[0].user.rolname !== 'PROD'"
                         v-model="data[0].estandares.a19[(index + 12) - 1]"
                         maxlength="1"> -->
                  <h1 v-else-if="data[0].estandares.seccion !== 2 && data[0].estandares.a19[(index + 12) - 1]"
                      style="font-size:10px; color: #0000FF; font-weight: bold;">
                    {{ data[0].estandares.a19[(index + 12) - 1] }}
                  </h1>
                  <h1 v-else style="font-size:10px; color: #0000FF;">NA</h1>
                </th>

                <!-- Sección 3 -->
                <th style="text-align: center;" v-for="index in 6" :key="index + 's19h4'">
                    <div style="text-align: center;" class="select-wrapper" v-if="data[0].estandares.seccion === 3">
                        <select class="custom-select"
                                :disabled="data[0].user.rolname !== 'PROD'"
                                v-model="data[0].estandares.a19[(index + 18) - 1]">
                        <option value="">--</option> <!-- Permite quitar la selección -->
                        <option value="A">A</option>
                        <option value="V">V</option>
                        <option value="R">R</option>
                        </select>
                        <span class="selected-value">{{ data[0].estandares.a19[(index + 18) - 1] || "--" }}</span>
                    </div>

                  <!-- <input v-if="data[0].estandares.seccion === 3"
                         class="grd_input-code"
                         :disabled="data[0].user.rolname !== 'PROD'"
                         v-model="data[0].estandares.a19[(index + 18) - 1]"
                         maxlength="1"> -->
                  <h1 v-else-if="data[0].estandares.seccion !== 3 && data[0].estandares.a19[(index + 18) - 1]"
                      style="font-size:10px; color: #0000FF; font-weight: bold;">
                    {{ data[0].estandares.a19[(index + 18) - 1] }}
                  </h1>
                  <h1 v-else style="font-size:10px; color: #0000FF;">NA</h1>
                </th>

                <!-- Sección 4 -->
                <th style="text-align: center;" v-for="index in 6" :key="index + 's19h5'">
                    <div style="text-align: center;" class="select-wrapper" v-if="data[0].estandares.seccion === 4">
                        <select class="custom-select"
                                :disabled="data[0].user.rolname !== 'PROD'"
                                v-model="data[0].estandares.a19[(index + 24) - 1]">
                        <option value="">--</option> <!-- Permite quitar la selección -->
                        <option value="A">A</option>
                        <option value="V">V</option>
                        <option value="R">R</option>
                        </select>
                        <span class="selected-value">{{ data[0].estandares.a19[(index + 24) - 1] || "--" }}</span>
                    </div>

                  <!-- <input v-if="data[0].estandares.seccion === 4"
                         class="grd_input-code"
                         :disabled="data[0].user.rolname !== 'PROD'"
                         v-model="data[0].estandares.a19[(index + 24) - 1]"
                         maxlength="1"> -->
                  <h1 v-else-if="data[0].estandares.seccion !== 4 && data[0].estandares.a19[(index + 24) - 1]"
                      style="font-size:10px; color: #0000FF; font-weight: bold;">
                    {{ data[0].estandares.a19[(index + 24) - 1] }}
                  </h1>
                  <h1 v-else style="font-size:10px; color: #0000FF;">NA</h1>
                </th>

                <!-- Sección 5 -->
                <th style="text-align: center;" v-for="index in 6" :key="index + 's19h6'">
                    <div style="text-align: center;" class="select-wrapper" v-if="data[0].estandares.seccion === 5">
                        <select class="custom-select"
                                :disabled="data[0].user.rolname !== 'PROD'"
                                v-model="data[0].estandares.a19[(index + 30) - 1]">
                        <option value="">--</option> <!-- Permite quitar la selección -->
                        <option value="A">A</option>
                        <option value="V">V</option>
                        <option value="R">R</option>
                        </select>
                        <span class="selected-value">{{ data[0].estandares.a19[(index + 30) - 1] || "--" }}</span>
                    </div>

                  <!-- <input v-if="data[0].estandares.seccion === 5"
                         class="grd_input-code"
                         :disabled="data[0].user.rolname !== 'PROD'"
                         v-model="data[0].estandares.a19[(index + 30) - 1]"
                         maxlength="1"> -->
                  <h1 v-else-if="data[0].estandares.seccion !== 5 && data[0].estandares.a19[(index + 30) - 1]"
                      style="font-size:10px; color: #0000FF; font-weight: bold;">
                    {{ data[0].estandares.a19[(index + 30) - 1] }}
                  </h1>
                  <h1 v-else style="font-size:10px; color: #0000FF;">NA</h1>
                </th>

                <!-- Sección 6 -->
                <th style="text-align: center;" v-for="index in 6" :key="index + 's19h7'">
                    <div style="text-align: center;" class="select-wrapper" v-if="data[0].estandares.seccion === 6">
                        <select class="custom-select"
                                :disabled="data[0].user.rolname !== 'PROD'"
                                v-model="data[0].estandares.a19[(index + 36) - 1]">
                        <option value="">--</option> <!-- Permite quitar la selección -->
                        <option value="A">A</option>
                        <option value="V">V</option>
                        <option value="R">R</option>
                        </select>
                        <span class="selected-value">{{ data[0].estandares.a19[(index + 36) - 1] || "--" }}</span>
                    </div>

                  <!-- <input v-if="data[0].estandares.seccion === 6"
                         class="grd_input-code"
                         :disabled="data[0].user.rolname !== 'PROD'"
                         v-model="data[0].estandares.a19[(index + 36) - 1]"
                         maxlength="1"> -->
                  <h1 v-else-if="data[0].estandares.seccion !== 6 && data[0].estandares.a19[(index + 36) - 1]"
                      style="font-size:10px; color: #0000FF; font-weight: bold;">
                    {{ data[0].estandares.a19[(index + 36) - 1] }}
                  </h1>
                  <h1 v-else style="font-size:10px; color: #0000FF;">NA</h1>
                </th>

                <!-- Sección 7 -->
                <th style="text-align: center;" v-for="index in 6" :key="index + 's19h8'">
                    <div style="text-align: center;" class="select-wrapper" v-if="data[0].estandares.seccion === 7">
                        <select class="custom-select"
                                :disabled="data[0].user.rolname !== 'PROD'"
                                v-model="data[0].estandares.a19[(index + 42) - 1]">
                        <option value="">--</option> <!-- Permite quitar la selección -->
                        <option value="A">A</option>
                        <option value="V">V</option>
                        <option value="R">R</option>
                        </select>
                        <span class="selected-value">{{ data[0].estandares.a19[(index + 42) - 1] || "--" }}</span>
                    </div>

                  <!-- <input v-if="data[0].estandares.seccion === 7"
                         class="grd_input-code"
                         :disabled="data[0].user.rolname !== 'PROD'"
                         v-model="data[0].estandares.a19[(index + 42) - 1]"
                         maxlength="1"> -->
                  <h1 v-else-if="data[0].estandares.seccion !== 7 && data[0].estandares.a19[(index + 42) - 1]"
                      style="font-size:10px; color: #0000FF; font-weight: bold;">
                    {{ data[0].estandares.a19[(index + 42) - 1] }}
                  </h1>
                  <h1 v-else style="font-size:10px; color: #0000FF;">NA</h1>
                </th>
              </tr>



              <tr>

                <th>REALIZÓ</th>

                <th style="text-align:center; font-size:8px" v-for="index in 8" :key="index" colspan="6">
                    <input
                      type="text"
                      class="form-control"
                      :disabled="true"
                      style="font-size:12px; text-align: center;"
                      v-model="data[0].estandares.realizo[index-1]"
                    />
                </th>

              </tr>

              <tr>

                <th>VERIFICÓ</th>

                <th style="text-align:center; font-size:8px" v-for="index in 8" :key="index" colspan="6">
                    <input
                      type="text"
                      style="font-size:12px; text-align: center;"
                      class="form-control"
                      :disabled="true"
                      v-model="data[0].estandares.verifico[index-1]"
                    />
                </th>

              </tr>

              <tr>

                <th>ACCIONES INMEDIATAS EN CASO DE DEFECTO ÁMBAR O ROJO</th>

                <th colspan="48">
                  <textarea id="observaciones" :disabled="data[0].user.rolname!='PROD' || data[0].estandares.seccion >=8" v-model="data[0].estandares.observaciones" class="form-control" rows="4"></textarea>
                </th>

              </tr>

              
            </thead>
            <!-- Fila de nota -->
            <tr>
              <th colspan="49" style="text-align:left"><strong>NOTA:</strong></th>
            </tr>

            <!-- Fila VERDE -->
            <tr>
              <td class="bg-verde text-center" style="width:150px;"><strong>VERDE (V)</strong></td>
              <td colspan="48">Cumple con las especificaciones</td>
            </tr>

            <!-- Fila ÁMBAR -->
            <tr>
              <td class="bg-ambar text-center"><strong>ÁMBAR (A)</strong></td>
              <td colspan="48">Cuando su condición no cumple totalmente con los CRQS, puede ser aprobado con tolerancia.</td>
            </tr>

            <!-- Fila ROJO -->
            <tr>
              <td class="bg-rojo text-center"><strong>ROJO (R)</strong></td>
              <td colspan="48">Cuando su condición no cumple con los CRQS o está fuera de la especificación</td>
            </tr>

            <!-- Fila Book de Defectos -->
            <tr>
              <td colspan="49">
                Para mayor detalle de los defectos presentados en los sachets refiérase al <strong>Book de Defectos Sachets</strong>
              </td>
            </tr>
            <tbody>

            </tbody>
       

          </table>
            <div class="text-end pt-4">
              <div class="col-auto">
                <button type="button" v-if="data[0].estandares.seccion ==9" @click="generatedReport" class="btn btn-dark"><i class="bi bi-file-earmark-pdf"></i> Generar Reporte</button>
                <button
                  type="button"
                  :disabled="data[0].estandares.seccion >= 8 || pendienteVerificacion"
                  v-if="data[0].user.rolname=='PROD'"
                  @click="saveOrUpdate"
                  class="btn btn-success"
                  :title="pendienteVerificacion ? 'Esperando verificación de calidad para continuar' : 'Guardar'"
                >
                  Guardar
                </button>
                <button
                  type="button"
                  :disabled="data[0].estandares.seccion != 8 || data[0].estandares.supervisado"
                  v-if="data[0].user.rolname == 'SPROD'"
                  @click="saveOrUpdate"
                  class="btn btn-success">
                  Confirmar
                </button>

                <!-- <button type="button" :disabled="data[0].estandares.seccion !=8" v-if="data[0].user.rolname=='SPROD'" @click="saveOrUpdate" class="btn btn-success">Confirmar</button> -->

                <button type="button" :disabled="data[0].estandares.seccion >=8" v-if="data[0].user.rolname=='PROD'" @click="nextSection" class="btn btn-warning">Siguiente Sección</button>

                <button type="button" :disabled="data[0].estandares.seccion >=8" v-if="data[0].user.rolname == 'CL' || data[0].user.rolname == 'ACL'" @click="saveOrUpdate" class="btn btn-success">Verificar</button>


                <button type="button" :disabled="data[0].estandares.seccion >=8" v-if="data[0].user.rolname == 'CL' || data[0].user.rolname == 'ACL'" @click="aprovedEstandar" class="btn btn-primary">Finalizar</button>
                <button
                  type="button"
                  :disabled="data[0].estandares.seccion == 9"
                  v-if="(data[0].user.rolname == 'CL' || data[0].user.rolname == 'ACL') && data[0].estandares.supervisado"
                  @click="aprovedEstandar"
                  class="btn btn-secondary"
                >
                  Autorizar
                </button>

                <!-- <button type="button" :disabled="data[0].estandares.seccion ==9" v-if="data[0].user.rolname == 'CL' || data[0].user.rolname == 'ACL'" @click="aprovedEstandar" class="btn btn-secondary">Autorizar</button> -->
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
const { upsertEstandares, nextSectionEstandares  } = require("../service.js");


   import { VueMaskDirective } from 'v-mask'
    Vue.directive('mask', VueMaskDirective);
export default {
  props: {
    source: { type: Object, required: true },
  },
  data: function () {
    return {
      data: this.source,
      edit_mode: false,
      reporte:false,
      presentacionInput: '',
      pendienteVerificacion: false, // true después de que PROD guarda; se resetea cuando Calidad verifica
    };
  },
  computed: {
      presentacionValue: {
      get() {
        const presentacion =
          this.data[0]?.estandares?.presentacion?.trim() ||
          this.data[0]?.order?.presentacion?.trim() ||
          this.data[0]?.order?.presentacion_sap?.trim() ||
          '';

        // También actualiza la variable local
        this.presentacionInput = presentacion;
        return presentacion;
      },
      set(val) {
        this.presentacionInput = val;

        if (this.data[0]?.order) {
          this.data[0].order.presentacion = val;
        }

        if (this.data[0]?.estandares) {
          this.data[0].estandares.presentacion = val;
        }
      }
    }
  },

  created() {
    if (!this.data[0]?.estandares?.presentacion) {
      const presentacionBase =
        this.data[0]?.e?.presentacion ||
        this.data[0]?.order?.presentacion_sap ||
        '';
      this.data[0].estandares.presentacion = presentacionBase.trim();
      this.presentacionInput = presentacionBase.trim(); // Guardar en la variable
    } else {
      this.presentacionInput = this.data[0].estandares.presentacion; // Inicializar desde lo existente
    }

    // Cargar hora actual si es PROD y la hora de la seccion actual esta vacia
    if (this.data[0]?.user?.rolname === 'PROD') {
      const seccion = this.data[0]?.estandares?.seccion || 0;
      if (!this.data[0].estandares.horas[seccion]) {
        const now = new Date();
        const hours = String(now.getHours()).padStart(2, '0');
        const minutes = String(now.getMinutes()).padStart(2, '0');
        // Usar this.$set para reactividad en Vue 2
        this.$set(this.data[0].estandares.horas, seccion, `${hours}:${minutes}`);
      }
    }
  },

  methods: {

    nextSection: async function() {
      console.log("Sección actual:", this.data[0].estandares.seccion);

      const seccion = this.data[0].estandares.seccion;
      const array = [1, 2, 3, 4, 5, 6];
      const limite = array.length;

      let current_rowcol_pivot = null;
      let valid = false;

      // Validar que no haya campos llenos aún en la sección siguiente
      MainLoop: for (let row = 1; row <= 19; row++) {
        for (const index of array) {
          current_rowcol_pivot = this.data[0].estandares['a' + row][(index + (limite * seccion)) - 1];
          if (current_rowcol_pivot != null && current_rowcol_pivot.trim().length > 0) {
            valid = false;
            break MainLoop;
          }
        }
        valid = true;
      }

      // Validar la fecha
      let fecha = validateDate2(this.data[0].estandares.fecharealizada);
      if (fecha === null) {
        StatusHandler.ShowStatus("Debes ingresar una fecha válida", StatusHandler.OPERATION.DEFAULT, StatusHandler.STATUS.FAIL);
        return;
      }

      // Validar si ya hay datos llenos en la siguiente sección (no permitido)
      if (!valid) {
        StatusHandler.ShowStatus(
          "Acción no permitida, algunos campos ya han sido llenados, debe esperar que su encargado verifique la información.",
          StatusHandler.OPERATION.DEFAULT,
          StatusHandler.STATUS.FAIL
        );
        return;
      }

      // 🔒 Validar que la sección actual esté VERIFICADA solo si hay datos llenados
      const horaActual = (this.data[0].estandares.horas?.[seccion] || "").trim();
      const realizoActual = (this.data[0].estandares.realizo?.[seccion] || "").trim();
      
      // Solo validar verificación si hay hora O realizo llenados
      if (horaActual.length > 0 || realizoActual.length > 0) {
        const verifico = (
          (this.data[0].estandares.verifico?.[seccion] || this.data[0].estandares.verifico?.[seccion - 1] || "")
        ).trim();

        if (!verifico || verifico.length < 3) {
          StatusHandler.ShowStatus(
            `No puedes avanzar. La sección ${seccion} aún no ha sido verificada por tu encargado.`,
            StatusHandler.OPERATION.DEFAULT,
            StatusHandler.STATUS.FAIL
          );
          return;
        }
      }

      // Confirmación
      const confirm = await StatusHandler.Confirm("¿Desea realizar esta acción?");
      if (!confirm) return;

      StatusHandler.LShow();
      
      // 👇 Guardar el usuario actual ANTES de hacer la petición
      const currentUser = { ...this.data[0].user };
      
      this.data[0].estandares.seccion += 1;

      nextSectionEstandares(this.data[0]).then(result => {
        let response = result.data;
        if (response.code == 0) {
          this.data[0].estandares.seccion -= 1;
          StatusHandler.LClose();
          StatusHandler.ShowStatus(response.msg, StatusHandler.OPERATION.DEFAULT, StatusHandler.STATUS.FAIL);
          return;
        }

        // 👇 Actualizar solo order y estandares, preservar el usuario
        if (response.data && Array.isArray(response.data) && response.data[0]) {
          this.data[0].order = response.data[0].order;
          this.data[0].estandares = response.data[0].estandares;
          // 👇 Restaurar el usuario original en lugar del que viene null
          this.data[0].user = currentUser;

          // Cargar hora actual si es PROD y la hora de la seccion actual esta vacia
          if (this.data[0]?.user?.rolname === 'PROD') {
            const currentSec = this.data[0]?.estandares?.seccion || 0;
            if (!this.data[0].estandares.horas[currentSec]) {
              const now = new Date();
              const hours = String(now.getHours()).padStart(2, '0');
              const minutes = String(now.getMinutes()).padStart(2, '0');
              this.$set(this.data[0].estandares.horas, currentSec, `${hours}:${minutes}`);
            }
          }
        }
        
        this.edit_mode = false;
        StatusHandler.LClose();
        StatusHandler.ShowStatus("¡Acción Exitosa!", StatusHandler.OPERATION.CREATE, StatusHandler.STATUS.SUCCESS);
      }).catch(ex => {
        this.data[0].estandares.seccion -= 1;
        StatusHandler.LClose();
        StatusHandler.Exception("Ocurrió un error", ex);
      });
    },

    // nextSection: async function() {
    //   console.log("Seccion: actual");
    //   console.log(this.data[0].estandares.seccion);

    //   const seccion = this.data[0].estandares.seccion;
    //   const array = [1, 2, 3, 4, 5, 6];
    //   const limite = array.length;

    //   let current_rowcol_pivot = null;
    //   let valid = false;

    //   // Validar que no haya campos llenos aún en la sección siguiente
    //   MainLoop: for (let row = 1; row <= 19; row++) {
    //     for (const index of array) {
    //       current_rowcol_pivot = this.data[0].estandares['a' + row][(index + (limite * seccion)) - 1];
    //       if (current_rowcol_pivot != null && current_rowcol_pivot.trim().length > 0) {
    //         valid = false;
    //         break MainLoop;
    //       }
    //     }
    //     valid = true;
    //   }

    //   // Validar la fecha
    //   let fecha = validateDate2(this.data[0].estandares.fecharealizada);
    //   if (fecha === null) {
    //     StatusHandler.ShowStatus("Debes ingresar una fecha válida", StatusHandler.OPERATION.DEFAULT, StatusHandler.STATUS.FAIL);
    //     return;
    //   }

    //   // Validar si ya hay datos llenos en la siguiente sección (no permitido)
    //   if (!valid) {
    //     StatusHandler.ShowStatus("Acción no permitida, algunos campos ya han sido llenados, debe esperar que su encargado verifique la información.", StatusHandler.OPERATION.DEFAULT, StatusHandler.STATUS.FAIL);
    //     return;
    //   }

    //   // 🔒 Validar que la sección actual esté verificada (realizo[seccion] debe tener un valor válido)
    //   const verificado = this.data[0].estandares.realizo[seccion];
    //   if (!verificado || verificado.trim().length < 3) {
    //     StatusHandler.ShowStatus("No puedes avanzar. La sección actual no ha sido verificada aún.", StatusHandler.OPERATION.DEFAULT, StatusHandler.STATUS.FAIL);
    //     return;
    //   }

    //   // Confirmación
    //   const confirm = await StatusHandler.Confirm("¿Desea realizar esta acción?");
    //   if (!confirm) return;

    //   StatusHandler.LShow();
    //   this.data[0].estandares.seccion += 1;

    //   upsertEstandares(this.data[0]).then(result => {
    //     let response = result.data;
    //     if (response.code == 0) {
    //       this.data[0].estandares.seccion -= 1;
    //       StatusHandler.ShowStatus(response.msg, StatusHandler.OPERATION.DEFAULT, StatusHandler.STATUS.FAIL);
    //       return;
    //     }

    //     this.data = response.data;
    //     this.edit_mode = false;
    //     StatusHandler.LClose();
    //     StatusHandler.ShowStatus("¡Acción Exitosa!", StatusHandler.OPERATION.CREATE, StatusHandler.STATUS.SUCCESS);
    //   }).catch(ex => {
    //     if (this.data[0].user.rolname == 'CL' || this.data[0].user.rolname == 'ACL')
    //       this.data[0].estandares.seccion -= 1;
    //     if (this.data[0].user.rolname == 'SPROD')
    //       this.data[0].estandares.supervisado = "";
    //     StatusHandler.LClose();
    //     StatusHandler.Exception("Ocurrió un error", ex);
    //   });
    // },

    // nextSection: async function(){

    //   console.log("Seccion: actual");
    //   console.log(this.data[0].estandares.seccion);

    //   const seccion = this.data[0].estandares.seccion;
    //   const array = [1,2,3,4,5,6];
    //   const limite = array.length;
    //   //console.log("3");

    //   var current_rowcol_pivot = null;
    //   var valid = false;

    //   MainLoop : for (let row = 1; row <= 19; row++){
    //     ChildLoop: for (const index of array){
    //       current_rowcol_pivot = this.data[0].estandares['a' + row][(index + (limite * seccion))-1];
    //       if (current_rowcol_pivot != null && current_rowcol_pivot.trim().length > 0){
    //         valid = false;
    //         break MainLoop;
    //       }
    //     }
    //     valid = true;
    //   }

    //   let fecha = validateDate2(this.data[0].estandares.fecharealizada);

    //   // Validar la fecha realizada
    //   if (fecha === null) {
    //     StatusHandler.ShowStatus("Debes ingresar una fecha válida", StatusHandler.OPERATION.DEFAULT, StatusHandler.STATUS.FAIL);
    //     return;
    //   }

    //   if(!valid){
    //     StatusHandler.ShowStatus("Accion no permitida, algunos campos ya han sido llenados",StatusHandler.OPERATION.DEFAULT,StatusHandler.STATUS.FAIL);
    //     return;
    //   }

    //   var confirm = await StatusHandler.Confirm("¿Desea realizar esta acción?");
    //   if(!confirm)return;
    //   StatusHandler.LShow();

    //   this.data[0].estandares.seccion=this.data[0].estandares.seccion+1;

    //   upsertEstandares(this.data[0]).then(result=>{
    //                 let response = result.data;
    //                 if(response.code == 0){
    //                   this.data[0].estandares.seccion=this.data[0].estandares.seccion-1;
    //                     StatusHandler.ShowStatus(response.msg,StatusHandler.OPERATION.DEFAULT,StatusHandler.STATUS.FAIL);
    //                     return;
    //                 }

    //                 this.data = response.data;
    //                 this.edit_mode = false;
    //                 StatusHandler.LClose();
    //                 StatusHandler.ShowStatus("¡Acción Exitosa!",StatusHandler.OPERATION.DEFAULT,StatusHandler.STATUS.SUCCESS);
    //             }).catch(ex=>{
    //                 if(this.data[0].user.rolname=='CL' || this.data[0].user.rolname=='ACL')
    //                   this.data[0].estandares.seccion=this.data[0].estandares.seccion-1;
    //                 if(this.data[0].user.rolname=='SPROD')
    //                   this.data[0].estandares.supervisado="";
    //                 StatusHandler.LClose();
    //                 StatusHandler.Exception("Ocurrió un error",ex);
    // })

    // },

    saveOrUpdate: async function () {
      const seccion = this.data[0].estandares.seccion;
      const rol = this.data[0].user.rolname;

      // Si NO es SPROD, hacer todas las validaciones
      if (rol !== 'SPROD') {
        // Validar fecha (solo para PROD)
        if (rol === 'PROD') {
          let fecha = validateDate2(this.data[0].estandares.fecharealizada);

          if (fecha === null) {
            StatusHandler.ShowStatus("Debes ingresar una fecha válida", StatusHandler.OPERATION.DEFAULT, StatusHandler.STATUS.FAIL);
            return;
          }

          // if (!validateDateNow(convertServerDate2(fecha))) {
          //   StatusHandler.ShowStatus("Debes ingresar una fecha mayor que hoy", StatusHandler.OPERATION.DEFAULT, StatusHandler.STATUS.FAIL);
          //   return;
          // }
          if (!validateDateNow(convertServerDate2(fecha))) {
            StatusHandler.ShowStatus("Debes ingresar una fecha válida", StatusHandler.OPERATION.DEFAULT, StatusHandler.STATUS.FAIL);
            return;
          }
        }

        // Validar horas
        const horas = this.data[0].estandares.horas[seccion];
        if (horas === undefined || horas === null || horas.length < 5) {
          StatusHandler.ShowStatus("Debes ingresar una hora válida", StatusHandler.OPERATION.DEFAULT, StatusHandler.STATUS.FAIL);
          return;
        }

        // Validar presentación
        const presentacion = this.presentacionInput;
        if (!presentacion || presentacion.trim() === '') {
          // StatusHandler.ShowStatus("Debes ingresar una presentación", StatusHandler.OPERATION.DEFAULT, StatusHandler.STATUS.FAIL);
          return;
        }

        this.data[0].estandares.presentacion = presentacion;

        // Validar "realizó"
        // const realizado = this.data[0].estandares.realizo[seccion];
        // if (!realizado || realizado.trim().length < 3) {
        //   StatusHandler.ShowStatus("Debes ingresar el nombre de quien realizó la verificación", StatusHandler.OPERATION.DEFAULT, StatusHandler.STATUS.FAIL);
        //   return;
        // }

        // Validar a1–a19
        const campos = [
          'a1', 'a2', 'a3', 'a4', 'a5', 'a6', 'a7', 'a8', 'a9', 'a10',
          'a11', 'a12', 'a13', 'a14', 'a15', 'a16', 'a17', 'a18', 'a19'
        ];
        const errores = [];

        campos.forEach(campo => {
          const arreglo = this.data[0].estandares[campo];
          const inicio = seccion * 6;
          const valores = arreglo.slice(inicio, inicio + 6);
          const validos = valores.every(val => ['A', 'V', 'R'].includes(val));
          if (!validos) {
            errores.push(campo.toUpperCase());
          }
        });

        if (errores.length > 0) {
          StatusHandler.ShowStatus(`Debes completar todos los campos de la sección antes de verificar.`, StatusHandler.OPERATION.DEFAULT, StatusHandler.STATUS.FAIL);
          return;
        }

        // Registrar verificación si es CL o ACL
        if (rol === 'CL' || rol === 'ACL') {
          this.data[0].estandares.verifico[seccion] = this.data[0].user.username;
          this.data[0].estandares.seccion += 1;
        }
      } else {
        // SPROD puede enviar sin validaciones
        this.data[0].estandares.supervisado = this.data[0].user.username;
      }

      // Confirmación
      const confirm = await StatusHandler.Confirm("¿Desea realizar esta acción?");
      if (!confirm) return;

      StatusHandler.LShow();

      upsertEstandares(this.data[0]).then(result => {
        let response = result.data;
        if (response.code === 0) {
          if (rol === 'CL' || rol === 'ACL') this.data[0].estandares.seccion -= 1;
          if (rol === 'SPROD') this.data[0].estandares.supervisado = "";
          StatusHandler.ShowStatus(response.msg, StatusHandler.OPERATION.DEFAULT, StatusHandler.STATUS.FAIL);
          return;
        }

        this.data = response.data;
        this.edit_mode = false;

        // Bloquear el botón Guardar de PROD hasta que Calidad verifique
        if (rol === 'PROD') {
          this.pendienteVerificacion = true;
        }
        // Si Calidad verifica (sección avanza), desbloquear para PROD
        if (rol === 'CL' || rol === 'ACL') {
          this.pendienteVerificacion = false;
        }

        StatusHandler.LClose();
        StatusHandler.ShowStatus("¡Acción Exitosa!", StatusHandler.OPERATION.CREATE, StatusHandler.STATUS.SUCCESS);
      }).catch(ex => {
        if (rol === 'CL' || rol === 'ACL') this.data[0].estandares.seccion -= 1;
        if (rol === 'SPROD') this.data[0].estandares.supervisado = "";
        StatusHandler.LClose();
        StatusHandler.Exception("Ocurrió un error", ex);
      });
    },

  //   saveOrUpdate: async function () {
  //     const seccion = this.data[0].estandares.seccion;
  //     const rol = this.data[0].user.rolname;

  //     // Si es PRODUCCIÓN, validar que la fecha realizada sea válida
  //     if (rol === 'PROD') {
  //         let fecha = validateDate2(this.data[0].estandares.fecharealizada);

  //         if (fecha === null) {
  //             StatusHandler.ShowStatus("Debes ingresar una fecha válida", StatusHandler.OPERATION.DEFAULT, StatusHandler.STATUS.FAIL);
  //             return;
  //         }

  //         if (!validateDateNow(convertServerDate2(fecha))) {
  //             StatusHandler.ShowStatus("Debes ingresar una fecha mayor que hoy", StatusHandler.OPERATION.DEFAULT, StatusHandler.STATUS.FAIL);
  //             return;
  //         }
  //     }

  //     // Validar horas y presentación (para todos los roles antes de verificar)
  //     const horas = this.data[0].estandares.horas[seccion];
  //     if (horas === undefined || horas === null || horas.length < 5) {
  //         StatusHandler.ShowStatus("Debes ingresar una hora válida", StatusHandler.OPERATION.DEFAULT, StatusHandler.STATUS.FAIL);
  //         return;
  //     }

  //   const presentacion = this.presentacionInput;

  //   if (!presentacion || presentacion.trim() === '') {
  //       StatusHandler.ShowStatus("Debes ingresar una presentación", StatusHandler.OPERATION.DEFAULT, StatusHandler.STATUS.FAIL);
  //       return;
  //   }

  //   // 💾 Asegura que se asigna al objeto a enviar
  //   this.data[0].estandares.presentacion = presentacion;

  //   // Confirmación
  //   console.log("📤 Enviando datos:", this.data[0].estandares);

  //     // 🔍 Validar que "realizó" tenga un nombre (solo si NO es PROD)
  //     if (rol !== 'PROD') {
  //         const realizado = this.data[0].estandares.realizo[seccion];
  //         if (!realizado || realizado.trim().length < 3) {
  //             StatusHandler.ShowStatus("Debes ingresar el nombre de quien realizó la verificación", StatusHandler.OPERATION.DEFAULT, StatusHandler.STATUS.FAIL);
  //             return;
  //         }
  //     }

  //     // 🔍 Validar que todos los campos a1–a19 de esta sección estén completos (para todos los roles)
  //     const campos = [
  //         'a1', 'a2', 'a3', 'a4', 'a5', 'a6', 'a7', 'a8', 'a9', 'a10',
  //         'a11', 'a12', 'a13', 'a14', 'a15', 'a16', 'a17', 'a18', 'a19'
  //     ];
  //     const errores = [];

  //     campos.forEach(campo => {
  //         const arreglo = this.data[0].estandares[campo];
  //         const inicio = seccion * 6;
  //         const valores = arreglo.slice(inicio, inicio + 6);

  //         const validos = valores.every(val => ['A', 'V', 'R'].includes(val));
  //         if (!validos) {
  //             errores.push(campo.toUpperCase());
  //         }
  //     });

  //     if (errores.length > 0) {
  //         StatusHandler.ShowStatus(
  //             `Debes completar todos los campos de la sección antes de verificar.`,
  //             StatusHandler.OPERATION.DEFAULT,
  //             StatusHandler.STATUS.FAIL
  //         );
  //         return;
  //     }

  //     // ✅ Confirmar acción
  //     var confirm = await StatusHandler.Confirm("¿Desea realizar esta acción?");
  //     if (!confirm) return;

  //     StatusHandler.LShow();

  //     // Rol de calidad avanza sección
  //     if (rol === 'CL' || rol === 'ACL') {
  //         this.data[0].estandares.verifico[seccion] = this.data[0].user.username;
  //         this.data[0].estandares.seccion += 1;
  //     }

  //     // Supervisor guarda su nombre
  //     if (rol === 'SPROD') {
  //         this.data[0].estandares.supervisado = this.data[0].user.username;
  //     }

  //     upsertEstandares(this.data[0]).then(result => {
  //         let response = result.data;
  //         if (response.code === 0) {
  //             if (rol === 'CL' || rol === 'ACL') {
  //                 this.data[0].estandares.seccion -= 1;
  //             }
  //             if (rol === 'SPROD') {
  //                 this.data[0].estandares.supervisado = "";
  //             }
  //             StatusHandler.ShowStatus(response.msg, StatusHandler.OPERATION.DEFAULT, StatusHandler.STATUS.FAIL);
  //             return;
  //         }

  //         this.data = response.data;
  //         this.edit_mode = false;
  //         StatusHandler.LClose();
  //         StatusHandler.ShowStatus("¡Acción Exitosa!", StatusHandler.OPERATION.DEFAULT, StatusHandler.STATUS.SUCCESS);
  //     }).catch(ex => {
  //         if (rol === 'CL' || rol === 'ACL') {
  //             this.data[0].estandares.seccion -= 1;
  //         }
  //         if (rol === 'SPROD') {
  //             this.data[0].estandares.supervisado = "";
  //         }
  //         StatusHandler.LClose();
  //         StatusHandler.Exception("Ocurrió un error", ex);
  //     });
  // },
  // Ultima version de la funcion vieja y funciona
  // aprovedEstandar: async function(){
  //               var confirm = await StatusHandler.Confirm("¿Desea realizar esta acción?");
  //               if(!confirm)return;
  //               StatusHandler.LShow();
  //               //this.data[0].estandares.seccion=this.data[0].estandares.seccion+1;
  //             let statusactual= this.data[0].estandares.seccion;
  //             let rolautorizado= this.data[0].estandares.autorizado;
  //             if(this.data[0].estandares.seccion != 8)
  //               this.data[0].estandares.seccion=8;
  //             else if(this.data[0].estandares.seccion == 8){
  //                 this.data[0].estandares.autorizado=this.data[0].user.username;
  //                 this.data[0].estandares.seccion=9;
  //             }
  //               upsertEstandares(this.data[0]).then(result=>{
  //                   let response = result.data;
  //                   if(response.code == 0){
  //                       this.data[0].estandares.seccion=this.data[0].estandares.seccion-1;
  //                       StatusHandler.ShowStatus(response.msg,StatusHandler.OPERATION.DEFAULT,StatusHandler.STATUS.FAIL);
  //                       return;
  //                   }

  //                   this.data = response.data;
  //                   this.edit_mode = false;
  //                   StatusHandler.LClose();
  //                   StatusHandler.ShowStatus("¡Acción Exitosa!",StatusHandler.OPERATION.CREATE,StatusHandler.STATUS.SUCCESS);
  //               }).catch(ex=>{
  //                   this.data[0].estandares.seccion=statusactual;
  //                   this.data[0].estandares.autorizado= rolautorizado;
  //                   StatusHandler.LClose();
  //                   StatusHandler.Exception("Ocurrió un error",ex);
  //               })
  //           },
  aprovedEstandar: async function () {
    const confirm = await StatusHandler.Confirm("¿Desea realizar esta acción?");
    if (!confirm) return;

    let statusactual = this.data[0].estandares.seccion;
    let rolautorizado = this.data[0].estandares.autorizado;
    let estandares = this.data[0].estandares;
    let seccion = Number(estandares.seccion) || 0;

    // 🔒 Validar que la sección actual esté VERIFICADA solo si tiene datos
    let idx = seccion;
    const realizoActual = (estandares.realizo?.[idx] || "").trim();
    const verificoActual = (
      (estandares.verifico?.[idx] || estandares.verifico?.[idx - 1] || "")
    ).trim();

    // Solo validar si hay datos en "realizo"
    if (realizoActual.length > 0 && (!verificoActual || verificoActual.length < 3)) {
      StatusHandler.ShowStatus(
        `No puedes continuar. La sección ${idx} aún no ha sido verificada por tu encargado.`,
        StatusHandler.OPERATION.DEFAULT,
        StatusHandler.STATUS.FAIL
      );
      return;
    }

    // 🔎 Validación de columnas realizadas pero no verificadas (solo al finalizar)
    if (seccion >= 8) {
      for (let i = 0; i <= 7; i++) {
        const realizo = (estandares.realizo?.[i] || "").trim();
        const verifico = (
          (estandares.verifico?.[i] || estandares.verifico?.[i - 1] || "")
        ).trim();

        // 👇 CAMBIO: Solo validar si "realizo" tiene datos
        if (realizo.length > 0 && (!verifico || verifico.length < 3)) {
          StatusHandler.ShowStatus(
            `⚠️ No puede finalizar. La columna ${i + 1} fue realizada pero aún no está verificada. 
            Por favor, verifique esa columna antes de continuar.`,
            StatusHandler.OPERATION.DEFAULT,
            StatusHandler.STATUS.FAIL
          );
          return;
        }
      }
    }

    // ✅ Si pasa todas las validaciones, ahora sí mostramos loader
    StatusHandler.LShow();

    try {
      // 🚩 Flujo normal de avance
      if (seccion < 8) {
        // Caso Finalizar: manda a sección 8
        this.data[0].estandares.seccion = 8;
        this.data[0].estandares.autorizado = "";

        // 🔒 limpiar verificación de sección 8 si existía
        if (this.data[0].estandares.verifico?.[8]) {
          this.data[0].estandares.verifico[8] = "";
        }

      } else if (seccion === 8) {
        // 🚩 Caso Autorizar: pasa a sección 9
        this.data[0].estandares.autorizado = this.data[0].user.username;
        this.data[0].estandares.seccion = 9;
      }

      const result = await upsertEstandares(this.data[0]);
      let response = result.data;

      if (response.code === 0) {
        // rollback si falla
        this.data[0].estandares.seccion = statusactual;
        this.data[0].estandares.autorizado = rolautorizado;
        StatusHandler.LClose();
        StatusHandler.ShowStatus(
          response.msg,
          StatusHandler.OPERATION.DEFAULT,
          StatusHandler.STATUS.FAIL
        );
        return;
      }

      // 👇 Preservar usuario actual
      const currentUser = { ...this.data[0].user };
      
      if (response.data && Array.isArray(response.data) && response.data[0]) {
        this.data[0].order = response.data[0].order;
        this.data[0].estandares = response.data[0].estandares;
        this.data[0].user = currentUser;
      }

      this.edit_mode = false;
      StatusHandler.LClose();
      StatusHandler.ShowStatus(
        "¡Acción Exitosa!",
        StatusHandler.OPERATION.CREATE,
        StatusHandler.STATUS.SUCCESS
      );

    } catch (ex) {
      // rollback en caso de excepción
      this.data[0].estandares.seccion = statusactual;
      this.data[0].estandares.autorizado = rolautorizado;
      StatusHandler.LClose();
      StatusHandler.Exception("Ocurrió un error", ex);
    }
  },

    generatedReport: function(){
      var open_url = window.location.origin + `/report/estandarescalidad/${this.data[0].order.num_id}/${this.data[0].estandares.turno}`;
      window.open(open_url, '_blank').focus();
    },

    // saveOrUpdate: async function() {
    // if (this.data[0].user.rolname === 'PROD') {
    //     let fecha = validateDate2(this.data[0].estandares.fecharealizada);

    //     // Validar la fecha realizada
    //     if (fecha === null) {
    //         StatusHandler.ShowStatus("Debes ingresar una fecha válida", StatusHandler.OPERATION.DEFAULT, StatusHandler.STATUS.FAIL);
    //         return;
    //     }
    //     if (!validateDateNow(convertServerDate2(fecha))) {
    //         StatusHandler.ShowStatus("Debes ingresar una fecha mayor que hoy", StatusHandler.OPERATION.DEFAULT, StatusHandler.STATUS.FAIL);
    //         return;
    //     }

    //     // Validar horas
    //     const seccion = this.data[0].estandares.seccion;
    //     const horas = this.data[0].estandares.horas[seccion];

    //     // Asegúrate de que 'horas' no sea nulo
    //     if (horas === undefined) {
    //         StatusHandler.ShowStatus("El campo de horas está vacío para esta sección", StatusHandler.OPERATION.DEFAULT, StatusHandler.STATUS.FAIL);
    //         return;
    //     }

    //     // Verificar que 'horas' tiene la longitud adecuada
    //     if (seccion < 8 && (horas === null || horas.length < 5)) {
    //         StatusHandler.ShowStatus("Debes ingresar una hora válida", StatusHandler.OPERATION.DEFAULT, StatusHandler.STATUS.FAIL);
    //         return;
    //     }

    //     // Validar presentación
    //     const presentacion = this.data[0].estandares.presentacion;
    //     if (seccion < 8) {
    //         if (presentacion === null || presentacion.length === 0) {
    //             StatusHandler.ShowStatus("Debes ingresar una presentación", StatusHandler.OPERATION.DEFAULT, StatusHandler.STATUS.FAIL);
    //             return;
    //         }
    //     }

    //     // Validación de secciones (a1-a19) por rol PROD
    //     if (this.data[0].user.rolname === 'PROD') {
    //         const seccion = this.data[0].estandares.seccion;
    //         const campos = [
    //             'a1', 'a2', 'a3', 'a4', 'a5', 'a6', 'a7', 'a8', 'a9', 'a10',
    //             'a11', 'a12', 'a13', 'a14', 'a15', 'a16', 'a17', 'a18', 'a19'
    //         ];
    //         const errores = [];

    //         campos.forEach(campo => {
    //             const arreglo = this.data[0].estandares[campo];
    //             const inicio = seccion * 6;
    //             const valores = arreglo.slice(inicio, inicio + 6);

    //             const validos = valores.every(val => ['A', 'V', 'R'].includes(val));
    //             if (!validos) {
    //                 errores.push(campo.toUpperCase());
    //             }
    //         });

    //         if (errores.length > 0) {
    //             StatusHandler.ShowStatus(
    //                 // `Debes completar todos los campos de la sección ${seccion} en: ${errores.join(', ')}`,
    //                 `Debes completar todos los campos de la secciónes de cada pregunta!`,
    //                 StatusHandler.OPERATION.DEFAULT,
    //                 StatusHandler.STATUS.FAIL
    //             );
    //             return;
    //         }
    //     }

    // }

    // // Confirmar la acción
    // var confirm = await StatusHandler.Confirm("¿Desea realizar esta acción?");
    // if (!confirm) return;

    //             StatusHandler.LShow();
    //             //this.data[0].estandares.seccion=this.data[0].estandares.seccion+1;
    //           if(this.data[0].user.rolname=='CL' || this.data[0].user.rolname=='ACL')
    //             this.data[0].estandares.seccion=this.data[0].estandares.seccion+1;
    //           if(this.data[0].user.rolname=='SPROD')
    //             this.data[0].estandares.supervisado=this.data[0].user.username;
    //             upsertEstandares(this.data[0]).then(result=>{
    //                 let response = result.data;
    //                 if(response.code == 0){
    //                     if(this.data[0].user.rolname=='CL' || this.data[0].user.rolname=='ACL')
    //                       this.data[0].estandares.seccion=this.data[0].estandares.seccion-1;
    //                     if(this.data[0].user.rolname=='SPROD')
    //                       this.data[0].estandares.supervisado="";
    //                     StatusHandler.ShowStatus(response.msg,StatusHandler.OPERATION.DEFAULT,StatusHandler.STATUS.FAIL);
    //                     return;
    //                 }

    //                 this.data = response.data;
    //                 this.edit_mode = false;
    //                 StatusHandler.LClose();
    //                 StatusHandler.ShowStatus("¡Acción Exitosa!",StatusHandler.OPERATION.DEFAULT,StatusHandler.STATUS.SUCCESS);
    //             }).catch(ex=>{
    //                 if(this.data[0].user.rolname=='CL' || this.data[0].user.rolname=='ACL')
    //                   this.data[0].estandares.seccion=this.data[0].estandares.seccion-1;
    //                 if(this.data[0].user.rolname=='SPROD')
    //                   this.data[0].estandares.supervisado="";
    //                 StatusHandler.LClose();
    //                 StatusHandler.Exception("Ocurrió un error",ex);
    //             })
    //         },


  },
};
</script>

<style>
.bg-verde {
  background-color: #8fcf8f;
}

.bg-ambar {
  background-color: #f9d88b;
}

.bg-rojo {
  background-color: #f5a6a6;
}

</style>