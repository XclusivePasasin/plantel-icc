@php
    function mapRole($role) {
         if (!$role) return "N/A";
        $map = [
            "Mezcla" => "Mezcla",
            "Calidad" => "Analista De Calidad",
            "Produccion" => "Producción",
            "JefeProduccion" => "Jefe De Producción",
            "Muestreo" => "Muestreo",
            "SupCalidad" => "Supervisor De Calidad",
            "JefeControlCalidad" => "Jefe Control De Calidad",
            "AuxControlCalidad" => "Auxiliar Control De Calidad",
        ];
        return $map[$role] ?? $role;
    }
@endphp
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Orden de Producción - Control de Calidad</title>
<!-- ... (unchanged styles) ... --> 
  <style>
    body {
      font-family: Arial, sans-serif;
      font-size: 13px;
      margin: 8px;
    }

    .container {
      width: 100%;
      max-width: 900px;
      margin: auto;
      padding: 4px;
    }

    .text-center {
      text-align: center;
    }

    h3, h4 {
        margin-top: 2px;
        margin-bottom: 2px;
    }


    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 10px;
    }

    th, td {
      border: 1px solid #000;
      padding: 13px; /* aumentado */
      vertical-align: middle;
      text-align: center; /* centrado */
    }

    .no-border td {
      border: none;
      padding: 4px;
      text-align: left;
    }

   
    .resultado {
      font-weight: bold;
      text-align: center;
    }

    .firma-space {
      height: 20px;
    }

    .cargo {
      font-size: 10px;
      color: #555;
      text-align: center;
    }

    .section-title {
      font-weight: bold;
    }

    .no-vertical-lines th {
        border-left: none;
        border-right: none;
    }

    .no-vertical-lines th:first-child {
        border-left: 1px solid #000;
    }

    .no-vertical-lines th:last-child {
        border-right: 1px solid #000;
    }
    .defblue1{
        color: rgb(0, 0, 255) !important;
    }
    .encabezado-compacto th {
        border-left: none;
        border-right: none;
        padding-top: 2px;
        padding-bottom: 2px;
    }

    .encabezado-compacto th:first-child {
        border-left: 1px solid #000;
    }

    .encabezado-compacto th:last-child {
        border-right: 1px solid #000;
    }

    .text-left{
        text-align: left;
    }

    .checkmark {
        display: inline-block;
        width: 18px;
        height: 18px;
        position: relative;
        background-color: transparent;
        box-sizing: border-box;
    }

    .checkmark::before {
    content: '';
    position: absolute;
    display: none;
    left: 6px;
    top: 2px;
    width: 5px;
    height: 10px;
    border: solid blue;
    border-width: 0 2px 2px 0;
    transform: rotate(45deg);
    }

    .checkmark.visible::before {
    display: block;
    }



  </style>
</head>
<body>
  <div class="container">
    <h3 class="text-center"><strong>DISTRIBUIDORA CUSCATLÁN, S.A. DE C.V.</strong></h3>
    <h4 class="text-center">ICC LABORATORIES</h4>
    <h4 class="text-center">ORDEN DE PRODUCCIÓN</h4>

    <table class="no-border">
      <tr>
        <td><strong>FECHA DE LA ORDEN:</strong> {{ $data->orden->order_date }}</td>
        <td><strong>CÓDIGO DEL PRODUCTO:</strong> {{ $data->orden->product_code }}</td>
      </tr>
      <tr>
        <td><strong>NÚMERO DE ORDEN:</strong> {{ $data->orden->num_id }}</td>
        <td><strong>NOMBRE DEL PRODUCTO:</strong> {{ $data->orden->product_name }}</td>
      </tr>
    </table>

    <table>
      <tr><th colspan="3" class="section-title encabezado-compacto">CONTROL DE AGUA</th></tr>
      <tr class="no-vertical-lines encabezado-compacto">
        <th>CONTROL</th>
        <th>ESPECIFICACIÓN</th>
        <th>RESULTADOS</th>
      </tr>
      <tr>
        <td class="text-left "><strong>PH</strong></td>
        <td>5.50 - 8.00</td>
        <td class="defblue1">{{ $data->analisis->ph_agua }}</td>
      </tr>
      <tr>
        <td class="text-left "><strong>CONDUCTIVIDAD</strong></td>
        <td>&lt;= 20 µS/cm</td>
        <td class="defblue1">{{ $data->analisis->conductividad_agua }} µS/cm</td>
      </tr>
      <tr>
        <td class="text-left "><strong>CLORO LIBRE</strong></td>
        <td>1.50 - 2.50 ppm</td>
        <td class="defblue1">{{ $data->analisis->cloro_libre_agua }} ppm</td>
      </tr>

      <tr><th colspan="3" class="section-title">CONTROL DEL PRODUCTO</th></tr>
      <tr class="no-vertical-lines encabezado-compacto">
        <th>CONTROL</th>
        <th>ESPECIFICACIÓN</th>
        <th>RESULTADOS</th>
      </tr>
      <tr>
        <td class="text-left "><strong>PH</strong></td>
        <td>{{ $data->analisis->especificacion_ph_producto }}</td>
        <td class="defblue1">{{ $data->analisis->ph_producto }}</td>
      </tr>
      <tr>
        <td class="text-left "><strong>VISCOSIDAD</strong></td>
        <td>{{ $data->analisis->especificacion_viscosidad_producto }}</td>
        <td class="defblue1">{{ $data->analisis->viscosidad_producto }} mPas</td>
      </tr>
      <tr>
        <td class="text-left "><strong>DENSIDAD</strong></td>
        <td>{{ $data->analisis->especificacion_densidad_producto }}</td>
        <td class="defblue1 ">{{ $data->analisis->densidad_producto }} <sup>g/mL</sup></td>
      </tr>

      <!-- APARIENCIA -->
      <tr>
        <td class="align-middle text-left"><strong>APARIENCIA</strong></td>
        <td class="align-middle">IGUAL AL ESTÁNDAR</td>
        <td class="align-middle text-center" >
          {{ $data->analisis->apariencia_producto == 1 ? 'IGUAL AL ESTÁNDAR' : 'NO CUMPLE' }}
        </td>
      </tr>

      <!-- COLOR -->
      <tr>
        <td class="align-middle text-left"><strong>COLOR</strong></td>
        <td class="align-middle">IGUAL AL ESTÁNDAR</td>
        <td class="align-middle text-center" >
          {{ $data->analisis->color_producto == 1 ? 'IGUAL AL ESTÁNDAR' : 'NO CUMPLE' }}
        </td>
      </tr>

      <!-- OLOR -->
      <tr>
        <td class="align-middle text-left"><strong>OLOR</strong></td>
        <td class="align-middle">IGUAL AL ESTÁNDAR</td>
        <td class="align-middle text-center" >
          {{ $data->analisis->olor_producto == 1 ? 'IGUAL AL ESTÁNDAR' : 'NO CUMPLE' }}
        </td>
      </tr>



      @if($data->analisis->observaciones_producto)
      <tr>
        <td ><strong>OBSERVACIONES</strong></td>
        <td colspan="2" class="defblue1 text-left">{{ $data->analisis->observaciones_producto }}</td>
      </tr>
      @endif

      <tr class="section-title">
        <th>REALIZÓ</th>
        <th>VERIFICÓ</th>
        <th>AUTORIZÓ</th>
      </tr>
      <tr class="section-title">
        <th style="height: 16px;"></th>
        <th></th>
        <th></th>
      </tr>
      <tr class="section-title">
        <th>FIRMA</th>
        <th>FIRMA</th>
        <th>FIRMA</th>
      </tr>
      <tr>
        <td class="defblue1">{{ $data->analisis->usuario_crea ?: "N/A" }}</td>
        <td class="defblue1">{{ $data->analisis->usuario_verifica ?: "N/A" }}</td>
        <td class="defblue1">{{ $data->analisis->usuario_autoriza ?: "N/A" }}</td>
      </tr>
      <tr class="section-title">
        <td>NOMBRE</td>
        <td>NOMBRE</td>
        <td>NOMBRE</td>
      </tr>
      <tr class="cargo">
        <td>{{ mapRole($data->analisis->rol_crea) }}</td>
        <td>{{ mapRole($data->analisis->rol_verifica) }}</td>
        <td>{{ mapRole($data->analisis->rol_autoriza) }}</td>
      </tr>
      <tr class="section-title">
        <td>CARGO</td>
        <td>CARGO</td>
        <td>CARGO</td>
      </tr>
      <!-- <tr>
        <td colspan="3"></td>
    </tr> -->
    </table>
  </div>
</body>
</html>
