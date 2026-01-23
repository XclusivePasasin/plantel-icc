<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        /* Estilos generales */
        * {
            box-sizing: border-box;
            font-family: Arial, Helvetica, sans-serif;
            font-size: 93%;
        }

        .page-break {
            page-break-after: always;
        }

        /* Estilos comunes */
        .text-center {
            text-align: center;
        }

        .fw-b1 {
            font-weight: bold;
        }

        .bb-1 {
            border-bottom: 1px solid #b5afaf;
        }

        .bb-2 {
            border-bottom: 1px solid black;
        }

        .m-0 { margin: 0px !important; }
        .p-0 { padding: 0px !important; }
        .pt-5 { padding-top: 5px; }
        .pl-5 { padding-left: 5px; }

        .mt-1 { margin-top: 15px; }
        .mt-2 { margin-top: 5px; }
        .dw100 { width: 100%; }

        .fsm1 {
            font-size: 80%;
        }

        .fsm2 {
            font-size: 78%;
        }

        .fsm3 {
            font-size: 65%;
            text-transform: uppercase;
        }

        /* Estilos para tablas y textos */
        .dtl-header th {
            border-top: 1px solid black;
            border-bottom: 1px solid black;
            padding: 5px;
            text-align: center;
        }

        .border-r1 {
            border: 2px solid black;
            padding: 5px;
            border-radius: 10px;
        }

        .border-r2 {
            border: 1px solid black;
            padding: 5px;
            border-radius: 10px;
            margin-top: 10px;
        }

        .separator1 {
            border-bottom: 1px dotted black;
            height: 1px;
        }

        .separator2 {
            border-bottom: 1px solid black;
            border-top: 1px solid black;
            height: 3px;
            margin: 10px 0;
        }

        .chk1 {
            width: 8px;
            display: inline-block;
            height: 8px;
            border: 1px solid black;
            margin-left: 5px;
        }

        .chk1.active {
            background-color: #888;
        }

        .defblue1 {
            color: rgb(0, 0, 255) !important;
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

        /* Alineación de contenido */
        .centered {
            text-align: center;
        }

        .observaciones-line {
            border-bottom: 1px solid #000;
            margin-bottom: 5px;
            height: 20px;
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

    </style>
</head>
<body>

    <!-- Encabezado de la página -->
    <p class="text-center fw-b1 p-0 m-0">DISTRIBUIDORA CUSCATLAN, S.A. DE C.V.</p>
    <p class="text-center fw-b1 p-0 m-0">ICC LABORATORIES</p>
    <p class="text-center fw-b1 p-0 m-0">ORDEN DE ENVASE/EMPAQUE</p>

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

            <!-- Tercera fila: NÚMERO DE LOTE -->
            <tr>
                <td class="linetext col1">NÚMERO DE LOTE:</td>
                <td class="col2"><span class="underline text-center">{{ $data->lot_num }}</span></td>
                <td class="col3"></td>
                <td class="col4"></td>
                <td class="col5"></td>
                <td class="col6"></td>
            </tr>

            <!-- Cuarta fila: TAMAÑO DE LOTE, TOTAL UNIDADES, RENDIMIENTO TEÓRICO -->
            <tr>
                <td class="linetext col1">TAMAÑO DE LOTE:</td>
                <td class="col2"><span class="underline text-center">{{ $data->lot_size }} </span></td>
                <td class="linetext col3">TOTAL UNIDADES:</td>
                <td class="col4"><span class="underline text-center">{{ $data->total_units }}</span></td>
                <td class="linetext col5">RENDIMIENTO TEÓRICO:</td>
                <td class="col6">
                    <div class="rectangulo">{{ $data->performance_teorico }}</div>
                </td>
            </tr>
        </tbody>
    </table>

    <!-- Sección de tiempos -->
    @if($data->times)
        @foreach (json_decode($data->times) as $time)
            <div class="border-r2 mt-3">
                <table class="dw100 fsm2" style="width: 100%; border-collapse: collapse; font-size: 1.2em; white-space: nowrap;">
                    <tr>
                        <!-- FECHA DE INICIO -->
                        <td class="bold" style="width: 25%; padding-right: 5px; white-space: nowrap;">FECHA DE INICIO :</td>
                        <td style="width: 25%; text-align: center; white-space: nowrap;">
                            @if($time->date_init)
                                <span style="display: inline-block; width: auto; letter-spacing: 2px; border-bottom: 1px solid #0000ff; color: #0000ff;">
                                    {{ implode(' / ', explode('/', $time->date_init)) }}
                                </span>
                            @else
                                <span style="color: black;">_______ / ________ / ________</span>
                            @endif
                        </td>
                        <!-- HORA DE INICIO -->
                        <td class="bold" style="width: 20%; padding-left: 15px; white-space: nowrap;">HORA DE INICIO :</td>
                        <td style="width: 15%; text-align: center; white-space: nowrap;">
                            @if($time->time_init)
                                <span style="display: inline-block; width: auto; letter-spacing: 2px; border-bottom: 1px solid #0000ff; color: #0000ff;">
                                    {{ implode(' : ', explode(':', $time->time_init)) }}
                                </span>
                            @else
                                <span style="color: black;">________ : ________</span>
                            @endif
                        </td>
                    </tr>

                    <tr>
                        <!-- FECHA DE FINALIZACIÓN -->
                        <td class="bold" style="width: 25%; padding-right: 5px; white-space: nowrap;">FECHA DE FINALIZACION :</td>
                        <td style="width: 25%; text-align: center; white-space: nowrap;">
                            @if($time->date_end)
                                <span style="display: inline-block; width: auto; letter-spacing: 2px; border-bottom: 1px solid #0000ff; color: #0000ff;">
                                    {{ implode(' / ', explode('/', $time->date_end)) }}
                                </span>
                            @else
                                <span style="color: black;">_______ / ________ / ________</span>
                            @endif
                        </td>
                        <!-- HORA DE FINALIZACIÓN -->
                        <td class="bold" style="width: 20%; padding-left: 15px; white-space: nowrap;">HORA DE FINALIZACION :</td>
                        <td style="width: 15%; text-align: center; white-space: nowrap;">
                            @if($time->time_end)
                                <span style="display: inline-block; width: auto; letter-spacing: 2px; border-bottom: 1px solid #0000ff; color: #0000ff;">
                                    {{ implode(' : ', explode(':', $time->time_end)) }}
                                </span>
                            @else
                                <span style="color: black;">________ : ________</span>
                            @endif
                        </td>
                    </tr>
                </table>
            </div>
        @endforeach
    @endif

    <div class="mt-1"></div>

    <!-- Operarios Responsables -->
    <div>
        <h6 class="text-center m-0">--------------------------------------------------------------- OPERARIOS RESPONSABLES ---------------------------------------------------------------</h6>
        <table class="dw100 fsm2" style="width: 100%; border-collapse: collapse; font-size: 1.1em; white-space: nowrap; margin-top: 10px;">
            <!-- Inicio del bucle de operarios -->
            @if($data->operarios)
                @foreach(json_decode($data->operarios) as $op)
                    <tr>
                        <!-- NOMBRE/FIRMA -->
                        <td class="linetext bold" style="width: 15%; padding-right: 10px;">NOMBRE/FIRMA</td>
                        <td style="width: 2%;">:</td>
                        <td style="width: 33%; text-align: center;">
                            @if($op->fullname)
                                <span style="display: inline-block; border-bottom: 1px solid #0000ff; color: #0000ff;">
                                    {{ $op->fullname }}
                                </span>
                            @else
                                <span style="color: #000;">___________________________</span>
                            @endif
                        </td>
                        <!-- FECHA -->
                        <td class="linetext bold" style="width: 10%; padding-left: 15px;">FECHA</td>
                        <td style="width: 2%;">:</td>
                        <td style="width: 38%; text-align: center;">
                            @if($op->date)
                                <span style="display: inline-block; width: auto; letter-spacing: 2px; text-align: center; border-bottom: 1px solid #0000ff; color: #0000ff;">
                                    {{ implode(' / ', explode('/', $op->date)) }}
                                </span>
                            @else
                                <span style="color: #000;">_______ / ________ / ________</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            @endif
            <!-- Fin del bucle de operarios -->
        </table>
    </div>

    <!-- Tabla de materiales -->
    <table class="dw100" style="margin-top: 20px; border-collapse: collapse;">
        <thead>
            <tr class="fsm2 dtl-header">
                <th style="width: 8%;">CÓDIGO</th>
                <th style="width: 18%;">DESCRIPCIÓN</th>
                <th style="width: 8%;">PROCESO</th>
                <th style="width: 8%;">CANTIDAD REQUERIDA</th>
                <th style="width: 10%;">UNI</th>
                <th style="width: 8%;">ALM</th>
                <th style="width: 9%;">LOTE</th>
                <th style="width: 1%;"></th>
                <th style="width: 9%;">PRIMER ENTREGA</th>
                <th style="width: 1%;"></th>
                <th style="width: 9%;">SEGUNDA ENTREGA</th>
                <th style="width: 1%;"></th>
                <th style="width: 10%;">DEVOLUCIÓN</th>
            </tr>
        </thead>
    </table>

    <table class="dw100">
        <tbody>
            @foreach ($data->materials()->get() as $e)
                <tr class="fsm3">
                    <td style="width: 8%;">{{ $e->code }}</td>
                    <td style="width: 18%;">{{ $e->description }}</td>
                    <td style="width: 8%;">{{ $e->process }}</td>
                    <td style="width: 8%;" class="text-center">{{ $e->required_amount }}</td>
                    <td style="width: 10%;" class="text-center">{{ $e->unit }}</td>
                    <td style="width: 8%;" class="text-center">{{ $e->stock }}</td>
                    <td style="width: 9%;" class="bb-1 text-center defblue1">{{ $e->lot1 }}</td>
                    <td style="width: 1%;"></td>
                    <td style="width: 9%;" class="bb-1 text-center defblue1">{{ $e->entrega1 }}</td>
                    <td style="width: 1%;"></td>
                    <td style="width: 9%;" class="bb-1 text-center defblue1">{{ $e->entrega2 }}</td>
                    <td style="width: 1%;"></td>
                    <td style="width: 10%;" class="bb-1 text-center defblue1">{{ $e->return }}</td>
                </tr>
                <tr>
                    <td colspan="13">
                        <div class="separator1"></div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Firmas -->
    <div class="mt-1">
        <table class="dw100 fw-b1">
            <tr>
                <td style="width: 33.33%;" class="text-center">
                    <span class="defblue1">{{ $data->user_entrega }}</span>
                    <br>
                    _______________________________________
                    <br>
                    ENTREGA BODEGA
                    <br>
                    NOMBRE/FIRMA
                </td>
                <td style="width: 33.33%;" class="text-center">
                    <span class="defblue1">{{ $data->user_autoriza }}</span>
                    <br>
                    _______________________________________
                    <br>
                    VERIFICADO POR C DE C
                    <br>
                    NOMBRE/FIRMA
                </td>
                <td style="width: 33.33%;" class="text-center">
                    <span class="defblue1">{{ $data->user_recibe }}</span>
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

    <!-- Devolución -->
    <div class="mt-1">
        <table class="dw100" style="text-align: center;">
            <tr>
                <td style="width: 50%;" class="text-center">
                    <span class="linetext">ENTREGA DEVOLUCIÓN NOMBRE/FIRMA:</span>
                    <span class="horizontal-line" style="width: 150px; margin-left: 10px;">{{ $data->devolucion_entrega }}</span>
                </td>
                <td style="width: 50%;" class="text-center">
                    <span class="linetext">RECIBE DEVOLUCIÓN NOMBRE/FIRMA:</span>
                    <span class="horizontal-line" style="width: 150px; margin-left: 10px;">{{ $data->devolucion_recibe }}</span>
                </td>
            </tr>
        </table>
    </div>

    <!-- Observaciones -->
    <div class="mt-1">
        <h6>OBSERVACIONES :</h6>
        @if($data->observations)
            <p class="defblue1" style="text-decoration: underline; text-align: justify;">
                {{ $data->observations }}
            </p>
        @else
            <!-- Simulamos 5 líneas para texto -->
            <div class="observaciones-line"></div>
            <div class="observaciones-line"></div>
            <div class="observaciones-line"></div>
        @endif
    </div>

    <!-- Nota -->
    <div class="mt-1">
        <p>NOTA: Verificar/ referirse a los controles en proceso de Control de Calidad.</p>
    </div>

    <!-- Procedimiento -->
    <div class="mt-1">
        <h6 class="m-0 p-0">PROCEDIMIENTO DE LLENADO Y EMPAQUE (Ver Hoja de verificación de envasado y empacado de sachet)</h6>
        <p class="m-0 p-0" style="text-align: justify;">
            Para Envases Flexibles: verificar que todos los insumos estén completos para el llenado del producto, mezclado y material de empaque, para el caso de sachet, el laminado aprobado previamente se ajusta en máquina y se procede al envasado, posteriormente se empaca en las cajas según contenido especificado.
            Las especificaciones de envasado del producto (peso y volumen), se encuentran en la hoja de controles en proceso, anexa en cada orden de empaque. Los estándares relevantes para el consumidor (CRQS), se encuentran en cada orden de empaque.
        </p>
    </div>

    <!-- Separadores adicionales -->
    <div class="mt-1"></div>
    <div class="mt-1"></div>
    <div class="mt-1"></div>

    <!-- Encabezado de la página -->
    <p class="text-center fw-b1 p-0 m-0">DISTRIBUIDORA CUSCATLAN, S.A. DE C.V.</p>
    <p class="text-center fw-b1 p-0 m-0">ICC LABORATORIES</p>
    <p class="text-center fw-b1 p-0 m-0">ORDEN DE ENVASE/EMPAQUE</p>

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

<!-- Entregas a Producto Terminado -->
<div class="separator2"></div>
<h6 class="m-0 p-0 section-title" style="font-size: 1em; text-align: center;">ENTREGAS A PRODUCTO TERMINADO</h6>
<div class="separator2"></div>

<table class="dw100 fsm2 entrega-table" style="width: 100%; border-collapse: collapse; font-size: 0.8em; white-space: nowrap; margin-top: 10px;">
    <!-- Inicio del bucle de entregas -->
    @php
        $total_cantidad = 0;
    @endphp
    @if($data->entregas)
        @foreach(json_decode($data->entregas) as $en)
            @php
                $cantidad = $en->cantidad ? (int)$en->cantidad : 0;
                $total_cantidad += $cantidad;
            @endphp
            <tr>
                <!-- FECHA -->
                <td class="bold" style="width: 10%; padding-right: 5px; white-space: nowrap;">FECHA:</td>
                <td style="width: 15%; text-align: center; white-space: nowrap; border-bottom: 1px solid #000;">
                    @if($en->date)
                        <span style="display: inline-block; letter-spacing: 2px; color: #0000ff;">
                            {{ implode(' / ', explode('/', $en->date)) }}
                        </span>
                    @else
                        <span style="color: #000;">____ / _____ / _____</span>
                    @endif
                </td>
                <!-- CANTIDAD -->
                <td class="bold" style="width: 10%; padding-left: 15px; white-space: nowrap;">CANTIDAD:</td>
                <td class="defblue1" style="width: 15%; text-align: center; white-space: nowrap; border-bottom: 1px solid #000; color: #000;">
                    {{ $en->cantidad ?? '_____________' }}
                </td>
                <!-- ENTREGADO -->
                <td class="bold" style="width: 10%; padding-left: 15px; white-space: nowrap;">ENTREGADO:</td>
                <td class="defblue1" style="width: 15%; text-align: center; white-space: nowrap; border-bottom: 1px solid #000; color: #000;">
                    {{ $en->entrega ?? '_____________' }}
                </td>
                <!-- RECIBIDO -->
                <td class="bold" style="width: 10%; padding-left: 15px; white-space: nowrap;">RECIBIDO:</td>
                <td class="defblue1" style="width: 15%; text-align: center; white-space: nowrap; border-bottom: 1px solid #000; color: #000;">
                    {{ $en->recibe ?? '_____________' }}
                </td>
            </tr>
        @endforeach
    @endif
    <!-- Fin del bucle de entregas -->
</table>



    <div class="separator2"></div>


    <!-- Sección final -->
    @php
        // Calculamos el rendimiento real
        $lot_size = $data->lot_size ? (int)$data->lot_size : 0;
        $total_cantidad = $total_cantidad ? $total_cantidad : 0;

        if ($lot_size > 0) {
            $performance = ($total_cantidad * 100) / $lot_size;
            $performance = number_format($performance, 2);
        } else {
            $performance = 0;
        }
    @endphp


    @php
        // ================================
        // 🧮 SUMA DE CAJAS Y UNIDADES
        // ================================
        $total_cajas = 0;
        $total_unidades = 0;

        if ($data->entregas) {
            $entregas = json_decode($data->entregas, true);

            foreach ($entregas as $en) {
                if (!empty($en['cantidad'])) {
                    // Eliminar espacios y dividir por "/"
                    $partes = explode('/', str_replace(' ', '', $en['cantidad']));
                    $cajas = isset($partes[0]) ? (int)$partes[0] : 0;
                    $unidades = isset($partes[1]) ? (int)$partes[1] : 0;

                    $total_cajas += $cajas;
                    $total_unidades += $unidades;
                }
            }
        }
    @endphp
    <div class="final-section">
       <div style="text-align: center;">
            <span class="linetext">CANTIDAD TOTAL:</span>
            <span class="horizontal-line" style="width: 150px; margin-left: 10px;">{{ $total_cajas }}</span>
            <span class="horizontal-line" style="width: 150px; margin-left: 10px;">{{ $total_unidades }}</span>
            <br>
            <span style="margin-left: 120px;">CAJAS</span>
            <span style="margin-left: 110px;">UNIDADES</span>
        </div>

      <div class="rendimiento-real">
        <table class="rendimiento-real-table">
            <tr>
                <td style="width: 60%; text-align: left;">
                    <div class="rendimiento-texto">
                        <span class="linetext">RENDIMIENTO REAL DE LA OPERACIÓN DE EMPAQUE:</span>
                        <span class="horizontal-line text-center" style="width: 80px;">
                            {{ $inspeccion->rendimientomezcla ?? 0 }}
                        </span>
                        %
                    </div>
                </td>

                <td style="width: 40%; text-align: right; padding: 0;">
                    <div class="rendimiento-sello">
                        <div class="rectangulo-grande">
                            <p>{{ $inspeccion->ptotal ?? 0 }} ---------------> 100%</p>
                            <p>{{ $data->total_units ?? 0 }} ---------------> {{ $inspeccion->rendimientomezcla ?? 0 }}%</p>
                        </div>
                        <br>
                        <div style="display: flex; align-items: center; justify-content: flex-start; margin-top: 15px;">
                            <span class="fw-b1" style="margin-right: 10px;">NOMBRE/FIRMA:</span>
                            <div class="horizontal-line" style="width: 180px;"></div>
                        </div>
                    </div>
                </td>
            </tr>
        </table>
    </div>
    </div>

</body>
</html>
