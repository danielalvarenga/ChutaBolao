<?php
require "../bootstrap.php";
require "../funcoes-insere-gols.php";

// INCLUSÂO DE INFORMAÇÔES PARA TESTE 

// Para Aposta
$palpite_time1_jogo = 89;
$palpite_time2_jogo = 88;

//Para Resultado do Jogo
$golsTime1 = 89;
$golsTime2 = 88;

//Para testar finalização do Campeonato
$finalizaRodada = true;
$finalizaCampeonato = true;

$enter = "<br/>";

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
		$quant = "2";
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
		
		$rodada = $rodada1;
		if($finalizaCampeonato){
			$rodada = $rodada2;
		}
		
		$codTime1 = $time1->getCodTime();
		$codTime2 = $time2->getCodTime();
		$urlEscudosJogo = 'imagens/teste/jogo-teste.png';
		
		$dataJogo = new DateTime('now', new DateTimeZone('America/Sao_Paulo'));
		$dataJogo->add(new DateInterval( "P2D" ) );
		$dataJogo->setTime( 00, 00, 00 );
		$data = $dataJogo->format( "Y-m-d H:i:s" );		
		
		$jogo = new Jogo($data,$rodada,$codTime1,$codTime2, $campeonato, $urlEscudosJogo);
		salvaBancoDados($jogo);
		
		$jogo2 = new Jogo($data,$rodada,$codTime2,$codTime1, $campeonato, $urlEscudosJogo);
		salvaBancoDados($jogo2);
	
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

	
	// CADASTRA USUARIO QUE ACERTA O PLACAR -------------------------------------------------------------------------------
	$conn = $entityManager->getConnection();
	$conn->beginTransaction();
	try{
		$user_id = "100000885523518";
		$primeiroNomeUsuario = 'Usuario que Acerta o Placar';
		$segundoNomeUsuario = 'Silva Beltrano';
		$emailUsuario = 'email-teste@hotmail.com';
		$tokenUsuario = 'AAADUkCMlzxoBAAde2WKyZAMFkBgDMxuGcNoXsZB37g3eiPRVGe2nQXTIbN0StDRO2Bh4xf2mCHZBfOSQOp9qbAbpFMhqp2amsijqxK5GhLnMfRr8Ycl';
		
		$usuario1 = new Usuario($user_id, $tokenUsuario, $primeiroNomeUsuario, $segundoNomeUsuario, $emailUsuario);
		salvaBancoDados($usuario1);
		
		$pontuacaoGeral1 = new PontuacaoGeral($usuario1);
		salvaBancoDados($pontuacaoGeral1);
	
		$conn->commit();
	} catch(Exception $e) {
		$conn->rollback();
		echo $e->getMessage() . "<br/><font color=red>Erro na gravação do usuário uqe acerta o placar.</font><br/>";
	}
	
	// CADASTRA USUARIO QUE ACERTA TIME GANHADOR -------------------------------------------------------------------------------
	$conn = $entityManager->getConnection();
	$conn->beginTransaction();
	try{
		$user_id = "100000885523519";
		$primeiroNomeUsuario = 'Usuario que Acerta Time Ganhador';
		$segundoNomeUsuario = 'Silva Beltrano';
		$emailUsuario = 'email-teste@hotmail.com';
		$tokenUsuario = 'AAADUkCMlzxoBAAde2WKyZAMFkBgDMxuGcNoXsZB37g3eiPRVGe2nQXTIbN0StDRO2Bh4xf2mCHZBfOSQOp9qbAbpFMhqp2amsijqxK5GhLnMfRr8Ycl';
	
		$usuario2 = new Usuario($user_id, $tokenUsuario, $primeiroNomeUsuario, $segundoNomeUsuario, $emailUsuario);
		salvaBancoDados($usuario2);
	
		$pontuacaoGeral2 = new PontuacaoGeral($usuario2);
		salvaBancoDados($pontuacaoGeral2);
	
		$conn->commit();
	} catch(Exception $e) {
		$conn->rollback();
		echo $e->getMessage() . "<br/><font color=red>Erro na gravação do usuário que erra o placar.</font><br/>";
	}
	
	// CADASTRA USUARIO QUE ACERTA PLACAR INVERTIDO -------------------------------------------------------------------------------
	$conn = $entityManager->getConnection();
	$conn->beginTransaction();
	try{
		$user_id = "100000885523520";
		$primeiroNomeUsuario = 'Usuario que Acerta o Placar Invertido';
		$segundoNomeUsuario = 'Silva Beltrano';
		$emailUsuario = 'email-teste@hotmail.com';
		$tokenUsuario = 'AAADUkCMlzxoBAAde2WKyZAMFkBgDMxuGcNoXsZB37g3eiPRVGe2nQXTIbN0StDRO2Bh4xf2mCHZBfOSQOp9qbAbpFMhqp2amsijqxK5GhLnMfRr8Ycl';
	
		$usuario3 = new Usuario($user_id, $tokenUsuario, $primeiroNomeUsuario, $segundoNomeUsuario, $emailUsuario);
		salvaBancoDados($usuario3);
	
		$pontuacaoGeral3 = new PontuacaoGeral($usuario3);
		salvaBancoDados($pontuacaoGeral3);
	
		$conn->commit();
	} catch(Exception $e) {
		$conn->rollback();
		echo $e->getMessage() . "<br/><font color=red>Erro na gravação do usuário que erra o placar.</font><br/>";
	}
	
	// CADASTRA USUARIO QUE ERRA O PLACAR -------------------------------------------------------------------------------
	$conn = $entityManager->getConnection();
	$conn->beginTransaction();
	try{
		$user_id = "100000885523521";
		$primeiroNomeUsuario = 'Usuario que Erra o Placar';
		$segundoNomeUsuario = 'Silva Beltrano';
		$emailUsuario = 'email-teste@hotmail.com';
		$tokenUsuario = 'AAADUkCMlzxoBAAde2WKyZAMFkBgDMxuGcNoXsZB37g3eiPRVGe2nQXTIbN0StDRO2Bh4xf2mCHZBfOSQOp9qbAbpFMhqp2amsijqxK5GhLnMfRr8Ycl';
	
		$usuario4 = new Usuario($user_id, $tokenUsuario, $primeiroNomeUsuario, $segundoNomeUsuario, $emailUsuario);
		salvaBancoDados($usuario4);
	
		$pontuacaoGeral4 = new PontuacaoGeral($usuario4);
		salvaBancoDados($pontuacaoGeral4);
	
		$conn->commit();
	} catch(Exception $e) {
		$conn->rollback();
		echo $e->getMessage() . "<br/><font color=red>Erro na gravação do usuário que erra o placar.</font><br/>";
	}

	
	// CADASTRA APOSTAS DE TESTE -------------------------------------------------------------------------------
	$conn = $entityManager->getConnection();
	$conn->beginTransaction();
	try{
		
		//Placar Correto para Usuario 1
		$pontuacaoRodada1 = new PontuacaoRodada($rodada, $campeonato, $usuario1);
		salvaBancoDados($pontuacaoRodada1);
		
		$premiosUsuario1 = new PremiosUsuario($usuario1, $campeonato);
		salvaBancoDados($premiosUsuario1);
		
		$aposta1 = new Aposta($usuario1, $campeonato, $jogo);
		$placarApostado1 = $palpite_time1_jogo."  X  ".$palpite_time2_jogo;
		$aposta1->setApostaGolsTime1($palpite_time1_jogo);
		$aposta1->setApostaGolsTime2($palpite_time2_jogo);
		salvaBancoDados($aposta1);
		
		$contadorAposta1= new ContadorAposta($placarApostado1, $campeonato, $jogo);
		salvaBancoDados($contadorAposta1);
		
		
		//Time Ganhador para Usuario 2
		$pontuacaoRodada2 = new PontuacaoRodada($rodada, $campeonato, $usuario2);
		salvaBancoDados($pontuacaoRodada2);
		
		$premiosUsuario2 = new PremiosUsuario($usuario2, $campeonato);
		salvaBancoDados($premiosUsuario2);
		
		$aposta2 = new Aposta($usuario2, $campeonato, $jogo);
		$placarApostado2 = 2+$palpite_time1_jogo."  X  ".$palpite_time2_jogo+2;
		$aposta2->setApostaGolsTime1($palpite_time1_jogo+2);
		$aposta2->setApostaGolsTime2($palpite_time2_jogo+2);
		salvaBancoDados($aposta2);
		
		$contadorAposta2= new ContadorAposta($placarApostado2, $campeonato, $jogo);
		salvaBancoDados($contadorAposta2);
		
		
		//Placar Invertido para Usuario 3
		$pontuacaoRodada3 = new PontuacaoRodada($rodada, $campeonato, $usuario3);
		salvaBancoDados($pontuacaoRodada3);
		
		$premiosUsuario3 = new PremiosUsuario($usuario3, $campeonato);
		salvaBancoDados($premiosUsuario3);
		
		$aposta3 = new Aposta($usuario3, $campeonato, $jogo);
		$placarApostado3 = $palpite_time2_jogo."  X  ".$palpite_time1_jogo;
		$aposta3->setApostaGolsTime1($palpite_time2_jogo);
		$aposta3->setApostaGolsTime2($palpite_time1_jogo);
		salvaBancoDados($aposta3);
		
		$contadorAposta3= new ContadorAposta($placarApostado3, $campeonato, $jogo);
		salvaBancoDados($contadorAposta3);
		
		
		//Placar Errado para Usuario 4
		$pontuacaoRodada4 = new PontuacaoRodada($rodada, $campeonato, $usuario4);
		salvaBancoDados($pontuacaoRodada4);
		
		$premiosUsuario4 = new PremiosUsuario($usuario4, $campeonato);
		salvaBancoDados($premiosUsuario4);
		
		$aposta4 = new Aposta($usuario4, $campeonato, $jogo);
		$golsErrados1 = $palpite_time1_jogo-2;
		$golsErrados2 = $palpite_time2_jogo-2;
		$placarApostado4 = $golsErrados2."  X  ".$golsErrados1;
		$aposta4->setApostaGolsTime1($golsErrados2);
		$aposta4->setApostaGolsTime2($golsErrados1);
		salvaBancoDados($aposta4);
		
		$contadorAposta4= new ContadorAposta($placarApostado4, $campeonato, $jogo);
		salvaBancoDados($contadorAposta4);
		
		$conn->commit();
	} catch(Exception $e) {
		$conn->rollback();
		echo $e->getMessage() . "<br/><font color=red>Erro na gravação de aposta.</font><br/>";
	}

	
	
	// CADASTRA GOLS DE TESTE -------------------------------------------------------------------------------
	$conn = $entityManager->getConnection();
	$conn->beginTransaction();
	try{
		if($finalizaRodada){
			$jogo2->setResultado(2, 1);
			atualizaBancoDados($jogo2);
		}
		if($finalizaCampeonato){
			$jogo2->setResultado(2, 1);
			atualizaBancoDados($jogo2);
		}
		
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
				
				$premiosUsuario = $entityManager->find("PremiosUsuario", array(
						"campeonato" =>	$jogo->getCampeonato()->getCodCampeonato(),
						"usuario" => $aposta->getUsuario()->getIdUsuario()
				));
				$premiosUsuario->calculaPontos($aposta->getPontosAposta());
				atualizaBancoDados($premiosUsuario);
				
				$pontuacaoRodada = $entityManager->find("PontuacaoRodada", array(
						"campeonato" =>	$jogo->getCampeonato()->getCodCampeonato(),
						"rodada" => $numRodada,
						"usuario" => $aposta->getUsuario()->getIdUsuario()
				));
				$pontuacaoRodada->calculaPontosRodada($aposta->getPontosAposta());
				atualizaBancoDados($pontuacaoRodada);
				
				$pontuacaoGeral = $entityManager->find("PontuacaoGeral", $aposta->getUsuario()->getIdUsuario());
				$pontuacaoGeral->calculaPontosGeral($aposta->getPontosAposta());
				atualizaBancoDados($pontuacaoGeral);
			}
		}
			
		atualizaClassificacaoPontosGeral();
		atualizaClassificacaoPontosCampeonato($jogo);
		atualizaClassificacaoPontosRodada($numRodada, $jogo);
		verificaFimRodada($numRodada, $jogo);
		verificaFinalCampeonato($numRodada, $jogo);
		
		//EXIBE INFORMAÇÔES PARA ANÁLISE DE ERROS
		echo 'Rodada '.$rodada->getNumRodada().' '.$rodada->getStatus().$enter;
		echo $campeonato->getNomeCampeonato().' '.$campeonato->getStatus().$enter.$enter;
		
		echo $enter.$usuario1->getPrimeiroNomeUsuario().$enter.$enter;
		echo 'Classificação Geral Pontos: '.$pontuacaoGeral1->getClassificacaoGeral().$enter;
		echo 'Classificação Geral Medalhas: '.$pontuacaoGeral1->getClassificacaoMedalhasGeral().$enter;
		echo 'Acertos Placar: '.$pontuacaoGeral1->getAcertosPlacarGeral().$enter;
		echo 'Acertos Invertidos: '.$pontuacaoGeral1->getAcertosPlacarInvertidoGeral().$enter;
		echo 'Acertos Time: '.$pontuacaoGeral1->getAcertosTimeGanhadorGeral().$enter;
		echo 'Pontos Geral: '.$pontuacaoGeral1->getPontosGeral().$enter;
		echo 'Medalhas Ouro Geral: '.$pontuacaoGeral1->getMedalhasOuroGeral().$enter;
		echo 'Medalhas Prata Geral: '.$pontuacaoGeral1->getMedalhasPrataGeral().$enter;
		echo 'Medalhas Bronze Geral: '.$pontuacaoGeral1->getMedalhasBronzeGeral().$enter;
		echo 'Trofeus Geral: '.$pontuacaoGeral1->getTrofeus().$enter.$enter;
		
		echo 'Classificação Pontos Campeonato: '.$premiosUsuario1->getClassificacaoCampeonato().$enter;
		echo 'Classificação Medalhas Campeonato: '.$premiosUsuario1->getClassificacaoMedalhas().$enter;
		echo 'Acertos Placar Campeonato: '.$premiosUsuario1->getAcertosPlacar().$enter;
		echo 'Acertos Invertidos Campeonato: '.$premiosUsuario1->getAcertosPlacarInvertido().$enter;
		echo 'Acertos Time Campeonato: '.$premiosUsuario1->getAcertosTimeGanhador().$enter;
		echo 'Pontos Campeonato: '.$premiosUsuario1->getPontosCampeonato().$enter;
		echo 'Medalhas Ouro Campeonato: '.$premiosUsuario1->getMedalhasOuro().$enter;
		echo 'Medalhas Prata Campeonato: '.$premiosUsuario1->getMedalhasPrata().$enter;
		echo 'Medalhas Bronze Campeonato: '.$premiosUsuario1->getMedalhasBronze().$enter;
		echo 'Trofeu Campeonato: '.$premiosUsuario1->getTrofeu().$enter;
		
		
		
		echo $enter.$usuario2->getPrimeiroNomeUsuario().$enter.$enter;
		echo 'Classificação Geral Pontos: '.$pontuacaoGeral2->getClassificacaoGeral().$enter;
		echo 'Classificação Geral Medalhas: '.$pontuacaoGeral2->getClassificacaoMedalhasGeral().$enter;
		echo 'Acertos Placar: '.$pontuacaoGeral2->getAcertosPlacarGeral().$enter;
		echo 'Acertos Invertidos: '.$pontuacaoGeral2->getAcertosPlacarInvertidoGeral().$enter;
		echo 'Acertos Time: '.$pontuacaoGeral2->getAcertosTimeGanhadorGeral().$enter;
		echo 'Pontos Geral: '.$pontuacaoGeral2->getPontosGeral().$enter;
		echo 'Medalhas Ouro Geral: '.$pontuacaoGeral2->getMedalhasOuroGeral().$enter;
		echo 'Medalhas Prata Geral: '.$pontuacaoGeral2->getMedalhasPrataGeral().$enter;
		echo 'Medalhas Bronze Geral: '.$pontuacaoGeral2->getMedalhasBronzeGeral().$enter;
		echo 'Trofeus Geral: '.$pontuacaoGeral2->getTrofeus().$enter.$enter;
		
		echo 'Classificação Pontos Campeonato: '.$premiosUsuario2->getClassificacaoCampeonato().$enter;
		echo 'Classificação Medalhas Campeonato: '.$premiosUsuario2->getClassificacaoMedalhas().$enter;
		echo 'Acertos Placar Campeonato: '.$premiosUsuario2->getAcertosPlacar().$enter;
		echo 'Acertos Invertidos Campeonato: '.$premiosUsuario2->getAcertosPlacarInvertido().$enter;
		echo 'Acertos Time Campeonato: '.$premiosUsuario2->getAcertosTimeGanhador().$enter;
		echo 'Pontos Campeonato: '.$premiosUsuario2->getPontosCampeonato().$enter;
		echo 'Medalhas Ouro Campeonato: '.$premiosUsuario2->getMedalhasOuro().$enter;
		echo 'Medalhas Prata Campeonato: '.$premiosUsuario2->getMedalhasPrata().$enter;
		echo 'Medalhas Bronze Campeonato: '.$premiosUsuario2->getMedalhasBronze().$enter;
		echo 'Trofeu Campeonato: '.$premiosUsuario2->getTrofeu().$enter;
		
		
		echo $enter.$usuario3->getPrimeiroNomeUsuario().$enter.$enter;
		echo 'Classificação Geral Pontos: '.$pontuacaoGeral3->getClassificacaoGeral().$enter;
		echo 'Classificação Geral Medalhas: '.$pontuacaoGeral3->getClassificacaoMedalhasGeral().$enter;
		echo 'Acertos Placar: '.$pontuacaoGeral3->getAcertosPlacarGeral().$enter;
		echo 'Acertos Invertidos: '.$pontuacaoGeral3->getAcertosPlacarInvertidoGeral().$enter;
		echo 'Acertos Time: '.$pontuacaoGeral3->getAcertosTimeGanhadorGeral().$enter;
		echo 'Pontos Geral: '.$pontuacaoGeral3->getPontosGeral().$enter;
		echo 'Medalhas Ouro Geral: '.$pontuacaoGeral3->getMedalhasOuroGeral().$enter;
		echo 'Medalhas Prata Geral: '.$pontuacaoGeral3->getMedalhasPrataGeral().$enter;
		echo 'Medalhas Bronze Geral: '.$pontuacaoGeral3->getMedalhasBronzeGeral().$enter;
		echo 'Trofeus Geral: '.$pontuacaoGeral3->getTrofeus().$enter.$enter;
		
		echo 'Classificação Pontos Campeonato: '.$premiosUsuario3->getClassificacaoCampeonato().$enter;
		echo 'Classificação Medalhas Campeonato: '.$premiosUsuario3->getClassificacaoMedalhas().$enter;
		echo 'Acertos Placar Campeonato: '.$premiosUsuario3->getAcertosPlacar().$enter;
		echo 'Acertos Invertidos Campeonato: '.$premiosUsuario3->getAcertosPlacarInvertido().$enter;
		echo 'Acertos Time Campeonato: '.$premiosUsuario3->getAcertosTimeGanhador().$enter;
		echo 'Pontos Campeonato: '.$premiosUsuario3->getPontosCampeonato().$enter;
		echo 'Medalhas Ouro Campeonato: '.$premiosUsuario3->getMedalhasOuro().$enter;
		echo 'Medalhas Prata Campeonato: '.$premiosUsuario3->getMedalhasPrata().$enter;
		echo 'Medalhas Bronze Campeonato: '.$premiosUsuario3->getMedalhasBronze().$enter;
		echo 'Trofeu Campeonato: '.$premiosUsuario3->getTrofeu().$enter;
		
		echo $enter.$usuario4->getPrimeiroNomeUsuario().$enter.$enter;
		echo 'Classificação Geral Pontos: '.$pontuacaoGeral4->getClassificacaoGeral().$enter;
		echo 'Classificação Geral Medalhas: '.$pontuacaoGeral4->getClassificacaoMedalhasGeral().$enter;
		echo 'Acertos Placar: '.$pontuacaoGeral4->getAcertosPlacarGeral().$enter;
		echo 'Acertos Invertidos: '.$pontuacaoGeral4->getAcertosPlacarInvertidoGeral().$enter;
		echo 'Acertos Time: '.$pontuacaoGeral4->getAcertosTimeGanhadorGeral().$enter;
		echo 'Pontos Geral: '.$pontuacaoGeral4->getPontosGeral().$enter;
		echo 'Medalhas Ouro Geral: '.$pontuacaoGeral4->getMedalhasOuroGeral().$enter;
		echo 'Medalhas Prata Geral: '.$pontuacaoGeral4->getMedalhasPrataGeral().$enter;
		echo 'Medalhas Bronze Geral: '.$pontuacaoGeral4->getMedalhasBronzeGeral().$enter;
		echo 'Trofeus Geral: '.$pontuacaoGeral4->getTrofeus().$enter.$enter;
		
		echo 'Classificação Pontos Campeonato: '.$premiosUsuario4->getClassificacaoCampeonato().$enter;
		echo 'Classificação Medalhas Campeonato: '.$premiosUsuario4->getClassificacaoMedalhas().$enter;
		echo 'Acertos Placar Campeonato: '.$premiosUsuario4->getAcertosPlacar().$enter;
		echo 'Acertos Invertidos Campeonato: '.$premiosUsuario4->getAcertosPlacarInvertido().$enter;
		echo 'Acertos Time Campeonato: '.$premiosUsuario4->getAcertosTimeGanhador().$enter;
		echo 'Pontos Campeonato: '.$premiosUsuario4->getPontosCampeonato().$enter;
		echo 'Medalhas Ouro Campeonato: '.$premiosUsuario4->getMedalhasOuro().$enter;
		echo 'Medalhas Prata Campeonato: '.$premiosUsuario4->getMedalhasPrata().$enter;
		echo 'Medalhas Bronze Campeonato: '.$premiosUsuario4->getMedalhasBronze().$enter;
		echo 'Trofeu Campeonato: '.$premiosUsuario3->getTrofeu().$enter;
		
		//REMOVE TODOS OS OBJETOS
		
		$entityManager->remove($usuario1);
		$entityManager->remove($usuario2);
		$entityManager->remove($usuario3);
		$entityManager->remove($usuario4);
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