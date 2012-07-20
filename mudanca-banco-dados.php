<?php
require ("bootstrap.php");
require 'metodos-bd.php';

$dql = 'SELECT a FROM Aposta a WHERE a.apostaGolsTime1=0
AND a.apostaGolsTime2=0
AND a.pontosAposta=0';
$apostas = consultaDql($dql);
foreach ($apostas as $aposta){
	if($aposta instanceof Aposta){
		removeBancoDados($aposta);
		}
}
echo 'excluídas apostas1.';

$dql = 'SELECT a FROM Aposta a WHERE a.apostaGolsTime1=" "
OR a.apostaGolsTime2=" "
AND a.pontosAposta=0';
$apostas = consultaDql($dql);
foreach ($apostas as $aposta){
	if($aposta instanceof Aposta){
		removeBancoDados($aposta);
		}
}
echo 'excluídas apostas1.';

$opcao1 = '   X   ';
$opcao2 = '   X  0';
$opcao3 = '0  X  0';
$dql = 'SELECT c FROM ContadorAposta c WHERE c.opcaoCadastrada='.$opcao1.'
AND c.opcaoCadastrada='.$opcao2.'
AND c.opcaoCadastrada='.$opcao3;
$contadorapostas = consultaDql($dql);
foreach ($contadorapostas as $contadoraposta){
	if($contadoraposta instanceof ContadorAposta){
		removeBancoDados($contadoraposta);
		}
}
echo 'excluídas apostas.';