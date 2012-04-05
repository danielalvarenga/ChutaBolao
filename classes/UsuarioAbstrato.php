<?php

abstract class UsuarioAbstrato {

	/**	private $idUsuario; */ // Identificador do usu�rio do Facebook - Direto do Facebook
	/** private $tokenUsuario; */ // Permiss�o de acesso do usu�rio - Direto do Facebook
	/** private $primeiroNomeUsuario; */ // Direto do Facebook
	/** private $segundoNomeUsuario; */ // Direto do Facebook
	/** private $emailUsuario; */ // Direto do Facebook
	/** private $pontosGeral; */ // Total de pontos acumulados desde o cadastro do usu�rio
	/** protected $apostas = null; */ // Array com todas as apostas do usu�rio
	/** protected $premiosCampeonato = null; */ // Array com todos os pr�mios do usu�rio. Para cada campeonato o usu�rio tem um objeto de PremiosDoCampeonato
	
	
	function __construct();
	/* Recebe como par�metros idUsuario, tokenUsuario, primeiroNomeUsuario, segundoNomeUsuario e
	 * emailUsuario e inicia pontosGeral com 0 */
	abstract function getIdUsuario();
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
	function ganhaPontos();
	function adicionaPremiosCampeonato();
	/* Recebe o objeto PremiosDoCampeonato e adiciona ao array premiosCampeonato[] */
	function buscaPremiosCampeonato();
	/* Retorna o objeto PremiosDoCampeonato ap�s buscar pela iDUsuario e codCampeonato dentro do array premiosCampeonato */
	function atualizaPremiosCampeonato();
	/* Recebe o objeto PremiosDoCampeonato e atualiza no array premiosCampeonato[] */
	function atualizaPontosGeral();
	/* Recebe os pontos que o usu�rio ganhou e incrementa em pontosGeralUsuario */

}