<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>DevPHP - PicPay</title>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">
    
    <link href="theme/plugins/bootstrap/css/bootstrap.css" rel="stylesheet">
    <link href="theme/plugins/node-waves/waves.css" rel="stylesheet" />
    <link href="theme/plugins/animate-css/animate.css" rel="stylesheet" />
    <link href="theme/css/style.css" rel="stylesheet">
    <link href="theme/css/themes/all-themes.css" rel="stylesheet" />

</head>

<body class="login-page">
    <div class="login-box">
        <div class="logo">
            <a href="javascript:void(0);">Picpay<b>DevPHP</b></a>
            <small>Vinícius Gusmão</small>
        </div>
        <div class="card">
            <div class="body">
                <form method="POST" action="{{ route('login') }}">
                        @csrf
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="material-icons">mail</i>
                        </span>
                        <div class="form-line">
                            <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" placeholder="E-mail" required autofocus>
                 
                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif

                        </div>
                    </div>
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="material-icons">lock</i>
                        </span>
                        <div class="form-line">
                            <input id="password" placeholder="Senha" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>
                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-8 p-t-5">
                        </div>
                        <div class="col-xs-4">
            <button type="submit" class="btn btn-block bg-light-green waves-effect">
                                    {{ __('Login') }}
                                </button>
                            
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <script src="theme/plugins/jquery/jquery.min.js"></script>
    <script src="theme/plugins/bootstrap/js/bootstrap.js"></script>
    <script src="theme/plugins/node-waves/waves.js"></script>
    
    <script src="theme/plugins/jquery-validation/jquery.validate.js"></script>
    <script src="theme/js/admin.js"></script>
    <script src="theme/js/pages/examples/sign-in.js"></script>

</html>
