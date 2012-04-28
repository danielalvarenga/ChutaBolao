<?php

use Doctrine\Common\Collections\ArrayCollection;

/** @Entity */
class time{
	/** @Id @Column(type="integer") @GeneratedValue */
	private $codTime;
	
	/** @Column(type="string") */
	private $nomeTime;
	
	function __construct($nomeTime){
		$this->nomeTime = strtoupper($nomeTime);
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