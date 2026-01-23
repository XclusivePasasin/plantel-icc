@extends('layouts.admin-template')

@php
    $page_title = 'Validación de tanque';
@endphp

@push('customStyles')
<style>
    .result-container {
        margin-top: 30px;
    }
    .btn-back {
        margin-bottom: 20px;
    }
</style>
@endpush

@section('content')
<div id="appValidacionTanque" class="sa-app__body px-2 px-lg-4">
    <div class="container my-4">
        <!-- Breadcrumb -->
        <nav class="sa-article__breadcrumb mb-6" aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-sa-simple">
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.home') }}">Inicio</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Validación de tanque</li> 
            </ol>
        </nav>

        <!-- Componente de búsqueda -->
        <div class="search-container" v-if="panels.buscar">
            <search-validacion-tanque 
                @load-order="cargarValidacion">
            </search-validacion-tanque>
        </div>

        <!-- Formulario de validación -->
        <div class="result-container" v-if="panels.formulario">
             <div class="mt-4 mb-4 d-flex gap-2">
                <!-- <button 
                    class="btn btn-dark"
                    @click="guardarValidacion"
                    v-if="helpers.estado < 2"
                >
                    <i class="bi bi-save"></i> Guardar
                </button> -->

                <button 
                    class="btn btn-secondary"
                    @click="volverABuscar"
                >
                    <i class="bi bi-arrow-left"></i> Volver
                </button>
            </div>
            <validacion-tanque 
                v-if="ordenActual && typeof helpers !== 'undefined'"
                :validacion-tanque="ordenActual.validacionTanque"
                ref="validacionTanque"
                :modo-lectura="helpers.estado > 1"
            />



        </div>
    </div>
</div>
@endsection

@push('customScripts')
<script type="text/javascript" src="{{ mix('js/vue-pages/app-tanque.js') }}"></script>
@endpush
