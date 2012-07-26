
<?php

$pagina = @$_GET["conteudo"];
switch ($pagina){
	case "home":
		$page = "includes/home.php";
		$title = "Chuta Bolão";
		$author = "";
		break;

	case "chutes":
		$page = "includes/apostas.php";
		$title = "Chutes";
		$author = "";
		break;

	case "encerrados":
		$page = "includes/apostas_antigas.php";
		$title = "Jogos Encerrados";
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
		$page = "includes/rankings.php";
		$title = "Ranks";
		$author = "";
		break;

	case "como-funciona":
		$page = "includes/como-funciona.php";
		$title = "Como Funciona";
		$author = "";
		break;

	default:
		$page = "includes/home.php";
		$title = "Chuta BolÃ£o";
		$author = "";
		break;

}
?>