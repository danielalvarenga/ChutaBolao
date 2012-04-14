<?php
class Time{
	private $id;
	private $nome;
	private $classificacao = array();

	function getId(){
		return $id;
	}

	function setNome($nome){
		$this->nome = toUpper($nome);
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