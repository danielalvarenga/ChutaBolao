<?php
class Classicacao{
	
	private $idCampeonato;
	private $idTime;
	private $classificacao;
	private $vitorias;
	private $derrotas;
	private $empates;
	private $golsPro;
	private $golsContra;
	
	function imcrementaVitorias(){
		$vitorias++;
	}
	
	function getVitorias(){
		return $vitorias;
	}
	
	function incrementaDerrotas(){
		$derrotas++;
	}
	
	function getDerrotas(){
		return $derrotas;
	}
	
	function incrementaEmpates(){
		$empates++;
	}
	
	function getEmpates(){
		return $empates;
	}
	
	function insereGolsPro($gols){
		$golsPro += gols;
	}
	
	function retornaGolsPro(){
		return $golsPro;
	}
	
	function insereGolsContra($gols){
		$golsContra += $gols;
	}
	
	function retornaGolsContra(){
		return $golsContra;
	}
	
	function calculaPontos(){
		return $vitorias * 3 + $empates;
	}
	
	function calculaSaldoDeGols(){
		return $golsPro - $golsContra;
	}
	
	function calculaClassificacao(){
		//será implementada somente quando for
		//utilizar a persistencia.
	}
	
}