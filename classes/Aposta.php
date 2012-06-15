<?php

/** @Entity @Table(name="aposta")*/
class Aposta{
	
	/** @Column(type="integer") */
	private $apostaGolsTime1;
	
	/** @Column(type="integer") */
	private $apostaGolsTime2;
	
	/** @Column(type="integer") */
	private $pontosAposta;
	
	/**
	* @Id @ManyToOne(targetEntity="Jogo", inversedBy="apostasJogo")
	*/
	protected $jogo;
	
	/**
	* @Id @ManyToOne(targetEntity="Usuario", inversedBy="apostasUsuario")
	*/
	protected $usuario;
	
	/**
	* @Id @ManyToOne(targetEntity="Campeonato", inversedBy="apostasCampeonato")
	*/
	protected $campeonato;

	function __construct($usuario,$campeonato,$jogo){
		$this->apostaGolsTime1 = NULL;
		$this->apostaGolsTime2 = NULL;
		$this->pontosAposta = 0;
		$this->usuario=$usuario;
		$this->campeonato=$campeonato;
		$this->jogo=$jogo;
	}
	
	function getApostaGolsTime1() {
		return $this->apostaGolsTime1;
	}
	
	function getApostaGolsTime2() {
		return $this->apostaGolsTime2;
	}

	function setApostaGolsTime1($apostaGolsTime1){
		$this->apostaGolsTime1=$apostaGolsTime1;
	}
	 
	function setApostaGolsTime2($apostaGolsTime2){
		$this->apostaGolsTime2=$apostaGolsTime2;
	}
	function getUsuario(){
		return $this->usuario;
	}
	
	function getCampeonato(){
		return $this->campeonato;
	}
	
	function getJogo(){
		return $this->jogo;
	}
	function setUsuario($usuario){
		$this->usuario = $usuario;
	}
	
	function setCampeonato($campeonato){
		$this->campeonato = $campeonato;
	}
	
	function setJogo($jogo){
		$this->jogo = $jogo;
	}
	
	function calculaPontosAposta($golsTime1,$golsTime2){

		if (($this->apostaGolsTime1 == $golsTime1) && ($this->apostaGolsTime2 == $golsTime2)){
			$this->pontosAposta=10;
		}
		
		elseif (($this->apostaGolsTime2 == $golsTime1) && ($this->apostaGolsTime1 == $golsTime2)){
			$this->pontosAposta=2;
		}
		
		elseif (($this->apostaGolsTime1 > $this->apostaGolsTime2) && ($golsTime1 > $golsTime2)){
			$this->pontosAposta=5;
		}

		elseif (($this->apostaGolsTime2 > $this->apostaGolsTime1) && ($golsTime2 > $golsTime1)){
			$this->pontosAposta=5;
		}
		elseif (($this->apostaGolsTime2 == $this->apostaGolsTime1) && ($golsTime2 == $golsTime1)){
			$this->pontosAposta=5;
		}
	}

	function getPontosAposta(){
		return $this->pontosAposta;
	}
}
?>