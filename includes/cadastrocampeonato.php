<html>
<head>
<title>
cadastro de campenato
</title>
</head>
<body>

	<h1>Inserir campeonato</h1>
	
	<form action="../envia_cadastrocampeonato.php" method="POST" enctype="multipart/form-data">
			
			<p>Nome do campeonato:<input type="text" name="nome" size="60" maxlength="30"></p>
            <p>Ano:<input type="text" name="nome" size="60" maxlength="4"></p>
            <p>Quantidade de rodadas:<input type="text" name="nome" size="60" maxlength="2"></p>
            <p><input type="submit" name="salvar" value="Salvar" /></p>
    </form>
    
		<h3><p> Instru��es para inserir </p> </h3>
		
		<p>1. N�o importa se voc� ir� inserir em min�scula ou maiuscula.
		<br>2.N�o inserir nenhum tipo de acento.
		<br>3.Entre um nome e outro insira anderline.</p>
		<p>4. Exemplo de inser��o:</p>
		<p>Nome do campeonato: "campeonato_brasileiro"</p>
	
</body>
</html>
