<?php

ini_set('memory_limit', '1028M');

try {
    $dbh = new PDO('mysql:host=localhost;dbname=picpay', 'root', '', array(
  PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
} catch (PDOException $e) {
    echo "Erro no mysql ".$e->getMessage()."\n";
}

$num_file_start = 12;

$num_file = $num_file_start;

while($file = getFile($num_file)) {

	echo "verificando arquivo ".$file."\n";

	$num_file++;

	$file_content = readTheFile($file);

	echo "Arquivo carregado\n";
	$i = 1;

	foreach ($file_content as $linhas) {
		$v = explode(",", $linhas);
		$campos = array_map('trim', $v);

		if(empty($campos[0])) {
			echo "Campos vazios\n";
			$i++;
			continue;
		} else {

			try {
				echo "Preparando inserts\n";

				$stm = $dbh->prepare('INSERT INTO users VALUES (?,?,?)');

				if($stm->execute([$campos[0],$campos[1],$campos[2]])) {
					echo "OK arquivo ".($num_file-1)." linha".$i."\n";
				}
			} catch (Exception $e) {
				echo "Erro arquivo ".($num_file-1)." linha ".$i." : ".$e->getMessage()."\n";
			}
			$i++;
		}
	}
}

function getFile($num) {
	$file_pre = "files/users_split";

	$pos = str_pad($num, 2, "0", STR_PAD_LEFT);

	$file = $file_pre.$pos;

	if(file_exists($file))
		return $file;

	return false;
}

function readTheFile($path) {
    $handle = fopen($path, "r");

    while(!feof($handle)) {
        yield trim(fgets($handle));
    }

    fclose($handle);
}