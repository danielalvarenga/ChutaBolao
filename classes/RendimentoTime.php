<?php

/** @Entity */
class RendimentoTime{
	
	/**
	 * @Id @ManyToOne(targetEntity="Campeonato", inversedBy="rendimentosTimes")
	 */
	private $campeonato;
	
	/**
	 * @Id @ManyToOne(targetEntity="Time", inversedBy="rendimentosCampeonatos")
	 */
	private $time;
	
	/** @Column(type="string") */
	private $classificacao;
	private $vitorias;
	private $derrotas;
	private $empates;
	private $golsPro;
	private $golsContra;
	private $pontos;
	private $saldoGols;
	
	function __construct($campeonato, $time){
		$this->classificacao = NULL;
		$this->vitorias = 0;
		$this->derrotas = 0;
		$this->empates = 0;
		$this->golsPro = 0;
		$this->golsContra = 0;
		$this->pontos = 0;
		$this->saldoGols = 0;
		$this->campeonato = $campeonato;
		$this->time = $time;
	}
	function getCampeonato(){
		return $this->campeonato;
	}
	function getTime(){
		return $this->time;
	}
	function getVitorias(){
		return $this->vitorias;
	}
	function getDerrotas(){
		return $this->derrotas;
	}
	function getEmpates(){
		return $this->empates;
	}
	function getGolsPro(){
		return $this->golsPro;
	}
	function getGolsContra(){
		return $this->golsContra;
	}
	function getClassificacao($classificacao){
		$this->classificacao = $classificacao;
	}
	function getPontos(){
		return $this->pontos;
	}
	//retorna o saldo de gols do time no campeonato (saldo de gols = gols pro - gols contra)
	function getSaldoDeGols(){
		return $this->saldoGols;
	}
	function setCampeonato($campeonato){
		$this->campeonato = $campeonato;;
	}
	function setTime($time){
		$this->time = $time;
	}
	function setClassificacao($classificacao){
		$this->classificacao = $classificacao;
	}
	//para cada empate obtido no campeonato o numero de empates é incrementado
	function incrementaEmpates(){
		$this->empates++;
	}
	//para cada vitoria obtida no campeonato o numero de vitorias é incrementado
	function incrementaVitorias(){
		$this->vitorias++;
	}
	//para cada derrota obtida no campeonato o numero de derrotas é incrementado
	function incrementaDerrotas(){
		$this->derrotas++;
	}
	//recebe o numero de gols que o time fez na partida e soma com os feitos nas outras partidas
	function somaGolsPro($golsPro){
		$this->golsPro += $golsPro;
	}
	//recebe o numero de gols que o time sofreu na partida e soma com os sofridos nas outras partidas
	function somaGolsContra($golsContra){
		$this->golsContra += $golsContra;
	}
	//calcula o numero de pontos feito pelo time no campeonato
	function calculaPontos(){
		$this->pontos = $this->vitorias * 3 + $this->empates;
	}
	//retorna o saldo de gols do time no campeonato (saldo de gols = gols pro - gols contra)
	function calculaSaldoDeGols(){
		$this->saldoGols = $this->golsPro - $this->golsContra;
	}
	function calculaRendimentoTime($golsPro, $golsContra){
		$this->somaGolsPro($golsPro);
		$this->somaGolsContra($golsContra);
		if($golsPro > $golsContra){
			$this->incrementaVitorias();
		} elseif ($golsPro < $golsContra){
			$this->incrementaDerrotas();
		} else {
			$this->incrementaEmpates();
		}
		$this->calculaPontos();
		$this->calculaSaldoDeGols();
	}
}