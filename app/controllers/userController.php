<?php
    //Includes
    require_once "dao/userDao.php";

    Class UserController{
        var $Dao;

        private function InitDao(){
            if($this->Dao ==null)
                $this->Dao = new UserDao();
        }
        public function Search($data){
            $this->InitDao();
    
            return json_encode($this->Dao->Search($data["search"],intval($data["page"])));
        }
    }
?>