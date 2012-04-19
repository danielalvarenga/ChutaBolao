<?php
require_once('simpletest/autorun.php');
require_once('../classes/RendimentoTime.php');

class TestOfRendimetoTime extends UnitTestCase {

function testaNumeroDeDerrotas(){
		$rendimento = new RendimentoTime();
		$rendimento->incrementaDerrotas();
		$this->assertEqual($rendimento->getDerrotas(), 1);
	}
	
	function testaNumeroDePontos(){
		$rendimento = new RendimentoTime();
		$rendimento->incrementaVitorias();
		$this->assertEqual($rendimento->calculaPontos(), 3); 
	}
	
	function testaNumeroDePontos2(){
		$rendimento = new RendimentoTime();
		$rendimento->incrementaEmpates();
		$this->assertEqual($rendimento->calculaPontos(), 1);
	}
	
	function testaNumeroDePontos3(){
		$rendimento = new RendimentoTime();
		$rendimento->incrementaVitorias();
		$rendimento->incrementaEmpates();
		$this->assertEqual($rendimento->calculaPontos(), 4);
	}
	
	function testaNumeroDeVitorias(){
		$rendimento = new RendimentoTime();
		$rendimento->incrementaVitorias();
		$this->assertEqual($rendimento->getVitorias(), 1);
	}
	
	function testaNumeroDeEmpates(){
		$rendimento = new RendimentoTime();
		$rendimento->incrementaEmpates();
		$this->assertEqual($rendimento->getEmpates(), 1);
	}
	
	function testaNumeroDeGolsPro(){
		$rendimento = new RendimentoTime();
		$rendimento->insereGolsPro(3);
		$this->assertEqual($rendimento->retornaGolsPro(3), 3);
	}
	
	function testaNumeroDeGolsContra(){
		$rendimento = new RendimentoTime();
		$rendimento->insereGolsContra(2);
		$this->assertEqual($rendimento->retornaGolsContra(2), 2);
	}
	
	function testaSaldoDeGols(){ 
		$rendimento = new RendimentoTime();
		$rendimento->insereGolsPro(5);
		$rendimento->insereGolsContra(2);
		$this->assertEqual($rendimento->calculaSaldoDeGols(), 3);
	}
	
	function testaPontos1(){
		$rendimento = new RendimentoTime();
		$rendimento->incrementaVitorias();
		$this->assertEqual($rendimento->calculaPontos(), 3);
	}
	
	function testaPontos2(){
		$rendimento = new RendimentoTime();
		$rendimento->incrementaEmpates();
		$this->assertEqual($rendimento->calculaPontos(), 1);
	}
	
	function testaPontos3(){
		$rendimento = new RendimentoTime();
		$rendimento->incrementaDerrotas();
		$this->assertEqual($rendimento->calculaPontos(), 0);
	}
}