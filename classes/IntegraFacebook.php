<?php
require_once '../Facebook-php-sdk/src/facebook.php';

$App_ID = '233715530059546';
$App_Secret = '0fa65b36e29b5ba8f774827028f67317';

$facebook = new Facebook(array(
		'appId' => $App_ID,
		'appSecret' => $App_Secret
));

$usuario = $facebook->getUser();

if($usuario == 0)
{
	$url = $Facebook->getLogin(array ('scope' => array('email', 'publish_stream')));
	header("location:".$url);
}
else
{
	if($_GET['action'] == 'finish')
	{
		session_destroy();
		header('Location: '.$facebook->getLogoutUrl());
	}
	else
	{
		if($_GET['action'] == 'publish' && strlen($_POST['status']) > 0)
		{
			$post = array('message' => $_POST['status']);
			$feed = $facebook->api('/me/feed');
		}
		else
		{
			$me = $facebook->api('/me');
			$nomeUsuario = $me['name'];
			$primeiroNomeUsuario = $me['first_name'];
			$segundoNomeUsuario = $me['last_name'];
			$emailUsuario = $me['email'];
			
			
			
		}
	}
}