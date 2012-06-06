<?php

use Doctrine\Common\Collections\ArrayCollection;

/** @Entity */
class Jogo {
	
	/** @Id @Column(type="integer", name="id") @GeneratedValue */
	private $codJogo;
	
	/** @Column(type="string")*/
	private $dataJogo;
	
	/** @Column(type="integer")*/
	private $codTime1;
	
	/** @Column(type="integer")*/
	private $codTime2;
	
	/** @Column(type="integer")*/
	private $golsTime1;
	
	/** @Column(type="integer")*/
	private $golsTime2;
	
	/** @Column(type="string")*/
	private $dataInicioApostas;
	
	/** @Column(type="string")*/
	private $dataFimApostas;
	
	/**
	 * @ManyToOne(targetEntity="Rodada", inversedBy="jogosRodada")
	 */
	protected $rodada;
	
	/**
	* @OneToMany(targetEntity="Aposta", mappedBy="jogo", cascade={"persist"})
	* @var Aposta[]
	*/
	protected $apostasJogo = null;
	
	/**
	* @ManyToOne(targetEntity="Campeonato", inversedBy="apostasCampeonato")
	*/
	protected $campeonato;
   
	function __construct($dataJogo,$rodada,$codTime1,$codTime2, $campeonato){
		$dataAtual= $this->calculaDataAtual();
		
		if ($codTime1===$codTime2){
			throw new Exception("ERRO CODIGO DOS DOIS TIMES SAO IGUAIS");
		}
		elseif (($dataJogo <= $dataAtual)){
		throw new Exception("ERRO DATA DO JOGO MENOR QUE DATA ATUAL");
		}
		else{

			$this->dataJogo=$dataJogo;
			$this->rodada = $rodada;
			$this->codTime1=$codTime1;
			$this->codTime2=$codTime2;
			$this->apostasJogo = new ArrayCollection();
			$this->campeonato = $campeonato;
			$this->dataInicioApostas = $this->calculaDataInicioAposta($dataJogo);
			$this->dataFimApostas = $this->calculaDataFimAposta($dataJogo);

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
	
	function setResultado($golsTime1, $golsTime2){
		if (($golsTime1 != "NULL")&&($golsTime2 != "NULL")){
			$this->golsTime1=$golsTime1;
			$this->golsTime2=$golsTime2;
		}
		else {
			$this->golsTime1 = NULL;
			$this->golsTime2 = NULL;
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
		$dataAtual= $this->calculaDataAtual();
	if(($dataInicioApostas>=$this->dataJogo)||($dataInicioApostas<$dataAtual))
		{
			throw new Exception("ERRO DATA DO INICIO DA APOSTA INVALIDO");
		}
		else{
			$this->dataInicioApostas=$dataInicioApostas;
		}
	}
	function setDataFimApostas($dataFimApostas){
		$dataAtual= $this->calculaDataAtual();
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
	
	function getCodjogo(){
		return $this->codJogo;
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
	function getDataInicioApostas(){
		return $this->dataInicioApostas;
	}
	function getDataFimApostas(){
		return $this->dataFimApostas;
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
	function setCampeonato($campeonato){
		$this->campeonato = $campeonato;
	}
	
	/* Recebe o objeto Aposta e adiciona ao array apostasJogo[] */
	
	function adicionaApostasJogo($aposta){
		$this->apostasJogo[] = $aposta;
	}
	function calculaDataInicioAposta($dataJogo){
		$dataInicioApostas = $this->criarDateTime($dataJogo);
		$dataInicioApostas->sub(new DateInterval( "P2D" ) ); // subtrai 2 dias
		$dataInicioApostas->setTime( 00, 00, 00 );
		return $dataInicioApostas->format( "Y-m-d H:i:s" );	
	}
	function calculaDataFimAposta($dataJogo){
		$dataFimAposta = $this->criarDateTime($dataJogo);
		$dataFimAposta->modify( "-1 Hours" );
		return $dataFimAposta->format( "Y-m-d H:i:s" );	
	}
	function criarDatetime($data){
		return new DateTime(''.$data.'', new DateTimeZone('America/Sao_Paulo'));
	}
	function calculaDataAtual(){
		$agora="now";
		$dataAtual = $this->criarDatetime($agora);
		return $dataAtual->format( "Y-m-d H:i:s" );
	}
	

}
?>
