<?php
use Doctrine\Common\Collections\ArrayCollection;

/** @Entity @Table(name="rodada")*/
Class Rodada{
	
	/** @Id @Column(type="integer", name="id") */
	private $numRodada;
	
	/** @Column(type="string")*/
	private $status;
	
	/**
	 * @Id @ManyToOne(targetEntity="Campeonato", inversedBy="rodadas", cascade={"persist"})
	 */
	protected $campeonato;
	
	/**
	 * @OneToMany(targetEntity="Jogo", mappedBy="rodada", cascade={"persist"})
	 * @var Jogo[]
	 */
	protected $jogosRodada;
	
	/**
	 * @OneToMany(targetEntity="PontuacaoRodada", mappedBy="rodada", cascade={"persist"})
	 * @var PontuacaoRodada[]
	 */
	protected $pontuacaoRodadas;
	
	function __construct($numRodada, $campeonato){
		$this->status = "ativa";
		$this->setNumRodada($numRodada);
		$this->setCampeonato($campeonato);
		$this->jogosRodada = new ArrayCollection();
		$this->pontuacaoRodadas = new ArrayCollection();
	}
	
	function getNumRodada(){
		return $this->numRodada;
	}
	
	function setNumRodada($numero){
		$this->numRodada = $numero;
	}
	
	function finalizaStatus(){
		$this->status = "finalizada";
	}
	
	function ativaStatus(){
		$this->status = "ativa";
	}
	
	function getStatus(){
		return $this->status;
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
	
	function getPontuacaoRodadas(){
		return $this->pontuacaoRodadas;
	}
	
	function adicionaPontuacaoRodada($pontuacaoRodada){
		$this->pontuacaoRodadas[] = $pontuacaoRodada;
	}
	
	function adicionaJogoRodada($jogo){
		$this->jogosRodada[] = $jogo;
	}
}