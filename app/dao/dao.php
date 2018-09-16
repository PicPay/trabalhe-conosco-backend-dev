<?php

    Class DAO {
        var $Manager;

        /*
        * Get mongo manager
        * @return $this->Manager
        */
        private function GetMongoManager(){
            if($this->Manager == null)
             $this->Manager = new MongoDB\Driver\Manager("mongodb://mongo:27017");

             return $this->Manager;
        }

        /*
        * Drop collection
        * @param collection {String} (Collection do Drop)
        * @return void
        */
        protected function Drop($collection){
            $manager = $this->GetMongoManager();
            $manager->executeCommand($collection, new \MongoDB\Driver\Command(["drop" => "collection"]));
        }

        /*
        * Do Query
        * @param collection {String} (Collection)
        * @param query {Array} (Mongo Query)
        * @param options {Array} (Query Options)
        * @return result {Array} (Query result)
        */
        protected function Query($collection,$query,$options){
            $manager = $this->GetMongoManager();
            
            $mQuery = new MongoDB\Driver\Query($query,$options);
            $cursor = $manager->executeQuery($collection, $mQuery);

            return $cursor->toArray();
        }

        /*
        * Make Regex to Query
        * @param reg {String} (String to regex)
        * @return regex {Mongo\BSON\Regex} (Regex to Mongo Query)
        */
        protected function MakeRegex(String $reg){
            return new MongoDB\BSON\Regex ($reg);
        }

        /*
        * Insert Data on Collection
        * @param collection {String} (Collection)
        * @param data {Array} (Data to Insert)
        * @return void
        */
        protected function Insert($collection,$data){
            $manager = $this->GetMongoManager();
            $bulk = new MongoDB\Driver\BulkWrite;           

            $data['_id'] = new MongoDB\BSON\ObjectID;
            
            $bulk->insert($data);
            $manager->executeBulkWrite($collection, $bulk);
        }

        /*
        * Update Data
        * @param collection {String} (Collection)
        * @param where {Array} (Mongo Where Clause)
        * @param data {Array} (Data to Update)
        * @return void
        */
        protected function Update($collection,$where,$data){
            $manager = $this->GetMongoManager();
            $bulk = new MongoDB\Driver\BulkWrite;
            $bulk->update($where,['$set' => $data],['multi' => false, 'upsert' => false]);
            $manager->executeBulkWrite($collection, $bulk);
        }

        /*
        * Update Array of data
        * @param collection {String} (Collection)
        * @param arr {Array} (Data array)
        * @return void
        */
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

        /*
        * Execute Command com MongoDB
        * @param collection {String} (Collection)
        * @param command {Mongo Command} (Mongo Command)
        * @return void
        */
        protected function Execute($collection, $command){
            $manager = $this->GetMongoManager();
            $manager->executeCommand($collection, $command);
        }
    }

?>