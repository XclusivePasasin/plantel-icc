<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        /* Estilos generales */
        *{
            box-sizing: border-box;
            font-family: Arial, Helvetica, sans-serif;
            font-size: 93%;
        }
        .page-break {
            page-break-after: always;
        }

        /* START estilos comunes */
        .text-center{
            text-align: center;
        }

        .fw-b1{
            font-weight: bold;
        }

        .bb-1{
            border-bottom: 1px solid #b5afaf;
        }

        .m-0{margin: 0px !important;}
        .p-0{padding: 0px !important;}
        .pt-5{padding-top: 5px;}
        .pl-5{padding-left: 5px;}

        .mt-1{margin-top: 10px;}
        .mt-2{margin-top: 15px;}
        .mt-3{margin-top: 20px;}
        .mt-4{margin-top: 30px;}
        .mt-5{margin-top: 100px;}
        .dw100{width: 100%;}

        .fsm1{
            font-size: 80%;
        }

        .fsm2{
            font-size: 78%;
        }

        .fsm3 {
            font-size: 65%;
            text-transform: uppercase;
        }
        /* END estilos comunes */

        /* Clases lumbral */
        .lumbral1{width: 22%;}
        .lumbral2{width: 3%;}
        .lumbral3{width: 75%;}

        .lumbral4{width: 22%;}
        .lumbral5{width: 3%;}
        .lumbral6{width: 25%;}
        .lumbral7{width: 22%;}
        .lumbral8{width: 3%;}
        .lumbral9{width: 25%;}

        /* Estilos para tablas y textos */
        .dtl-header th {
            border-top: 2px solid black;
            border-bottom: 2px solid black;
            padding: 5px;
            text-align: center;
        }

        .border-r1{
            border: 2px solid black;
            padding: 5px;
            border-radius: 10px;
        }

        .separator1{
            border-bottom: 1px dotted black;
            height: 3px;
        }

        .separator2{
            border-bottom: 1px solid black;
            border-top: 1px solid black;
            height: 3px;
        }

        .separator3{
            margin-top: 10px;
            border-bottom: 1px dashed #00a6ae;
            height: 3px;
        }

        .defblue1{
            color: rgb(0, 0, 255) !important;
        }

        /* Estilos para el check */
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
            border: solid blue; /* Ajustar el color del check */
            border-width: 0 2px 2px 0;
            transform: rotate(45deg);
        }

        .checkmark.visible::before {
            display: block;
        }

        /* Estilos para el contenedor del check */
        .check-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 100%;
        }

        /* Estilos para la línea horizontal */
        .check-container hr {
            width: 100%;
            border: none;
            height: 1px;
            background-color: #b5afaf; /* Gris claro */
            margin: 2px 0 0 0;
        }

        /* Encabezado para Dompdf */
        body {
            margin: 0cm 0cm;
            /* Márgenes internos para el contenido principal */
            padding-top: 3cm; /* Altura del encabezado */
            padding-bottom: 0cm; /* Sin pie de página */
        }

        header {
            position: fixed;
            top: 0cm;
            left: 0cm;
            right: 0cm;
            height: 3cm;

            /** Estilos personales **/
            color: #000000;
        }

        /* Estilos para el rectángulo grande en la sección final */
        .rectangulo-grande {
            border: 1px solid #000;
            width: 100%;
            height: 80px; /* Aumentar altura para acomodar texto */
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 10px;
            box-sizing: border-box;
            text-align: center;
        }

        .rectangulo-grande p {
            font-size: 1.2em; /* Aumentar tamaño de fuente */
            margin: 5px 0;
        }

        /* Otros estilos existentes */

        .horizontal-line {
            border-bottom: 1px solid black;
            width: 200px;
            display: inline-block;
        }

        .underline {
            border-bottom: 1px solid black;
            display: inline-block;
            width: 100%;
        }

        /* Sección final */
        .final-section {
            margin-top: 30px;
        }

        .firma-section {
            width: 45%;
            text-align: center;
            display: inline-block;
            vertical-align: top;
        }

        .firma-section p {
            margin: 5px 0;
        }
        
      .observaciones-line {
            border-bottom: 1px solid #000;
            margin: 0;
            height: 20px;
        }


        /* Rendimiento real */
        .rendimiento-real {
            margin-top: 20px;
            width: 100%;
        }

        .rendimiento-real-table {
            width: 100%;
            border-collapse: collapse;
        }

        .rendimiento-real-table td {
            vertical-align: top;
            padding: 0; /* Eliminar padding para mejor alineación */
        }

        .rendimiento-texto {
            text-align: left;
            font-size: 100%;
        }

        .rendimiento-texto .linetext {
            white-space: nowrap;
            margin-right: 10px;
        }

        .rendimiento-texto .horizontal-line {
            border-bottom: 1px solid black;
            width: 80px;
            display: inline-block;
            margin-left: 10px;
        }

        .rendimiento-sello {
            text-align: right;
        }

        /* Sección de entregas */
        .lumbral14 {
            font-weight: bold;
            width: 10%;
            white-space: nowrap;
        }

        .lumbral12 {
            width: 15%;
            padding-left: 5px;
        }

        .section-title {
            margin-top: 20px;
            margin-bottom: 10px;
        }

        /* Ajustes adicionales */
        .entrega-table td {
            padding: 5px;
        }

        .subtext {
            border-bottom: 1px solid #000;
            text-align: center;
        }

        .linetext {
            font-weight: bold;
            padding-top: 5px;
            white-space: nowrap;
            font-size: 90%; /* Reducir el tamaño del texto */
        }

        .rectangulo {
            border: 1px solid #000;
            padding: 10px 30px;
            text-align: center;
            display: inline-block;
            white-space: nowrap;
            vertical-align: middle;
        }

        .rectangulo-grande {
            border: 1px solid #000;
            width: 100%;
            height: 50px; /* Aumentar altura para acomodar texto */
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 10px;
            box-sizing: border-box;
            text-align: center;
        }

        .rectangulo-grande p {
            font-size: 1.2em; /* Aumentar tamaño de fuente */
            margin: 5px 0;
        }

        .align-left {
            text-align: left;
        }

        .bold {
            font-weight: bold;
        }

        .table {
            width: 100%;
            margin-top: 10px;
            table-layout: fixed;
            border-collapse: collapse;
        }

        .table td {
            white-space: nowrap;
            text-transform: uppercase;
            padding: 5px 10px;
            border-bottom: 1px solid #ddd;
            vertical-align: top;
        }

        /* Anchos de columnas */
        .col1 { width: 20%; }
        .col2 { width: 13%; }
        .col3 { width: 20%; }
        .col4 { width: 13%; }
        .col5 { width: 20%; }
        .col6 { width: 14%; }
        .observaciones-line {
            border-bottom: 1px solid #000;
            margin-bottom: 5px;
            height: 20px;
        }
    </style>
</head>
<body>

    <!-- Definir encabezado -->
    <header>
        <p class="text-center fw-b1 p-0 m-0">DISTRIBUIDORA CUSCATLAN, S.A. DE C.V.</p>
        <p class="text-center fw-b1 p-0 m-0">ICC LABORATORIES</p>
        <p class="text-center fw-b1 p-0 m-0">ORDEN DE PRODUCCIÓN</p>
                <!-- Tabla principal -->
                <table class="table">
                    <tbody>
                        <!-- Primera fila: FECHA DE LA ORDEN y CÓDIGO DEL PRODUCTO -->
                        <tr>
                            <td class="linetext col1">FECHA DE LA ORDEN:</td>
                            <td class="col2">{{ \Carbon\Carbon::parse($data->order_date)->format('d/m/Y') }}</td>
                            <td class="linetext col3">CÓDIGO DEL PRODUCTO:</td>
                            <td class="col4">{{ $data->product_code }}</td>
                            <td class="col5"></td>
                            <td class="col6"></td>
                        </tr>

                        <!-- Segunda fila: NÚMERO DE ORDEN y NOMBRE DEL PRODUCTO -->
                        <tr>
                            <td class="linetext col1">NÚMERO DE ORDEN:</td>
                            <td class="col2">{{ $data->num_id }}</td>
                            <td class="linetext col3">NOMBRE DEL PRODUCTO:</td>
                            <td class="col4">{{ $data->product_name }}</td>
                            <td class="col5"></td>
                            <td class="col6"></td>
                        </tr>
                    </tbody>
                </table>
                <!-- Fin de Tabla principal -->
                <div class="separator3"></div>
    </header>

    <!-- Contenido principal -->
    <main>

        <table class="dw100 mt-2" style="white-space: nowrap;">
            <tbody>
                <!-- Primera fila: PRODUCCIÓN AUTORIZADA POR, FIRMA -->
                <tr>
                    <td colspan="6" style="text-align: left; white-space: nowrap;">
                        <span class="linetext col1">PRODUCCIÓN AUTORIZADA POR :</span>
                        <span class="horizontal-line defblue1 text-center" style="width: 150px; display: inline-block; margin-right: 20px;">{{ $data->user_autoriza_finish}}</span>
                        <span class="linetext col1">FIRMA :</span>
                        <span class="horizontal-line" style="width: 150px; display: inline-block;"></span>
                    </td>
                </tr>
                <!-- Segunda fila: NÚMERO DE LOTE -->
                <tr>
                    <td class="linetext col1">NÚMERO DE LOTE</td>
                    <td class="lumbral5">:</td>
                    <td class="col2"><span class="underline text-center">{{ $data->lot_num }}</span></td>
                    <td class="col3"></td>
                    <td class="col4"></td>
                    <td class="col5"></td>
                    <td class="col6"></td>
                </tr>

                <!-- Tercera fila: TAMAÑO DE LOTE -->
                <tr>
                    <td class="linetext col1">TAMAÑO DE LOTE</td>
                    <td class="lumbral5">:</td>
                    <td class="col2"><span class="underline text-center">{{ $data->lot_size }} KG</span></td>
                    <td class="col3"></td>
                    <td class="col4"></td>
                    <td class="col5"></td>
                    <td class="col6"></td>
                </tr>
            </tbody>
        </table>


        <table class="dw100" style="white-space: nowrap;">
            <tbody>
                <!-- Primera fila -->
                <tr>
                <td class="lumbral4 pt-5 fw-b1">FECHA DE INICIO DE PESADO</td>
                <td class="lumbral5">:</td>
                <td class="lumbral6 bb-1 defblue1 text-center">
                    {{
                    $data->pesaje_inicio
                        ? date('d / m / Y', strtotime($data->pesaje_inicio))
                        : '__ / __ / ____'
                    }}
                </td>
                <td class="lumbral7 pt-5 pl-5 fw-b1">HORA DE INICIO DE PESADO</td>
                <td class="lumbral8">:</td>
                <td class="lumbral9 bb-1 defblue1 text-center">
                    {{
                    $data->pesaje_inicio
                        ? date('H : i', strtotime($data->pesaje_inicio))
                        : '__ : __'
                    }}
                </td>
                </tr>

                <!-- Segunda fila -->
                <tr>
                <td class="lumbral4 pt-5 fw-b1">FECHA DE FINALIZACIÓN DE PESADO</td>
                <td class="lumbral5">:</td>
                <td class="lumbral6 bb-1 defblue1 text-center">
                    {{
                    $data->pesaje_fin
                        ? date('d / m / Y', strtotime($data->pesaje_fin))
                        : '__ / __ / ____'
                    }}
                </td>
                <td class="lumbral7 pt-5 pl-5 fw-b1">HORA DE FINALIZACIÓN DE PESADO</td>
                <td class="lumbral8">:</td>
                <td class="lumbral9 bb-1 defblue1 text-center">
                    {{
                    $data->pesaje_fin
                        ? date('H : i', strtotime($data->pesaje_fin))
                        : '__ : __'
                    }}
                </td>
                </tr>

                <!-- Tercera fila -->
                <tr>
                <td class="linetext col1">NÚMERO DE FORMULA MAESTRA</td>
                <td class="lumbral5">:</td>
                <td class="col2 bb-1 defblue1 text-center">
                    {{ $data->cod_formula_master ? $data->cod_formula_master : '___________' }}
                </td>
                <td class="col3"></td>
                <td class="col4"></td>
                <td class="col5"></td>
                </tr>
            </tbody>
            </table>


        <table class="dw100" style="margin-top: 20px; border-collapse: collapse;">
            <thead>
                <tr class="fsm2 dtl-header">
                    <th style="width: 10%;">CÓDIGO</th>
                    <th style="width: 20%;">DESCRIPCIÓN</th>
                    <th style="width: 10%;">CANTIDAD REQUERIDA</th>
                    <!-- <th style="width: 10%;">RECEPCIÓN MEZCLA</th> -->
                    <th style="width: 10%;">UNIDAD</th>
                    <!-- <th style="width: 10%;">CANTIDAD</th> -->
                    <th style="width: 10%;">ALMACÉN</th>
                    <th style="width: 9%;">PRIMER ENTREGA</th>
                    <th style="width: 1%;"></th>
                    <th style="width: 9%;">LOTE</th>
                    <th style="width: 1%;"></th>
                    <th style="width: 9%;">SEGUNDA ENTREGA</th>
                    <th style="width: 1%;"></th>
                    <th style="width: 10%;">LOTE</th>
                </tr>
            </thead>
        </table>

        <table class="dw100">
            <tbody>
                @foreach ($data->mixMaterials()->get() as $e)
                <tr class="fsm3">
                    <td style="width: 10%;">{{ $e->code }}</td>
                    <td style="width: 20%;">{{ $e->description }}</td>
                    <td style="width: 10%;" class="text-center">
                        @if(($e->amount1 == null && $e->amount2 == null))
                            <div>{{ $e->required_amount }}</div>
                        @else
                            <div>
                                <span>{{$e->amount1 + $e->amount2}}</span>
                            </div>
                        @endif

                    </td>
                    <!-- <td style="width: 10%;" class="text-center">
                        <div class="check-container">
                            <span class="checkmark {{ $e->entrega3 == 1 ? 'visible' : '' }}"></span>
                            <hr>
                        </div>
                    </td> -->
                    <td style="width: 10%;" class="text-center">{{ $e->unit }}</td>
                    <!-- <td style="width: 10%;" class="text-center">{{ $e->stock }}</td> -->
                    <td style="width: 12%;" class="text-center">{{ $e->almacen }}</td>
                    <td style="width: 9%;" class="text-center">
                        <div class="check-container">
                            <span class="checkmark {{ $e->entrega1 == 1 ? 'visible' : '' }}"></span>
                            <hr>
                        </div>
                    </td>
                    <td style="width: 1%;"></td>
                    <td style="width: 12%;" class="bb-1 defblue1 text-center">{{ $e->lot1 }}</td>
                    <td style="width: 1%;"></td>
                    <td style="width: 9%;" class="text-center">
                        <div class="check-container">
                            <span class="checkmark {{ $e->entrega2 == 1 ? 'visible' : '' }}"></span>
                            <hr>
                        </div>
                    </td>
                    <td style="width: 1%;"></td>
                    <td style="width: 10%;" class="bb-1 defblue1 text-center">{{ $e->lot2 }}</td>
                </tr>
                <tr>
                    <td colspan="13">
                        <div class="separator1"></div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <table class="dw100" style="white-space: nowrap; margin-top: 15px;">
            <tbody>
                <tr>
                    <td class="fw-b1" style="text-align: left; padding-right: 5px;">PESADO POR :</td>
                    <td class="bb-1 defblue1" style="width: 100px; text-align: center;">{{ $data->user_entrega }}</td>
                    <td class="fw-b1" style="text-align: left; padding-left: 10px; padding-right: 5px;">FIRMA :</td>
                    <td class="bb-1" style="width: 100px; text-align: center;"></td>
                    <td class="fw-b1" style="text-align: left; padding-left: 10px; padding-right: 5px;">VERIFICADO POR :</td>
                    <td class="bb-1 defblue1" style="width: 100px; text-align: center;">{{ $data->verified_by }}</td>
                    <td class="fw-b1" style="text-align: left; padding-left: 10px; padding-right: 5px;">FIRMA :</td>
                    <td class="bb-1" style="width: 100px; text-align: center;"></td>
                </tr>
            </tbody>
        </table>


        <!-- Observaciones -->
        <div class="mt-2">
            <h6>OBSERVACIONES :</h6>

            <div style="position: relative; height: 80px; line-height: 21px;">
                <!-- Texto encima con saltos automáticos -->
                <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; word-break: break-word; white-space: normal; text-align: justify; font-size: 93%;">
                    {!! $data->observaciones !!}
                </div>

                <!-- Líneas de fondo alineadas con el texto -->
                <div class="observaciones-line"></div>
                <div class="observaciones-line"></div>
                <div class="observaciones-line"></div>
                <div class="observaciones-line"></div>
            </div>
        </div>




        <!-- Firmas -->
        <div class="mt-4">
            <table class="dw100 fw-b1">
                <tr>
                    <td style="width: 33.33%;" class="text-center">
                        <span class="defblue1">{{ $data->user_entrega_mp }}</span>
                        <br>
                        _______________________________________
                        <br>
                        ENTREGA BODEGA MP
                        <br>
                        NOMBRE/FIRMA
                    </td>
                    <!-- <td style="width: 33.33%;" class="text-center">
                        <span class="defblue1">{{ $data->materials_received_by }}</span>
                        <br>
                        _______________________________________
                        <br>
                        RECIBE MATERIALES,
                        <br>
                        NOMBRE/FIRMA
                    </td> -->
                    <td style="width: 33.33%;" class="text-center">
                        <span class="defblue1">{{ $data->materials_received_by }}</span>
                        <br>
                        _______________________________________
                        <br>
                        RECIBE PRODUCCIÓN
                        <br>
                        NOMBRE/FIRMA
                    </td>
                </tr>
            </table>
        </div>

        <div class="mt-5"></div>
        <div class="mt-5"></div>
        <div class="mt-5"></div>
        <div class="mt-3"></div>

        <h6 class="text-center m-0">---------------------------------------------------------- PROCESO DE FABRICACIÓN ----------------------------------------------------------</h6>
        <table class="dw100 mt-2" style="white-space: nowrap;">
            <tbody>
                <!-- Primera fila -->
                <tr>
                    <td class="lumbral4 pt-5 fw-b1">FECHA DE INICIO DE FABRICACIÓN</td>
                    <td class="lumbral5">:</td>
                    <td class="lumbral6 bb-1 defblue1 text-center">{{ $data->datetime_init ? date('d / m / Y', strtotime($data->datetime_init)) : '____ / ______ / ______' }}</td>
                    <td class="lumbral7 pt-5 pl-5 fw-b1">HORA DE INICIO DE FABRICACIÓN</td>
                    <td class="lumbral8">:</td>
                    <td class="lumbral9 bb-1 defblue1 text-center">{{ $data->datetime_init ? date('H : i', strtotime($data->datetime_init)) : '____ : ____' }}</td>
                </tr>

                <!-- Segunda fila -->
                <tr>
                    <td class="lumbral4 pt-5 fw-b1">FECHA DE FINALIZACIÓN DE FABRICACIÓN</td>
                    <td class="lumbral5">:</td>
                    <td class="lumbral6 bb-1 defblue1 text-center">{{ $data->datetime_end ? date('d / m / Y', strtotime($data->datetime_end)) : '____ / ______ / ______' }}</td>
                    <td class="lumbral7 pt-5 pl-5 fw-b1">HORA DE FINALIZACIÓN DE FABRICACIÓN</td>
                    <td class="lumbral8">:</td>
                    <td class="lumbral9 bb-1 defblue1 text-center">{{ $data->datetime_end ? date('H : i', strtotime($data->datetime_end)) : '____ : ____' }}</td>
                </tr>
            </tbody>
        </table>

        <div class="dw100" style="margin-top: 15px; white-space: nowrap; border-collapse: collapse;">
            <table style="width: 100%; border-collapse: collapse;">
                <tbody>
                    <tr>
                        <td class="fw-b1" style="text-align: left; padding-right: 10px; white-space: nowrap;">
                            RENDIMIENTO REAL :
                        </td>
                        <td class="bb-1 defblue1 text-center" style="width: 200px; text-align: center; white-space: nowrap;">
                            {{ $data->real_performance }} KG
                        </td>
                        <td class="fw-b1" style="text-align: left; padding-left: 15px; white-space: nowrap;">
                            NOMBRE/FIRMA :
                        </td>
                        <td class="bb-1 defblue1 text-center" style="width: 200px; text-align: center; white-space: nowrap;">
                            {{ $data->user_recibe }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>


        <div class="separator1 mt-2"></div>

        <div class="mt-2">
            <h6 class="m-0 p-0">INDICACIONES PREVIAS A UTILIZAR EL ÁREA DE FABRICACIÓN:</h6>
            <p class="m-0 p-0" style="text-align: justify;">Antes del inicio de cualquier operación para este producto, debera observarse que las paredes, piso, cielo, ventanas y luminarias esten en buenas condiciones. Todo el equipo a utilizar, recipientes y utensilios deben estar sanitizados. Todas las materias extrañas, deben ser retiradas antes de iniciar.</p>
        </div>

        <div class="separator2 mt-2"></div>

        <h6 class="text-center mt-2">----------------------------------------- REVISIÓN DE MATERIA PRIMA ANTES DEL FABRICADO -----------------------------------------</h6>
        <div class="mt-1">
            @php
                $firstRevision = $data->revisiones ? json_decode($data->revisiones)[0] ?? null : null;
            @endphp

            @if($firstRevision)
                <!-- Bloque RESPONSABLE DE LA REVISIÓN -->
                <div>
                    <div style="border: 2px solid black; border-radius: 10px; padding: 8px; margin-bottom: 8px;">
                        <table class="dw100 fsm2" style="width: 100%; border-collapse: collapse;">
                            <tr>
                                <td style="width: 20%; white-space: nowrap; padding: 5px;" class="fw-b1">RESPONSABLE DE LA REVISIÓN :</td>
                                <td style="width: 20%; text-align: center;" class="bb-1 defblue1">{{ $firstRevision->username ?? '_________________' }}</td>
                                <td style="width: 5%;"></td>
                                <td style="width: 10%; white-space: nowrap; padding-left: 5px;" class="fw-b1">FIRMA :</td>
                                <td style="width: 20%; text-align: center;" class="bb-1 defblue1"></td>
                                <!-- <td style="width: 20%; text-align: center;" class="bb-1 defblue1">{{ $firstRevision->firma ?? '_________________' }}</td> -->
                                <td style="width: 5%;"></td>
                                <td style="width: 10%; white-space: nowrap; padding-left: 5px;" class="fw-b1">FECHA :</td>
                                <td style="width: 20%; text-align: center;" class="bb-1 defblue1">{{ $firstRevision->date ?? '____ / _____ / ______' }}</td>
                            </tr>
                        </table>
                    </div>

                    <!-- Separador -->
                    <div class="separator1 mt-2"></div>

                    <!-- Bloque ANALISIS DE DUREZA DE AGUA -->
                    {{-- <div style="border: 2px solid black; border-radius: 10px; padding: 8px; margin-bottom: 12px; margin-top: 10px">
                        <table class="dw100 fsm2" style="width: 100%; border-collapse: collapse;">
                            <tr>
                                <td style="width: 20%; white-space: nowrap; padding: 5px;" class="fw-b1">ANALISIS DE DUREZA DE AGUA :</td>
                                <td style="width: 5%; white-space: nowrap;" class="fw-b1">CUMPLE :</td>
                                <td style="width: 5%; text-align: center; padding-left: 3px;">
                                    <div class="check-container" style="display: inline-block; width: 15px; height: 15px; border: 1px solid black; vertical-align: middle;">
                                        <span class="checkmark {{ $data->water_check == 1 ? 'visible' : '' }}"></span>
                                    </div>
                                </td>
                                <td style="width: 10%; white-space: nowrap; padding-left: 5px;" class="fw-b1">FIRMA :</td>
                                <td style="width: 20%; text-align: center;" class="bb-1 defblue1">{{ $firstRevision->firma ?? '_________________' }}</td>
                                <td style="width: 5%;"></td>
                                <td style="width: 10%; white-space: nowrap; padding-left: 5px;" class="fw-b1">FECHA :</td>
                                <td style="width: 20%; text-align: center;" class="bb-1 defblue1">{{ $firstRevision->date ?? '____ / _____ / ______' }}</td>
                            </tr>
                        </table>
                    </div> --}}
                </div>
            @endif
        </div>



       <!-- Observaciones -->
        <div class="mt-2">
            <h6>OBSERVACIONES :</h6>

            <div style="position: relative; height: 80px; line-height: 21px;">
                <!-- Texto encima con saltos automáticos -->
                <!-- <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; word-break: break-word; white-space: normal; text-align: justify; font-size: 93%;">
                    {!! $data->observaciones !!}
                </div> -->

                <!-- Líneas de fondo alineadas con el texto -->
                <div class="observaciones-line"></div>
                <div class="observaciones-line"></div>
                <div class="observaciones-line"></div>
                <div class="observaciones-line"></div>
            </div>
        </div>

        <div class="mt-2">
            <p class="p-0 m-0" style=" text-transform: uppercase;"> <span class="fw-b1">NOTA:</span> PARA PROCEDIMIENTOS Y EQUIPOS A UTILIZAR VER PROCESO DE MANUFACTURA DE {{ $data->product_name }}</p>
        </div>

    </main>

</body>
</html>
