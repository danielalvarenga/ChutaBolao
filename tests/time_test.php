<?php

require_once('simpletest/autorun.php');
require_once('../ChutaBolao/test/Time.php');

class TestOfTime extends UnitTestCase {
  
	function testaNumeroDeDerrotas(){
		$time = new Time();
		$this->assertEqual($time->setDerrotas(), 1);
	}
	
	function testaNumeroDePontos(){
		$time = new Time();
		$this->assertEqual($time->setPontos(3), 3); 
	}
	
	function testaNumeroDeVitorias(){
		$time = new Time();
		$this->assertEqual($time->setVitorias(), 1);
	}
	
	function testaNumeroDeEmpates(){
		$time = new Time();
		$this->assertEqual($time->setEmpates(), 1);
	}
	
	function testaNumeroDeGolsPro(){
		$time = new Time();
		$this->assertEqual($time->setGolsPro(3), 3);
	}
	
	function testaNumeroDeGolsContra(){
		$time = new Time();
		$this->assertEqual($time->setGolsContra(2), 2);
	}
	
	function testaSaldoDeGols(){
		$time = new Time();
		$time->setGolsPro(5);
		$time->setGolsContra(2);
		$this->assertEqual($time->calculaSaldoDeGola(), 3);
	}
	
	function testaPontos1(){
		$time = new Time();
		$time->setVitorias();
		$this->assertEqual($time->calculaPontos(), 3);
	}
	
	function testaPontos2(){
		$time = new Time();
		$time->setEmpates();
		$this->assertEqual($time->calculaPontos(), 1);
	}
	
	function testaPontos3(){
		$time = new Time();
		$time->setDerrotas();
		$this->assertEqual($time->calculaPontos(), 0);
	}
}
?>