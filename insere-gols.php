<?php

require "bootstrap.php";


if (isset($_POST['jogo'])) {
	
	$codJogo = $_POST['jogo'];
	$jogo = $entityManager->find("Jogo", $codJogo);
	
	$codTime1 = $jogo->getCodTime1();
	$codTime2 = $jogo->getCodTime2();
	$time1 = $entityManager->find("Time", $codTime1);
	$time2 = $entityManager->find("Time", $codTime2);
	
	
	if($_POST['golsTime1']){
		
		$golsTime1 = $_POST['golsTime1'];
		$golsTime2 = $_POST['golsTime2'];
		$jogo->setResultado($golsTime1, $golsTime2);
		
		$entityManager->merge($jogo);
		$entityManager->flush();
		
		$jogo = $entityManager->find("Jogo", $_POST['jogo']);
		
		$codJogo = $jogo->getCodjogo();
		$dqlApostas = "SELECT a FROM Aposta a WHERE a.jogo = $codJogo";
		$queryApostas = $entityManager->createQuery($dqlApostas);
		$apostas = $queryApostas->getResult();
		
		foreach ($apostas as $aposta){
			if ($aposta instanceof Aposta){
				$aposta->calculaPontosAposta($jogo->getGolsTime1(),$jogo->getGolsTime2());
				
				$premiosUsuario = $entityManager->find("PremiosUsuario", array(
					"campeonato" =>	$jogo->getCampeonato()->getCodCampeonato(),
					"usuario" => $aposta->getUsuario()->getIdUsuario()
				));
				$premiosUsuario->calculaPontos($aposta->getPontosAposta());
				
				$entityManager->merge($premiosUsuario);
				$entityManager->flush();
			} else {
				throw new Exception("N�O EXISTEM APOSTAS PARA ESTE JOGO");
			}
			
		}
	}

?>
<html>
<head>
<title>
inserir gols
</title>
</head>
<body>

	<h1 align="center">Inserir Gols</h1>
<br/><br/>
		<h2 align="center">Jogo</h2>
	<table border="1" align="center">
		<tr vertical-align="middle" align="center">
			<td><b>Data</b></td>
			<td><b>Campeonato</b></td>
			<td><b>Rodada</b></td>
			<td><b>Time1</b></td>
			<td><b>Time2</b></td>
			<td><b>Resultado</b></td>
			<td><b>In�cio de Apostas</b></td>
			<td><b>Fim de Apostas</b></td>
		</tr>
<?php
	echo '
			<tr vertical-align="middle" align="center">
				<td>'.$jogo->getDatajogo().'</td>
				<td>'.$jogo->getCampeonato()->getNomeCampeonato().' '.$jogo->getCampeonato()->getAnoCampeonato().'</td>
				<td>'.$jogo->getRodada().'</td>
				<td>'.$time1->getNomeTime().'</td>
				<td>'.$time2->getNomeTime().'</td>
				<td>'.$jogo->getGolstime1().' X '.$jogo->getGolstime2().'</td>
				<td>'.$jogo->getDataInicioApostas().'</td>
				<td>'.$jogo->getDataFimApostas().'</td>
			</tr>';
?>
</table>
<br/><br/>
		<h2 align="center">Resultado</h2>
	<form method="POST" action="">
	 	<p align="center"><?php echo $time1->getNomeTime()?> 
	 	<select name="golsTime1">';
	 		<option value="NULL"></OPTION>
			<?php
				for($gols = 0 ; $gols < 100 ; $gols++ ){
					echo "<option value=$gols>$gols</option>";
				};
			?>
		</select>
		 X 
		<select name="golsTime2">
			<option value="NULL"></OPTION>
			<?php
				for($gols = 0 ; $gols < 100 ; $gols++ ){
					echo "<option value=$gols>$gols</option>";
				};
			?>
		</select> <?php echo $time2->getNomeTime();?>
		<br/>
		<input type="hidden" name="jogo" value=<?php echo $jogo->getCodjogo();?>>
		<input type="submit" name="registra-resultado" value="Registrar Resultado"><br/>
		</p>
	</form>
<?php
}
?>
	<br/><br/><br/>
	<p align="center"><a href="cadastra-jogo.php">Voltar para Jogos</a></p>
		<p align="center"><a href="admin.php">Menu Principal</a></p>
</body>
</html>