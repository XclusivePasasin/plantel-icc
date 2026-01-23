@extends('layouts.admin-template')
@section('title', 'Estados')

@push('customStyles')
    
@endpush

@section('content')
<div id="appMixStatus" class="sa-app__body px-2 px-lg-4">
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

        <seach-order  title="Estados mezcla" :aorders="{{$aorders}}" typeorder="mix" v-if="flags.F1" @load-order="loadOrder"></seach-order>
        <div class="d-none" id="parentWrappen">
            <div v-for="info of item" class="sa-article__container container container--max--md">
                <div class="card">
                    <div class="card-body">
                        <div class="row border-bottom pb-3 pt-3">
                            <div class="col-12 col-md-6">
                                <div class="card">
                                    <div class="card-body d-flex align-items-center justify-content-between pb-0 pt-4">
                                        <h2 class="fs-exact-17 mb-0">Orden de Mezcla (Principal)</h2>
                                        <a v-if="has_cap('cap-materiaprima') || has_cap('cap-supcalidad') || has_cap('cap-mezcla')" href="{{route('mix.load')}}" class="fs-exact-14">Verificar</a>
                                    </div>
                                    <div class="card-body d-flex align-items-center pt-4">
                                        <div :class="{'leaf-warning': !info.master.complete, 'leaf-success': info.master.complete}">
                                            <i class="bi bi-file-earmark-ruled"></i>                            
                                        </div>
                                        <div class="ms-3 ps-2">
                                            <div class="fs-exact-13 text-muted">Estado de hoja</div>
                                            <div class="fs-exact-14 fw-medium">@{{info.master.complete === true ? 'Completado' : 'Incompleto'}} </div>
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
                                        <h2 class="fs-exact-17 mb-0">Granel</h2>
                                        <a v-if="has_cap('cap-mezcla')" href="{{route('admin.addgranel')}}" class="fs-exact-14">Verificar</a>
                                    </div>
                                    <div class="card-body d-flex align-items-center pt-4">
                                        <div :class="{'leaf-warning': !info.granel.complete, 'leaf-success': info.granel.complete}">
                                            <i class="bi bi-file-earmark-ruled"></i>                            
                                        </div>
                                        <div class="ms-3 ps-2">
                                            <div class="fs-exact-13 text-muted">Estado de hoja</div>
                                            <div class="fs-exact-14 fw-medium">@{{info.granel.complete === true ? 'Completado' : 'Incompleto'}}</div>
                                        </div>
                                    </div>
                                </div>                        
                            </div>
                            <div class="col-12 col-md-6">
                            <span v-html="info.granel.msgs"></span>               
                            </div>                    
                        </div>

                    <div class="row border-bottom pb-3 pt-3">
                        <div class="col-12 col-md-6">
                            <div class="card">
                                <div class="card-body d-flex align-items-center justify-content-between pb-0 pt-4">
                                    <h2 class="fs-exact-17 mb-0">Control de Producto</h2>
                                    <a v-if="has_cap('cap-supcalidad') || has_cap('cap-calidad')" href="{{ route('admin.controlproducto') }}" class="fs-exact-14">Verificar</a>
                                </div>
                                <div class="card-body d-flex align-items-center pt-4">
                                    <div :class="{'leaf-warning': !info.control_producto.complete, 'leaf-success': info.control_producto.complete}">
                                        <i class="bi bi-file-earmark-ruled"></i>
                                    </div>
                                    <div class="ms-3 ps-2">
                                        <div class="fs-exact-13 text-muted">Estado de hoja</div>
                                        <div class="fs-exact-17 fw-medium">@{{ info.control_producto.complete === true ? 'Completado' : 'Incompleto' }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <span v-html="info.control_producto.msgs"></span>
                        </div>
                    </div>

                        <div class="row border-bottom pb-3 pt-3">
                            <div class="col-12 col-md-6">
                                <div class="card">
                                    <div class="card-body d-flex align-items-center justify-content-between pb-0 pt-4">
                                        <h2 class="fs-exact-17 mb-0">Análisis de agua </h2>
                                        <a v-if="has_cap('cap-supcalidad') || has_cap('cap-calidad') || has_cap('cap-mezcla')" href="{{route('admin.anagua')}}" class="fs-exact-14">Verificar</a>
                                    </div>
                                    <div class="card-body d-flex align-items-center pt-4">
                                        <div :class="{'leaf-warning': !info.water.complete, 'leaf-success': info.water.complete}">
                                            <i class="bi bi-file-earmark-ruled"></i>                            
                                        </div>
                                        <div class="ms-3 ps-2">
                                            <div class="fs-exact-13 text-muted">Estado de hoja</div>
                                            <div class="fs-exact-17 fw-medium">@{{info.water.complete === true ? 'Completado' : 'Incompleto'}}</div>
                                        </div>
                                    </div>
                                </div>                         
                            </div>
                            <div class="col-12 col-md-6">
                                <span v-html="info.water.msgs"></span>     
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
    <script  type="text/javascript" src="{{ mix('js/admin/app-mix-status.js') }}"></script>
@endpush

