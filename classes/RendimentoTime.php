<?php

/** @Entity @Table(name="rendimentotime")*/
class RendimentoTime{
	
	/** @Id @Column(type="string") */
	protected $id;
	
	/**
	 * @ManyToOne(targetEntity="Campeonato", inversedBy="rendimentosTimes")
	 */
	protected $campeonato;
	
	/**
	 * @ManyToOne(targetEntity="Time", inversedBy="rendimentosCampeonatos")
	 */
	protected $time;
	
	/** @Column(type="integer", nullable=true) */
	private $classificacao;
	/** @Column(type="integer") */
	private $vitorias;
	/** @Column(type="integer") */
	private $derrotas;
	/** @Column(type="integer") */
	private $empates;
	/** @Column(type="integer") */
	private $golsPro;
	/** @Column(type="integer") */
	private $golsContra;
	/** @Column(type="integer") */
	private $pontos;
	/** @Column(type="integer") */
	private $saldoGols;
	
	function __construct($campeonato, $time){
		$this->id = $campeonato->getCodCampeonato()."x".$time->getCodTime();
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
	function getId(){
		return $this->id;
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
	function getQuantidadeJogos(){
		return $this->vitorias+$this->empates+$this->derrotas;
	}
	function getGolsPro(){
		return $this->golsPro;
	}
	function getGolsContra(){
		return $this->golsContra;
	}
	function getClassificacao(){
		return $this->classificacao ;
	}
	function getPontos(){
		return $this->pontos;
	}
	//retorna o saldo de gols do time no campeonato (saldo de gols = gols pro - gols contra)
	function getSaldoGols(){
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
	//para cada empate obtido no campeonato o numero de empates � incrementado
	function incrementaEmpates(){
		$this->empates++;
	}
	//para cada vitoria obtida no campeonato o numero de vitorias � incrementado
	function incrementaVitorias(){
		$this->vitorias++;
	}
	//para cada derrota obtida no campeonato o numero de derrotas � incrementado
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
	function calculaSaldoGols(){
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
		$this->calculaSaldoGols();
	}
	
	function subtraiGolsPro($golsPro){
		$this->golsPro-=$golsPro;
	}
	function subtraiGolsContra($golsContra){
		$this->golsContra -= $golsContra;
	}
	function decrementaVitorias(){
		$this->vitorias--;
	}
	function decrementaDerrotas(){
		$this->derrotas--;
	}
	function decrementaEmpates(){
		$this->empates--;
	}
	
	function desfazCalculaRendimentoTime($golsPro, $golsContra){
		$this->subtraiGolsPro($golsPro);
		$this->subtraiGolsContra($golsContra);
		if($golsPro > $golsContra){
			$this->decrementaVitorias();
		} elseif ($golsPro < $golsContra){
			$this->decrementaDerrotas();
		} else {
			$this->decrementaEmpates();
		}
		$this->calculaPontos();
		$this->calculaSaldoGols();
	}
	
}