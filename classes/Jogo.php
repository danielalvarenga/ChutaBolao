
<?php

class Jogo {
	
	private $codJogo;
	private $dataJogo;
	private $rodada;
	private $codTime1;
	private $codTime2;
	private $golsTime1;
	private $golsTime2;
	private $dataInicioapostas;
	private $dataFimapostas;
	
	function __construct($codJogo,$dataJogo,$rodada,$codTime1,$codTime2,$dataInicioapostas,$dataFimapostas){
		$this->codJogo=$codJogo;
		$this->dataJogo=$dataJogo;
		$this->rodada=$rodada;
		$this->codTime1=$codTime1;
		$this->codTime2=$codTime2;
		$this->dataInicioapostas=$dataInicioapostas;
		$this->dataFimapostas=$dataFimapostas;
	}
	
	function setGolstime1($num_gols){
		if (is_int($num_gols)&&($num_gols>=0)){
			$this->golsTime1=$num_gols;
			return true;
		}
		else {
			return false;
		}
	}
	
	function setGolstime2($num_gols){
		if (is_int($num_gols)&&($num_gols>=0)){
			$this->golsTime2=$num_gols;
			return true;
		}
		else {
			return false;
		}
		
	}
	
	function retornaCodcampeonato(){
		return $this->codCampeonato;
	}
	
	function verificaPeriodoapostas($datadaAposta){
		if (($datadaAposta>=$this->dataInicioapostas)&&($datadaAposta<=$this->dataFimapostas)) {
			return true;
		}
		else {
			return false;
		}
	}
	
	function getCodjogo(){
		return $this->codJogo;
	}
	
	function getDatajogo(){
		return $this->dataJogo;
	}
	
	function getGolstime1(){
		return $this->golsTime1;
	}
	
	function getGolstime2(){
		return $this->golsTime2;
	}
	
	function getCodtime1(){
		return $this->codTime1;
	}
	
	function getCodtime2(){
		return $this->codTime2;
	}
	
	function getRodada(){
		return $this->rodada;
	}
	
}