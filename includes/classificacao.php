<?php
require 'bootstrap.php';
$conn = $entityManager->getConnection();
$conn->beginTransaction();
try{

$dql = "SELECT c FROM Campeonato c WHERE c.status='ativo' ";
$query= $entityManager->createQuery($dql);
$campeonatos= $query->getResult();

if($campeonatos<>NULL){
	foreach ($campeonatos as $campeonato)	{
			$dql = "SELECT r FROM RendimentoTime r WHERE r.campeonato=".$campeonato->getCodCampeonato()."ORDER BY r.classificacao" ;
			$query= $entityManager->createQuery($dql);
			$rendimentosTimes= $query->getResult();
				
if ($rendimentosTimes<>NULL) {
	  	
	echo "<table id='tabela' align='center' cellspacing=0 >
				<td id='aposta'align='center' colspan='11'>
					Ranking ".$campeonato->getNomeCampeonato()." ".$campeonato->getAnoCampeonato()."
				</td class=\"coluna\">
			<tr align='center'class=\"linha\" >
					<td >
						Classificacao 
					</td class=\"coluna\">
					<td>
						Time
					</td class=\"coluna\">
					<td >
						
					</td class=\"coluna\">
			
					<td >
						PG
					</td class=\"coluna\">
					<td>
						Jg
					</td class=\"coluna\">
					<td >
						Vt
					</td class=\"coluna\">
					<td >
						Ep
					</td class=\"coluna\">
                    <td >
						De
					</td class=\"coluna\">
			 		<td >
						GP
					</td class=\"coluna\">
				    <td >
						GC
					</td class=\"coluna\">
					<td >
						SG
					</td class=\"coluna\">
						
			</tr>	";

	    foreach($rendimentosTimes as $rendimentoTimes){	   
	    	
	    		    	
		echo "	<tr class=\"linha\" align='center'>
			   		<td class=\"coluna\">"
			    		.$rendimentoTimes->getClassificacao()."
			    	</td>
			    	<td class=\"coluna\">"
			    		.$rendimentoTimes->getTime()->getNomeTime()."
			    	</td>
			    	<td class=\"coluna\">	
			    		<img class=\"escudo\" src=".$rendimentoTimes->getTime()->getEscudo().">
			    	</td>
			    	<td class=\"coluna\">"
						.$rendimentoTimes->getPontos()."
			    	</td>
			    	<td class=\"coluna\">"
			    		.$rendimentoTimes->getQuantidadeJogos()."			    	
					</td>
			    	<td class=\"coluna\">"
						.$rendimentoTimes->getVitorias()."
			    	</td>
			    	<td class=\"coluna\">"
						.$rendimentoTimes->getEmpates()."
			    	</td>
			    	<td class=\"coluna\">"
						.$rendimentoTimes->getDerrotas()."
			    	</td>
			    	<td class=\"coluna\">"
						.$rendimentoTimes->getGolsPro()."
			    	</td>
			    	<td class=\"coluna\">"
						.$rendimentoTimes->getGolsContra()."
			    	</td>
			    	<td class=\"coluna\">"
						.$rendimentoTimes->getSaldoDeGols()."
			    	</td>			    	
			    </tr>";
	
	    }	

					echo "</table><br>";
	}
					}
		
}

$conn->commit();
} catch(Exception $e) {
	$conn->rollback();

	echo
		"<p align='center'>
		<table id='tabela'>
		<tr class=\"linha\">
		<td class=\"coluna\">
		<p align='center'>Não existem dados a serem exibidos. Volte amanhã para conferir.</p>
		</td>
		</tr>
		</table>";
	}
	$conn->close();

	


       ?>