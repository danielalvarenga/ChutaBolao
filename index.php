<?php require"links_index.php"; ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Chuta Bol&atilde;o</title>
<link href="estilos/folha.css" rel="stylesheet" type="text/css" />
</head>

<body>
<!-- logo-->

<div id="principal">

	<div id="top">
    	
        <div id="topleft">
        </div>
        
        <div id="topright">
        <h2 align="center"> <br /><br />Banner</h2>
        </div>
        
    </div>
<!-- Menu   xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx-->

	<div id="areamenu">
    <ul id="menu">
    <li><a href="index.php?conteudo=home" title="Home">Home</a></li>
	<li><a href="index.php?conteudo=apostas" title="Apostas">Apostas</a></li>
    <li><a href="index.php?conteudo=classificacao" title="Classificação">Classificação</a></li>
	<li><a href="index.php?conteudo=convites" title="Convites">Convites</a></li>
	<li><a href="index.php?conteudo=placares" title="placares">Placares</a></li>
	<li><a href="index.php?conteudo=ranks" title="Ranks">Ranks</a></li>
    </ul>
    </div>
    
<!-- pagina principal   xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx-->

    <div id="content"><?php include $page; ?></div>

<!-- rodapé    xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx-->

	<div id="footer"><p>Copyright © 2012</p></div>
    
<!-- xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx-->

</div>



</body>
</html>
