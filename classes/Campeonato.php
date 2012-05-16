<?php

use Doctrine\Common\Collections\ArrayCollection;

/** @Entity */
class Campeonato {
	
	/** @Id @Column(type="integer", name="id") @GeneratedValue */
	private $codCampeonato;
	
	/** @Column(type="string")*/
	private $nomeCampeonato;
	
	/** @Column(type="integer")*/
	private $anoCampeonato;
	
	/** @Column(type="integer")*/
	private $quantidadeRodadas;
	
	/** @Column(type="string")*/
	private $status;
	
	/**
	* @OneToMany(targetEntity="Aposta", mappedBy="campeonato", cascade={"persist"})
	* @var Aposta[]
	*/
	protected $apostasCampeonato;
	
	/**
	* @OneToMany(targetEntity="Jogo", mappedBy="campeonato")
	* @var Jogo[]
	*/
	protected $jogosCampeonato;
	
	/**
	* @OneToMany(targetEntity="PremiosUsuario", mappedBy="campeonato")
	* @var PremiosUsuario[]
	*/
	protected $premiacoesCampeonato;
	
	
	public function __construct($nomeCampeonato, $anoCampeonato, $quantidadeRodadas){
		if ($quantidadeRodadas <= 0) {
			throw new Exception("ERRO: QUANTIDADE DE RODADAS INVALIDA");
		}
		
		else
		if ($quantidadeRodadas===null){
			throw new Exception("É OBRIGATÓRIO PREENCHER O CAMPO RODADAS");
		}
		else{
			$this->nomeCampeonato = $nomeCampeonato;
			$this->anoCampeonato = $anoCampeonato;
			$this->status = "ativo";
			$this->quantidadeRodadas = $quantidadeRodadas;
			$this->apostasCampeonato = new ArrayCollection();
			$this->jogosCampeonato = new ArrayCollection();
			$this->premiacoesCampeonato = new ArrayCollection();
		}
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
	
	function getApostasCampeonato(){
		return $this->apostasCampeonato;
	}
	
	function getJogosCampeonato(){
		return $this->jogosCampeonato;
	}
	
	function getPremiacoesCampeonato(){
		return $this->premiacoesCampeonato;
	}
	
	/* Recebe o objeto PremiosUsuario e adiciona ao array premiacoesCampeonato[] */
	
	function adicionaPremiacoesCampeonato($premiosUsuario){
		$this->premiacoesCampeonato[] = $premiosUsuario;
	}
	
	/* Recebe o objeto Aposta e adiciona ao array apostasCampeonato[] */
	
	function adicionaApostasCampeonato($aposta){
		$this->apostasCampeonato[] = $aposta;
	}
	
	/* Recebe o objeto Jogo e adiciona ao array jogosCampeonato[] */

	function adicionaJogosCampeonato($jogo){
		$this->jogosCampeonato[] = $jogo;
	}
	
}
?>