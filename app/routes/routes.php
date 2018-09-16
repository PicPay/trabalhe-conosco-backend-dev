<?php

    //Includes
    require_once "controllers/userController.php";
    require_once "controllers/authController.php";

    Class Router {
        var $UserController;
        var $AuthController;
        private function CheckAuth(){
            if($this->AuthController == null)
                $this->AuthController = new AuthController();
                
            if($this->AuthController->CheckAuth()){
                echo json_encode(array("success"=> false, "message"=>"Auth Error"));
                exit();
            }
        }

        public function Search(Array $data){
            $this->CheckAuth();

            if($this->UserController == null)
                $this->UserController = new UserController();
            
            return $this->UserController->Search($data);
        }

        public function Login(Array $data){
            if($this->AuthController == null)
                $this->AuthController = new AuthController();
            
            return $this->AuthController->Login($_REQUEST);
        }
    }
?>