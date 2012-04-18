<?php

class Usuario{

	private $idUsuario; // Identificador do usu�rio do Facebook - Direto do Facebook
	private $tokenUsuario; // Permiss�o de acesso do usu�rio - Direto do Facebook
	private $primeiroNomeUsuario;
	private $segundoNomeUsuario;
	private $emailUsuario;
	private $pontosGeral; // Total de pontos acumulados desde o cadastro do usu�rio
	var $apostas;
	var $premiacoes;
		
	/* Recebe como par�metros idUsuario, tokenUsuario, primeiroNomeUsuario, segundoNomeUsuario e emailUsuario,
	 * inicia pontosGeral com 0 e instancia apostas e premiacoes como null */
	
	function __construct($idUsuario, $tokenUsuario, $primeiroNomeUsuario, $segundoNomeUsuario, $emailUsuario){
	$this->idUsuario = $idUsuario;
	$this->tokenUsuario = $tokenUsuario;
	$this->primeiroNomeUsuario = $primeiroNomeUsuario;
	$this->segundoNomeUsuario = $segundoNomeUsuario;
	$this->emailUsuario = $emailUsuario;
	$this->pontosGeral = 0;
	$this->apostas = null;
	$this->premiacoes = null;
	}
	
	function getIdUsuario(){
		return $this->idUsuario;
	}

	function setIdUsuario($idUsuario){
		$this->idUsuario = $idUsuario;
	}
	
	function getTokenUsuario(){
		return $this->tokenUsuario;
	}
	
	function setTokenUsuario($tokenUsuario){
		$this->tokenUsuario = $tokenUsuario;
	}
	
	function getPrimeiroNomeUsuario(){
		return $this->primeiroNomeUsuario;
	}
	
	function setPrimeiroNomeUsuario($primeiroNomeUsuario){
		$this->primeiroNomeUsuario = $primeiroNomeUsuario;
	}
	
	function getSegundoNomeUsuario(){
		return $this->segundoNomeUsuario;
	}
	
	function setSegundoNomeUsuario($segundoNomeUsuario){
		$this->segundoNomeUsuario = $segundoNomeUsuario;
	}
	
	function getEmailUsuario(){
		return $this->emailUsuario;
	}
	
	function setEmailUsuario($emailUsuario){
		$this->emailUsuario = $emailUsuario;
	}
	
	function getPontosGeral(){
		return $this->pontosGeral;
	}
	
	/* Recebe a quantidade de pontos ganhos por par�metro e soma com pontosGeral */
	
	function ganhaPontosGeral($pontos){
		$this->pontosGeral = $this->pontosGeral + $pontos;
	}
	
	/* Recebe o objeto Aposta e adiciona ao array apostas[] */
	
	function adicionaAposta($aposta){
		$this->apostas[] = $aposta;
	}
	
	/* Recebe o objeto PremiosCampeonato e adiciona ao array premiacoes[] */
	
	function adicionaPremiacoes($premiosUsuario){
		$this->premiacoes[] = $premiosUsuario;
	}
	
	
	
}