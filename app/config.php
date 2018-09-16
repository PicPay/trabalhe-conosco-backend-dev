<?php
    /*
     Rotina responsável por setar prioridade no banco de dados
    */

    require_once "dao/userDao.php";
    require_once "dao/authDao.php";
    require_once "dao/configDao.php";

    $UserDao = new UserDAO();
    $AuthDao = new AuthDao();
    $ConfDao = new ConfDao();
    
    if($ConfDao->CheckDatabase()){
        echo "\n DATABASE JA CONFIGURADA \n";
        exit();
    }

    //Lista de relevancia ordenada por prioridade
    $path = "./data/";
    $files = array('lista_relevancia_1.txt','lista_relevancia_2.txt');
    $priority = 100; // Prioridade maxima -> 100
    $count = array();

    foreach ($files as &$file) {
        $List = array();
        if ($fh = fopen($path.$file, 'r')) {
            $count[$file] = array("len"=>0, "priority"=>$priority);
            while (!feof($fh)) {
                $line = fgets($fh);
                //Removendo enter
                $line = str_replace("\n", "", $line);
                $line = str_replace("\r", "", $line);
                //Setando prioridade
                $List[] = array("where"=>array("id"=>$line),"data"=>array("priority"=>$priority));
                //$List[] = $line;
                
                //$List[] = array("id"=>$line);
                
                //$UserDao->SetPriority($line,$priority);
                $count[$file]["len"]++;
            }
            fclose($fh);
        }
        $UserDao->SetPriorityArray($List);
        //$UserDao->SetPriority($List,$priority);
        $priority--;
    }

    unset($value);

    $ConfDao->CreateIndex();

    echo "<BR>--- Registros adicionados com prioridade ---<br>";
    echo json_encode($count);

    echo "<BR>--- Usuarios ---<br>";
    //Cadastra login
    echo $AuthDao->Register("joao","joao");

    $ConfDao->SetInitialized();
?>