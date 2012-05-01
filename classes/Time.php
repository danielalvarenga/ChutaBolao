<?php

use Doctrine\Common\Collections\ArrayCollection;

/** @Entity */
class time{
	/** @Id @Column(type="integer") @GeneratedValue */
	private $codTime;

	/** @Column(type="string") */
	private $nomeTime;

	function __construct($nomeTime){
		if ($nomeTime === null){
			throw new Exception("Insira um nome para o time!");
		}
		else{
		$this->nomeTime = strtoupper($nomeTime);
		}
	}

	function getCodTime(){
		return $codTime;
	}

	function setNomeTime($nomeTime){
		$this->nomeTime = strtoupper($nomeTime);
	}

	function getNomeTime(){
		return $this->nomeTime;
	}

}
?>