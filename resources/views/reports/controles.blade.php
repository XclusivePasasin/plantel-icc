<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>

    <style>
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

        table, th {
  border: 1px solid black;
  border-collapse: collapse;
}
table td { border-spacing: 1em; }

input[type="checkbox"] {
  cursor: pointer;
  -webkit-appearance: none;
  -moz-appearance: none;
  appearance: none;
  outline: 0;
  height: 18px;
  width: 18px;
  border: 1px solid white;
}

    </style>
    <p class="text-center fw-b1 p-0 m-0">ICC LABORATORIES</p><br>
    <p class="text-center fw-b1 p-0 m-0">HOJA DE CONTROLES EN PROCESO (PESO Y VOLUMEN)</p><br>

    <table style="border:none; width:100%">
        <tr>
            <td style="text-align:left; font-size:12px;" >NOMBRE DEL PRODUCTO: <u style="color: #0000FF; font-weight: bold;">{{$data->order->product_name}}</u></td>

            <td style="text-align:left; font-size:12px;" >LOTE: <u style="color: #0000FF; font-weight: bold;">{{$data->order->lot_num}}</u></td>

            <td style="text-align:left; font-size:12px;" >ORDEN DE PRODUCCIÓN: <u style="color: #0000FF; font-weight: bold;">{{$data->order->num_id}}</u></td>

            <td style="text-align:left; font-size:12px;" >PRESENTACION: <u style="color: #0000FF; font-weight: bold;">{{$data->controles->presentacion}}</u></td>
        </tr>

        <tr>
            <td style="text-align:left; font-size:12px;" >VOLUMEN MÁXIMO: <u style="color: #0000FF; font-weight: bold;">{{$data->controles->vmaximo}}</u></td>

            <td style="text-align:left; font-size:12px;" >VOLUMEN ÓPTIMO: <u style="color: #0000FF; font-weight: bold;">{{$data->controles->voptimo}}</u></td>

            <td style="text-align:left; font-size:12px;" >VOLUMEN MÍNIMO: <u style="color: #0000FF; font-weight: bold;">{{$data->controles->vminimo}}</u></td>

        </tr>

        <tr>
            <td style="text-align:left; font-size:12px;" >PESO MÁXIMO: <u style="color: #0000FF; font-weight: bold;">{{$data->controles->pmaximo}}</u></td>

            <td style="text-align:left; font-size:12px;" >PESO ÓPTIMO: <u style="color: #0000FF; font-weight: bold;">{{$data->controles->poptimo}}</u></td>

            <td style="text-align:left; font-size:12px;" >PESO MÍNIMO: <u style="color: #0000FF; font-weight: bold;">{{$data->controles->pminimo}}</u></td>
        </tr>

        <!-- <tr>
            <td style="text-align:left; font-size:12px;" >FECHA: <u style="color: #0000FF; font-weight: bold;">{{$data->controles->fecharealizada}}</u></td>
        </tr> -->
    </table>
<br>
    <table border="none" cellpadding="1" style="font-size: 13px; width:100%; border-collapse: collapse;">
    <thead>
        <!-- Fila que contiene la columna de pesos y la gráfica -->
        <tr>
      <td style="padding: 0; border: 1px solid #ddd; width: 15%;">
            <div style="display: flex; flex-direction: column; height: 330px;">
                <!-- Máximo -->
                <div style="height: 110px; border-bottom: 1px solid #ddd; background-color: #ccc; position: relative;">
                    <div style="text-align: center; font-weight: bold; font-size: 13px; color: #1b1b1bff; line-height: 1.2; padding-top: 35px;">
                        MÁXIMO<br>
                        {{ $data->controles->pmaximo ?? 'N/A' }}
                    </div>
                </div>
                
                <!-- Óptimo -->
                <div style="height: 110px; border-bottom: 1px solid #ddd; background-color: #ccc; position: relative;">
                    <div style="text-align: center; font-weight: bold; font-size: 13px; color: #1b1b1bff; line-height: 1.2; padding-top: 35px;">
                        ÓPTIMO<br>
                        {{ $data->controles->poptimo ?? 'N/A' }}
                    </div>
                </div>
                
                <!-- Mínimo -->
                <div style="height: 110px; background-color: #ccc; position: relative;">
                    <div style="text-align: center; font-weight: bold; font-size: 13px; color: #1b1b1bff; line-height: 1.2; padding-top: 35px;">
                        MÍNIMO<br>
                        {{ $data->controles->pminimo ?? 'N/A' }}
                    </div>
                </div>
            </div>
        </td>



            
            <!-- Gráfica (derecha) -->
            <td colspan="25" style="text-align: center; padding: 2px; border: 1px solid #ddd;">
                <img src="{{ $chart_image }}" alt="Gráfica de Peso" style="height: 330px; width: 100%; object-fit: contain;">
            </td>
        </tr>

        <!-- Filas de datos (horas, peso/volumen, realizó, verificó) -->
        <tr>
            <th style="font-size: 9px; border: 1px solid #ddd;">HORA</th>
            @for ($i = 1; $i <=25; $i++)
                <th style="text-align:center; font-size:9px; border: 1px solid #ddd;">{{ $data->controles->horas[$i-1] ?? 'N/A' }}</th>
            @endfor
        </tr>

        <tr>
            <th style="text-align:center; font-size:9px; border: 1px solid #ddd;">PESO/VOLUMEN REAL</th>
            @for ($i = 1; $i <=25; $i++)
                <th style="text-align:center; font-size:9px; border: 1px solid #ddd;">
                    @if (!empty($data->controles->m7[$i-1]))
                        <span style="font-size:9px; color: #0000FF; font-weight: bold;">{{ $data->controles->m7[$i-1] }}</span>
                    @else
                        <span style="font-size:7px; color: #0000FF;">NA</span>
                    @endif
                </th>
            @endfor
        </tr>

        <tr>
            <th style="text-align:center; font-size:9px; border: 1px solid #ddd;">REALIZÓ</th>
            @for ($i = 1; $i <=25; $i++)
                <th style="text-align:center; font-size:9px; color: #0000FF; font-weight: bold; border: 1px solid #ddd;">
                    {{ $data->controles->realizo[$i-1] ?? 'N/A' }}
                </th>
            @endfor
        </tr>

        <tr>
            <th style="text-align:center; font-size:9px; border: 1px solid #ddd;">VERIFICÓ</th>
            @for ($i = 1; $i <=25; $i++)
                <th style="text-align:center; font-size:9px; color: #0000FF; font-weight: bold; border: 1px solid #ddd;">
                    {{ $data->controles->verifico[$i-1] ?? 'N/A' }}
                </th>
            @endfor
        </tr>
    </thead>
</table>
    <table style="border:none; width:100%">
        <tr>
            <td style="text-align:left; font-size:12px;" >FECHA: <u style="color: #0000FF; font-weight: bold;">{{$data->controles->fecharealizada2}}</u></td>
        </tr>
    </table>

    <table cellpadding="1" style="font-size: 13px; width:100%">

        <thead>

        {{-- <tr>

            <th style="font-size: 9px;">HORA</th>

            @for ($i = 1; $i <=25; $i++)
                <th style="text-align:center; font-size:9px;" >
                    {{$data->controles->horas[$i+24]}}
                </th>
            @endfor

        </tr>

        <tr>

            <th style="text-align:center; font-size:11px;" colspan="26">PESO/VOLUMEN</th>

        </tr> --}}

        {{-- <tr>
                <th style="text-align:center; font-size:9px;" rowspan="2">MÁXIMO</th>
                @for ($i = 1; $i <=25; $i++)
                    <th style="text-align:center; font-size:9px;" >
                    @if ($data->controles->t1[$i-1]!=null)
                    <h1 style="font-size:9px; color: #0000FF; font-weight: bold;">{{$data->controles->t1[$i-1]}}</h1>
                    @else
                    <h1 style="font-size:7px; color: #0000FF;">NA</h1>
                    @endif
                    </th>
                @endfor
        </tr>

        <tr>
                @for ($i = 1; $i <=25; $i++)
                    <th style="text-align:center; font-size:9px;" >
                    @if ($data->controles->t2[$i-1]!=null)
                    <h1 style="font-size:9px; color: #0000FF; font-weight: bold;">{{$data->controles->t2[$i-1]}}</h1>
                    @else
                    <h1 style="font-size:7px; color: #0000FF;">NA</h1>
                    @endif
                    </th>
                @endfor
        </tr>

        <tr>
                <th style="text-align:center; font-size:9px;" rowspan="2">ÓPTIMO</th>
                @for ($i = 1; $i <=25; $i++)
                    <th style="text-align:center; font-size:9px;" >
                    @if ($data->controles->t3[$i-1]!=null)
                    <h1 style="font-size:9px; color: #0000FF; font-weight: bold;">{{$data->controles->t3[$i-1]}}</h1>
                    @else
                    <h1 style="font-size:7px; color: #0000FF;">NA</h1>
                    @endif
                    </th>
                @endfor
        </tr>

        <tr>
                @for ($i = 1; $i <=25; $i++)
                    <th style="text-align:center; font-size:9px;" >
                    @if ($data->controles->t4[$i-1]!=null)
                    <h1 style="font-size:9px; color: #0000FF; font-weight: bold;">{{$data->controles->t4[$i-1]}}</h1>
                    @else
                    <h1 style="font-size:7px; color: #0000FF;">NA</h1>
                    @endif
                    </th>
                @endfor
        </tr>

        <tr>
                <th style="text-align:center; font-size:9px;" rowspan="2">MÍNIMO</th>
                @for ($i = 1; $i <=25; $i++)
                    <th style="text-align:center; font-size:9px;" >
                    @if ($data->controles->t5[$i-1]!=null)
                    <h1 style="font-size:9px; color: #0000FF; font-weight: bold;">{{$data->controles->t5[$i-1]}}</h1>
                    @else
                    <h1 style="font-size:7px; color: #0000FF;">NA</h1>
                    @endif
                    </th>
                @endfor
        </tr>

        <tr>
                @for ($i = 1; $i <=25; $i++)
                    <th style="text-align:center; font-size:9px;" >
                    @if ($data->controles->t6[$i-1]!=null)
                    <h1 style="font-size:9px; color: #0000FF; font-weight: bold;">{{$data->controles->t6[$i-1]}}</h1>
                    @else
                    <h1 style="font-size:7px; color: #0000FF;">NA</h1>
                    @endif
                    </th>
                @endfor
        </tr> --}}

        {{-- <tr>
                <th style="text-align:center; font-size:9px;">PESO/VOLUMEN REAL</th>
                @for ($i = 1; $i <=25; $i++)
                    <th style="text-align:center; font-size:9px;" >
                    @if ($data->controles->t7[$i-1]!=null)
                    <h1 style="font-size:9px; color: #0000FF; font-weight: bold;">{{$data->controles->t7[$i-1]}}</h1>
                    @else
                    <h1 style="font-size:7px; color: #0000FF;">NA</h1>
                    @endif
                    </th>
                @endfor
        </tr> --}}

        {{-- <tr>
                <th style="text-align:center; font-size:9px;">REALIZÓ</th>
                @for ($i = 1; $i <=25; $i++)
                    @if (strlen($data->controles->t1[$i-1]) > 0 || strlen($data->controles->t2[$i-1]) > 0
                    || strlen($data->controles->t3[$i-1]) > 0 || strlen($data->controles->t4[$i-1]) > 0
                    || strlen($data->controles->t5[$i-1]) > 0 || strlen($data->controles->t6[$i-1]) > 0
                    || strlen($data->controles->t7[$i-1]) > 0)
                        <th style="text-align:center; font-size:9px; color: #0000FF; font-weight: bold;" >
                            {{$data->controles->realizo2[$i-1]}}
                        </th>
                    @else
                        <th style="text-align:center; font-size:9px;" >

                        </th>
                    @endif
                @endfor
        </tr>

        <tr>
                <th style="text-align:center; font-size:9px;">VERIFICÓ</th>
                @for ($i = 1; $i <=25; $i++)
                @if (strlen($data->controles->t1[$i-1]) > 0 || strlen($data->controles->t2[$i-1]) > 0
                    || strlen($data->controles->t3[$i-1]) > 0 || strlen($data->controles->t4[$i-1]) > 0
                    || strlen($data->controles->t5[$i-1]) > 0 || strlen($data->controles->t6[$i-1]) > 0
                    || strlen($data->controles->t7[$i-1]) > 0)
                        <th style="text-align:center; font-size:9px; color: #0000FF; font-weight: bold;" >
                            {{$data->controles->verifico2[$i-1]}}
                        </th>
                    @else
                        <th style="text-align:center; font-size:9px;" >

                        </th>
                    @endif
                @endfor
        </tr> --}}

        <tr>
                <th style="text-align:center; font-size:9px;" colspan="3">ESPECIFICACIONES</th>
                <th style="text-align:center; font-size:9px;" colspan="23">OBSERVACIONES</th>
        </tr>

        <tr>
                <th style="text-align:center; font-size:9px;" >COLOR</th>
                <th style="text-align:center; font-size:9px;" >OLOR</th>
                <th style="text-align:center; font-size:9px;" >CONSISTENCIA</th>
                <th colspan="23" rowspan="3" style="text-align:center; font-size:9px; color: #0000FF; font-weight: bold;">
                    {{$data->controles->observaciones}}
                </th>
        </tr>

        <tr>
                @for ($i = 1; $i <=3; $i++)
                    <th style="text-align:center; font-size:9px; color: #0000FF; font-weight: bold;" >
                        {{$data->controles->e1[$i-1]}}
                    </th>
                @endfor
        </tr>
        {{-- <tr>
                @for ($i = 1; $i <=3; $i++)
                    <th style="text-align:center; font-size:9px; color: #0000FF; font-weight: bold;" >
                        {{$data->controles->e2[$i-1]}}
                    </th>
                @endfor
        </tr> --}}
        </thead>

    </table>
    <br>
    <table style="border:none; width:100%">
        <tr>
            <td style="text-align:center; font-size:12px;" >LLENADO POR: <u style="color: #0000FF; font-weight: bold;">{{$data->controles->llenado}}</u></td>

            <td style="text-align:center; font-size:12px;" >SUPERVISADO POR: <u style="color: #0000FF; font-weight: bold;">{{$data->controles->supervisado}}</u></td>

            <td style="text-align:center; font-size:12px;" >AUTORIZADO POR: <u style="color: #0000FF; font-weight: bold;">{{$data->controles->autorizado}}</u></td>

        </tr>
    </table>

</body>

</html>
