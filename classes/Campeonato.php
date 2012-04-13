<?php
class Campeonato {

	private $codCampeonato;

	private $nomeCampeonato;
	
	private $anoCampeonato;
	
	private $rodada = array();

	
	public function getCodCampeonato(){
		return $codCampeonato;
	}

	public function setNomeCampeonato($nomeCampeonato){
		$this->nomeCampeonato = $nomeCampeonato;
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

	public function adicionarRodadas($rodada){
		for ($rodada = 0; $rodada < 38; $variavel++){
			$this->rodada[] = $rodada; 
		}
	}
}
?>