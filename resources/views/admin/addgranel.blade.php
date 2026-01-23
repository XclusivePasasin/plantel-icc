@extends('layouts.admin-template')
@section('title', 'Granel')

@push('customStyles')

@endpush

@section('content')
<div id="granelLoader" class="sa-app__body px-2 px-lg-4">
    <div class="container pb-6">
        <br>
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
            <seach-order title="Granel" :aorders="{{$aorders}}" typeorder="mix" v-if="panels.p1" @load-order="loadGranel"></seach-order>
            <div v-else class="row">
               <!-- Pasar los datos del usuario autenticado al componente 'granel' -->
               <granel :source="order" :user-data='@json(auth()->user())'></granel>
            </div>
        </div>

        <!--HERE MODALS-->

        <!--HERE END MODALS-->

        <!--HERE END CONTENT SECTION-->
    </div>
</div>
@endsection

@push('customScripts')
    <script  type="text/javascript" src="{{ mix('js/admin/app-addgranel.js') }}"></script>
@endpush

