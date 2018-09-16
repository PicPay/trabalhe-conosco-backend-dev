<?php

    //Includes
    require_once "interface/interface.php";

    Class Login extends BasicInterface{
        public function Render(){
            $pagecontents = file_get_contents("interface/static/login.html");
            echo $pagecontents;
        }
    }

?>