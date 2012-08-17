<?php

use Doctrine\Common\Collections\ArrayCollection;

/** @Entity @Table(name="campeonato")*/
class Campeonato {
	
	/** @Id @Column(type="integer", name="id") @GeneratedValue */
	private $codCampeonato;
	
	/** @Column(type="string")*/
	private $nomeCampeonato;
	
	/** @Column(type="integer")*/
	private $anoCampeonato;
	
	/** @Column(type="string")*/
	private $status;
	
	/** @Column(type="integer")*/
	private $quantidadeRodadas;
	
	/** @Column(type="string")*/
	private $urlLogo;
	
	/**
	* @OneToMany(targetEntity="Rodada", mappedBy="campeonato", cascade={"persist", "remove"})
	* @var Rodada[]
	*/
	protected $rodadas;

	/**
	* @OneToMany(targetEntity="ContadorAposta", mappedBy="campeonato", cascade={"persist", "remove"})
	* @var ContadorAposta[]
	*/
	protected $contadorCampeonato;
	
	/**
	 * @OneToMany(targetEntity="PontuacaoRodada", mappedBy="rodada", cascade={"persist", "remove"})
	 * @var PontuacaoRodada[]
	 */
	protected $pontuacaoRodadas;
	
	/**
	* @OneToMany(targetEntity="Aposta", mappedBy="campeonato", cascade={"persist", "remove"})
	* @var Aposta[]
	*/
	protected $apostasCampeonato;
	
	/**
	* @OneToMany(targetEntity="Jogo", mappedBy="campeonato", cascade={"persist", "remove"})
	* @var Jogo[]
	*/
	protected $jogosCampeonato;
	
	/**
	* @OneToMany(targetEntity="PremiosUsuario", mappedBy="campeonato", cascade={"persist", "remove"})
	* @var PremiosUsuario[]
	*/
	protected $premiacoesCampeonato;
	
	/**
	 * @OneToMany(targetEntity="RendimentoTime", mappedBy="campeonato", cascade={"persist", "remove"})
	 * @var RendimentoTime[]
	 */
	protected $rendimentosTimes;
	
	
	function __construct($nomeCampeonato, $anoCampeonato, $qtdRodadas, $urlLogo){
			$this->nomeCampeonato = $nomeCampeonato;
			$this->anoCampeonato = $anoCampeonato;
			$this->status = "ativo";
			$this->setQuantidadeRodadas($qtdRodadas);
			$this->setUrlLogo($urlLogo);
			$this->apostasCampeonato = new ArrayCollection();
			$this->jogosCampeonato = new ArrayCollection();
			$this->premiacoesCampeonato = new ArrayCollection();
			$this->rendimentosTimes = new ArrayCollection();
			$this->pontuacaoRodadas = new ArrayCollection();
			$this->contadorCampeonato= new ArrayCollection();	
	}
	
	function getUrlLogo(){
		return $this->urlLogo;
	}
	
	function setUrlLogo($urlImagem){
		$this->urlLogo = $urlImagem;
	}
	
	function getContadorCampeonato(){
		return $this->contadorCampeonato;
	}
	function getCodCampeonato(){
		return $this->codCampeonato;
	}

	function setNomeCampeonato($nomeCampeonato){
		$this->nomeCampeonato = strtoupper($nomeCampeonato);
	}

	function getNomeCampeonato(){
		return $this->nomeCampeonato;
	}

	function setAnoCampeonato($anoCampeonato){
		$this->anoCampeonato = $anoCampeonato;
	}
	
	function getAnoCampeonato(){
		return $this->anoCampeonato;
	}

	function finalizaStatus(){
		$this->status = "finalizado";
	}
	
	function ativaStatus(){
		$this->status = "ativo";
	}
	
	function getStatus(){
		return $this->status;
	} 
	
	function adicionarQuantidadeRodadas($quantidadeRodadas){
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
	function setQuantidadeRodadas($qtdRodadas){
		$this->quantidadeRodadas = $qtdRodadas;
	}
	
	function getQuantidadeRodadas(){
		return $this->quantidadeRodadas;
	}
	
	function getRodadas(){
		return $this->rodadas;
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
	
	function getRendimentosTimes(){
		return $this->rendimentosTimes;
	}
	
	function getPontuacaoRodadas(){
		return $this->pontuacaoRodadas;
	}
	
	function adicionaPontuacaoRodada($pontuacaoRodada){
		$this->pontuacaoRodadas[] = $pontuacaoRodada;
	}
	
	function adicionaRodada($rodada){
		$this->rodadas[] = $rodada;
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
	function adicionaRendimentosTimes($rendimentoTime){
		$this->rendimentosTimes[] = $rendimentoTime;
	}
	
}
?>