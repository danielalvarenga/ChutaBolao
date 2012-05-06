<?php
require "bootstrap.php";

$user_id = 100000885523518;
$usuario = $entityManager->find("Usuario", 100000885523518);

if($usuario instanceof Usuario){
	echo 'Nome: ' . $usuario->getPrimeiroNomeUsuario() . '<br />';
	echo 'e-mail: ' . $usuario->getEmailUsuario() . '<br />';
} else{
	$user_id = 100000885523518;
	$primeiroNomeUsuario = 'Daniel';
	$segundoNomeUsuario = 'Alvarenga Lima';
	$emailUsuario = 'alvarenga_daniel@hotmail.com';
	$tokenUsuario = 'AAADUkCMlzxoBAAde2WKyZAMFkBgDMxuGcNoXsZB37g3eiPRVGe2nQXTIbN0StDRO2Bh4xf2mCHZBfOSQOp9qbAbpFMhqp2amsijqxK5GhLnMfRr8Ycl';
	$usuario = new Usuario($user_id, $tokenUsuario, $primeiroNomeUsuario, $segundoNomeUsuario, $emailUsuario);
	
	
	$nomeCampeonato = "Brasileirão";
	$anoCampeonato = 2012;
	$quantidadeRodadas = 38;
	$campeonato = new Campeonato($nomeCampeonato, $anoCampeonato, $quantidadeRodadas);
	$entityManager->persist($campeonato);
	$entityManager->flush();
	echo 'Campeonato persistido.<br />';
	
	$entityManager->persist($usuario);
	$entityManager->flush();
	echo 'Usuário cadastrado.<br />';
	
	$premiacoes = new PremiosUsuario($usuario, $campeonato);
	$entityManager->persist($premiacoes);
	$entityManager->flush();
	echo 'premios persistido.<br />';
	
	$usuario->adicionaPremiacoesUsuario($premiacoes);
	echo 'Adicionado a coleção do usuario.<br />';
}







/*
// Para Usuario --------------------------------------------------------

$user_id = 100000885523518;
$primeiroNomeUsuario = 'Daniel';
$segundoNomeUsuario = 'Alvarenga Lima';
$emailUsuario = 'alvarenga_daniel@hotmail.com';
$tokenUsuario = 'AAADUkCMlzxoBAAde2WKyZAMFkBgDMxuGcNoXsZB37g3eiPRVGe2nQXTIbN0StDRO2Bh4xf2mCHZBfOSQOp9qbAbpFMhqp2amsijqxK5GhLnMfRr8Ycl';
$usuario = new Usuario($user_id, $tokenUsuario, $primeiroNomeUsuario, $segundoNomeUsuario, $emailUsuario);

$entityManager->persist($usuario);
$entityManager->flush();

// Para Time --------------------------------------------------------

$nome = 'Flamengo';
$time = new Time($nome);

$entityManager->persist($time);
$entityManager->flush();

echo "Usuario criado com o ID ".$usuario->getIdUsuario()."\n";*/