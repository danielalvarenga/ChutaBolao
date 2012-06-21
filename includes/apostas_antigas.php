 <?php
require ("bootstrap.php");


$conn = $entityManager->getConnection();
$conn->beginTransaction();
try{
/*	$dataAgora = new DateTime('now', new DateTimeZone('America/Sao_Paulo'));
	$dataAtual = $dataAgora->format( "Y-m-d H:i:s" );
	*/
	$dql = "SELECT c FROM Campeonato c WHERE c.status='ativo' ";
	$query= $entityManager->createQuery($dql);
	$campeonatos= $query->getResult();
	
	if($campeonatos<>NULL){
 
		$opcaoVazia=' ';
		$imprimeLetraX= "X";
	    
		foreach ($campeonatos as $campeonato){
			
			//Essa parte do codigo busca os jogos cadastradas dentro do banco de dados.
		
			$dql = "SELECT a FROM Aposta a WHERE a.campeonato=".$campeonato->getCodCampeonato()." AND a.usuario=".$user_id;
			$query = $entityManager->createQuery($dql);
			$apostas = $query->getResult();
		
			//Aqui esta testando se a busca voltou com algum jogo ou nao
		if ($apostas<>NULL){
					echo 
					'<br>
				<table id="tabela" cellspacing=0>
					<td id="aposta" align="center" colspan="7">'
						.$campeonato->getNomeCampeonato().' '.$campeonato->getAnoCampeonato().'
					</td>';
					
						// Essa parte do codigo busca aposta do usuario de acordo com o numero do
						//jogo cadastradas dentro do banco de dados.
			
	foreach ($apostas as $aposta){	//Aqui esta buscando os nomes dos times do jogo
						$time = $entityManager->find("Time", $aposta->getJogo()->getCodtime1());
						$time1 = $time->getNomeTime();
						$escudo1 = $time->getEscudo();
						
						//Aqui esta buscando os nomes dos times do jogo
						$time = $entityManager->find("Time", $aposta->getJogo()->getCodtime2());
						$time2 = $time->getNomeTime();
						$escudo2 = $time->getEscudo();
						
						//Aqui esta testando se a busca voltou com alguma aposta ou nao
						
							echo "
							<tr>
								<td class=\"data\" align='center' colspan='7' >
									".$aposta->getJogo()->getDataLogica()."
								</td>
							</tr>
							<tr class=\"linha\" align='center'>
								<td class=\"coluna\" align=\"right\">
									$time1
								</td>
								<td class=\"coluna\">
									<img class=\"escudo\" src='$escudo1'>
								</td>
								<td class=\"coluna\">										"
									.$aposta->getApostaGolsTime1();
										echo "
								</td>
								<td class=\"coluna\">
									$imprimeLetraX
								</td>
								<td class=\"coluna\">   
									".$aposta->getApostaGolsTime2();
										
										echo "
								</td>
								<td class=\"coluna\">
									<img class=\"escudo\" src='$escudo2'>
								</td>
								<td class=\"coluna\" align=\"left\">
									$time2
								</td>
							</tr>";

								}
		echo "
	</table>";
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
	<p align='center'>Não existem apostas cadastradas. Volte amanhã para conferir.</p>
	</td>
	</tr>
	</table>";
}
$conn->close();

?>
