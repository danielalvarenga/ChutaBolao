<?php

/** @Entity @Table(name="pontuacaogeral")*/
Class PontuacaoGeral {
	
	/** @Column(type="integer") */
	private $acertosPlacarGeral;

	/** @Column(type="integer") */
	private $acertosTimeGanhadorGeral;

	/** @Column(type="integer") */
	private $acertosPlacarInvertidoGeral;
	
	/** @Column(type="integer") */
	private $errosPlacarGeral;

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
	
	/** @Column(type="integer") */
	private $trofeus;

	/** @Id @OneToOne(targetEntity="Usuario", inversedBy="pontuacaoGeral", cascade={"persist"})
	 * @var Usuario
	 * */
	protected $usuario;
	
	function __construct($usuario){
		$this->acertosPlacarGeral = 0;
		$this->acertosTimeGanhadorGeral = 0;
		$this->acertosPlacarInvertidoGeral = 0;
		$this->errosPlacarGeral = 0;
		$this->pontosGeral = 0;
		$this->classificacaoGeral = 0;
		$this->medalhasOuroGeral = 0;
		$this->medalhasPrataGeral = 0;
		$this->medalhasBronzeGeral = 0;
		$this->pontosMedalhasGeral = 0;
		$this->classificacaoMedalhasGeral = 0;
		$this->trofeus = 0;
		$this->usuario = $usuario;
	}
	
	function getUsuario(){
		return $this->usuario;
	}
	function setUsuario($usuario){
		$this->usuario = $usuario;
	}
	function getAcertosPlacarGeral(){
		return $this->acertosPlacarGeral;
	}
	function getAcertosTimeGanhadorGeral(){
		return $this->acertosTimeGanhadorGeral;
	}
	function getAcertosPlacarInvertidoGeral(){
		return $this->acertosPlacarInvertidoGeral;
	}
	function getErrosPlacarGeral(){
		return $this->errosPlacarGeral;
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
	function getTrofeus(){
		return $this->trofeus;
	}
	function ganhaTrofeu(){
		$this->trofeus++;
	}
	function calculaPontosMedalhasGeral(){
		$this->pontosMedalhasGeral=
			($this->medalhasOuroGeral <<13)+
			($this->medalhasPrataGeral<<7)+
			($this->medalhasBronzeGeral<<1);
	}
	function calculaPontosGeral($pontosAposta){
		switch($pontosAposta){
			case 10 : {
				$this->acertosPlacarGeral++;
				break;
			}
			case 5 : {
				$this->acertosTimeGanhadorGeral++;
				break;
			}
			case 2 : {
				$this->acertosPlacarInvertidoGeral++;
				break;
			}
			case 0 : {
				$this->errosPlacarGeral++;
				break;
			}
		}
		$this->pontosGeral += $pontosAposta;
	}
}
?>