<html>
<head>
<title>
cadastro de time
</title>
</head>
<body>
	<form action="envia_cadastro_time.php">
		<p>Nome do time: <input type="text" name="nome" size="20"></p>
		<p><input type="submit" value="Salvar" name="salvar"></p>
		<p><h3>Instruções para inserir</h3></p>
		<p>1. Não importa se você irá inserir em minúscula ou maiuscula.
		<br>2.Não inserir nenhum tipo de acento.
		<br>2. Insira o nome do time seguido de traço e sigla do estado do time.
		<br>3. Se o time for extrangeiro inserir a sigla do país.</p>
		<p>5. Exemplo de inserção:</p>
		<p>Time do Brasil: "comercial-pi"
		<br>Time extrageiro: "milan-ita"</p>
		<?php echo "xyz"?>
	</form>
</body>
</html>
