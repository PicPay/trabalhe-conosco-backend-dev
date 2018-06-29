<?php
#controlador de Login

defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Input extends CI_Input {

    function __construct() {
        parent::__construct();
    }

    //Overide ip_address() with your own function
    function ip_address() {

        //Obtain the IP address however you'd like, you may want to do additional validation, etc..
        if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            return $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            return $_SERVER['REMOTE_ADDR'];
        }
    }

}
