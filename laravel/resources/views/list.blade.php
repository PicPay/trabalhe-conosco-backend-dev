<link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>


<link href="//cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css"/>
<script href="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>


<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

<!-- Latest compiled and minified JavaScript -->
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


        <ul class="nav nav-tabs">
            <li class="active"><a data-toggle="tab" href="#home">List</a></li>
            <li><a data-toggle="tab" href="#menu1">Major List</a></li>
        </ul>

        <div class="tab-content">
            <div id="home" class="tab-pane fade in active">
                <div class="row">
                    <div class="col-md-8">
                        <h3>List Management</h3>
                        <p>The first list adds a score of 2 for each user on it, and the Secondary list adds a Score of 1 for each user on it, add or remove users in order to make them relevant.</p>
                    </div>

                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="panel panel-default">
                            <!-- Default panel contents -->
                            <div class="panel-heading">
                                First List
                                <div class="pull-right">
                                    <button class="add-modal btn btn-success" data-info="first_list"
                                        <span class="glyphicon glyphicon-trash"></span> Add
                                    </button>
                                </div>
                            </div>


                            <!-- Table -->
                            <table class="table">
                                <thead>
                                    <th>Token</th>
                                    <th>Name</th>
                                    <th>Username</th>
                                    <th>Actions</th>
                                </thead>
                                <tbody>

                                @foreach ($first_list['data'] as $value)
                                <tr>
                                    <td>{{ $value->token }}</td>
                                    <td>{{ $value->name }}</td>
                                    <td>{{ $value->username }}</td>
                                    <td><button class="delete-modal btn btn-danger"
                                                data-token="{{$value->token}}" data-name="{{$value->name}}" data-username="{{$value->username}}" data-table="first_table">
                                            <span class="glyphicon glyphicon-trash"></span> Delete
                                        </button></td>
                                </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <nav aria-label="pages">
                                <ul class="pagination">
                                    <li class="disabled"><a href="#" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li>
                                    <li class="active"><a href="#">1 <span class="sr-only">(current)</span></a></li>
                                    <li class=""><a href="#">2 <span class="sr-only">(current)</span></a></li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="panel panel-default">
                            <!-- Default panel contents -->
                            <div class="panel-heading">
                                Secondary List
                                <div class="pull-right">
                                    <button class="add-modal btn btn-success" data-info="secondary_list"
                                    <span class="glyphicon glyphicon-trash"></span> Add
                                    </button>
                                </div>
                            </div>

                            <!-- Table -->
                            <table class="table secondary-table">
                                <thead>
                                    <th>Token</th>
                                    <th>Name</th>
                                    <th>Username</th>
                                    <th>Actions</th>
                                </thead>
                                <tbody>
                                @foreach ($secondary_list['data'] as $value)
                                <tr>
                                    <td>{{ $value->token }}</td>
                                    <td>{{ $value->name }}</td>
                                    <td>{{ $value->username }}</td>
                                    <td><button class="delete-modal btn btn-danger"
                                                data-token="{{$value->token}}" data-name="{{$value->name}}" data-username="{{$value->username}}" data-table="secondary_table">
                                            <span class="glyphicon glyphicon-trash"></span> Delete
                                        </button></td>
                                </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <nav aria-label="pages">
                                <ul class="pagination">
                                    <li class="disabled"><a href="#" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li>
                                    <li class="active"><a href="#">1 <span class="sr-only">(current)</span></a></li>
                                </ul>
                            </nav>

                        </div>
                    </div>
                </div>

            </div>



            <div id="menu1" class="tab-pane fade">

                <h3>Major List</h3>
                <p>This readonly list contains the major users, which contains in both first list and second list</p>

                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">

                            <!-- Table -->
                            <table class="table">
                                <thead>
                                <th>Token</th>
                                <th>Name</th>
                                <th>Username</th>
                                </thead>
                                <tbody>
                                @foreach ($major_list['data'] as $value)
                                <tr>
                                    <td>{{ $value->token }}</td>
                                    <td>{{ $value->name }}</td>
                                    <td>{{ $value->username }}</td>
                                </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <nav aria-label="Pages">
                                <ul class="pagination">
                                    <li class="disabled"><a href="#" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li>
                                    <li class="active"><a href="#">1 <span class="sr-only">(current)</span></a></li>
                                </ul>
                            </nav>
                        </div>
                    </div>

                </div>
            </div>



        </div>




    </div>



</div>



<script>

    $(".add-modal").click( function(){

    });


    $(".delete-modal").on('click', function() {
        // console.log($(this).data('token'));

        if ($(this).data("table") == "first_table") {

            $.post( "/list/delete_first_list", $(this).data('token') ,function( data ) {
                console.log(data)
                // $( ".result" ).html( data );
            });
        }else{

            $.post( "/list/delete_secondary_list", $(this).data('token') ,function( data ) {
                console.log(data)
                // $( ".result" ).html( data );
            });
        }
    });
</script>
