<?php

require "bootstrap.php";

$data = date("Y-m-d");

if (isset($_POST[campeonato])) {
	
	/*print($_POST[datajogo]);
	print($_POST[rodada]);
	print($_POST[codtime1]);
	print($_POST[codtime2]);*/
	
	//$datetime = new DateTime('02-01-2013');
	$datetime = new DateTime($_POST[datajogo]);
	
	$jogo = new Jogo($datetime,$_POST[rodada],$_POST[codtime1],$_POST[codtime2]);
	//$jogo->setDataInicioApostas('2012-05-06');
	//$jogo->setDataFimApostas('2012-05-07');

	$entityManager->persist($jogo);
	$entityManager->flush();
	
	header("Location: index.php?conteudo=jogos");

}
else {

?>
<html>
<head>
<title>
cadastro de time
</title>
</head>
<body>

	<h1>Inserir Jogo</h1>
	
<p>

<form method="POST" action="">
 <p>
  Data: <input type="text" name="datajogo" size="20"></p>
  <p>Campeonato: 
	<select size="1" name="campeonato">
		<option value="1">camp1</option>
		<option selected value="2">camp2</option>
		<option value="3">camp3</option>
	</select>
  </p>
  <p>Rodada: <input type="text" name="rodada" size="20"></p>
  <p>Time1: 
	<select size="1" name="codtime1">
		<option value="1">Time1</option>
		<option selected value="2">Time2</option>
		<option value="3">Time3</option>
	</select>
  </p>
  <p>Time2: 
	<select size="1" name="codtime2">
		<option value="1">Time1</option>
		<option selected value="2">Time2</option>
		<option value="3">Time3</option>
	</select>
  </p>
  <p>Gols Time1: <input type="text" name="T5" size="20"></p>
  <p>Gols Time2: <input type="text" name="T6" size="20"></p>
  <p><input type="submit" value="Gravar" name="B1"></p>
</form>

</p>
<?php
}
?>
</body>
</html>