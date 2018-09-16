<?php

    //Includes
    require_once "interface/interface.php";

    Class Search extends BasicInterface{
        public function Render(){
            $pagecontents = file_get_contents("interface/static/search.html");
            echo str_replace("{username}", $_SESSION["username"], $pagecontents);
        }
    }

?>