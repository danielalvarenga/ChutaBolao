<?php
/** @Entity @Table(name="premiosusuario")*/
class PremiosUsuario{
	
	/** @Column(type="integer") */
	private $codTimeFavorito; // Time para o qual o usuário torce no campeonato
	
	/** @Column(type="integer") */
	private $acertosPlacar; // Quantidade de vezes que acertou o placar exato
	
	/** @Column(type="integer") */
	private $acertosTimeGanhador; // Quantidade de vezes que acertou o ganhador, mesmo errando o placar
	
	/** @Column(type="integer") */
	private $acertosPlacarInvertido; // Quantidade de vezes que acertou o placar invertido
	
	/** @Column(type="integer") */
	private $pontosCampeonato; // Quantidade de pontos acumulados no campeonato
	
	/** @Column(type="integer") */
	private $medalhasOuro; // Quantidade de medalhas de ouro acumuladas no campeonato
	
	/** @Column(type="integer") */
	private $medalhasPrata; // Quantidade de medalhas de prata acumuladas no campeonato
	
	/** @Column(type="integer") */
	private $medalhasBronze; // Quantidade de medalhas de bronze acumuladas no campeonato
	
	/** @Column(type="integer") */
	private $chuteirasOuro; // Quantidade de chuteiras de ouro acumuladas no campeonato
	
	/** @Column(type="integer") */
	private $chuteirasPrata; // Quantidade de chuteiras de prata acumuladas no campeonato
	
	/** @Column(type="integer") */
	private $chuteirasBronze; // Quantidade de chuteiras de bronze acumuladas no campeonato
	
	/** @Column(type="boolean") */
	private $trofeu; // "true" se o usuário ganhou troféu do campeonato. "false" por default.
	
	/**
	* @Id @ManyToOne(targetEntity="Usuario", inversedBy="premiacoes")
	*/
	private $usuario; // Objeto da Classe Usuario a quem pertence os prêmios
	
	/**
	 * @Id @ManyToOne(targetEntity="Campeonato", inversedBy="premiacoesCampeonato")
	 */
	private $campeonato; // Objeto da Classe Campeonato que referência em qual Campeonato foram ganhos os prêmios
	
	/* Recebe como parâmetros a id do usuário, o código de campeonato e código do time favorito.
	* Se não for escolhido nenhum Time Favorito o valor será "0" por default.
	* Inicia trofeu com false e inicia as demais variáveis com 0. */
	
	function __construct($usuario, $campeonato, $codTimeFavorito = NULL){
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
		$this->usuario = $usuario;
		$this->campeonato = $campeonato;
	}
	
	function getUsuario(){
		return $this->usuario;
	}
	function getCampeonato(){
		return $this->campeonato;
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
	/* Incrementa em +1 o atributo acertosPlacar */
	function acertaPlacar(){
		$this->acertosPlacar++;
	}
	/* Incrementa em +1 o atributo acertosTimeGanhador */
	function acertaTimeGanhador(){
		$this->acertosTimeGanhador++;
	}
	/* Incrementa em +1 o atributo acertosPlacarInvertido */
	function acertaPlacarInvertido(){
		$this->acertosPlacarInvertido++;
	}
	/* Recebe a quantidade de pontos ganhos por parâmetro e soma com pontosCampeonato */
	function ganhaPontosCampeonato($pontos){
		$this->pontosCampeonato = $this->pontosCampeonato + $pontos;
	}
	/* Incrementa em +1 o atributo medalhasOuro */
	function ganhaMedalhaOuro(){
		$this->medalhasOuro++;
	}
	/* Incrementa em +1 o atributo medalhasPrata */
	function ganhaMedalhaPrata(){
		$this->medalhasPrata++;
	}
	/* Incrementa em +1 o atributo medalhasBronze */
	function ganhaMedalhaBronze(){
		$this->medalhasBronze++;
	}
	/* Incrementa em +1 o atributo chuteirasOuro */
	function ganhaChuteiraOuro(){
		$this->chuteirasOuro++;
	}
	/* Incrementa em +1 o atributo chuteirasPrata */
	function ganhaChuteiraPrata(){
		$this->chuteirasPrata++;
	}
	/* Incrementa em +1 o atributo chuteirasBronze */
	function ganhaChuteiraBronze(){
		$this->chuteirasBronze++;
	}
	/* Atribue "true" ao atributo trofeu */
	function ganhaTrofeu(){
		$this->trofeu = true;
	}
	
	function calculaPontos($pontosAposta){
		switch($pontosAposta){
			case 10 : {
				$this->acertosPlacar++;
				break;
			}
			case 5 : {
				$this->acertosTimeGanhador++;
				break;
			}
			case 5 : {
				$this->acertosPlacarInvertido++;
				break;
			}
		}
		$this->pontosCampeonato += $pontosAposta;
	}
}