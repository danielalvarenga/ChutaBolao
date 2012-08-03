<?php

/** @Entity @Table(name="contadoraposta")*/
class ContadorAposta{
	
	/** @Id @Column(type="string", name="id")  */
	private $opcaoCadastrada;
	
	/** @Column(type="integer") */
	private $quantidadeApostas;
	
	/**
	* @Id @ManyToOne(targetEntity="Campeonato", inversedBy="contadorCampeonato")
	*/
	protected $campeonato;
	
	/**
	* @Id @ManyToOne(targetEntity="Jogo", inversedBy="contadorJogo")
	*/
	protected  $jogo;
	
	function __construct($opcaoCadastrada,$campeonato,$jogo){
		$this->opcaoCadastrada=$opcaoCadastrada;
		$this->campeonato=$campeonato;
		$this->jogo=$jogo;
		$this->quantidadeApostas=1;
	}
	
	function incrementaQuantidadeApostas(){
		$this->quantidadeApostas++;	
	}
	
	function decrementaQuantidadeApostas(){
		$this->quantidadeApostas--;
	} 
	
	function getQuantidadeApostas(){
		return $this->quantidadeApostas;	
	}
	function getCampeonato(){
		return $this->campeonato;
	}
	function getJogo(){
		return $this->jogo;
	}
	
	function getOpcaoCadastrada(){
		return $this->opcaoCadastrada;
	}
}
