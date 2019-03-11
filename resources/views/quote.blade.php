<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SearchBlox Search Box</title>

    <!-- Bootstrap -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
<style>
    .custom-search-form{
        margin-top:5px;
    }
</style>
<div class="container">
    <div class="row">
        <div class="col-lg-3">


            <!-- Update the searchblox server location below in the action field-->
            <!-- Change the action to http://localhost:8080/searchblox/plugin/index.html shown below if you want faceted search results -->
            <!-- <form action="http://localhost:8080/searchblox/plugin/index.html" method="get"> -->
            <form action="http://192.168.1.40:8000/api/v1/user/elasticSearch/rovaron" method="get">

                <!--To add search parameter use the syntax as in the line below-->

                <!--<input type="hidden" name="col" value="2">-->

                <div class="input-group custom-search-form">
                    <input type="text" class="form-control" name="query" value="">
                    <span class="input-group-btn">
<button class="btn btn-default" type="search">
<span class="glyphicon glyphicon-search"></span>
</button>
</span>

                    </span>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>