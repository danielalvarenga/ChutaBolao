<?php
/** @Entity @Table(name="log")*/
class Log{
	
	/** @Id @Column(type="integer", name="id") @GeneratedValue */
	private $idLog;
	
	/** @Column(type="string")*/
	private $descricao;

	/** @Column(type="string")*/
	private $data;
	
	/** @Column(type="integer")*/
	private $quantidade;
	
	function __construct($descricao){
		$this->descricao = $descricao;
		$this->quantidade = 1;
		$this->setData();
	}
	
	function getIdLog(){
		return $this->idLog;
	}
	function setDescricao($descricao){
		$this->descricao = $descricao;
	}
	function getDescricao(){
		return $this->descricao;
	}
	function incrementaQuantidade(){
		$this->Quantidade++;
		$this->setData();
	}
	function getQuantidade(){
		return $this->quantidade;
	}
	function setData(){
		$dataAgora = $this->criarDateTime("now");
		$data = $dataAgora->format( "Y-m-d H:i:s" );
		$this->data = $data;
	}
	function getData(){
		$data = $this->criarDateTime($this->data);
		return $data->format( "d/m/Y" )." às ".$dataLogica->format( "H:i" );
	}
	function criarDateTime($data){
		return new DateTime(''.$data.'', new DateTimeZone('America/Sao_Paulo'));
	}
	
}
?>