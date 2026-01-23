<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tarjetas de Productos</title>
    <style>
        /** Define the margins of your page **/
        @page {
                margin: 90px 25px;
        }
        .page {
            page-break-after: always;
        }

        .page:last-child {
            page-break-after: auto;
        }

        header {
            position: fixed;
            top: -80px;
            left: 0px;
            right: 0px;
            height: 50px;
            line-height: 0px;
            /* background: blue;  */ 
        }
        .brand{
            font-weight: bolder;
            text-align: center;
        }

        /* Contenedor de filas (row) */
        .row {
            display: block;
            width: 100%;
        }

        /* Cada columna de 50% (col-6) */
        .col-6 {
            display: inline-block;
            width: 48%; /* Aproximadamente 50%, dejando espacio para el margen */
            margin: 0.5%; /* Margen para separar las tarjetas */
            box-sizing: border-box;
            vertical-align: top;
            
            
        }

        /* Estilo de la tarjeta */
        .card {
            padding: 15px;
            border: 1px solid ;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            font-family: Arial, sans-serif;
        }

        /* Encabezado de la tarjeta */
        .row-header {
            display: block;
            margin-bottom: 10px;
        }

        .title {
            font-weight: bold;
            font-size: 14px;
            margin: 0;
            
        }

        .description {
            font-size: 13px;
            color: #333;
            margin: 0;
        }

        /* Ajustes para etiquetas p en la tarjeta */
        .card p {
            margin: 5px 0;
        }
    </style>
</head>
<body>
    <!-- Define header and footer blocks before your content -->
    <header>
        <div class="brand">
            <p >DISTRIBUIDORA CUSCATLAN, S.A. DE C.V.</p>
            <p>ICC LABORATORIES</p>
            <p>ORDEN DE PRODUCCIÓN</p><br>
        </div>
    </header>


             @foreach ($data->materials()->get()->chunk(8) as $group)
             <div class="row">
                <div class="row">
                    <div class="col-6">
                        <strong>FECHA DE LA ORDEN: </strong> {{ \Carbon\Carbon::parse($data->order_date)->format('d/m/Y') }}
                    </div>
                    <div class="col-6">
                        <strong>CÓDIGO DEL PRODUCTO: </strong> {{ $data->product_code }}
                    </div>
                    <div class="col-6"><strong>NÚMERO DE ORDEN: </strong> {{ $data->num_id }}</div>
                    <div class="col-6"><strong>NOMBRE DEL PRODUCTO: </strong> {{ $data->product_name }}</div>
                    <div class="col-6"></div>
                    <div class="col-6"><strong>LOTE:</strong>{{ $data->lot_num }}</div>
                </div>
                {{-- @foreach ($group as $product)
                    <div class="col-6">
                        <div class="card">
                            <div class="row-header">
                                <div style="float: left;">
                                    <p class="title">CÓDIGO</p>
                                    <p>{{$product->code}}</p>
                                </div>
                                <div style="float: right;">
                                    <p class="title">CANTIDAD</p>
                                    <p>{{$product->required_amount}}</p>
                                </div>
                            </div><br>
                            <div style="margin-top: 80px;">
                                <p class="title">DESCRIPCIÓN</p>
                                <p class="description">{{$product->description}}</p>
                            </div>
                        </div>
                    </div>
                @endforeach --}}
                @foreach ($group as $product)
    @if ($product->amount1 && $product->amount2)
        <div class="col-6">
            <div class="card">
                <div class="row-header">
                    <div style="float: left;">
                        <p class="title">CÓDIGO</p>
                        <p>{{ $product->code }}</p>
                    </div>
                    <div style="float: right;">
                        <p class="title">CANTIDAD 1</p>
                        <p>{{ $product->amount1 }}</p>
                    </div>
                </div><br>
                <div style="margin-top: 80px;">
                    <p class="title">DESCRIPCIÓN</p>
                    <p class="description">{{ $product->description }}</p>
                </div>
            </div>
        </div>

        <div class="col-6">
            <div class="card">
                <div class="row-header">
                    <div style="float: left;">
                        <p class="title">CÓDIGO</p>
                        <p>{{ $product->code }}</p>
                    </div>
                    <div style="float: right;">
                        <p class="title">CANTIDAD 2</p>
                        <p>{{ $product->amount2 }}</p>
                    </div>
                </div><br>
                <div style="margin-top: 80px;">
                    <p class="title">DESCRIPCIÓN</p>
                    <p class="description">{{ $product->description }}</p>
                </div>
            </div>
        </div>
    @else
        <div class="col-6">
            <div class="card">
                <div class="row-header">
                    <div style="float: left;">
                        <p class="title">CÓDIGO</p>
                        <p>{{ $product->code }}</p>
                    </div>
                    <div style="float: right;">
                        <p class="title">CANTIDAD</p>
                        <p>{{ $product->required_amount }}</p>
                    </div>
                </div><br>
                <div style="margin-top: 80px;">
                    <p class="title">DESCRIPCIÓN</p>
                    <p class="description">{{ $product->description }}</p>
                </div>
            </div>
        </div>
    @endif
@endforeach

        
                <br><br><br><br><br>
            </div>
             @endforeach

        



</body>
</html>
