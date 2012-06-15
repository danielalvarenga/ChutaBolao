<?php

require "bootstrap.php";


if (isset($_POST['jogo'])) {
	
	$codJogo = $_POST['jogo'];
	$jogo = $entityManager->find("Jogo", $codJogo);
	
	$codTime1 = $jogo->getCodTime1();
	$codTime2 = $jogo->getCodTime2();
	$time1 = $entityManager->find("Time", $codTime1);
	$time2 = $entityManager->find("Time", $codTime2);
	
	
	if(isset($_POST['golsTime1'])){
		
		$conn = $entityManager->getConnection();
		$conn->beginTransaction();
		try{
		
		// Atualiza resultado do jogo com os gols
		
			$golsTime1 = $_POST['golsTime1'];
			$golsTime2 = $_POST['golsTime2'];
			$jogo->setResultado($golsTime1, $golsTime2);
			
			$entityManager->merge($jogo);
			$entityManager->flush();
			
			$jogo = $entityManager->find("Jogo", $_POST['jogo']);
			
		//Atualização do rendimento dos times --------------------------------
		
			//Time1
			$rendimentoTime1 = $entityManager->find("RendimentoTime", array(
					"time" => $codTime1,
					"campeonato" => $jogo->getCampeonato()->getCodCampeonato()
					));
			$golsPro1 = $golsTime1;
			$golsContra1 = $golsTime2;
			$rendimentoTime1->calculaRendimentoTime($golsPro1, $golsContra1);
			
			$entityManager->merge($rendimentoTime1);
			$entityManager->flush();
			
			//Time2
			$rendimentoTime2 = $entityManager->find("RendimentoTime", array(
					"time" => $codTime2,
					"campeonato" => $jogo->getCampeonato()->getCodCampeonato()
			));
			$golsPro2 = $golsTime2;
			$golsContra2 = $golsTime1;
			$rendimentoTime2->calculaRendimentoTime($golsPro2, $golsContra2);
			
			$entityManager->merge($rendimentoTime2);
			$entityManager->flush();
			
		//--------------------------------------------------------------------
			$numRodada = $jogo->getRodada()->getNumRodada();
			$codJogo = $jogo->getCodjogo();
			$dqlApostas = "SELECT a FROM Aposta a WHERE a.jogo = $codJogo";
			$queryApostas = $entityManager->createQuery($dqlApostas);
			$apostas = $queryApostas->getResult();
			
			foreach ($apostas as $aposta){
				if ($aposta instanceof Aposta){
					$aposta->calculaPontosAposta($jogo->getGolsTime1(),$jogo->getGolsTime2());
					$entityManager->merge($aposta);
					$entityManager->flush();
					
					//Atualiza PremiosUsuario do Usuário no Campeonato
					
					$premiosUsuario = $entityManager->find("PremiosUsuario", array(
						"campeonato" =>	$jogo->getCampeonato()->getCodCampeonato(),
						"usuario" => $aposta->getUsuario()->getIdUsuario()
					));
					$premiosUsuario->calculaPontos($aposta->getPontosAposta());
					$entityManager->merge($premiosUsuario);
					$entityManager->flush();
					
					//Atualiza Pontos de cada Usuário na Rodada
					
					$pontuacaoRodada = $entityManager->find("PontuacaoRodada", array(
							"campeonato" =>	$jogo->getCampeonato()->getCodCampeonato(),
							"rodada" => $numRodada,
							"usuario" => $aposta->getUsuario()->getIdUsuario()
					));
					$pontuacaoRodada->calculaPontosRodada($aposta->getPontosAposta());
					$entityManager->merge($pontuacaoRodada);
					$entityManager->flush();
					
					//Atualiza PontosGeral de cada Usuário
					
					$usuario = $entityManager->find("Usuario", $aposta->getUsuario()->getIdUsuario());
					$usuario->calculaPontosGeral($aposta->getPontosAposta());
					$entityManager->merge($usuario);
					$entityManager->flush();
					
				} else {
					echo "NÃO EXISTEM APOSTAS PARA ESTE JOGO";
				}
			}
			
			//Atualiza Classificação Geral dos Usuários
			
			$dql = "SELECT u FROM Usuario u ORDER BY u.pontosGeral DESC";
			$query = $entityManager->createQuery($dql);
			$usuarios = $query->getResult();
			$classificacaoGeral = 1;
			$primeiro = true;
			$pontosGeralAnterior = NULL;
			foreach ($usuarios as $usuario){
				if($usuario instanceof Usuario){
					if($primeiro){
						$usuario->setClassificacaoGeral($classificacaoGeral);
						$pontosGeralAnterior = $usuario->getPontosGeral();
						$primeiro = false;
						$entityManager->merge($usuario);
						$entityManager->flush();
					}
					else{
						if($usuario->getPontosGeral() == $pontosGeralAnterior){
							$usuario->setClassificacaoGeral($classificacaoGeral);
							$entityManager->merge($usuario);
							$entityManager->flush();
						}
						else{
							$classificacaoGeral++;
							$usuario->setClassificacaoGeral($classificacaoGeral);
							$pontosGeralAnterior = $usuario->getPontosGeral();
							$entityManager->merge($usuario);
							$entityManager->flush();
						}
					}
				}
			}
			
			//Atualiza Classificação dos Usuários no Campeonato
			
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
			
			//Atualiza Classificação dos Usuários na Rodada
			
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
					else{
						if($pontuacaoRodada->getPontosRodada() == $pontosRodadaAnterior){
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
			
			//Dá medalhas ao final da rodada --------------------------------
			
			//Verifica se a rodada acabou
			$dql = 'SELECT j FROM Jogo j WHERE j.rodada = '.$numRodada.'
					AND j.campeonato ='.$jogo->getCampeonato()->getCodCampeonato().'
					ORDER BY j.dataJogo DESC';
			$query = $entityManager->createQuery($dql);
			$jogs = $query->getResult();
			$fimRodada = true;
			foreach($jogs as $jog) {
				if($jog instanceof Jogo){
					if($jog->getGolstime1() == NULL){
						$fimRodada = false;
						break;
					}
				}
			}
			
			//Atribui medalhas
			if($fimRodada){
				$dql = "SELECT p FROM PontuacaoRodada p WHERE
						p.classificacaoRodada >= 1 AND p.classificacaoRodada <= 3";
				$query = $entityManager->createQuery($dql);
				$pontuacoesRodada = $query->getResult();
				foreach ($pontuacoesRodada as $pontuacaoRodada){
					if($pontuacaoRodada instanceof PontuacaoRodada){
						
						$premiosUsuario = $entityManager->find("PremiosUsuario", array(
								"campeonato" =>	$pontuacaoRodada->getCampeonato()->getCodCampeonato(),
								"usuario" => $pontuacaoRodada->getUsuario()->getIdUsuario()
						));
						if($pontuacaoRodada->getClassificacaoRodada() == 1){
							$premiosUsuario->ganhaMedalhaOuro();
						}
						elseif ($pontuacaoRodada->getClassificacaoRodada() == 2){
							$premiosUsuario->ganhaMedalhaPrata();
						}
						elseif ($pontuacaoRodada->getClassificacaoRodada() == 3){
							$premiosUsuario->ganhaMedalhaBronze();
						}
						$entityManager->merge($premiosUsuario);
						$entityManager->flush();
					}
				}
				
				//Atualiza Classificação de Medalhas dos Usuários no Campeonato
				
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
			
			//Dá chuteiras ao final do Campeonato --------------------------------
			
			//Verifica se o Campeonato acabou
			$dql = 'SELECT j FROM Jogo j WHERE
					j.campeonato ='.$jogo->getCampeonato()->getCodCampeonato().'
					ORDER BY j.dataJogo DESC';
			$query = $entityManager->createQuery($dql);
			$jogs = $query->getResult();
			$fimCampeonato = true;
			foreach($jogs as $jog) {
				if($jog instanceof Jogo){
					if($jog->getGolstime1() == NULL){
						$fimCampeonato = false;
						break;
					}
				}
			}
			
			if($fimCampeonato){
				
				//Atribui as Chuteiras
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
				
				// Atribui o troféu
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
			}
			
			$conn->commit();
		} catch(Exception $e) {
			$conn->rollback();
			echo $e->getMessage() . "<br/><font color=red>Não foi possível gravar os dados. Verifique o Banco de Dados.</font><br/>";
		}
		$conn->close();
		
	}

?>
<html>
<head>
<title>
inserir gols
</title>
</head>
<body>

	<h1 align="center">Inserir Gols</h1>
<br/><br/>
		<h2 align="center">Jogo</h2>
	<table border="1" align="center">
		<tr vertical-align="middle" align="center">
			<td><b>Data</b></td>
			<td><b>Campeonato</b></td>
			<td><b>Rodada</b></td>
			<td><b>Time1</b></td>
			<td><b>Time2</b></td>
			<td><b>Resultado</b></td>
			<td><b>Início de Apostas</b></td>
			<td><b>Fim de Apostas</b></td>
		</tr>
<?php
	echo '
			<tr vertical-align="middle" align="center">
				<td>'.$jogo->getDatajogo().'</td>
				<td>'.$jogo->getCampeonato()->getNomeCampeonato().' '.$jogo->getCampeonato()->getAnoCampeonato().'</td>
				<td>'.$jogo->getRodada()->getNumRodada().'</td>
				<td>'.$time1->getNomeTime().'</td>
				<td>'.$time2->getNomeTime().'</td>
				<td>'.$jogo->getGolstime1().' X '.$jogo->getGolstime2().'</td>
				<td>'.$jogo->getDataInicioApostas().'</td>
				<td>'.$jogo->getDataFimApostas().'</td>
			</tr>';
?>
</table>
<br/><br/>
		<h2 align="center">Resultado</h2>
	<form method="POST" action="">
	 	<p align="center"><?php echo $time1->getNomeTime()?> 
	 	<select name="golsTime1">';
	 		<option value="NULL"></OPTION>
			<?php
				for($gols = 0 ; $gols < 100 ; $gols++ ){
					echo "<option value=$gols>$gols</option>";
				};
			?>
		</select>
		 X 
		<select name="golsTime2">
			<option value="NULL"></OPTION>
			<?php
				for($gols = 0 ; $gols < 100 ; $gols++ ){
					echo "<option value=$gols>$gols</option>";
				};
			?>
		</select> <?php echo $time2->getNomeTime();?>
		<br/>
		<input type="hidden" name="jogo" value=<?php echo $jogo->getCodjogo();?>>
		<input type="submit" name="registra-resultado" value="Registrar Resultado"><br/>
		</p>
	</form>
<?php
}
?>
	<br/><br/><br/>
	<p align="center"><a href="cadastra-jogo.php">Voltar para Jogos</a></p>
		<p align="center"><a href="admin.php">Menu Principal</a></p>
</body>
</html>