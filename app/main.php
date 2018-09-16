<?php
    //Includes
    require_once "routes/routes.php";
    
    session_start();
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");

    $Router = new Router();

    switch ($_GET["type"]){
        case "search":
            echo $Router->Search(array("search"=> $_REQUEST["data"], "page"=>$_REQUEST["page"]));
        break;

        case "login":
            echo $Router->Login($_REQUEST);
        break;
    }
    
?>