<!DOCTYPE html>
<html>
<head>
    <title>Simple Login System in Laravel</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <style type="text/css">
        body{
            background-color:#ffffff;
        }
        .modal-content{
            background-color:#ffffff;
            color: #21c25e;
        }

        .info img{
            display:block;
            margin:auto;
            min-height: 100px;
            position:relative;
            max-width: 100%;
            height: auto;
            width: auto
        }

        .wrapper{
            margin-top: 10vh;
        }
    </style>
</head>
<body>
<br />
<div class="container">
    <div class="modal-dialog" style="margin-bottom:0">
        <div class="modal-content">
            <div class="panel-heading"><h1 class=" text-center"><strong>Login </strong></h1></div>
            <div class="panel-body">

                @if(isset(Auth::user()->email))
                <script>window.location="dashboard";</script>
                @endif

                @if ($message = Session::get('error'))
                <div class="alert alert-danger alert-block">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <strong>{{ $message }}</strong>
                </div>
                @endif

                @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <ul>
                        @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <form method="post" action="{{ url('/checklogin') }}">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label>Enter Email</label>
                        <input type="email" name="email" class="form-control" />
                    </div>
                    <div class="form-group">
                        <label>Enter Password</label>
                        <input type="password" name="password" class="form-control" />
                    </div>
                    <div class="form-group align-content-center">
                        <input type="submit" name="login" class="btn btn-success btn-block btn-lg" value="Login" />
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="wrapper in">
    <div class="info">
        <img src="https://www.picpay.com/static/images/kb-method-n1.png">
    </div>
</div>

</body>
</html>
