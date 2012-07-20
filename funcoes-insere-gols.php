<?php
require "bootstrap.php";
require 'metodos-bd.php';

		function atualizaClassificacaoPontosGeral(){
			
			$contador=0;
			$armazenaPontos[0]=null;
			$armazenaPosicao[0]=null;
				
			$dql = "SELECT p FROM PontuacaoGeral p GROUP BY p.pontosGeral ORDER BY p.pontosGeral DESC";
			$pontuacoesGerais = consultaDql($dql);
			
			foreach ($pontuacoesGerais as $pontuacaoGeral){
				if($pontuacaoGeral instanceof PontuacaoGeral){
					$armazenaPontos[$contador]=$pontuacaoGeral->getPontosGeral();
					$armazenaPosicao[$contador]=$contador+1;
					$contador++;
				}
			}
			for ($i=0 ; $i < $contador ; $i++){
			$dql = "SELECT p FROM PontuacaoGeral p WHERE p.pontosGeral=".$armazenaPontos[$i] ;
			$pontuacoesGerais = consultaDql($dql);
			
			foreach ($pontuacoesGerais as $pontuacaoGeral){
				if($pontuacaoGeral instanceof PontuacaoGeral){
					$pontuacaoGeral->setClassificacaoGeral($armazenaPosicao[$i]);
					atualizaBancoDados($pontuacaoGeral);
						
							}
						
				 	  }
			     }
			}		
		function atualizaClassificacaoPontosCampeonato($jogo){
			
			$contador=0;
			$armazenaPontos[0]=null;
			$armazenaPosicao[0]=null;
				
			$dql = "SELECT p FROM PremiosUsuario p WHERE
					p.campeonato =".$jogo->getCampeonato()->getCodCampeonato()."
					GROUP BY p.pontosCampeonato ORDER BY p.pontosCampeonato DESC";
			$premiosUsuarios = consultaDql($dql);
			
			foreach ($premiosUsuarios as $premiosUsuario){
				if($premiosUsuario instanceof PremiosUsuario){
					$armazenaPontos[$contador]=$premiosUsuario->getPontosCampeonato();
					$armazenaPosicao[$contador]=$contador+1;
					$contador++;
					
						}
					}
			for ($i=0 ; $i < $contador ; $i++){
				$dql = "SELECT p FROM PremiosUsuario p WHERE
						p.campeonato =".$jogo->getCampeonato()->getCodCampeonato()."
						AND p.pontosCampeonato=".$armazenaPontos[$i] ;
				$premiosUsuarios = consultaDql($dql);

				foreach ($premiosUsuarios as $premiosUsuario){
					if($premiosUsuario instanceof PremiosUsuario){
						$premiosUsuario->setClassificacaoCampeonato($armazenaPosicao[$i]);
						atualizaBancoDados($premiosUsuario);
					}		
				}
			}
		}
			
		function atualizaClassificacaoPontosRodada($numRodada, $jogo){
			
			$contador=0;
			$armazenaPontos[0]=null;
			$armazenaPosicao[0]=null;
			$dql = 'SELECT p FROM PontuacaoRodada p WHERE
					p.rodada = '.$numRodada.'
					AND p.campeonato ='.$jogo->getCampeonato()->getCodCampeonato().'
					ORDER BY p.pontosRodada DESC';
			$pontuacoesRodada=consultaDql($dql);
			
			foreach ($pontuacoesRodada as $pontuacaoRodada){
				if($pontuacaoRodada instanceof PontuacaoRodada){
					$armazenaPontos[$contador]=$pontuacaoRodada->getPontosRodada();
					$armazenaPosicao[$contador]=$contador+1;
					$contador++;
					}
				}
				for($i=0 ; $i < $contador ; $i++){
					$dql = 'SELECT p FROM PontuacaoRodada p WHERE
							p.rodada = '.$numRodada.'
							AND p.campeonato ='.$jogo->getCampeonato()->getCodCampeonato().'
						    AND p.pontosRodada='.$armazenaPontos[$i];
					$pontuacoesRodada=consultaDql($dql);

					foreach ($pontuacoesRodada as $pontuacaoRodada){
						if($pontuacaoRodada instanceof PontuacaoRodada){
							$pontuacaoRodada->setClassificacaoRodada($armazenaPosicao[$i]);
							atualizaBancoDados($pontuacaoRodada);
					}
				}	
			}
		}

			
		function verificaFimRodada($numRodada, $jogo){
			$campeonato = $jogo->getCampeonato()->getCodCampeonato();
			$dql = "SELECT j FROM Jogo j WHERE j.rodada = '$numRodada'
					AND j.campeonato ='$campeonato'
					AND j.golsTime1 >= 0";
			$jogosPassados =consultaDql($dql);
			
			$qtdJogosPassados = sizeof($jogosPassados);
			
			$dql = "SELECT j FROM Jogo j WHERE j.rodada = '$numRodada'
			AND j.campeonato ='$campeonato'";
			$jogosTodos = consultaDql($dql);
			
			$qtdJogosRodada = sizeof($jogosTodos);
			
			if($qtdJogosPassados == $qtdJogosRodada){
				atribuiMedalhasRodada($numRodada, $jogo);
				atualizaClassificacaoMedalhasCampeonato($jogo);
				atualizaClassificacaoMedalhasCampeonato($jogo);
				atualizaClassificacaoMedalhasGeral();
			}
		}
			
		function atribuiMedalhasRodada($numRodada, $jogo){
		global $entityManager;
			
			$dql = 'SELECT p FROM PontuacaoRodada p WHERE p.rodada = '.$numRodada.'
					AND p.campeonato ='.$jogo->getCampeonato()->getCodCampeonato().'
					AND p.classificacaoRodada >= 1 AND p.classificacaoRodada <= 3';
			$pontuacoesRodada = consultaDql($dql);
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
					atualizaBancoDados($premiosUsuario);
					atualizaBancoDados($pontuacaoGeral);
					}
			}
		}
					
		function atualizaClassificacaoMedalhasCampeonato($jogo){
			
$contador=0;
$armazenaPontos[0]=null;
$armazenaPosicao[0]=null;

			$dql = "SELECT p FROM PremiosUsuario p WHERE
					p.campeonato =".$jogo->getCampeonato()->getCodCampeonato()."
					ORDER BY p.pontosMedalhas DESC";
$premiosUsuarios = consultaDql($dql);

foreach ($premiosUsuarios as $premiosUsuario){
	if($premiosUsuario instanceof PremiosUsuario){
		$armazenaPontos[$contador]=$premiosUsuario->getPontosMedalhas();
		$armazenaPosicao[$contador]=$contador+1;
		$contador++;
			
		}	
	}

for ($i=0 ; $i < $contador ; $i++){
	$dql = "SELECT p FROM PremiosUsuario p WHERE
						p.campeonato =".$jogo->getCampeonato()->getCodCampeonato()."
						AND p.pontosMedalhas=".$armazenaPontos[$i] ;
	$premiosUsuarios = consultaDql($dql);

	foreach ($premiosUsuarios as $premiosUsuario){
		if($premiosUsuario instanceof PremiosUsuario){
			$premiosUsuario->setClassificacaoMedalhas($armazenaPosicao[$i]);
			atualizaBancoDados($premiosUsuario);
				
				}
			}
		}
	}
				
		function atualizaClassificacaoMedalhasGeral(){
			
$contador=0;
$armazenaPontos[0]=null;
$armazenaPosicao[0]=null;

$dql = "SELECT p FROM PontuacaoGeral p GROUP BY p.pontosMedalhasGeral ORDER BY p.pontosMedalhasGeral DESC";
$pontuacoesGerais = consultaDql($dql);

foreach ($pontuacoesGerais as $pontuacaoGeral){
	if($pontuacaoGeral instanceof PontuacaoGeral){
		$armazenaPontos[$contador]=$pontuacaoGeral->getPontosMedalhasGeral();
		$armazenaPosicao[$contador]=$contador+1;
		$contador++;	
			}
		}
		for ($i = 0 ;$i < $contador ; $i++){
			$dql = "SELECT p FROM PontuacaoGeral p WHERE p.pontosMedalhasGeral=".$armazenaPontos[$i];
			$pontuacoesGerais = consultaDql($dql);

			foreach ($pontuacoesGerais as $pontuacaoGeral){
				if($pontuacaoGeral instanceof PontuacaoGeral){
					$pontuacaoGeral->setClassificacaoMedalhasGeral(	$armazenaPosicao[$i]);
					atualizaBancoDados($pontuacaoGeral);
					}
				}
			}
		}
			
		function verificaFinalCampeonato($numRodada, $jogo){
			if($numRodada == $jogo->getCampeonato()->getQuantidadeRodadas()){
				
				$campeonato = $jogo->getCampeonato()->getCodCampeonato();
				
				$dql = "SELECT j FROM Jogo j WHERE j.campeonato ='$campeonato'
				AND j.golsTime1 >= 0";
				$jogosPassados = consultaDql($dql);
					
				$qtdJogosPassados = sizeof($jogosPassados);
					
				$dql = "SELECT j FROM Jogo j WHERE j.campeonato ='$campeonato'";
				$jogosTodos = consultaDql($dql);
					
				$qtdJogosCampeonato = sizeof($jogosTodos);
					
				if($qtdJogosPassados == $qtdJogosCampeonato){
					$this->atualizaChuteirasCampeonato($jogo);
					$this->atribuiTrofeuCampeonato($jogo);
				}
			}
		}
				
		function atualizaChuteirasCampeonato($jogo){
			$dql = 'SELECT p FROM PremiosUsuario p WHERE
					p.campeonato ='.$jogo->getCampeonato()->getCodCampeonato().'
					AND p.classificacaoMedalhas >= 1 AND p.classificacaoMedalhas <= 3';
			$premiosUsuarios = consultaDql($dql);
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
					atualizaBancoDados($premiosUsuario);
					}
			}
		}
			
		function atribuiTrofeuCampeonato($jogo){
			$dql = 'SELECT p FROM PremiosUsuario p WHERE
					p.campeonato ='.$jogo->getCampeonato()->getCodCampeonato().'
					AND p.classificacaoCampeonato = 1 ORDER BY p.acertosPlacar DESC,
					p.acertosTimeGanhador DESC, p.acertosPlacarInvertido DESC, p.pontosMedalhas DESC';
			
			//essa parte abaixo e se quiser listar tambem a quantidade de erros
			//e so tirar a aspas simples e o ponto e virgula acima 
			//no final de p.pontosMedalhas DESC e acrescentar essa parte abaixo
			
			//    , p.errosPlacar ASC';
			
			$premiosUsuarios = consultaDql($dql);
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
			atualizaBancoDados($premiosUsuarioGanhador);
			$pontuacaoGeral = $premiosUsuarioGanhador->getUsuario()->getPontuacaoGeral();
			$pontuacaoGeral->ganhaTrofeu();
			atualizaBancoDados($pontuacaoGeral);
			$campeonato = $jogo->getCampeonato();
			$campeonato->finalizaStatus();
			atualizaBancoDados($campeonato);
			}
?>
