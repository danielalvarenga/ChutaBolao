<?php

abstract class UsuarioAbstrato {

	/**	private $idUsuario; */ // Identificador do usuário do Facebook - Direto do Facebook
	/** private $tokenUsuario; */ // Permissão de acesso do usuário - Direto do Facebook
	/** private $primeiroNomeUsuario; */ // Direto do Facebook
	/** private $segundoNomeUsuario; */ // Direto do Facebook
	/** private $emailUsuario; */ // Direto do Facebook
	/** private $pontosGeral; */ // Total de pontos acumulados desde o cadastro do usuário
	/** protected $apostas = null; */ // Array com todas as apostas do usuário
	/** protected $premiosCampeonato = null; */ // Array com todos os prêmios do usuário. Para cada campeonato o usuário tem um objeto de PremiosDoCampeonato
	
	
	function __construct();
	/* Recebe como parâmetros idUsuario, tokenUsuario, primeiroNomeUsuario, segundoNomeUsuario e
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
	/* Retorna o objeto PremiosDoCampeonato após buscar pela iDUsuario e codCampeonato dentro do array premiosCampeonato */
	function atualizaPremiosCampeonato();
	/* Recebe o objeto PremiosDoCampeonato e atualiza no array premiosCampeonato[] */
	function atualizaPontosGeral();
	/* Recebe os pontos que o usuário ganhou e incrementa em pontosGeralUsuario */

}