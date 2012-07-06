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
	
	$semChutes = false;
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
					echo'
				<table id="tabela" cellspacing=0>
					<td id="aposta" align="center" colspan="7">
					<h3>'.$campeonato->getNomeCampeonato().' '.$campeonato->getAnoCampeonato().'</h3>
					</td>';
					
						// Essa parte do codigo busca aposta do usuario de acordo com o numero do
						//jogo cadastradas dentro do banco de dados.
			
					foreach ($apostas as $aposta){	//Aqui esta buscando os nomes dos times do jogo
						$time = $entityManager->find("Time", $aposta->getJogo()->getCodTime1());
						$time1 = $time->getNomeTime();
						$escudo1 = $time->getEscudo();
						
						//Aqui esta buscando os nomes dos times do jogo
						$time = $entityManager->find("Time", $aposta->getJogo()->getCodTime2());
						$time2 = $time->getNomeTime();
						$escudo2 = $time->getEscudo();
						
						//Aqui esta testando se a busca voltou com alguma aposta ou nao
						
							echo "
							<tr>
								<td class=\"data\" align='center' colspan='7' >
									Realizado em ".$aposta->getJogo()->getDataLogica();
									if(($aposta->getJogo()->getGolsTime1() != NULL) && ($aposta->getJogo()->getGolsTime2() != NULL)){
										echo " - O RESULTADO REAL FOI ".$aposta->getJogo()->getGolsTime1()." X ".$aposta->getJogo()->getGolsTime2();
									}
									else{
										echo " - AGUARDANDO RESULTADO REAL...";
									}
								echo"
								</td>
							</tr>
							<tr class=\"linha\" align='center'>
								<td class=\"nomeTime\" align=\"right\">
									$time1
								</td>
								<td class=\"coluna\">
									<img class=\"escudo\" src='$escudo1'>
								</td>
								<td class=\"coluna\">"
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
								<td class=\"nomeTime\" align=\"left\">
									$time2
								</td>
							</tr>";

					}
				echo "
				</table>";
			}
			else{
				$semChutes = false;
			}				
		}
	}
	else{
		$semChutes = false;
	}
	if($semChutes){
		echo
		"<p align='center'>
		<table id='tabela'>
		<tr class=\"linha\">
		<td class=\"coluna\">
		<p class=\"aviso\" align='center'>Você ainda não deu seu chute em nenhum jogo.</p>
		</td>
		</tr>
		</table>";
	}

	$conn->commit();
} catch(Exception $e) {
	$conn->rollback();
	echo
	"<p align='center'>
	<table id='tabela'>
	<tr class=\"linha\">
	<td class=\"coluna\">
	<p class=\"aviso\" align='center'>Você ainda não deu seu chute em nenhum jogo.</p>
	</td>
	</tr>
	</table>";
}
$conn->close();

?>
