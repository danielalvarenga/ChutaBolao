<?php ob_start();
require "bootstrap.php";
/*require_once 'FacebookApi/facebook.php';

$app_Id = '233715530059546';
$app_Secret = '0fa65b36e29b5ba8f774827028f67317';

$config = array(
    'appId' => $app_Id,
    'secret' => $app_Secret,
);

$facebook = new Facebook($config);
$user_id = $facebook->getUser();
*/
$user_id = '100000885523518';
$usuario = $entityManager->find("Usuario", $user_id);
/*
if(!($usuario instanceof Usuario)){
	$user_profile = $facebook->api('/me', 'GET');
	$primeiroNomeUsuario = $user_profile['first_name'];
	$segundoNomeUsuario = $user_profile['last_name'];
	$emailUsuario = $user_profile['email'];
	$tokenUsuario = $facebook->getAccessToken();
	$usuario = new Usuario($user_id, $tokenUsuario, $primeiroNomeUsuario, $segundoNomeUsuario, $emailUsuario);
	$entityManager->persist($usuario);
	$entityManager->flush();

	$link = 'http://apps.facebook.com/chutabolao';
//	$message = 'Massa!'; //$nomeUsuario . 'agora faz parte do Clube Chuta Bolão, e pode mostrar suas habilidades de técnico apostando qual será o resultado dos melhores jogos de futebol do Campeonato. Quem será melhor? Ele ou você?';
	$ret_obj = $facebook->api('/me/feed', 'POST',
	array(
											'link' => $link,
//											'message' => $message
	));
}

ob_end_flush(); */
require"links_index.php"?>
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

<?php /*
if($user_id){
	try{
*/?>
		
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
		
<?php	/*
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
*/?>
</body>
</html>