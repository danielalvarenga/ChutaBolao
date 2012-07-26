<?php

require ('bootstrap.php');

function consultaDql($dql){
	global $entityManager;
	$conn = $entityManager->getConnection();
	$conn->beginTransaction();
	try{
		$query= $entityManager->createQuery($dql);
		$retorna= $query->getResult();
		$conn->commit();
	} catch(Exception $e) {
		$conn->rollback();
		$erro = $e->getMessage().' - consultaDql('.$dql.')';
		salvaLogErro($erro);
	}
	return $retorna;
}

function consultaDqlMaxResult($quantidade,$dql){
	global $entityManager;
	$conn = $entityManager->getConnection();
	$conn->beginTransaction();
	try{
		$query= $entityManager->createQuery($dql);
		$query->setMaxResults($quantidade);
		$retorna= $query->getResult();
		$conn->commit();
	} catch(Exception $e) {
		$conn->rollback();
		$erro = $e->getMessage().' - consultaDqlMaxResult('.$quantidade.','.$dql.')';
		salvaLogErro($erro);
	}
	return $retorna;
}

function buscaObjeto($classe, $id){
	global $entityManager;
	$conn = $entityManager->getConnection();
	$conn->beginTransaction();
	try{
		$objeto = $entityManager->find($classe, $id);
		$conn->commit();
	} catch(Exception $e) {
		$conn->rollback();
		$erro = $e->getMessage().' - buscaObjeto('.$classe.', id)';
		salvaLogErro($erro);
	}
	return $objeto;
}

function salvaBancoDados($objeto){
	global $entityManager;
	$conn = $entityManager->getConnection();
	$conn->beginTransaction();
	try{
		$entityManager->persist($objeto);
		$entityManager->flush();
		$conn->commit();
	} catch(Exception $e) {
		$conn->rollback();
		$erro = $e->getMessage().' - salvaBancoDados('.$objeto.')';
		salvaLogErro($erro);
	}
}

function removeBancoDados($objeto){
	global $entityManager;
	$conn = $entityManager->getConnection();
	$conn->beginTransaction();
	try{
		$entityManager->remove($objeto);
		$entityManager->flush();
		$conn->commit();
	} catch(Exception $e) {
		$conn->rollback();
		$erro = $e->getMessage().' - removeBancoDados('.$objeto.')';
		salvaLogErro($erro);
	}
}

function atualizaBancoDados($atualizado){
	global $entityManager;
	global $entityManager;
	$conn = $entityManager->getConnection();
	$conn->beginTransaction();
	try{
		$entityManager->merge($atualizado);
		$entityManager->flush();
		$conn->commit();
	} catch(Exception $e) {
		$conn->rollback();
		$erro = $e->getMessage().' - removeBancoDados('.$objeto.')';
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
	$dql = "SELECT l FROM Log l WHERE l.descricao = '$erro'";
	$logs = consultaDql($dql);
	if($logs <> NULL){
		foreach ($logs as $log){
			if($log instanceof Log){
				$log->incrementaQuantidade();
				atualizaBancoDados($log);
			}
		}
	}
	else{
		$log = new Log($erro);
		salvaBancoDados($log);
	}
	echo("<script> top.location.href='index.php'</script>");
}

?>
