<?php
require "bootstrap.php";

		function atualizaClassificacaoPontosGeral(){
			global $entityManager;
			$dql = "SELECT p FROM PontuacaoGeral p ORDER BY p.pontosGeral DESC";
			$query = $entityManager->createQuery($dql);
			$pontuacoesGerais = $query->getResult();
			$classificacaoGeral = 1;
			$primeiro = true;
			$pontosGeralAnterior = NULL;
			foreach ($pontuacoesGerais as $pontuacaoGeral){
				if($pontuacaoGeral instanceof PontuacaoGeral){
					if($primeiro){
						$pontuacaoGeral->setClassificacaoGeral($classificacaoGeral);
						$pontosGeralAnterior = $pontuacaoGeral->getPontosGeral();
						$primeiro = false;
						$entityManager->merge($pontuacaoGeral);
						$entityManager->flush();
					}
					else{
						if($pontuacaoGeral->getPontosGeral() == $pontosGeralAnterior){
							$pontuacaoGeral->setClassificacaoGeral($classificacaoGeral);
							$entityManager->merge($pontuacaoGeral);
							$entityManager->flush();
						}
						else{
							$classificacaoGeral++;
							$pontuacaoGeral->setClassificacaoGeral($classificacaoGeral);
							$pontosGeralAnterior = $pontuacaoGeral->getPontosGeral();
							$entityManager->merge($pontuacaoGeral);
							$entityManager->flush();
						}
					}
				}
			}
		}
			
		function atualizaClassificacaoPontosCampeonato($jogo){
			global $entityManager;
			$dql = "SELECT p FROM PremiosUsuario p WHERE
					p.campeonato =".$jogo->getCampeonato()->getCodCampeonato()."
					ORDER BY p.pontosCampeonato DESC";
			$query = $entityManager->createQuery($dql);
			$premiosUsuarios = $query->getResult();
			$classificacaoCampeonato = 1;
			$primeiro = true;
			$pontosCampeonatoAnterior = NULL;
			foreach ($premiosUsuarios as $premiosUsuario){
				if($premiosUsuario instanceof PremiosUsuario){
					if($primeiro){
						$premiosUsuario->setClassificacaoCampeonato($classificacaoCampeonato);
						$pontosCampeonatoAnterior = $premiosUsuario->getPontosCampeonato();
						$primeiro = false;
						$entityManager->merge($premiosUsuario);
						$entityManager->flush();
					}
					else{
						if($premiosUsuario->getPontosCampeonato() == $pontosCampeonatoAnterior){
							$premiosUsuario->setClassificacaoCampeonato($classificacaoCampeonato);
							$entityManager->merge($premiosUsuario);
							$entityManager->flush();
						}
						else{
							$classificacaoCampeonato++;
							$premiosUsuario->setClassificacaoCampeonato($classificacaoCampeonato);
							$pontosCampeonatoAnterior = $premiosUsuario->getPontosCampeonato();
							$entityManager->merge($premiosUsuario);
							$entityManager->flush();
						}
					}
				}
			}
		}
			
		function atualizaClassificacaoPontosRodada($numRodada, $jogo){
			global $entityManager;
			$dql = 'SELECT p FROM PontuacaoRodada p WHERE
					p.rodada = '.$numRodada.'
					AND p.campeonato ='.$jogo->getCampeonato()->getCodCampeonato().'
					ORDER BY p.pontosRodada DESC';
			$query = $entityManager->createQuery($dql);
			$pontuacoesRodada = $query->getResult();
			$classificacaoRodada = 1;
			$primeiro = true;
			$pontosRodadaAnterior = NULL;
			foreach ($pontuacoesRodada as $pontuacaoRodada){
				if($pontuacaoRodada instanceof PontuacaoRodada){
					if($primeiro){
						$pontuacaoRodada->setClassificacaoRodada($classificacaoRodada);
						$pontosRodadaAnterior = $pontuacaoRodada->getPontosRodada();
						$primeiro = false;
						$entityManager->merge($pontuacaoRodada);
						$entityManager->flush();
					}
					elseif($pontuacaoRodada->getPontosRodada() == $pontosRodadaAnterior){
							$pontuacaoRodada->setClassificacaoRodada($classificacaoRodada);
							$entityManager->merge($pontuacaoRodada);
							$entityManager->flush();
					}
					else{
						$classificacaoRodada++;
						$pontuacaoRodada->setClassificacaoRodada($classificacaoRodada);
						$pontosRodadaAnterior = $pontuacaoRodada->getPontosRodada();
						$entityManager->merge($pontuacaoRodada);
						$entityManager->flush();
					}
				}
			}
		}
			
		function verificaFimRodada($numRodada, $jogo){
			global $entityManager;
			$campeonato = $jogo->getCampeonato()->getCodCampeonato();
			$dql = "SELECT j FROM Jogo j WHERE j.rodada = '$numRodada'
					AND j.campeonato ='$campeonato'
					AND j.golsTime1 >= 0";
			$query = $entityManager->createQuery($dql);
			$jogosPassados = $query->getResult();
			
			$qtdJogosPassados = sizeof($jogosPassados);
			
			$dql = "SELECT j FROM Jogo j WHERE j.rodada = '$numRodada'
			AND j.campeonato ='$campeonato'";
			$query = $entityManager->createQuery($dql);
			$jogosTodos = $query->getResult();
			
			$qtdJogosRodada = sizeof($jogosTodos);
			
			$fimRodada = false;
			if($qtdJogosPassados == $qtdJogosRodada){
				$fimRodada = true;
			}
			
			if($fimRodada){
				atribuiMedalhasRodada($numRodada, $jogo);
				atualizaClassificacaoMedalhasCampeonato($jogo);
				atualizaClassificacaoMedalhasGeral();
			}
		}
			
		function atribuiMedalhasRodada($numRodada, $jogo){
			global $entityManager;
			$dql = 'SELECT p FROM PontuacaoRodada p WHERE p.rodada = '.$numRodada.'
					AND p.campeonato ='.$jogo->getCampeonato()->getCodCampeonato().'
					AND p.classificacaoRodada >= 1 AND p.classificacaoRodada <= 3';
			$query = $entityManager->createQuery($dql);
			$pontuacoesRodada = $query->getResult();
			foreach ($pontuacoesRodada as $pontuacaoRodada){
				if($pontuacaoRodada instanceof PontuacaoRodada){
					
					$premiosUsuario = $entityManager->find("PremiosUsuario", array(
							"campeonato" =>	$pontuacaoRodada->getCampeonato()->getCodCampeonato(),
							"usuario" => $pontuacaoRodada->getUsuario()->getIdUsuario()
					));
					$pontuacaoGeral = $entityManager->find("PontuacaoGeral", $pontuacaoRodada->getUsuario()->getIdUsuario());
											
					if($pontuacaoRodada->getClassificacaoRodada() == 1){
						$premiosUsuario->ganhaMedalhaOuro();
						$pontuacaoGeral->ganhaMedalhasOuroGeral();
					}
					elseif ($pontuacaoRodada->getClassificacaoRodada() == 2){
						$premiosUsuario->ganhaMedalhaPrata();
						$pontuacaoGeral->ganhaMedalhasPrataGeral();
					}
					elseif ($pontuacaoRodada->getClassificacaoRodada() == 3){
						$premiosUsuario->ganhaMedalhaBronze();
						$pontuacaoGeral->ganhaMedalhasBronzeGeral();
					}
					$entityManager->merge($premiosUsuario);
					$entityManager->flush();
					$entityManager->merge($pontuacaoGeral);
					$entityManager->flush();
				}
			}
		}
				
		function atualizaClassificacaoMedalhasCampeonato($jogo){
			global $entityManager;
			$dql = "SELECT p FROM PremiosUsuario p WHERE
					p.campeonato =".$jogo->getCampeonato()->getCodCampeonato()."
					ORDER BY p.pontosMedalhas DESC";
			$query = $entityManager->createQuery($dql);
			$premiosUsuarios = $query->getResult();
			$classificacaoMedalhas = 1;
			$primeiro = true;
			$pontosMedalhasAnterior = NULL;
			foreach ($premiosUsuarios as $premiosUsuario){
				if($premiosUsuario instanceof PremiosUsuario){
					if($primeiro){
						$premiosUsuario->setClassificacaoMedalhas($classificacaoMedalhas);
						$pontosMedalhasAnterior = $premiosUsuario->getPontosMedalhas();
						$primeiro = false;
						$entityManager->merge($premiosUsuario);
						$entityManager->flush();
					}
					else{
						if($premiosUsuario->getPontosMedalhas() == $pontosMedalhasAnterior){
							$premiosUsuario->setClassificacaoMedalhas($classificacaoMedalhas);
							$entityManager->merge($premiosUsuario);
							$entityManager->flush();
						}
						else{
							$classificacaoMedalhas++;
							$premiosUsuario->setClassificacaoMedalhas($classificacaoMedalhas);
							$pontosMedalhasAnterior = $premiosUsuario->getPontosMedalhas();
							$entityManager->merge($premiosUsuario);
							$entityManager->flush();
						}
					}
				}
			}
		}
				
		function atualizaClassificacaoMedalhasGeral(){
			global $entityManager;
			$dql = "SELECT p FROM PontuacaoGeral p ORDER BY p.pontosMedalhasGeral DESC";
			$query = $entityManager->createQuery($dql);
			$pontuacoesGerais = $query->getResult();
			$classificacaoMedalhasGeral = 1;
			$primeiro = true;
			$pontosMedalhasGeralAnterior = NULL;
			foreach ($pontuacoesGerais as $pontuacaoGeral){
				if($pontuacaoGeral instanceof PontuacaoGeral){
					if($primeiro){
						$pontuacaoGeral->setClassificacaoMedalhasGeral($classificacaoMedalhasGeral);
						$pontosMedalhasAnteriorGeral = $pontuacaoGeral->getPontosMedalhasGeral();
						$primeiro = false;
						$entityManager->merge($pontuacaoGeral);
						$entityManager->flush();
					}
					else{
						if($pontuacaoGeral->getPontosMedalhasGeral() == $pontosMedalhasAnteriorGeral){
							$pontuacaoGeral->setClassificacaoMedalhasGeral($classificacaoMedalhasGeral);
							$entityManager->merge($pontuacaoGeral);
							$entityManager->flush();
						}
						else{
							$classificacaoMedalhasGeral++;
							$pontuacaoGeral->setClassificacaoMedalhasGeral($classificacaoMedalhasGeral);
							$pontosMedalhasAnteriorGeral = $pontuacaoGeral->getPontosMedalhasGeral();
							$entityManager->merge($pontuacaoGeral);
							$entityManager->flush();
						}
					}
				}
			}
		}
			
		function verificaFinalCampeonato($numRodada, $jogo){
			global $entityManager;
			if($numRodada == $jogo->getCampeonato()->getQuantidadeRodadas()){
				
				$campeonato = $jogo->getCampeonato()->getCodCampeonato();
				
				$dql = "SELECT j FROM Jogo j WHERE j.campeonato ='$campeonato'
				AND j.golsTime1 >= 0";
				$query = $entityManager->createQuery($dql);
				$jogosPassados = $query->getResult();
					
				$qtdJogosPassados = sizeof($jogosPassados);
					
				$dql = "SELECT j FROM Jogo j WHERE j.campeonato ='$campeonato'";
				$query = $entityManager->createQuery($dql);
				$jogosTodos = $query->getResult();
					
				$qtdJogosCampeonato = sizeof($jogosTodos);
					
				$fimCampeonato = false;
				if($qtdJogosPassados == $qtdJogosCampeonato){
					$fimCampeonato = true;
				}
				
				if($fimCampeonato){
					$this->atualizaChuteirasCampeonato($jogo);
					$this->atribuiTrofeuCampeonato($jogo);
				}
			}
		}
				
		function atualizaChuteirasCampeonato($jogo){
			global $entityManager;
			$dql = 'SELECT p FROM PremiosUsuario p WHERE
					p.campeonato ='.$jogo->getCampeonato()->getCodCampeonato().'
					AND p.classificacaoMedalhas >= 1 AND p.classificacaoMedalhas <= 3';
			$query = $entityManager->createQuery($dql);
			$premiosUsuarios = $query->getResult();
			foreach ($premiosUsuarios as $premiosUsuario){
				if($premiosUsuario instanceof PremiosUsuario){
						
					if($premiosUsuario->getClassificacaoMedalhas() == 1){
						$premiosUsuario->ganhaChuteiraOuro();
					}
					elseif ($premiosUsuario->getClassificacaoMedalhas() == 2){
						$premiosUsuario->ganhaChuteiraPrata();
					}
					elseif ($premiosUsuario->getClassificacaoMedalhas() == 3){
						$premiosUsuario->ganhaChuteiraBronze();
					}
					$entityManager->merge($premiosUsuario);
					$entityManager->flush();
				}
			}
		}
			
		function atribuiTrofeuCampeonato($jogo){
			global $entityManager;
			$dql = 'SELECT p FROM PremiosUsuario p WHERE
					p.campeonato ='.$jogo->getCampeonato()->getCodCampeonato().'
					AND p.chuteirasOuro = 1';
			$query = $entityManager->createQuery($dql);
			$premiosUsuarios = $query->getResult();
			$primeiro = true;
			$premiosUsuarioGanhador = NULL;
			foreach ($premiosUsuarios as $premiosUsuario){
				if($premiosUsuario instanceof PremiosUsuario){
					if($primeiro){
						$premiosUsuarioGanhador = $premiosUsuario;
						$primeiro = false;
					}
					else{
						if($premiosUsuario->getAcertosPlacar() > $premiosUsuarioGanhador->getAcertosPlacar()){
							$premiosUsuarioGanhador = $premiosUsuario;
						}
						elseif($premiosUsuario->getAcertosPlacar() == $premiosUsuarioGanhador->getAcertosPlacar()){
							if($premiosUsuario->getAcertosTimeGanhador() > $premiosUsuarioGanhador->getAcertosTimeGanhador()){
								$premiosUsuarioGanhador = $premiosUsuario;
							}
							elseif($premiosUsuario->getAcertosTimeGanhador() == $premiosUsuarioGanhador->getAcertosTimeGanhador()){
								if($premiosUsuario->getAcertosPlacarInvertido() > $premiosUsuarioGanhador->getAcertosPlacarInvertido()){
									$premiosUsuarioGanhador = $premiosUsuario;
								}
								elseif($premiosUsuario->getAcertosPlacarInvertido() == $premiosUsuarioGanhador->getAcertosPlacarInvertido()){
									if($premiosUsuario->getErrosPlacar() < $premiosUsuarioGanhador->getErrosPlacar()){
										$premiosUsuarioGanhador = $premiosUsuario;
									}
									elseif($premiosUsuario->getErrosPlacar() == $premiosUsuarioGanhador->getErrosPlacar()){
										$sorteio = rand(1,2);
										if($sorteiro == 2){
											$premiosUsuarioGanhador = $premiosUsuario;
										}
									}
								}
							}
						}
					}
				}
			}
			$premiosUsuarioGanhador->ganhaTrofeu();
			$entityManager->merge($premiosUsuarioGanhador);
			$entityManager->flush();
			$pontuacaoGeral = $premiosUsuarioGanhador->getUsuario()->getPontuacaoGeral();
			$pontuacaoGeral->ganhaTrofeu();
			$entityManager->merge($pontuacaoGeral);
			$entityManager->flush();
			$campeonato = $jogo->getCampeonato();
			$campeonato->finalizaStatus();
			$entityManager->merge($campeonato);
			$entityManager->flush();
		}
?>
