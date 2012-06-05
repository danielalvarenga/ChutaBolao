<?php
use Doctrine\Common\Collections\ArrayCollection;

/** @Entity */
Class Rodada{
	
	/** @Id @Column(type="integer", name="id") */
	private $numRodada;
	
	/**
	 * @Id @ManyToOne(targetEntity="Campeonato", inversedBy="rodadas")
	 */
	private $campeonato;
	
	/**
	 * @OneToMany(targetEntity="Jogo", mappedBy="rodada", cascade={"persist"})
	 * @var Jogo[]
	 */
	protected $jogosRodada;
	
	function __construct($numRodada, $campeonato){
		$this->setNumRodada($numRodada);
		$this->setCampeonato($campeonato);
		$this->jogosRodada = new ArrayCollection();
	}
	
	function getNumRodada(){
		return $this->numRodada;
	}
	
	function setNumRodada($numero){
		$this->numRodada = $numero;
	}
	
	function getCampeonato(){
		return $this->campeonato;
	}
	
	function setCampeonato($campeonato){
		$this->campeonato = $campeonato;
	}
	
	function getJogosRodada(){
		return $this->jogosRodada;
	}
	
	function adicionaJogoRodada($jogo){
		$this->jogosRodada[] = $jogo;
	}
}