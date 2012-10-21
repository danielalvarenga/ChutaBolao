<?php
include "valida_cookies.inc";
require "bootstrap.php";
require 'metodos-bd.php';

if(isset($_GET['excluir'])){
	$conn = $entityManager->getConnection();
	$conn->beginTransaction();
	try{
		$jogoExcluir = $entityManager->find("Jogo", $_GET['jogoExcluir']);
		$codCampeonato = $jogoExcluir->getCampeonato()->getCodCampeonato();
		$tipo = $_GET['tipo'];
		$numRodada = $jogoExcluir->getRodada()->getNumRodada();
		$imgJogo = $jogoExcluir->getEscudosJogo();
		removeBancoDados($jogoExcluir);
		unlink("$imgJogo");
		echo "<script> alert('Jogo Excluído.')
		location = ('cadastra-jogo3.php?campeonato=$codCampeonato&tipo=$tipo&rodada=$numRodada');
		</script>";
		$conn->commit();
	} catch(Exception $e) {
		$conn->rollback();
		echo $e->getMessage() . "<br/><font color=red>Não foi possível apagar os dados. Verifique o Banco de Dados.</font><br/>";
	}
	$conn->close();
}
$conn = $entityManager->getConnection();
$conn->beginTransaction();
try{
if(empty($_GET['codJogo'])){
	echo "<script> alert('Jogo não informado.')
	location = ('cadastra-jogo.php');
	</script>";
}
if(isset($_GET['codJogo'])){
	$jogo = buscaObjeto("Jogo", $_GET['codJogo']);
	$objCampeonato = $jogo->getCampeonato();
	$objRodada = $jogo->getRodada();
	$time1 = buscaObjeto("Time", $jogo->getCodTime1());
	$time2 = buscaObjeto("Time", $jogo->getCodTime2());
}

if (isset($_GET['atualizaJogo'])) {
	if($_GET['ano'] == "ano"){
		echo "<script> alert('Você não informou o novo ano para a data.');</script>";
	}
	elseif($_GET['mes'] == "mês"){
		echo "<script> alert('Você não informou o novo mês para a data.');</script>";
	}
	elseif($_GET['dia'] == "dia"){
		echo "<script> alert('Você não informou o novo dia para a data.');</script>";
	}
	elseif($_GET['hora'] == "hora"){
		echo "<script> alert('Você não informou a hora para o novo horário.');</script>";
	}
	elseif($_GET['minuto'] == "minuto"){
		echo "<script> alert('Você não informou os minutos para o novo horário.');</script>";
	}
	else{
		$data = $_GET['ano'].'-'.$_GET['mes'].'-'.$_GET['dia'].' '.$_GET['hora'].':'.$_GET['minuto'].':00';
		$dataJogo = new DateTime(''.$data.'', new DateTimeZone('America/Sao_Paulo'));
		$dataJogoString = $dataJogo->format( "Y-m-d H:i:s" );
		
		$jogo->setDataJogo($dataJogoString);
		atualizaBancoDados($jogo);
	}
}

	

?>
<html>
<head>
<title>
Cadastro de Jogos
</title>
</head>
<body>

	<h1>Cadastro de Jogos</h1>

<p>

<form method="GET" action="">
		<input type="hidden" name="tipo" value="<?php echo $_GET['tipo'];?>">
		<p>Data e Horário Atual: <?php echo $jogo->getDataLogica();?></p>
		<p>Nova Data 
	 	<select name="dia">
	 	<option>dia</option>
			<?php
				for($dia = 1 ; $dia <= 31 ; $dia++ ){
				$dia2 = $dia;
					if($dia2 <= 9){
						$dia2 = '0'.$dia;
						echo "<option value=$dia2>$dia2</option>";
					} else{
						echo "<option value=$dia>$dia</option>";
					}
				};
			?>
		</select>
		<select name="mes">
		<option>mês</option>
			<?php
				for($mes = 1 ; $mes <= 12 ; $mes++ ){
					$mes2 = $mes;
					if($mes2 <= 9){
						$mes2 = '0'.$mes;
						echo "<option value=$mes2>$mes2</option>";
					} else{
						echo "<option value=$mes>$mes</option>";
					}
				};
			?>
		</select>
		<select name="ano">
		<option>ano</option>
			<?php
				for($ano = 2012 ; $ano <= 2020 ; $ano++ ){
					echo "<option value=$ano>$ano</option>";
				};
			?>
		</select>
		</p>
		<p>Novo Horário  
	 	<select name="hora">
	 	<option>hora</option>
			<?php
				for($hora = 23 ; $hora >= 0 ; $hora-- ){
					$hora2 = $hora;
					if($hora2 <= 9){
						$hora2 = '0'.$hora;
						echo "<option value=$hora2>$hora2</option>";
					} else{
						echo "<option value=$hora>$hora</option>";
					}
				};
			?>
		</select>
		<select name="minuto">
		<option>minuto</option>
			<?php
				for($minuto = 0 ; $minuto <= 59 ; $minuto +=5 ){
					$minuto2 = $minuto;
					if($minuto2 <= 9){
						$minuto2 = '0'.$minuto;
						echo "<option value=$minuto2>$minuto2</option>";
					} else{
						echo "<option value=$minuto>$minuto</option>";
					}
				};
			?>
		</select>
		</p><input type="hidden" name="codJogo" value="<?php echo $jogo->getCodjogo();?>">
		<p><input type="submit" value="Atualizar Jogo" name="atualizaJogo"></p>
</form>

</p>

		<table border="1">
			<tr vertical-align="middle" align="center">
				<td>Data</td>
				<td>Campeonato</td>
				<td>Rodada</td>
				<td>Escudos</td>
				<td>Resultado</td>
				<td>Início de Apostas</td>
				<td>Fim de Apostas</td>
				<td></td>
			</tr>	
			<tr vertical-align="middle" align="center">
				<td><?php echo $jogo->getDataLogica();?></td>
				<td><?php echo $jogo->getCampeonato()->getNomeCampeonato();?> 
					<?php echo $jogo->getCampeonato()->getAnoCampeonato();?>
				</td>
				<td><?php echo $jogo->getRodada()->getNumRodada();?></td>
				<td>
					<img src="<?php echo $jogo->getEscudosJogo();?>" width="50px" height="50px">
				</td>
				<td>
					<?php
					if(($jogo->getGolstime1() === NULL) && ($jogo->getGolstime2() === NULL)){
					?>
						<form method="GET" action="insere-gols.php">
						 	<p align="center">
						 	<?php echo $time1->getNomeTime().' ';?>
						 	<img class="escudoTime" src="<?php echo $time1->getEscudo();?>" width="25px" height="25px"> 
						 	<select name="golsTime1">
						 		<option value="<?php echo $jogo->getGolstime1();?>"><?php echo $jogo->getGolstime1();?></OPTION>
								<?php
									for($gols = 0 ; $gols < 100 ; $gols++ ){
										echo "<option value=$gols>$gols</option>";
									};
								?>
							</select>
							 X 
							<select name="golsTime2">
								<option value="<?php echo $jogo->getGolstime2();?>"><?php echo $jogo->getGolstime2();?></OPTION>
								<?php
									for($gols = 0 ; $gols < 100 ; $gols++ ){
										echo "<option value=$gols>$gols</option>";
									};
								?>
							</select>
							<img class="escudoTime" src="<?php echo $time2->getEscudo();?>" width="25px" height="25px"> 
							<?php echo ' '.$time2->getNomeTime();?>
							<br/>
							<input type="hidden" name="tipo" value="<?php echo $_GET['tipo'];?>">
							<input type="hidden" name="jogo" value="<?php echo $jogo->getCodJogo();?>">
							<input type="submit" name="registra-resultado" value="Registrar Resultado">
							</p>
						</form>
					<?php
					}
					else{
						echo $time1->getNomeTime().' '.$jogo->getGolstime1().' X '.
							$jogo->getGolstime2().' '.$time2->getNomeTime();
					}
					?>
				</td>
				<td><?php echo $jogo->getDataLogicaInicioApostas();?></td>
				<td><?php echo $jogo->getDataLogicaFimApostas();?></td>
				<td>
					<form method="GET" action="">
					<input type="hidden" name="tipo" value="<?php echo $_GET['tipo'];?>">
					<input type="hidden" name="jogoExcluir" value="<?php echo $jogo->getCodjogo();?>">
					<input type="submit" name="excluir" value="Excluir"><br/>
					</form>
				</td>
			</tr>
	<?php
		$conn->commit();
	} catch(Exception $e) {
		$conn->rollback();
		echo $e->getMessage() . "<br/><font color=red>Dados não encontrados. Verifique o Banco de Dados.</font><br/>";
	}
	$conn->close();
	
	$codCampeonato = $jogo->getCampeonato()->getCodCampeonato();
	$tipo = $_GET['tipo'];
	$numRodada = $jogo->getRodada()->getNumRodada();
	$link = "cadastra-jogo3.php?campeonato=$codCampeonato&tipo=$tipo&rodada=$numRodada";
?>
</table>
	<p align="center"><a href="<?php echo $link;?>">Voltar</a></p>
	<p align="center"><a href="admin.php">Menu Principal</a></p>
</body>
</html>
