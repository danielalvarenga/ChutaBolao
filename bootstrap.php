<?php

use Doctrine\ORM\Tools\Setup;

require_once "entities/Usuario.php";

require_once "Doctrine/ORM/Tools/Setup.php";
Setup::registerAutoloadPEAR();

$debug = true;
$config = Setup::createAnnotationMetadataConfiguration(array(__DIR__."/classes"), $debug);


// Configuracao de acesso ao banco de dados
$conn = array(
    'driver' => 'pdo_mysql',
    'user' => 'root',
    'password' => '',
    'dbname' => 'chutabolao'
);

// Obtendo uma instancia do Entity Manager
$entityManager = \Doctrine\ORM\EntityManager::create($conn, $config);