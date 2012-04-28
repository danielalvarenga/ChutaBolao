<?php
use Doctrine\Common\Collections\ArrayCollection;

/**
* @Entity @Table(name="time")
*/
class time{
	/** @Id @Column(type="integer") @GeneratedValue */
	private $id;
	/** @Column(type="string") */
	private $nome;
	/**
	* @OneToMany(targetEntity="RendimentoTime", mappedBy="time")
	* @var RendimentoTime[]
	*/
	//private $rendimento = new ArreyCollection();
	
	function __construct($nome){
		$this->nome = strtoupper($nome);
	}
	
	function getId(){
		return $id;
	}
	
	function setNome($nome){
		$this->nome = strtoupper($nome);
	}
	
	function getNome(){
		return $this->nome;
	}
	function setClassificacao($rendimento){
		$this->rendimento[] = $rendimento;
	}
	function getClassificacao(){
		return $classificacao;
	}
}
?>