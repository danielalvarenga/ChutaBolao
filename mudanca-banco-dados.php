<?php
require ("bootstrap.php");

$dql = 'SELECT a FROM Aposta a WHERE a.apostaGolsTime1=0
AND a.apostaGolsTime2=0
AND a.pontosAposta=0';
$query = $entityManager->createQuery($dql);
$apostas = $query->getResult();
foreach ($apostas as $aposta){
	if($aposta instanceof Aposta){
		$entityManager->remove($aposta);
		$entityManager->flush();
	}
}
echo 'excluídas apostas1.';

$dql = 'SELECT a FROM Aposta a WHERE a.apostaGolsTime1=" "
OR a.apostaGolsTime2=" "
AND a.pontosAposta=0';
$query = $entityManager->createQuery($dql);
$apostas = $query->getResult();
foreach ($apostas as $aposta){
	if($aposta instanceof Aposta){
		$entityManager->remove($aposta);
		$entityManager->flush();
	}
}
echo 'excluídas apostas1.';

$opcao1 = '   X   ';
$opcao2 = '   X  0';
$opcao3 = '0  X  0';
$dql = 'SELECT c FROM ContadorAposta c WHERE c.opcaoCadastrada='.$opcao1.'
AND c.opcaoCadastrada='.$opcao2.'
AND c.opcaoCadastrada='.$opcao3;
$query = $entityManager->createQuery($dql);
$contadorapostas = $query->getResult();
foreach ($contadorapostas as $contadoraposta){
	if($contadoraposta instanceof ContadorAposta){
		$entityManager->remove($contadoraposta);
		$entityManager->flush();
	}
}
echo 'excluídas apostas.';