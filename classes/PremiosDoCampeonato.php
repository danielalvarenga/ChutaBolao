<?php

class PremiosDoCampeonato extends PremiosDoCampeonatoAbstrata{
	
	private $idUsuario;
	private $codCampeonato;
	private $codTimeFavorito;
	private $codRodada;
	private $acertosPlacar;
	private $acertosTimeGanhador;
	private $acertosPlacarInvertido;
	private $pontosCampeonato;
	private $pontosRodada;
	private $medalhasOuro;
	private $medalhasPrata;
	private $medalhasBronze;
	private $chuteirasOuro;
	private $chuteirasPrata;
	private $chuteirasBronze;
	private $trofeus;
	
	function _construct($codCampeonato, $codRodada, $codTimeFavorito = null){
		$this->codCampeonato = $codCampeonato;
		$this->codTimeFavorito = $codTimeFavorito;
		$this->codRodada = $codRodada;
		$this->acertosPlacar = 0;
		$this->acertosTimeGanhador = 0;
		$this->acertosPlacarInvertido = 0;
		$this->pontosCampeonato = 0;
		$this->pontosRodada = 0;
		$this->medalhasOuro = 0;
		$this->medalhasPrata = 0;
		$this->medalhasBronze = 0;
		$this->chuteirasOuro = 0;
		$this->chuteirasPrata = 0;
		$this->chuteirasBronze = 0;
		$this->trofeus = 0;		
	}

	
	

}