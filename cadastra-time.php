<?php

require "bootstrap.php";

if(isset($_POST['time'])){
	$time = $entityManager->find("Time", $_POST['time']);
	$escudo = $time->getEscudo();
	$nomeTime = $time->getNomeTime();
	$codTime = $time->getCodTime();
	$entityManager->remove($time);
	$entityManager->flush();
	unlink("$escudo");
	echo "Excluído time com o nome $nomeTime com código $codTime<br><br>";
}

if(isset($_POST['nome'])){
	
	
	if(empty($_POST['nome'])){
		echo "<script> alert('Campo \"nome\" obrigatorio!')
		location = ('cadastra-time.php');
		</script>";
	}
	else{
		$nome = $_POST['nome'];
		$imagem = $_FILES["escudo"];
		// Se a foto estiver sido selecionada
		if (!empty($imagem["name"])) {
		
			// Largura máxima em pixels
			$largura = 47;
			// Altura máxima em pixels
			$altura = 47;

			$dimensoes = getimagesize($imagem["tmp_name"]);

			if($dimensoes[0] <= $largura && $dimensoes[1] <= $altura){
				$dqlTime = "SELECT t FROM Time t WHERE t.nomeTime = '$nome'";
				$queryT = $entityManager->createQuery($dqlTime);
				$queryT->setMaxResults(1);
				$times = $queryT->getResult();
				$contador = 0;
				foreach($times as $time) {
					if($time instanceof Time){
						$contador++;
					}
				}
				if($contador == 0){
					// Pega extensão da imagem
					preg_match("/\.(gif|bmp|png|jpg|jpeg){1}$/i", $imagem["name"], $ext);
					
					$nomeUrlEscudo = strtolower(trim(
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
									str_replace(' ', '-', $nome)
											)))))))))))).$largura.'x'.$altura;
					
					// Gera um nome único para a imagem
					$nome_imagem = $nomeUrlEscudo."." . $ext[1];
			
					// Caminho de onde ficará a imagem
					$caminho_imagem = "imagens/escudos/" . $nome_imagem;
			
					// Faz o upload da imagem para seu respectivo caminho
					move_uploaded_file($imagem["tmp_name"], $caminho_imagem);
					
					$time = new Time($nome, $caminho_imagem);
					$entityManager->persist($time);
					$entityManager->flush();
				}
				else{
					echo "<font color='red'><b>Este time já existe.</b></font>";
				}
			}
		}
	}
}
?>

<html>
<head>
<title>
cadastro de time
</title>
</head>
<body>

	<h1>Inserir time</h1>
	
	<form action="" method="POST" enctype="multipart/form-data">
			
			<p>Nome: <input type="text" name="nome" size="60"></p>
           	<p>Escudo: <input type="file" name="escudo"/></p>
            <p><input type="submit" name="salvar" value="Salvar" /></p>
    </form>
    
		<h3><p> Instruções para inserir </p> </h3>
		
		<p>1. Não importa se você irá inserir em minúscula ou maiuscula.
		<br>2.Não inserir nenhum tipo de acento.
		<br>2. Insira o nome do time seguido de traço e sigla do estado do time.
		<br>3. Se o time for extrangeiro inserir a sigla do país.</p>
		<p>5. Exemplo de inserção:</p>
		<p>Time do Brasil: "comercial-pi"
		<br>Time extrageiro: "milan-ita"</p>
		
		
		<h2>Times Cadastrados</h2>
<table border="1">
	<tr vertical-align="middle" align="center">
		<td>Código</td>
		<td>Time</td>
		<td>Escudo</td>
		<td></td>
	</tr>

<?php
	$dqlTimes = "SELECT t FROM Time t ORDER BY t.nomeTime ASC";
	$queryTimes = $entityManager->createQuery($dqlTimes);
	$times = $queryTimes->getResult();
	foreach($times as $time) {
		if($time instanceof Time){
			echo '<tr vertical-align="middle" align="center">
					<td>'.$time->getCodtime().'</td>
					<td>'.$time->getNometime().'</td>
					<td><img src="'.$time->getEscudo().'"></td>
					<td>
						<form method="POST" action="">
						<input type="hidden" name="time" value='.$time->getCodTime().'>
						<input type="submit" name="excluir" value="Excluir"><br/>
						</form>
					</td>
				</tr>';
		}
	}
?>
</table>
		<p align="center"><a href="cadastra-campeonato.php">Cadastrar Campeonato</a></p>
		<p align="center"><a href="cadastra-jogo.php">Cadastrar Jogo</a></p>
		<p align="center"><a href="admin.php">Menu Principal</a></p>
</body>
</html>
