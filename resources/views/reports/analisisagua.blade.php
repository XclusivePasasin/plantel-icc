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


    </style>

    <p class="text-center fw-b1 p-0 m-0">DISTRIBUIDORA CUSCATLAN, S.A. DE C.V.</p>
    <p class="text-center fw-b1 p-0 m-0">ICC LABORATORIES</p>
    <p class="text-center fw-b1 p-0 m-0">ORDEN DE PRODUCCIÓN</p><br>

    {{-- <div class="head-wrapper">
        <div class="col1">
            <strong>FECHA DE LA ORDEN: </strong> X
            <strong>NÚMERO DE ORDEN: </strong> X
        </div>
        <div class="col2">
            <strong>CÓDIGO DEL PRODUCTO: </strong> X
            <strong>NOMBRE DEL PRODUCTO: </strong> X
        </div>
    </div> --}}
    <?php if(isset($data->orden) ) { ?>
    <table border="0" style="width: 100%">
        <thead>
            
        </thead>
        <tbody>
            <tr>
                <td> <strong>FECHA DE LA ORDEN: </strong> {{$data->orden->order_date}}</td>
                <td> <strong>CÓDIGO DEL PRODUCTO: </strong> {{$data->orden->product_code}}</td>
            </tr>
            <tr>
                <td> <strong>NÚMERO DE ORDEN: </strong> {{$data->orden->num_id}}</td>
                <td> <strong>NOMBRE DEL PRODUCTO: </strong> {{$data->orden->product_name}}</td>
            </tr>
        </tbody>
    </table>    
    <?php }?>
    <table border="1" class="collapsetable dw100">
        <tbody>
            <tr>
                <td colspan="3" class="text-center fw-b1">CONTROL DEL AGUA</td>
            </tr>
            <tr>
                <td class="text-center fw-b1">CONTROL</td>
                <td class="text-center fw-b1">ESPECIFICACION</td>
                <td class="text-center fw-b1">RESULTADO</td>
            </tr>
            <tr>
                <td class="fw-b1">PH</td>
                <td class="text-center">{{$especificacion->phagua}}</td>
                <td class="text-center; color: #0000FF; font-weight: bold;">{{$data->analisis->phagua}}</td>
            </tr>
            <tr>
                <td class="fw-b1">CONDUCTIVIDAD</td>
                <td class="text-center">{{$especificacion->conductividad}}</td>
                <td class="text-center; color: #0000FF; font-weight: bold;">{{$data->analisis->conductividad}}</td>
            </tr>
            <tr>
                <td class="fw-b1">CLORO LIBRE</td>
                <td class="text-center">{{$especificacion->clorolibre}}</td>
                <td class="text-center; color: #0000FF; font-weight: bold;">{{$data->analisis->clibre}}</td>
            </tr>
            <tr>
                <td colspan="3" class="text-center fw-b1">CONTROL DEL PRODUCTO</td>
            </tr>
            <tr>
                <td class="fw-b1">PH</td>
                <td class="text-center; color: #0000FF; font-weight: bold;">{{$especificacion->phproducto}}</td>
                <td class="text-center; color: #0000FF; font-weight: bold;">{{$data->analisis->phproducto}}</td>
            </tr>
            <tr>
                <td class="fw-b1">VISCOSIDAD</td>
                <td class="text-center; color: #0000FF; font-weight: bold;">{{$especificacion->viscosidad}}</td>
                <td class="text-center; color: #0000FF; font-weight: bold;">{{$data->analisis->viscosidad}}</td>
            </tr>
            <tr>
                <td class="fw-b1">DENSIDAD</td>
                <td class="text-center; color: #0000FF; font-weight: bold;">{{$especificacion->densidad}}</td>
                <td class="text-center; color: #0000FF; font-weight: bold;">{{$data->analisis->densidad}}</td>
            </tr>
            <tr>
                <td class="fw-b1">APARIENCIA</td>
                <td class="text-center">{{$especificacion->apariencia}}</td>
                <td class="text-center; color: #0000FF; font-weight: bold;">{{$data->analisis->apariencia}}</td>
            </tr>
            <tr>
                <td class="fw-b1">COLOR</td>
                <td class="text-center">{{$especificacion->color}}</td>
                <td class="text-center; color: #0000FF; font-weight: bold;">{{$data->analisis->color}}</td>
            </tr>
            <tr>
                <td class="fw-b1">OLOR</td>
                <td class="text-center">{{$especificacion->olor}}</td>
                <td class="text-center; color: #0000FF; font-weight: bold;">{{$data->analisis->olor}}</td>
            </tr>
            <tr>
                <td colspan="3" class="text-center fw-b1">AUTORIZACIONES</td>
            </tr>
            <tr>
                <td class="text-center fw-b1">REALIZO</td>
                <td class="text-center fw-b1">VERIFICO</td>
                <td class="text-center fw-b1">AUTORIZO</td>
            </tr>
            <tr>
                <td class="text-center">{{$data->analisis->user_crea}}</td>
                <td class="text-center">{{$data->analisis->user_verifica}}</td>
                <td class="text-center">{{$data->analisis->user_autoriza}}</td>
            </tr>
            <tr>
                <td class="text-center fw-b1">FIRMA</td>
                <td class="text-center fw-b1">FIRMA</td>
                <td class="text-center fw-b1">FIRMA</td>
            </tr>
            <tr>
                <td class="text-center">{{$data->analisis->user_crea}}</td>
                <td class="text-center">{{$data->analisis->user_verifica}}</td>
                <td class="text-center">{{$data->analisis->user_autoriza}}</td>
            </tr>
            <tr>
                <td class="text-center fw-b1">NOMBRE</td>
                <td class="text-center fw-b1">NOMBRE</td>
                <td class="text-center fw-b1">NOMBRE</td>
            </tr>
            <tr>
                <td class="text-center">{{$data->analisis->rol_crea}}</td>
                <td class="text-center">{{$data->analisis->rol_verifica}}</td>
                <td class="text-center">{{$data->analisis->rol_autoriza}}</td>
            </tr>
            <tr>
                <td class="text-center fw-b1">CARGO</td>
                <td class="text-center fw-b1">CARGO</td>
                <td class="text-center fw-b1">CARGO</td>
            </tr>
        </tbody>
    </table>
</body>

</html>