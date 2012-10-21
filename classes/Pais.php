<?php

use Doctrine\Common\Collections\ArrayCollection;

/** @Entity @Table(name="pais")*/
class Pais{
	
	/** @Column(type="string") */
	private $sigla2letras;
	
	/** @Column(type="string") */
	private $sigla3letras;
	
	/** @Id @Column(type="integer", name="id") @GeneratedValue*/
	private $codPais;
	
	/** @Column(type="string") */
	private $nomePais;
	
	/** @Column(type="string") */
	private $bandeira;
	
	/**
	 * @OneToMany(targetEntity="Time", mappedBy="pais", cascade={"persist"})
	 * @var Time[]
	 */
	protected $times;
	
	function __construct($nomePais, $sigla2letras, $sigla3letras, $bandeira){
		$this->setNomePais($nomePais);
		$this->setBandeira($bandeira);
		$this->setSigla2Letras($sigla2letras);
		$this->setSigla3Letras($sigla3letras);
		$this->times = new ArrayCollection();
	}
	function getCodPais(){
		return $this->codPais;
	}
	function setNomePais($nomePais){
		$this->nomePais = $nomePais;
	}
	function getNomePais(){
		return $this->nomePais;
	}
	function setSigla2Letras($sigla2letras){
		$this->sigla2letras = strtoupper($sigla2letras);
	}
	function getSigla2Letras(){
		return $this->sigla2letras;
	}
	function setSigla3Letras($sigla3letras){
		$this->sigla3letras = strtoupper($sigla3letras);
	}
	function getSigla3Letras(){
		return $this->sigla3letras;
	}
	function setBandeira($bandeira){
		$this->bandeira = $bandeira;
	}
	function getBandeira(){
		return $this->bandeira;
	}
	function getTimes(){
		return $this->times;
	}
	function adicionaTime($time){
		$this->times[] = $time;
	}
}