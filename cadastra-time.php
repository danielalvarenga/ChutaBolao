<?php

require "bootstrap.php";

if(isset($_POST['time'])){
	$time = $entityManager->find("Time", $_POST['time']);
	$nomeTime = $time->getNomeTime();
	$codTime = $time->getCodTime();
	$entityManager->remove($time);
	$entityManager->flush();
	echo "Excluído time com o nome $nomeTime com código $codTime<br><br>";
}

if(isset($_POST['nome'])){
	//try{
	
	//$arquivo = $_FILES['arquivo'];
	//if ($arqError == 0) {
	//	$pasta = '/uploads/';
	//	$upload = move_uploaded_file($arqTemp, $pasta . $arqName);
	//}
	$nome = $_POST['nome'];
	$time = new Time($nome);
	$entityManager->persist($time);
	$entityManager->flush();
	//}
	//catch (Exception $e){
	//	echo ($e->getMensage());
	//}
	echo "Inserido time com o nome {$time->getNomeTime()}<br><br>";
	//print_r($arquivo);
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
			
			<p>Nome:<input type="text" name="nome" size="60"></p>
           <!--  Escudo:<input type="file" name="arquivo" class="width233" />  -->
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
		<td></td>
	</tr>

<?php
	$dqlTimes = "SELECT t FROM Time t ORDER BY t.codTime ASC";
	$queryTimes = $entityManager->createQuery($dqlTimes);
	$times = $queryTimes->getResult();
	foreach($times as $time) {
		if($time instanceof Time){
			echo '<tr vertical-align="middle" align="center">
					<td>'.$time->getCodtime().'</td>
					<td>'.$time->getNometime().'</td>
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
