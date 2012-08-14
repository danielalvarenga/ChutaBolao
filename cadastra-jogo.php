<?php
include "valida_cookies.inc";
require "bootstrap.php";
require 'metodos-bd.php';

if(isset($_POST['excluir'])){
	$conn = $entityManager->getConnection();
	$conn->beginTransaction();
	try{
		$jogoExcluir = $entityManager->find("Jogo", $_POST['jogoExcluir']);
		$imgJogo = $jogoExcluir->getEscudosJogo();
		removeBancoDados($jogoExcluir);
		unlink("$imgJogo");
		echo "<script> alert('Jogo Excluído.')
		location = ('cadastra-jogo.php');
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
	
	// Testa se existem pelo menos 1campeonato cadastrado
	$camp = "SELECT c FROM Campeonato c WHERE c.status = 'ativo'";
	$campeonatos = consultaDqlMaxResult(1, $camp);
	$contador = 0;
	foreach($campeonatos as $campeonato) {
		if($campeonato instanceof Campeonato){
			$contador++;
		}
	}
	if($contador == 1){
	
	$conn = $entityManager->getConnection();
	$conn->beginTransaction();
	try{
	// Testa se existem 2 times cadastrados
		$dqlTime = "SELECT t FROM Time t";
		$times = consultaDqlMaxResult(2, $dqlTime);
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
						$conn = $entityManager->getConnection();
						$conn->beginTransaction();
						try{
							$camp = "SELECT c FROM Campeonato c WHERE c.status = 'ativo' ORDER BY c.nomeCampeonato DESC";
							$campeonatos = consultaDql($camp);
							foreach($campeonatos as $campeonato) {
								if($campeonato instanceof Campeonato){
									echo '<option value='.$campeonato->getCodCampeonato().'> '.$campeonato->getNomeCampeonato().' '.$campeonato->getAnoCampeonato().'</option>';
								}
							}
							$conn->commit();
						} catch(Exception $e) {
							$conn->rollback();
							echo $e->getMessage() . "<br/><font color=red>Dados não encontrados. Verifique o Banco de Dados.</font><br/>";
						}
						?>		
					</select>
					<a href="cadastra-campeonato.php">Cadastrar novo Campeonato</a>
					</p>
					<p>Tipo de Campeonato: 
					<select name="tipo">
						<option></option>
						<option value="nacional">Nacional</option>
						<option value="mundial">Mundial</option>
					</select>
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
				
				$jogos = consultaDql($dqlJogo);
					
				foreach($jogos as $jogo) {
				
					if($jogo instanceof Jogo){
						if($jogo->getCampeonato()->getStatus() != "finalizado"){
					
							$codTime1 = $jogo->getCodtime1();
							
							$codTime2 = $jogo->getCodtime2();
							
							$time1 = $entityManager->find("Time", $codTime1);
							
							$time2 = $entityManager->find("Time", $codTime2);
							
							?>
								<tr vertical-align="middle" align="center">
									<td><?php echo $jogo->getDatajogo();?></td>
									<td><?php echo $jogo->getCampeonato()->getNomeCampeonato();?> 
										<?php echo $jogo->getCampeonato()->getAnoCampeonato();?>
									</td>
									<td><?php echo $jogo->getRodada()->getNumRodada();?></td>
									<td>
											<img src="<?php echo $jogo->getEscudosJogo();?>">
									</td>
									<td>
										<?php
										if(($jogo->getGolstime1() === NULL) && ($jogo->getGolstime2() === NULL)){
										?>
											<form method="POST" action="insere-gols.php">
											 	<p align="center"><?php echo $time1->getNomeTime();?> 
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
												</select> <?php echo $time2->getNomeTime();?>
												<br/>
												<input type="hidden" name="jogo" value=<?php echo $jogo->getCodJogo();?>>
												<input type="submit" name="registra-resultado" value="Registrar Resultado"><br/>
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
									<td><?php echo $jogo->getDataInicioApostas();?></td>
									<td><?php echo $jogo->getDataFimApostas();?></td>
									<td>
										<form method="POST" action="">
										<input type="hidden" name="jogoExcluir" value="<?php echo $jogo->getCodjogo();?>">
										<input type="submit" name="excluir" value="Excluir"><br/>
										</form>
									</td>
								</tr>
							<?php
						}
					}
				}
				$conn->commit();
			} catch(Exception $e) {
				$conn->rollback();
				echo $e->getMessage() . "<br/><font color=red>Dados não encontrados. Verifique o Banco de Dados.</font><br/>";
			}
				?>
				</table>
			<?php 
			} else {
				echo 'É necessário ter no mínimo 2 Times cadastrados para cadastrar um jogo.';
				echo '<p align="center"><a href="cadastra-time.php">Cadastrar Times</a></p>';
			}
			$conn->commit();
		} catch(Exception $e) {
			$conn->rollback();
			echo $e->getMessage() . "<br/><font color=red>Dados de Times não encontrados. Verifique o Banco de Dados.</font><br/>";
		}
	} else{
		echo 'É necessário ter no mínimo 1 Campeonato Ativo para cadastrar um jogo.';
		echo '<p align="center"><a href="cadastra-campeonato.php">Cadastrar Campeonato</a></p>';
	}
	$conn->commit();
} catch(Exception $e) {
	$conn->rollback();
	echo $e->getMessage() . "<br/><font color=red>Dados de Campeonato não encontrados. Verifique o Banco de Dados.</font><br/>";
}
$conn->close();
?>

	<p align="center"><a href="admin.php">Menu Principal</a></p>
</body>
</html>
