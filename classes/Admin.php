<?php

/** @Entity @Table(name="admin")*/
class Admin{
	
	/** @Column(type="string")*/
	private $nome;
	
	/** @Id @Column(type="string")*/
	private $login;
	
	/** @Column(type="string")*/
	private $senha;
	
	function __construct($nome, $login, $senha = 12345678){
		$this->nome = $nome;
		$this->login = $login;
		$this->senha = $senha;		
	}
	
	function getNome(){
		return $this->nome;
	}
	
	function getLogin(){
		return $this->login;
	}
	
	function getSenha(){
		return md5($this->senha);
	}
	
	function setSenha($senha){
		$this->senha = $senha;
	}
	
}
?>