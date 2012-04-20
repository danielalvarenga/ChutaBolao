<?php
require_once('simpletest/autorun.php');
require_once('../classes/Campeonato.php');

class TestOfCampeonato extends UnitTestCase {
	
	var $c1;
	var $c2;
	
	function setUp(){
		$codCampeonato = 12345;
		$nomeCampeonato = "CAMPEONATO";
		$anoCampeonato = 2012;
		$quantidadeRodadas = 38;
		$status = "ATIVO";
		$this->c1 = new Campeonato($codCampeonato, $nomeCampeonato, $anoCampeonato, $quantidadeRodadas, $status);
		$this->c2 = new Campeonato($codCampeonato, $nomeCampeonato, $anoCampeonato, $quantidadeRodadas, $status);
	}
	
	
	
	function testaNomeCampeonato1(){
		$nomeCampeonato = "brasileiro";
		$this->c1->setNomeCampeonato($nomeCampeonato);
		$this->assertEqual($this->c1->getNomeCampeonato(), "BRASILEIRO");
	}
	
	function testaNomeCampeonato2(){
		$nomeCampeonato = "BRASILEIRO";
		$this->c1->setNomeCampeonato($nomeCampeonato);
		$this->assertEqual($this->c1->getNomeCampeonato(), "BRASILEIRO");
	}
	
	function testaNomeCampeonato3(){
		$nomeCampeonato = "BRAsileiro";
		$this->c1->setNomeCampeonato($nomeCampeonato);
		$this->assertEqual($this->c1->getNomeCampeonato(), "BRASILEIRO");
	}
	
	function testaNomeCampeonato4(){
		$nomeCampeonato = "brasiLEIRO";
		$this->c1->setNomeCampeonato($nomeCampeonato);
		$this->assertEqual($this->c1->getNomeCampeonato(), "BRASILEIRO");
	}
	
	function TestNomeCampeonatoInvalido1() {
		try {
			$erro=false;
			$this->c1->setAnoCampeonato(2012);
			$this->c2->setAnoCampeonato(2012);
			$this->c1->setNomeCampeonato("brasileiro");
			$this->c2->setNomeCampeonato("brasileiro");
	
		} catch (Exception $e) {
			$erro=true;
		}
	}
	
	function TestNomeCampeonatoInvalido2() {
		try {
			$erro=false;
			$this->c1->setNomeCampeonato("brasileiro2012");
				
		} catch (Exception $e) {
			$erro=true;
		}
	}
	
	function TestNomeCampeonatoInvalido3() {
		try {
			$erro=false;
			$this->c1->setNomeCampeonato("br@sileir0");
	
		} catch (Exception $e) {
			$erro=true;
		}
	}
	
	function testaAnoCampeonato1(){
		$anoCampeonato = 2012;
		$this->c1->setAnoCampeonato($anoCampeonato);
		$this->assertEqual($this->c1->getAnoCampeonato(), 2012);
	}
	
	function testaAnoCampeonato2(){
		$anoCampeonato = 2013;
		$this->c1->setAnoCampeonato($anoCampeonato);
		$this->assertEqual($this->c1->getAnoCampeonato(), 2013);
	}
	
	function testaAnoCampeonato3(){
		$anoCampeonato = 2014;
		$this->c1->setAnoCampeonato($anoCampeonato);
		$this->assertEqual($this->c1->getAnoCampeonato(), 2014);
	}
	
	function TestAnoCampeonatoInvalido1() {
		try {
			$erro=false;
			$this->c1->setAnoCampeonato(1999);
	
		} catch (Exception $e) {
			$erro=true;
		}
	}
	
	function TestAnoCampeonatoInvalido2() {
		try {
			$erro=false;
			$this->c1->setAnoCampeonato(2000);
	
		} catch (Exception $e) {
			$erro=true;
		}
	}
	
	function TestAnoCampeonatoInvalido3() {
		try {
			$erro=false;
			$this->c1->setAnoCampeonato(2001);
	
		} catch (Exception $e) {
			$erro=true;
		}
	}
	
	function TestAnoCampeonatoInvalido4() {
		try {
			$erro=false;
			$this->c1->setAnoCampeonato(2011);
	
		} catch (Exception $e) {
			$erro=true;
		}
	}
	
	function TestAnoCampeonatoInvalido5() {
		try {
			$erro=false;
			$this->c1->setAnoCampeonato(0);
	
		} catch (Exception $e) {
			$erro=true;
		}
	}
	
	function TestAnoCampeonatoInvalido6() {
		try {
			$erro=false;
			$this->c1->setAnoCampeonato(1);
	
		} catch (Exception $e) {
			$erro=true;
		}
	}
	
	function TestAnoCampeonatoInvalido7() {
		try {
			$erro=false;
			$this->c1->setAnoCampeonato(-1);
	
		} catch (Exception $e) {
			$erro=true;
		}
	}
	
	function TestAnoCampeonatoInvalido8() {
		try {
			$erro=false;
			$this->c1->setAnoCampeonato(-2012);
	
		} catch (Exception $e) {
			$erro=true;
		}
	}
	
	function TestAnoCampeonatoInvalido9() {
		try {
			$erro=false;
			$this->c1->setAnoCampeonato(-2011);
	
		} catch (Exception $e) {
			$erro=true;
		}
	}
	
	function TestAnoCampeonatoInvalido10() {
		try {
			$erro=false;
			$this->c1->setAnoCampeonato(-2013);
	
		} catch (Exception $e) {
			$erro=true;
		}
	}
	
	function testaQuantidadeRodadas1(){
		$quantidadeRodadas = 10;
		$this->c1->setQuantidadeRodadas($quantidadeRodadas);
		$this->assertEqual($this->c1->getQuantidadeRodadas(), 10);
	}
	
	function testaQuantidadeRodadas2(){
		$quantidadeRodadas = 11;
		$this->c1->setQuantidadeRodadas($quantidadeRodadas);
		$this->assertEqual($this->c1->getQuantidadeRodadas(), 11);
	}
	
	function testaQuantidadeRodadas3(){
		$quantidadeRodadas = 12;
		$this->c1->setQuantidadeRodadas($quantidadeRodadas);
		$this->assertEqual($this->c1->getQuantidadeRodadas(), 12);
	}
	
	function testaQuantidadeRodadas4(){
		$quantidadeRodadas = 37;
		$this->c1->setQuantidadeRodadas($quantidadeRodadas);
		$this->assertEqual($this->c1->getQuantidadeRodadas(), 37);
	}
	
	function testaQuantidadeRodadas5(){
		$quantidadeRodadas = 38;
		$this->c1->setQuantidadeRodadas($quantidadeRodadas);
		$this->assertEqual($this->c1->getQuantidadeRodadas(), 38);
	}
	
	function testaQuantidadeRodadasInvalida1() {
		try {
			$erro=false;
			$this->c1->setQuantidadeRodadas(0);
	
		} catch (Exception $e) {
			$erro=true;
		}
	}
	
	function testaQuantidadeRodadasInvalida2() {
		try {
			$erro=false;
			$this->c1->setQuantidadeRodadas(-1);
	
		} catch (Exception $e) {
			$erro=true;
		}
	}

	function testaQuantidadeRodadasInvalida3() {
		try {
			$erro=false;
			$this->c1->setQuantidadeRodadas(-38);
	
		} catch (Exception $e) {
			$erro=true;
		}
	}
	
	function testaStatus1(){
		$status = "ativo";
		$this->c1->setStatus($status);
		$this->assertEqual($this->c1->getStatus(), "ATIVO");
	}	
	
	function testaStatus2(){
		$status = "ATIVO";
		$this->c1->setStatus($status);
		$this->assertEqual($this->c1->getStatus(), "ATIVO");
	}
	
	function testaStatus3(){
		$status = "Ativo";
		$this->c1->setStatus($status);
		$this->assertEqual($this->c1->getStatus(), "ATIVO");
	}
	
	function testaStatus4(){
		$status = "ATIvo";
		$this->c1->setStatus($status);
		$this->assertEqual($this->c1->getStatus(), "ATIVO");
	}
	
	function testaStatus5(){
		$status = "atiVO";
		$this->c1->setStatus($status);
		$this->assertEqual($this->c1->getStatus(), "ATIVO");
	}
	
	function testaStatus6(){
		$status = "finalizado";
		$this->c1->setStatus($status);
		$this->assertEqual($this->c1->getStatus(), "FINALIZADO");
	}
	
	function testaStatus7(){
		$status = "FINALIZADO";
		$this->c1->setStatus($status);
		$this->assertEqual($this->c1->getStatus(), "FINALIZADO");
	}
	
	function testaStatus8(){
		$status = "fINALIZADO";
		$this->c1->setStatus($status);
		$this->assertEqual($this->c1->getStatus(), "FINALIZADO");
	}
	
	function testaStatus9(){
		$status = "Finalizado";
		$this->c1->setStatus($status);
		$this->assertEqual($this->c1->getStatus(), "FINALIZADO");
	}
	
	function testaStatus10(){
		$status = "finALIZADO";
		$this->c1->setStatus($status);
		$this->assertEqual($this->c1->getStatus(), "FINALIZADO");
	}
	
	function TestStatusInvalido() {
		try {
			$erro=false;
			$this->c1->setStatus("ativado");
	
		} catch (Exception $e) {
			$erro=true;
		}
	}	
	
	function TestStatusInvalido1() {
		try {
			$erro=false;
			$this->c1->setStatus("DESATIVADO");
	
		} catch (Exception $e) {
			$erro=true;
		}
	}
	
	function TestStatusInvalido2() {
		try {
			$erro=false;
			$this->c1->setStatus("ativ0");
	
		} catch (Exception $e) {
			$erro=true;
		}
	}
	
	function TestStatusInvalido3() {
		try {
			$erro=false;
			$this->c1->setStatus("f1naliz4d0");
	
		} catch (Exception $e) {
			$erro=true;
		}
	}
	
}