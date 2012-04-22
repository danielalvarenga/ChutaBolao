<?php
class Time{
	private $id; //indentificador do time.
	private $nome;//nome do time.
	private $classificacao = array(); //recebe o rendimento do time em derterminado campeonato.

	function __construct($nome){
		$this->nome = strtoupper($nome);	
	}
	
	function getId(){
		return $this->id;
	}

	function setNome($nome){
		$this->nome = strtoupper($nome);
	}

	function getNome(){
		return $this->nome;
	}
	
	function setClassificacao($classificacao){
		$this->classificacao[] = $classificacao;
	}
	
	function getClassificacao(){
		return $this->classificacao;
	}
}