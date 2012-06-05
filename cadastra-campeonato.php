<?php

use Doctrine\DBAL\Types\ArrayType;

use Doctrine\ORM\Query\AST\Functions\LengthFunction;

require "bootstrap.php";

if(isset($_POST['campeonato'])){
	$campeonato = $entityManager->find("Campeonato", $_POST['campeonato']);
	$nomeCampeonato = $campeonato->getNomeCampeonato();
	$anoCampeonato = $campeonato->getAnoCampeonato();
	$entityManager->remove($campeonato);
	$entityManager->flush();
	echo "Excluído Campeonato $nomeCampeonato $anoCampeonato<br><br>";
}

if(isset($_POST['nome'])){
	
	$nome = $_POST['nome'];
	$ano = $_POST['ano'];
	$quant = $_POST['quant'];
	$campeonato = new Campeonato($nome, $ano, $quant);	
	
	$entityManager->persist($campeonato);
	$entityManager->flush();
	
	for($i = 1; $i <= $quant; $i++){
		$rodada = new Rodada($i, $campeonato);
		$entityManager->persist($rodada);
		$entityManager->flush();
	}
	
	echo "Campeonato criado com: ";
	echo "Codigo: ".$campeonato->getCodCampeonato()."\n";
	echo "Nome: ".$campeonato->getNomeCampeonato()."\n";
	echo "Ano: ".$campeonato->getAnoCampeonato()."\n";
	echo "Quantidade de rodadas: ".$campeonato->getQuantidadeRodadas()."\n";
}

?>

<html>
<head>
<title>
cadastro de time
</title>
</head>
<body>

	<h1>Inserir Campeonato</h1>
	
	<form action="" method="POST" enctype="multipart/form-data">
			
			<p>Nome do campeonato:<input type="text" name="nome" size="60" maxlength="30"></p>
            <p>Ano:<input type="text" name="ano" size="60" maxlength="4"></p>
            <p>Quantidade de rodadas:<input type="text" name="quant" size="60" maxlength="2"></p>
            <p><input type="submit" name="salvar" value="Salvar" /></p>
    </form>
    
		<h3><p> Instruções para inserir </p> </h3>
		
		<p>1. Não importa se você irá inserir em minúscula ou maiuscula.
		<br>2.Não inserir nenhum tipo de acento.
		<br>3.Entre um nome e outro insira anderline.</p>
		<p>4. Exemplo de inserção:</p>
		<p>Nome do campeonato: "campeonato_brasileiro"</p>
		
			<h2>Campeonatos Cadastrados</h2>
<table border="1">
	<tr vertical-align="middle" align="center">
		<td>Código</td>
		<td>Nome</td>
		<td>Ano</td>
		<td>Rodadas</td>
		<td>Status</td>
		<td></td>
	</tr>

<?php
	$dqlCampeonatos = "SELECT c FROM Campeonato c ORDER BY c.codCampeonato ASC";
	$queryCampeonatos = $entityManager->createQuery($dqlCampeonatos);
	$campeonatos = $queryCampeonatos->getResult();
	foreach($campeonatos as $campeonato) {
		if($campeonato instanceof Campeonato){
			echo '<tr vertical-align="middle" align="center">
					<td>'.$campeonato->getcodCampeonato().'</td>
					<td>'.$campeonato->getNomeCampeonato().'</td>
					<td>'.$campeonato->getAnoCampeonato().'</td>
					<td>'.$campeonato->getQuantidadeRodadas().'</td>
					<td>'.$campeonato->getStatus().'</td>
					<td>
						<form method="POST" action="">
						<input type="hidden" name="campeonato" value='.$campeonato->getCodCampeonato().'>
						<input type="submit" name="excluir" value="Excluir"><br/>
						</form>
					</td>
				</tr>';
		}
	}
?>
</table>
		<p align="center"><a href="cadastra-time.php">Cadastrar Time</a></p>
		<p align="center"><a href="cadastra-jogo.php">Cadastrar Jogo</a></p>
		<p align="center"><a href="admin.php">Menu Principal</a></p>
</body>
</html>
