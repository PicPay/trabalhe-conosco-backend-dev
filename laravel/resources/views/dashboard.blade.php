<link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<!------ Include the above in your HEAD tag ---------->

<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" type="text/css" rel="stylesheet">
<link rel="stylesheet" href="/css/dashboard.css">

<div id="top-nav" class="navbar navbar-default navbar-static-top">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand" href="/dashboard"><img src="https://logodownload.org/wp-content/uploads/2018/05/picpay-logo.png" height="50px"></a>

            <div class="navbar-brand navbar-right logout-div">
                <a class="logout-link" href="/logout">Logout</a></li>
            </div>
        </div>





    </div>
    <!-- /container -->
</div>

<!-- /Header -->

<!-- Main -->

<div class="col-lg-2 col-md-2 col-sm-3 col-xs-12">

    <ul class="nav nav-pills nav-stacked" >
        <!--<li class="nav-header"></li>-->
        <li><h1><a class="btn btn-success btn-lg btn-block" href="/search/search_user">Search a User</a></h1></li>
        <li><h1><a class="btn btn-success btn-lg btn-block" href="/list/list_management">List Management</a></h1></li>


    </ul>
</div><!-- /span-3 -->
<div class="col-lg-10 col-md-10 col-sm-9 col-xs-12">
    <!-- Right -->
    <div class="jumbotron">
        <div class="card">
            <div class="card-body">
                <h1 class="card-title text-center">Welcome to the Dashboard</h1>
                <p class="card-text">This is our UI for the search and list management</p>
                <p class="card-text">to use the API dont forget to put in the header your token</p>
                <p class="card-text">Token: <span style="word-wrap:break-word;"><b>{{ $name }}</b></span></p>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-6">
                <div class="card">
                    <div class="card-body text-center">
                        <h3 class="card-title">Search a User</h3>
                        <p class="card-text">Search a User by inserting ID, Name of Username, you will be able to find all resulting matches ordered by their score.</p>
                        <a href="/search/search_user" class="btn btn-success btn-lg">Search a User</a>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="card">
                    <div class="card-body text-center">
                        <h3 class="card-title">List Management</h3>
                        <p class="card-text">Management of Primary and Secondary list of user relevance, it also constains a major list and a sync feature.</p>
                        <a href="/list/list_management" class="btn btn-success btn-lg">List Management</a>

                    </div>
                </div>
            </div>
        </div>
    </div>



</div>
