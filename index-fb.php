<?php
$charsetArray[1] = 'utf-8';
$charsetArray[2] = 'ISO-8859-1';
$charset = $charsetArray[2];
header('Content-type: text/html; charset='.$charset);
include 'config.php';
require "bootstrap.php";
require 'metodos-bd.php';
require_once 'FacebookApi/facebook.php';

$config = array(
		'appId' => $app_id,
		'secret' => $app_secret);
$facebook = new Facebook($config);
?>

<?php
@session_start();

function proxy($url){
	$context = stream_context_create(array('http'=>array('ignore_errors'=>true)));
	$data = file_get_contents($url, FALSE, $context);
	return $data;
}

if(empty($_SESSION["facebook_token"])){

}else{
	$token = $_SESSION["facebook_token"];
	$dados_usuario = json_decode(proxy("https://graph.facebook.com/me/?access_token=".$token),true);
	//print_r($dados_usuario);
	$user_id = $dados_usuario['id'];
	try {				
		$usuario = buscaObjeto("Usuario", $user_id);
			
		if($usuario instanceof Usuario){
			$usuario->setTokenUsuario($token);
			atualizaBancoDados($usuario);
		}
		else{
			$conn = $entityManager->getConnection();
			$conn->beginTransaction();
			try{
				
				$primeiroNomeUsuario = $dados_usuario['first_name'];
				$segundoNomeUsuario = $dados_usuario['last_name'];
				$emailUsuario = $dados_usuario['email'];
				
				$usuario = new Usuario($user_id, $token, $primeiroNomeUsuario, $segundoNomeUsuario, $emailUsuario);
				salvaBancoDados($usuario);
				
				$pontuacaoGeral = new PontuacaoGeral($usuario);
				salvaBancoDados($pontuacaoGeral);
				
				$conn->commit();
			} catch(Exception $e) {
				desfazTransacao($e);
			}
			
			$message = 'Agora vou mostrar quem entende de futebol! =D';
			$picture = 'http://www.chutabolao.com.br/facebook/imagens/publicacoes/chuta-bolao-logo.png';
			$link = 'http://apps.facebook.com/chutabolao';
			$name = $primeiroNomeUsuario.' agora "Chuta Bolão"';
			$caption = 'Seu time vai ganhar esse Campeonato?';
			$description = 'Faça seus Chutes e acerte o placar dos melhores jogos do Campeonato.';
			
			$ret_obj = $facebook->api('/'.$user_id.'/feed', 'POST',	array(
					'access_token' => utf8_encode($token),
					'link' => utf8_encode($link),
					'message' => utf8_encode($message),
					'name' => utf8_encode($name),
					'picture' => $picture,
					'caption' => utf8_encode($caption),
					'description' => utf8_encode($description)
			));
			
		}
	} catch (FacebookApiException $e) {
		//echo '<pre>'.htmlspecialchars(print_r($e, true)).'</pre>';
		$user = null;
		echo("<script> top.location.href='index.php'</script>");
	}

?>
<?php require"links_index.php"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php echo '<meta http-equiv="Content-Type" content="text/html; charset='.$charset.'" />'; ?>
<title>Chuta Bolão</title>
<link href="estilos/folha.css" rel="stylesheet" type="text/css" />

<!---------------------------Google Analytics---------------------------->
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-31194475-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
<!------------------------------------------------------------------------>

</head>
<?php 
$conteudo = $_GET['conteudo'];
switch ($conteudo){
	case 'home':{
		$idMenuBody = "tsmenu1";
		break;
	}
	case 'chutes':{
		$idMenuBody = "tsmenu2";
		break;
	}
	case 'classificacao':{
		$idMenuBody = "tsmenu3";
		break;
	}
	case 'convites':{
		$idMenuBody = "tsmenu4";
		break;
	}
	case 'placares':{
		$idMenuBody = "tsmenu5";
		break;
	}
	case 'ranks':{
		$idMenuBody = "tsmenu6";
		break;
	}
	case 'encerrados':{
		$idMenuBody = "tsmenu7";
		break;
	}
	case 'como-funciona':{
		$idMenuBody = "tsmenu8";
		break;
	}
	default:{
		$idMenuBody = "tsmenu1";
		break;
	}
}
?>

<body background="imagens/campo-futebol.png" id="<?php echo $idMenuBody;?>">
		
		<!-- CabeÃ§alho -->
		
		<div id="principal">
				
		<div id="cabecalho">
				 
			<div id="logo">
				<img src="imagens/logo.png">
			</div>			
			
			<div id="banner">
				<p>
				<a target="_blank" href="https://www.facebook.com/sertaogames">
					<img src="imagens/banners/sertao-games.png">
				</a>
				</p>
				<div id="curtir">
					<iframe src="//www.facebook.com/plugins/like.php?href=https%3A%2F%2Fwww.facebook.com%2Fsertaogames&amp;send=false&amp;layout=button_count&amp;width=100&amp;show_faces=false&amp;action=like&amp;colorscheme=light&amp;font&amp;height=21&amp;appId=104984016274497" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:100px; height:21px;" allowTransparency="true"></iframe>
				</div>
			</div>
			<div id="banner">
				<p>
				<a target="_blank" href="https://www.facebook.com/osmosqueteiros">
					<img src="imagens/banners/os-mosqueteiros.png">
				</a>
				</p>
				<div id="curtir">
				<iframe src="//www.facebook.com/plugins/like.php?href=https%3A%2F%2Fwww.facebook.com%2FOsMosqueteiros&amp;send=false&amp;layout=button_count&amp;width=100&amp;show_faces=false&amp;action=like&amp;colorscheme=light&amp;font&amp;height=21&amp;appId=104984016274497" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:100px; height:21px;" allowTransparency="true"></iframe>
				</div>
			</div>
			<div id="banner">
				<p>
				<a target="_blank" href="https://www.facebook.com/querocarona">
					<img src="imagens/banners/quero-carona.png">
				</a>
				</p>
				<div id="curtir">
				<iframe src="//www.facebook.com/plugins/like.php?href=https%3A%2F%2Fwww.facebook.com%2Fquerocarona&amp;send=false&amp;layout=button_count&amp;width=100&amp;show_faces=false&amp;action=like&amp;colorscheme=light&amp;font&amp;height=21&amp;appId=104984016274497" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:100px; height:21px;" allowTransparency="true"></iframe>
				</div>
			</div>
			<div id="banner">
				<p>
				<a target="_blank" href="https://www.facebook.com/chutabolao">
					<img src="imagens/banners/chuta-bolao.png">
				</a>
				</p>
				<div id="curtir">
				<iframe src="//www.facebook.com/plugins/like.php?href=https%3A%2F%2Fwww.facebook.com%2FChutaBolao&amp;send=false&amp;layout=button_count&amp;width=100&amp;show_faces=false&amp;action=like&amp;colorscheme=light&amp;font&amp;height=21&amp;appId=104984016274497" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:100px; height:21px;" allowTransparency="true"></iframe>
				</div>
			</div>
			
		
		</div>
		
		<div id="boxMenu">
			<div id="ts_tabmenu">
		        <ul>
					<li id="li_tsmenu1"><a href="index-fb.php?conteudo=home" title="Home"><strong>Início</strong></a></li>
					<li id="li_tsmenu2"><a href="index-fb.php?conteudo=chutes" title="Chutes"><strong>Jogos&nbsp;Liberados</strong></a></li>
					<!--  <li id="li_tsmenu3"><a href="index-fb.php?conteudo=classificacao" title="Classificação"><strong>Classifica&ccedil;&atilde;o</strong></a></li>  -->
					<!--  <li id="li_tsmenu4"><a href="index-fb.php?conteudo=convites" title="Convites"><strong>Desafie</strong></a></li>  -->
					<li id="li_tsmenu5"><a href="index-fb.php?conteudo=placares" title="placares"><strong>TOP&nbsp;3&nbsp;Placares</strong></a></li>
					<li id="li_tsmenu6"><a href="index-fb.php?conteudo=ranks" title="Ranks"><strong>Rankings</strong></a></li>
					<li id="li_tsmenu7"><a href="index-fb.php?conteudo=encerrados" title="Apostas Ja Realizadas"><strong>Chutes&nbsp;Feitos</strong></a></li>
					<li id="li_tsmenu8"><a href="index-fb.php?conteudo=como-funciona" title="Como Funciona"><strong>Como&nbsp;Funciona</strong></a></li>		
		        </ul>
	        </div>
		</div>
		
					
		<div id="conteudo">
			<?php include $page; ?>
		</div>
		
		<div id="rodape">
				Copyright ©  2012
			</div>
		</div>		
</body>
</html>
<?php 
}
?>