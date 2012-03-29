<?php
require("../facebook-php-sdk/src/facebook.php"); // chama a biblioteca b�sica do Facebook

//Facebook dados
session_start();
$_SESSION["app_id"] = "233715530059546";
$_SESSION["app_secret"] = "0fa65b36e29b5ba8f774827028f67317";


//Dados da sua aplica��o
$facebook = new Facebook(array(
		"appId" => $_SESSION["app_id"],
		"secret" => $_SESSION["app_secret"],
));

$user = $facebook->getUser(); //Isto est� criando o objeto Usu�rio do Facebook

/*Isto est� definindo de que autoriza��es e dados do usu�rio voc� precisa para sua aplica��o, email,
 * publicar no mural dela, localidade, etc. Isto ser� entendido mais pra frente. Importante: o endere�o de
 * "redirect_uri" deve ter a p�gina no final (.php) e pra evitar problemas ser a mesma que cont�m estes c�digos aqui. */

$params = array(scope => "email, publish_stream", redirect_uri => "http://apps.facebook.com/chutabolao/usuario.php");

/*Pega a URL da sua aplica��o que � como se fosse o login. Isto � a cria��o da sess�o com o Facebook.
 * Neste artigo t�m-se em mente uma aplica��o que se passa na primeira pessoa, ou seja, no usu�rio que est� a vendo no momento. */

$loginUrl = $facebook->getLoginUrl($params);

/*N�o existe uma sess�o Facebook v�lida neste momento. Enviar o usu�rio para ser autenticado.
 * Neste momento o usu�rio vai ser redirecionado exclusivamente para a tela de Permiss�o (�nica vez). */

if (!$user) {
	echo "<script>top.location.href = \".$loginUrl.\"</script>";
	exit;
}

//Supondo-se que j� existe um ID Facebook v�lido

if ($user) {
	try {

		// Cria usu�rio Facebook. Isto pega o objeto usu�rio "me" (voc� que est� visitando a app) via JSON e PHP
		$fb_perfil = $facebook->api("/me");


	} catch (FacebookApiException $e) {
		error_log($e);
		$user = null;
	}
}

	/* O resgate ID Facebook na sess�o PHP � uma boa pr�tica para que voc� possa validar a sess�o da sua aplica��o. */

	$_SESSION["fb_id"] = $fb_perfil["id"];

	/*Agora resgate os dados do Facebook como quiser. Uma dica � usar o m�todo utf8_encode() para
	 * n�o ver caracteres estranhos se suas p�ginas forem ISO. A base de dados do Facebook � UTF8. */

	$_SESSION["primeiro_nome"] = utf8_encode($fb_perfil["first_name"]);
	$_SESSION["ultimo_nome"] = utf8_encode($fb_perfil["last_name"]);
	$_SESSION["email"] = $fb_perfil["email"];


	/*Pronto! Agora se voc� � usu�rio entendeu a id�ia.
	 * Uma dica interessante � validar se o ID do FB do usu�rio est� em sess�o, sen�o jogue-o para a autentica��o, assim: */

	//N�o existe ID Facebook em sess�o
	if ($_SESSION["fb_id"]=="") {
		echo "<script>top.location.href = \".$loginUrl.\"</script>";
		exit;
	}
	
?>