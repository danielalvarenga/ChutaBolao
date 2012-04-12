<?php


/** @Entity */
class Usuario{

	/** @Id @Column(type="integer")*/
	private $idUsuario;
	
	/** @Column(type="string") */
	private $tokenUsuario;
	
	/** @Column(type="string") */
	private $primeiroNomeUsuario;
	
	/** @Column(type="string") */
	private $segundoNomeUsuario;
	
	/** @Column(type="string") */
	private $emailUsuario;
	
	/** @Column(type="integer") */
	private $pontosGeral;
	
	
	protected $apostas;
	protected $premiacoes;

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
	
	function ganhaPontosGeral($pontos){
		$this->pontosGeral = $this->pontosGeral + $pontos;
	}
	
	function TestAdicionaAposta(){
		$codJogo = 12;
		$apostaGolsTime1 = 2;
		$apostaGolsTime2 = 1;
		$a = new Aposta();
		$this->u1->adicionaAposta($a);
		
	}
	
	
}