<?php

require_once('simpletest/autorun.php');

class RodaTodosOsTestes extends TestSuite {
	
	function RodaTodosOsTestes(){
		$this->TestSuite('Roda todos os testes');
		$this->addFile('usuario_test.php');
		$this->addFile('time_test.php');
		$this->addFile('campeonato_test.php');
		$this->addFile('jogo_test.php');
		$this->addFile('aposta_test.php');
		$this->addFile('admin_test.php');
	}
}