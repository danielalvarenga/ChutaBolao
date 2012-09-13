<?php
require_once 'bootstrap.php';

$em = $entityManager;
$tool = new \Doctrine\ORM\Tools\SchemaTool($em);
$classes = array(
		$em->getClassMetadata('Admin'),
		$em->getClassMetadata('Log'),
		$em->getClassMetadata('Pais'),
		$em->getClassMetadata('Time'),
		$em->getClassMetadata('Campeonato'),
		$em->getClassMetadata('RendimentoTime'),
		$em->getClassMetadata('Rodada'),
		$em->getClassMetadata('Jogo'),
		$em->getClassMetadata('Usuario'),
		$em->getClassMetadata('Aposta'),
		$em->getClassMetadata('ContadorAposta'),
		$em->getClassMetadata('PremiosUsuario'),
		$em->getClassMetadata('PontuacaoRodada'),
		$em->getClassMetadata('PontuacaoGeral')
		
);
$tool->dropSchema($classes); // remove banco de dados
//$tool->createSchema($classes); // cria novo banco de dados
//$tool->updateSchema($classes); // atualiza o banco de dados