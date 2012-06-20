<?php

/** @Entity @Table(name="pontuacaogeral")*/
Class PontuacaoGeral {

	/** @Column(type="integer") */
	private $pontosGeral;

	/** @Column(type="integer") */
	private $classificacaoGeral;
	
	/** @Column(type="integer") */
	private $medalhasOuroGeral;
	
	/** @Column(type="integer") */
	private $medalhasPrataGeral;
	
	/** @Column(type="integer") */
	private $medalhasBronzeGeral;
	
	/** @Column(type="integer") */
	private $pontosMedalhasGeral;
	
	/** @Column(type="integer") */
	private $classificacaoMedalhasGeral;

	/** @Id @OneToOne(targetEntity="Usuario", inversedBy="pontuacaoGeral")
	 * @var Usuario
	 * */
	protected $usuario;
	
	function __construct($usuario){
		$this->pontosGeral = 0;
		$this->classificacaoGeral = 0;
		$this->medalhasOuroGeral = 0;
		$this->medalhasPrataGeral = 0;
		$this->medalhasBronzeGeral = 0;
		$this->pontosMedalhasGeral = 0;
		$this->classificacaoMedalhasGeral = 0;
		$this->usuario = $usuario;
	}
	
	function getUsuario(){
		return $this->usuario;
	}
	function setUsuario($usuario){
		$this->usuario = $usuario;
	}
	function calculaPontosGeral($pontosAposta){
		$this->pontosGeral += $pontosAposta;
	}
	function getPontosGeral(){
		return $this->pontosGeral;
	}
	function getClassificacaoGeral(){
		return $this->classificacaoGeral;
	}
	function setClassificacaoGeral($classificacaoGeral){
		$this->classificacaoGeral = $classificacaoGeral;
	}
	function getMedalhasOuroGeral(){
		return $this->medalhasOuroGeral++;
	}
	function getMedalhasPrataGeral(){
		return $this->medalhasPrataGeral++;
	}
	function getMedalhasBronzeGeral(){
		return $this->medalhasBronzeGeral++;
	}
	function ganhaMedalhasOuroGeral(){
		$this->medalhasOuroGeral++;
		$this->calculaPontosMedalhasGeral();
	}
	function ganhaMedalhasPrataGeral(){
		$this->medalhasPrataGeral++;
		$this->calculaPontosMedalhasGeral();
	}
	function ganhaMedalhasBronzeGeral(){
		$this->medalhasBronzeGeral++;
		$this->calculaPontosMedalhasGeral();
	}
	function setClassificacaoMedalhasGeral($classificacaoMedalhasGeral){
		$this->classificacaoMedalhasGeral = $classificacaoMedalhasGeral;
	}
	function getClassificacaoMedalhasGeral(){
		return $this->classificacaoMedalhasGeral;
	}
	function getPontosMedalhasGeral(){
		return $this->pontosMedalhasGeral;
	}
	function calculaPontosMedalhasGeral(){
		$this->pontosMedalhasGeral=
			($this->medalhasOuroGeral <<13)+
			($this->medalhasPrataGeral<<7)+
			($this->medalhasBronzeGeral<<1);
	}
}
?>