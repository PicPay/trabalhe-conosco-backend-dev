<?php

    require_once "dao/dao.php";
    
    Class UserDao extends Dao{

        /*
        * Search User with priority
        * @param name {String} (Name to search)
        * @param page {int} (Pagination)
        * @return result {Array} (Query result)
        */
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

        /*
        * Set Priority on Array
        * @param arr {Array} (Array to Set Proirity)
        * @return void
        */
        public function SetPriorityArray(Array $arr){
            $this->UpdateArray('picpay.users',$arr);
        }

        /*
        * Set priority to ID
        * @param id {Array} (Array of IDs)
        * @param priority {int} (Priority to set)
        * @return void
        */
        public function SetPriority(Array $id,int $priority){
            $data = ['priority' => $priority];
            $where = ['$or'=>$id];
            //print_r($where);
            $this->Update('picpay.users',$where,$data);
        }

        /*
        * Inser Simple user
        * @param user {Array} (User array [id,name,username])
        * @return void
        */
        public function NewSimple(Array $user){
            $user["priority"] = 0;
            $this->Insert('picpay.users',$user);
        }
    }
?>