<?php
 class BancoDeDadosAposta {
 private	$idUsuario;
 private $codCampeonato;
 private $codJogo;
 private $apostaGolsTime1;
 private $apostaGolsTime2;
 
function __construct($idUsuario,$codCampeonato,$codJogo){
	$this->idUsuario=$idUsuario;
	$this->codCampeonato=$codCampeonato;
	$this->codJogo=$codJogo;
}

function query($idUsuario,$codCampeonato,$codJogo){
	if (($this->idUsuario===$idUsuario)&&($this->codCampeonato===$codCampeonato)&&($this->codJogo===$codJogo))
	{throw new Exception("APOSTA JA CADASTRADA NO BANCO DE DADOS");}
	
}
function setApostaGolsTime1($apostaGolsTime1){
$this->apostaGolsTime1=$apostaGolsTime1;
}
function setApostaGolsTime2($apostaGolsTime2){
	$this->apostaGolsTime2=$apostaGolsTime2;
}

 } 
 ?>