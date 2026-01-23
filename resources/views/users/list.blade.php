@extends('layouts.admin-template')
@section('title', 'Usuarios')

@push('customStyles')
    
@endpush

@section('content')
<div id="appListUser" class="sa-app__body px-2 px-lg-4">
    <div class="container my-4">
        <!--HERE INIT CONTENT SECTION-->
        <nav class="sa-article__breadcrumb mb-6" aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-sa-simple">
                <li class="breadcrumb-item">
                    <a href="{{route('usuarios.list')}}">Usuarios</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">{{$page_title}}</li>
            </ol>
        </nav> 

        <div class=""> 
            <div class="py-5">
                <div class="row g-4 align-items-center">
                    <div class="col">
                        <h1 class="h3 m-0">Usuarios</h1>
                    </div>
                        
                    <div class="col-auto d-flex">
                        <a href="{{route('usuarios.create')}}" class="btn btn-primary">Nuevo usuario</a>
                    </div>
                </div>
            </div>
                
            <div class="card">
                <h5 class="card-header text-center">
                    GESTIÓN DE USUARIOS
                    <p class="text-center m-0">Listado</p>
                </h5>
            
                <div class="container">    
                    <list-user></list-user>
                </div>
            </div>
        </div>            
    </div>    
<div>
        <!--HERE MODALS-->
  
        <!--HERE END MODALS-->  

        <!--HERE END CONTENT SECTION-->

@endsection

@push('customScripts')
    <script  type="text/javascript" src="{{ mix('js/admin/app-listuser.js') }}"></script>
@endpush