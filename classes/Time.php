<?php

use Doctrine\Common\Collections\ArrayCollection;


/** @Entity @Table(name="time")*/
class Time{
	
	/** @Id @Column(type="integer", name="id") @GeneratedValue */
	private $codTime;

	/** @Column(type="string") */
	private $nomeTime;
	
	/** @Column(type="string") */
	private $escudo;
	
	/**
	 * @OneToMany(targetEntity="RendimentoTime", mappedBy="time", cascade={"persist"})
	 * @var RendimentoTime[]
	 */
	protected $rendimentosCampeonatos;

	function __construct($nomeTime, $escudo){
		$this->setNomeTime($nomeTime);
		$this->setEscudo($escudo);
		$this->rendimentosCampeonatos = new ArrayCollection();
	}

	function getCodTime(){
		return $this->codTime;
	}

	function setNomeTime($nomeTime){
		$this->nomeTime =
				str_replace(' De ', ' de ',
				str_replace(' Do ', ' do ',
				str_replace(' Da ', ' da ',
				ucwords(strtolower(trim($nomeTime))))));
	}

	function getNomeTime(){
		return $this->nomeTime;
	}
	
	function setEscudo($urlEscudo){
		$this->escudo = $urlEscudo;
	}
	
	function getEscudo(){
		return $this->escudo;
	}
	
	function getRendimentosCampeonatos(){
		return $this->rendimentosCampeonatos;
	}
	
	function adicionaRendimentosCampeonatos($rendimentoTime){
		$this->rendimentosCampeonatos[] = $rendimentoTime;
	}

}
?>