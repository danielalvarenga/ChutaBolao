<?php

abstract class UsuarioAbstrato {

	/*
	private $idUsuario; // Identificador do usuário do Facebook - Direto do Facebook
	private $tokenUsuario; // Permissão de acesso do usuário - Direto do Facebook
	private $primeiroNomeUsuario; // Direto do Facebook
	private $segundoNomeUsuario; // Direto do Facebook
	private $emailUsuario; // Direto do Facebook
	private $pontosGeralUsuario; // Total de pontos acumulados desde o cadastro do usuário
	protected $apostas = null; // Array com todas as apostas do usuário
	protected $premios = null; // Array com todos os prêmios do usuário. Para cada campeonato o usuário tem um objeto de PremiosUsuario
	*/
	
	function __construct();
	/* Deve receber idUsuario, tokenUsuario, primeiroNomeUsuario, segundoNomeUsuario e
	 * emailUsuario e inicia pontosGeralUsuario com 0 */
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
	function ganhaPontos();
	/* Recebe os pontos que o usuário ganhou e incrementa em pontosGeralUsuario */
	function adicionaPremios();
	/* Recebe o objeto PremiosUsuario e adiciona ao array premios[] */
	function buscaPremios();
	/*  */
}