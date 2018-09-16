<?php

    require_once "dao/dao.php";
    
    Class UserDao extends Dao{

        public function Search(String $name,int $page){
            $regex = new MongoDB\BSON\Regex ($name);
            $options = [
                'projection' => ['_id' => 0, 'priority'=>0],
                'sort' => ['priority'=>-1],
                'skip' => $page*15,
                'limit' => 15
            ];
            $query = array( '$or' => array( array('nome' => $regex), array('username'=> $regex)));
            return $this->Query('picpay.users',$query,$options);
        }

        public function SetPriorityArray(Array $arr){
            $this->UpdateArray('picpay.users',$arr);
        }


        public function SetPriority(Array $id,int $priority){
            $data = ['priority' => $priority];
            $where = ['$or'=>$id];
            //print_r($where);
            $this->Update('picpay.users',$where,$data);
        }

        public function NewSimple(Array $user){
            $user["priority"] = 0;
            $this->Insert('picpay.users',$user);
        }
    }
?>