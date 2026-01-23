@extends('layouts.admin-template')
@section('title', 'Aprobar')

@push('customStyles')

@endpush

@section('content')
<div id="appApprove" class="sa-app__body px-2 px-lg-4">
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

        <seach-order title="Aprobar pesaje" :aorders="{{$aorders}}" typeorder="mix" v-if="panels.p1" @load-order="loadOrder"></seach-order>
        <div v-else>
            <mixorder v-for="(e,index) of order" :source="e"></mixorder>
        </div>

        <!--HERE MODALS-->

        <!--HERE END MODALS-->

        <!--HERE END CONTENT SECTION-->
    </div>
</div>
@endsection

@push('customScripts')
    <script  type="text/javascript" src="{{ mix('js/admin/app-pesaje-approve.js') }}"></script>
    {{-- <script>
        window.AppVars = {
            current_user: {
                role: "{{ session('role_cur_user') }}" // Por ejemplo, 'SupCalidad'
            }
        };
    </script> --}}
@endpush

