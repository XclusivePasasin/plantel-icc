@extends('layouts.admin-template')
@section('title', 'Inicio')

@push('customStyles')
    
@endpush

@section('content')
<div id="appHome" class="sa-app__body px-2 px-lg-4">
    <div class="container my-4 container--max--xl">
        <!--HERE INIT CONTENT SECTION-->
        <nav class="sa-article__breadcrumb mb-6" aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-sa-simple">
                <li class="breadcrumb-item">
                    <a href="{{route('admin.home')}}">Inicio</a>
                </li>
            </ol>
        </nav>

        <div class="row g-4">
                <div class="col-6 col-md-4 col-lg-3">
                    <div class="card text-center">
                        <a  href="{{route('admin.home',['page_pass' => 'Panel Principal'])}}" class="text-reset p-5 text-decoration-none sa-hover-area">
                            <div class="fs-4 mb-4 text-muted opacity-50">
                            <i class="bi bi-file-earmark-spreadsheet"></i>
                            </div>
                            <h2 class="fs-6 fw-medium mb-3">Inicio</h2>
                            <div class="text-muted fs-exact-14">
                                ...
                            </div>
                        </a>
                    </div>
                </div>

                <div class="col-6 col-md-4 col-lg-3">
                    <div class="card text-center">
                        <a  href="{{route('mix.status',['page_pass' => 'Estados mezcla'])}}" class="text-reset p-5 text-decoration-none sa-hover-area">
                            <div class="fs-4 mb-4 text-muted opacity-50">
                            <i class="bi bi-file-earmark-spreadsheet"></i>
                            </div>
                            <h2 class="fs-6 fw-medium mb-3">Estados mezcla</h2>
                            <div class="text-muted fs-exact-14">
                                ...
                            </div>
                        </a>
                    </div>
                </div>
                
                <div class="col-6 col-md-4 col-lg-3">
                    <div class="card text-center">
                        <a  href="{{route('packing.status',['page_pass' => 'Estados empaque'])}}" class="text-reset p-5 text-decoration-none sa-hover-area">
                            <div class="fs-4 mb-4 text-muted opacity-50">
                            <i class="bi bi-file-earmark-spreadsheet"></i>
                            </div>
                            <h2 class="fs-6 fw-medium mb-3">Estados empaque</h2>
                            <div class="text-muted fs-exact-14">
                                ...
                            </div>
                        </a>
                    </div>
                </div>                
            @foreach(Session::get('main_menu') as $ite_menu)
                <div class="col-6 col-md-4 col-lg-3">
                    <div class="card text-center">
                        <a  href="{{route($ite_menu->path,['page_pass' => $ite_menu->menu])}}" class="text-reset p-5 text-decoration-none sa-hover-area">
                            <div class="fs-4 mb-4 text-muted opacity-50">
                            <i class="{{$ite_menu->icon}}"></i>
                            </div>
                            <h2 class="fs-6 fw-medium mb-3">{{$ite_menu->menu}}</h2>
                            <div class="text-muted fs-exact-14">
                                ...
                            </div>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

        <!--HERE MODALS-->
        <!--HERE END MODALS-->  

        <!--HERE END CONTENT SECTION-->
    </div>
</div>
@endsection

@push('customScripts')

@endpush

