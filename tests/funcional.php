<?php
require "../bootstrap.php";
require "../funcoes-insere-gols.php";

// INCLUSÂO DE INFORMAÇÔES PARA TESTE 

// Para Jogo
$dataJogo = "2012-07-23 23:00:00";

// Para Aposta
$palpite_time1_jogo = 99;
$palpite_time2_jogo = 98;

//Para Resultado do Jogo
$golsTime1 = 99;
$golsTime2 = 98;

$conn = $entityManager->getConnection();
$conn->beginTransaction();
try{

	// CADASTRA TIMES DE TESTE -------------------------------------------------------------------------------
	$conn = $entityManager->getConnection();
	$conn->beginTransaction();
	try{
	
		$nome1 = "Time de Teste 1";
		$caminho_imagem1 = "imagens/teste/time1-teste.png";
		
		$time1 = new Time($nome1, $caminho_imagem1);
		salvaBancoDados($time1);
		
		$nome2 = "Time de Teste 2";
		$caminho_imagem2 = "imagens/teste/time2-teste.png";
		
		$time2 = new Time($nome2, $caminho_imagem2);
		salvaBancoDados($time2);
		
		$conn->commit();
	} catch(Exception $e) {
		$conn->rollback();
		echo $e->getMessage() . "<br/><font color=red>Erro na gravação dos times.</font><br/>";
	}
	
	
	// CADASTRA CAMPEONATO DE TESTE -------------------------------------------------------------------------------
	$conn = $entityManager->getConnection();
	$conn->beginTransaction();
	try{
		$nome = "Campeonato de Teste";
		$ano = "2012";
		$quant = "38";
		$caminho_imagem = "imagens/teste/campeonato-teste.png";
		
		$campeonato = new Campeonato($nome, $ano, $quant, $caminho_imagem);
		salvaBancoDados($campeonato);
		
		$conn->commit();
	} catch(Exception $e) {
		$conn->rollback();
		echo $e->getMessage() . "<br/><font color=red>Erro na gravação do campeonato.</font><br/>";
	}
	
		
	// CADASTRA RODADA DE TESTE -------------------------------------------------------------------------------
	$conn = $entityManager->getConnection();
	$conn->beginTransaction();
	try{	
		$rodada1 = new Rodada(1, $campeonato);
		salvaBancoDados($rodada1);
		
		$rodada2 = new Rodada(2, $campeonato);
		salvaBancoDados($rodada2);
		
		$conn->commit();
	} catch(Exception $e) {
		$conn->rollback();
		echo $e->getMessage() . "<br/><font color=red>Erro na gravação das rodadas.</font><br/>";
	}
	
	
	// CADASTRA JOGO DE TESTE -------------------------------------------------------------------------------
	$conn = $entityManager->getConnection();
	$conn->beginTransaction();
	try{
		$codTime1 = $time1->getCodTime();
		$codTime2 = $time2->getCodTime();
		$urlEscudosJogo = 'imagens/teste/jogo-teste.png';
		$data = $dataJogo;		
		
		$jogo = new Jogo($data,$rodada1,$codTime1,$codTime2, $campeonato, $urlEscudosJogo);
		salvaBancoDados($jogo);
	
		$conn->commit();
	} catch(Exception $e) {
		$conn->rollback();
		echo $e->getMessage() . "<br/><font color=red>Erro na gravação do jogo.</font><br/>";
	}
	
	
	// CADASTRA RENDIMENTOS DE TIMES DE TESTE -------------------------------------------------------------------------------
	$conn = $entityManager->getConnection();
	$conn->beginTransaction();
	try{
		$rendimentoTime1 = new RendimentoTime($campeonato, $time1);
		salvaBancoDados($rendimentoTime1);
		
		$rendimentoTime2 = new RendimentoTime($campeonato, $time2);
		salvaBancoDados($rendimentoTime2);
		
		$conn->commit();
	} catch(Exception $e) {
		$conn->rollback();
		echo $e->getMessage() . "<br/><font color=red>Erro na gravação do rendimentos de times.</font><br/>";
	}

	
	// CADASTRA USUARIO DE TESTE -------------------------------------------------------------------------------
	$conn = $entityManager->getConnection();
	$conn->beginTransaction();
	try{
		$user_id = "100000885523518";
		$primeiroNomeUsuario = 'Testador Fulano';
		$segundoNomeUsuario = 'Silva Beltrano';
		$emailUsuario = 'email-teste@hotmail.com';
		$tokenUsuario = 'AAADUkCMlzxoBAAde2WKyZAMFkBgDMxuGcNoXsZB37g3eiPRVGe2nQXTIbN0StDRO2Bh4xf2mCHZBfOSQOp9qbAbpFMhqp2amsijqxK5GhLnMfRr8Ycl';
		
		$usuario = new Usuario($user_id, $tokenUsuario, $primeiroNomeUsuario, $segundoNomeUsuario, $emailUsuario);
		$entityManager->persist($usuario);
		$entityManager->flush();
		
		$pontuacaoGeral = new PontuacaoGeral($usuario);
		$entityManager->persist($pontuacaoGeral);
		$entityManager->flush();
	
		$conn->commit();
	} catch(Exception $e) {
		$conn->rollback();
		echo $e->getMessage() . "<br/><font color=red>Erro na gravação do usuário.</font><br/>";
	}

	
	// CADASTRA APOSTAS DE TESTE -------------------------------------------------------------------------------
	$conn = $entityManager->getConnection();
	$conn->beginTransaction();
	try{
		$pontuacaoRodada = new PontuacaoRodada($rodada1, $campeonato, $usuario);
		salvaBancoDados($pontuacaoRodada);
		
		$premiosUsuario = new PremiosUsuario($usuario, $campeonato);
		salvaBancoDados($premiosUsuario);
		
		$aposta = new Aposta($usuario, $campeonato, $jogo);
		$placarApostado = $palpite_time1_jogo."  X  ".$palpite_time2_jogo;
		$aposta->setApostaGolsTime1($palpite_time1_jogo);
		$aposta->setApostaGolsTime2($palpite_time2_jogo);
		salvaBancoDados($aposta);
		
		$contadorAposta= new ContadorAposta($placarApostado, $campeonato, $jogo);
		salvaBancoDados($contadorAposta);
		
		$conn->commit();
	} catch(Exception $e) {
		$conn->rollback();
		echo $e->getMessage() . "<br/><font color=red>Erro na gravação de aposta.</font><br/>";
	}

	
	
	// CADASTRA GOLS DE TESTE -------------------------------------------------------------------------------
	$conn = $entityManager->getConnection();
	$conn->beginTransaction();
	try{
		$jogo->setResultado($golsTime1, $golsTime2);
		atualizaBancoDados($jogo);
			
		$golsPro1 = $golsTime1;
		$golsContra1 = $golsTime2;
		$rendimentoTime1->calculaRendimentoTime($golsPro1, $golsContra1);
		atualizaBancoDados($rendimentoTime1);
			
		$golsPro2 = $golsTime2;
		$golsContra2 = $golsTime1;
		$rendimentoTime2->calculaRendimentoTime($golsPro2, $golsContra2);
		atualizaBancoDados($rendimentoTime2);
			
		$numRodada = $jogo->getRodada()->getNumRodada();
		$codJogo = $jogo->getCodJogo();
		
		$dql = "SELECT a FROM Aposta a WHERE a.jogo = $codJogo";
		$apostas = consultaDql($dql);
			
		foreach ($apostas as $aposta){
			if ($aposta instanceof Aposta){
				$aposta->calculaPontosAposta($jogo->getGolsTime1(),$jogo->getGolsTime2());
				atualizaBancoDados($aposta);
					
				$premiosUsuario->calculaPontos($aposta->getPontosAposta());
				atualizaBancoDados($premiosUsuario);
					
				$pontuacaoRodada->calculaPontosRodada($aposta->getPontosAposta());
				atualizaBancoDados($pontuacaoRodada);
		
				$pontuacaoGeral->calculaPontosGeral($aposta->getPontosAposta());
				atualizaBancoDados($pontuacaoGeral);
			}
		}
			
		atualizaClassificacaoPontosGeral();
		atualizaClassificacaoPontosCampeonato($jogo);
		atualizaClassificacaoPontosRodada($numRodada, $jogo);
		verificaFimRodada($numRodada, $jogo);
		verificaFinalCampeonato($numRodada, $jogo);
		
		$entityManager->remove($usuario);
		$entityManager->remove($campeonato);
		$entityManager->remove($time1);
		$entityManager->remove($time2);
		$entityManager->flush();
		
		$conn->commit();
	} catch(Exception $e) {
		$conn->rollback();
		echo $e->getMessage() . "<br/><font color=red>Erro na gravação de resultados de gols.</font><br/>";
	}

	
	$conn->commit();
} catch(Exception $e) {
	$conn->rollback();
	echo $e->getMessage() . "<br/><font color=red>Erro na gravação de dados.</font><br/>";
}
$conn->close();
?>