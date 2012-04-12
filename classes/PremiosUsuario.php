<?php

class PremiosCampeonato{
	
	private $idUsuario;
	private $codCampeonato;
	private $codTimeFavorito;
	private $acertosPlacar;
	private $acertosTimeGanhador;
	private $acertosPlacarInvertido;
	private $pontosCampeonato; 
	private $medalhasOuro;
	private $medalhasPrata;
	private $medalhasBronze;
	private $chuteirasOuro;
	private $chuteirasPrata;
	private $chuteirasBronze;
	private $trofeu;
	
	function __construct($idUsuario, $codCampeonato, $codTimeFavorito = 0){
		$this->idUsuario = $idUsuario;
		$this->codCampeonato = $codCampeonato;
		$this->codTimeFavorito = $codTimeFavorito;
		$this->acertosPlacar = 0;
		$this->acertosTimeGanhador = 0;
		$this->acertosPlacarInvertido = 0;
		$this->pontosCampeonato = 0;
		$this->medalhasOuro = 0;
		$this->medalhasPrata = 0;
		$this->medalhasBronze = 0;
		$this->chuteirasOuro = 0;
		$this->chuteirasPrata = 0;
		$this->chuteirasBronze = 0;
		$this->trofeu = false;
	}
	
	function getIdUsuario(){
		return $this->idUsuario;
	}
	function getCodCampeonato(){
		return $this->codCampeonato;
	}
	function getCodTimeFavorito(){
		return $this->codTimeFavorito;
	}
	function setCodTimeFavorito($codTimeFavorito){
		$this->codTimeFavorito = $codTimeFavorito;
	}
	function getAcertosPlacar(){
		return $this->acertosPlacar;
	}
	function getAcertosTimeGanhador(){
		return $this->acertosTimeGanhador;
	}
	function getAcertosPlacarInvertido(){
		return $this->acertosPlacarInvertido;
	}
	function getPontosCampeonato(){
		return $this->pontosCampeonato;;
	}
	function getMedalhasOuro(){
		return $this->medalhasOuro;
	}
	function getMedalhasPrata(){
		return $this->medalhasPrata;
	}
	function getMedalhasBronze(){
		return $this->medalhasBronze;
	}
	function getChuteirasOuro(){
		return $this->chuteirasOuro;
	}
	function getChuteirasPrata(){
		return $this->chuteirasPrata;
	}
	function getChuteirasBronze(){
		return $this->chuteirasBronze;
	}
	function getTrofeu(){
		return $this->trofeu;
	}
	function ganhaTrofeu(){
		$this->trofeu = true;
	}
	function acertaPlacar(){
		$this->acertosPlacar++;
		ganhaPontosCampeonato(10);
	}
	function ganhaPontosCampeonato($pontos){
		$this->ganhaPontosCampeonato = $this->ganhaPontosCampeonato + $pontos;
	}

}