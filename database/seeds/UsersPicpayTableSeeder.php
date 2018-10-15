<?php
set_time_limit(0);

use Illuminate\Database\Seeder;
use App\UsersPicpay;
use App\Service\UsersPicpayService;
use App\Repository\UsersPicpayRepository;

/**
 * Class UsersPicpayTableSeeder
 */
class UsersPicpayTableSeeder extends Seeder
{
    /**
     * @var UsersPicpayService
     */
    protected  $usersPicpayService;

    /**
     * UsersPicpayTableSeeder constructor.
     * @param UsersPicpayService $usersPicpayService
     */
    public function __construct(UsersPicpayService $usersPicpayService)
    {
        $this->usersPicpayService = $usersPicpayService;

        $this->fileRelevance1 = app_path() . '/Sources/lista_relevancia_1.txt';
        $this->fileRelevance2= app_path() . '/Sources/lista_relevancia_2.txt';
        $this->usersPicpayCsv = app_path() . '/Sources/users_picpay.csv';
    }

    public function run()
    {
        $this->setRelevancies();
    }

    public function setRelevancies()
    {
        $fileOpenRelevance1 = fopen($this->fileRelevance1, 'r');
        $fileOpenRelevance2 = fopen($this->fileRelevance2, 'r');

        if ($fileOpenRelevance1) {
            $this->saveRelevance($fileOpenRelevance1, $this->fileRelevance1, $relevance = 2);
        }
        if ($fileOpenRelevance2) {
            $this->saveRelevance($fileOpenRelevance2, $this->fileRelevance2, $relevance = 1);
        }
    }

    /**
     * @param $file
     * @param $path
     * @param $relevance
     */
    public function saveRelevance($file, $path, $relevance) {
        $lines = explode("\n", fread($file, filesize($path)));

        foreach ($lines as $line) {
            $this->usersPicpayService->update($line, $relevance);
        }
    }
}
