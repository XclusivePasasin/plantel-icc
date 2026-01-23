<!DOCTYPE html>
<html dir="ltr" data-scompiler-id="0" lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">    
    <title>:.: Login</title>
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">    
    <link href="{{ asset('assets/css/bootstrap.ltr.css') }}" rel="stylesheet">    
    <link href="{{ asset('assets/css/stroyka_style.css') }}" rel="stylesheet">    
</head>
<body style="background-color: #e2dfdf !important;">
    <div class="min-h-100 p-0 p-sm-6 d-flex align-items-stretch">
        <form class="card w-25x flex-grow-1 flex-sm-grow-0 m-sm-auto" method="POST" action="{{route('login')}}">
            @csrf
            <div class="card-body p-sm-5 m-sm-3 flex-grow-0">
                <img style="display: block;width: 100%;" src="{{asset('images/logo-icc.png')}}" alt="">
                <h1 class="mb-0 mt-6 fs-3">Iniciar sesión</h1>
                <div class="fs-exact-14 text-muted mt-2 pt-1 mb-5 pb-2">Inicie sesión con su cuenta para poder continuar </div>

                <div class="mb-4">
                    <label class="form-label">Correo electrónico</label>
                    <input type="text" name="email" class="form-control form-control-lg @error('email') is-invalid @enderror" value="{{old('email')}}" id="txtUsername">
                    @error('email')
                    <span class="invalid-feedback" role="alert" style="display: block !important;">
                        <strong>{{$message}}</strong>
                    </span>
                    @enderror
                </div>
                    
                <div class="mb-4">
                    <label class="form-label">Clave de acceso</label>
                    <input type="password" name="password" class="form-control form-control-lg @error('password') is-invalid @enderror" id="txtPassword">
                    @error('no_match')
                    <span class="invalid-feedback" role="alert" style="display: block !important;">
                        <strong>{{$message}}</strong>
                    </span>                    
                    @enderror

                    @error('inactive_user')
                    <span class="invalid-feedback" role="alert" style="display: block !important; text-align:center;">
                        <strong>{{$message}}</strong>
                    </span>                    
                    @enderror
                </div>

                <div>
                    <button type="submit" class="btn btn-primary btn-lg w-100">
                        Continuar
                        <i class="bi bi-box-arrow-in-right"></i>
                    </button>
                </div>
            </div>        
        </form>
    </div>
    <!-- Scripts -->

    <script src="{{ asset('js/app.js') }}" defer></script>    
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}" defer></script>    
    <script src="{{ asset('assets/js/stroyka.js') }}" defer></script>    
</body>
</html>