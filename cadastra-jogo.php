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
		
	?>
		<html>
		<head>
		<title>
		cadastro de jogo
		</title>
		</head>
		<body>
		
			<h1>Cadastrar novo Jogo</h1>
		
		<p>
		
		<form method="POST" action="cadastra-jogo2.php">
				
			<p>Escolha o Campeonato:
			<select size="1" name="campeonato">
			<option></option>
				<?php
				$camp = "SELECT c FROM Campeonato c WHERE c.status = 'ativo' ORDER BY c.nomeCampeonato DESC";
				$queryc = $entityManager->createQuery($camp);
				$campeonatos = $queryc->getResult();
					foreach($campeonatos as $campeonato) {
						if($campeonato instanceof Campeonato){
							echo '<option value='.$campeonato->getCodCampeonato().'> '.$campeonato->getNomeCampeonato().' '.$campeonato->getAnoCampeonato().'</option>';
						}
					}
				?>		
			</select>
			<a href="cadastra-campeonato.php">Cadastrar novo Campeonato</a>
			</p>
			<p><input type="submit" value="Próximo" name="passo1"></p>
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
