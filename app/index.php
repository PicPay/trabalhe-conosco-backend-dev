<?php
    session_start();
    //incluces
    require_once "controllers/authController.php";
    require_once "interface/login.php";
    require_once "interface/search.php";

    $Authontroller = new AuthController();
    $Interface = null;

    //Check Auth
    if($Authontroller->CheckAuth())
        $Interface = new Login();
    else
        $Interface = new Search();

    $Interface->Render();
?>