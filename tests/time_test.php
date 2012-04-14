<?php

require_once('simpletest/autorun.php');
require_once('../ChutaBolao/test/Time.php');

class TestOfTime extends UnitTestCase {
  
	function TestaGetSetNome(){
		$time = newTime();
		$time->setNome("corinthians paulista");
		$this->assertEqual($time->getNome(), "CORINTHIANS PAULISTA");
	}
	
	function TestaGetSetNome2(){
		$time = newTime();
		$time->setNome("CORINTHIANS PAULISTA");
		$this->assertEqual($time->getNome(), "CORINTHIANS PAULISTA");
	}
}	

?>