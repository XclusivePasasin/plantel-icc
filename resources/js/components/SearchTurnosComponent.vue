<template>
    <div class="container mt-4">
      <div class="border p-3 bg-white">
        <h5 class="text-center font-bold mb-1">DISTRIBUIDORA CUSCATLAN, S.A. DE C.V.</h5>
        <h6 class="text-center">ICC LABORATORIES</h6>
        <h6 class="text-center mb-3">ORDEN DE PRODUCCIÓN</h6>
  
        <h6 class="text-center bg-warning text-white py-3">CONTROL DEL AGUA</h6>
  
        <table class="table table-bordered text-center">
          <thead class="thead-light">
            <tr>
              <th>CONTROL</th>
              <th>ESPECIFICACIÓN</th>
              <th>RESULTADO</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>PH</td>
              <td>5.5 - 8.0</td>
              <td><input type="text" class="form-control text-center" v-model="form.ph" /></td>
            </tr>
            <tr>
              <td>CONDUCTIVIDAD</td>
              <td>&lt;= 20 µS/cm</td>
              <td><input type="text" class="form-control text-center" v-model="form.conductividad" /></td>
            </tr>
            <tr>
              <td>CLORO LIBRE</td>
              <td>1.5 - 2.5 ppm</td>
              <td><input type="text" class="form-control text-center" v-model="form.cloroLibre" /></td>
            </tr>
            <tr>
              <td colspan="3">
                <strong>OBSERVACIONES</strong>
                <textarea class="form-control mt-2" rows="3" v-model="form.observaciones"></textarea>
              </td>
            </tr>
          </tbody>
        </table>
  
        <div class="text-right">
          <button class="btn btn-success" @click="guardar">Guardar</button>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  export default {
    data() {
      return {
        form: {
          ph: '',
          conductividad: '',
          cloroLibre: '',
          observaciones: ''
        }
      };
    },
    methods: {
      guardar() {
        console.log("Datos guardados:", this.form);
        // Aquí puedes emitir un evento o hacer una petición axios para enviar los datos
      }
    }
  };
  </script>
  
  <style scoped>
  .table td, .table th {
    vertical-align: middle;
  }

  .table-bordered {
    border: 1px solid black;
    }

    .table-bordered th,
    .table-bordered td {
    border: 1px solid black !important;
    }
  </style>
  