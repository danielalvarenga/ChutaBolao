<?php

require_once('simpletest/autorun.php');
require_once('../classes/premiosUsuario.php');

class TestPremiosUsuario extends UnitTestCase {
	
	var $p1;
	
	function setUp(){
		$idUsuario = 1;
		$codCampeonato = 2;
		$codTimeFavorito = 3;
		$this->p1 = new PremiosUsuario($idUsuario, $codCampeonato);
		$p2 = new PremiosUsuario($idUsuario, $codCampeonato, $codTimeFavorito);
		$this->assertEqual($p2->getCodTimeFavorito(), 3);
	}
	function TestGetUsuario(){
		$this->assertEqual($this->p1->getUsuario(), 1);
	}
	function TestGetCampeonato(){
		$this->assertEqual($this->p1->getCampeonato(), 2);
	}
	function TestGetCodTimeFavorito(){
		$this->assertEqual($this->p1->getCodTimeFavorito(), 0);
	}
	function TestGetAcertosPlacar(){
		$this->assertEqual($this->p1->getAcertosPlacar(), 0);
	}
	function TestGetAcertosTimeGanhador(){
		$this->assertEqual($this->p1->getAcertosTimeGanhador(), 0);
	}
	function TestGetAcertosPlacarInvertido(){
		$this->assertEqual($this->p1->getAcertosPlacarInvertido(), 0);
	}
	function TestGetPontosCampeonato(){
		$this->assertEqual($this->p1->getPontosCampeonato(), 0);
	}
	function TestGetMedalhasOuro(){
		$this->assertEqual($this->p1->getMedalhasOuro(), 0);
	}
	function TestGetMedalhasPrata(){
		$this->assertEqual($this->p1->getMedalhasPrata(), 0);
	}
	function TestGetMedalhasBronze(){
		$this->assertEqual($this->p1->getMedalhasBronze(), 0);
	}
	function TestGetChuteirasOuro(){
		$this->assertEqual($this->p1->getChuteirasOuro(), 0);
	}
	function TestGetChuteirasPrata(){
		$this->assertEqual($this->p1->getChuteirasPrata(), 0);
	}
	function TestGetChuteirasBronze(){
		$this->assertEqual($this->p1->getChuteirasBronze(), 0);
	}
	function TestGetTrofeu(){
		$this->assertEqual($this->p1->getTrofeu(), false);
	}
	function TestGetSetCodTimeFavorito(){
		$codTimeFavorito = 4;
		$this->p1->setCodTimeFavorito($codTimeFavorito);
		$this->assertEqual($this->p1->getCodTimeFavorito(), 4);
	}
	function TestAcertaPlacar(){
		$this->p1->acertaPlacar();
		$this->assertEqual($this->p1->getAcertosPlacar(), 1);
	}
	function TestAcertaTimeGanhador(){
		$this->p1->acertaTimeGanhador();
		$this->assertEqual($this->p1->getAcertosTimeGanhador(), 1);
	}
	function TestAcertaPlacarInvertido(){
		$this->p1->acertaPlacarInvertido();
		$this->assertEqual($this->p1->getAcertosPlacarInvertido(), 1);
	}
	function TestGanhaPontosCampeonato(){
		$this->p1->ganhaPontosCampeonato(10);
		$this->assertEqual($this->p1->getPontosCampeonato(), 10);
	}
	function TestGanhaMedalhaOuro(){
		$this->p1->ganhaMedalhaOuro();
		$this->assertEqual($this->p1->getMedalhasOuro(), 1);
	}
	function TestGanhaMedalhaPrata(){
		$this->p1->ganhaMedalhaPrata();
		$this->assertEqual($this->p1->getMedalhasPrata(), 1);
	}
	function TestGanhaMedalhaBronze(){
		$this->p1->ganhaMedalhaBronze();
		$this->assertEqual($this->p1->getMedalhasBronze(), 1);
	}
	function TestGanhaChuteiraOuro(){
		$this->p1->ganhaChuteiraOuro();
		$this->assertEqual($this->p1->getChuteirasOuro(), 1);
	}
	function TestGanhaChuteiraPrata(){
		$this->p1->ganhaChuteiraPrata();
		$this->assertEqual($this->p1->getChuteirasPrata(), 1);
	}
	function TestGanhaChuteiraBronze(){
		$this->p1->ganhaChuteiraBronze();
		$this->assertEqual($this->p1->getChuteirasBronze(), 1);
	}
	function TestGanhaTrofeu(){
		$this->p1->ganhaTrofeu();
		$this->assertEqual($this->p1->getTrofeu(), true);
	}
}