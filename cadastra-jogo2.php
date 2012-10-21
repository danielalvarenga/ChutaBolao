<?php
include "valida_cookies.inc";
require "bootstrap.php";			
require 'metodos-bd.php';

if(empty($_GET['campeonato'])){
	echo "<script> alert('Você não informou o nome do Campeonato.')
	location = ('cadastra-jogo.php');
	</script>";
}

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

<form method="GET" action="cadastra-jogo3.php">
  
	<?php
	$conn = $entityManager->getConnection();
	$conn->beginTransaction();
	try{
		if(isset($_GET['campeonato']) && isset($_GET['tipo'])){ ?>
			<input type="hidden" name="campeonato" value="<?php echo $_GET['campeonato'];?>">
			<input type="hidden" name="tipo" value="<?php echo $_GET['tipo'];?>">
			<?php
			$campeonato = $entityManager->find("Campeonato", $_GET['campeonato']);
			echo '<b>Campeonato:</b> '.$campeonato->getNomeCampeonato().' '.$campeonato->getAnoCampeonato().
					'<br/><font size="1"><a href="cadastra-jogo.php">Escolher outro Campeonato</a></font></p>';
		
			$dqlR = 'SELECT r FROM Rodada r WHERE r.campeonato = '.$_GET['campeonato'].'ORDER BY r.numRodada ASC';
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
		  	<p><input type="submit" value="Próximo" name="B1"></p>
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
<p align="center"><a href="admin.php">Menu Principal</a></p>
</body>
</html>
