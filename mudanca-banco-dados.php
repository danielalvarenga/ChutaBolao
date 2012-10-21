<?php
require ("bootstrap.php");
require 'metodos-bd.php';

$conn = $entityManager->getConnection();
$conn->beginTransaction();
try{

$dql = "SELECT u FROM Usuario u WHERE u.idUsuario = '1130122019'
		OR u.idUsuario = '100000885523518'
		OR u.idUsuario = '100003489131091'
		OR u.idUsuario = '100001984735537'";
$usuarios = consultaDql($dql);
foreach ($usuarios as $usuario){
	$premiosUsuarios = $usuario->getPremiacoesUsuario();
	foreach ($premiosUsuarios as $premiosUsuario){
		$premiosUsuario->setClassificacaoCampeonato(0);
		$premiosUsuario->setClassificacaoMedalhas(0);
		atualizaBancoDados($premiosUsuario);
	}
	$pontuacaoRodadas = $usuario->getPontuacaoRodadas();
	foreach ($pontuacaoRodadas as $pontuacaoRodada){
		$pontuacaoRodada->setClassificacaoRodada(0);
		atualizaBancoDados($pontuacaoRodada);
	}
	$pontuacaoGeral = $usuario->getPontuacaoGeral();
	$pontuacaoGeral->setClassificacaoGeral(0);
	$pontuacaoGeral->setClassificacaoMedalhasGeral(0);
	atualizaBancoDados($pontuacaoGeral);
}

//for($i = 1; $i <= 3; $i++){
	$i = 3; // campeonato
	$j = 4; // rodada
	atualizaClassificacaoPontosGeral();
	atualizaClassificacaoPontosCampeonato($i);
	atualizaClassificacaoPontosRodada($j, $i);
	verificaFimRodada($j, $i);
	verificaFinalCampeonato($j, $i);
//}
	
$conn->commit();
} catch(Exception $e) {
	$conn->rollback();
	$conn->close();
	$mensagem = $e->getMessage();
	echo("<script>
			alert(\"Não foi possível gravar os dados.\n$mensagem\");
			</script>");
}
$conn->close();

?>




<?php

		function atualizaClassificacaoPontosGeral(){
			
			$contador=0;
			$armazenaPontos[0]=null;
			$armazenaPosicao[0]=null;
				
			$dql = "SELECT p FROM PontuacaoGeral p WHERE p.usuario <> '1130122019'
			AND p.usuario <> '100000885523518'
			AND p.usuario <> '100003489131091'
			AND p.usuario <> '100001984735537'
			GROUP BY p.pontosGeral ORDER BY p.pontosGeral DESC";
			$pontuacoesGerais = consultaDql($dql);
			
			foreach ($pontuacoesGerais as $pontuacaoGeral){
				if($pontuacaoGeral instanceof PontuacaoGeral){
					$armazenaPontos[$contador]=$pontuacaoGeral->getPontosGeral();
					$armazenaPosicao[$contador]=$contador+1;
					$contador++;
				}
			}
			for ($i=0 ; $i < $contador ; $i++){
				$dql = "SELECT p FROM PontuacaoGeral p WHERE p.usuario <> '1130122019'
				AND p.usuario <> '100000885523518'
				AND p.usuario <> '100003489131091'
				AND p.usuario <> '100001984735537'
				AND p.pontosGeral= '$armazenaPontos[$i]'";
				$pontuacoesGerais = consultaDql($dql);
				
				foreach ($pontuacoesGerais as $pontuacaoGeral){
					if($pontuacaoGeral instanceof PontuacaoGeral){
						$pontuacaoGeral->setClassificacaoGeral($armazenaPosicao[$i]);
						atualizaBancoDados($pontuacaoGeral);
							
					}
				}
			}
		}	
		function atualizaClassificacaoPontosCampeonato($campeonato){
			
			$contador=0;
			$armazenaPontos[0]=null;
			$armazenaPosicao[0]=null;
				
			$dql = "SELECT p FROM PremiosUsuario p WHERE p.usuario <> '1130122019'
					AND p.usuario <> '100000885523518'
					AND p.usuario <> '100003489131091'
					AND p.usuario <> '100001984735537'
					AND p.campeonato = '$campeonato'
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
				$dql = "SELECT p FROM PremiosUsuario p WHERE p.usuario <> '1130122019'
						AND p.usuario <> '100000885523518'
						AND p.usuario <> '100003489131091'
						AND p.usuario <> '100001984735537'
						AND p.campeonato = '$campeonato'
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
			
		function atualizaClassificacaoPontosRodada($numRodada, $campeonato){
			
			$contador=0;
			$armazenaPontos[0]=null;
			$armazenaPosicao[0]=null;
			$dql = "SELECT p FROM PontuacaoRodada p WHERE p.usuario <> '1130122019'
					AND p.usuario <> '100000885523518'
					AND p.usuario <> '100003489131091'
					AND p.usuario <> '100001984735537'
					AND p.rodada = '$numRodada'
					AND p.campeonato = '$campeonato'
					GROUP BY p.pontosRodada
					ORDER BY p.pontosRodada DESC";
			$pontuacoesRodada=consultaDql($dql);
			
			foreach ($pontuacoesRodada as $pontuacaoRodada){
				if($pontuacaoRodada instanceof PontuacaoRodada){
					$armazenaPontos[$contador]=$pontuacaoRodada->getPontosRodada();
					$armazenaPosicao[$contador]=$contador+1;
					$contador++;
					}
				}
				for($i=0 ; $i < $contador ; $i++){
					$dql = "SELECT p FROM PontuacaoRodada p WHERE p.usuario <> '1130122019'
							AND p.usuario <> '100000885523518'
							AND p.usuario <> '100003489131091'
							AND p.usuario <> '100001984735537'
							AND p.rodada = '.$numRodada.'
							AND p.campeonato ='$campeonato'
						    AND p.pontosRodada='$armazenaPontos[$i]'";
					$pontuacoesRodada=consultaDql($dql);

					foreach ($pontuacoesRodada as $pontuacaoRodada){
						if($pontuacaoRodada instanceof PontuacaoRodada){
							$pontuacaoRodada->setClassificacaoRodada($armazenaPosicao[$i]);
							atualizaBancoDados($pontuacaoRodada);
					}
				}	
			}
		}

			
		function verificaFimRodada($numRodada, $campeonato){
			$dql = "SELECT j FROM Jogo j WHERE j.rodada = '$numRodada'
					AND j.campeonato = '$campeonato'
					ORDER BY j.golsTime1 ASC";
			$jogos = consultaDqlMaxResult(1, $dql);
			
			$finalizado = true;
			foreach ($jogos as $jogo){
				$golsTime1 = $jogo->getGolstime1();
				$golsTime2 = $jogo->getGolstime2();
				if(($golsTime1 === NULL) && ($golsTime2 === NULL)){
					$finalizado = false;
				}
			}
			
			if($finalizado){
				//echo 'Campeonato: '.$jogo->getCampeonato()->getNomeCampeonato().'<br/>';
				$rodada = buscaObjeto("Rodada", array(
						"numRodada" => $numRodada,
						"campeonato" => $campeonato));
				$rodada->finalizaStatus();
				atualizaBancoDados($rodada);
				
				//echo 'Rodada: '.$rodada->getNumRodada().'<br/>';
				//echo 'Campeonato: '.$rodada->getCampeonato()->getNomeCampeonato().'<br/>';
				//echo 'Status: '.$rodada->getStatus().'<br/>';
				atualizaClassificacaoMedalhasCampeonato($campeonato);
				atualizaClassificacaoMedalhasGeral();
			}
		}
					
		function atualizaClassificacaoMedalhasCampeonato($campeonato){
			
			$contador=0;
			$armazenaPontos[0]=null;
			$armazenaPosicao[0]=null;
			
			$dql = "SELECT p FROM PremiosUsuario p WHERE p.usuario <> '1130122019'
					AND p.usuario <> '100000885523518'
					AND p.usuario <> '100003489131091'
					AND p.usuario <> '100001984735537'
					AND p.campeonato =".$campeonato."
					GROUP BY p.pontosMedalhas
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
				$dql = "SELECT p FROM PremiosUsuario p WHERE p.usuario <> '1130122019'
									AND p.usuario <> '100000885523518'
									AND p.usuario <> '100003489131091'
									AND p.usuario <> '100001984735537'
									AND p.campeonato =".$campeonato."
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
			
			$dql = "SELECT p FROM PontuacaoGeral p WHERE p.usuario <> '1130122019'
									AND p.usuario <> '100000885523518'
									AND p.usuario <> '100003489131091'
									AND p.usuario <> '100001984735537'
									GROUP BY p.pontosMedalhasGeral
									ORDER BY p.pontosMedalhasGeral DESC";
			$pontuacoesGerais = consultaDql($dql);
			
			foreach ($pontuacoesGerais as $pontuacaoGeral){
				if($pontuacaoGeral instanceof PontuacaoGeral){
					$armazenaPontos[$contador]=$pontuacaoGeral->getPontosMedalhasGeral();
					$armazenaPosicao[$contador]=$contador+1;
					$contador++;	
				}
			}
			for ($i = 0 ;$i < $contador ; $i++){
				$dql = "SELECT p FROM PontuacaoGeral p WHERE p.pontosMedalhasGeral= '$armazenaPontos[$i]'
						AND p.usuario <> '1130122019'
						AND p.usuario <> '100000885523518'
						AND p.usuario <> '100003489131091'
						AND p.usuario <> '100001984735537'";
				$pontuacoesGerais = consultaDql($dql);
	
				foreach ($pontuacoesGerais as $pontuacaoGeral){
					if($pontuacaoGeral instanceof PontuacaoGeral){
						$pontuacaoGeral->setClassificacaoMedalhasGeral(	$armazenaPosicao[$i]);
						atualizaBancoDados($pontuacaoGeral);
					}
				}
			}
		}
			
		function verificaFinalCampeonato($numRodada, $campeonato){				
				$dql = "SELECT j FROM Jogo j WHERE j.campeonato = '$campeonato'
						ORDER BY j.golsTime1 ASC";
				$jogos = consultaDqlMaxResult(1, $dql);
				
				$finalizado = true;
				foreach ($jogos as $jogo){
					$golsTime1 = $jogo->getGolstime1();
					$golsTime2 = $jogo->getGolstime2();
					if(($golsTime1 === NULL) && ($golsTime2 === NULL)){
						$finalizado = false;
					}
				}
				
				if($finalizado){
					atribuiTrofeuCampeonato($campeonato);
				}
		}
			
		function atribuiTrofeuCampeonato($campeonato){
			$dql = "SELECT p FROM PremiosUsuario p WHERE p.usuario <> '1130122019'
					AND p.usuario <> '100000885523518'
					AND p.usuario <> '100003489131091'
					AND p.usuario <> '100001984735537'
					AND p.campeonato =".$campeonato."
					AND p.classificacaoCampeonato = 1
					ORDER BY p.acertosPlacar DESC, p.acertosTimeGanhador DESC,
						p.acertosPlacarInvertido DESC, p.pontosMedalhas DESC";
			
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
			$idUsuario = $premiosUsuarioGanhador->getUsuario()->getIdUsuario();
			global $entityManager;
			$pontuacaoGeral = $entityManager->find("PontuacaoGeral", $idUsuario);
			$pontuacaoGeral->ganhaTrofeu();
			atualizaBancoDados($pontuacaoGeral);
		}

?>