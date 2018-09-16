<?php
    /*
     Rotina responsável por setar prioridade no banco de dados
    */

    require_once "./dao/userDao.php";

    $UserDao = new UserDAO();
    
    //Lista de relevancia ordenada por prioridade
    $path = "./data/";
    $files = array('lista_relevancia_1.txt','lista_relevancia_2.txt');
    $priority = 100; // Prioridade maxima -> 100
    $count = array();

    foreach ($files as &$file) {
        if ($fh = fopen($path.$file, 'r')) {
            $count[$file] = array("len"=>0, "priority"=>$priority);
            while (!feof($fh)) {
                $line = fgets($fh);
                //Removendo enter
                $line = str_replace("\n", "", $line);
                $line = str_replace("\r", "", $line);
                //Setando prioridade
                $UserDao->SetPriority($line,$priority);
                $count[$file]["len"]++;
            }
            fclose($fh);
        }
        $priority--;
    }

    unset($value);

    echo "<BR>--- Registros adicionados com prioridade ---<br>";
    echo json_encode($count);

    echo "<BR>--- Usuarios ---<br>";
    //Cadastra login
    $AuthDao = new AuthDao();
    echo $AuthDao->Register("joao","joao");

?>