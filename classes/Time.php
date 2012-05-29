<?php

use Doctrine\Common\Collections\ArrayCollection;


/** @Entity */
class time{
	
	/** @Id @Column(type="integer", name="id") @GeneratedValue */
	private $codTime;

	/** @Column(type="string") */
	private $nomeTime;
	
	/**
	 * @OneToMany(targetEntity="RendimentoTime", mappedBy="time", cascade={"persist"})
	 * @var RendimentoTime[]
	 */
	protected $rendimentosCampeonatos;

	function __construct($nomeTime){
		$this->nomeTime = strtoupper($nomeTime);
		$this->rendimentosCampeonatos = new ArrayCollection();
	}

	function getCodTime(){
		return $this->codTime;
	}

	function setNomeTime($nomeTime){
		$this->nomeTime = strtoupper($nomeTime);
	}

	function getNomeTime(){
		return $this->nomeTime;
	}
	
	function getRendimentosCampeonatos(){
		return $this->rendimentosCampeonatos;
	}
	
	function adicionaRendimentosCampeonatos($rendimentoTime){
		$this->rendimentosCampeonatos[] = $rendimentoTime;
	}

}
?>