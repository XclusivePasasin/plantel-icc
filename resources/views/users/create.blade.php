@extends('layouts.admin-template')
@section('title', 'Agregar usuario')

@push('customStyles')
    
@endpush

@section('content')
<div id="appCreateUser" class="sa-app__body px-2 px-lg-4">
    <div class="container my-4">
        <!--HERE INIT CONTENT SECTION-->
        <nav class="sa-article__breadcrumb mb-6" aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-sa-simple">
                <li class="breadcrumb-item">
                    <a href="{{route('usuarios.list')}}">Usuarios</a>
                </li>
                <li href="{{route('usuarios.create')}}" class="breadcrumb-item active" aria-current="page">Agregar usuario</li>
            </ol>
        </nav> 

        <div class=""> 
            <div class="py-5">
                <div class="row g-4 align-items-center">
                    <div class="col">
                        <h1 class="h3 m-0">Usuarios</h1>
                    </div>
                        
                    <div class="col-auto d-flex">
                        <a href="{{route('usuarios.list')}}" class="btn btn-primary">Regresar</a>
                    </div>
                </div>
            </div>
                
            <div class="card">
                <h5 class="card-header text-center">
                    AGREGAR 
                    <p class="text-center m-0">Usuario</p>
                </h5>

                <div class="container">
                    <p class="py-4" style="text-align:center;">Complete los campos del formulario.</p>
        
                    <div class="offset-1 col-10 offset-2">
                        <create-user :roles='{!! json_encode($roles) !!}' :users='{!! json_encode($users) !!}'></create-user>
                    </div> 
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
    <script  type="text/javascript" src="{{ mix('js/admin/app-createuser.js') }}"></script>
@endpush