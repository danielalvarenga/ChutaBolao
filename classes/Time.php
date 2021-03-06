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
	 * @OneToMany(targetEntity="RendimentoTime", mappedBy="time", cascade={"persist", "remove"})
	 * @var RendimentoTime[]
	 */
	protected $rendimentosCampeonatos;
	
	/**
	 * @ManyToOne(targetEntity="Pais", inversedBy="times")
	 */
	protected $pais;
	
	/**
	 * @OneToMany(targetEntity="Usuario", mappedBy="time", cascade={"persist"})
	 * @var Usuario[]
	 */
	protected $torcedores;

	function __construct($nomeTime, $escudo, $pais){
		$this->setNomeTime($nomeTime);
		$this->setEscudo($escudo);
		$this->pais = $pais;
		$this->rendimentosCampeonatos = new ArrayCollection();
		$this->torcedores = new ArrayCollection();
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
	
	function getPais(){
		return $this->pais;
	}
	
	function getRendimentosCampeonatos(){
		return $this->rendimentosCampeonatos;
	}
	
	function adicionaRendimentosCampeonatos($rendimentoTime){
		$this->rendimentosCampeonatos[] = $rendimentoTime;
	}
	
	function getTorcedores(){
		return $this->torcedores;
	}
	
	function adicionaTorcedor($usuario){
		$this->torcedores[] = $usuario;
	}

}
?>