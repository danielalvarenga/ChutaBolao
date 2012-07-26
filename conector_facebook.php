<?php 
include 'config.php';

if($_GET["code"]){
	
	$code = $_GET["code"];	
	$token_url	= "https://graph.facebook.com/oauth/access_token?"."client_id=".$app_id."&redirect_uri=".urlencode($url_app."conector_facebook.php")."&client_secret=". $app_secret."&code=".$code;	
	$response = file_get_contents($token_url);
	$token_de_acesso = str_replace('access_token=','',$response);	
	@session_start();
	$_SESSION["facebook_token"]=$token_de_acesso;  
	echo("<script> top.location.href='" . $url_app . "?status=ok'</script>");

}else{
echo("<script> top.location.href='" . $url_app . "?code=erro'</script>");	
}

?>