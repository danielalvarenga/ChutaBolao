<?php
class RendimentoTime{

	private $campeonato;
	private $time;
	private $classificacao;
	private $vitorias;
	private $derrotas;
	private $empates;
	private $golsPro;
	private $golsContra;
	
	function __construct($campeonato, $time){
		$this->campeonato = $campeonato;
		$this->time = $time;
	}
	//para cada vitoria obtida no campeonato o numero de vitorias é incrementado
	function incrementaVitorias(){
		$this->vitorias++;
	}
	
	function getVitorias(){
		return $this->vitorias;
	}
	
	//para cada derrota obtida no campeonato o numero de derrotas é incrementado
	function incrementaDerrotas(){
		$this->derrotas++;
	}

	function getDerrotas(){
		return $this->derrotas;
	}
	//para cada empate obtido no campeonato o numero de empates é incrementado
	function incrementaEmpates(){
		$this->empates++;
	}

	function getEmpates(){
		return $this->empates;
	}
	
	//recebe o numero de gols que o time fez na partida e soma com os feitos nas outras partidas
	function insereGolsPro($gols){
		$this->golsPro += $gols;
	}
	
	//retorna o numero de gols que o time fez no campeonato
	function retornaGolsPro(){
		return $this->golsPro;
	}
	
	//recebe o numero de gols que o time sofreu na partida e soma com os sofridos nas outras partidas
	function insereGolsContra($gols){
		$this->golsContra += $gols;
	}
	
	//retorna o numerode gols que o time sofreu no campeonato
	function retornaGolsContra(){
		return $this->golsContra;
	}
	
	//calcula o numero de pontos feito pelo time no campeonato
	function calculaPontos(){
		$pontos = $this->vitorias * 3 + $this->empates;
		return $pontos;
	}
	
	//retorna o saldo de gols do time no campeonato (saldo de gols = gols pro - gols contra)
	function calculaSaldoDeGols(){
		$saldo = $this->golsPro - $this->golsContra;
		return $saldo;
	}
	//retorna a classificacao do time no campeonato
	function calculaClassificacao(){
		//será implementada somente quando for
		//utilizar a persistencia.
	}

}