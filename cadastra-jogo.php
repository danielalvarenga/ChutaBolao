<?php
include "valida_cookies.inc";
require "bootstrap.php";
require 'metodos-bd.php';

if(isset($_GET['excluir'])){
	$conn = $entityManager->getConnection();
	$conn->beginTransaction();
	try{
		$jogoExcluir = $entityManager->find("Jogo", $_GET['jogoExcluir']);
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
				Cadastro de Jogos e Resultados
				</title>
				</head>
				<body>
				
					<h1>Cadastro de Jogos e Resultados</h1>

				<p>
				<form method="GET" action="cadastra-jogo2.php">
						
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
						<option value="nacional">Nacional</option>
						<option value="mundial">Mundial</option>
					</select>
					</p>
					<p><input type="submit" value="Próximo" name="passo1"></p>
				</form>
				
				</p>

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
