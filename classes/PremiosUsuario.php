<?php

use Doctrine\Common\Collections\ArrayCollection;


/** @Entity */
class PremiosUsuario {
	
	/** @Id @Column(type="integer") @GenerateValue */
	private $codPremiacoes;
	
	/** @Column(type="integer", nullable=true) */
	private $codCampeonato;
	
	/** @Column(type="integer", nullable=true) */
	private $codTimeFavorito;
	
	/** @Column(type="integer", nullable=true) */
	private $codRodada;
	
	/** @Column(type="integer", nullable=false) */
	private $acertosPlacar;
	
	/** @Column(type="integer", nullable=false) */
	private $acertosTimeGanhador;
	
	/** @Column(type="integer", nullable=false) */
	private $acertosPlacarInvertido;
	
	/** @Column(type="integer", nullable=false) */
	private $pontosCampeonato;
	
	/** @Column(type="integer", nullable=false) */
	private $pontosRodada;
	
	/** @Column(type="integer", nullable=false) */
	private $medalhasOuro;
	
	/** @Column(type="integer", nullable=false) */
	private $medalhasPrata;
	
	/** @Column(type="integer", nullable=false) */
	private $medalhasBronze;
	
	/** @Column(type="integer", nullable=false) */
	private $chuteirasOuro;
	
	/** @Column(type="integer", nullable=false) */
	private $chuteirasPrata;
	
	/** @Column(type="integer", nullable=false) */
	private $chuteirasBronze;
	
	/** @Column(type="integer", nullable=false) */
	private $trofeus;
	
	/** @ManyToOne(targetEntity="Usuario", inversedBy="premios")
	 * @var Usuario */
	protected $usuario;
	
	function _construct($codCampeonato, $codRodada, $codTimeFavorito = null){
		$this->codCampeonato = $codCampeonato;
		$this->codTimeFavorito = $codTimeFavorito;
		$this->codRodada = $codRodada;
		$this->acertosPlacar = 0;
		$this->acertosTimeGanhador = 0;
		$this->acertosPlacarInvertido = 0;
		$this->pontosCampeonato = 0;
		$this->pontosRodada = 0;
		$this->medalhasOuro = 0;
		$this->medalhasPrata = 0;
		$this->medalhasBronze = 0;
		$this->chuteirasOuro = 0;
		$this->chuteirasPrata = 0;
		$this->chuteirasBronze = 0;
		$this->trofeus = 0;		
	}
	
	function getAcertosPlacar(){
		return $acertosPlacar;
	}
	
	function setAcertosPlacar(){
		$this->acertosPlacar++;
	}

}