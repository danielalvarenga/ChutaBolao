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
	echo "Exclu�do time com o nome $nomeTime com c�digo $codTime<br><br>";
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
		
			// Largura m�xima em pixels
			$largura = 47;
			// Altura m�xima em pixels
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
					// Pega extens�o da imagem
					preg_match("/\.(gif|bmp|png|jpg|jpeg){1}$/i", $imagem["name"], $ext);
					
					$nomeUrlEscudo = strtolower(trim(
									str_replace('�', 'e',
									str_replace('�', 'o',
									str_replace('�', 'a', 
									str_replace('�', 'i', 
									str_replace('�', 'u', 
									str_replace('�', 'e', 
									str_replace('�', 'o', 
									str_replace('�', 'a', 
									str_replace('�', 'o',
									str_replace('�', 'a',
									str_replace(' ', '-', $nome)
											)))))))))))).$largura.'x'.$altura;
					
					// Gera um nome �nico para a imagem
					$nome_imagem = $nomeUrlEscudo."." . $ext[1];
			
					// Caminho de onde ficar� a imagem
					$caminho_imagem = "imagens/escudos/" . $nome_imagem;
			
					// Faz o upload da imagem para seu respectivo caminho
					move_uploaded_file($imagem["tmp_name"], $caminho_imagem);
					
					$time = new Time($nome, $caminho_imagem);
					$entityManager->persist($time);
					$entityManager->flush();
				}
				else{
					echo "<font color='red'><b>Este time j� existe.</b></font>";
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
    
		<h3><p> Instru��es para inserir </p> </h3>
		
		<p>1. N�o importa se voc� ir� inserir em min�scula ou maiuscula.
		<br>2.N�o inserir nenhum tipo de acento.
		<br>2. Insira o nome do time seguido de tra�o e sigla do estado do time.
		<br>3. Se o time for extrangeiro inserir a sigla do pa�s.</p>
		<p>5. Exemplo de inser��o:</p>
		<p>Time do Brasil: "comercial-pi"
		<br>Time extrageiro: "milan-ita"</p>
		
		
		<h2>Times Cadastrados</h2>
<table border="1">
	<tr vertical-align="middle" align="center">
		<td>C�digo</td>
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
