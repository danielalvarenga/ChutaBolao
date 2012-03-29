<?php
require("../facebook-php-sdk/src/facebook.php"); // chama a biblioteca básica do Facebook

//Facebook dados
session_start();
$_SESSION["app_id"] = "233715530059546";
$_SESSION["app_secret"] = "0fa65b36e29b5ba8f774827028f67317";


//Dados da sua aplicação
$facebook = new Facebook(array(
		"appId" => $_SESSION["app_id"],
		"secret" => $_SESSION["app_secret"],
));

$user = $facebook->getUser(); //Isto está criando o objeto Usuário do Facebook

/*Isto está definindo de que autorizações e dados do usuário você precisa para sua aplicação, email,
 * publicar no mural dela, localidade, etc. Isto será entendido mais pra frente. Importante: o endereço de
 * "redirect_uri" deve ter a página no final (.php) e pra evitar problemas ser a mesma que contém estes códigos aqui. */

$params = array(scope => "email, publish_stream", redirect_uri => "http://apps.facebook.com/chutabolao/usuario.php");

/*Pega a URL da sua aplicação que é como se fosse o login. Isto é a criação da sessão com o Facebook.
 * Neste artigo têm-se em mente uma aplicação que se passa na primeira pessoa, ou seja, no usuário que está a vendo no momento. */

$loginUrl = $facebook->getLoginUrl($params);

/*Não existe uma sessão Facebook válida neste momento. Enviar o usuário para ser autenticado.
 * Neste momento o usuário vai ser redirecionado exclusivamente para a tela de Permissão (única vez). */

if (!$user) {
	echo "<script>top.location.href = \".$loginUrl.\"</script>";
	exit;
}

//Supondo-se que já existe um ID Facebook válido

if ($user) {
	try {

		// Cria usuário Facebook. Isto pega o objeto usuário "me" (você que está visitando a app) via JSON e PHP
		$fb_perfil = $facebook->api("/me");


	} catch (FacebookApiException $e) {
		error_log($e);
		$user = null;
	}
}

	/* O resgate ID Facebook na sessão PHP é uma boa prática para que você possa validar a sessão da sua aplicação. */

	$_SESSION["fb_id"] = $fb_perfil["id"];

	/*Agora resgate os dados do Facebook como quiser. Uma dica é usar o método utf8_encode() para
	 * não ver caracteres estranhos se suas páginas forem ISO. A base de dados do Facebook é UTF8. */

	$_SESSION["primeiro_nome"] = utf8_encode($fb_perfil["first_name"]);
	$_SESSION["ultimo_nome"] = utf8_encode($fb_perfil["last_name"]);
	$_SESSION["email"] = $fb_perfil["email"];


	/*Pronto! Agora se você é usuário entendeu a idéia.
	 * Uma dica interessante é validar se o ID do FB do usuário está em sessão, senão jogue-o para a autenticação, assim: */

	//Não existe ID Facebook em sessão
	if ($_SESSION["fb_id"]=="") {
		echo "<script>top.location.href = \".$loginUrl.\"</script>";
		exit;
	}
	
?>