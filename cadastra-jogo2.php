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
	$conn = $entityManager->getConnection();
	$conn->beginTransaction();
	try{
		if(isset($_POST['campeonato'])){ ?>
			<input type="hidden" name="campeonato" value="<?php echo $_POST['campeonato'];?>">
			<?php
			$campeonato = $entityManager->find("Campeonato", $_POST['campeonato']);
			echo '<b>Campeonato:</b> '.$campeonato->getNomeCampeonato().' '.$campeonato->getAnoCampeonato().
					'<br/><font size="1"><a href="cadastra-jogo.php">Escolher outro Campeonato</a></font></p>';
		
			$dqlR = 'SELECT r FROM Rodada r WHERE r.campeonato = '.$_POST['campeonato'].'ORDER BY r.numRodada ASC';
			$rodadas = consultaDql($dqlR);
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
			echo '<p align="center">Você não escolheu um Campeonato. <br/>
			<a href="cadastra-jogo.php">Escolher Campeonato</a></p>';
		}
		$conn->commit();
	} catch(Exception $e) {
		$conn->rollback();
		echo $e->getMessage() . "<br/><font color=red>Dados não encontrados. Verifique o Banco de Dados.</font><br/>";
	}
	$conn->close();
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
	$conn->close();
?>
	</table>
<p align="center"><a href="admin.php">Menu Principal</a></p>
</body>
</html>
