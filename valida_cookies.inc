<?php
require "bootstrap.php";

if(isset($_COOKIE["nome_usuario"])){
	$nome_usuario = $_COOKIE["nome_usuario"];
}
if(isset($_COOKIE["senha_usuario"])){
	$senha_usuario = $_COOKIE["senha_usuario"];
}
if(empty($nome_usuario) OR empty($senha_usuario)){
	echo '<html><body>
				<p align="center">Você não efetuou LOGIN!</p>
				<p align="center"><a href="login.php">Fazer Login</a></p>
				</body></html>';
	exit;
}
else{
	$admin = $entityManager->find("Admin", $nome_usuario);
	if($admin instanceof Admin){
		if($senha_usuario != $admin->getSenha()){
			setcookie("nome_usuario");
			setcookie("senha_usuario");
			echo '<html><body>
				<p align="center">Você não efetuou LOGIN!</p>
				<p align="center"><a href="login.php">Fazer Login</a></p>
				</body></html>';
			exit;
		}
	}
	else{
		setcookie("nome_usuario");
		setcookie("senha_usuario");
		echo '<html><body>
				<p align="center">Você não efetuou LOGIN!</p>
				<p align="center"><a href="login.php">Fazer Login</a></p>
				</body></html>';
		exit;
	}
}
?>