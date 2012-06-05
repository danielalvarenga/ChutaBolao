<?php

require "bootstrap.php";

// Testa se existem pelo menos 1campeonato cadastrado
$camp = "SELECT c FROM Campeonato c WHERE c.status = 'ativo'";
$queryc = $entityManager->createQuery($camp);
$queryc->setMaxResults(1);
$campeonatos = $queryc->getResult();
$contador = 0;
foreach($campeonatos as $campeonato) {
	if($campeonato instanceof Campeonato){
		$contador++;
	}
}
if($contador == 1){

// Testa se existem 2 times cadastrados
	$dqlTime = "SELECT t FROM Time t";
	$queryt = $entityManager->createQuery($dqlTime);
	$queryt->setMaxResults(2);
	$times = $queryt->getResult();
	$contador = 0;
	foreach($times as $time) {
		if($time instanceof Time){
			$contador++;
		}
	}
	if($contador == 2){
		
		if (isset($_POST['codtime1'])) {
			
			$codTime1 = $_POST['codtime1'];
			$codTime2 = $_POST['codtime2'];
			$codCampeonato = $_POST['campeonato'];
			
			$data = $_POST['ano'].'-'.$_POST['mes'].'-'.$_POST['dia'].' '.$_POST['hora'].':'.$_POST['minuto'].':00';
			$dataJogo = new DateTime(''.$data.'', new DateTimeZone('America/Sao_Paulo'));
			$dataJogoString = $dataJogo->format( "Y-m-d H:i:s" );
			
			$dqlJogo = "SELECT j FROM Jogo j WHERE
						j.codTime1 = '$codTime1' AND
						j.codTime2 = '$codTime2' AND
						j.campeonato = '$codCampeonato' AND
						j.dataJogo ='$dataJogoString'";
			$queryJ = $entityManager->createQuery($dqlJogo);
			$jogos = $queryJ->getResult();

			if($jogos <> NULL){
					echo "Este jogo já existe.<br/>";
			} else{
					$objCampeonato = $entityManager->find("Campeonato", $_POST['campeonato']);
					$ObjRodada = $entityManager->find("Rodada", array(
							"numRodada" => $_POST['rodada'],
							"campeonato" => $_POST['campeonato']
							));
						
					// ----------------------- Instancia um objeto RendimentoTime para cada Time deste jogo no Campeonato --------------------------
						
					$rendimentoTime1 = $entityManager->find("RendimentoTime", array(
							"campeonato" => $_POST['campeonato'],
							"time" => $_POST['codtime1']
							));
					$rendimentoTime2 = $entityManager->find("RendimentoTime", array(
							"campeonato" => $_POST['campeonato'],
							"time" => $_POST['codtime2']
							));
						
					if(!$rendimentoTime1 instanceof RendimentoTime){
						$time1 = $entityManager->find("Time", $_POST['codtime1']);
						$rendimentoTime1 = new RendimentoTime($objCampeonato, $time1);
						$entityManager->persist($rendimentoTime1);
						$entityManager->flush();
					}
					if(!$rendimentoTime2 instanceof RendimentoTime){
						$time2 = $entityManager->find("Time", $_POST['codtime2']);
						$rendimentoTime2 = new RendimentoTime($objCampeonato, $time2);
						$entityManager->persist($rendimentoTime2);
						$entityManager->flush();
					}
					// -------------------------------------------------------------------------------------------------------------------
					
					$jogo = new Jogo($data,$ObjRodada,$_POST['codtime1'],$_POST['codtime2'], $objCampeonato);
					$entityManager->persist($jogo);
					$entityManager->flush();
			}
		}
			
		
		?>
		<html>
		<head>
		<title>
		cadastro de jogo
		</title>
		</head>
		<body>
		
			<h1>Inserir Jogo</h1>
		
		<p>
		
		<form method="POST" action="">
		
		<p>Campeonato: <select size="1" name="campeonato">
		<?php
			$camp = "SELECT c FROM Campeonato c WHERE c.status = 'ativo' ORDER BY c.nomeCampeonato DESC";
			$queryc = $entityManager->createQuery($camp);
			$campeonatos = $queryc->getResult();
				foreach($campeonatos as $campeonato) {
					if($campeonato instanceof Campeonato){
						$codCampeonato = $campeonato->getCodCampeonato();
						$nomeCampeonato = $campeonato->getNomeCampeonato();
						$anoCampeonato = $campeonato->getAnoCampeonato();
						echo "<option value= $codCampeonato> $nomeCampeonato $anoCampeonato </option>";
					}
				}
		?>		
		</select>
		<a href="cadastra-campeonato.php">Cadastrar novo Campeonato</a>
		  </p>
		  
		<?php if(isset($_POST['campeonato'])){ ?>
				<input type="hidden" name="campeonato" value="<?php echo $_POST['campeonato'];?>">
				
					<?php 
							$dqlR = "SELECT r FROM Rodada r ORDER BY r.numRodada ASC";
							$querytR = $entityManager->createQuery($dqlR);
							$rodadas = $querytR->getResult();
					?>
					<p>Rodada: 
						<select name="rodada">
						<?php 
							foreach($rodadas as $rodada) {
								if($rodada instanceof Rodada){
									echo "<option value=".$rodada->getNumRodada().">".$rodada->getNumRodada()."</option>";
								}
							}
						?>
						</select>
					 </p>
					
					<?php if(isset($_POST['rodada'])){ ?>
					<input type="hidden" name="campeonato" value="<?php echo $_POST['campeonato'];?>">
					<input type="hidden" name="rodada" value="<?php echo $_POST['rodada'];?>">
							<p>Data do Jogo 
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
									for($ano = 2012 ; $ano <= 2030 ; $ano++ ){
										echo "<option value=$ano>$ano</option>";
									};
								?>
							</select></p>
							<p>Horário 
						 	<select name="hora">
						 	<option>hora</option>
								<?php
									for($hora = 0 ; $hora <= 23 ; $hora++ ){
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
									for($minuto = 0 ; $minuto <= 59 ; $minuto++ ){
										$minuto2 = $minuto;
										if($minuto2 <= 9){
											$minuto2 = '0'.$minuto;
											echo "<option value=$minuto2>$minuto2</option>";
										} else{
											echo "<option value=$minuto>$minuto</option>";
										}
									};
								?>
							</select></p>
							<?php 
									$time1 = "SELECT t FROM time t ORDER BY t.nomeTime ASC";
									$queryt1 = $entityManager->createQuery($time1);
									$times = $queryt1->getResult();
							?>
							<p>Time1: 
								<select size="1" name="codtime1">
								<?php 
									foreach($times as $time1) {
										echo "<option value=".$time1->getCodTime().">".$time1->getNomeTime()."</option>";
									}
								?>
								</select>
							 </p>
							 <p>Time2: 
								<select size="1" name="codtime2">
								<?php
									foreach($times as $time2) {
										$ctcod = $time2->getCodTime();
										
										echo "<option value=".$time2->getCodTime().">".$time2->getNomeTime()."</option>";
									}
								?>
								</select>
							  </p>
					<?php }?>
		  <?php }?>
		  <p><input type="submit" value="Gravar" name="B1"></p>
		</form>
		
		</p>
		

		<h2>Jogos Cadastrados</h2>
		<table border="1">
			<tr vertical-align="middle" align="center">
				<td>Data</td>
				<td>Campeonato</td>
				<td>Rodada</td>
				<td>Time1</td>
				<td>Time2</td>
				<td>Resultado</td>
				<td>Início de Apostas</td>
				<td>Fim de Apostas</td>
				<td></td>
			</tr>
		
		<?php
		$dqlJogo = "SELECT j FROM Jogo j ORDER BY j.campeonato DESC";
		
		$queryJogo = $entityManager->createQuery($dqlJogo);
		
		$jogos = $queryJogo->getResult();
			
		foreach($jogos as $jogo) {
		
			if($jogo instanceof Jogo){
			
				$codTime1 = $jogo->getCodtime1();
				
				$codTime2 = $jogo->getCodtime2();
				
				$time1 = $entityManager->find("Time", $codTime1);
				
				$time2 = $entityManager->find("Time", $codTime2);
				
				echo '<tr vertical-align="middle" align="center">
						<td>'.$jogo->getDatajogo().'</td>
						<td>'.$jogo->getCampeonato()->getNomeCampeonato().' '.$jogo->getCampeonato()->getAnoCampeonato().'</td>
						<td>'.$jogo->getRodada()->getNumRodada().'</td>
						<td>'.$time1->getNomeTime().'</td>
						<td>'.$time2->getNomeTime().'</td>
						<td>'.$jogo->getGolstime1().' X '.$jogo->getGolstime2().'</td>
						<td>'.$jogo->getDataInicioApostas().'</td>
						<td>'.$jogo->getDataFimApostas().'</td>
						<td>
							<form method="POST" action="insere-gols.php">
							<input type="hidden" name="jogo" value='.$jogo->getCodjogo().'>
							<input type="submit" name="insere-gols" value="Inserir Gols"><br/>
							</form>
						</td>
					</tr>';
			}
		}
		?>
		</table>
	<?php 
	} else {
		echo 'É necessário ter no mínimo 2 Times cadastrados para cadastrar um jogo.';
		echo '<p align="center"><a href="cadastra-time.php">Cadastrar Times</a></p>';
	}
} else{
	echo 'É necessário ter no mínimo 1 Campeonato Ativo para cadastrar um jogo.';
	echo '<p align="center"><a href="cadastra-campeonato.php">Cadastrar Campeonato</a></p>';
}
?>

	<p align="center"><a href="admin.php">Menu Principal</a></p>
</body>
</html>
