
<?php
 function calculaDataAtual(){
	$agora = time()-18000;

	$data=getdate($agora);
	if($data["mday"]<=9){ $data["mday"]="0".$data["mday"];	}
	
	if($data["mon"]<=9){ $data["mon"]="0".$data["mon"];	    }
	
	if(($data["hours"]-5)<=9){ $data["hours"]="0".$data["hours"];	}
	
	if($data["minutes"]<=9){ $data["minutes"]="0".$data["minutes"];	}
	
	if($data["seconds"]<=9){ $data["seconds"]="0".$data["seconds"];	}
	
	$dataAtual= $data["year"]."-".$data["mon"]."-".$data["mday"]."-".$data["hours"].
		":".$data["minutes"].":".$data["seconds"];
	
	return $dataAtual; }
?>
<?php

use Doctrine\Common\Collections\ArrayCollection;

/** @Entity */
class Jogo {
	
	/** @Id @Column(type="integer") @GeneratedValue */
	private $codJogo;
	
	/** @Column(type="datetime")*/
	private $dataJogo;
	
	/** @Column(type="integer")*/
	private $rodada;
	
	/** @Column(type="integer")*/
	private $codTime1;
	
	/** @Column(type="integer")*/
	private $codTime2;
	
	/** @Column(type="integer")*/
	private $golsTime1;
	
	/** @Column(type="integer")*/
	private $golsTime2;
	
	/** @Column(type="datetime")*/
	private $dataInicioApostas;
	
	/** @Column(type="datetime")*/
	private $dataFimApostas;
	
	/**
	* @OneToMany(targetEntity="Aposta", mappedBy="jogo")
	* @var Aposta[]
	*/
	protected $apostasJogo = null;
	
	/**
	* @ManyToOne(targetEntity="Campeonato", inversedBy="apostasCampeonato")
	*/
	protected $campeonato;
   
	function __construct($dataJogo,$rodada,$codTime1,$codTime2){
		$dataAtual= calculaDataAtual();
		
		if((!(is_int($codTime1)) || ($codTime1<=0)) || (!(is_int($codTime2)) || ($codTime2<=0))){
			throw new Exception("ERRO OS PARAMETROS DOS TIMES SAO INVALIDOS ");
		}

		elseif ($codTime1===$codTime2){
			throw new Exception("ERRO CODIGO DOS DOIS TIMES SAO IGUAIS");
		}

		elseif (!((is_int($rodada))&&($rodada>0))){
			throw new Exception("ERRO CODIGO DA RODADA INVALIDA");
		}
		elseif (($dataJogo <= $dataAtual)){
		throw new Exception("ERRO DATA DO JOGO MENOR QUE DATA ATUAL");
		}
		else{

			$this->dataJogo=$dataJogo;
			$this->rodada=$rodada;
			$this->codTime1=$codTime1;
			$this->codTime2=$codTime2;
			$this->apostasJogo = new ArrayCollection();

		}
	}
		function setCodTime1($codTime1){
	
		if(((is_int($codTime1))&&($codTime1>0))){
			$this->codTime1=$codTime1;
		}

		else{throw new Exception("ERRO PARAMETROS DO TIME INVALIDO");
		}
	}
	function setCodTime2($codTime2){
		if(((is_int($codTime2))&&($codTime2>0))){
			$this->codTime2=$codTime2;
		}

		else{throw new Exception("ERRO PARAMETROS DO TIME INVALIDO");
		}
	}
	function setGolstime1($num_golsTime1){
		if (is_int($num_golsTime1)&&($num_golsTime1>=0)){
			$this->golsTime1=$num_golsTime1;
		}
		else {
			throw new Exception("NUMERO DE GOLS INVALIDO");
		}
	}

	function setGolstime2($num_golsTime2){
		if (is_int($num_golsTime2)&&($num_golsTime2>=0)){
			$this->golsTime2=$num_golsTime2;
				
		}
		else {
			throw new Exception("NUMERO DE GOLS INVALIDO");
				
		}

	}
	
	function setDataInicioApostas($dataInicioApostas){
		$dataAtual= calculaDataAtual();
	if(($dataInicioApostas>=$this->dataJogo)||($dataInicioApostas<$dataAtual))
		{
			throw new Exception("ERRO DATA DO INICIO DA APOSTA INVALIDO");
		}
		else{
			$this->dataInicioApostas=$dataInicioApostas;
		}
	}
	function setDataFimApostas($dataFimApostas){
		$dataAtual= calculaDataAtual();
				if(($dataFimApostas>=$this->dataJogo)||($dataFimApostas<$dataAtual)
		||($dataFimApostas<=$this->dataInicioApostas))
		{
			throw new Exception("ERRO DATA DO FIM DA APOSTA INVALIDO");
		}
		else{
			$this->dataFimApostas=$dataFimApostas;
		}
		
	}

	function verificaPeriodoapostas($dataDaAposta){
		
		if (($dataDaAposta>=$this->dataInicioApostas)&&($dataDaAposta<=$this->dataFimApostas)) {
			return true;
		}
		else {
			return false;
		}
	}

	function getDatajogo(){
		return $this->dataJogo;
	}

	function getGolstime1(){
		return $this->golsTime1;
	}

	function getGolstime2(){
		return $this->golsTime2;
	}

	function getCodtime1(){
		return $this->codTime1;
	}

	function getCodtime2(){
		return $this->codTime2;
	}

	function getRodada(){
		return $this->rodada;
	}
	
	function getDataInicioApostas(){
		return $this->dataInicioApostas;
	}

	function getDataFimApostas(){
		return $this->dataFimApostas;
	}
	
	function getCampeonato(){
		return $this->campeonato;
	}
	
	function setCampeonato($campeonato){
		$this->campeonato = $campeonato;
	}
	
	/* Recebe o objeto Aposta e adiciona ao array apostasJogo[] */
	
	function adicionaApostasJogo($aposta){
		$this->apostasJogo[] = $aposta;
	}

}
