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
<div id="modal_add_first" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Content will be loaded here from "remote.php" file -->
        </div>
    </div>
</div>

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

        <input type="hidden" class="form-control" name="page_selected_first_list" id="page_selected_first_list" value="{{ $first_list['current_page'] }}" data-page="{{ $first_list['current_page'] }}" aria-describedby="sizing-addon1">
        <input type="hidden" class="form-control" name="page_selected_first_list" id="page_selected_secondary_list" value="{{ $secondary_list['current_page'] }}" data-page="{{ $secondary_list['current_page'] }}" aria-describedby="sizing-addon1">
        <input type="hidden" class="form-control" name="page_selected_first_list" id="page_selected_major_list" value="{{ $major_list['current_page'] }}" data-page="{{ $major_list['current_page'] }}" aria-describedby="sizing-addon1">



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
                            </div>

                            <div class="panel-heading message-add-remove-first alert-primary" style="display:none;">
                                <p class="message-add-remove-content-first"></p>
                            </div>

                            <div class="panel-heading">
                                <input type="text" class="form-control" name="token_first" id="token_first" placeholder="Token" aria-describedby="sizing-addon1">
                                <div class="pull-right">
                                    <button  onclick="addToList('first')" class="add-modal btn btn-success" data-info="first_list"
                                    <span class="glyphicon glyphicon-trash"></span> Add
                                    </button>
                                </div>
                            </div>

                            <!-- Table -->
                            <table class="table">
                                <thead>
                                    <th>Token</th>
                                    <th>Actions</th>
                                </thead>
                                <tbody class="body-content-first">

                                @foreach ($first_list['data'] as $value)
                                <tr>
                                    <td>{{ $value->token }}</td>
                                    <td><button onclick='removeFromList("{{$value->token}}" , "first")' class="delete-modal btn btn-danger"
                                                data-token="{{$value->token}}" data-table="first_table">
                                            <span class="glyphicon glyphicon-trash"></span> Delete
                                        </button></td>
                                </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <ul class="pagination pagination-search-first">

                            </ul>
                            <p class="showing-paragraph-first"></p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="panel panel-default">
                            <!-- Default panel contents -->
                            <div class="panel-heading">
                                Secondary List
                            </div>

                            <div class="panel-heading message-add-remove-secondary alert-primary" style="display:none;">
                                <p class="message-add-remove-content-secondary"></p>
                            </div>

                            <div class="panel-heading">
                                <input type="text" class="form-control" name="token_secondary" id="token_secondary" placeholder="Token" aria-describedby="sizing-addon1">
                                <div class="pull-right">
                                    <button  onclick="addToList('secondary')" class="add-modal btn btn-success" data-info="first_list"
                                    <span class="glyphicon glyphicon-trash"></span> Add
                                    </button>
                                </div>
                            </div>

                            <!-- Table -->
                            <table class="table secondary-table">
                                <thead>
                                    <th>Token</th>
                                    <th>Actions</th>
                                </thead>
                                <tbody class="body-content-secondary">
                                @foreach ($secondary_list['data'] as $value)
                                <tr>
                                    <td>{{ $value->token }}</td>
                                    <td><button onclick='removeFromList("{{$value->token}}" , "secondary")' class="delete-modal btn btn-danger"
                                                data-token="{{$value->token}}"  data-table="secondary_table">
                                            <span class="glyphicon glyphicon-trash"></span> Delete
                                        </button></td>
                                </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <ul class="pagination pagination-search-secondary">

                            </ul>
                            <p class="showing-paragraph-secondary"></p>

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
                                </thead>
                                <tbody class="body-content-major">
                                @foreach ($major_list['data'] as $value)
                                <tr>
                                    <td>{{ $value->token }}</td>
                                </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <ul class="pagination pagination-search-major">

                            </ul>
                            <p class="showing-paragraph-major"></p>
                        </div>
                    </div>

                </div>
            </div>



        </div>




    </div>



</div>



<script>
function addToList(list){
    console.log(list);
    if(list == "first"){
        var token = $("#token_first").val();
        var url = "/list/add_first_list";
    }else{
        var token = $("#token_secondary").val();
        var url = "/list/add_secondary_list";
    }

    var json_obj = {
        "list" : "" + list,
        "token" :"" + token
    };
    console.log(json_obj);

    $.ajax({
        url: url,
        type: 'post',
        data: JSON.stringify(json_obj),
        headers: {
            "Authorization": 'Bearer 1ARlT7YQpMEo3CXRZIimadTcBHVcesm6fg7xrZQL5pyofwDBxr3aVQ5cTyZE',   //If your header name has spaces or any other char not appropriate
            "Accept": 'application/json',  //for object property name, use quoted notation shown in second
            "Content-Type": 'application/json'  //for object property name, use quoted notation shown in second
        },
        dataType: 'json',
        success: function (data) {
            console.log("success");
            var message = ".message-add-remove-" + list;
            var content = ".message-add-remove-content-" + list;
            if(data){
                $(message).show();
                $(content).html("Added with Success");
            }else{
                $(message).show();
                $(content).html("Customer not found, not added");
            }
        },
    });


}

function removeFromList(token, list){
    console.log(list);
    if(list == "first"){
        var url = "/list/delete_first_list";
    }else{
        var url = "/list/delete_secondary_list";
    }

    var json_obj = {
        "list" : "" + list,
        "token" :"" + token
    };
    console.log(json_obj);

    $.ajax({
        url: url,
        type: 'post',
        data: JSON.stringify(json_obj),
        headers: {
            "Authorization": 'Bearer 1ARlT7YQpMEo3CXRZIimadTcBHVcesm6fg7xrZQL5pyofwDBxr3aVQ5cTyZE',   //If your header name has spaces or any other char not appropriate
            "Accept": 'application/json',  //for object property name, use quoted notation shown in second
            "Content-Type": 'application/json'  //for object property name, use quoted notation shown in second
        },
        dataType: 'json',
        success: function (data) {
            console.log(data);
            console.log('success');
            location.reload();
        },
    });


}


function loadPaginationFirst() {
    var i = parseInt($("#page_selected_first_list").val());
    var page = i;
    console.log(i);
    if (i == 1) {
        i = 1;
    } else {
        i = page - 1;
    }


    var list = "first";
    $(".pagination-search-first").html("");
    for (i; i < page + 5; i++) {
        if (i == page && i <= <?php echo $first_list['total_pages'] ?>) {
            $(".pagination-search-first").html($(".pagination-search-first").html() + "<li class='active page-option' data-page='+ i +'><span>" + i + "</span></li>");
        } else if (i <= <?php echo $first_list['total_pages'] ?>) {
            $(".pagination-search-first").html($(".pagination-search-first").html() + "<li onclick='updateTable(" + i + ", \"first\")' data-list='first' data-page='"+ i +"'><span>" + i + "</span></li>");
        }
    }
    $(".pagination-search-first").html($(".pagination-search-first").html() + "<li class='disabled'><span>&raquo;</span></li>");

    var offset_max = parseInt(<?php echo $first_list['offset'] ?>) + 15;

    $(".showing-paragraph-first").html("Showing: " + (<?php echo $first_list['offset'] ?>) + " to " + offset_max + " | Total: " + <?php echo $first_list['total_rows'] ?> +" | Total Pages: " + <?php echo $first_list['total_pages'] ?>);
}

function loadPaginationSecondary() {
    var i = parseInt($("#page_selected_secondary_list").val());
    var page = i
    if (i == 1) {
        i = 1;
    } else {
        i = page - 1;
    }

    var list = "secondary";

    $(".pagination-search-secondary").html("");
    for (i; i < page + 5; i++) {
        if (i == page && i <= <?php echo $secondary_list['total_pages'] ?>) {
            $(".pagination-search-secondary").html($(".pagination-search-secondary").html() + "<li class='active page-option' data-page='+ i +'><span>" + i + "</span></li>");
        } else if (i <= <?php echo $secondary_list['total_pages'] ?>) {
            $(".pagination-search-secondary").html($(".pagination-search-secondary").html() + "<li onclick='updateTable(" + i + ", \"secondary\")' data-list='secondary' data-page='"+ i +"'><span>" + i + "</span></li>");
        }
    }
    $(".pagination-search-secondary").html($(".pagination-search-secondary").html() + "<li class='disabled'><span>&raquo;</span></li>");

    var offset_max = parseInt(<?php echo $secondary_list['offset'] ?>) + 15;

    $(".showing-paragraph-secondary").html("Showing: " + (<?php echo $secondary_list['offset'] ?>) + " to " + offset_max + " | Total: " + <?php echo $secondary_list['total_rows'] ?> +" | Total Pages: " + <?php echo $secondary_list['total_pages'] ?>);
}

function loadPaginationMajor() {
    var i = parseInt($("#page_selected_major_list").val());
    var page = i
    if (i == 1) {
        i = 1;
    } else {
        i = page - 1;
    }

    var list="major";
    $(".pagination-search-major").html("");
    for (i; i < page + 5; i++) {
        if (i == page && i <= <?php echo $major_list['total_pages'] ?>) {
            $(".pagination-search-major").html($(".pagination-search-major").html() + "<li class='active page-option' data-page='+ i +'><span>" + i + "</span></li>");
        } else if (i <= <?php echo $major_list['total_pages'] ?>) {
            $(".pagination-search-major").html($(".pagination-search-major").html() + "<li onclick='updateTable(" + i + ", \"major\")' data-list='major' data-page='"+ i +"'><span>" + i + "</span></li>");
        }
    }
    $(".pagination-search-major").html($(".pagination-search-major").html() + "<li class='disabled'><span>&raquo;</span></li>");

    var offset_max = parseInt(<?php echo $major_list['offset'] ?>) + 15;

    $(".showing-paragraph-major").html("Showing: " + (<?php echo $major_list['offset'] ?>) + " to " + offset_max + " | Total: " + <?php echo $major_list['total_rows'] ?> +" | Total Pages: " + <?php echo $major_list['total_pages'] ?>);
}


function updateTable(page, list){

    console.log(page);

    var json_obj = {
        "list" : "" + list,
        "show_per_page": 15,
        "page" : page
    };
    console.log(json_obj);

    $.ajax({
        url: '/list/get_list',
        type: 'post',
        data: JSON.stringify(json_obj),
        headers: {
            "Authorization": 'Bearer 1ARlT7YQpMEo3CXRZIimadTcBHVcesm6fg7xrZQL5pyofwDBxr3aVQ5cTyZE',   //If your header name has spaces or any other char not appropriate
            "Accept": 'application/json',  //for object property name, use quoted notation shown in second
            "Content-Type": 'application/json'  //for object property name, use quoted notation shown in second
        },
        dataType: 'json',
        success: function (data) {
            console.log(data);
            var body_content = ".body-content-"+list;
            $(body_content).html("");

            Object.keys(data.data).forEach(function(key){
                $(body_content).html($(body_content).html() + "<tr><td>" + data.data[key].token + "</td><td><button onclick=\'removeFromList(\""+ data.data[key].token +"\", \"" + list + "\")\' class=\"delete-modal btn btn-danger\"\n" +
                    "                                                data-token=\"" + data.data[key].token + "\" data-table=\"" +list +"\">\n" +
                    "                                            <span class=\"glyphicon glyphicon-trash\"></span> Delete\n" +
                    "                                        </button></td></tr>");
            });

            if(list == "first"){
                $("#page_selected_first_list").val(page);
                loadPaginationFirst();
                var offset_max = parseInt(data.offset) + 15;
                $(".showing-paragraph-first").html("Showing: " + (data.offset) + " to " + offset_max + " | Total: " + <?php echo $first_list['total_rows'] ?> +" | Total Pages: " + <?php echo $first_list['total_pages'] ?>);
            }else if(list == "secondary"){
                $("#page_selected_secondary_list").val(page);
                loadPaginationSecondary();
                var offset_max = parseInt(data.offset) + 15;
                $(".showing-paragraph-secondary").html("Showing: " + (data.offset) + " to " + offset_max + " | Total: " + <?php echo $secondary_list['total_rows'] ?> +" | Total Pages: " + <?php echo $secondary_list['total_pages'] ?>);
            }else if(list == "major"){
                $("#page_selected_major_list").val(page);
                loadPaginationMajor();
                var offset_max = parseInt(data.offset) + 15;
                $(".showing-paragraph-major").html("Showing: " + (data.offset) + " to " + offset_max + " | Total: " + <?php echo $major_list['total_rows'] ?> +" | Total Pages: " + <?php echo $major_list['total_pages'] ?>);
            }

        },
        error: function(data){
            console.log(data);
        }
    });

}


$( document ).ready(function() {
    loadPaginationFirst();
    loadPaginationSecondary();
    loadPaginationMajor();
});



</script>
