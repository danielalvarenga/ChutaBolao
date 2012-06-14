<?php

/** @Entity @Table(name="pontuacaorodada")*/
Class PontuacaoRodada {
	
	/** @Column(type="integer") */
	private $pontosRodada;
	
	/** @Column(type="integer") */
	private $classificacaoRodada;
	
	/** @Id @ManyToOne(targetEntity="Rodada", inversedBy="pontuacaoRodadas")
	 * @var Rodada
	 */
	protected $rodada;
	
	/** @Id @ManyToOne(targetEntity="Usuario", inversedBy="pontuacaoRodadas")
	 * @var Usuario
	 * */
	protected $usuario; // Objeto da Classe Usuario a quem pertence os prêmios
	
	/** @Id @ManyToOne(targetEntity="Campeonato", inversedBy="pontuacaoRodadas")
	 * @var Campeonato
	 */
	protected $campeonato; // Objeto da Classe Campeonato que referência em qual Campeonato foram ganhos os prêmios
	
	function __construct($rodada, $campeonato, $usuario){
		$this->pontosRodada = 0;
		$this->classificacaoRodada = NULL;
		$this->rodada = $rodada;
		$this->campeonato = $campeonato;
		$this->usuario = $usuario;
	}
	
	function getPontosRodada(){
		return $this->pontosRodada;
	}	
	function getClassificacaoRodada(){
		return $this->classificacaoRodada;
	}
	function setClassificacaoRodada($classificacaoRodada){
		$this->classificacaoRodada = $classificacaoRodada;
	}
	function getRodada(){
		return $this->rodada;
	}
	function setRodada($rodada){
		$this->rodada = $rodada;
	}
	function getCampeonato(){
		return $this->campeonato;
	}
	function setCampeonato(){
		$this->campeonato = $campeonato;
	}
	function getUsuario(){
		return $this->usuario;
	}
	function setUsuario($usuario){
		$this->usuario = $usuario;
	}
	function calculaPontosRodada($pontosAposta){
		$this->pontosRodada += $pontosAposta;
	}
}