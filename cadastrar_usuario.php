<?php
require "bootstrap.php";

$user_id = 12345679;
$primeiroNomeUsuario = 'abc';
$segundoNomeUsuario = 'def';
$emailUsuario = 'oi@oi.com.br';
$tokenUsuario = 'se33errf5rtgy';
$usuario = new Usuario($user_id, $tokenUsuario, $primeiroNomeUsuario, $segundoNomeUsuario, $emailUsuario);

$entityManager->persist($usuario);
$entityManager->flush();

$nome = 'Flamengo';
$time = new Time($nome);

$entityManager->persist($time);
$entityManager->flush();

echo "Usuario criado com o ID ".$usuario->getIdUsuario()."\n";