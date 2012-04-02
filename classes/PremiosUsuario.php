<?php

use Doctrine\Common\Collections\ArrayCollection;


/** @Entity */
class PremiosUsuario {
	
	/**
	 * @Id
	 * @Column(type="integer")
	 * @GenerateValue
	 */
	private $codPremiacoes;
	
	/** @Column(type="integer", nullable=true) */
	private $codCampeonato;
	
	/** @Column(type="integer", nullable=true) */
	private $codTimeFavorito;
	
	/** @Column(type="integer", nullable=true) */
	private $codRodada;
	
	/** @Column(type="integer", nullable=false) */
	private $acertosPlacar = 0;
	
	/** @Column(type="integer", nullable=false) */
	private $acertosTimeGanhador = 0;
	
	/** @Column(type="integer", nullable=false) */
	private $acertosPlacarInvertido = 0;
	
	/** @Column(type="integer", nullable=false) */
	private $pontosCampeonato = 0;
	
	/** @Column(type="integer", nullable=false) */
	private $pontosRodada = 0;
	
	/** @Column(type="integer", nullable=false) */
	private $medalhasOuro = 0;
	
	/** @Column(type="integer", nullable=false) */
	private $medalhasPrata = 0;
	
	/** @Column(type="integer", nullable=false) */
	private $medalhasBronze = 0;
	
	/** @Column(type="integer", nullable=false) */
	private $chuteirasOuro = 0;
	
	/** @Column(type="integer", nullable=false) */
	private $chuteirasPrata = 0;
	
	/** @Column(type="integer", nullable=false) */
	private $chuteirasBronze = 0;
	
	/** @Column(type="integer", nullable=false) */
	private $trofeus = 0;
	
	/**
	 * @ManyToOne(targetEntity="Usuario", inversedBy="premiacoesUsuario")
	 * @var Usuario
	 */
	protected $usuario;
}