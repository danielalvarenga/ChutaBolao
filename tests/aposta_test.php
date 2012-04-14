<?php
require_once('simpletest/autorun.php');
require_once('../classes/Aposta.php');

class TestOfAposta extends UnitTestCase{
	var $aposta;
	var $aposta1;
	function setUp(){
		$this->aposta=new Aposta(123,1,1);

	}

	function TestApostaGolsTime1Negativa1() {
		try {
			$erro=false;
			$this->aposta->setApostaGolsTime1(-1);
			$this->aposta->setApostaGolsTime2(3);

		} catch (Exception $e) {
			$erro=true;
		}
		$this->assertTrue($erro);

	}
	function TestApostaGolsTime1Negativa2() {
		try {
			$erro=false;
			$this->aposta->setApostaGolsTime1(-3);
			$this->aposta->setApostaGolsTime2(1);


		} catch (Exception $e) {
			$erro=true;
		}
		$this->assertTrue($erro);

	}
	function TestApostaGolsTime1Negativa3() {
		try {
			$erro=false;
			$this->aposta->setApostaGolsTime1(-5);
			$this->aposta->setApostaGolsTime2(0);


		} catch (Exception $e) {
			$erro=true;
		}
		$this->assertTrue($erro);

	}
	function TestApostaGolsTime2Negativa1() {
		try {
			$erro=false;
			$this->aposta->setApostaGolsTime1(1);
			$this->aposta->setApostaGolsTime2(-3);

		} catch (Exception $e) {
			$erro=true;
		}
		$this->assertTrue($erro);

	}
	function TestApostaGolsTime2Negativa2() {
		try {
			$erro=false;
			$this->aposta->setApostaGolsTime1(3);
			$this->aposta->setApostaGolsTime2(-1);


		} catch (Exception $e) {
			$erro=true;
		}
		$this->assertTrue($erro);

	}
	function TestApostaGolsTime2Negativa3() {
		try {
			$erro=false;
			$this->aposta->setApostaGolsTime1(0);
			$this->aposta->setApostaGolsTime2(-5);


		} catch (Exception $e) {
			$erro=true;
		}
		$this->assertTrue($erro);

	}

	function TestApostaGolsTime1ValorNulo() {
		try {
			$erro=false;
			$this->aposta->setApostaGolsTime1(null);
			$this->aposta->setApostaGolsTime2(3);

		} catch (Exception $e) {
			$erro=true;
		}
		$this->assertTrue($erro);

	}
	function TestApostaGolsTime2ValorNulo() {
		try {
			$erro=false;
			$this->aposta->setApostaGolsTime1(3);
			$this->aposta->setApostaGolsTime2(null);


		} catch (Exception $e) {
			$erro=true;
		}
		$this->assertTrue($erro);

	}
	function TestApostaJogoRepetidaInvalida1(){
		try {
			$erro=false;
			$this->aposta1=new Aposta(123,1,1);
			$this->aposta->setApostaGolsTime1(3);
			$this->aposta->setApostaGolsTime2(0);
			$this->aposta1->setApostaGolsTime1(3);
			$this->aposta1->setApostaGolsTime2(0);
		} catch (Exception $e) {
			$erro=true;
		}
		$this->assertTrue($erro);

	}
	function TestApostaJogoRepetidaInvalida2(){
		try {
			$erro=false;
			$this->aposta1=new Aposta(123,1,1);
			$this->aposta->setApostaGolsTime1(2);
			$this->aposta->setApostaGolsTime2(0);
			$this->aposta1->setApostaGolsTime1(3);
			$this->aposta1->setApostaGolsTime2(0);
		} catch (Exception $e) {
			$erro=true;
		}
		$this->assertTrue($erro);

	}
	function TestApostaJogoRepetidaInvalida3(){
		try{
			$erro=false;
			$this->aposta1=new Aposta(123,1,1);
			$this->aposta->setApostaGolsTime1(3);
			$this->aposta->setApostaGolsTime2(0);
			$this->aposta1->setApostaGolsTime1(4);
			$this->aposta1->setApostaGolsTime2(3);

		} catch (Exception $e) {
			$erro=true;
		}
		$this->assertTrue($erro);

	}
	function TestParametrosInvalido1(){

		try{
			$erro=false;
			$c=new Aposta(null, 1,1);

		}catch (Exception $e){
			$erro=true;
		}
		$this->assertTrue($erro);
	}
	function TestParametrosInvalido2(){

		try{
			$erro=false;
			$c=new Aposta(123,null,1);

		}catch (Exception $e){
			$erro=true;
		}
		$this->assertTrue($erro);
	}
	function TestParametrosInvalido3(){

		try{
			$erro=false;
			$c=new Aposta(123, 1,null);

		}catch (Exception $e){
			$erro=true;
		}
		$this->assertTrue($erro);
	}
	function TestCalculaPontuacaoAcertoPlacar1(){
		$this->aposta->setApostaGolsTime1(3);
		$this->aposta->setApostaGolsTime2(0);
		$this->aposta->calculaPontosAposta(3, 0);
		$this->assertEqual($this->aposta->getPontosAposta(), 10);
	}
	function TestaCalculaPontuacaoAcertoPlacar2(){
		$this->aposta->setApostaGolsTime1(0);
		$this->aposta->setApostaGolsTime2(0);
		$this->aposta->calculaPontosAposta(0, 0);
		$this->assertEqual($this->aposta->getPontosAposta(), 10);
	}
	function TestaCalculaPontuacaoAcertoPlacar3(){
		$this->aposta->setApostaGolsTime1(0);
		$this->aposta->setApostaGolsTime2(3);
		$this->aposta->calculaPontosAposta(0, 3);
		$this->assertEqual($this->aposta->getPontosAposta(), 10);
	}
	function TestCalculaPontuacaoAcertoPlacarInvertido1(){
		$this->aposta->setApostaGolsTime1(3);
		$this->aposta->setApostaGolsTime2(0);
		$this->aposta->calculaPontosAposta(0, 3);
		$this->assertEqual($this->aposta->getPontosAposta(), 2);
	}
	function TestaCalculaPontuacaoAcertoPlacarInvertido2(){
		$this->aposta->setApostaGolsTime1(0);
		$this->aposta->setApostaGolsTime2(3);
		$this->aposta->calculaPontosAposta(3, 0);
		$this->assertEqual($this->aposta->getPontosAposta(), 2);
	}
	function TestaCalculaPontuacaoAcertoPlacarInvertido3(){
		$this->aposta->setApostaGolsTime1(5);
		$this->aposta->setApostaGolsTime2(3);
		$this->aposta->calculaPontosAposta(3, 5);
		$this->assertEqual($this->aposta->getPontosAposta(), 2);
	}
	function TestCalculaPontuacaoAcertoGanhador1(){
		$this->aposta->setApostaGolsTime1(3);
		$this->aposta->setApostaGolsTime2(0);
		$this->aposta->calculaPontosAposta(2, 0);
		$this->assertEqual($this->aposta->getPontosAposta(), 5);
	}
	function TestaCalculaPontuacaoAcertoGanhador2(){
		$this->aposta->setApostaGolsTime1(2);
		$this->aposta->setApostaGolsTime2(0);
		$this->aposta->calculaPontosAposta(3, 0);
		$this->assertEqual($this->aposta->getPontosAposta(), 5);
	}
	function TestaCalculaPontuacaoAcertoGanhador3(){
		$this->aposta->setApostaGolsTime1(0);
		$this->aposta->setApostaGolsTime2(3);
		$this->aposta->calculaPontosAposta(0, 4);
		$this->assertEqual($this->aposta->getPontosAposta(), 5);
	}
	function TestaCalculaPontuacaoAcertoGanhador4(){
		$this->aposta->setApostaGolsTime1(0);
		$this->aposta->setApostaGolsTime2(3);
		$this->aposta->calculaPontosAposta(0, 2);
		$this->assertEqual($this->aposta->getPontosAposta(), 5);
	}
	function TestaCalculaPontuacaoAcertoGanhador5(){
		$this->aposta->setApostaGolsTime1(3);
		$this->aposta->setApostaGolsTime2(3);
		$this->aposta->calculaPontosAposta(0, 0);
		$this->assertEqual($this->aposta->getPontosAposta(), 5);
	}
	function TestaCalculaPontuacaoAcertoGanhador6(){
		$this->aposta->setApostaGolsTime1(0);
		$this->aposta->setApostaGolsTime2(0);
		$this->aposta->calculaPontosAposta(2, 2);
		$this->assertEqual($this->aposta->getPontosAposta(), 5);
	}
	function TestPontuacaoIgualZero1(){
		$this->aposta->setApostaGolsTime1(3);
		$this->aposta->setApostaGolsTime2(0);
		$this->aposta->calculaPontosAposta(0, 2);
		$this->assertEqual($this->aposta->getPontosAposta(), 0);
	}
	function TestaPontuacaoIgualZero2(){
		$this->aposta->setApostaGolsTime1(0);
		$this->aposta->setApostaGolsTime2(3);
		$this->aposta->calculaPontosAposta(2, 0);
		$this->assertEqual($this->aposta->getPontosAposta(), 0);
	}
	function TestaCalculaPontuacaoIgualZero3(){
		$this->aposta->setApostaGolsTime1(3);
		$this->aposta->setApostaGolsTime2(3);
		$this->aposta->calculaPontosAposta(4, 3);
		$this->assertEqual($this->aposta->getPontosAposta(), 0);
	}
	function TestaCalculaPontuacaoIgualZero4(){
		$this->aposta->setApostaGolsTime1(4);
		$this->aposta->setApostaGolsTime2(3);
		$this->aposta->calculaPontosAposta(3, 3);
		$this->assertEqual($this->aposta->getPontosAposta(), 0);
	}

}
?>
