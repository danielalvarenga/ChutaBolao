<?php ob_start();
$charsetArray[1] = 'utf-8';
$charsetArray[2] = 'ISO-8859-1';
$charset = $charsetArray[2];
header('Content-type: text/html; charset='.$charset);
require "bootstrap.php";
/*
require_once 'FacebookApi/facebook.php';

$app_id = '233715530059546';
$app_secret = '0fa65b36e29b5ba8f774827028f67317';
$config = array(
		'appId' => $app_id,
		'secret' => $app_secret,);
$facebook = new Facebook($config);
$user_id = $facebook->getUser();
*/
$user_id = "100000885523518";
$primeiroNomeUsuario = 'Daniel';
$segundoNomeUsuario = 'Alvarenga Lima';
$emailUsuario = 'alvarenga_daniel@hotmail.com';
$tokenUsuario = 'AAADUkCMlzxoBAAde2WKyZAMFkBgDMxuGcNoXsZB37g3eiPRVGe2nQXTIbN0StDRO2Bh4xf2mCHZBfOSQOp9qbAbpFMhqp2amsijqxK5GhLnMfRr8Ycl';


$conn = $entityManager->getConnection();
$conn->beginTransaction();
try{
	$usuario = $entityManager->find("Usuario", $user_id);
	if(($usuario instanceof Usuario) == false){
		$usuario = new Usuario($user_id, $tokenUsuario, $primeiroNomeUsuario, $segundoNomeUsuario, $emailUsuario);
		$entityManager->persist($usuario);
		$entityManager->flush();
		
		$pontuacaoGeral = new PontuacaoGeral($usuario);
		$entityManager->persist($pontuacaoGeral);
		$entityManager->flush();
		
/*		$message = 'Agora vou mostrar quem entende de futebol! =D';
		$picture = 'http://www.chutabolao.com.br/facebook/imagens/publicacoes/logo.png';
		$link = 'http://apps.facebook.com/chutabolao';
		$name = $primeiroNomeUsuario.' agora "Chuta Bol„o"';
		$caption = 'Seu time vai ganhar esse Campeonato?';		
		$description = 'FaÁa seus Chutes e acerte o placar dos melhores jogos do Campeonato.';
		$ret_obj = $facebook->api('/me/feed', 'POST',	array(
				'link' => $link,
				'message' => $message,
				'name' => $name,
				'picture' => $picture,
				'caption' => $caption,
				'description' => $description
				));
*/		
		}
	$conn->commit();
} catch(Exception $e) {
	$conn->rollback();
	echo $e->getMessage() . "<br/><font color=red>N√£o foi poss√≠vel gravar os dados de Usu√°rio.
							Verifique o Banco de Dados.</font><br/>";
}
$conn->close();
ob_end_flush();
?>
<?php require"links_index.php"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php echo '<meta http-equiv="Content-Type" content="text/html; charset='.$charset.'" />'; ?>
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

<body background="imagens/campo-futebol.png">

<?php 
if($user_id){
	try{
?>
		
		<!-- Cabe√ßalho -->
		
		<div id="principal">
				
		<div id="top">
				 
		<div id="topleft">
				</div>
		
		<div id="topright">
		<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0" width="538" height="150" title="Chuta Bol√£o">
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
				<li id="z"><a href="index.php?conteudo=home" title="Home"><strong>&nbsp;&nbsp;&nbsp;InÌcio&nbsp;&nbsp;&nbsp;&nbsp;</strong></a></li>
				<li id="li_menu2"><a href="index.php?conteudo=apostas" title="Apostas"><strong>&nbsp;&nbsp;&nbsp;Jogos&nbsp;Liberados&nbsp;&nbsp;&nbsp;&nbsp;</strong></a></li>
				<!--  <li id="li_menu3"><a href="index.php?conteudo=classificacao" title="Classifica√ß√£o"><strong>&nbsp;&nbsp;&nbsp;Classifica&ccedil;&atilde;o&nbsp;&nbsp;&nbsp;&nbsp;</strong></a></li>  -->
				<!--  <li id="li_menu4"><a href="index.php?conteudo=convites" title="Convites"><strong>&nbsp;&nbsp;&nbsp;Convites&nbsp;&nbsp;&nbsp;&nbsp;</strong></a></li>  -->
				<li id="li_menu5"><a href="index.php?conteudo=placares" title="Placares"><strong>&nbsp;&nbsp;&nbsp;Placares&nbsp;&nbsp;&nbsp;&nbsp;</strong></a></li>
				<li id="li_menu6"><a href="index.php?conteudo=ranks" title="Rankings"><strong>&nbsp;&nbsp;&nbsp;Rankings&nbsp;&nbsp;&nbsp;&nbsp;</strong></a></li>
				<li id="li_menu7"><a href="index.php?conteudo=apostas_antigas" title="Chutes Anteriores"><strong>&nbsp;&nbsp;&nbsp;Jogos&nbsp;Encerrados&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</strong></a></li>
		</ul>
		</div>
		</div>
		<!-- pagina principal   xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx-->
		
		<div id="content"><?php include $page; ?></div>
				
				<!-- rodap√©    xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx-->
				
					<div id="footer"><p>Copyright ©  2012 Chuta Bol„o</p></div>
				    
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
