<?php

require "bootstrap.php";

//try{

//$arquivo = $_FILES['arquivo'];
//if ($arqError == 0) {
//	$pasta = '/uploads/';
//	$upload = move_uploaded_file($arqTemp, $pasta . $arqName);
//}

$nome = $_POST['nome'];
$time = new Time($nome);
$entityManager->persist($time);
$entityManager->flush();

//}
//catch (Exception $e){
//	echo ($e->getMensage());
//}
echo "inserido time com o nome {$time->getNomeTime()}<br>";
//print_r($arquivo);