@extends('layouts.admin-template')
@section('title', 'Control de producto')

@push('customStyles')
<style>
    .result-container {
        margin-top: 30px;
    }
    .btn-back {
        margin-bottom: 20px;
    }
    .product-info-card {
        border-left: 4px solid #007bff;
        background-color: #f8f9fa;
        margin-bottom: 20px;
    }
</style>
@endpush

@section('content')
<div id="appControlProducto" class="sa-app__body px-2 px-lg-4">
    <div class="container my-4">
        <!-- Breadcrumb -->
        <nav class="sa-article__breadcrumb mb-6" aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-sa-simple">
                <li class="breadcrumb-item">
                    <a href="{{route('admin.home')}}">Inicio</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Control de Producto</li>
            </ol>
        </nav>

        <!-- Componente principal -->
        <div class="search-container" v-if="panels.p1">
            <search-orden 
                title="Control de producto" 
                :aorders="{{ json_encode($aorders) }}" 
                typeorder="control-producto" 
                @load-order="loadProducto">
            </search-orden>
        </div>
        
        <div class="result-container" v-if="panels.p2">
            <!-- <button @click="volverABuscar" class="btn btn-secondary btn-back">
                <i class="bi bi-arrow-left"></i> Volver a buscar
            </button> -->
            
            <control-producto 
                v-if="ordenActual"
                :order-data="ordenActual">
            </control-producto>
        </div>
    </div>
</div>
@endsection

@push('customScripts')
<script type="text/javascript" src="{{ mix('js/vue-pages/app-controlproducto.js') }}"></script>
@endpush