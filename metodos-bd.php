<?php

require ('bootstrap.php');

function consultaDql($dql){
	global $entityManager;
	try{
		$query= $entityManager->createQuery($dql);
		$retorna= $query->getResult();	
	} catch(Exception $e) {
		$erroE = $e->getMessage();
		$erro = "$erroE - consultaDql()";
		salvaLogErro($erro);
	}
	return $retorna;
}

function consultaDqlMaxResult($quantidade,$dql){
	global $entityManager;
	try{
		$query= $entityManager->createQuery($dql);
		$query->setMaxResults($quantidade);
		$retorna= $query->getResult();
		
	} catch(Exception $e) {
		$erroE = $e->getMessage();
		$erro = "$erroE - consultaDqlMaxResult('.$quantidade.','.$dql.')";
		salvaLogErro($erro);
	}
	return $retorna;
}

function buscaObjeto($classe, $id){
	global $entityManager;
	try{
		$objeto = $entityManager->find($classe, $id);
	} catch(Exception $e) {
		$erroE = $e->getMessage(); $erro = "$erroE - buscaObjeto('.$classe.', id)";
		salvaLogErro($erro);
	}
	return $objeto;
}

function salvaBancoDados($objeto){
	global $entityManager;
	try{
		$entityManager->persist($objeto);
		$entityManager->flush();
		
	} catch(Exception $e) {
		$erroE = $e->getMessage();
		$erro = "$erroE - salvaBancoDados(objeto)";
		salvaLogErro($erro);
	}
}

function removeBancoDados($objeto){
	global $entityManager;
	try{
		$entityManager->remove($objeto);
		$entityManager->flush();
		
	} catch(Exception $e) {
		$erroE = $e->getMessage();
		$erro = "$erroE - removeBancoDados(objeto)";
		salvaLogErro($erro);
	}
}

function atualizaBancoDados($objeto){
	global $entityManager;
	try{
		$entityManager->merge($objeto);
		$entityManager->flush();
		
	} catch(Exception $e) {
		$erroE = $e->getMessage();
		$erro = "$erroE - removeBancoDados($objeto)";
		salvaLogErro($erro);
	}
}

function desfazTransacao($e){
	global $conn;
	$conn->rollback();
	$erro = $e->getMessage();
	salvaLogErro($erro);
}

function salvaLogErro($erro){
	global $entityManager;
	$dql = "SELECT l FROM Log l WHERE l.descricao = '$erro'";
	$query= $entityManager->createQuery($dql);
	$logs= $query->getResult();
	$naoExiste = true;
	foreach ($logs as $log){
		if($log instanceof Log){
			$naoExiste = false;
			$log->incrementaQuantidade();
			$entityManager->merge($log);
			$entityManager->flush();
		}
	}
	if($naoExiste){
		$log = new Log($erro);
		$entityManager->persist($log);
		$entityManager->flush();
	}
}

?>
