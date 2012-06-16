<?php 
header("Content-Type: text/html; charset=UTF-8",true);
require "bootstrap.php";
require_once 'FacebookApi/facebook.php';
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

$user_id = $dados_usuario['id'];

//>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>> Salva Usuario no BD <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<

$conn = $entityManager->getConnection();
$conn->beginTransaction();
try{
	$usuario = $entityManager->find("Usuario", $user_id);
	$conn->commit();
} catch(Exception $e) {
	$conn->rollback();
	echo $e->getMessage() . "<br/><font color=red>Usuario n�o localizado no Banco de Dados.</font><br/>";
}
$conn->close();

	if(($usuario instanceof Usuario) == false){
		
		$conn = $entityManager->getConnection();
		$conn->beginTransaction();
		try{
			$primeiroNomeUsuario = $dados_usuario['first_name'];
			$segundoNomeUsuario = $dados_usuario['last_name'];
			$emailUsuario = $dados_usuario['email'];
			$tokenUsuario = $token;
			$usuario = new Usuario($user_id, $tokenUsuario, $primeiroNomeUsuario, $segundoNomeUsuario, $emailUsuario);
			$entityManager->persist($usuario);
			$entityManager->flush();
			
			$conn->commit();
		} catch(Exception $e) {
			$conn->rollback();
			echo $e->getMessage() . "<br/><font color=red>Não foi possível gravar os dados de Usuário.
			Verifique o Banco de Dados.</font><br/>";
		}
		$conn->close();
			
		$message = 'Agora vou mostrar quem entende de futebol! =D';
		$picture = 'http://www.chutabolao.com.br/facebook/imagens/publicacoes/logo.png';
		$link = 'http://apps.facebook.com/chutabolao';
		$name = $primeiroNomeUsuario.' agora "Chuta Bol�o"';
		$caption = 'Seu time vai ganhar esse Campeonato?';
		$description = 'Fa�a seus Chutes e acerte o placar dos melhores jogos do Campeonato.';
		$ret_obj = $facebook->api('/me/feed', 'POST',	array(
				'link' => $link,
				'message' => $message,
				'name' => $name,
				'picture' => $picture,
				'caption' => $caption,
				'description' => $description
		));

	}
//>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>><<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<


?>



<?php require"links_index.php"?>
	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Chuta Bol&atilde;o</title>
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
	
	<body>
			
			<!-- Cabeçalho -->
			
			<div id="principal">
					
			<div id="top">
					 
			<div id="topleft">
					</div>
			
			<div id="topright">
			<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0" width="538" height="150" title="Chuta Bolão">
	<param name="movie" value="imagens/banner.swf" />
	<param name="quality" value="high" />
	<embed src="imagens/banner.swf" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="538" height="150"></embed>
	</object>
	</div>
	
	</div>
	
	<!-- Menu   xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx-->
		
		<div id="areamenu">
		<div id="menu">
        <ul>
				<li id="li_menu1"><a href="index2.php?conteudo=home" title="Home"><strong>&nbsp;&nbsp;&nbsp;Home&nbsp;&nbsp;&nbsp;&nbsp;</strong></a></li>
				<li id="li_menu2"><a href="index2.php?conteudo=apostas" title="Apostas"><strong>&nbsp;&nbsp;&nbsp;Apostas&nbsp;&nbsp;&nbsp;&nbsp;</strong></a></li>
				<li id="li_menu3"><a href="index2.php?conteudo=classificacao" title="Classificação"><strong>&nbsp;&nbsp;&nbsp;Classifica&ccedil;&atilde;o&nbsp;&nbsp;&nbsp;&nbsp;</strong></a></li>
				<li id="li_menu4"><a href="index2.php?conteudo=convites" title="Convites"><strong>&nbsp;&nbsp;&nbsp;Convites&nbsp;&nbsp;&nbsp;&nbsp;</strong></a></li>
				<li id="li_menu5"><a href="index2.php?conteudo=placares" title="placares"><strong>&nbsp;&nbsp;&nbsp;Placares&nbsp;&nbsp;&nbsp;&nbsp;</strong></a></li>
				<li id="li_menu6"><a href="index2.php?conteudo=ranks" title="Ranks"><strong>&nbsp;&nbsp;&nbsp;Ranks&nbsp;&nbsp;&nbsp;&nbsp;</strong></a></li>
		</ul>
		</div>
		</div>
		<!-- pagina principal   xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx-->
	
	<div id="content"><?php include $page; ?></div>
			
			<!-- rodapé    xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx-->
			
				<div id="footer"><p>Copyright ©  2012</p></div>
			    
			<!-- xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx-->
			
			</div>
	</body>
	</html>


<?php }?>