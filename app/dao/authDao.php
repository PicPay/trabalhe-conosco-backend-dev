<?php

    require_once "dao/dao.php";
    
    Class AuthDao extends Dao{

        public function Login(String $user,String $password){
            $options = [
                'projection' => ['password'=>0]
            ];
            $query = array('username' => $user, 'password'=> $password);
            
            return $this->Query('picpay.auth',$query,$options);
        }

        public function Register(String $username,String $password){
            return $this->Insert('picpay.auth',array("username"=>$username, "password"=>$password));
        }
    }
?>