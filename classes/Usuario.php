<?php

use Doctrine\Common\Collections\ArrayCollection;

/** @Entity */
class Usuario {

	/** @Id @Column(type="string", nullable=false, unique=true) */
	private $idUsuario;

	/** @Column(type="string", nullable=false) */
	private $tokenUsuario;

	/** @Column(type="string", nullable=false) */
	private $primeiroNomeUsuario;

	/** @Column(type="string", nullable=false) */
	private $segundoNomeUsuario;

	/** @Column(type="string", nullable=false) */
	private $emailUsuario;

	/** @Column(type="integer", nullable=false) */
	private $pontosGeralUsuario;

	/** @OneToMany(targetEntity="PremiosUsuario", mappedBy="usuario")
	 * @var PremiosUsuario[] */
	protected $premios = null;
	
	function __construct($idUsuario, $tokenUsuario, $primeiroNomeUsuario, $segundoNomeUsuario, $emailUsuario){
		$this->idUsuario = $idUsuario;
		$this->tokenUsuario = $tokenUsuario;
		$this->primeiroNomeUsuario = $primeiroNomeUsuario;
		$this->segundoNomeUsuario = $segundoNomeUsuario;
		$this->emailUsuario = $emailUsuario;
		$this->pontosGeralUsuario = 0;
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
	
	function getPontosGeralUsuario(){
		return $this->pontosGeralUsuario;
	}
	
	function ganhaPontos($pontosGanhos){
		$this->pontosGeralUsuario = $this->pontosGeralUsuario + $pontosGanhos;
	}
	
	function adicionaPremios($objetoPremiosUsuario){
		$this->premios[] = $objetoPremiosUsuario;
	}	
}