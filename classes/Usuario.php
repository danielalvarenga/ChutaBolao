<?php

use Doctrine\Common\Collections\ArrayCollection;

/** @Entity @Table(name="usuario")*/
class Usuario{
	
	/** @Id @Column(type="bigint", name="id") */
	private $idUsuario; // Identificador do usuário do Facebook - Direto do Facebook
	
	/** @Column(type="string")*/
	private $tokenUsuario; // Permissão de acesso do usuário - Direto do Facebook
	
	/** @Column(type="string")*/
	private $primeiroNomeUsuario;
	
	/** @Column(type="string")*/
	private $segundoNomeUsuario;
	
	/** @Column(type="string")*/
	private $emailUsuario;
	
	/** @Column(type="integer")*/
	private $pontosGeral; // Total de pontos acumulados desde o cadastro do usuário
	
	/**
	 * @OneToMany(targetEntity="Aposta", mappedBy="usuario", cascade={"persist"})
	 * @var Aposta[]
	 */
	protected $apostasUsuario = null;
	
	/**
	 * @OneToMany(targetEntity="PremiosUsuario", mappedBy="usuario", cascade={"persist"}) 
	 * @var PremiosUsuario[]
	 */
	protected $premiacoesUsuario = null;
		
	/* Recebe como parâmetros idUsuario, tokenUsuario, primeiroNomeUsuario, segundoNomeUsuario e emailUsuario,
	 * inicia pontosGeral com 0 e instancia apostas e premiacoes como null */
	
	function __construct($idUsuario, $tokenUsuario, $primeiroNomeUsuario, $segundoNomeUsuario, $emailUsuario){
	$this->idUsuario = $idUsuario;
	$this->tokenUsuario = $tokenUsuario;
	$this->primeiroNomeUsuario = $primeiroNomeUsuario;
	$this->segundoNomeUsuario = $segundoNomeUsuario;
	$this->emailUsuario = $emailUsuario;
	$this->pontosGeral = 0;
	$this->apostas = new ArrayCollection() ;
	$this->premiacoes = new ArrayCollection() ;
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
	
	function getApostas($aposta){
		return $this->apostas;
	}
	
	function getPremiacoesUsuario(){
		return $this->premiacoesUsuario;
	}
	
	/* Recebe a quantidade de pontos ganhos por parâmetro e soma com pontosGeral */
	
	function ganhaPontosGeral($pontos){
		$this->pontosGeral = $this->pontosGeral + $pontos;
	}
	
	/* Recebe o objeto Aposta e adiciona ao array apostas[] */
	
	function adicionaAposta($aposta){
		$this->apostas[] = $aposta;
	}
	
	/* Recebe o objeto PremiosUsuario e adiciona ao array premiacoes[] */
	
	function adicionaPremiacoesUsuario($premiosUsuario){
		$this->premiacoes[] = $premiosUsuario;
	}
	
	
	
}