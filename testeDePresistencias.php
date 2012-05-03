<?php
require "bootstrap.php";

$user_id = 100000885523518;
//echo $user_id .  ' é um ' . gettype($user_id_str) ;
$usuario = $entityManager->find("Usuario", "100000885523518");

print 'Nome: ' . $usuario->getPrimeiroNomeUsuario() . '<br />';
print 'ID: ' . $usuario->getIdUsuario();
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