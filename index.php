<?php
include 'config.php';//incluimos o arquivo de configura��o
@session_start();//iniciamos uma se��o se nao existir
if($_SESSION["facebook_token"]==""){//verificamos se existe uma conex�o com o face.
	$state = md5(uniqid(rand(), TRUE));//geramos um id unico
	$dialog_url = "https://www.facebook.com/dialog/oauth?client_id=" . $app_id . "&redirect_uri=".urlencode($url_app . "conector_facebook.php")."&scope=email,publish_stream&state=".$state;
	echo("<script> top.location.href='" . $dialog_url . "'</script>");//redirecionamos o usuario para a p�gina de login
}else{
	echo("<script> top.location.href='".$url_app."index-fb.php'</script>");
}
 
?>