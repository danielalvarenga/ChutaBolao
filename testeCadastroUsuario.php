<?php

require "bootstrap.php";

$idUsuario = 100003489131091;
$tokenUsuario = "iurfvgbhju8765rtgyu765rfghyu765r";
$primeiroNomeUsuario = "Primeironome";
$segundoNomeUsuario = "Segundonome";
$emailUsuario = "primeirosegundonome@oi.com";
$u1 = new Usuario($idUsuario, $tokenUsuario, $primeiroNomeUsuario, $segundoNomeUsuario, $emailUsuario);

$entityManager->persist($u1);
$entityManager->flush();

echo "Usuario criado com o id".$u1->getIdUsuario()."\n";