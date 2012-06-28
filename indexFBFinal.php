<?php
header('Content-type: text/html; charset=ISO-8859-1');
require "bootstrap.php";
require_once 'FacebookApi/facebook.php';

$app_id = '233715530059546';
$app_secret = '0fa65b36e29b5ba8f774827028f67317';
$config = array(
		'appId' => $app_id,
		'secret' => $app_secret,);
$facebook = new Facebook($config);
$user_id = $facebook->getUser();

if ($user_id) {
	try {
		$user_profile = $facebook->api('/me');
		
		$conn = $entityManager->getConnection();
		$conn->beginTransaction();
		try{
		
			$usuario = $entityManager->find("Usuario", $user_id);
			
			$conn->commit();
		} catch(Exception $e) {
			$conn->rollback();
			echo $e->getMessage() . "<br/><font color=red>Não localizado usuário no Banco de Dados.</font><br/>";
		}
		$conn->close();
			
		if(($usuario instanceof Usuario) == false){
			
			$conn = $entityManager->getConnection();
			$conn->beginTransaction();
			try{
			
				$primeiroNomeUsuario = $user_profile['first_name'];
				$segundoNomeUsuario = $user_profile['last_name'];
				$emailUsuario = $user_profile['email'];
				$tokenUsuario = $facebook->getAccessToken();
				$usuario = new Usuario($user_id, $tokenUsuario, $primeiroNomeUsuario, $segundoNomeUsuario, $emailUsuario);
				$entityManager->persist($usuario);
				$entityManager->flush();
				$pontuacaoGeral = new PontuacaoGeral($usuario);
				$entityManager->persist($pontuacaoGeral);
				$entityManager->flush();
			
			$conn->commit();
			} catch(Exception $e) {
				$conn->rollback();
				echo $e->getMessage() . "<br/><font color=red>Não gravado usuário no Banco de Dados.</font><br/>";
			}
			$conn->close();
			
			$message = 'Agora vou mostrar quem entende de futebol! =D';
			$picture = 'http://www.chutabolao.com.br/facebook/imagens/publicacoes/chuta-bolao-logo.png';
			$link = 'http://apps.facebook.com/chutabolao';
			$name = $primeiroNomeUsuario.' agora "Chuta Bolão"';
			$caption = 'Seu time vai ganhar esse Campeonato?';
			$description = 'Faça seus Chutes e acerte o placar dos melhores jogos do Campeonato.';
			$ret_obj = $facebook->api('/me/feed', 'POST',	array(
					'link' => $link,
					'message' => $message,
					'name' => $name,
					'picture' => $picture,
					'caption' => $caption,
					'description' => $description
			));
		
		}
		
	} catch (FacebookApiException $e) {
		echo '<pre>'.htmlspecialchars(print_r($e, true)).'</pre>';
		$user = null;
	}
}
?>
<?php require"links_index.php"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
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
		
		<!-- CabeÃ§alho -->
		
		<div id="principal">
				
		<div id="top">
				 
		<div id="topleft">
				</div>
		
		<div id="topright">
		<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0" width="538" height="150" title="Chuta BolÃ£o">
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
				<li id="li_menu1"><a href="index.php?conteudo=home" title="Home"><strong>&nbsp;&nbsp;&nbsp;Início&nbsp;&nbsp;&nbsp;&nbsp;</strong></a></li>
				<li id="li_menu2"><a href="index.php?conteudo=apostas" title="Apostas"><strong>&nbsp;&nbsp;&nbsp;Jogos&nbsp;Liberados&nbsp;&nbsp;&nbsp;&nbsp;</strong></a></li>
				<!--  <li id="li_menu3"><a href="index.php?conteudo=classificacao" title="ClassificaÃ§Ã£o"><strong>&nbsp;&nbsp;&nbsp;Classifica&ccedil;&atilde;o&nbsp;&nbsp;&nbsp;&nbsp;</strong></a></li>  -->
				<!--  <li id="li_menu4"><a href="index.php?conteudo=convites" title="Convites"><strong>&nbsp;&nbsp;&nbsp;Convites&nbsp;&nbsp;&nbsp;&nbsp;</strong></a></li>  -->
				<li id="li_menu5"><a href="index.php?conteudo=placares" title="placares"><strong>&nbsp;&nbsp;&nbsp;Placares&nbsp;&nbsp;&nbsp;&nbsp;</strong></a></li>
				<li id="li_menu6"><a href="index.php?conteudo=ranks" title="Ranks"><strong>&nbsp;&nbsp;&nbsp;Rankings&nbsp;&nbsp;&nbsp;&nbsp;</strong></a></li>
				<li id="li_menu7"><a href="index.php?conteudo=apostas_antigas" title="Apostas Ja Realizadas"><strong>&nbsp;&nbsp;&nbsp;Jogos&nbsp;Encerrados&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</strong></a></li>
						
        </ul>
		</div>
		</div>
		<!-- pagina principal   xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx-->
		
		<div id="content"><?php include $page; ?></div>
				
				<!-- rodapÃ©    xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx-->
				
					<div id="footer"><p>Copyright Â©  2012</p></div>
				    
				<!-- xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx-->
				
				</div>
		
<script>               
      window.fbAsyncInit = function() {
        FB.init({
          appId: '<?php echo $facebook->getAppID() ?>', 
          cookie: true, 
          xfbml: true,
          oauth: true
        });
        FB.Event.subscribe('auth.login', function(response) {
          window.location.reload();
        });
        FB.Event.subscribe('auth.logout', function(response) {
          window.location.reload();
        });
      };
      (function() {
        var e = document.createElement('script'); e.async = true;
        e.src = document.location.protocol +
          '//connect.facebook.net/en_US/all.js';
        document.getElementById('fb-root').appendChild(e);
      }());
</script>
		
</body>
</html>

