<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>ICC LABORATORIES - Etiqueta de Identificación de Graneles</title>
  <style>
    body { 
      display: flex; 
      justify-content: center; /* centra horizontalmente */
      align-items: flex-start; /* alinea arriba para documentos largos */
      min-height: 100vh; /* altura mínima de la ventana */
      font-family: Arial, sans-serif; 
      font-size: 12px; 
      margin: 0; 
    }
    
    .container { 
      border: 2px solid #000; 
      padding: 14px;
      max-width: 800px;
      margin: 0 auto; /* centra horizontalmente */
      box-sizing: border-box; /* asegura que padding no expanda más el width */
      background-color: white; /* fondo blanco para el reporte */
    }
    
    .header-row {
      width: 100%;
      margin-bottom: 10px;
    }
    
    .header-table {
      width: 100%;
      border-collapse: collapse;
      border: none;
    }
    
    .header-table td {
      border: none;
      padding: 5px;
      vertical-align: middle;
    }
    
    .logo-cell {
      width: 33%;
      text-align: left;
    }
    
    .title-cell {
      width: 34%;
      text-align: center;
    }
    
    .empty-cell {
      width: 33%;
    }
    
    h2 {
      text-align: center;
      margin: 5px 0;
      font-size: 16px;
      font-weight: bold;
    }
    
    h3 {
      text-align: center;
      margin: 10px 0;
      font-size: 14px;
      font-weight: bold;
    }
    
    h4 {
      margin: 15px 0 10px 0;
      font-size: 12px;
      font-weight: bold;
    }
    
   .tanque-row {
      text-align: center;
      margin: 15px 0;
      display: flex;
      justify-content: center;
      align-items: center; /* Alinea verticalmente */
    }

    .tanque-row .label {
      font-size: 15px;
      font-weight: bold;
    }

    .tanque-numero {
      border: 2px solid #000;
      padding: 5px 10px;
      font-size: 15px;
      font-weight: bold;
      display: inline-block;
      margin-left: 10px;
      margin-bottom: -10px;
    }

    .info-table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 10px;
    }
    
    .info-table td {
      border: none;
      padding: 5px;
      vertical-align: middle;
    }
    
    .label {
      font-weight: bold;
    }
    
    .underlined {
      border-bottom: 1px solid #000;
      padding: 2px 5px;
      min-height: 15px;
      display: inline-block;
      min-width: 100px;
    }
    
    .checkbox-container {
      text-align: center;
      vertical-align: middle;
    }

    .checkbox-container .label {
      display: block;
      margin-bottom: 5px;
    }
    
  
    /* .checkbox-item {
      display: inline-block;
      margin: 0 10px;
      text-align: center;
    } */

    .checkbox-item {
      display: inline-flex;
      flex-direction: column; /* texto arriba, checkbox abajo */
      align-items: center; /* centrar horizontalmente */
      margin: 0 15px;
      gap: 5px; /* espacio entre texto y checkbox */
      font-size: 12px;
    }


    .checkbox-item input[type="checkbox"] {
      transform: scale(1.2); /* opcional: agranda un poco el checkbox */
      margin: 0;
    }


    .checkmark {
      display: inline-block;
      width: 20px;
      height: 20px;
      border: 2px solid #000;
      box-sizing: border-box;
      vertical-align: middle;
      text-align: center;
      line-height: 20px;
      font-size: 16px;
      color: blue; 
      font-weight: bold;
    }

    .checkmark.checked {
      color: blue; 
    }

    
    .parametros-table {
      width: 100%;
      border-collapse: collapse;
      margin: 15px 0;
    }
    
    .parametros-table th,
    .parametros-table td {
      border: 1px solid #000;
      padding: 5px;
      text-align: center;
      font-size: 11px;
    }
    
    .parametros-table th {
      background-color: #f0f0f0;
      font-weight: bold;
    }
    
    .firma-table {
      width: 80%;
      border-collapse: collapse;
      margin-top: 20px;
    }
    
    .firma-table td {
      border: none;
      padding: 10px 5px;
      vertical-align: middle;
    }
    
    .firma-line {
      border-bottom: 1px solid #000;
      min-height: 20px;
      padding: 5px;
      min-width: 150px;
      display: inline-block;
    }

   
  </style>
</head>
<body>
  <div class="container">
    
    <!-- Header con logo y título -->
    <table class="header-table">
      <tr>
        <td class="logo-cell">
          <!-- <img style="max-width: 120px; height: auto;" src="https://www.iccuscatlan.com/wp-content/uploads/logo-icc-dist.webp" alt="ICC Logo"> -->
        </td>
        <td class="title-cell">
          <h2>ICC LABORATORIES</h2>
        </td>
        <td class="empty-cell"></td>
      </tr>
    </table>

    <h3>ETIQUETA DE IDENTIFICACIÓN DE GRANELES</h3>
    
    <!-- Número de tanque -->
    <div class="tanque-row">
      <span style="top: '15px;" class="label">Tanque Nº:</span>
      <span class="tanque-numero">{{ $data->granel->tanque }}</span>
    </div>

    <!-- Información del producto -->
    <table class="info-table">
      <tr>
        <td style="width: 15%;"><span class="label">PRODUCTO:</span></td>
        <td style="width: 85%;"><span class="underlined">{{ $data->granel->producto }}</span></td>
      </tr>
    </table>

    <table class="info-table">
      <tr>
        <td style="width: 15%;"><span class="label">No. DE LOTE:</span></td>
        <td style="width: 18%;"><span class="underlined">{{ $data->granel->lote }}</span></td>
        <td style="width: 12%;"><span class="label">Nº BATCH:</span></td>
        <td style="width: 18%;"><span class="underlined">{{ $data->granel->batch }}</span></td>
        <td style="width: 12%;"><span class="label">Nº ORDEN:</span></td>
        <td style="width: 25%;"><span class="underlined">{{ $data->granel->orden }}</span></td>
      </tr>
    </table>

    <table class="info-table">
      <tr>
        <td style="width: 25%;"><span class="label">FECHA DE FABRICACIÓN:</span></td>
        <td style="width: 35%;"><span class="underlined">{{ $data->granel->fecha_fabricacion ?? '' }}</span></td>
        <td style="width: 15%;"><span class="label">CANTIDAD:</span></td>
        <td style="width: 25%;"><span class="underlined">{{ $data->granel->cantidad }} KG</span></td>
      </tr>
    </table>

    <table class="info-table">
      <tr>
        <td style="width: 25%;"><span class="label">FECHA DE EXPIRACIÓN:</span></td>
        <td style="width: 75%;"><span class="underlined">{{ $data->granel->fecha_expiracion ?? '' }}</span></td>
      </tr>
    </table>

    <!-- Proceso y Color/Olor -->
    <table class="info-table">
      <tr>
        <td style="width: 15%;"><span class="label">PROCESO:</span></td>
        <td style="width: 25%;"><span class="underlined">{{ $data->granel->proceso }}</span></td>
        <td  class="checkbox-container">
        <td style="width: 20%;"><span class="label">COLOR Y OLOR IGUAL AL PATRÓN:</span></td>
        <td style="width: 40%;">
          <div class="checkbox-item" style="display: inline-block; text-align: center; margin-right: 20px;">
            <div style="margin-bottom: 5px;">CUMPLE</div>
            <input type="checkbox" id="cumple" {{ $data->granel->checkbox_result == 'CUMPLE' ? 'checked' : '' }} disabled>
          </div>

          <div class="checkbox-item" style="display: inline-block; text-align: center;">
            <div style="margin-bottom: 5px;">NO CUMPLE</div>
            <input type="checkbox" id="no_cumple" {{ $data->granel->checkbox_result == 'NO CUMPLE' ? 'checked' : '' }} disabled>
          </div>
        </td>
      </tr>
    </table>


   <!-- Parámetros -->
  <h4>PARÁMETROS DE PRODUCTO A GRANEL</h4>
  <table class="parametros-table">
    <thead>
      <tr>
        <th style="width: 70%;">Parámetro</th>
        <th style="width: 70%;">Temperatura °C</th>
        <th style="width: 70%;">Especificaciónes</th>
        <th style="width: 70%;">Resultado</th>
        <th style="width: 70%;">F. Realizo</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>VISCOSIDAD (mPas)</td>
        <td>{{ $data->granel->viscosidad_temp }} °C</td>
        <td>{{ $data->granel->viscosidad }}</td>
        <td>{{ $data->granel->viscosidad_resultado }} mPas</td>
        <td>{{ $data->granel->viscosidad_firma }}</td>
      </tr>
      <tr>
        <td>pH</td>
        <td>{{ $data->granel->ph_temp }} °C</td>
        <td>{{ $data->granel->ph }}</td>
        <td>{{ $data->granel->ph_resultado }}</td>
        <td>{{ $data->granel->ph_firma }}</td>
      </tr>
      <tr>
        <td>Densidad g/mL</td>
        <td>{{ $data->granel->densidad_temp }} °C</td>
        <td>{{ $data->granel->densidad }}</td>
        <td>{{ $data->granel->densidad_resultado }} g/mL</td>
        <td>{{ $data->granel->densidad_firma }}</td>
      </tr>

    </tbody>
  </table>


    <!-- Responsables y Equipo -->
    <table class="firma-table">
      <tr>
        <td style="width: 20%;"><span class="label">RESPONSABLES:</span></td>
        <td style="width: 30%;"><span class="underlined">{{ str_replace(array("\n", "\r", "\n\r"), " ", $data->granel->responsables) }}</span></td>
        <td style="width: 15%;"><span class="label">EQUIPO:</span></td>
        <td style="width: 35%;"><span class="underlined">{{ $data->granel->equipo }}</span></td>
      </tr>
    </table>

    <!-- Firma y Sello -->
    <table class="firma-table">
      <tr>
        <td style="width: 15%;"><span class="label">FIRMA:</span></td>
        <td style="width: 35%;"><span class="firma-line"></span></td>
        <td style="width: 15%;"><span class="label">SELLO:</span></td>
        <td style="width: 35%;"><span class="firma-line"></span></td>
      </tr>
    </table>

    <!-- Código del formulario -->
    <div style="text-align: right; margin-top: 30px; font-size: 10px;">
      CC-PE0021-10
    </div>

  </div>
</body>
</html>