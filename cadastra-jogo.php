<?php
include "valida_cookies.inc";
require "bootstrap.php";
require 'metodos-bd.php';

if(isset($_POST['excluir'])){
	$conn = $entityManager->getConnection();
	$conn->beginTransaction();
	try{
		$jogoExcluir = $entityManager->find("Jogo", $_POST['jogoExcluir']);
		removeBancoDados($jogoExcluir);
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
									<form method="POST" action="">
									<input type="hidden" name="jogoExcluir" value='.$jogo->getCodjogo().'>
									<input type="submit" name="excluir" value="Excluir"><br/>
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
