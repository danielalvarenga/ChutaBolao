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
	
	/**
	 * @OneToOne(targetEntity="PontuacaoGeral", mappedBy="usuario", cascade={"persist", "remove"})
	 * @var PontuacaoGeral
	 */
	protected $pontuacaoGeral;
	
	/**
	 * @OneToMany(targetEntity="PontuacaoRodada", mappedBy="usuario", cascade={"persist", "remove"})
	 * @var PontuacaoRodada[]
	 */
	protected $pontuacaoRodadas;
	
	/**
	 * @OneToMany(targetEntity="Aposta", mappedBy="usuario", cascade={"persist", "remove"})
	 * @var Aposta[]
	 */
	protected $apostasUsuario;
	
	/**
	 * @OneToMany(targetEntity="PremiosUsuario", mappedBy="usuario", cascade={"persist", "remove"}) 
	 * @var PremiosUsuario[]
	 */
	protected $premiacoesUsuario;
	
	function __construct($idUsuario, $tokenUsuario, $primeiroNomeUsuario, $segundoNomeUsuario, $emailUsuario){
	$this->idUsuario = $idUsuario;
	$this->tokenUsuario = $tokenUsuario;
	$this->primeiroNomeUsuario = $primeiroNomeUsuario;
	$this->segundoNomeUsuario = $segundoNomeUsuario;
	$this->emailUsuario = $emailUsuario;
	$this->apostasUsuario = new ArrayCollection() ;
	$this->premiacoesUsuario = new ArrayCollection() ;
	$this->pontuacaoRodadas = new ArrayCollection();
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
	
	function getPontuacaoGeral(){
		return $this->pontuacaoGeral;
	}
	
	function setPontuacaoGeral($pontuaçãoGeral){
		$this->pontuacaoGeral = $pontuaçãoGeral;
	}
	
	function getApostas($aposta){
		return $this->apostas;
	}
	
	function getPremiacoesUsuario(){
		return $this->premiacoesUsuario;
	}
	
	function adicionaAposta($aposta){
		$this->apostasUsuario[] = $aposta;
	}
	
	function adicionaPremiacoesUsuario($premiosUsuario){
		$this->premiacoesUsuario[] = $premiosUsuario;
	}
	
	function getPontuacaoRodadas(){
		return $this->pontuacaoRodadas;
	}
	
	function adicionaPontuacaoRodada($pontuacaoRodada){
		$this->pontuacaoRodadas[] = $pontuacaoRodada;
	}
	
}