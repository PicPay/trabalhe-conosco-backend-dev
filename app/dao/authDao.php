<?php

    require_once "dao/dao.php";
    
    Class AuthDao extends Dao{

        /*
        * Do Login
        * @param user {String} (User)
        * @param password {String} (Pasword)
        * @return result {Array} (User Data)
        */
        public function Login(String $user,String $password){
            $options = [
                'projection' => ['password'=>0]
            ];
            $query = array('username' => $user, 'password'=> $password);
            
            return $this->Query('picpay.auth',$query,$options);
        }

        /*
        * Register User
        * @param user {String} (User)
        * @param password {String} (Pasword)
        * @return void
        */
        public function Register(String $username,String $password){
            return $this->Insert('picpay.auth',array("username"=>$username, "password"=>$password));
        }
    }
?>