<?php

/****************************************************************************************************************************************************************
*	Arquivo contendo a consulta para listagem do jogo
*	Ta faltando, um JOIN nas tabelas de Jogo e Time para poder apresentar o nome do time ao inves do codTime1 e codTime2
*	Ultima modificação: 01/05/2012 por Clairton
***************************************************************************************************************************************************************/

require "bootstrap.php";

$data = date("Y-m-d");

$dql = "SELECT j FROM jogo j ORDER BY j.id ASC";

$query = $entityManager->createQuery($dql);
$jogo = $query->getResult();

	echo "<table><tr><td>Rodada&nbsp;&nbsp;&nbsp;&nbsp;</td><td>Time1&nbsp;&nbsp;&nbsp;&nbsp;</td><td>Time2&nbsp;&nbsp;&nbsp;&nbsp;</td><td>Período das apostas</td></tr><tr>";

foreach($jogo as $jogo) {

	$cdTime1 =  $jogo->getCodtime1();
	$time1 = $entityManager->find("Time", $cdTime1);
	$nmTime1 = $time1->getNomeTime();

	$cdTime2 =  $jogo->getCodtime2();
	$time2 = $entityManager->find("Time", $cdTime2);
	$nmTime2 = $time2->getNomeTime();

    echo "<td>".$jogo->getRodada() . "</td><td> " .  $nmTime1 . "&nbsp;</td><td>" . $nmTime2 . "&nbsp;</td><td> de 00/00/0000 até 00/00/0000 </td></tr><tr>";
}

echo "</tr></table><br/ >";

?>z

<a href="index.php?conteudo=cadastra-jogo"> Cadastrar Novo Jogo </a>
