<?phprequire_once '../FacebookApi/facebook.php';require"links_index.php"// ID da App, vocé obteve isso na ultima página de geração do seu aplicativo no facebook$App_ID = '233715530059546';// App Secret, você obteve isso na ultima página de geração do seu aplicativo no facebook$App_Secret = '0fa65b36e29b5ba8f774827028f67317';//Instanciando o Objeto da classe do facebook$facebook = new Facebook(array(		'appId' => $App_ID,		'appSecret' => $App_Secret));//Pegando Id do usuário Logado$o_user = $facebook->getUser();// Verificando se está conectadoif($o_user == 0){	// Envia para a página de permissão do facebook, nela voce irá dar permissão ao aplicativo acessar dados da sua conta	$url = $Facebook->getLogin(array ('scope' => array('email', 'publish_stream')));	header("location:".$url);}else{	//Verificando se o comando de logout foi enviado	if($_GET['action'] == 'finish')	{		//Retirando a permissão do Aplicativo à sua conta no facebook		session_destroy();		header('Location: '.$facebook->getLogoutUrl());	}	else	{		//Atualizando seu status no facebook		if($_GET['action'] == 'publish' && strlen($_POST['status']) > 0)		{			$post = array('message' => $_POST['status']);			$feed = $facebook->api('/me/feed');		}		else		{			//pegando as informações do usuário conectado			//Use var_dump($me) ou print_r($me) para ver todos os campos retornados			$me = $facebook->api('/me');			$nomeUsuario = $me['name'];			$primeiroNomeUsuario = $me['first_name'];			$segundoNomeUsuario = $me['last_name'];			$emailUsuario = $me['email'];			$tokenUsuario = $me['acess_token'];											}	}}?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Chuta Bol&atilde;o</title>
<link href="estilos/folha.css" rel="stylesheet" type="text/css" />
</head>

<body>
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



</body>
</html>
