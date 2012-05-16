<?php

require_once('simpletest/autorun.php');
require_once('../classes/Usuario.php');
require_once('../classes/Aposta.php');
require_once('../classes/PremiosUsuario.php');

class TestUsuario extends UnitTestCase {
	
	var $u1;
	
	function setUp(){
		$idUsuario = 100003489131091;
		$tokenUsuario = "iurfvgbhju8765rtgyu765rfghyu765r";
		$primeiroNomeUsuario = "Primeironome";
		$segundoNomeUsuario = "Segundonome";
		$emailUsuario = "primeirosegundonome@oi.com";
		$this->u1 = new Usuario($idUsuario, $tokenUsuario, $primeiroNomeUsuario, $segundoNomeUsuario, $emailUsuario);
	}
	
	function TestGetSetIdUsuario(){
		$idUsuario = 0;
		$this->u1->setIdUsuario($idUsuario);
		$this->assertEqual($this->u1->getIdUsuario(), 0);
	}
	
	function TestGetSetTokenUsuario(){
		$tokenUsuario = 0;
		$this->u1->setTokenUsuario($tokenUsuario);
		$this->assertEqual($this->u1->getTokenUsuario(), 0);
	}
	
	function TestGetSetPrimeiroNomeUsuario(){
		$primeiroNomeUsuario = 0;
		$this->u1->setPrimeiroNomeUsuario($primeiroNomeUsuario);
		$this->assertEqual($this->u1->getPrimeiroNomeUsuario(), 0);
	}
	
	function TestGetSetSegundoNomeUsuario(){
		$segundoNomeUsuario = 0;
		$this->u1->setSegundoNomeUsuario($segundoNomeUsuario);
		$this->assertEqual($this->u1->getSegundoNomeUsuario(), 0);
	}
	
	function TestGetSetEmailUsuario(){
		$emailUsuario = 0;
		$this->u1->setEmailUsuario($emailUsuario);
		$this->assertEqual($this->u1->getEmailUsuario(), 0);
	}
	
	function TestGanhaPontosGeral(){
		$this->u1->ganhaPontosGeral(10);
		$this->assertEqual($this->u1->getPontosGeral(), 10);
	}
	
	function TestAdicionaAposta(){
		$aposta = new Aposta(123,2012,1);
		$this->u1->adicionaAposta($aposta);
		$this->assertEqual($this->u1->apostas[0], $aposta);
	}
	
	function TestAdicionaPremiacoes(){
		$premiacoes = new PremiosUsuario(123, 1);
		$this->u1->adicionaPremiacoes($premiacoes);
		$this->assertEqual($this->u1->premiacoes[0], $premiacoes);
	}
	
}
?>