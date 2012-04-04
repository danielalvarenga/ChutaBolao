<?php

abstract class PremiosDoCampeonatoAbstrata{
	
	/**	private $idUsuario; */ // identifica o usuário
	/**	private $codCampeonato; */ // Identifica qual Campeonato
	/**	private $codTimeFavorito; */ // Time para o qual o usuário torce no campeonato
	/**	private $codRodada; */ // 
	/**	private $acertosPlacar; */ // 
	/**	private $acertosTimeGanhador; */ // 
	/**	private $acertosPlacarInvertido; */ // 
	/**	private $pontosCampeonato; */ // 
	/**	private $pontosRodada; */ // 
	/**	private $medalhasOuro; */ // 
	/**	private $medalhasPrata; */ // 
	/**	private $medalhasBronze; */ // 
	/**	private $chuteirasOuro; */ // 
	/**	private $chuteirasPrata; */ // 
	/**	private $chuteirasBronze; */ // 
	/**	private $trofeus; */ // 
	
	function _construct($idUsuario, $codCampeonato);
	function getIdUsuario();
	function getCodCampeonato();
	function getCodTimeFavorito();
	function getCodRodada();
	function getAcertosPlacar();
	function getAcertosTimeGanhador();
	function getAcertosPlacarInvertido();
	function getPontosCampeonato();
	function getPontosRodada();
	function getMedalhasOuro();
	function getMedalhasPrata();
	function getMedalhasBronze();
	function getChuteirasOuro();
	function getChuteirasPrata();
	function getChuteirasBronze();
	function getTrofeus();
	function setCodTimeFavorito($codTimeFavorito);
	function setCodRodada($codRodada);
	function setAcertosPlacar($acertosPlacar);
	function setAcertosTimeGanhador($acertosTimeGanhador);
	function setAcertosPlacarInvertido($acertosPlacarInvertido);
	function setPontosCampeonato($pontosCampeonato);
	function setPontosRodada($pontosRodada);
	function setMedalhasOuro($medalhasOuro);
	function setMedalhasPrata($medalhasPrata);
	function setMedalhasBronze($medalhasBronze);
	function setChuteirasOuro($chuteirasOuro);
	function setChuteirasPrata($chuteirasPrata);
	function setChuteirasBronze($chuteirasBronze);
	function setTrofeus($trofeus);
	
	


	

}