<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>Hoja de inspecciones</title>
</head>
<style>
    .center {
        text-align: center;
    }
    .left {
        text-align: left;
    }
    .underline {
        text-decoration: underline;
    }
    .strong {
        font-weight: bold;
    }
    .tabla1 {
        width: 100%;
    }
    td, th {
        padding: 0.5em;
    }
</style>
<body>
    <div class="container">
        <div class="center strong">
            <p>DISTRIBUIDORA CUSCATLAN, S.A. DE C.V.</p>
            <p>ICC LABORATORIES</p>
            <p>HOJA DE INSPECCIÓN</p>
            <br>
        </div>

        <div class="left">
            <p class="strong">Validación de conexión a tanque</p>
            <table class="table table-sm">
                <tbody>
                    <tr>
                        <th scope="row">Fecha y hora</th>
                        <td>{{$data->inspecciones->fechahoraconxtanque1}}</td>
                    </tr>
                    <tr>
                        <th scope="row">Supervisor de producción</th>
                        <td>{{$data->inspecciones->supervisorconxtanque1}}</td>
                    </tr>
                    <tr>
                        <th scope="row">Auxiliar de Control de calidad</th>
                        <td>{{$data->inspecciones->ctrlcalidadconxtanque1}}</td>
                    </tr>
                    <tr>
                        <th scope="row">Producción</th>
                        <td>{{$data->inspecciones->opmaquinaconxtanque1}}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="left">
            <p>LOTE. <span class="underline strong">{{$data->order->lot_num}}</span></p>
            <p>N° Tanque. <span class="underline strong">{{$data->inspecciones->tanque}}</span></p>
        </div>

        <div class="table-responsive">
            <table class="table table-sm">
                <thead>
                    <tr class="center strong">
                        <th colspan="2">RECHAZADOS</th>
                        <th colspan="2">VACÍOS</th>
                    </tr>
                    <tr>
                        <th>FECHAS</th>
                        <th>CANTIDAD UND</th>
                        <th>FECHAS</th>
                        <th>CANTIDAD KGS</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{$data->inspecciones->rechazadosfecha1}}</td>
                        <td>{{$data->inspecciones->rechazadoscantidadund1}}</td>
                        <td>{{$data->inspecciones->vaciosfecha1}}</td>
                        <td>{{$data->inspecciones->vacioscantidadkgs1}}</td>
                    </tr>
                    <tr>
                        <td>{{$data->inspecciones->rechazadosfecha2}}</td>
                        <td>{{$data->inspecciones->rechazadoscantidadund2}}</td>
                        <td>{{$data->inspecciones->vaciosfecha2}}</td>
                        <td>{{$data->inspecciones->vacioscantidadkgs2}}</td>
                    </tr>
                    <tr>
                        <td>{{$data->inspecciones->rechazadosfecha3}}</td>
                        <td>{{$data->inspecciones->rechazadoscantidadund3}}</td>
                        <td>{{$data->inspecciones->vaciosfecha3}}</td>
                        <td>{{$data->inspecciones->vacioscantidadkgs3}}</td>
                    </tr>
                    <tr>
                        <td>{{$data->inspecciones->rechazadosfecha4}}</td>
                        <td>{{$data->inspecciones->rechazadoscantidadund4}}</td>
                        <td>{{$data->inspecciones->vaciosfecha4}}</td>
                        <td>{{$data->inspecciones->vacioscantidadkgs4}}</td>
                    </tr>
                    <tr>
                        <td class="strong center">TOTAL</td>
                        <td>{{$data->inspecciones->totalunidadesrechazadas}}</td>
                        <td class="strong center">TOTAL</td>
                        <td>{{$data->inspecciones->totalkilogramosvacios}}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="left">
            <p>PRODUCTO TERMINADO =
                <span class="underline strong">{{$data->inspecciones->productoterminado1}} + {{$data->inspecciones->productoterminado2}}</span>
            </p>
        </div>

    <div>
        <table class="table table-sm">
            <tbody>
                <tr>
                    <th scope="row">PT+</th>
                    @if($data->inspecciones->pt)
                    <td>{{$data->inspecciones->pt}}</td>
                    @endif
                </tr>

                <tr>
                    <th scope="row">PR</th>
                    @if($data->inspecciones->totalunidadesrechazadas)
                    <td>{{$data->inspecciones->totalunidadesrechazadas}}</td>
                    @endif
                    </tr>
                <tr>
                    <th scope="row">=</th>
                    @if($data->inspecciones->ptotal)
                    <td>{{$data->inspecciones->ptotal}}</td>
                    @endif
                </tr>
            </tbody>
        </table>
    </div>

    <div class="left pt-4">
        <p>RENDIMIENTO DE MEZCLA = ({{$data->inspecciones->ptotal}} x 100) / 300000 = <span class="underline strong">{{$data->inspecciones->rendimientomezcla}}</span></p>
    </div>

    <div class="left">
        <p>CONSUMO DE BOBINA = <span class="underline strong">{{$data->inspecciones->consumobobina}}</span></p>
    </div>

</div>
</body>
</html>
