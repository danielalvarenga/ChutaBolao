<?php

require "bootstrap.php";
require_once "lib/WideImage.php";

if(isset($_POST['rodada']) && isset($_POST['campeonato'])){
	$objCampeonato = $entityManager->find("Campeonato", $_POST['campeonato']);
	$objRodada = $entityManager->find("Rodada", array(
			"numRodada" => $_POST['rodada'],
			"campeonato" => $_POST['campeonato']
	));
}
else{
	echo '<p align="center">Você não escolheu um Campeonato e uma rodada. <br/>
	<a href="cadastra-jogo.php">Escolher</a></p>';
}
		
if (isset($_POST['codtime1'])) {
	$conn = $entityManager->getConnection();
	$conn->beginTransaction();
	try{
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
		
		$time1 = $entityManager->find("Time", $_POST['codtime1']);
		$time2 = $entityManager->find("Time", $_POST['codtime2']);
		
		// Cria a imagem de publicação do jogo
		$urlEscudosJogo = 'imagens/jogos/'.
					strtolower(trim(
					str_replace('é', 'e',
					str_replace('ó', 'o',
					str_replace('á', 'a', 
					str_replace('í', 'i', 
					str_replace('ú', 'u', 
					str_replace('ê', 'e', 
					str_replace('ô', 'o', 
					str_replace('â', 'a', 
					str_replace('õ', 'o',
					str_replace('ã', 'a',
					str_replace(' ', '-', $time1->getNomeTime()
							)))))))))))))
					.'x'.
					strtolower(trim(
					str_replace('é', 'e',
					str_replace('ó', 'o',
					str_replace('á', 'a', 
					str_replace('í', 'i', 
					str_replace('ú', 'u', 
					str_replace('ê', 'e', 
					str_replace('ô', 'o', 
					str_replace('â', 'a', 
					str_replace('õ', 'o',
					str_replace('ã', 'a',
					str_replace(' ', '-', $time2->getNomeTime()
							)))))))))))))
					.'.png';
		$escudo1 = WideImage::load($time1->getEscudo());
		$escudo2 = WideImage::load($time2->getEscudo());
		$letraX = WideImage::load('imagens/jogos/x.png');
			
		$escudo1->resizeCanvas( 90, 90, 0, 'top', null, 'any', false);
		$escudo2->resizeCanvas( 90, 90, 'right', 'botton', null, 'any', false);
			
		$escudosJogo = $escudo1->resizeCanvas( 90, 90, 0, 'top', null, 'any', false)
		->merge($escudo2, "right", "bottom", 100)->merge($letraX);
		
		// Salva a imagem em um novo arquivo com 80% de qualidade
		$escudosJogo->saveToFile($urlEscudosJogo, null, 80);
		// Limpa a imagem da memória
		$escudo1->destroy();
		$escudo2->destroy();
		$letraX->destroy();
		
		//---------------------------------------------------------------------------------
	
		if($jogos <> NULL){
				echo '<font color="red"><b>Este jogo já existe.</b></font><br/>';
		} else{
					
		// Instancia um objeto RendimentoTime para cada Time deste jogo no Campeonato
					
				$rendimentoTime1 = $entityManager->find("RendimentoTime", array(
						"campeonato" => $_POST['campeonato'],
						"time" => $_POST['codtime1']
						));
				$rendimentoTime2 = $entityManager->find("RendimentoTime", array(
						"campeonato" => $_POST['campeonato'],
						"time" => $_POST['codtime2']
						));
					
				if(!$rendimentoTime1 instanceof RendimentoTime){
					$rendimentoTime1 = new RendimentoTime($objCampeonato, $time1);
					$entityManager->persist($rendimentoTime1);
					$entityManager->flush();
				}
				if(!$rendimentoTime2 instanceof RendimentoTime){
					$rendimentoTime2 = new RendimentoTime($objCampeonato, $time2);
					$entityManager->persist($rendimentoTime2);
					$entityManager->flush();
				}
		// -------------------------------------------------------------------------------------------------------------------
				
				$jogo = new Jogo($data,$objRodada,$_POST['codtime1'],$_POST['codtime2'], $objCampeonato, $urlEscudosJogo);
				$entityManager->persist($jogo);
				$entityManager->flush();
		}
		$conn->commit();
	} catch(Exception $e) {
		$conn->rollback();
		echo $e->getMessage() . "<br/><font color=red>Não foi possível gravar os dados. Verifique o Banco de Dados.</font><br/>";
	}
	$conn->close();
}
	

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

<form method="POST" action="">					
	<?php
	if(isset($_POST['rodada']) && isset($_POST['campeonato'])){ ?>
		<input type="hidden" name="campeonato" value="<?php echo $_POST['campeonato'];?>">
		<input type="hidden" name="rodada" value="<?php echo $_POST['rodada'];?>">
		<?php
		echo '<b>Campeonato:</b> '.$objCampeonato->getNomeCampeonato().' '.$objCampeonato->getAnoCampeonato().'<br/>';
		echo '<b>Rodada:</b> '.$objRodada->getNumRodada().
		'<br/><font size="1"><a href="cadastra-jogo.php">Escolher Novamente</a></font></p>';
		?>
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
		<td>Escudos</td>
		<td>Resultado</td>
		<td>Início de Apostas</td>
		<td>Fim de Apostas</td>
		<td></td>
	</tr>

<?php
	$conn = $entityManager->getConnection();
	$conn->beginTransaction();
	try{
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
						<td>
								<img src="'.$jogo->getEscudosJogo().'">
						</td>
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
		$conn->commit();
	} catch(Exception $e) {
		$conn->rollback();
		echo $e->getMessage() . "<br/><font color=red>Dados não encontrados. Verifique o Banco de Dados.</font><br/>";
	}
	$conn->close();
?>
</table>

	<p align="center"><a href="admin.php">Menu Principal</a></p>
</body>
</html>
