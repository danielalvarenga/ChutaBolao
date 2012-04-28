<?php
//require 'bootstrap.php';
require 'Time.php';
//try{

$arquivo = $_FILES['arquivo'];
$nome = $_POST['nome'];
/**if ($arqError == 0) {
	$pasta = '/uploads/';
	$upload = move_uploaded_file($arqTemp, $pasta . $arqName);
}
**/
$time = new time($nome);
//$entityManager->persist($time);
//$entityManager->flush();

//}
//catch (Exception $e){
	//echo ($e->getMensage());
//}
echo "inserido time com o nome {$time->getNome()}<br>";
print_r($arquivo);