<?php

use Illuminate\Database\Seeder;

class SecondaryListScoreTableSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $file = base_path() . '/database/temp/lista_relevancia_2.txt';
        $handle = fopen($file, "r");
        print_r("Seeding the Secondary Score table, this will take while, customer will have score 1 if in the secondary list customers.\nn
if the customer is present in both lists it will have a score 3\n");
        if ($handle) {
            while (($line = fgets($handle)) !== false) {
                $line = preg_replace('/\s+/', '', $line);
                $this->addOrUpdateScore($line);
            }
            print_r("\n  We have updated the existing customers with the relative score set by the relevance lists.\n 
  In case of addition of customers/users we highly suggest to sync the score by the url: (URL COMES HERE) \n\n");

            fclose($handle);
        } else {
            // error opening the file.
            print_r("error opening file");
        }
    }

    function add($table, $data){

        return DB::table($table)->insert($data);

    }

    function update($table, $data, $where){

        return DB::table($table)
            ->where($where)
            ->update($data);

    }

    function getFirst($table, $where){
        $response = DB::table($table)
            ->select('*')
            ->where($where)
            ->first();

        return $response;
    }

    function addOrUpdateScore($token)
    {

        $table_secondary_list_score = 'secondary_list_score';
        $where_secondary_list_score = array('token' => $token);

        $customer = $this->getFirst($table_secondary_list_score, $where_secondary_list_score);
        if($customer == null) {
            $data_secondary_list_score = array(
                'token' => $token,
                'created_at' => date('Y-m-d H:i:s', time()),
                'updated_at' => date('Y-m-d H:i:s', time()),
            );
            $score_added = $this->add($table_secondary_list_score, $data_secondary_list_score);
        }

        $table_customer = 'customer';
        $where_customer = array('customer.token' => $token);
        $customer = $this->getFirst($table_customer, $where_customer);
        if ($customer != null) {
//            print_r($customer->name . "\n");

            $customer_id = $customer->id;

            $value = 0;


            $table_customer_score = 'customer_score';
            $where_customer_score = array('customer_id' => $customer_id);
            $score_row = $this->getFirst($table_customer_score, $where_customer_score);
            if ($score_row != null) {

                switch ($score_row->score) {
                    case 0:
                    case 1:
                        $value = 1;
                        break;
                    case 2:
                    case 3:
                        $value = 3;
                        break;
                }

                $data = array(
                    'score' => $value
                );
                $this->update($table_customer_score, $data, $where_customer_score);

            } else {
                $data = array(
                    'customer_id' => $customer_id,
                    'score' => 1,
                    'created_at' => date('Y-m-d H:i:s', time()),
                    'updated_at' => date('Y-m-d H:i:s', time()),
                );
                $this->add($table_customer_score, $data);


            }
        } else {

        }
    }
}
