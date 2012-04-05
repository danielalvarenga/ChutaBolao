<?php

class Usuario extends UsuarioAbstrato {

	private $idUsuario;
	private $tokenUsuario;
	private $primeiroNomeUsuario;
	private $segundoNomeUsuario;
	private $emailUsuario;
	private $pontosGeral;
	protected $apostas = null;
	protected $premiosCampeonato = null;
	
	function __construct($idUsuario, $tokenUsuario, $primeiroNomeUsuario, $segundoNomeUsuario, $emailUsuario){
		$this->idUsuario = $idUsuario;
		$this->tokenUsuario = $tokenUsuario;
		$this->primeiroNomeUsuario = $primeiroNomeUsuario;
		$this->segundoNomeUsuario = $segundoNomeUsuario;
		$this->emailUsuario = $emailUsuario;
		$this->pontosGeralUsuario = 0;
	}
	
	
}