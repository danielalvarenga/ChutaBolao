<?php

require_once('simpletest/autorun.php');
require_once('../classes/Time.php');

class TestTime extends UnitTestCase {

function TestGetSetNome(){
		$time = new time("corinthians paulista");
		//$time->setNome("corinthians paulista");
		$this->assertEqual($time->getNome(), "CORINTHIANS PAULISTA");
	}
	
	function TestGetSetNome2(){
		$time = new time("CORINTHIANS PAULISTA");
		//$time->setNome();
		$this->assertEqual($time->getNome(), "CORINTHIANS PAULISTA");
	}
}

?>