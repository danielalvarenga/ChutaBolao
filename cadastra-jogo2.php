<?php

require "bootstrap.php";			
		
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

<form method="POST" action="cadastra-jogo3.php">
  
	<?php
	if(isset($_POST['campeonato'])){ ?>
		<input type="hidden" name="campeonato" value="<?php echo $_POST['campeonato'];?>">
		<?php
		$campeonato = $entityManager->find("Campeonato", $_POST['campeonato']);
		echo '<b>Campeonato:</b> '.$campeonato->getNomeCampeonato().' '.$campeonato->getAnoCampeonato().
				'<br/><font size="1"><a href="cadastra-jogo.php">Escolher outro Campeonato</a></font></p>';
	
		$dqlR = 'SELECT r FROM Rodada r WHERE r.campeonato = '.$_POST['campeonato'].'ORDER BY r.numRodada ASC';
		$querytR = $entityManager->createQuery($dqlR);
		$rodadas = $querytR->getResult();
		?>
		<p>Escolha a Rodada: 
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
	  	<p><input type="submit" value="Gravar" name="B1"></p>
  <?php
	} else{
		echo '<p align="center">Voc� n�o escolheu um Campeonato. <br/>
		<a href="cadastra-jogo.php">Escolher Campeonato</a></p>';
	}
  ?>
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
			<td>In�cio de Apostas</td>
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
<p align="center"><a href="admin.php">Menu Principal</a></p>
</body>
</html>