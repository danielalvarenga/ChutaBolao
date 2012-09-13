<?php
require "bootstrap.php";
require "desfaz-funcoes-insere-gols.php";

if (isset($_GET['jogo'])) {
	
	$jogo = buscaObjeto("Jogo", $_GET['jogo']);
	$time1 = buscaObjeto("Time", $jogo->getCodTime1());
	$time2 = buscaObjeto("Time", $jogo->getCodTime2());
	$golsTime1=$jogo->getGolstime1();	
	$golsTime2=$jogo->getGolstime2();
	$numRodada = $jogo->getRodada()->getNumRodada();
		
		$conn = $entityManager->getConnection();
		$conn->beginTransaction();
		try{
			
		//Atualização do rendimento dos times --------------------------------
			
			$golsPro1 = $golsTime1;
			$golsContra1 = $golsTime2;
			desfazAtualizaRendimentoTime($jogo, $time1, $golsPro1, $golsContra1);
			
			$golsPro2 = $golsTime2;
			$golsContra2 = $golsTime1;
			desfazAtualizaRendimentoTime($jogo, $time2, $golsPro2, $golsContra2);
			
		//--------------------------------------------------------------------
			$codJogo = $jogo->getCodJogo();
			$dql = "SELECT a FROM Aposta a WHERE a.jogo = '$codJogo'";
			$apostas = consultaDql($dql);
			
			
			foreach ($apostas as $aposta){
				if ($aposta instanceof Aposta){
					
					//Atualiza PremiosUsuario do Usuário no Campeonato
					$premiosUsuario = buscaObjeto("PremiosUsuario", array(
						"campeonato" =>	$jogo->getCampeonato()->getCodCampeonato(),
						"usuario" => $aposta->getUsuario()->getIdUsuario()
					));
					$premiosUsuario->subtraiCalculaPontos($aposta->getPontosAposta());
					atualizaBancoDados($premiosUsuario);
					
					//Atualiza Pontos de cada Usuário na Rodada
					
					$pontuacaoRodada = buscaObjeto("PontuacaoRodada", array(
							"campeonato" =>	$jogo->getCampeonato()->getCodCampeonato(),
							"rodada" => $numRodada,
							"usuario" => $aposta->getUsuario()->getIdUsuario()
					));
					$pontosAposta = $aposta->getPontosAposta();
					if($pontuacaoRodada instanceof PontuacaoRodada){
						$pontuacaoRodada->subtraiPontosRodada($pontosAposta);
						atualizaBancoDados($pontuacaoRodada);
					}
					
					//Atualiza PontosGeral de cada Usuário
					
					$pontuacaoGeral = buscaObjeto("PontuacaoGeral", $aposta->getUsuario()->getIdUsuario());
					$pontuacaoGeral->subtraiPontosGeral($pontosAposta);
					atualizaBancoDados($pontuacaoGeral);
					$aposta->desfazPontosAposta();
					atualizaBancoDados($aposta);
						
				} else {
					echo "NÃO EXISTEM APOSTAS PARA ESTE JOGO";
				}
			}
			
			desfazVerificaFimRodada($numRodada, $jogo);
			desfazVerificaFinalCampeonato($numRodada, $jogo);
			// Atualiza resultado do jogo com os gols
			atualizaClassificacaoPontosGeral();
			atualizaClassificacaoPontosCampeonato($jogo);
			atualizaClassificacaoPontosRodada($numRodada, $jogo);
				
			$golsTime1 = NULL ;
			$golsTime2 = NULL ;
			
			$jogo->setResultado($golsTime1, $golsTime2);
			atualizaBancoDados($jogo);
				
			
			$conn->commit();
		} catch(Exception $e) {
			$conn->rollback();
			$conn->close();
			$mensagem = $e->getMessage();
			$codCampeonato = $jogo->getCampeonato()->getCodCampeonato();
			$tipo = $_GET['tipo'];
			
			echo("<script>
					alert(\"Não foi possível gravar os dados.\n$mensagem\");
					location.href='cadastra-jogo3.php?campeonato=$codCampeonato&tipo=$tipo&rodada=$numRodada';
					</script>");
		}
		$conn->close();
		
	}
	$codCampeonato = $jogo->getCampeonato()->getCodCampeonato();
	$tipo = $_GET['tipo'];
	
	echo("<script>
			alert(\"O resultado do Jogo e todas as apostas foram desfeitas.\");
			location.href='cadastra-jogo3.php?campeonato=$codCampeonato&tipo=$tipo&rodada=$numRodada';
		</script>");

?>
