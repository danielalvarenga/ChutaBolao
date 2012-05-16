<?php

require "bootstrap.php";

$campeonato = new Campeonato();
$nome = $_POST['nome'];
$ano = $_POST['ano'];
$quant = $_POST['quant'];

$campeonato->setNomeCampeonato($nome);
$campeonato->setAnoCampeonato($ano);
$campeonato->setQuantidadeRodadas($quant);

$entityManager->persist($campeonato);
$entityManager->flush();

echo "Cidade criada com: ";
echo "Codigo: ".$campeonato->getCodCampeonato()."\n";
echo "Nome: ".$campeonato->getNomeCampeonato()."\n";
echo "Ano: ".$campeonato->getAnoCampeonato()."\n";
echo "Quantidade de rodadas: ".$campeonato->getQuantidadeRodadas()."\n";
