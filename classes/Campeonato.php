<?php
class Campeonato {

	private $codCampeonato;

	private $nomeCampeonato;
	
	private $anoCampeonato;
	
	private $quantidadeRodadas;
	
	private $status;

	public function getCodCampeonato(){
		return $codCampeonato;
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
		return $nomeCampeonato;
	}

	public function setAnoCampeonato($anoCampeonato){
		$this->nomeCampeonato = $nomeCampeonato;
	}
	
	public function getAnoCampeonato(){
		return $nomeCampeonato;
	}

	public function setStatus($status){
		$this->status = strtoupper($status);
	}
	
	public function getStatus(){
		return $status;
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