<?php
require "bootstrap.php";

$dql = "SELECT c FROM Cidade c ORDER BY c.nome ASC";

$query = $entityManager->createQuery($dql);
$query->setMaxResults(30);

$cidades = $query->getResult();

foreach($cidades as $cidade) {
    echo $cidade->getId() . " - " . $cidade->getNome() . " - " . $cidade->getUf() . "<br/ >";
}
