
<?php

$pagina = @$_GET["conteudo"];
switch ($pagina){
	case "home":
	$page = "includes/home.php";
	$title = "Chuta Bolão";
	$author = "";
	break;
	
	case "apostas":
	$page = "includes/apostas.php";
	$title = "Apostas";
	$author = "";
	break;
	
	case "classificacao":
	$page = "includes/classificacao.php";
	$title = "Classificação";
	$author = "";
	break;
	
	case "convites":
	$page = "includes/convites.php";
	$title = "Convites";
	$author = "";
	break;
	
	case "placares":
	$page = "includes/placares.php";
	$title = "Placares";
	$author = "";
	break;
	
	
	case "ranks":
	$page = "includes/ranks.php";
	$title = "Ranks";
	$author = "";
	break;
	

	
	default:
	$page = "includes/home.php";
	$title = "Chuta BolÃ£o";
	$author = "";
	break;
	
}
?>