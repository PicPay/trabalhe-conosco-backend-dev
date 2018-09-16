<?php

    Class DAO {
        var $Manager;

        private function GetMongoManager(){
            if($this->Manager == null)
             $this->Manager = new MongoDB\Driver\Manager("mongodb://mongo:27017");

             return $this->Manager;
        }

        protected function Drop($collection){
            $manager = $this->GetMongoManager();
            $manager->executeCommand($collection, new \MongoDB\Driver\Command(["drop" => "collection"]));
        }

        protected function Query($collection,$query,$options){
            $manager = $this->GetMongoManager();
            
            $mQuery = new MongoDB\Driver\Query($query,$options);
            $cursor = $manager->executeQuery($collection, $mQuery);

            return $cursor->toArray();
        }

        protected function MakeRegex(String $reg){
            return new MongoDB\BSON\Regex ($reg);
        }

        protected function Insert($collection,$data){
            $manager = $this->GetMongoManager();
            $bulk = new MongoDB\Driver\BulkWrite;           

            $data['_id'] = new MongoDB\BSON\ObjectID;
            
            $bulk->insert($data);
            $manager->executeBulkWrite($collection, $bulk);
        }

        protected function Update($collection,$where,$data){
            $manager = $this->GetMongoManager();
            $bulk = new MongoDB\Driver\BulkWrite;
            $bulk->update($where,['$set' => $data],['multi' => false, 'upsert' => false]);
            $manager->executeBulkWrite($collection, $bulk);
        }


        protected function UpdateArray($collection,$arr){
            $manager = $this->GetMongoManager();
            $bulk = new MongoDB\Driver\BulkWrite;
            foreach ($arr as &$value) {
                $bulk->update($value["where"],['$set' => $value["data"]],['multi' => false, 'upsert' => false]);  
            }
            unset($value);
            //$bulk->update($where,['$set' => $data],['multi' => true, 'upsert' => false]);
            $manager->executeBulkWrite($collection, $bulk);
        }

        protected function Execute($collection, $command){
            $manager = $this->GetMongoManager();
            $manager->executeCommand($collection, $command);
        }
    }

?>