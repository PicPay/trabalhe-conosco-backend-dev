<?php

session_start();
unset($_SESSION["token"]);

header("location: ./index.php");

?>