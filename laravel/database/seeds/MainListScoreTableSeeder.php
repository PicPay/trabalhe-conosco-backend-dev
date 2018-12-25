<?php

use Illuminate\Database\Seeder;

class MainListScoreTableSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $file = base_path() . '/database/temp/lista_relevancia_1.txt';
        $handle = fopen($file, "r");
        print_R("Seeding the Main Score table, this will take while, we are prioritizing with score 2 the first list customers\n");
        if ($handle) {
            while (($line = fgets($handle)) !== false) {
                $line = preg_replace('/\s+/', '', $line);
                $this->addOrUpdateScore($line);
            }



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

    function addOrUpdateScore($token){
        $table_main_list_score = 'main_list_score';
        $where_main_list_score = array('token' => $token);

        $customer = $this->getFirst($table_main_list_score, $where_main_list_score);
        if($customer == null) {
            $data_main_list_score = array(
                'token' => $token,
                'created_at' => date('Y-m-d H:i:s', time()),
                'updated_at' => date('Y-m-d H:i:s', time()),
            );
            $score_added = $this->add($table_main_list_score, $data_main_list_score);
        }


        $table_customer ='customer';
        $where_customer = array('customer.token' => $token);
        $customer = $this->getFirst($table_customer, $where_customer);
        if($customer != null){

//            print_r($customer->name . "\n");

            $customer_id = $customer->id;

            $value = 0;


            $table_customer_score = 'customer_score';
            $where_customer_score = array('customer_id' => $customer_id);
            $score_row = $this->getFirst($table_customer_score, $where_customer_score);
            if($score_row != null){

                switch ($score_row->score) {
                    case 0:
                    case 2:
                        $value = 2;
                        break;
                    case 1:
                    case 3:
                        $value = 3;
                        break;
                }

                $data = array(
                    'score' => $value
                );
                $this->update($table_customer_score, $data, $where_customer_score);

            }else{
                $data = array(
                    'customer_id' => $customer_id,
                    'score' => 2,
                    'created_at' => date('Y-m-d H:i:s', time()),
                    'updated_at' => date('Y-m-d H:i:s', time()),
                );
                $this->add($table_customer_score, $data);


            }
        }
    }
}
