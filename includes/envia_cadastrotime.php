<?php
require 'bootstrap.php';
require 'time.php';

$time = new time($_GET['nome']);
$entityManager->persist($time);
$entityManager->flush();

echo "inserido time com o nome {$time->getNome()}";
