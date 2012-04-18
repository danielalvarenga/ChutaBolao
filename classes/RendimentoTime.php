<?php
class RendimentoTime{

	private $idCampeonato;
	private $idTime;
	private $classificacao;
	private $vitorias;
	private $derrotas;
	private $empates;
	private $golsPro;
	private $golsContra;

	function incrementaVitorias(){
		$this->vitorias++;
	}

	function getVitorias(){
		return $this->vitorias;
	}

	function incrementaDerrotas(){
		$this->derrotas++;
	}

	function getDerrotas(){
		return $this->derrotas;
	}

	function incrementaEmpates(){
		$this->empates++;
	}

	function getEmpates(){
		return $this->empates;
	}

	function insereGolsPro($gols){
		$this->golsPro += $gols;
	}

	function retornaGolsPro(){
		return $this->golsPro;
	}

	function insereGolsContra($gols){
		$this->golsContra += $gols;
	}

	function retornaGolsContra(){
		return $this->golsContra;
	}

	function calculaPontos(){
		$pontos = $this->vitorias * 3 + $this->empates;
		return $pontos;
	}

	function calculaSaldoDeGols(){
		$saldo = $this->golsPro - $this->golsContra;
		return $saldo;
	}

	function calculaClassificacao(){
		//será implementada somente quando for
		//utilizar a persistencia.
	}

}