<?php

abstract class PremiosCampeonatoAbstrata{
	
	/**	private $idUsuario; */ // identifica o usu�rio
	/**	private $codCampeonato; */ // Identifica qual Campeonato
	/**	private $codTimeFavorito; */ // Time para o qual o usu�rio torce no campeonato
	/**	private $acertosPlacar; */ // Quantidade de vezes que acertou o placar exato
	/**	private $acertosTimeGanhador; */ // Quantidade de vezes que acertou o ganhador, mesmo errando o placar
	/**	private $acertosPlacarInvertido; */ // Quantidade de vezes que acertou o placar invertido
	/**	private $pontosCampeonato; */ // Quantidade de pontos acumulados no campeonato
	/**	private $medalhasOuro; */ // Quantidade de medalhas de ouro acumuladas no campeonato
	/**	private $medalhasPrata; */ // Quantidade de medalhas de prata acumuladas no campeonato
	/**	private $medalhasBronze; */ // Quantidade de medalhas de bronze acumuladas no campeonato
	/**	private $chuteirasOuro; */ // Quantidade de chuteiras de ouro acumuladas no campeonato
	/**	private $chuteirasPrata; */ // Quantidade de chuteiras de prata acumuladas no campeonato
	/**	private $chuteirasBronze; */ // Quantidade de chuteiras de bronze acumuladas no campeonato
	/**	private $trofeu; */ // Verdadeiro se usu�rio ganhou trof�u do campeonato. Falso por default.
	
	function _construct($idUsuario, $codCampeonato, $codTimeFavorito = 0);
	/* Recebe como par�metros a id do usu�rio, o c�digo de campeonato e c�digo do time favorito.
	 * Se n�o for escolhido nenhum Time Favorito o valor ser� "0" por default.
	 * Inicia trofeu com false e
	 * Inicia demais vari�veis com 0. */
	function getIdUsuario();
	function getCodCampeonato();
	function getCodTimeFavorito();
	function setCodTimeFavorito($codTimeFavorito);
	function getAcertosPlacar();
	function getAcertosTimeGanhador();
	function getAcertosPlacarInvertido();
	function getPontosCampeonato();
	function getMedalhasOuro();
	function getMedalhasPrata();
	function getMedalhasBronze();
	function getChuteirasOuro();
	function getChuteirasPrata();
	function getChuteirasBronze();
	function AcertaPlacar();
	/* Incrementa em +1 o atributo acertosPlacar e chama a fun��o ganhaPontos passando o valor "10" como par�metro*/
	function AcertaTimeGanhador();
	/* Incrementa em +1 o atributo acertosTimeGanhador e chama a fun��o ganhaPontos passando o valor "5" como par�metro*/
	function AcertaPlacarInvertido();
	/* Incrementa em +1 o atributo acertosPlacarInvertido e chama a fun��o ganhaPontos passando o valor "2" como par�metro*/
	function ganhaPontosCampeonato($pontos);
	/* Recebe a quantidade de pontos ganhos por par�metro e soma com pontosCampeonato */
	function ganhaMedalhasOuro();
	/* Incrementa em +1 o atributo medalhasOuro */
	function ganhaMedalhasPrata();
	/* Incrementa em +1 o atributo medalhasPrata */
	function ganhaMedalhasBronze();
	/* Incrementa em +1 o atributo medalhasBronze */
	function ganhaChuteirasOuro();
	/* Incrementa em +1 o atributo chuteirasOuro */
	function ganhaChuteirasPrata();
	/* Incrementa em +1 o atributo chuteirasPrata */
	function ganhaChuteirasBronze();
	/* Incrementa em +1 o atributo chuteirasBronze */
	function ganhaTrofeu();
	/* Atribue "true" ao atributo trofeu */
}