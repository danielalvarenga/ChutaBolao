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
	private $jogo;
	
	/**
	* @Id @ManyToOne(targetEntity="Usuario", inversedBy="apostasUsuario")
	*/
	private $usuario;
	
	/**
	* @Id @ManyToOne(targetEntity="Campeonato", inversedBy="apostasCampeonato")
	*/
	private $campeonato;

	function __construct($idUsuario,$codCampeonato,$codJogo){
		if($idUsuario===null){
			throw new Exception("ERRO 1 NAO FOI POSSIVEL REALIZAR SUA APOSTA ");
		}
		
		elseif ($codCampeonato===null){
			throw new Exception("ERRO 2 NAO FOI POSSIVEL REALIZAR SUA APOSTA ");
		}
		
		elseif ($codJogo===null){
			throw new Exception("ERRO 3 NAO FOI POSSIVEL REALIZAR SUA APOSTA ");
		}
		
		else{
		$this->usuario=$idUsuario;
		$this->campeonato=$codCampeonato;
		$this->jogo=$codJogo;
	}
	}
	
	function getApostaGolsTime1() {
		return $this->apostaGolsTime1;
	}
	
	function getApostaGolsTime2() {
		return $this->apostaGolsTime2;
	}

	function setApostaGolsTime1($apostaGolsTime1){
		if ($apostaGolsTime1<0){throw new Exception("ERRO NUMERO DE GOLS NEGATIVO");
		}
		elseif ($apostaGolsTime1===null){throw new Exception("E OBRIGATORIO PREENCHER OS DOIS CAMPOS ");
		}
		else{
		$this->apostaGolsTime1=$apostaGolsTime1;
	}
	}
	 
	function setApostaGolsTime2($apostaGolsTime2){
		if ($apostaGolsTime2<0){
			throw new Exception("ERRO NUMERO DE GOLS NEGATIVO");
		}
		elseif ($apostaGolsTime2===null){
			throw new Exception("E OBRIGATORIO PREENCHER OS DOIS CAMPOS ");
		}
		else{
		
		$this->apostaGolsTime2=$apostaGolsTime2;
	}
	}
	function getUsuario(){
		return $this->usuario;
	}
	
	function getCodCampeonato(){
		return $this->codCampeonato;
	}
	
	function getcodRodada(){
		return $this->codRodada;
	}
	
	function getCodJogo(){
		return $this->codJogo;
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
		else {
			$this->pontosAposta=0;
		}
	}

	function getPontosAposta(){
		return $this->pontosAposta;
	}
}
?>