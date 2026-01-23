<template>
  <div class="container-fluid px-2 px-md-5 py-3">
      <div class="bg-white border rounded shadow-sm p-3 p-md-5">
          <!-- Botón arriba a la izquierda -->
    <div class="d-flex justify-content-end mb-2">
    </div>
          <h5 class="text-center font-weight-bold mb-1">
              DISTRIBUIDORA CUSCATLAN, S.A. DE C.V.
          </h5>
          <h6 class="text-center">ICC LABORATORIES</h6>
          <h6 class="text-center mb-4">ORDEN DE PRODUCCIÓN</h6>

          <div class="table-responsive">
              <table class="table table-bordered text-center mb-4">
                  <thead>
                      <tr>
                          <th colspan="3" class="py-2">CONTROL DEL AGUA</th>
                      </tr>
                      <tr class="thead-light text-dark">
                          <th>CONTROL</th>
                          <th>ESPECIFICACIÓN</th>
                          <th>RESULTADO</th>
                      </tr>
                  </thead>
                  <tbody>
                      <tr>
                          <td>PH</td>
                          <td>5.5 - 8.0</td>
                          <td>
                              <input
                                  type="text"
                                  class="form-control text-left"
                                  v-model="form.resultado_ph"
                                  :disabled="
                                      !editable || !(has_cap('cap-calidad') || has_cap('cap-muestreo') || has_cap('cap-jefecontrol-calidad') || has_cap('cap-mezcla') || has_cap('cap-auxcontrol-calidad') || has_cap('cap-supcalidad'))
                                  "
                              />
                          </td>
                      </tr>
                      <tr>
                          <td>CONDUCTIVIDAD</td>
                          <td>&lt;= 20 µS/cm</td>
                          <td>
                              <input
                                  type="text"
                                  class="form-control text-left"
                                  v-model="form.resultado_conductividad"
                                  :disabled="
                                      !editable || !(has_cap('cap-calidad') || has_cap('cap-muestreo') || has_cap('cap-jefecontrol-calidad') || has_cap('cap-mezcla') || has_cap('cap-auxcontrol-calidad') || has_cap('cap-supcalidad'))
                                  "
                              />
                          </td>
                      </tr>
                      <tr>
                          <td>CLORO LIBRE</td>
                          <td>1.5 - 2.5 ppm</td>
                          <td>
                              <input
                                  type="text"
                                  class="form-control text-left"
                                  v-model="form.resultado_cloro_libre"
                                  :disabled="
                                      !editable || !(has_cap('cap-calidad') || has_cap('cap-muestreo') || has_cap('cap-jefecontrol-calidad') || has_cap('cap-mezcla') || has_cap('cap-auxcontrol-calidad') || has_cap('cap-supcalidad'))
                                  "
                              />
                          </td>
                      </tr>
                      <tr>
                          <td class="align-top">
                              <strong>OBSERVACIONES</strong>
                          </td>
                          <td colspan="2">
                              <textarea
                                  class="form-control mt-2"
                                  rows="3"
                                  v-model="form.observaciones"
                                  :disabled="
                                      !editable || !(has_cap('cap-calidad') || has_cap('cap-muestreo') || has_cap('cap-jefecontrol-calidad') || has_cap('cap-mezcla') || has_cap('cap-auxcontrol-calidad') || has_cap('cap-supcalidad'))
                                  "
                                  placeholder="Escriba aquí..."
                              ></textarea>
                          </td>
                      </tr>
                  </tbody>
              </table>
          </div>

          <div class="d-flex justify-content-end">
              <button
                  v-if="!registroExistente && (has_cap('cap-calidad') || has_cap('cap-muestreo') || has_cap('cap-jefecontrol-calidad') || has_cap('cap-mezcla') || has_cap('cap-auxcontrol-calidad') || has_cap('cap-supcalidad'))"
                  class="btn btn-success"
                  @click="guardar"
              >
                  Guardar
              </button>

              <button
                  v-if="editable == true && registroExistente === true && (has_cap('cap-calidad') || has_cap('cap-muestreo') || has_cap('cap-jefecontrol-calidad') || has_cap('cap-mezcla') || has_cap('cap-auxcontrol-calidad') || has_cap('cap-supcalidad'))"
                  class="btn btn-primary"
                  @click="actualizar"
              >
                  Guardar Cambios
              </button>
               <button
                v-if="registroExistente && (has_cap('cap-calidad') || has_cap('cap-muestreo') || has_cap('cap-jefecontrol-calidad') || has_cap('cap-mezcla') || has_cap('cap-auxcontrol-calidad') || has_cap('cap-supcalidad'))"
                class="btn btn-success mb-2"
                @click="nuevoRegistro"
                >
                Registrar nuevo análisis
                </button>

              

          </div>
      </div>
  </div>
</template>

<script>
import {
  getResultadoAgua,
  createResultadoAgua,
  updateResultadoAgua,
} from "../service.js";

export default {
  data() {
      return {
          form: {
              resultado_ph: "",
              resultado_conductividad: "",
              resultado_cloro_libre: "",
              observaciones: "",
              nombre_usuario: window.user_name || "",  // Asumiendo que lo tienes cargado en el layout
              rol_usuario: window.user_role || "",
          },
          id: null,
          registroExistente: false,
          editable: false,
      };
  },
  mounted() {
      window.user_name = "{{ Auth::user()->name }}";
      window.user_role = "{{ Auth::user()->roles->pluck('name')->first() }}";
      this.cargarResultadoAgua();
  },
  methods: {
      has_cap(e) {
          return window.has_cap == undefined ? false : window.has_cap(e);
      },
      cargarResultadoAgua() {
          StatusHandler.LShow();
          getResultadoAgua()
              .then((response) => {
                  this.form = {
                      resultado_ph: response.data.resultado_ph,
                      resultado_conductividad: response.data.resultado_conductividad,
                      resultado_cloro_libre: response.data.resultado_cloro_libre,
                      observaciones: response.data.observaciones,
                  };
                  this.id = response.data.id;
                  this.registroExistente = true;
                  this.editable = false;
              })
              .catch(() => {
                  this.registroExistente = false;
                  this.editable = true;
                  StatusHandler.ShowStatus(
                      "No existe un registro. Puede crear uno nuevo.",
                      StatusHandler.OPERATION.DEFAULT,
                      StatusHandler.STATUS.INFO
                  );
              })
              .finally(() => {
                  StatusHandler.LClose();
              });
      },
      async nuevoRegistro() {
            const confirm = await StatusHandler.Confirm(
                "Registrar nuevo análisis",
                "¿Está seguro que desea crear un nuevo análisis? Esto desactivará el anterior."
            );

            if (!confirm) return; // Si cancela, no hace nada

            // Limpia el formulario y permite editar
            this.form = {
                resultado_ph: "",
                resultado_conductividad: "",
                resultado_cloro_libre: "",
                observaciones: "",
            };
            this.id = null;
            this.editable = true;
            this.registroExistente = false;
        },


      // Método para guardar el nuevo registro
    guardar: async function () {
          var confirm = await StatusHandler.Confirm("Confirmar creación", "¿Desea guardar este nuevo registro?");
          if (!confirm) return;

          // Preparamos los datos adicionales para enviar
          const datosEnviar = {
              ...this.form,
              // Estos datos se capturarán en el backend desde la sesión o Auth
          };

          StatusHandler.LShow();
          createResultadoAgua(datosEnviar)
              .then(result => {
                  let response = result.data;

                  if (response.code === 0) {
                      StatusHandler.ShowStatus(response.msg, StatusHandler.OPERATION.DEFAULT, StatusHandler.STATUS.FAIL);
                      return;
                  }

                  this.id = response.data.id;
                  this.registroExistente = true;
                  this.editable = false;

                //   StatusHandler.LClose();
                  StatusHandler.ShowStatus("Registro creado exitosamente.", StatusHandler.OPERATION.CREATE, StatusHandler.STATUS.SUCCESS);
              })
              .catch(ex => {
                //   StatusHandler.LClose();
                  StatusHandler.Exception("Error al guardar", ex);
              });
      },


      activarEdicion() {
          this.editable = true;
      },

      actualizar: async function () {
        var confirm = await StatusHandler.Confirm("Confirmar actualización", "¿Está seguro que desea guardar los cambios realizados?");
        if (!confirm) return;

        StatusHandler.LShow();
        updateResultadoAgua(this.id, this.form)
            .then(result => {
                let response = result.data;

                if (response.code === 0) {
                    StatusHandler.ShowStatus(response.msg, StatusHandler.OPERATION.DEFAULT, StatusHandler.STATUS.FAIL);
                    return;
                }

                // Opcional: puedes actualizar el formulario si el backend devuelve datos nuevos
                // this.form = response.data;

                this.editable = false;

                // StatusHandler.LClose();
                StatusHandler.ShowStatus("¡Guardado exitoso!", StatusHandler.OPERATION.CREATE, StatusHandler.STATUS.SUCCESS);
            })
            .catch(ex => {
                // StatusHandler.LClose();
                StatusHandler.Exception("Actualizar registro de agua", ex);
            });
    },
  },
};
</script>

<style scoped>
.table td,
.table th {
  vertical-align: middle;
}
.table-bordered {
  border: 2px solid black;
}
.table-bordered th,
.table-bordered td {
  border: 1px solid black !important;
}
</style>