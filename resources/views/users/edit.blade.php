@extends('layouts.admin-template')
@section('title', 'Editar usuario')

@push('customStyles')
    
@endpush

@section('content')
<div id="appEditUser" class="sa-app__body px-2 px-lg-4">
    <div class="container my-4">
        <!--HERE INIT CONTENT SECTION-->
        <nav class="sa-article__breadcrumb mb-6" aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-sa-simple">
                <li class="breadcrumb-item">
                    <a href="{{route('usuarios.list')}}">Usuarios</a>
                </li>
                <li href="{{route('usuarios.create')}}" class="breadcrumb-item active" aria-current="page">Editar usuario</li>
            </ol>
        </nav> 

        <div class=""> 
            <div class="py-5">
                <div class="row g-4 align-items-center">
                    <div class="col">
                        
                    </div>
                        
                    <div class="col-auto d-flex">
                        <a href="{{route('usuarios.list')}}" class="btn btn-primary">Regresar</a>
                    </div>
                </div>
            </div>
            
            <edit-user :user="{{$user}}" :permissions="{{$permissions}}" :rol_user="{{$rol_user}}" :roles='{!! json_encode($roles) !!}' :users='{!! json_encode($users) !!}'></edit-user>
        </div>            
    </div>
        
<div>
        <!--HERE MODALS-->
  
        <!--HERE END MODALS-->  

        <!--HERE END CONTENT SECTION-->

@endsection

@push('customScripts')
<script  type="text/javascript" src="{{ mix('js/admin/app-edituser.js') }}"></script>
@endpush