<?php

require_once('simpletest/autorun.php');
require_once('../classes/Usuario.php');
require_once '../classes/PremiosUsuario.php';

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
	
	function TestGanhaPontos(){
		$this->u1->ganhaPontos(10);
		$this->assertEqual($this->u1->getPontosGeralUsuario(), 10);
	}
	
	function TestIncluirPremiacoes(){
		$p = new PremiosUsuario(1, 1);
		$p->setAcertosPlacar();
		$this->u1->adicionaPremios($p);
		$this->assertIsA($p, $this->u1->getPremiacoes(0));
	}
	
}
?>