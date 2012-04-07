<?php

abstract class UsuarioAbstrato {

	/**	private $idUsuario; */ // Identificador do usu�rio do Facebook - Direto do Facebook
	/** private $tokenUsuario; */ // Permiss�o de acesso do usu�rio - Direto do Facebook
	/** private $primeiroNomeUsuario; */ // Direto do Facebook
	/** private $segundoNomeUsuario; */ // Direto do Facebook
	/** private $emailUsuario; */ // Direto do Facebook
	/** private $pontosGeral; */ // Total de pontos acumulados desde o cadastro do usu�rio
	/** protected $apostas = null; */ // Array com todas as apostas do usu�rio
	/** protected $premiacoes = null; */ // Array com todos os pr�mios do usu�rio. Para cada campeonato o usu�rio tem um objeto de PremiosCampeonato
	
	
	function __construct($idUsuario, $tokenUsuario, $primeiroNomeUsuario, $segundoNomeUsuario, $emailUsuario);
	/* Recebe como par�metros idUsuario, tokenUsuario, primeiroNomeUsuario, segundoNomeUsuario e emailUsuario,
	 * inicia pontosGeral com 0 e
	 * inicia apostas e premiacoes com null */
	function getIdUsuario();
	function setIdUsuario();	
	function getTokenUsuario();
	function setTokenUsuario();
	function getPrimeiroNomeUsuario();
	function setPrimeiroNomeUsuario();
	function getSegundoNomeUsuario();
	function setSegundoNomeUsuario();
	function getEmailUsuario();
	function setEmailUsuario();
	function getPontosGeralUsuario();
	function ganhaPontosGeral($pontos);
	/* Recebe a quantidade de pontos ganhos por par�metro e soma com pontosGeral */
	function adicionaAposta($aposta);
	/* Recebe o objeto Aposta e adiciona ao array apostas[] */
	function buscaAposta();
	/* Retorna o objeto Aposta ap�s buscar pela iDUsuario e codJogo dentro do array apostas[] */
	function atualizaAposta($aposta);
	/* Recebe o objeto Aposta e atualiza no array apostas[] */
	function adicionaPremiacoes($premiosCampeonato);
	/* Recebe o objeto PremiosCampeonato e adiciona ao array premiacoes[] */
	function buscaPremiacoes();
	/* Retorna o objeto PremiosCampeonato ap�s buscar pela iDUsuario e codCampeonato dentro do array premiacoes[] */
	function atualizaPremiacoes($premiosCampeonato);
	/* Recebe o objeto PremiosCampeonato e atualiza no array premiacoes[] */

}