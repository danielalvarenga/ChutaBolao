<?php

require "bootstrap.php";


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
	
</body>
</html>
