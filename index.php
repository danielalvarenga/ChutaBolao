<?php ob_start();
header('Content-type: text/html; charset=utf-8');
require "bootstrap.php";/*
require_once 'FacebookApi/facebook.php';$app_Id = '233715530059546';$app_Secret = '0fa65b36e29b5ba8f774827028f67317';$config = array(    'appId' => $app_Id,    'secret' => $app_Secret,);
$facebook = new Facebook($config);$user_id = $facebook->getUser();
*/
$user_id = "100000885523518";$usuario = $entityManager->find("Usuario", $user_id);
/*
if(!($usuario instanceof Usuario)){	$user_profile = $facebook->api('/me', 'GET');
	$primeiroNomeUsuario = $user_profile['first_name'];
	$segundoNomeUsuario = $user_profile['last_name'];
	$emailUsuario = $user_profile['email'];
	$tokenUsuario = $facebook->getAccessToken();
	$usuario = new Usuario($user_id, $tokenUsuario, $primeiroNomeUsuario, $segundoNomeUsuario, $emailUsuario);
	$entityManager->persist($usuario);
	$entityManager->flush();
	$link = 'http://apps.facebook.com/chutabolao';//	$message = 'Massa!'; //$nomeUsuario . 'agora faz parte do Clube Chuta Bol�o, e pode mostrar suas habilidades de t�cnico apostando qual ser� o resultado dos melhores jogos de futebol do Campeonato. Quem ser� melhor? Ele ou voc�?';	$ret_obj = $facebook->api('/me/feed', 'POST',	array(											'link' => $link,//											'message' => $message	));}
*/
ob_end_flush();
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

<?php 
if($user_id){
	try{
?>
		
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
				<li id="li_menu1"><a href="index.php?conteudo=home" title="Home"><strong>&nbsp;&nbsp;&nbsp;Home&nbsp;&nbsp;&nbsp;&nbsp;</strong></a></li>
				<li id="li_menu2"><a href="index.php?conteudo=apostas" title="Apostas"><strong>&nbsp;&nbsp;&nbsp;Apostas&nbsp;&nbsp;&nbsp;&nbsp;</strong></a></li>
				<li id="li_menu3"><a href="index.php?conteudo=classificacao" title="Classificação"><strong>&nbsp;&nbsp;&nbsp;Classifica&ccedil;&atilde;o&nbsp;&nbsp;&nbsp;&nbsp;</strong></a></li>
				<li id="li_menu4"><a href="index.php?conteudo=convites" title="Convites"><strong>&nbsp;&nbsp;&nbsp;Convites&nbsp;&nbsp;&nbsp;&nbsp;</strong></a></li>
				<li id="li_menu5"><a href="index.php?conteudo=placares" title="placares"><strong>&nbsp;&nbsp;&nbsp;Placares&nbsp;&nbsp;&nbsp;&nbsp;</strong></a></li>
				<li id="li_menu6"><a href="index.php?conteudo=ranks" title="Ranks"><strong>&nbsp;&nbsp;&nbsp;Ranks&nbsp;&nbsp;&nbsp;&nbsp;</strong></a></li>
		</ul>
		</div>
		</div>
		<!-- pagina principal   xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx-->
		
		<div id="content"><?php include $page; ?></div>
				
				<!-- rodapé    xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx-->
				
					<div id="footer"><p>Copyright ©  2012</p></div>
				    
				<!-- xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx-->
				
				</div>
		
<?php
	} catch(FacebookApiException $e) {
		$login_url = $facebook->getLoginUrl(array(
							'scope' => 'publish_stream'
		));
		echo 'Por Favor <ahref="' . $login_url . '">login.</a>';
		error_log($e->getType());
		error_log($e->getMessage());
	}
} else {
	$login_url = $facebook->getLoginUrl(array(
							'scope' => 'publish_stream'
	));
}
?>
</body>
</html>