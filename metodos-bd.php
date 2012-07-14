<?php

require ('bootstrap.php');

function consultaDql($dql){
	global $entityManager;
	$query= $entityManager->createQuery($dql);
	$retorna= $query->getResult();
	return $retorna;
}

function consultaDqlMaxResult($quantidade,$dql){
	global $entityManager;
	$query= $entityManager->createQuery($dql);
	$query->setMaxResults($quantidade);
	$retorna= $query->getResult();
	return $retorna;
}

function salvaBancoDados($novo){
	global $entityManager;
	$entityManager->persist($novo);
	$entityManager->flush();
}

function removeBancoDados($removido){
	global $entityManager;
	$entityManager->remove($removido);
	$entityManager->flush();
	
}

function atualizaBancoDados($atualizado){
	global $entityManager;
	$entityManager->merge($atualizado);
	$entityManager->flush();
	
}

?>
