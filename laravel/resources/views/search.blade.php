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
<link rel="stylesheet" href="/css/custom.css">

<input type="hidden" class="form-control" name="bearer" id="bearer" value="{{ $api_token }}">


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


        <h1>Search a User</h1>
        <p>Please provide token, name or username. Empty or more than 4 character.</p>
        <p>The search will focus on the info you provided.</p>
        <div class="search-form row">
            <input type="hidden" class="form-control" name="page_selected" id="page_selected" value="1" data-page="1" aria-describedby="sizing-addon1">
            <div class="col-md-4">
                <div class="input-group input-group-lg">
                    <span class="input-group-addon" id="sizing-addon1">Token</span>
                    <input type="text" class="form-control" name="parameters[id]" id="token" placeholder="Token" aria-describedby="sizing-addon1">
                </div>
            </div>
            <div class="col-md-4">
                <div class="input-group input-group-lg">
                    <span class="input-group-addon" id="sizing-addon1">Name</span>
                    <input type="text" class="form-control" placeholder="Name" name="parameters[name]" id="name" aria-describedby="sizing-addon1">
                </div>
            </div>
            <div class="col-md-4">
                <div class="input-group input-group-lg">
                    <span class="input-group-addon" id="sizing-addon1">UserName</span>
                    <input type="text" class="form-control" placeholder="Username" name="parameters[username]" id="username" aria-describedby="sizing-addon1">
                </div>
            </div>

            <div class="col-md-6 col-md-offset-3 submit-button">
                <button type="submit" class="submit-search-form btn btn-success btn-lg btn-block"  onclick="submit_search()">Search</button>
            </div>
        </div>

    </div>

    <div class="jumbotron jumbotron-message" style="display:none;">
        <div class="alert alert-danger">

        </div>
    </div>

    <div class="jumbotron jumbotron-search" style="display:none;">
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
                        <tbody class="body-customer">
                        </tbody>
                    </table>
                    <ul class="pagination pagination-search">

                    </ul>

                </div>
            </div>

        </div>
    </div>




</div>

<script>
var bearer = "" + $("#bearer").val();

function change_page(page){
    $("#page_selected").attr("data-page", page);
    $("#page_selected").val(page);
    submit_search();
}



function submit_search(){
    var token = $("#token").val();
    var name = $("#name").val();
    var username = $("#username").val();
    var page = parseInt($("#page_selected").val());

    console.log(page);

    var json_obj = {
        "parameters" : {
            "id" : token,
            "name" : name,
            "username" : username
        },
        "show_per_page": 15,
        "page" : page
    }
    console.log(json_obj);

    $.ajax({
        url: '/api/rest/customer',
        type: 'post',
        data: JSON.stringify(json_obj),
        headers: {
            "Authorization": 'Bearer '+ bearer,   //If your header name has spaces or any other char not appropriate
            "Accept": 'application/json',  //for object property name, use quoted notation shown in second
            "Content-Type": 'application/json'  //for object property name, use quoted notation shown in second
        },
        dataType: 'json',
        success: function (data) {
            console.info(data);
            if(data.error_code == 200){
                $(".body-customer").html("");
                $(".jumbotron-search").show();
                $(".jumbotron-message").hide();


                Object.keys(data.data).forEach(function(key){
                    $(".body-customer").html($(".body-customer").html() + "<tr><td>" + data.data[key].token + "</td><td>" + data.data[key].name + "</td><td>" + data.data[key].username + "</td></tr>");
                });

                $(".pagination-search").html("<li class='disabled'><span>&laquo;</span></li>");

                var i = page;
                if(i == 1){
                    i = 1;
                }else{
                    i = page-1
                }

                for (i; i < data.current_page+5; i++) {
                    console.log(i);
                    if(i == data.current_page && i<= data.total_pages){
                        console.log("if");
                        $(".pagination-search").html($(".pagination-search").html() + "<li class='active page-option' data-page='+ i +'><span>" + i + "</span></li>");
                    }else if(i<= data.total_pages){
                        console.log("else");
                        $(".pagination-search").html($(".pagination-search").html() + "<li onclick='change_page("+ i +")' data-page='+ i +'><span>" + i + "</span></li>");
                    }
                }
                $(".pagination-search").html($(".pagination-search").html() + "<li class='disabled'><span>&raquo;</span></li>");

                var offset_max = data.offset + 15;

                $(".showing-paragraph").html("Showing: " + (data.offset) + " to " + offset_max + " | Total: " + data.total_rows + " | Total Pages: " + data.total_pages);




            }else if(data.error_code == 204){
                $(".jumbotron-message").show();
                $(".jumbotron-message").html(data.message);
            }else if(data.error_code == 400){
                $(".jumbotron-message").show();
                $(".jumbotron-message").html(data.message);
            }else if(data.error_code == 422){
                $(".jumbotron-message").show();
                $(".jumbotron-message").html(data.message);
            }
        }
    });
}


</script>
