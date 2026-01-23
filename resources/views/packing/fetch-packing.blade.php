@extends('layouts.admin-template')
@section('title', 'Ordem Empaquetado')

@push('customStyles')

@endpush

@section('content')
<div id="appPackingFetch" class="sa-app__body px-2 px-lg-4">
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

        <seach-order  title="Pesaje" :aorders="{{$aorders}}" typeorder="packing" v-if="flags.F1" @load-order="loadOrder"></seach-order>
        <div v-else >
            <packing v-for="(e,index) of order" :source="e" :key="e.order_id"></packing>
        </div>

        <!--HERE MODALS-->
        <!--HERE END MODALS-->

        <!--HERE END CONTENT SECTION-->
    </div>
</div>
@endsection

@push('customScripts')
    <script  type="text/javascript" src="{{ mix('js/admin/app-fetchpacking.js') }}"></script>
@endpush

