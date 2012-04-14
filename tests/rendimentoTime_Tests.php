<?php
require_once('simpletest/autorun.php');
require_once('../ChutaBolao/test/RendimentoTime.php');

class TestOfRendimetoTime extends UnitTestCase {

function testaNumeroDeDerrotas(){
		$rendimento = new RendimetoTime();
		$rendimento->incrementaDerrotas();
		$this->assertEqual($rendimeto->getDerrotas(), 1);
	}
	
	function testaNumeroDePontos(){
		$rendimento = new RendimetoTime();
		$rendimento->incrementaVitorias();
		$this->assertEqual($rendimeto->calculaPontos(), 3); 
	}
	
	function testaNumeroDePontos2(){
		$rendimento = new RendimetoTime();
		$rendimento->incrementaEmpates();
		$this->assertEqual($rendimeto->calculaPontos(), 1);
	}
	
	function testaNumeroDePontos(){
		$rendimento = new RendimetoTime();
		$rendimento->incrementaVitorias();
		$rendimento->incrementaEmpates();
		$this->assertEqual($rendimeto->calculaPontos(), 4);
	}
	
	function testaNumeroDeVitorias(){
		$rendimento = new RendimetoTime();
		$rendimento->incrementaVitorias();
		$this->assertEqual($rendimeto->getVitorias(), 1);
	}
	
	function testaNumeroDeEmpates(){
		$rendimento = new RendimetoTime();
		$rendimento->incrementaEmpates();
		$this->assertEqual($rendimeto->getEmpates(), 1);
	}
	
	function testaNumeroDeGolsPro(){
		$rendimento = new RendimetoTime();
		$rendimento->setGolsPro(3);
		$this->assertEqual($rendimeto->getGolsPro(3), 3);
	}
	
	function testaNumeroDeGolsContra(){
		$rendimento = new RendimetoTime();
		$rendimento->setGolsContra(2);
		$this->assertEqual($rendimeto->getGolsContra(2), 2);
	}
	
	function testaSaldoDeGols(){ 
		$rendimento = new RendimetoTime();
		$rendimento->setGolsPro(5);
		$rendimento->setGolsContra(2);
		$this->assertEqual($rendimeto->calculaSaldoDeGols(), 3);
	}
	
	function testaPontos1(){
		$rendimento = new RendimetoTime();
		$time->setVitorias();
		$this->assertEqual($rendimeto->calculaPontos(), 3);
	}
	
	function testaPontos2(){
		$rendimento = new RendimetoTime();
		$time->setEmpates();
		$this->assertEqual($rendimeto->calculaPontos(), 1);
	}
	
	function testaPontos3(){
		$rendimento = new RendimetoTime();
		$time->setDerrotas();
		$this->assertEqual($rendimeto->calculaPontos(), 0);
	}
}