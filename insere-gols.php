<?php
include "valida_cookies.inc";
require "bootstrap.php";
require "funcoes-insere-gols.php";


if (isset($_POST['jogo'])) {
	
	$jogo = buscaObjeto("Jogo", $_POST['jogo']);
	$time1 = buscaObjeto("Time", $jogo->getCodTime1());
	$time2 = buscaObjeto("Time", $jogo->getCodTime2());
		
	if(isset($_POST['golsTime1']) && isset($_POST['golsTime2'])){
		
		$conn = $entityManager->getConnection();
		$conn->beginTransaction();
		try{
		
		// Atualiza resultado do jogo com os gols
		
			$golsTime1 = $_POST['golsTime1'];
			$golsTime2 = $_POST['golsTime2'];
			
			$jogo->setResultado($golsTime1, $golsTime2);
			atualizaBancoDados($jogo);
			
		//Atualização do rendimento dos times --------------------------------
			
			$golsPro1 = $golsTime1;
			$golsContra1 = $golsTime2;
			atualizaRendimentoTime($jogo, $time1, $golsPro1, $golsContra1);
			
			$golsPro2 = $golsTime2;
			$golsContra2 = $golsTime1;
			atualizaRendimentoTime($jogo, $time2, $golsPro2, $golsContra2);
			
		//--------------------------------------------------------------------
			$numRodada = $jogo->getRodada()->getNumRodada();
			$codJogo = $jogo->getCodJogo();
			$dql = "SELECT a FROM Aposta a WHERE a.jogo = '$codJogo'";
			$apostas = consultaDql($dql);
			
			foreach ($apostas as $aposta){
				if ($aposta instanceof Aposta){
					$aposta->calculaPontosAposta($golsTime1, $golsTime2);
					atualizaBancoDados($aposta);
					
					//Atualiza PremiosUsuario do Usuário no Campeonato
					$premiosUsuario = buscaObjeto("PremiosUsuario", array(
						"campeonato" =>	$jogo->getCampeonato()->getCodCampeonato(),
						"usuario" => $aposta->getUsuario()->getIdUsuario()
					));
					$premiosUsuario->calculaPontos($aposta->getPontosAposta());
					atualizaBancoDados($premiosUsuario);
					
					//Atualiza Pontos de cada Usuário na Rodada
					
					$pontuacaoRodada = buscaObjeto("PontuacaoRodada", array(
							"campeonato" =>	$jogo->getCampeonato()->getCodCampeonato(),
							"rodada" => $numRodada,
							"usuario" => $aposta->getUsuario()->getIdUsuario()
					));
					$pontosAposta = $aposta->getPontosAposta();
					if($pontuacaoRodada instanceof PontuacaoRodada){
						$pontuacaoRodada->calculaPontosRodada($pontosAposta);
						atualizaBancoDados($pontuacaoRodada);
					}
					else{
						$campeonato = $jogo->getCampeonato();
						$usuario = $aposta->getUsuario();
						$rodada = $jogo->getRodada();
						$pontuacaoRodada = new PontuacaoRodada($rodada, $campeonato, $usuario);
						$pontuacaoRodada->calculaPontosRodada($pontosAposta);
						salvaBancoDados($pontuacaoRodada);
					}
					
					//Atualiza PontosGeral de cada Usuário
					
					$pontuacaoGeral = buscaObjeto("PontuacaoGeral", $aposta->getUsuario()->getIdUsuario());
					$pontuacaoGeral->calculaPontosGeral($aposta->getPontosAposta());
					atualizaBancoDados($pontuacaoGeral);
					
				} else {
					echo "NÃO EXISTEM APOSTAS PARA ESTE JOGO";
				}
			}
			
			atualizaClassificacaoPontosGeral();
			atualizaClassificacaoPontosCampeonato($jogo);
			atualizaClassificacaoPontosRodada($numRodada, $jogo);
			verificaFimRodada($numRodada, $jogo);
			verificaFinalCampeonato($numRodada, $jogo);
			
			$conn->commit();
		} catch(Exception $e) {
			$conn->rollback();
			$conn->close();
			$mensagem = $e->getMessage();
			echo("<script>
					alert(\"Não foi possível gravar os dados.\n$mensagem\");
					location.href='cadastra-jogo.php';
					</script>");
		}
		$conn->close();
		
	}
	echo("<script>
			alert(\"O resultado do Jogo e todas as apostas foram atualizadas.\");
			location.href='cadastra-jogo.php';
		</script>");
}
?>
