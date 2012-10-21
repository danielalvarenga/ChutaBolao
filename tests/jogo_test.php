<?php

require_once('simpletest/autorun.php');
require_once('../classes/Jogo.php');

class TestOfJogo extends UnitTestCase{
	var $jogo;
	var $codTime1;
	var $codTime2;
	var $codRodada;
	var $dataJogo;
	var $dataInicioAposta;
	var $dataFimAposta;
	function setUp(){
		$this->codTime1=2;
		$this->codTime2=3;
		$this->codRodada=1;
		$this->dataJogo='2012-06-12-21:30:00';
		$this->dataInicioAposta='2012-04-24-08:00:00';
		$this->dataFimAposta='2012-06-12-20:30:00';
		$this->jogo=new Jogo( $this->dataJogo,$this->codRodada,$this->codTime1 ,$this->codTime2);//,strtotime('2012-04-17'), strtotime('2012-05-11'));
	    $this->jogo->setDataInicioApostas($this->dataInicioAposta);
        $this->jogo->setDataFimApostas($this->dataFimAposta);	
	}

	function TestVerificaPeriodoApostas1() {
		$this->assertEqual($this->jogo->verificaPeriodoapostas('2012-04-24-12:01:00'), true);
		}
	function TestVerificaPeriodoApostas2() {
		$this->assertEqual($this->jogo->verificaPeriodoapostas('2012-05-22-14:10:30'), true);
	}
	function TestVerificaPeriodoApostas3() {
		$this->assertEqual($this->jogo->verificaPeriodoapostas('2012-06-11-21:15:10'), true);
	}
	
	function TestVerificaPeriodoApostasInvalido1() {
		$this->assertEqual($this->jogo->verificaPeriodoapostas('2012-03-18-12:30:29'), false);
	}
	
	function TestVerificaPeriodoApostasInvalido2() {
		$this->assertEqual($this->jogo->verificaPeriodoapostas('2012-03-30-11:10:52'), false);
	}
	
	function TestVerificaPeriodoApostasInvalido3() {
		$this->assertEqual($this->jogo->verificaPeriodoapostas('2012-06-13-13:05:01'), false);
	}
	function TestPlacarInvalido1(){
		$GolsTime1 = -1;
		$GolsTime2 = 2;
		try {
			$erro=false;
			$this->jogo->setGolstime1($GolsTime1);
			$this->jogo->setGolstime2($GolsTime2);
		} catch (Exception $e) {
			$erro=true;
		}
		$this->assertTrue($erro);
	}
	function TestPlacarInvalido2(){
		$GolsTime1 = 2;
		$GolsTime2 = -2;
		try {
			$erro=false;
			$this->jogo->setGolstime1($GolsTime1);
			$this->jogo->setGolstime2($GolsTime2);
		} catch (Exception $e) {
			$erro=true;
		}
		$this->assertTrue($erro);
	}
	function TestPlacarInvalido3(){
		$GolsTime1 = -1;
		$GolsTime2 = -2;
		try {
			$erro=false;
			$this->jogo->setGolstime1($GolsTime1);
			$this->jogo->setGolstime2($GolsTime2);
		} catch (Exception $e) {
			$erro=true;
		}
		$this->assertTrue($erro);
	}
	
	function TestPlacarInvalido4(){
		$GolsTime1 = null;
		$GolsTime2 = -2;
		try {
			$erro=false;
			$this->jogo->setGolstime1($GolsTime1);
			$this->jogo->setGolstime2($GolsTime2);
		} catch (Exception $e) {
			$erro=true;
		}
		$this->assertTrue($erro);
	}
	function TestPlacarInvalido5(){
		$GolsTime1 = -1;
		$GolsTime2 = null;
		try {
			$erro=false;
			$this->jogo->setGolstime1($GolsTime1);
			$this->jogo->setGolstime2($GolsTime2);
		} catch (Exception $e) {
			$erro=true;
		}
		$this->assertTrue($erro);
	}
	function TestPlacarInvalido6(){
		$GolsTime1 = null;
		$GolsTime2 = null;
		try {
			$erro=false;
			$this->jogo->setGolstime1($GolsTime1);
			$this->jogo->setGolstime2($GolsTime2);
		} catch (Exception $e) {
			$erro=true;
		}
		$this->assertTrue($erro);
	}
	
	
	function TestRodadaInvalida1(){
		try {
			$erro = false;
			$jogo1 = new Jogo($this->dataJogo, 0, $this->codTime1, $this->codTime2);
			
		} catch (Exception $e) {
		$erro=true;
		}
		$this->assertTrue($erro);
			}
	
	function TestRodadaInvalida2(){
		try {
			$erro = false;
			$jogo1 = new Jogo($this->dataJogo, -5 , $this->codTime1, $this->codTime2);
				
		} catch (Exception $e) {
			$erro=true;
		}
		$this->assertTrue($erro);
		
	}
	
	function TestRodadaInvalida3(){
		try {
			$erro = false;
			$jogo1 = new Jogo($this->dataJogo, null, $this->codTime1, $this->codTime2);
				
		} catch (Exception $e) {
			$erro=true;
		}
		$this->assertTrue($erro);
		
	}
	function TestDataJogoInvalida1(){
		try {
			$erro = false;
			$jogo1 = new Jogo('2012-04-20-10:12:15', $this->codRodada , $this->codTime1, $this->codTime2);
				
		} catch (Exception $e) {
			$erro=true;
		}
		$this->assertTrue($erro);
	}
	
	function TestDataJogoInvalida2(){
		try {
			$erro = false;
			$jogo1 = new Jogo('2012-02-28-23:58:59', $this->codRodada , $this->codTime1, $this->codTime2);
	
		} catch (Exception $e) {
			$erro=true;
		}
		$this->assertTrue($erro);
	
	}
	
	function TestDataJogoInvalida3(){
		try {
			$erro = false;
			$jogo1 = new Jogo( null , $this->codRodada, $this->codTime1, $this->codTime2);
	
		} catch (Exception $e) {
			$erro=true;
		}
		$this->assertTrue($erro);
	
	}
	function TestCodTime1Invalida1(){
		try {
			$erro = false;
			$jogo1 = new Jogo($this->dataJogo, $this->codRodada , 0 , $this->codTime2);
				
		} catch (Exception $e) {
			$erro=true;
		}
		$this->assertTrue($erro);
	}
	
	function TestCodTime1Invalida2(){
		try {
			$erro = false;
			$jogo1 = new Jogo($this->dataJogo, $this->codRodada, -5, $this->codTime2);
	
		} catch (Exception $e) {
			$erro=true;
		}
		$this->assertTrue($erro);
	
	}
	
	function TestCodTime1Invalida3(){
		try {
			$erro = false;
			$jogo1 = new Jogo($this->dataJogo, $this->codRodada , null, $this->codTime2);
	
		} catch (Exception $e) {
			$erro=true;
		}
		$this->assertTrue($erro);
	
	}
	
	function TestCodTime2Invalida1(){
		try {
			$erro = false;
			$jogo1 = new Jogo($this->dataJogo, $this->codRodada , $this->codTime1 , 0);
	
		} catch (Exception $e) {
			$erro=true;
		}
		$this->assertTrue($erro);
	}
	
	function TestCodTime2Invalida2(){
		try {
			$erro = false;
			$jogo1 = new Jogo($this->dataJogo, $this->codRodada, $this->codTime1, -5);
	
		} catch (Exception $e) {
			$erro=true;
		}
		$this->assertTrue($erro);
	
	}
	
	function TestCodTime2Invalida3(){
		try {
			$erro = false;
			$jogo1 = new Jogo($this->dataJogo, $this->codRodada ,$this->codTime1 , null);
	
		} catch (Exception $e) {
			$erro=true;
		}
		$this->assertTrue($erro);
	
	}
	function TestCodTime1Codtime2IguaisInvalido1(){
		try {
			$erro = false;
			$jogo1 = new Jogo($this->dataJogo, $this->codRodada , 1 , 1 );
	
		} catch (Exception $e) {
			$erro=true;
		}
		$this->assertTrue($erro);
	
	}
	function TestCodTime1Codtime2IguaisInvalido2(){
		try {
			$erro = false;
			$jogo1 = new Jogo($this->dataJogo, $this->codRodada , -1 , -1 );
	
		} catch (Exception $e) {
			$erro=true;
		}
		$this->assertTrue($erro);
	
	}
	function TestCodTime1Codtime2IguaisInvalido3(){
		try {
			$erro = false;
			$jogo1 = new Jogo($this->dataJogo, $this->codRodada , 0 , 0 );
	
		} catch (Exception $e) {
			$erro=true;
		}
		$this->assertTrue($erro);
	
	}
	
}