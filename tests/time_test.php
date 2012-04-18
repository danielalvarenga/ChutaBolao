<?php

require_once('simpletest/autorun.php');
require_once('../ChutaBolao/test/Time.php');

class TestTime extends UnitTestCase {

function TestaGetSetNome(){
		$time = new time();
		$time->setNome("corinthians paulista");
		$this->assertEqual($time->getNome(), "CORINTHIANS PAULISTA");
	}
	
	function TestaGetSetNome2(){
		$time = new time();
		$time->setNome("CORINTHIANS PAULISTA");
		$this->assertEqual($time->getNome(), "CORINTHIANS PAULISTA");
	}
}

?>