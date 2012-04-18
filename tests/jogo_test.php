<?php

require_once('simpletest/autorun.php');
require_once('../classes/Jogo.php');

class TestOfJogo extends UnitTestCase{
	var $jogo;
	
	function setUp(){
		$this->jogo=new Jogo(1, strtotime('2012-05-12'), 1, 2, 3,strtotime('2012-04-17'), strtotime('2012-05-11'));
	}

	function TestVerificaPeriodoapostas() {
		$this->assertEqual($this->jogo->verificaPeriodoapostas(strtotime('2012-04-18')), true);		
	}
	
	function TestMudaplacar(){
		$GolsTime1 = 4;
		$GolsTime2 = 2;
		$this->assertEqual($this->jogo->setGolstime1($GolsTime1), true);
		$this->assertEqual($this->jogo->setGolstime2($GolsTime2), true);
	}
	
	function TestVerificaplacar(){
		$this->jogo->setGolstime1(3);
		$this->jogo->setGolstime2(0);
		$this->assertEqual($this->jogo->getGolstime1(), 3);
		$this->assertEqual($this->jogo->getGolstime2(), 0);
	}
	
	function TestRodada(){
		$this->assertEqual($this->jogo->getRodada(), 1);
	}
	
	function TestCodjogo(){
		$this->assertEqual($this->jogo->getCodjogo(), 1);
	}
	
	function TestDatajogo(){
		$this->assertEqual($this->jogo->getDatajogo(), strtotime('2012-05-12'));
	}
	
	function TestTimes(){
		$this->assertEqual($this->jogo->getCodtime1(), 2);
		$this->assertEqual($this->jogo->getCodtime2(), 3);
	}
	
}