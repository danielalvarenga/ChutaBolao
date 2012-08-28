<?php
include "valida_cookies.inc";
require "bootstrap.php";
require 'metodos-bd.php';
if(isset($_POST["classificacao"])){
	$rendimentoTime = buscaObjeto("RendimentoTime", $_POST["codRendimentoTime"]);
	if($rendimentoTime instanceof RendimentoTime){
		$dql = "SELECT r FROM RendimentoTime r WHERE r.classificacao =".$_POST["classificacao"]."
				AND r.campeonato = ".$rendimentoTime->getCampeonato()->getCodCampeonato();
		$rendimentos = consultaDql($dql);
		foreach ($rendimentos as $rendimentoTimeTroca){
			$rendimentoTimeTroca->setClassificacao($rendimentoTime->getClassificacao());
			atualizaBancoDados($rendimentoTimeTroca);
		}
		$rendimentoTime->setClassificacao($_POST["classificacao"]);
		atualizaBancoDados($rendimentoTime);
	}
}
if(isset($_POST["atualiza"])){
	$dql = "SELECT c FROM Campeonato c WHERE c.status='ativo' ORDER BY c.codCampeonato ASC";
	$campeonatos = consultaDql($dql);
	foreach ($campeonatos as $campeonato){
		$codCampeonato = $campeonato->getCodCampeonato();
		$dql = "SELECT r FROM RendimentoTime r WHERE r.campeonato = '$codCampeonato' ORDER BY r.classificacao, r.pontos DESC";
		$rendimentosTimes = consultaDql($dql);
		$primeiro = true;
		$posicao = 1;
		foreach ($rendimentosTimes as $rendimentoTime){
			if($primeiro){
				$rendimentoTimeAnterior = $rendimentoTime;
				$primeiro = false;
			}
			elseif($rendimentoTime->getPontos() < $rendimentoTimeAnterior->getPontos()){
				$rendimentoTimeAnterior->setClassificacao($posicao);
				atualizaBancoDados($rendimentoTimeAnterior);
				$rendimentoTimeAnterior = $rendimentoTime;
				$posicao++;
			}
			elseif($rendimentoTime->getPontos() > $rendimentoTimeAnterior->getPontos()){
				$rendimentoTime->setClassificacao($posicao);
				atualizaBancoDados($rendimentoTime);
				$posicao++;
			}
			elseif($rendimentoTime->getVitorias() < $rendimentoTimeAnterior->getVitorias()){
				$rendimentoTimeAnterior->setClassificacao($posicao);
				atualizaBancoDados($rendimentoTimeAnterior);
				$rendimentoTimeAnterior = $rendimentoTime;
				$posicao++;
			}
			elseif($rendimentoTime->getVitorias() > $rendimentoTimeAnterior->getVitorias()){
				$rendimentoTime->setClassificacao($posicao);
				atualizaBancoDados($rendimentoTime);
				$posicao++;
			}
			elseif($rendimentoTime->getSaldoGols() < $rendimentoTimeAnterior->getSaldoGols()){
				$rendimentoTimeAnterior->setClassificacao($posicao);
				atualizaBancoDados($rendimentoTimeAnterior);
				$rendimentoTimeAnterior = $rendimentoTime;
				$posicao++;
			}
			elseif($rendimentoTime->getSaldoGols() > $rendimentoTimeAnterior->getSaldoGols()){
				$rendimentoTime->setClassificacao($posicao);
				atualizaBancoDados($rendimentoTime);
				$posicao++;
			}
			elseif($rendimentoTime->getGolsPro() < $rendimentoTimeAnterior->getGolsPro()){
				$rendimentoTimeAnterior->setClassificacao($posicao);
				atualizaBancoDados($rendimentoTimeAnterior);
				$rendimentoTimeAnterior = $rendimentoTime;
				$posicao++;
			}
			elseif($rendimentoTime->getGolsPro() > $rendimentoTimeAnterior->getGolsPro()){
				$rendimentoTime->setClassificacao($posicao);
				atualizaBancoDados($rendimentoTime);
				$posicao++;
			}
		}
		$rendimentoTimeAnterior->setClassificacao($posicao);
		atualizaBancoDados($rendimentoTimeAnterior);
	}
}

?>
<html>
<head>
<title>
Classificações
</title>
</head>
<body>

<h1>Classificação dos Campeonatos</h1>

<form action="" method="post">
<button type="submit" name="atualiza" value="atualiza">Atualizar Classificação</button>
</form>

<?php 
$dql = "SELECT c FROM Campeonato c WHERE c.status='ativo' ORDER BY c.codCampeonato ASC";
$campeonatos = consultaDql($dql);
foreach ($campeonatos as $campeonato){
	$codCampeonato = $campeonato->getCodCampeonato();
	$dql = "SELECT r FROM RendimentoTime r WHERE r.campeonato = '$codCampeonato' ORDER BY r.classificacao, r.pontos DESC";
	$rendimentosTimes = consultaDql($dql);
	?>
	<h3 align="center"><?php echo $campeonato->getNomeCampeonato()." ".$campeonato->getAnoCampeonato();?></h3>
	<center>
	<table border=1>
		<tr>
			<td>
			Nº
			</td>
			<td>
			Time
			</td>
			<td>
			P
			</td>
			<td>
			V
			</td>
			<td>
			E
			</td>
			<td>
			D
			</td>
			<td>
			GP
			</td>
			<td>
			GC
			</td>
			<td>
			SD
			</td>
			<td>
			</td>
		</tr>
		
	<?php 
	foreach ($rendimentosTimes as $classificacao){
		?>
		<tr>
			<td>
			<?php echo $classificacao->getClassificacao();?>
			</td>
			<td>
			<?php echo $classificacao->getTime()->getNomeTime();?>
			</td>
			<td>
			<?php echo $classificacao->getPontos();?>
			</td>
			<td>
			<?php echo $classificacao->getVitorias();?>
			</td>
			<td>
			<?php echo $classificacao->getEmpates();?>
			</td>
			<td>
			<?php echo $classificacao->getDerrotas();?>
			</td>
			<td>
			<?php echo $classificacao->getGolsPro();?>
			</td>
			<td>
			<?php echo $classificacao->getGolsContra();?>
			</td>
			<td>
			<?php echo $classificacao->getSaldoGols();?>
			</td>
			<td>
				<form action="" method="post">
				<input type="hidden" name="codRendimentoTime" value="<?php echo $classificacao->getId();?>">
				<input type="text" name="classificacao" size="3" maxlength="2">
				<input type="submit" name="salvar" value="Corrigir Classificação" />
				</form>
			</td>
		</tr>
		<?php
	}
	?>
	</table>
	</center>
	<br />
	<?php 
}
?>
</body>
</html>