<!DOCTYPE html>
<html lang="es" class="fontawesome-i2svg-active fontawesome-i2svg-complete" dir="ltr" data-scompiler-id="0">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') | Unilever</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">    
    <link href="{{ asset('assets/css/simplebar.min.css') }}" rel="stylesheet">  
    <link href="{{ asset('assets/css/bootstrap.ltr.css') }}" rel="stylesheet">    
    <link href="{{ asset('assets/css/stroyka_style.css') }}" rel="stylesheet">  
    <script>

        @auth //Usuario logeado
            window.AppVars = {!! json_encode([
                'csrfToken' => csrf_token(), // token 
                'permissions' => Auth::user()->caps, 
                'base_url' => url('/'), //URL BASE 
                'storage_url' => url('/files'), //URL BASE 
                'full_url' => url()->full(),
                'current_url' => url()->current(),
                "current_user" => [
                    "id" => Auth::user()->id,
                    "email" => Auth::user()->email,
                    "id_foreign" => session()->get('user_cur_id'),
                    "user_fullname" => session()->get('user_cur_fullname')
                ]
            ]) !!};
        @endauth            

        window.has_cap = function(cap){
            let status_cap = false;
            if(window.AppVars.permissions == undefined){
                return false;
            }
            
            for(let val of window.AppVars.permissions){
                if(val === cap){
                    return !status_cap;
                }
            }
            return status_cap;
        }        
        
    </script>
    <!--For custom user styles-->
    @stack('customStyles')
</head>

<body>

    <div class="sa-app sa-app--mobile-sidebar-hidden sa-app--toolbar-fixed sa-app--desktop-sidebar-shown"
        style="--sa-footer-visible-height: 0px;">
        @include('layouts.components.admin-aside')
        <div class="sa-app__content">
            @include('layouts.components.admin-navbar')
            @yield('content')
        </div>
        <div class="sa-app__toasts toast-container bottom-0 end-0">

        </div>
    </div>

    <script src="{{ asset('js/app.js') }}"></script>    
    <script src="{{ asset('assets/js/simplebar.min.js') }}" ></script>    
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}" ></script>    
    <script src="{{ asset('assets/js/stroyka.js') }}" ></script>    
    @stack('customScripts')

</body>

</html>