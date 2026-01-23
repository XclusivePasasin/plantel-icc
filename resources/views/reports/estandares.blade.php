<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>

    <style>
        .bg-verde { background-color: #8fcf8f; }
        .bg-ambar { background-color: #f9d88b; }
        .bg-rojo  { background-color: #f5a6a6; }
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

    <p class="text-center fw-b1 p-0 m-0">ESTÁNDARES DE CALIDAD RELEVANTES PARA EL CONSUMIDOR (CRQS SACHETS)</p><br>

    <table style="border:none; width:100%">
        <tr>
            <td style="text-align:left; font-size:12px;" >NOMBRE DEL PRODUCTO: <u style="color: #0000FF; font-weight: bold;">{{$data->order->product_name}}</u></td>
            <td style="text-align:left; font-size:12px;" >LOTE: <u style="color: #0000FF; font-weight: bold;">{{$data->order->lot_num}}</u></td>
            <td style="text-align:left; font-size:12px;" >PRESENTACION: <u style="color: #0000FF; font-weight: bold;">{{$data->estandares->presentacion}}</u></td>
        </tr>
        <tr>
            <td style="text-align:left; font-size:12px;" >OPERARIO RESPONSABLE: <u style="color: #0000FF; font-weight: bold;">{{$data->estandares->opresponsable}}</u></td>
        </tr>
        <tr>
            <td style="text-align:left; font-size:12px;" >FECHA: <u style="color: #0000FF; font-weight: bold;">{{$data->estandares->fecharealizada}}</u></td>
            <td style="text-align:left; font-size:12px;" >SUPERVISADO POR: <u style="color: #0000FF; font-weight: bold;">{{$data->estandares->supervisado}}</u></td>
            <td style="text-align:left; font-size:12px;" >AUTORIZADO POR: <u style="color: #0000FF; font-weight: bold;">{{$data->estandares->autorizado}}</u></td>
        </tr>
    </table>

    <table cellpadding="1" style="font-size: 13px; width:100%">

        <thead>

        <tr>

            <th style="font-size: 9px;">Defecto</th>

            @for ($i = 1; $i <=8; $i++)
                <th style="text-align:center; font-size: 9px;" colspan="6">Hora
                    <p>{{$data->estandares->horas[$i-1]}}</p>
                </th>
            @endfor

        </tr>
        <tr>
            <th style="font-size:9px;">Numeración</th>
            @for ($h = 0; $h < 8; $h++) {{-- 8 bloques de hora --}}
                @for ($n = 1; $n <= 6; $n++) {{-- 1..6 por cada hora --}}
                    <th style="text-align:center; font-size:9px;">{{ $n }}</th>
                @endfor
            @endfor
        </tr>
        <tr>
            <th scope="col" style="font-size:9px; width:140px;">Color de la impresión es correcta</th>

            @for ($i = 1; $i <=6; $i++)
                <th>
                    @if ($data->estandares->a1[($i)-1])
                        <h1 style="font-size:9px; color: #0000FF; font-weight: bold;">{{$data->estandares->a1[($i)-1]}}</h1>
                    @else
                        <h1 style="font-size:7px; color: #0000FF;">NA</h1>
                    @endif
                </th>
            @endfor

            @for ($i = 1; $i <=6; $i++)
                <th>
                    @if ($data->estandares->a1[($i+6)-1])
                        <h1 style="font-size:9px; color: #0000FF; font-weight: bold;">{{$data->estandares->a1[($i+6)-1]}}</h1>
                    @else
                        <h1 style="font-size:7px; color: #0000FF;">NA</h1>
                    @endif
                </th>
            @endfor
            @for ($i = 1; $i <=6; $i++)
                <th>
                    @if ($data->estandares->a1[($i+12)-1])
                        <h1 style="font-size:9px; color: #0000FF; font-weight: bold;">{{ $data->estandares->a1[($i+12)-1] }}</h1>
                    @else
                        <h1 style="font-size:7px; color: #0000FF;">NA</h1>
                    @endif
                </th>
            @endfor
            @for ($i = 1; $i <=6; $i++)
                <th>
                    @if ($data->estandares->a1[($i+18)-1])
                        <h1 style="font-size:9px; color: #0000FF; font-weight: bold;">{{ $data->estandares->a1[($i+18)-1] }}</h1>
                    @else
                        <h1 style="font-size:7px; color: #0000FF;">NA</h1>
                    @endif
                </th>
            @endfor
            @for ($i = 1; $i <=6; $i++)
                <th>
                    @if ($data->estandares->a1[($i+24)-1])
                        <h1 style="font-size:9px; color: #0000FF; font-weight: bold;">{{ $data->estandares->a1[($i+24)-1] }}</h1>
                    @else
                        <h1 style="font-size:7px; color: #0000FF;">NA</h1>
                    @endif
                </th>
            @endfor
            @for ($i = 1; $i <=6; $i++)
                <th>
                    @if ($data->estandares->a1[($i+30)-1])
                        <h1 style="font-size:9px; color: #0000FF; font-weight: bold;">{{ $data->estandares->a1[($i+30)-1] }}</h1>
                    @else
                        <h1 style="font-size:7px; color: #0000FF;">NA</h1>
                    @endif
                </th>
            @endfor
            @for ($i = 1; $i <=6; $i++)
                <th>
                    @if ($data->estandares->a1[($i+36)-1])
                        <h1 style="font-size:9px; color: #0000FF; font-weight: bold;">{{ $data->estandares->a1[($i+36)-1] }}</h1>
                    @else
                        <h1 style="font-size:7px; color: #0000FF;">NA</h1>
                    @endif
                </th>
            @endfor
            @for ($i = 1; $i <=6; $i++)
                <th>
                    @if ($data->estandares->a1[($i+42)-1])
                        <h1 style="font-size:9px; color: #0000FF; font-weight: bold;">{{ $data->estandares->a1[($i+42)-1] }}</h1>
                    @else
                        <h1 style="font-size:7px; color: #0000FF;">NA</h1>
                    @endif
                </th>
            @endfor

        </tr>


        <tr>

            <th scope="col" style="font-size:9px; width:140px;">Calidad de la impresión del texto</th>

            @for ($i = 1; $i <=6; $i++)
                <th>
                    @if ($data->estandares->a2[($i)-1])
                    <h1 style="font-size:9px; color: #0000FF; font-weight: bold;">{{$data->estandares->a2[($i)-1]}}</h1>
                    @else
                    <h1 style="font-size:7px; color: #0000FF;">NA</h1>
                    @endif
                </th>
            @endfor

            @for ($i = 1; $i <=6; $i++)
                <th>
                    @if ($data->estandares->a2[($i+6)-1])
                    <h1 style="font-size:9px; color: #0000FF; font-weight: bold;"> {{ $data->estandares->a2[($i+6)-1] }} </h1>
                    @else
                    <h1 style="font-size:7px; color: #0000FF;">NA</h1>
                    @endif
                </th>
            @endfor
            @for ($i = 1; $i <=6; $i++)
                <th>
                    @if ($data->estandares->a2[($i+12)-1])
                    <h1 style="font-size:9px; color: #0000FF; font-weight: bold;"> {{ $data->estandares->a2[($i+12)-1] }} </h1>
                    @else
                    <h1 style="font-size:7px; color: #0000FF;">NA</h1>
                    @endif
                </th>
            @endfor
            @for ($i = 1; $i <=6; $i++)
                <th>
                    @if ($data->estandares->a2[($i+18)-1])
                    <h1 style="font-size:9px; color: #0000FF; font-weight: bold;"> {{ $data->estandares->a2[($i+18)-1] }} </h1>
                    @else
                    <h1 style="font-size:7px; color: #0000FF;">NA</h1>
                    @endif
                </th>
            @endfor
            @for ($i = 1; $i <=6; $i++)
                <th>
                    @if ($data->estandares->a2[($i+24)-1])
                    <h1 style="font-size:9px; color: #0000FF; font-weight: bold;"> {{ $data->estandares->a2[($i+24)-1] }} </h1>
                    @else
                    <h1 style="font-size:7px; color: #0000FF;">NA</h1>
                    @endif
                </th>
            @endfor
            @for ($i = 1; $i <=6; $i++)
                <th>
                    @if ($data->estandares->a2[($i+30)-1])
                    <h1 style="font-size:9px; color: #0000FF; font-weight: bold;"> {{ $data->estandares->a2[($i+30)-1] }} </h1>
                    @else
                    <h1 style="font-size:7px; color: #0000FF;">NA</h1>
                    @endif
                </th>
            @endfor
            @for ($i = 1; $i <=6; $i++)
                <th>
                    @if ($data->estandares->a2[($i+36)-1])
                    <h1 style="font-size:9px; color: #0000FF; font-weight: bold;"> {{ $data->estandares->a2[($i+36)-1] }} </h1>
                    @else
                    <h1 style="font-size:7px; color: #0000FF;">NA</h1>
                    @endif
                </th>
            @endfor
            @for ($i = 1; $i <=6; $i++)
                <th>
                    @if ($data->estandares->a2[($i+42)-1])
                    <h1 style="font-size:9px; color: #0000FF; font-weight: bold;"> {{ $data->estandares->a2[($i+42)-1] }} </h1>
                    @else
                    <h1 style="font-size:7px; color: #0000FF;">NA</h1>
                    @endif
                </th>
            @endfor

        </tr>

        <tr>

<th scope="col" style="font-size:9px; width:140px;">Impresión Lote y venoe/corte/Orientación</th>

@for ($i = 1; $i <=6; $i++)
    <th>
        @if ($data->estandares->a3[($i)-1])
        <h1 style="font-size:9px; color: #0000FF; font-weight: bold;"> {{ $data->estandares->a3[($i)-1] }} </h1>
        @else
        <h1 style="font-size:7px; color: #0000FF;">NA</h1>
        @endif
    </th>
@endfor

@for ($i = 1; $i <=6; $i++)
    <th>
        @if ($data->estandares->a3[($i+6)-1])
        <h1 style="font-size:9px; color: #0000FF; font-weight: bold;"> {{ $data->estandares->a3[($i+6)-1] }} </h1>
        @else
        <h1 style="font-size:7px; color: #0000FF;">NA</h1>
        @endif
    </th>
@endfor
@for ($i = 1; $i <=6; $i++)
    <th>
        @if ($data->estandares->a3[($i+12)-1])
        <h1 style="font-size:9px; color: #0000FF; font-weight: bold;"> {{ $data->estandares->a3[($i+12)-1] }} </h1>
        @else
        <h1 style="font-size:7px; color: #0000FF;">NA</h1>
        @endif
    </th>
@endfor
@for ($i = 1; $i <=6; $i++)
    <th>
        @if ($data->estandares->a3[($i+18)-1])
        <h1 style="font-size:9px; color: #0000FF; font-weight: bold;"> {{ $data->estandares->a3[($i+18)-1] }} </h1>
        @else
        <h1 style="font-size:7px; color: #0000FF;">NA</h1>
        @endif
    </th>
@endfor
@for ($i = 1; $i <=6; $i++)
    <th>
        @if ($data->estandares->a3[($i+24)-1])
        <h1 style="font-size:9px; color: #0000FF; font-weight: bold;"> {{ $data->estandares->a3[($i+24)-1] }} </h1>
        @else
        <h1 style="font-size:7px; color: #0000FF;">NA</h1>
        @endif
    </th>
@endfor
@for ($i = 1; $i <=6; $i++)
    <th>
        @if ($data->estandares->a3[($i+30)-1])
        <h1 style="font-size:9px; color: #0000FF; font-weight: bold;"> {{ $data->estandares->a3[($i+30)-1] }} </h1>
        @else
        <h1 style="font-size:7px; color: #0000FF;">NA</h1>
        @endif
    </th>
@endfor
@for ($i = 1; $i <=6; $i++)
    <th>
        @if ($data->estandares->a3[($i+36)-1])
        <h1 style="font-size:9px; color: #0000FF; font-weight: bold;"> {{ $data->estandares->a3[($i+36)-1] }} </h1>
        @else
        <h1 style="font-size:7px; color: #0000FF;">NA</h1>
        @endif
    </th>
@endfor
@for ($i = 1; $i <=6; $i++)
    <th>
        @if ($data->estandares->a3[($i+42)-1])
        <h1 style="font-size:9px; color: #0000FF; font-weight: bold;"> {{ $data->estandares->a3[($i+42)-1] }} </h1>
        @else
        <h1 style="font-size:7px; color: #0000FF;">NA</h1>
        @endif
    </th>
@endfor

</tr>

<tr>

        <th scope="col" style="font-size:9px; width:140px;">Polvo en el empaque proveniente del ambiente</th>

        @for ($i = 1; $i <=6; $i++)
            <th>
                @if ($data->estandares->a4[($i)-1])
                <h1 style="font-size:9px; color: #0000FF; font-weight: bold;">  {{ $data->estandares->a4[($i)-1]}}</h1>
                @else
                <h1 style="font-size:7px; color: #0000FF;">NA</h1>
                 @endif
            </th>
        @endfor

        @for ($i = 1; $i <=6; $i++)
            <th>
                @if ($data->estandares->a4[($i+6)-1])
                <h1 style="font-size:9px; color: #0000FF; font-weight: bold;"> {{ $data->estandares->a4[($i+6)-1] }} </h1>
                @else
                <h1 style="font-size:7px; color: #0000FF;">NA</h1>
                 @endif
            </th>
        @endfor
        @for ($i = 1; $i <=6; $i++)
            <th>
                @if ($data->estandares->a4[($i+12)-1])
                <h1 style="font-size:9px; color: #0000FF; font-weight: bold;"> {{$data->estandares->a4[($i+12)-1]}} </h1>
                @else
                <h1 style="font-size:7px; color: #0000FF;">NA</h1>
                 @endif
            </th>
        @endfor
        @for ($i = 1; $i <=6; $i++)
            <th>
                @if ($data->estandares->a4[($i+18)-1])
                <h1 style="font-size:9px; color: #0000FF; font-weight: bold;"> {{$data->estandares->a4[($i+18)-1]}} </h1>
                @else
                <h1 style="font-size:7px; color: #0000FF;">NA</h1>
                 @endif
            </th>
        @endfor
        @for ($i = 1; $i <=6; $i++)
            <th>
                @if ($data->estandares->a4[($i+24)-1])
                <h1 style="font-size:9px; color: #0000FF; font-weight: bold;"> {{$data->estandares->a4[($i+24)-1]}} </h1>
                @else
                <h1 style="font-size:7px; color: #0000FF;">NA</h1>
                 @endif
            </th>
        @endfor
        @for ($i = 1; $i <=6; $i++)
            <th>
                @if ($data->estandares->a4[($i+30)-1])
                <h1 style="font-size:9px; color: #0000FF; font-weight: bold;"> {{$data->estandares->a4[($i+30)-1]}} </h1>
                @else
                <h1 style="font-size:7px; color: #0000FF;">NA</h1>
                 @endif
            </th>
        @endfor
        @for ($i = 1; $i <=6; $i++)
            <th>
                @if ($data->estandares->a4[($i+36)-1])
                <h1 style="font-size:9px; color: #0000FF; font-weight: bold;"> {{$data->estandares->a4[($i+36)-1]}} </h1>
                @else
                <h1 style="font-size:7px; color: #0000FF;">NA</h1>
                 @endif
            </th>
        @endfor
        @for ($i = 1; $i <=6; $i++)
            <th>
                @if ($data->estandares->a4[($i+42)-1])
                <h1 style="font-size:9px; color: #0000FF; font-weight: bold;"> {{$data->estandares->a4[($i+42)-1]}} </h1>
                @else
                <h1 style="font-size:7px; color: #0000FF;">NA</h1>
                 @endif
            </th>
        @endfor

</tr>

<tr>

        <th scope="col" style="font-size:9px; width:140px;">Manchado de producto. grasa o cualquier suciedad</th>

        @for ($i = 1; $i <=6; $i++)
            <th>
                @if ($data->estandares->a5[($i)-1])
                <h1 style="font-size:9px; color: #0000FF; font-weight: bold;"> {{ $data->estandares->a5[($i)-1] }} </h1>
                @else
                <h1 style="font-size:7px; color: #0000FF;">NA</h1>
                 @endif
            </th>
        @endfor

        @for ($i = 1; $i <=6; $i++)
            <th>
                @if ($data->estandares->a5[($i+6)-1])
                <h1 style="font-size:9px; color: #0000FF; font-weight: bold;"> {{$data->estandares->a5[($i+6)-1]}} </h1>
                @else
                <h1 style="font-size:7px; color: #0000FF;">NA</h1>
                 @endif
            </th>
        @endfor
        @for ($i = 1; $i <=6; $i++)
            <th>
                @if ($data->estandares->a5[($i+12)-1])
                <h1 style="font-size:9px; color: #0000FF; font-weight: bold;"> {{ $data->estandares->a5[($i+12)-1] }} </h1>
                @else
                <h1 style="font-size:7px; color: #0000FF;">NA</h1>
                 @endif
            </th>
        @endfor
        @for ($i = 1; $i <=6; $i++)
            <th>
                @if ($data->estandares->a5[($i+18)-1])
                <h1 style="font-size:9px; color: #0000FF; font-weight: bold;"> {{ $data->estandares->a5[($i+18)-1] }} </h1>
                @else
                <h1 style="font-size:7px; color: #0000FF;">NA</h1>
                 @endif
            </th>
        @endfor
        @for ($i = 1; $i <=6; $i++)
            <th>
                @if ($data->estandares->a5[($i+24)-1])
                <h1 style="font-size:9px; color: #0000FF; font-weight: bold;"> {{ $data->estandares->a5[($i+24)-1] }} </h1>
                @else
                <h1 style="font-size:7px; color: #0000FF;">NA</h1>
                 @endif
            </th>
        @endfor
        @for ($i = 1; $i <=6; $i++)
            <th>
                @if ($data->estandares->a5[($i+30)-1])
                <h1 style="font-size:9px; color: #0000FF; font-weight: bold;"> {{ $data->estandares->a5[($i+30)-1] }} </h1>
                @else
                <h1 style="font-size:7px; color: #0000FF;">NA</h1>
                 @endif
            </th>
        @endfor
        @for ($i = 1; $i <=6; $i++)
            <th>
                @if ($data->estandares->a5[($i+36)-1])
                <h1 style="font-size:9px; color: #0000FF; font-weight: bold;"> {{ $data->estandares->a5[($i+36)-1] }} </h1>
                @else
                <h1 style="font-size:7px; color: #0000FF;">NA</h1>
                 @endif
            </th>
        @endfor
        @for ($i = 1; $i <=6; $i++)
            <th>
                @if ($data->estandares->a5[($i+42)-1])
                <h1 style="font-size:9px; color: #0000FF; font-weight: bold;"> {{ $data->estandares->a5[($i+42)-1] }} </h1>
                @else
                <h1 style="font-size:7px; color: #0000FF;">NA</h1>
                 @endif
            </th>
        @endfor

</tr>

<tr>

        <th scope="col" style="font-size:9px; width:140px;">Producto obviamente bajo de peso</th>

        @for ($i = 1; $i <=6; $i++)
            <th>
                @if ($data->estandares->a6[($i)-1])
                <h1 style="font-size:9px; color: #0000FF; font-weight: bold;"> {{ $data->estandares->a6[($i)-1] }} </h1>
                @else
                <h1 style="font-size:7px; color: #0000FF;">NA</h1>
                 @endif
            </th>
        @endfor

        @for ($i = 1; $i <=6; $i++)
            <th>
                @if ($data->estandares->a6[($i+6)-1])
                <h1 style="font-size:9px; color: #0000FF; font-weight: bold;"> {{$data->estandares->a6[($i+6)-1]}} </h1>
                @else
                <h1 style="font-size:7px; color: #0000FF;">NA</h1>
                 @endif
            </th>
        @endfor
        @for ($i = 1; $i <=6; $i++)
            <th>
                @if ($data->estandares->a6[($i+12)-1])
                <h1 style="font-size:9px; color: #0000FF; font-weight: bold;"> {{ $data->estandares->a6[($i+12)-1] }} </h1>
                @else
                <h1 style="font-size:7px; color: #0000FF;">NA</h1>
                 @endif
            </th>
        @endfor
        @for ($i = 1; $i <=6; $i++)
            <th>
                @if ($data->estandares->a6[($i+18)-1])
                <h1 style="font-size:9px; color: #0000FF; font-weight: bold;"> {{ $data->estandares->a6[($i+18)-1] }} </h1>
                @else
                <h1 style="font-size:7px; color: #0000FF;">NA</h1>
                 @endif
            </th>
        @endfor
        @for ($i = 1; $i <=6; $i++)
            <th>
                @if ($data->estandares->a6[($i+24)-1])
                <h1 style="font-size:9px; color: #0000FF; font-weight: bold;"> {{ $data->estandares->a6[($i+24)-1] }} </h1>
                @else
                <h1 style="font-size:7px; color: #0000FF;">NA</h1>
                 @endif
            </th>
        @endfor
        @for ($i = 1; $i <=6; $i++)
            <th>
                @if ($data->estandares->a6[($i+30)-1])
                <h1 style="font-size:9px; color: #0000FF; font-weight: bold;"> {{ $data->estandares->a6[($i+30)-1] }} </h1>
                @else
                <h1 style="font-size:7px; color: #0000FF;">NA</h1>
                 @endif
            </th>
        @endfor
        @for ($i = 1; $i <=6; $i++)
            <th>
                @if ($data->estandares->a6[($i+36)-1])
                <h1 style="font-size:9px; color: #0000FF; font-weight: bold;"> {{ $data->estandares->a6[($i+36)-1] }} </h1>
                @else
                <h1 style="font-size:7px; color: #0000FF;">NA</h1>
                 @endif
            </th>
        @endfor
        @for ($i = 1; $i <=6; $i++)
            <th>
                @if ($data->estandares->a6[($i+42)-1])
                <h1 style="font-size:9px; color: #0000FF; font-weight: bold;"> {{ $data->estandares->a6[($i+42)-1] }} </h1>
                @else
                <h1 style="font-size:7px; color: #0000FF;">NA</h1>
                 @endif
            </th>
        @endfor

</tr>

<tr>

        <th scope="col" style="font-size:9px; width:140px;">Cualquier componente del producto no corresponde con el estándar</th>

        @for ($i = 1; $i <=6; $i++)
            <th>
                @if ($data->estandares->a7[($i)-1])
                <h1 style="font-size:9px; color: #0000FF; font-weight: bold;"> {{ $data->estandares->a7[($i)-1] }} </h1>
                @else
                <h1 style="font-size:7px; color: #0000FF;">NA</h1>
                 @endif
            </th>
        @endfor

        @for ($i = 1; $i <=6; $i++)
            <th>
                @if ($data->estandares->a7[($i+6)-1])
                <h1 style="font-size:9px; color: #0000FF; font-weight: bold;"> {{ $data->estandares->a7[($i+6)-1] }} </h1>
                @else
                <h1 style="font-size:7px; color: #0000FF;">NA</h1>
                 @endif
            </th>
        @endfor
        @for ($i = 1; $i <=6; $i++)
            <th>
                @if ($data->estandares->a7[($i+12)-1])
                <h1 style="font-size:9px; color: #0000FF; font-weight: bold;"> {{ $data->estandares->a7[($i+12)-1] }} </h1>
                @else
                <h1 style="font-size:7px; color: #0000FF;">NA</h1>
                 @endif
            </th>
        @endfor
        @for ($i = 1; $i <=6; $i++)
            <th>
                @if ($data->estandares->a7[($i+18)-1])
                <h1 style="font-size:9px; color: #0000FF; font-weight: bold;"> {{ $data->estandares->a7[($i+18)-1] }} </h1>
                @else
                <h1 style="font-size:7px; color: #0000FF;">NA</h1>
                 @endif
            </th>
        @endfor
        @for ($i = 1; $i <=6; $i++)
            <th>
                @if ($data->estandares->a7[($i+24)-1])
                <h1 style="font-size:9px; color: #0000FF; font-weight: bold;"> {{ $data->estandares->a7[($i+24)-1] }} </h1>
                @else
                <h1 style="font-size:7px; color: #0000FF;">NA</h1>
                 @endif
            </th>
        @endfor
        @for ($i = 1; $i <=6; $i++)
            <th>
                @if ($data->estandares->a7[($i+30)-1])
                <h1 style="font-size:9px; color: #0000FF; font-weight: bold;"> {{ $data->estandares->a7[($i+30)-1] }} </h1>
                @else
                <h1 style="font-size:7px; color: #0000FF;">NA</h1>
                 @endif
            </th>
        @endfor
        @for ($i = 1; $i <=6; $i++)
            <th>
                @if ($data->estandares->a7[($i+36)-1])
                <h1 style="font-size:9px; color: #0000FF; font-weight: bold;"> {{ $data->estandares->a7[($i+36)-1] }} </h1>
                @else
                <h1 style="font-size:7px; color: #0000FF;">NA</h1>
                 @endif
            </th>
        @endfor
        @for ($i = 1; $i <=6; $i++)
            <th>
                @if ($data->estandares->a7[($i+42)-1])
                <h1 style="font-size:9px; color: #0000FF; font-weight: bold;"> {{ $data->estandares->a7[($i+42)-1] }} </h1>
                @else
                <h1 style="font-size:7px; color: #0000FF;">NA</h1>
                 @endif
            </th>
        @endfor

</tr>

<tr>

        <th scope="col" style="font-size:9px; width:140px;">Delaminación</th>

        @for ($i = 1; $i <=6; $i++)
            <th>
                @if ($data->estandares->a8[($i)-1])
                <h1 style="font-size:9px; color: #0000FF; font-weight: bold;"> {{ $data->estandares->a8[($i)-1] }} </h1>
                @else
                <h1 style="font-size:7px; color: #0000FF;">NA</h1>
                 @endif
            </th>
        @endfor

        @for ($i = 1; $i <=6; $i++)
            <th>
                @if ($data->estandares->a8[($i+6)-1])
                <h1 style="font-size:9px; color: #0000FF; font-weight: bold;"> {{ $data->estandares->a8[($i+6)-1] }} </h1>
                @else
                <h1 style="font-size:7px; color: #0000FF;">NA</h1>
                 @endif
            </th>
        @endfor
        @for ($i = 1; $i <=6; $i++)
            <th>
                @if ($data->estandares->a8[($i+18)-1])
                <h1 style="font-size:9px; color: #0000FF; font-weight: bold;"> {{ $data->estandares->a8[($i+18)-1] }} </h1>
                @else
                <h1 style="font-size:7px; color: #0000FF;">NA</h1>
                 @endif
            </th>
        @endfor
        @for ($i = 1; $i <=6; $i++)
            <th>
                @if ($data->estandares->a8[($i+18)-1])
                <h1 style="font-size:9px; color: #0000FF; font-weight: bold;"> {{ $data->estandares->a8[($i+18)-1] }} </h1>
                @else
                <h1 style="font-size:7px; color: #0000FF;">NA</h1>
                 @endif
            </th>
        @endfor
        @for ($i = 1; $i <=6; $i++)
            <th>
                @if ($data->estandares->a8[($i+24)-1])
                <h1 style="font-size:9px; color: #0000FF; font-weight: bold;"> {{ $data->estandares->a8[($i+24)-1] }} </h1>
                @else
                <h1 style="font-size:7px; color: #0000FF;">NA</h1>
                 @endif
            </th>
        @endfor
        @for ($i = 1; $i <=6; $i++)
            <th>
                @if ($data->estandares->a8[($i+30)-1])
                <h1 style="font-size:9px; color: #0000FF; font-weight: bold;"> {{ $data->estandares->a8[($i+30)-1] }} </h1>
                @else
                <h1 style="font-size:7px; color: #0000FF;">NA</h1>
                 @endif
            </th>
        @endfor
        @for ($i = 1; $i <=6; $i++)
            <th>
                @if ($data->estandares->a8[($i+36)-1])
                <h1 style="font-size:9px; color: #0000FF; font-weight: bold;"> {{ $data->estandares->a8[($i+36)-1] }} </h1>
                @else
                <h1 style="font-size:7px; color: #0000FF;">NA</h1>
                 @endif
            </th>
        @endfor
        @for ($i = 1; $i <=6; $i++)
            <th>
                @if ($data->estandares->a8[($i+42)-1])
                <h1 style="font-size:9px; color: #0000FF; font-weight: bold;"> {{ $data->estandares->a8[($i+42)-1] }} </h1>
                @else
                <h1 style="font-size:7px; color: #0000FF;">NA</h1>
                 @endif
            </th>
        @endfor

</tr>

<tr>

        <th scope="col" style="font-size:9px; width:140px;">Sello alineado</th>

        @for ($i = 1; $i <=6; $i++)
            <th>
                @if ($data->estandares->a9[($i)-1])
                <h1 style="font-size:9px; color: #0000FF; font-weight: bold;"> {{ $data->estandares->a9[($i)-1] }} </h1>
                @else
                <h1 style="font-size:7px; color: #0000FF;">NA</h1>
                 @endif
            </th>
        @endfor

        @for ($i = 1; $i <=6; $i++)
            <th>
                @if ($data->estandares->a9[($i+6)-1])
                <h1 style="font-size:9px; color: #0000FF; font-weight: bold;"> {{ $data->estandares->a9[($i+6)-1] }} </h1>
                @else
                <h1 style="font-size:7px; color: #0000FF;">NA</h1>
                 @endif
            </th>
        @endfor
        @for ($i = 1; $i <=6; $i++)
            <th>
                @if ($data->estandares->a9[($i+12)-1])
                <h1 style="font-size:9px; color: #0000FF; font-weight: bold;"> {{ $data->estandares->a9[($i+12)-1] }} </h1>
                @else
                <h1 style="font-size:7px; color: #0000FF;">NA</h1>
                 @endif
            </th>
        @endfor
        @for ($i = 1; $i <=6; $i++)
            <th>
                @if ($data->estandares->a9[($i+18)-1])
                <h1 style="font-size:9px; color: #0000FF; font-weight: bold;"> {{ $data->estandares->a9[($i+18)-1] }} </h1>
                @else
                <h1 style="font-size:7px; color: #0000FF;">NA</h1>
                 @endif
            </th>
        @endfor
        @for ($i = 1; $i <=6; $i++)
            <th>
                @if ($data->estandares->a9[($i+24)-1])
                <h1 style="font-size:9px; color: #0000FF; font-weight: bold;"> {{ $data->estandares->a9[($i+24)-1] }} </h1>
                @else
                <h1 style="font-size:7px; color: #0000FF;">NA</h1>
                 @endif
            </th>
        @endfor
        @for ($i = 1; $i <=6; $i++)
            <th>
                @if ($data->estandares->a9[($i+30)-1])
                <h1 style="font-size:9px; color: #0000FF; font-weight: bold;"> {{ $data->estandares->a9[($i+30)-1] }} </h1>
                @else
                <h1 style="font-size:7px; color: #0000FF;">NA</h1>
                 @endif
            </th>
        @endfor
        @for ($i = 1; $i <=6; $i++)
            <th>
                @if ($data->estandares->a9[($i+36)-1])
                <h1 style="font-size:9px; color: #0000FF; font-weight: bold;"> {{ $data->estandares->a9[($i+36)-1] }} </h1>
                @else
                <h1 style="font-size:7px; color: #0000FF;">NA</h1>
                 @endif
            </th>
        @endfor
        @for ($i = 1; $i <=6; $i++)
            <th>
                @if ($data->estandares->a9[($i+42)-1])
                <h1 style="font-size:9px; color: #0000FF; font-weight: bold;"> {{ $data->estandares->a9[($i+42)-1] }} </h1>
                @else
                <h1 style="font-size:7px; color: #0000FF;">NA</h1>
                 @endif
            </th>
        @endfor

</tr>

<tr>

        <th scope="col" style="font-size:9px; width:140px;">Sello quemado</th>

        @for ($i = 1; $i <=6; $i++)
            <th>
                @if ($data->estandares->a10[($i)-1])
                <h1 style="font-size:9px; color: #0000FF; font-weight: bold;"> {{ $data->estandares->a10[($i)-1] }} </h1>
                @else
                <h1 style="font-size:7px; color: #0000FF;">NA</h1>
                 @endif
            </th>
        @endfor

        @for ($i = 1; $i <=6; $i++)
            <th>
                @if ($data->estandares->a10[($i+6)-1])
                <h1 style="font-size:9px; color: #0000FF; font-weight: bold;"> {{ $data->estandares->a10[($i+6)-1] }} </h1>
                @else
                <h1 style="font-size:7px; color: #0000FF;">NA</h1>
                 @endif
            </th>
        @endfor
        @for ($i = 1; $i <=6; $i++)
            <th>
                @if ($data->estandares->a10[($i+12)-1])
                <h1 style="font-size:9px; color: #0000FF; font-weight: bold;"> {{ $data->estandares->a10[($i+12)-1] }} </h1>
                @else
                <h1 style="font-size:7px; color: #0000FF;">NA</h1>
                 @endif
            </th>
        @endfor
        @for ($i = 1; $i <=6; $i++)
            <th>
                @if ($data->estandares->a10[($i+18)-1])
                <h1 style="font-size:9px; color: #0000FF; font-weight: bold;"> {{ $data->estandares->a10[($i+18)-1] }} </h1>
                @else
                <h1 style="font-size:7px; color: #0000FF;">NA</h1>
                 @endif
            </th>
        @endfor
        @for ($i = 1; $i <=6; $i++)
            <th>
                @if ($data->estandares->a10[($i+24)-1])
                <h1 style="font-size:9px; color: #0000FF; font-weight: bold;"> {{ $data->estandares->a10[($i+24)-1] }} </h1>
                @else
                <h1 style="font-size:7px; color: #0000FF;">NA</h1>
                 @endif
            </th>
        @endfor
        @for ($i = 1; $i <=6; $i++)
            <th>
                @if ($data->estandares->a10[($i+30)-1])
                <h1 style="font-size:9px; color: #0000FF; font-weight: bold;"> {{ $data->estandares->a10[($i+30)-1] }} </h1>
                @else
                <h1 style="font-size:7px; color: #0000FF;">NA</h1>
                 @endif
            </th>
        @endfor
        @for ($i = 1; $i <=6; $i++)
            <th>
                @if ($data->estandares->a10[($i+36)-1])
                <h1 style="font-size:9px; color: #0000FF; font-weight: bold;"> {{ $data->estandares->a10[($i+36)-1] }} </h1>
                @else
                <h1 style="font-size:7px; color: #0000FF;">NA</h1>
                 @endif
            </th>
        @endfor
        @for ($i = 1; $i <=6; $i++)
            <th>
                @if ($data->estandares->a10[($i+42)-1])
                <h1 style="font-size:9px; color: #0000FF; font-weight: bold;"> {{ $data->estandares->a10[($i+42)-1] }} </h1>
                @else
                <h1 style="font-size:7px; color: #0000FF;">NA</h1>
                 @endif
            </th>
        @endfor

</tr>

<tr>

        <th scope="col" style="font-size:9px; width:140px;">Sello dañado</th>

        @for ($i = 1; $i <=6; $i++)
            <th>
                @if ($data->estandares->a11[($i)-1])
                <h1 style="font-size:9px; color: #0000FF; font-weight: bold;"> {{ $data->estandares->a11[($i)-1] }} </h1>
                @else
                <h1 style="font-size:7px; color: #0000FF;">NA</h1>
                 @endif
            </th>
        @endfor

        @for ($i = 1; $i <=6; $i++)
            <th>
                @if ($data->estandares->a11[($i+6)-1])
                <h1 style="font-size:9px; color: #0000FF; font-weight: bold;"> {{ $data->estandares->a11[($i+6)-1] }} </h1>
                @else
                <h1 style="font-size:7px; color: #0000FF;">NA</h1>
                 @endif
            </th>
        @endfor
        @for ($i = 1; $i <=6; $i++)
            <th>
                @if ($data->estandares->a11[($i+12)-1])
                <h1 style="font-size:9px; color: #0000FF; font-weight: bold;"> {{ $data->estandares->a11[($i+12)-1] }} </h1>
                @else
                <h1 style="font-size:7px; color: #0000FF;">NA</h1>
                 @endif
            </th>
        @endfor
        @for ($i = 1; $i <=6; $i++)
            <th>
                @if ($data->estandares->a11[($i+18)-1])
                <h1 style="font-size:9px; color: #0000FF; font-weight: bold;"> {{ $data->estandares->a11[($i+18)-1] }} </h1>
                @else
                <h1 style="font-size:7px; color: #0000FF;">NA</h1>
                 @endif
            </th>
        @endfor
        @for ($i = 1; $i <=6; $i++)
            <th>
                @if ($data->estandares->a11[($i+24)-1])
                <h1 style="font-size:9px; color: #0000FF; font-weight: bold;"> {{ $data->estandares->a11[($i+24)-1] }} </h1>
                @else
                <h1 style="font-size:7px; color: #0000FF;">NA</h1>
                 @endif
            </th>
        @endfor
        @for ($i = 1; $i <=6; $i++)
            <th>
                @if ($data->estandares->a11[($i+30)-1])
                <h1 style="font-size:9px; color: #0000FF; font-weight: bold;"> {{ $data->estandares->a11[($i+30)-1] }} </h1>
                @else
                <h1 style="font-size:7px; color: #0000FF;">NA</h1>
                 @endif
            </th>
        @endfor
        @for ($i = 1; $i <=6; $i++)
            <th>
                @if ($data->estandares->a11[($i+36)-1])
                <h1 style="font-size:9px; color: #0000FF; font-weight: bold;"> {{ $data->estandares->a11[($i+36)-1] }} </h1>
                @else
                <h1 style="font-size:7px; color: #0000FF;">NA</h1>
                 @endif
            </th>
        @endfor
        @for ($i = 1; $i <=6; $i++)
            <th>
                @if ($data->estandares->a11[($i+42)-1])
                <h1 style="font-size:9px; color: #0000FF; font-weight: bold;"> {{ $data->estandares->a11[($i+42)-1] }} </h1>
                @else
                <h1 style="font-size:7px; color: #0000FF;">NA</h1>
                 @endif
            </th>
        @endfor

</tr>

<tr>

        <th scope="col" style="font-size:9px; width:140px;">Mal sellado</th>

        @for ($i = 1; $i <=6; $i++)
            <th>
                @if ($data->estandares->a12[($i)-1])
                <h1 style="font-size:9px; color: #0000FF; font-weight: bold;"> {{ $data->estandares->a12[($i)-1] }} </h1>
                @else
                <h1 style="font-size:7px; color: #0000FF;">NA</h1>
                 @endif
            </th>
        @endfor

        @for ($i = 1; $i <=6; $i++)
            <th>
                @if ($data->estandares->a12[($i+6)-1])
                <h1 style="font-size:9px; color: #0000FF; font-weight: bold;"> {{ $data->estandares->a12[($i+6)-1] }} </h1>
                @else
                <h1 style="font-size:7px; color: #0000FF;">NA</h1>
                 @endif
            </th>
        @endfor
        @for ($i = 1; $i <=6; $i++)
            <th>
                @if ($data->estandares->a12[($i+12)-1])
                <h1 style="font-size:9px; color: #0000FF; font-weight: bold;"> {{ $data->estandares->a12[($i+12)-1] }} </h1>
                @else
                <h1 style="font-size:7px; color: #0000FF;">NA</h1>
                 @endif
            </th>
        @endfor
        @for ($i = 1; $i <=6; $i++)
            <th>
                @if ($data->estandares->a12[($i+18)-1])
                <h1 style="font-size:9px; color: #0000FF; font-weight: bold;"> {{ $data->estandares->a12[($i+18)-1] }} </h1>
                @else
                <h1 style="font-size:7px; color: #0000FF;">NA</h1>
                 @endif
            </th>
        @endfor
        @for ($i = 1; $i <=6; $i++)
            <th>
                @if ($data->estandares->a12[($i+24)-1])
                <h1 style="font-size:9px; color: #0000FF; font-weight: bold;"> {{ $data->estandares->a12[($i+24)-1] }} </h1>
                @else
                <h1 style="font-size:7px; color: #0000FF;">NA</h1>
                 @endif
            </th>
        @endfor
        @for ($i = 1; $i <=6; $i++)
            <th>
                @if ($data->estandares->a12[($i+30)-1])
                <h1 style="font-size:9px; color: #0000FF; font-weight: bold;"> {{ $data->estandares->a12[($i+30)-1] }} </h1>
                @else
                <h1 style="font-size:7px; color: #0000FF;">NA</h1>
                 @endif
            </th>
        @endfor
        @for ($i = 1; $i <=6; $i++)
            <th>
                @if ($data->estandares->a12[($i+36)-1])
                <h1 style="font-size:9px; color: #0000FF; font-weight: bold;"> {{ $data->estandares->a12[($i+36)-1] }} </h1>
                @else
                <h1 style="font-size:7px; color: #0000FF;">NA</h1>
                 @endif
            </th>
        @endfor
        @for ($i = 1; $i <=6; $i++)
            <th>
                @if ($data->estandares->a12[($i+42)-1])
                <h1 style="font-size:9px; color: #0000FF; font-weight: bold;"> {{ $data->estandares->a12[($i+42)-1] }} </h1>
                @else
                <h1 style="font-size:7px; color: #0000FF;">NA</h1>
                 @endif
            </th>
        @endfor

</tr>

<tr>

        <th scope="col" style="font-size:9px; width:140px;">Empaque sin producto</th>

        @for ($i = 1; $i <=6; $i++)
            <th>
                @if ($data->estandares->a13[($i)-1])
                <h1 style="font-size:9px; color: #0000FF; font-weight: bold;"> {{ $data->estandares->a13[($i)-1] }} </h1>
                @else
                <h1 style="font-size:7px; color: #0000FF;">NA</h1>
                 @endif
            </th>
        @endfor

        @for ($i = 1; $i <=6; $i++)
            <th>
                @if ($data->estandares->a13[($i+6)-1])
                <h1 style="font-size:9px; color: #0000FF; font-weight: bold;"> {{ $data->estandares->a13[($i+6)-1] }} </h1>
                @else
                <h1 style="font-size:7px; color: #0000FF;">NA</h1>
                 @endif
            </th>
        @endfor
        @for ($i = 1; $i <=6; $i++)
            <th>
                @if ($data->estandares->a13[($i+12)-1])
                <h1 style="font-size:9px; color: #0000FF; font-weight: bold;"> {{ $data->estandares->a13[($i+12)-1] }} </h1>
                @else
                <h1 style="font-size:7px; color: #0000FF;">NA</h1>
                 @endif
            </th>
        @endfor
        @for ($i = 1; $i <=6; $i++)
            <th>
                @if ($data->estandares->a13[($i+18)-1])
                <h1 style="font-size:9px; color: #0000FF; font-weight: bold;"> {{ $data->estandares->a13[($i+18)-1] }} </h1>
                @else
                <h1 style="font-size:7px; color: #0000FF;">NA</h1>
                 @endif
            </th>
        @endfor
        @for ($i = 1; $i <=6; $i++)
            <th>
                @if ($data->estandares->a13[($i+24)-1])
                <h1 style="font-size:9px; color: #0000FF; font-weight: bold;"> {{ $data->estandares->a13[($i+24)-1] }} </h1>
                @else
                <h1 style="font-size:7px; color: #0000FF;">NA</h1>
                 @endif
            </th>
        @endfor
        @for ($i = 1; $i <=6; $i++)
            <th>
                @if ($data->estandares->a13[($i+30)-1])
                <h1 style="font-size:9px; color: #0000FF; font-weight: bold;"> {{ $data->estandares->a13[($i+30)-1] }} </h1>
                @else
                <h1 style="font-size:7px; color: #0000FF;">NA</h1>
                 @endif
            </th>
        @endfor
        @for ($i = 1; $i <=6; $i++)
            <th>
                @if ($data->estandares->a13[($i+36)-1])
                <h1 style="font-size:9px; color: #0000FF; font-weight: bold;"> {{ $data->estandares->a13[($i+36)-1] }} </h1>
                @else
                <h1 style="font-size:7px; color: #0000FF;">NA</h1>
                 @endif
            </th>
        @endfor
        @for ($i = 1; $i <=6; $i++)
            <th>
                @if ($data->estandares->a13[($i+42)-1])
                <h1 style="font-size:9px; color: #0000FF; font-weight: bold;"> {{ $data->estandares->a13[($i+42)-1] }} </h1>
                @else
                <h1 style="font-size:7px; color: #0000FF;">NA</h1>
                 @endif
            </th>
        @endfor

</tr>

<tr>

        <th scope="col" style="font-size:9px; width:140px;">Empaque deforme</th>

        @for ($i = 1; $i <=6; $i++)
            <th>
                @if ($data->estandares->a14[($i)-1])
                <h1 style="font-size:9px; color: #0000FF; font-weight: bold;"> {{ $data->estandares->a14[($i)-1] }} </h1>
                @else
                <h1 style="font-size:7px; color: #0000FF;">NA</h1>
                 @endif
            </th>
        @endfor

        @for ($i = 1; $i <=6; $i++)
            <th>
                @if ($data->estandares->a14[($i+6)-1])
                <h1 style="font-size:9px; color: #0000FF; font-weight: bold;"> {{ $data->estandares->a14[($i+6)-1] }} </h1>
                @else
                <h1 style="font-size:7px; color: #0000FF;">NA</h1>
                 @endif
            </th>
        @endfor
        @for ($i = 1; $i <=6; $i++)
            <th>
                @if ($data->estandares->a14[($i+12)-1])
                <h1 style="font-size:9px; color: #0000FF; font-weight: bold;"> {{ $data->estandares->a14[($i+12)-1] }} </h1>
                @else
                <h1 style="font-size:7px; color: #0000FF;">NA</h1>
                 @endif
            </th>
        @endfor
        @for ($i = 1; $i <=6; $i++)
            <th>
                @if ($data->estandares->a14[($i+18)-1])
                <h1 style="font-size:9px; color: #0000FF; font-weight: bold;"> {{ $data->estandares->a14[($i+18)-1] }} </h1>
                @else
                <h1 style="font-size:7px; color: #0000FF;">NA</h1>
                 @endif
            </th>
        @endfor
        @for ($i = 1; $i <=6; $i++)
            <th>
                @if ($data->estandares->a14[($i+24)-1])
                <h1 style="font-size:9px; color: #0000FF; font-weight: bold;"> {{ $data->estandares->a14[($i+24)-1] }} </h1>
                @else
                <h1 style="font-size:7px; color: #0000FF;">NA</h1>
                 @endif
            </th>
        @endfor
        @for ($i = 1; $i <=6; $i++)
            <th>
                @if ($data->estandares->a14[($i+30)-1])
                <h1 style="font-size:9px; color: #0000FF; font-weight: bold;"> {{ $data->estandares->a14[($i+30)-1] }} </h1>
                @else
                <h1 style="font-size:7px; color: #0000FF;">NA</h1>
                 @endif
            </th>
        @endfor
        @for ($i = 1; $i <=6; $i++)
            <th>
                @if ($data->estandares->a14[($i+36)-1])
                <h1 style="font-size:9px; color: #0000FF; font-weight: bold;"> {{ $data->estandares->a14[($i+36)-1] }} </h1>
                @else
                <h1 style="font-size:7px; color: #0000FF;">NA</h1>
                 @endif
            </th>
        @endfor
        @for ($i = 1; $i <=6; $i++)
            <th>
                @if ($data->estandares->a14[($i+42)-1])
                <h1 style="font-size:9px; color: #0000FF; font-weight: bold;"> {{ $data->estandares->a14[($i+42)-1] }} </h1>
                @else
                <h1 style="font-size:7px; color: #0000FF;">NA</h1>
                 @endif
            </th>
        @endfor

</tr>

<tr>

        <th scope="col" style="font-size:9px; width:140px;">Empaque perforado</th>

        @for ($i = 1; $i <=6; $i++)
            <th>
                @if ($data->estandares->a15[($i)-1])
                <h1 style="font-size:9px; color: #0000FF; font-weight: bold;"> {{ $data->estandares->a15[($i)-1] }} </h1>
                @else
                <h1 style="font-size:7px; color: #0000FF;">NA</h1>
                 @endif
            </th>
        @endfor

        @for ($i = 1; $i <=6; $i++)
            <th>
                @if ($data->estandares->a15[($i+6)-1])
                <h1 style="font-size:9px; color: #0000FF; font-weight: bold;"> {{ $data->estandares->a15[($i+6)-1] }} </h1>
                @else
                <h1 style="font-size:7px; color: #0000FF;">NA</h1>
                 @endif
            </th>
        @endfor
        @for ($i = 1; $i <=6; $i++)
            <th>
                @if ($data->estandares->a15[($i+12)-1])
                <h1 style="font-size:9px; color: #0000FF; font-weight: bold;"> {{ $data->estandares->a15[($i+12)-1] }} </h1>
                @else
                <h1 style="font-size:7px; color: #0000FF;">NA</h1>
                 @endif
            </th>
        @endfor
        @for ($i = 1; $i <=6; $i++)
            <th>
                @if ($data->estandares->a15[($i+18)-1])
                <h1 style="font-size:9px; color: #0000FF; font-weight: bold;"> {{ $data->estandares->a15[($i+18)-1] }} </h1>
                @else
                <h1 style="font-size:7px; color: #0000FF;">NA</h1>
                 @endif
            </th>
        @endfor
        @for ($i = 1; $i <=6; $i++)
            <th>
                @if ($data->estandares->a15[($i+24)-1])
                <h1 style="font-size:9px; color: #0000FF; font-weight: bold;"> {{ $data->estandares->a15[($i+24)-1] }} </h1>
                @else
                <h1 style="font-size:7px; color: #0000FF;">NA</h1>
                 @endif
            </th>
        @endfor
        @for ($i = 1; $i <=6; $i++)
            <th>
                @if ($data->estandares->a15[($i+30)-1])
                <h1 style="font-size:9px; color: #0000FF; font-weight: bold;"> {{ $data->estandares->a15[($i+30)-1] }} </h1>
                @else
                <h1 style="font-size:7px; color: #0000FF;">NA</h1>
                 @endif
            </th>
        @endfor
        @for ($i = 1; $i <=6; $i++)
            <th>
                @if ($data->estandares->a15[($i+36)-1])
                <h1 style="font-size:9px; color: #0000FF; font-weight: bold;"> {{ $data->estandares->a15[($i+36)-1] }} </h1>
                @else
                <h1 style="font-size:7px; color: #0000FF;">NA</h1>
                 @endif
            </th>
        @endfor
        @for ($i = 1; $i <=6; $i++)
            <th>
                @if ($data->estandares->a15[($i+42)-1])
                <h1 style="font-size:9px; color: #0000FF; font-weight: bold;"> {{ $data->estandares->a15[($i+42)-1] }} </h1>
                @else
                <h1 style="font-size:7px; color: #0000FF;">NA</h1>
                 @endif
            </th>
        @endfor

</tr>

<tr>

        <th scope="col" style="font-size:9px; width:140px;">Empaque rasguñado o rayado</th>

        @for ($i = 1; $i <=6; $i++)
            <th>
                @if ($data->estandares->a16[($i)-1])
                <h1 style="font-size:9px; color: #0000FF; font-weight: bold;"> {{ $data->estandares->a16[($i)-1] }} </h1>
                @else
                <h1 style="font-size:7px; color: #0000FF;">NA</h1>
                 @endif
            </th>
        @endfor

        @for ($i = 1; $i <=6; $i++)
            <th>
                @if ($data->estandares->a16[($i+6)-1])
                <h1 style="font-size:9px; color: #0000FF; font-weight: bold;"> {{ $data->estandares->a16[($i+6)-1] }} </h1>
                @else
                <h1 style="font-size:7px; color: #0000FF;">NA</h1>
                 @endif
            </th>
        @endfor
        @for ($i = 1; $i <=6; $i++)
            <th>
                @if ($data->estandares->a16[($i+12)-1])
                <h1 style="font-size:9px; color: #0000FF; font-weight: bold;"> {{ $data->estandares->a16[($i+12)-1] }} </h1>
                @else
                <h1 style="font-size:7px; color: #0000FF;">NA</h1>
                 @endif
            </th>
        @endfor
        @for ($i = 1; $i <=6; $i++)
            <th>
                @if ($data->estandares->a16[($i+18)-1])
                <h1 style="font-size:9px; color: #0000FF; font-weight: bold;"> {{ $data->estandares->a16[($i+18)-1] }} </h1>
                @else
                <h1 style="font-size:7px; color: #0000FF;">NA</h1>
                 @endif
            </th>
        @endfor
        @for ($i = 1; $i <=6; $i++)
            <th>
                @if ($data->estandares->a16[($i+24)-1])
                <h1 style="font-size:9px; color: #0000FF; font-weight: bold;"> {{ $data->estandares->a16[($i+24)-1] }} </h1>
                @else
                <h1 style="font-size:7px; color: #0000FF;">NA</h1>
                 @endif
            </th>
        @endfor
        @for ($i = 1; $i <=6; $i++)
            <th>
                @if ($data->estandares->a16[($i+30)-1])
                <h1 style="font-size:9px; color: #0000FF; font-weight: bold;"> {{ $data->estandares->a16[($i+30)-1] }} </h1>
                @else
                <h1 style="font-size:7px; color: #0000FF;">NA</h1>
                 @endif
            </th>
        @endfor
        @for ($i = 1; $i <=6; $i++)
            <th>
                @if ($data->estandares->a16[($i+36)-1])
                <h1 style="font-size:9px; color: #0000FF; font-weight: bold;"> {{ $data->estandares->a16[($i+36)-1] }} </h1>
                @else
                <h1 style="font-size:7px; color: #0000FF;">NA</h1>
                 @endif
            </th>
        @endfor
        @for ($i = 1; $i <=6; $i++)
            <th>
                @if ($data->estandares->a16[($i+42)-1])
                <h1 style="font-size:9px; color: #0000FF; font-weight: bold;"> {{ $data->estandares->a16[($i+42)-1] }} </h1>
                @else
                <h1 style="font-size:7px; color: #0000FF;">NA</h1>
                 @endif
            </th>
        @endfor

</tr>

<tr>

        <th scope="col" style="font-size:9px; width:140px;">Código de barra o Lote legible, posición incorrecta en sachel o corrugado</th>

        @for ($i = 1; $i <=6; $i++)
            <th>
                @if ($data->estandares->a17[($i)-1])
                <h1 style="font-size:9px; color: #0000FF; font-weight: bold;"> {{ $data->estandares->a17[($i)-1] }} </h1>
                @else
                <h1 style="font-size:7px; color: #0000FF;">NA</h1>
                 @endif
            </th>
        @endfor

        @for ($i = 1; $i <=6; $i++)
            <th>
                @if ($data->estandares->a17[($i+6)-1])
                <h1 style="font-size:9px; color: #0000FF; font-weight: bold;"> {{ $data->estandares->a17[($i+6)-1] }} </h1>
                @else
                <h1 style="font-size:7px; color: #0000FF;">NA</h1>
                 @endif
            </th>
        @endfor
        @for ($i = 1; $i <=6; $i++)
            <th>
                @if ($data->estandares->a17[($i+12)-1])
                <h1 style="font-size:9px; color: #0000FF; font-weight: bold;"> {{ $data->estandares->a17[($i+12)-1] }} </h1>
                @else
                <h1 style="font-size:7px; color: #0000FF;">NA</h1>
                 @endif
            </th>
        @endfor
        @for ($i = 1; $i <=6; $i++)
            <th>
                @if ($data->estandares->a17[($i+18)-1])
                <h1 style="font-size:9px; color: #0000FF; font-weight: bold;"> {{ $data->estandares->a17[($i+18)-1] }} </h1>
                @else
                <h1 style="font-size:7px; color: #0000FF;">NA</h1>
                 @endif
            </th>
        @endfor
        @for ($i = 1; $i <=6; $i++)
            <th>
                @if ($data->estandares->a17[($i+24)-1])
                <h1 style="font-size:9px; color: #0000FF; font-weight: bold;"> {{ $data->estandares->a17[($i+24)-1] }} </h1>
                @else
                <h1 style="font-size:7px; color: #0000FF;">NA</h1>
                 @endif
            </th>
        @endfor
        @for ($i = 1; $i <=6; $i++)
            <th>
                @if ($data->estandares->a17[($i+30)-1])
                <h1 style="font-size:9px; color: #0000FF; font-weight: bold;"> {{ $data->estandares->a17[($i+30)-1] }} </h1>
                @else
                <h1 style="font-size:7px; color: #0000FF;">NA</h1>
                 @endif
            </th>
        @endfor
        @for ($i = 1; $i <=6; $i++)
            <th>
                @if ($data->estandares->a17[($i+36)-1])
                <h1 style="font-size:9px; color: #0000FF; font-weight: bold;"> {{ $data->estandares->a17[($i+36)-1] }} </h1>
                @else
                <h1 style="font-size:7px; color: #0000FF;">NA</h1>
                 @endif
            </th>
        @endfor
        @for ($i = 1; $i <=6; $i++)
            <th>
                @if ($data->estandares->a17[($i+42)-1])
                <h1 style="font-size:9px; color: #0000FF; font-weight: bold;"> {{ $data->estandares->a17[($i+42)-1] }} </h1>
                @else
                <h1 style="font-size:7px; color: #0000FF;">NA</h1>
                 @endif
            </th>
        @endfor

</tr>


<tr>

        <th scope="col" style="font-size:9px; width:140px;">Fuga del producto</th>

        @for ($i = 1; $i <=6; $i++)
            <th>
                @if ($data->estandares->a18[($i)-1])
                <h1 style="font-size:9px; color: #0000FF; font-weight: bold;"> {{ $data->estandares->a18[($i)-1] }} </h1>
                @else
                <h1 style="font-size:7px; color: #0000FF;">NA</h1>
                 @endif
            </th>
        @endfor

        @for ($i = 1; $i <=6; $i++)
            <th>
                @if ($data->estandares->a18[($i+6)-1])
                <h1 style="font-size:9px; color: #0000FF; font-weight: bold;"> {{ $data->estandares->a18[($i+6)-1] }} </h1>
                @else
                <h1 style="font-size:7px; color: #0000FF;">NA</h1>
                 @endif
            </th>
        @endfor
        @for ($i = 1; $i <=6; $i++)
            <th>
                @if ($data->estandares->a18[($i+12)-1])
                <h1 style="font-size:9px; color: #0000FF; font-weight: bold;"> {{ $data->estandares->a18[($i+12)-1] }} </h1>
                @else
                <h1 style="font-size:7px; color: #0000FF;">NA</h1>
                 @endif
            </th>
        @endfor
        @for ($i = 1; $i <=6; $i++)
            <th>
                @if ($data->estandares->a18[($i+18)-1])
                <h1 style="font-size:9px; color: #0000FF; font-weight: bold;"> {{ $data->estandares->a18[($i+18)-1] }} </h1>
                @else
                <h1 style="font-size:7px; color: #0000FF;">NA</h1>
                 @endif
            </th>
        @endfor
        @for ($i = 1; $i <=6; $i++)
            <th>
                @if ($data->estandares->a18[($i+24)-1])
                <h1 style="font-size:9px; color: #0000FF; font-weight: bold;"> {{ $data->estandares->a18[($i+24)-1] }} </h1>
                @else
                <h1 style="font-size:7px; color: #0000FF;">NA</h1>
                 @endif
            </th>
        @endfor
        @for ($i = 1; $i <=6; $i++)
            <th>
                @if ($data->estandares->a18[($i+30)-1])
                <h1 style="font-size:9px; color: #0000FF; font-weight: bold;"> {{ $data->estandares->a18[($i+30)-1] }} </h1>
                @else
                <h1 style="font-size:7px; color: #0000FF;">NA</h1>
                 @endif
            </th>
        @endfor
        @for ($i = 1; $i <=6; $i++)
            <th>
                @if ($data->estandares->a18[($i+36)-1])
                <h1 style="font-size:9px; color: #0000FF; font-weight: bold;"> {{ $data->estandares->a18[($i+36)-1] }} </h1>
                @else
                <h1 style="font-size:7px; color: #0000FF;">NA</h1>
                 @endif
            </th>
        @endfor
        @for ($i = 1; $i <=6; $i++)
            <th>
                @if ($data->estandares->a18[($i+42)-1])
                <h1 style="font-size:9px; color: #0000FF; font-weight: bold;"> {{ $data->estandares->a18[($i+42)-1] }} </h1>
                @else
                <h1 style="font-size:7px; color: #0000FF;">NA</h1>
                 @endif
            </th>
        @endfor

</tr>

<tr>

        <th scope="col" style="font-size:9px; width:140px;">Resultado</th>

        @for ($i = 1; $i <=6; $i++)
            <th>
                @if ($data->estandares->a19[($i)-1])
                <h1 style="font-size:9px; color: #0000FF; font-weight: bold;"> {{ $data->estandares->a19[($i)-1] }} </h1>
                @else
                <h1 style="font-size:7px; color: #0000FF;">NA</h1>
                 @endif
            </th>
        @endfor

        @for ($i = 1; $i <=6; $i++)
            <th>
                @if ($data->estandares->a19[($i+6)-1])
                <h1 style="font-size:9px; color: #0000FF; font-weight: bold;"> {{ $data->estandares->a19[($i+6)-1] }} </h1>
                @else
                <h1 style="font-size:7px; color: #0000FF;">NA</h1>
                 @endif
            </th>
        @endfor
        @for ($i = 1; $i <=6; $i++)
            <th>
                @if ($data->estandares->a19[($i+12)-1])
                <h1 style="font-size:9px; color: #0000FF; font-weight: bold;"> {{ $data->estandares->a19[($i+12)-1] }} </h1>
                @else
                <h1 style="font-size:7px; color: #0000FF;">NA</h1>
                 @endif
            </th>
        @endfor
        @for ($i = 1; $i <=6; $i++)
            <th>
                @if ($data->estandares->a19[($i+18)-1])
                <h1 style="font-size:9px; color: #0000FF; font-weight: bold;"> {{ $data->estandares->a19[($i+18)-1] }} </h1>
                @else
                <h1 style="font-size:7px; color: #0000FF;">NA</h1>
                 @endif
            </th>
        @endfor
        @for ($i = 1; $i <=6; $i++)
            <th>
                @if ($data->estandares->a19[($i+24)-1])
                <h1 style="font-size:9px; color: #0000FF; font-weight: bold;"> {{ $data->estandares->a19[($i+24)-1] }} </h1>
                @else
                <h1 style="font-size:7px; color: #0000FF;">NA</h1>
                 @endif
            </th>
        @endfor
        @for ($i = 1; $i <=6; $i++)
            <th>
                @if ($data->estandares->a19[($i+30)-1])
                <h1 style="font-size:9px; color: #0000FF; font-weight: bold;"> {{ $data->estandares->a19[($i+30)-1] }} </h1>
                @else
                <h1 style="font-size:7px; color: #0000FF;">NA</h1>
                 @endif
            </th>
        @endfor
        @for ($i = 1; $i <=6; $i++)
            <th>
                @if ($data->estandares->a19[($i+36)-1])
                <h1 style="font-size:9px; color: #0000FF; font-weight: bold;"> {{ $data->estandares->a19[($i+36)-1] }} </h1>
                @else
                <h1 style="font-size:7px; color: #0000FF;">NA</h1>
                 @endif
            </th>
        @endfor
        @for ($i = 1; $i <=6; $i++)
            <th>
                @if ($data->estandares->a19[($i+42)-1])
                <h1 style="font-size:9px; color: #0000FF; font-weight: bold;"> {{ $data->estandares->a19[($i+42)-1] }} </h1>
                @else
                <h1 style="font-size:7px; color: #0000FF;">NA</h1>
                 @endif
            </th>
        @endfor

</tr>


        <tr>

            <th style="font-size:9px; width:140px;">REALIZÓ</th>

            @for ($i = 1; $i <=8; $i++)
                <th style="text-align:center; color: #0000FF; font-weight: bold;"  colspan="6">
                {{$data->estandares->realizo[$i-1]}}
            @endfor
            </th>

        </tr>

        <tr>

            <th style="font-size:9px; width:140px;">VERIFICÓ</th>

            @for ($i = 1; $i <=8; $i++)
                <th style="text-align:center; color: #0000FF; font-weight: bold;" colspan="6">
                    @if (strlen($data->estandares->horas[$i-1])>0)
                        {{$data->estandares->verifico[$i-1]}}

                    @endif
            @endfor
            </th>

        </tr>

        <tr>

            <th style="font-size:9px; width:140px;">ACCIONES INMEDIATAS EN CASO DE DEFECTO ÁMBAR O ROJO</th>

            <th colspan="48" style="color: #0000FF; font-weight: bold;">
                {{$data->estandares->observaciones}}
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
    <div style="width: 100%;">
        <pre style="font-size: 10px;"><p style="color: white; font-size:2px;">.</p>                                                                                                                               CC-PEO036-6</pre>
    </div>
</body>

</html>
