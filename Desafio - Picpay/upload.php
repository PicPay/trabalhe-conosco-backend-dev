<?php
require_once("banco-usuarios.php");
require_once("routes/db.php");

// upload dos arquivos para ajuste das prioridades.


// Arquivo com prioridade 1
$target_path = "uploads/";
$target_path = $target_path . basename( $_FILES['Priority1']['name']); 
$content1 = file($_FILES["Priority1"]["tmp_name"]);

if(move_uploaded_file($_FILES['Priority1']['tmp_name'], $target_path)) {
    $_SESSION["success"] ="O arquivo ".  basename( $_FILES['Priority1']['name'])." foi adicionado a base de prioridades!";
} else{
    $_SESSION["danger"] ="Ocorreu um erro ao enviar o arquivo!";
}
setPrioridade($content1, 1);


// Arquivo com prioridade 2
$target_path = "uploads/";
$target_path = $target_path . basename( $_FILES['Priority2']['name']); 
$content2 = file($_FILES["Priority2"]["tmp_name"]);

if(move_uploaded_file($_FILES['Priority2']['tmp_name'], $target_path)) {
    $_SESSION["success"] ="O arquivo ".  basename( $_FILES['Priority2']['name'])." foi adicionado a base de prioridades!";
} else{
    $_SESSION["danger"] ="Ocorreu um erro ao enviar o arquivo!";
}
setPrioridade($content2, 2);


header('Location: index.php');
