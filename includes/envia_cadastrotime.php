<<?php
//require 'bootstrap.php';
require 'time.php';

$arquivo = $_FILES['arquivo'];

if ($arqError == 0) {
	$pasta = '/uploads/';
	$upload = move_uploaded_file($arqTemp, $pasta . $arqName);

$time = new time($_GET['nome']);

echo "inserido time com o nome {$time->getNome()}<br>";