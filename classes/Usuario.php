<?php

use Doctrine\Common\Collections\ArrayCollection;

/** @Entity */
class Usuario implements Transacao {
	
	/**
	 * @Id
	 * @GenerateValue
	 */
	private $idUsuario;
	
	/** @Column(type="string", nullable=false) */
	private $tokenUsuario;
	
	/** @Column(type="string", nullable=false) */
	private $nomeUsuario;
	
	/** @Column(type="string", nullable=false) */
	private $primeiroNomeUsuario;
	
	/** @Column(type="string", nullable=false) */
	private $segundoNomeUsuario;
	
	/** @Column(type="string", nullable=false) */
	private $emailUsuario;
	
	/** @Column(type="integer", nullable=false) */
	private $pontosGeralUsuario = 0;
	
	/**
	 * @OneToMany(targetEntity="PremiosUsuario", mappedBy="usuario")
	 * @var PremiosUsuario[]
	 */
	protected $premiacoesUsuario = null;
	
}