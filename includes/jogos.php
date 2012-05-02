<?php

/****************************************************************************************************************************************************************
*	Arquivo contendo a consulta para listagem do jogo
*	Ta faltando, um JOIN nas tabelas de Jogo e Time para poder apresentar o nome do time ao inves do codTime1 e codTime2
*	Ultima modificação: 01/05/2012 por Clairton
***************************************************************************************************************************************************************/

require "bootstrap.php";

$data = date("Y-m-d");

$dql = "SELECT j FROM jogo j ORDER BY j.codJogo ASC";

$query = $entityManager->createQuery($dql);
$query->setMaxResults(30);

$jogo = $query->getResult();

foreach($jogo as $jogo) {
    echo $jogo->getRodada() . " - " . $jogo->getCodtime1() . " - " . $jogo->getCodtime2() . "<br/ >";
}

?>

<a href="index.php?conteudo=cadastrajogo"> Cadastrar Novo Jogo </a>
