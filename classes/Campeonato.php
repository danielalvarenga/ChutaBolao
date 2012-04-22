<?php
class Campeonato {

	private $codCampeonato;

	private $nomeCampeonato;
	
	private $anoCampeonato;
	
	private $quantidadeRodadas;
	
	private $status;
	
	public function __construct($nomeCampeonato, $anoCampeonato, $quantidadeRodadas){
		$this->nomeCampeonato = $nomeCampeonato;
		$this->anoCampeonato = $anoCampeonato;
		$this->quantidadeRodadas = $quantidadeRodadas;
		$this->status = "ativo";
	}

	public function getCodCampeonato(){
		return $this->codCampeonato;
	}
	
	public function setQuantidadeRodadas($quantidadeRodadas){
		$this->quantidadeRodadas = strtoupper($quantidadeRodadas);
	}
	
	public function getQuantidadeRodadas(){
		return $this->quantidadeRodadas;
	}

	public function setNomeCampeonato($nomeCampeonato){
		$this->nomeCampeonato = strtoupper($nomeCampeonato);
	}

	public function getNomeCampeonato(){
		return $this->nomeCampeonato;
	}

	public function setAnoCampeonato($anoCampeonato){
		$this->anoCampeonato = $anoCampeonato;
	}
	
	public function getAnoCampeonato(){
		return $this->anoCampeonato;
	}

	public function finalizaStatus(){
		$this->status = "finalizado";
	}
	
	public function ativaStatus(){
		$this->status = "ativo";
	}
	
	public function getStatus(){
		return $this->status;
	} 
	
	public function adicionarQuantidadeRodadas($quantidadeRodadas){
		if ($quantidadeRodadas <= 0) {
			throw new Exception("ERRO: QUANTIDADE DE RODADAS INVALIDA");
		}
		
		else
		if ($quantidadeRodadas===null){
			throw new Exception("E OBRIGATORIO PREENCHER O CAMPO");
		}
		else{
			$this->quantidadeRodadas = $quantidadeRodadas;
		}
	}		 
		
	public function adicionarRodadas($rodada){
		if ($rodada >= $quantidadeRodadas) {
			throw new Exception("ERRO: NUMERO DE RODADA INVALIDO");
		}
		
		else
			if ($rodada===null){
				throw new Exception("E OBRIGATORIO PREENCHER O CAMPO");
			}
			else{
				$this->rodada = $rodada;
			}
		}
	
}
?>