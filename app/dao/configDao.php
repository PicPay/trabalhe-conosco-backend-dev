<?php

    require_once "dao/dao.php";
    
    Class ConfDao extends Dao{

        public function CheckDatabase(){
            $options = [
                'projection' => ['_id'=>0],
            ];
            $query = array('initialized' => 1);
            
            $result = $this->Query('picpay.config',$query,$options);
            return (count($result)>0);
        }

        public function SetInitialized(){
            return $this->Insert('picpay.config',array("initialized"=>1));
        }

        public function CreateIndex(){
            $command = new MongoDB\Driver\Command([
                "createIndexes" => "users",
                "indexes"       => [[
                  "name" => "dIndex",
                  "key"  => [ "priority" => -1],
                  "ns"   => "picpay.users",
               ]],
            ]);
            $this->Execute("picpay", $command);
        }
    }
?>