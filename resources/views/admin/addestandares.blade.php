@extends('layouts.admin-template')
@section('title', 'Estándares de Calidad')

@push('customStyles')

@endpush

@section('content')
<div id="estandaresLoader" class="sa-app__body px-2 px-lg-4">
    <div class="container pb-6">
        <!--HERE INIT CONTENT SECTION-->
        <nav class="sa-article__breadcrumb mb-6" aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-sa-simple">
                <li class="breadcrumb-item">
                    <a href="{{route('admin.home')}}">Inicio</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">{{$page_title}}</li>
            </ol>
        </nav>

        <div class="">
            <seach-order title="Estandares" :aorders="{{$aorders}}" typeorder="packing" v-if="panels.p1" @load-order="loadEstandares"></seach-order>
            <div v-else class="row">
                <estandares :source="order"></estandares>
            </div>

            <div class="row d-none" id="pnlSecondary" v-if="order.length == 0">
                <div class="col-lg-6 mx-auto">
                    <div class="row mb-2" v-for="vi_estandar in listEstandares" :key="vi_estandar.seccion + vi_estandar.turno">
                        <div class="col-12">
                            <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">@{{ vi_estandar.seccion}} Columnas Verificadas | Turno @{{ vi_estandar.turno}}</h5>
                                <p class="card-text">Hoja de Estadares de calidad, Creado @{{ vi_estandar.created_at}}</p>
                                <button class="btn btn-primary" @click="cargarEstandar(vi_estandar.id)">Cargar Hoja</button>
                            </div>
                            </div>
                        </div>
                    </div>
                    <div class="row" v-if="has_cap('cap-produccion')">
                        <div class="col-12">
                            <button class="btn btn-success mt-3" @click="crearNuevoEstandar">+ Agregar hoja</button>
                        </div>
                    </div>
                </div>
            </dvi>
        </div>

        <!--HERE MODALS-->

        <!--HERE END MODALS-->

        <!--HERE END CONTENT SECTION-->
    </div>
</div>
@endsection

@push('customScripts')
    <script  type="text/javascript" src="{{ mix('js/admin/app-addestandares.js') }}"></script>
@endpush

