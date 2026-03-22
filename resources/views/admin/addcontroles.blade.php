@extends('layouts.admin-template')
@section('title', 'Controles en Proceso')

@push('customStyles')
    <!-- Aquí puedes agregar estilos personalizados si es necesario -->
@endpush

@section('content')
<div id="controlesLoader" class="sa-app__body px-2 px-lg-4">
    <div class="container pb-6">
        <!--HERE INIT CONTENT SECTION-->
        <nav class="sa-article__breadcrumb mb-6" aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-sa-simple">
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.home') }}">Inicio</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">{{ $page_title }}</li>
            </ol>
        </nav>

        <div class="">
            <seach-order title="Controles" :aorders="{{$aorders}}" typeorder="packing" v-if="panels.p1" @load-order="loadControles"></seach-order>
            <div v-else class="row">
                <controles :source="order"></controles>
            </div>

                <div class="row d-none" id="pnlSecondary" v-if="order.length == 0">
                    <div class="col-lg-6 mx-auto">
                        <div class="row mb-2" v-for="vi_control in listControles" :key="vi_control.seccion + vi_control.turno">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <!-- <h5 class="card-title">@{{ vi_control.seccion }} Columnas Verificadas | Turno @{{ vi_control.turno }}</h5> -->
                                        <h5 class="card-title">@{{ vi_control.seccion }} Columnas Verificadas</h5>
                                        <p class="card-text">Hoja de Control de Procesos, Creado @{{ vi_control.created_at }}</p>
                                        <button class="btn btn-primary" @click="cargarControl(vi_control.id)">Cargar Hoja</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row" v-if="has_cap('cap-produccion')">
                            <div class="col-12">
                                <button class="btn btn-success mt-3" @click="crearNuevoControl">+Agregar hoja</button>
                            </div>
                        </div>
                    </div>
                </div>

        <!--HERE MODALS-->

        <!--HERE END MODALS-->

        <!--HERE END CONTENT SECTION-->
    </div>
</div>
@endsection

@push('customScripts')
    <script type="text/javascript" src="{{ mix('js/admin/app-addcontroles.js') }}"></script>
@endpush
