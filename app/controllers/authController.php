<?php
    //Includes
    require_once "dao/authDao.php";

    Class AuthController{
        var $AuthDao;

        private function InitDao(){
            if($this->AuthDao ==null)
                $this->AuthDao = new AuthDao();
        }

        public function CheckAuth(){
            return (!isset($_SESSION["logged"]) || $_SESSION["logged"] == 0) ;
        }

        public function Login(Array $data){
            if(!isset($data["username"]) || !isset($data["password"]))
                return json_encode(array("succes"=> false, "message"=>"Invalid parameters"));

            $this->InitDao();
            
            $dr = $this->AuthDao->Login($data["username"],$data["password"]);

            $result = array("success"=>false,"message"=>"Login Failed");
            if(count($dr)>0){
                $_SESSION["logged"] = true;
                $result = array("success"=>true,"data"=>$dr[0]);
            }

            return json_encode($result);
        }

    }
?>