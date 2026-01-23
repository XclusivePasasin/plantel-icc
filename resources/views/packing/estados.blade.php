@extends('layouts.admin-template')
@section('title', 'Estados')

@push('customStyles')
    
@endpush

@section('content')
<div id="appPackingStatus" class="sa-app__body px-2 px-lg-4">
    <div class="container my-4">
        <!--HERE INIT CONTENT SECTION-->
        <nav class="sa-article__breadcrumb mb-6" aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-sa-simple">
                <li class="breadcrumb-item">
                    <a href="{{route('admin.home')}}">Inicio</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">{{$page_title}}</li>
            </ol>
        </nav>   
        
        
        <seach-order  title="Estados empaque" :aorders="{{$aorders}}" typeorder="packing" v-if="flags.F1" @load-order="loadOrder"></seach-order>
        <div class="d-none" id="parentWrappen">
            <div v-for="info of item" class="sa-article__container container container--max--md">
                <div class="card">
                    <div class="card-body">
                        <div class="row border-bottom pb-3 pt-3">
                            <div class="col-12 col-md-6">
                                <div class="card">
                                    <div class="card-body d-flex align-items-center justify-content-between pb-0 pt-4">
                                        <h2 class="fs-exact-16 mb-0">Orden de Empaque (Principal)</h2>
                                    </div>
                                    <div class="card-body d-flex align-items-center pt-4">
                                        <div :class="{'leaf-warning': !info.master.complete, 'leaf-success': info.master.complete}">
                                            <i class="bi bi-file-earmark-ruled"></i>                            
                                        </div>
                                        <div class="ms-3 ps-2">
                                            <div class="fs-exact-13 text-muted">Estado de hoja</div>
                                            <div class="fs-exact-14 fw-medium">Completado</div>
                                        </div>
                                    </div>
                                </div>                         
                            </div>
                            <div class="col-12 col-md-6">
                                <span v-html="info.master.msgs"></span>                        
                            </div>                    
                        </div>
                        <div class="row border-bottom pb-3 pt-3">
                            <div class="col-12 col-md-6">
                                <div class="card">
                                    <div class="card-body d-flex align-items-center justify-content-between pb-0 pt-4">
                                        <h2 class="fs-exact-16 mb-0">Estándares de Calidad</h2>
                                    </div>
                                    <div class="card-body d-flex align-items-center pt-4">
                                        <div :class="{'leaf-warning': !info.estandares.complete, 'leaf-success': info.estandares.complete}">
                                            <i class="bi bi-file-earmark-ruled"></i>                            
                                        </div>
                                        <div class="ms-3 ps-2">
                                            <div class="fs-exact-13 text-muted">Estado de hoja</div>
                                            <div class="fs-exact-14 fw-medium">@{{info.estandares.complete === true ? 'Completado' : 'Incompleto'}}</div>
                                        </div>
                                    </div>
                                </div>                        
                            </div>
                            <div class="col-12 col-md-6">
                                <span v-html="info.estandares.msgs"></span>                        
                            </div>                    
                        </div>
                        <div class="row border-bottom pb-3 pt-3">
                            <div class="col-12 col-md-6">
                                <div class="card">
                                    <div class="card-body d-flex align-items-center justify-content-between pb-0 pt-4">
                                        <h2 class="fs-exact-16 mb-0">Control en Proceso</h2>
                                        <a href="#" class="fs-exact-14">Verificar</a>
                                    </div>
                                    <div class="card-body d-flex align-items-center pt-4">
                                        <div :class="{'leaf-warning': !info.controles.complete, 'leaf-success': info.controles.complete}">
                                            <i class="bi bi-file-earmark-ruled"></i>                            
                                        </div>
                                        <div class="ms-3 ps-2">
                                            <div class="fs-exact-13 text-muted">Estado de hoja</div>
                                            <div class="fs-exact-17 fw-medium">@{{info.controles.complete === true ? 'Completado' : 'Incompleto'}}</div>
                                        </div>
                                    </div>
                                </div>                         
                            </div>
                            <div class="col-12 col-md-6">
                                <span v-html="info.controles.msgs"></span>                        
                            </div>                    
                        </div>
                        <div class="row border-bottom pb-3 pt-3">
                            <div class="col-12 col-md-6">
                                <div class="card">
                                    <div class="card-body d-flex align-items-center justify-content-between pb-0 pt-4">
                                        <h2 class="fs-exact-16 mb-0">Inspecciones</h2>
                                        <a href="#" class="fs-exact-14">Verificar</a>
                                    </div>
                                    <div class="card-body d-flex align-items-center pt-4">
                                        <div :class="{'leaf-warning': !info.inspecciones.complete, 'leaf-success': info.inspecciones.complete}">
                                            <i class="bi bi-file-earmark-ruled"></i>                            
                                        </div>
                                        <div class="ms-3 ps-2">
                                            <div class="fs-exact-13 text-muted">Estado de hoja</div>
                                            <div class="fs-exact-17 fw-medium">@{{info.inspecciones.complete === true ? 'Completado' : 'Incompleto'}}</div>
                                        </div>
                                    </div>
                                </div>                         
                            </div>
                            <div class="col-12 col-md-6">
                                <span v-html="info.inspecciones.msgs"></span>                        
                            </div>                    
                        </div>
                                                                                    
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
    <script  type="text/javascript" src="{{ mix('js/admin/app-packing-status.js') }}"></script>
@endpush

