<?php
class Time{
	private $id;
	private $nome;
	private $classificacao = array();

	function __construct($nome){
		$this->nome = $nome;	
	}
	
	function getId(){
		return $id;
	}

	function setNome($nome){
		$this->nome = strtoupper($nome);
	}

	function getNome(){
		return $nome;
	}
	
	function setClassificacao($classificacao){
		$this->classificacao[] = $classificacao;
	}
	
	function getClassificacao(){
		return $classificacao;
	}
}