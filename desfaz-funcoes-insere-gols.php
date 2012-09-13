<?php
require 'funcoes-insere-gols.php';
require 'bootstrap.php';

	function desfazAtualizaRendimentoTime($jogo, $time, $golsPro, $golsContra){
			$rendimentoTime = buscaObjeto("RendimentoTime", $jogo->getCampeonato()->getCodCampeonato()."x".$time->getCodTime());
			$rendimentoTime->desfazCalculaRendimentoTime($golsPro, $golsContra);
			atualizaBancoDados($rendimentoTime);
		}
	function desfazAtribuiMedalhasOuro($numRodada, $jogo){
		global $entityManager;
			
		$dql = 'SELECT p FROM PontuacaoRodada p WHERE p.rodada = 4
							AND p.campeonato ='.$jogo->getCampeonato()->getCodCampeonato().'
							AND p.classificacaoRodada = 1 ';
		$pontuacoesRodada = consultaDql($dql);
		foreach ($pontuacoesRodada as $pontuacaoRodada){
			if($pontuacaoRodada instanceof PontuacaoRodada){
					
				$premiosUsuario = $entityManager->find("PremiosUsuario", array(
									"campeonato" =>	$pontuacaoRodada->getCampeonato()->getCodCampeonato(),
									"usuario" => $pontuacaoRodada->getUsuario()->getIdUsuario()
				));
				$pontuacaoGeral = $entityManager->find("PontuacaoGeral", $pontuacaoRodada->getUsuario()->getIdUsuario());
				$premiosUsuario->subtraiMedalhaOuro();
				$pontuacaoGeral->subtraiMedalhaOuroGeral();
				atualizaBancoDados($premiosUsuario);
				atualizaBancoDados($pontuacaoGeral);
					
			}
		}
	}
	function desfazAtribuiMedalhasPrata($numRodada, $jogo){
		global $entityManager;
			
		$dql = 'SELECT p FROM PontuacaoRodada p WHERE p.rodada = '.$numRodada.'
								AND p.campeonato ='.$jogo->getCampeonato()->getCodCampeonato().'
								AND p.classificacaoRodada = 2 ';
		$pontuacoesRodada = consultaDql($dql);
		foreach ($pontuacoesRodada as $pontuacaoRodada){
			if($pontuacaoRodada instanceof PontuacaoRodada){
					
				$premiosUsuario = $entityManager->find("PremiosUsuario", array(
										"campeonato" =>	$pontuacaoRodada->getCampeonato()->getCodCampeonato(),
										"usuario" => $pontuacaoRodada->getUsuario()->getIdUsuario()
				));
				$pontuacaoGeral = $entityManager->find("PontuacaoGeral", $pontuacaoRodada->getUsuario()->getIdUsuario());
				$premiosUsuario->subtraiMedalhaPrata();
				$pontuacaoGeral->subtraiMedalhaPrataGeral();
				atualizaBancoDados($premiosUsuario);
				atualizaBancoDados($pontuacaoGeral);
					
			}
		}
	}
	function desfazAtribuiMedalhasBronze($numRodada, $jogo){
		global $entityManager;
			
		$dql = 'SELECT p FROM PontuacaoRodada p WHERE p.rodada = '.$numRodada.'
								AND p.campeonato ='.$jogo->getCampeonato()->getCodCampeonato().'
								AND p.classificacaoRodada = 3 ';
		$pontuacoesRodada = consultaDql($dql);
		foreach ($pontuacoesRodada as $pontuacaoRodada){
			if($pontuacaoRodada instanceof PontuacaoRodada){
					
				$premiosUsuario = $entityManager->find("PremiosUsuario", array(
										"campeonato" =>	$pontuacaoRodada->getCampeonato()->getCodCampeonato(),
										"usuario" => $pontuacaoRodada->getUsuario()->getIdUsuario()
				));
				$pontuacaoGeral = $entityManager->find("PontuacaoGeral", $pontuacaoRodada->getUsuario()->getIdUsuario());
				$premiosUsuario->subtraiMedalhaBronze();
				$pontuacaoGeral->subtraiMedalhaBronzeGeral();
				atualizaBancoDados($premiosUsuario);
				atualizaBancoDados($pontuacaoGeral);
					
			}
		}
	}
	
	function desfazVerificaFimRodada($numRodada, $jogo){
		$campeonato = $jogo->getCampeonato()->getCodCampeonato();
		$dql = "SELECT j FROM Jogo j WHERE j.rodada = '$numRodada'
						AND j.campeonato = '$campeonato'
						ORDER BY j.golsTime1 ASC";
		$jogos = consultaDqlMaxResult(1, $dql);
			
		foreach ($jogos as $jogo){
			$golsTime1 = $jogo->getGolstime1();
			$golsTime2 = $jogo->getGolstime2();
			if(!(($golsTime1 === NULL) && ($golsTime2 === NULL))){
			desfazAtribuiMedalhasRodada($numRodada, $jogo);
				$rodada = buscaObjeto("Rodada", array(
										"numRodada" => $numRodada,
										"campeonato" => $campeonato));
				$rodada->ativaStatus();
				atualizaBancoDados($rodada);
				
			}
		}
	}	
		function desfazVerificaFinalCampeonato($numRodada, $jogo){
			if($numRodada == $jogo->getCampeonato()->getQuantidadeRodadas()){
				$campeonato = $jogo->getCampeonato()->getCodCampeonato();
				$dql = "SELECT j FROM Jogo j WHERE j.campeonato = '$campeonato'
								ORDER BY j.golsTime1 ASC";
				$jogos = consultaDqlMaxResult(1, $dql);
		
				foreach ($jogos as $jogo1){
					$golsTime1 = $jogo1->getGolstime1();
					$golsTime2 = $jogo1->getGolstime2();
						
					if(!(($golsTime1 === NULL) && ($golsTime2 === NULL))){
						desfazAtribuiTrofeuCampeonato($jogo);
					}
				
				$camp=buscaObjeto("Campeonato", $campeonato);
				$camp->ativaStatus();
				atualizaBancoDados($camp);
				}
			}
		}
			
	function desfazAtribuiMedalhasRodada($numRodada, $jogo){
	desfazAtribuiMedalhasOuro($numRodada, $jogo);
	desfazAtribuiMedalhasPrata($numRodada, $jogo);
	desfazAtribuiMedalhasBronze($numRodada, $jogo);	
		}	
		
	
	function desfazAtribuiTrofeuCampeonato($jogo){
		global $entityManager;
		$dql = 'SELECT p FROM PremiosUsuario p WHERE
					p.campeonato ='.$jogo->getCampeonato()->getCodCampeonato().'AND
					p.trofeu=1';
		$premiosUsuarios=consultaDql($dql);
		foreach ($premiosUsuarios as $premiosUsuario){
			if($premiosUsuario instanceof PremiosUsuario){
				
				$premiosUsuario->subtraiTrofeu();
				atualizaBancoDados($premiosUsuario);
				
				$pontuacaoGeral = $entityManager->find("PontuacaoGeral", $premiosUsuario->getUsuario()->getIdUsuario());
				
				$pontuacaoGeral->subtraiTrofeus();
				atualizaBancoDados($pontuacaoGeral);
				desfazAtribuiChuteiras($jogo);	
				}
		}
	}
	function desfazAtribuiChuteirasOuro($jogo){
		global $entityManager;
		$dql = 'SELECT p FROM PremiosUsuario p WHERE
							p.campeonato ='.$jogo->getCampeonato()->getCodCampeonato().'AND
							p.chuteirasOuro=1';
		$premiosUsuarios=consultaDql($dql);
		foreach ($premiosUsuarios as $premiosUsuario){
			if($premiosUsuario instanceof PremiosUsuario){
				$premiosUsuario->subtraiChuteiraOuro();
				$pontuacaoGeral = $entityManager->find("PontuacaoGeral", $premiosUsuario->getUsuario()->getIdUsuario());
				$pontuacaoGeral->subtraiChuteiraOuroGeral();
				atualizaBancoDados($pontuacaoGeral);
				atualizaBancoDados($premiosUsuario);
				
				}
			}
		}
	function desfazAtribuiChuteirasPrata($jogo){
		global $entityManager;
		$dql = 'SELECT p FROM PremiosUsuario p WHERE
							p.campeonato ='.$jogo->getCampeonato()->getCodCampeonato().'AND
							p.chuteirasPrata=1';
		$premiosUsuarios=consultaDql($dql);
		foreach ($premiosUsuarios as $premiosUsuario){
			if($premiosUsuario instanceof PremiosUsuario){
				$premiosUsuario->subtraiChuteiraPrata();
				atualizaBancoDados($premiosUsuario);
				$pontuacaoGeral = $entityManager->find("PontuacaoGeral", $premiosUsuario->getUsuario()->getIdUsuario());
				$pontuacaoGeral->subtraiChuteiraPrataGeral();
				atualizaBancoDados($pontuacaoGeral);
					
				}
		}
	}
	function desfazAtribuiChuteirasBronze($jogo){
		$dql = 'SELECT p FROM PremiosUsuario p WHERE
							p.campeonato ='.$jogo->getCampeonato()->getCodCampeonato().'AND
							p.chuteirasBronze=1';
		$premiosUsuarios=consultaDql($dql);
		foreach ($premiosUsuarios as $premiosUsuario){
			if($premiosUsuario instanceof PremiosUsuario){
				$premiosUsuario->subtraiChuteiraBronze();
				atualizaBancoDados($premiosUsuario);
				global $entityManager;
				$pontuacaoGeral = $entityManager->find("PontuacaoGeral", $premiosUsuario->getUsuario()->getIdUsuario());
				$pontuacaoGeral->subtraiChuteiraBronzeGeral();
				atualizaBancoDados($pontuacaoGeral);
					
				}
		}
	}
	
	function desfazAtribuiChuteiras($jogo){
		desfazAtribuiChuteirasOuro($jogo);
		desfazAtribuiChuteirasPrata($jogo);
		desfazAtribuiChuteirasBronze($jogo);
		
		}
	?>
	