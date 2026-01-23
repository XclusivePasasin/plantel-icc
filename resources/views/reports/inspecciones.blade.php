<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Validación de Conexión a Tanque</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      padding: 10px;
      margin: 0;
    }

    .titulo {
      text-align: center;
      font-weight: bold;
      margin-bottom: 10px;
      font-size: 16px;
    }

    table {
      border-collapse: collapse;
      margin-bottom: 15px;
    }

    th, td {
      border: 1px solid #000;
      padding: 6px; 
    font-size: 12px;
      text-align: left;
    }

    /* th {
      background-color: #f3f3f3;
    } */

    .lote {
      margin: 20px 0;
      font-size: 14px;
    }

    .section-title {
      font-weight: bold;
      margin-bottom: 5px;
      font-size: 14px;
      text-align: center;
      border: none;
    }

    .small-table {
      width: 40%;
      margin-bottom: 20px;
    }

    .underline {
      text-decoration: underline;
    }

    .tabla-envuelta {
      width: 100%;
    }

    .tabla-envuelta td {
      vertical-align: top;
      width: 100%;
    }

    .subtabla {
      width: 100%;
    }
  </style>
</head>
<body>

<table style="width: 100%; border: 1px solid #000; border-collapse: collapse; table-layout: fixed;">
  <colgroup>
    <col style="width: 12.5%;">
    <col style="width: 12.5%;">
    <col style="width: 12.5%;">
    <col style="width: 12.5%;">
    <col style="width: 12.5%;">
    <col style="width: 12.5%;">
    <col style="width: 12.5%;">
    <col style="width: 12.5%;">
  </colgroup>

  <!-- Encabezado principal -->
  <tr>
    <th colspan="8" style="text-align: center; border: 1px solid #000;">
      VALIDACIÓN DE CONEXIÓN A TANQUE
    </th>
  </tr>

  <!-- Encabezados de bloques -->
  <tr>
    <th colspan="4" style="text-align: center; border: 1px solid #000;">CONEXIÓN</th>
    <th colspan="4" style="text-align: center; border: 1px solid #000;">RECONEXIÓN</th>
  </tr>

  <!-- Fila Fecha/Hora -->
  <tr>
    <th style="border: 1px solid #000;">Fecha</th>
    <td style="border: 1px solid #000;">
      {{ \Carbon\Carbon::parse($data->inspecciones->fechahoraconxtanque1)->format('d/m/Y') }}
    </td>
    <th style="border: 1px solid #000;">Hora</th>
    <td style="border: 1px solid #000;">
      {{ \Carbon\Carbon::parse($data->inspecciones->fechahoraconxtanque1)->format('H:i') }}
    </td>

    <th style="border: 1px solid #000;">Fecha</th>
    <td style="border: 1px solid #000;">&nbsp;</td>
    <th style="border: 1px solid #000;">Hora</th>
    <td style="border: 1px solid #000;">&nbsp;</td>
  </tr>

  <!-- Supervisor -->
  <tr>
    <th style="border: 1px solid #000;">Supervisor</th>
    <td colspan="3" style="border: 1px solid #000;">{{ $data->inspecciones->supervisorconxtanque1 }}</td>
    <th style="border: 1px solid #000;">Supervisor</th>
    <td colspan="3" style="border: 1px solid #000;">&nbsp;</td>
  </tr>

  <!-- Control de calidad -->
  <tr>
    <th style="border: 1px solid #000;">Control de Calidad</th>
    <td colspan="3" style="border: 1px solid #000;">{{ $data->inspecciones->ctrlcalidadconxtanque1 }}</td>
    <th style="border: 1px solid #000;">Control de Calidad</th>
    <td colspan="3" style="border: 1px solid #000;">&nbsp;</td>
  </tr>

  <!-- Operario -->
  <tr>
    <th style="border: 1px solid #000;">Operario de maq.</th>
    <td colspan="3" style="border: 1px solid #000;">{{ $data->inspecciones->opmaquinaconxtanque1 }}</td>
    <th style="border: 1px solid #000;">Operario de maq.</th>
    <td colspan="3" style="border: 1px solid #000;">&nbsp;</td>
  </tr>
</table>



  <div class="lote">
    <strong>PRODUCTO:</strong> {{ $packing->product_name ?? 'N/A' }}
  </div>
  <div class="lote">
    <strong>LOTE:</strong> {{ $data->inspecciones->lote }}
  </div>

  <table class="tabla-envuelta" style="border: none; width: 100%;">
  <tr>
    <!-- 🟥 Rechazos -->
    <td style="border: none; vertical-align: top;">
      <div class="section-title">RECHAZOS</div>
      <table class="subtabla">
        <thead>
          <tr>
            <th>FECHA</th>
            <th>CANTIDAD UNIDADES</th>
          </tr>
        </thead>
        <tbody>
          @for ($i = 1; $i <= 4; $i++)
          <tr>
            <td>{{ optional(\Carbon\Carbon::parse($data->inspecciones->{'rechazadosfecha'.$i}))->format('d/m/Y') }}</td>
            <td>{{ $data->inspecciones->{'rechazadoscantidadund'.$i} ?? 0 }}</td>
          </tr>
          @endfor
          <tr>
            <td><strong>TOTAL</strong></td>
            <td><strong>{{ $data->inspecciones->totalunidadesrechazadas ?? 0 }}</strong></td>
          </tr>
        </tbody>
      </table>
    </td>

    <!-- 🟦 Vacíos -->
    <td style="border: none; vertical-align: top;">
      <div class="section-title">VACÍO</div>
      <table class="subtabla">
        <thead>
          <tr>
            <th>FECHA</th>
            <th>CANTIDAD KGS</th>
          </tr>
        </thead>
        <tbody>
          @for ($i = 1; $i <= 4; $i++)
          <tr>
            <td>{{ optional(\Carbon\Carbon::parse($data->inspecciones->{'vaciosfecha'.$i}))->format('d/m/Y') }}</td>
            <td>{{ number_format($data->inspecciones->{'vacioscantidadkgs'.$i} ?? 0, 2) }} kg</td>
          </tr>
          @endfor
          <tr>
            <td><strong>TOTAL</strong></td>
            <td><strong>{{ number_format($data->inspecciones->totalkilogramosvacios ?? 0, 2) }} kg</strong></td>
          </tr>
        </tbody>
      </table>
    </td>
  </tr>
</table>


<div class="lote">
    <strong>PRODUCTO TERMINADO:</strong>
    {{ $data->inspecciones->productoterminado1 }} C + {{ $data->inspecciones->productoterminado2 }} U
</div>


  <table class="small-table">
    <tr><th>PT+</th><td>{{ $data->inspecciones->pt }}</td></tr>
    <tr><th>PR</th><td>{{ $data->inspecciones->totalunidadesrechazadas }}</td></tr>
    <tr><th>=</th><td>{{ $data->inspecciones->ptotal  }}</td></tr>
  </table>

  <div class="lote">
    <strong>RENDIMIENTO DE MEZCLA:</strong> {{ number_format($data->inspecciones->rendimientomezcla, 2) }}
  </div>

  <div class="lote">
    <strong>CONSUMO DE BOBINA:</strong> <span>{{ $data->inspecciones->consumobobina }}</span>
  </div>

</body>
</html>
