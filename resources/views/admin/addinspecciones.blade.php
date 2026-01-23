@extends('layouts.admin-template')
@section('title', 'Inspección en proceso')

@push('customStyles')
    
@endpush

@section('content')
<div id="inspeccionesLoader" class="sa-app__body px-2 px-lg-4">
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
            <seach-order title="inspecciones" :aorders="{{$aorders}}" typeorder="packing" v-if="panels.p1" @load-order="loadInspecciones"></seach-order>
            <div v-else class="row">
                <inspecciones :source="order"></inspecciones>
            </div>           
        </div>

        <!--HERE MODALS-->

        <!--HERE END MODALS-->  

        <!--HERE END CONTENT SECTION-->
    </div>
</div>
@endsection

@push('customScripts')
    <script  type="text/javascript" src="{{ mix('js/admin/app-addinspecciones.js') }}"></script>
@endpush

