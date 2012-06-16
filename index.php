<?php 
include 'config.php';
@session_start();
if($_SESSION["facebook_token"]==""){
	$state = md5(uniqid(rand(), TRUE));
	$dialog_url = "https://www.facebook.com/dialog/oauth?client_id=" .
					$app_id . "&redirect_uri=".
					urlencode($url_app . "conector_facebook.php").
					"&scope=email,read_stream&state=".$state;
	echo("<script> top.location.href='" . $dialog_url . "'</script>");

}else{
	echo("<script> top.location.href='".$url_app."index2.php'</script>");
}


?>