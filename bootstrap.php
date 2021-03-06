<?php

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

require_once "classes/Admin.php";
require_once "classes/Log.php";
require_once "classes/Usuario.php";
require_once "classes/PremiosUsuario.php";
require_once "classes/Aposta.php";
require_once "classes/Time.php";
require_once "classes/Pais.php";
require_once "classes/Jogo.php";
require_once "classes/Rodada.php";
require_once "classes/Campeonato.php";
require_once "classes/RendimentoTime.php";
require_once "classes/PontuacaoRodada.php";
require_once "classes/PontuacaoGeral.php";
require_once "classes/ContadorAposta.php";

//require_once "Doctrine/ORM/Tools/Setup.php";
//Setup::registerAutoloadPEAR();

require_once 'Doctrine/Common/ClassLoader.php';
$loader = new \Doctrine\Common\ClassLoader("Doctrine");
$loader->register();

// Configuracao de acesso ao banco de dados
$conn = array(
    'driver' => 'pdo_mysql',
    'user' => 'chutabol_admin',
    'password' => 'corporativa10',
    'dbname' => 'chutabol_facebook'
);

$debug = true;
$path = array(__DIR__."/classes");
$config = Setup::createAnnotationMetadataConfiguration($path, $debug);

// Obtendo uma instancia do Entity Manager
$entityManager = \Doctrine\ORM\EntityManager::create($conn, $config);
set_time_limit(300);
