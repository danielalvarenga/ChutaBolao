<?php
require ("bootstrap.php");

function opcaoUsuario(){
	for($indiceEscolhaUsuario = 0 ; $indiceEscolhaUsuario < 100 ; $indiceEscolhaUsuario++ ){
		echo "<OPTION VALUE=$indiceEscolhaUsuario>$indiceEscolhaUsuario</OPTION>";
	}
}

if(isset($_POST)){
	$conn = $entityManager->getConnection();
	$conn->beginTransaction();
	try{
		$contador=0;
		$contador1=0;
		for ($i=0;$i<sizeof($_POST)/4;$i++){
			$auxContadorAposta[0]=null;
			$aux=$i <<2;
			$jogo_campeonato=$_POST[$aux];
			$jogo_numero= $_POST[$aux + 1 ];
			$palpite_time1_jogo= $_POST[$aux + 2 ];
			$palpite_time2_jogo= $_POST[$aux + 3 ];
				
			//Busca objeto Jogo, Campeonato e Aposta
				
			$usuario = $entityManager->find("Usuario", $user_id);
			$jogo = $entityManager->find("Jogo", $jogo_numero);
			$campeonato= $entityManager->find("Campeonato", $jogo_campeonato);
			$apostaCadastrada = $entityManager->find("Aposta", array(
					"campeonato" =>	$jogo_campeonato,
					"usuario" => $user_id,
					"jogo" => $jogo_numero
			));
				
			//Cria um objeto PontuacaoRodada para o Usuario na Rodada do Jogo que apostou se ainda nÃ£o existir
				
			$pontuacaoRodada = $entityManager->find("PontuacaoRodada", array(
					"campeonato" =>	$jogo_campeonato,
					"rodada" => $jogo->getRodada()->getNumRodada(),
					"usuario" => $user_id
			));
			if(!$pontuacaoRodada instanceof PontuacaoRodada){
				$pontuacaoRodada = new PontuacaoRodada($jogo->getRodada(), $campeonato, $usuario);
				$entityManager->persist($pontuacaoRodada);
				$entityManager->flush();
			}
				
			//Cria um objeto PremiosUsuario para o Usuario no Campeonato do Jogo que apostou se ainda nÃ£o existir

			$premiosUsuario = $entityManager->find("PremiosUsuario", array(
					"campeonato" =>	$jogo_campeonato,
					"usuario" => $user_id
			));
			if(!$premiosUsuario instanceof PremiosUsuario){
				$premiosUsuario = new PremiosUsuario($usuario, $campeonato);
				$entityManager->persist($premiosUsuario);
				$entityManager->flush();
			}
				
			//Cria nova aposta se ainda nÃ£o existir
			$publica = false;
			if ($apostaCadastrada instanceof Aposta){
				$indice=0;
				if ($apostaCadastrada->getApostaGolsTime1()<>$palpite_time1_jogo) {
					$auxContadorAposta[$indice]=$apostaCadastrada->getApostaGolsTime1()."  X  ".$apostaCadastrada->getApostaGolsTime2();
					$atualizacaoContadorAposta=$palpite_time1_jogo."  X  ".$apostaCadastrada->getApostaGolsTime2();
					$apostaCadastrada->setApostaGolsTime1($palpite_time1_jogo);
					$auxiliar_jogo=$apostaCadastrada->getJogo()->getCodjogo();
					$entityManager->merge($apostaCadastrada);
					$entityManager->flush();
					$publica = true;
					$contador1++;
					$indice++;
				}
					
				if($apostaCadastrada->getApostaGolsTime2()<>$palpite_time2_jogo){
					$auxContadorAposta[$indice]=$apostaCadastrada->getApostaGolsTime1()."  X  ".$apostaCadastrada->getApostaGolsTime2();
					$apostaCadastrada->setApostaGolsTime2($palpite_time2_jogo);
					$atualizacaoContadorAposta=$apostaCadastrada->getApostaGolsTime1()."  X  ".$palpite_time2_jogo;
					$auxiliar_jogo=$apostaCadastrada->getJogo()->getCodjogo();
					$entityManager->merge($apostaCadastrada);
					$entityManager->flush();
					$publica = true;
					$contador1++;
				}
				if($auxContadorAposta[0]<>NULL){
					$contadorAposta = $entityManager->find("ContadorAposta", array (
							"campeonato"=>$jogo_campeonato,
							"jogo"=> $auxiliar_jogo,
							"opcaoCadastrada"=>$auxContadorAposta[0]
					));
					$contadorAposta->declementaQuantidadeApostas();
					$entityManager->merge($contadorAposta);
					$entityManager->flush();

					$contadorAposta = $entityManager->find("ContadorAposta", array (
							"campeonato"=>$jogo_campeonato,
							"jogo"=> $auxiliar_jogo,
							"opcaoCadastrada"=>$atualizacaoContadorAposta
					));

					//Cria um objeto ContadorAposta para uma Aposta no Campeonato do Jogo que apostou se ainda nÃ£o existir

					if ($contadorAposta instanceof ContadorAposta){
						$contadorAposta->inclementaQuantidadeApostas();
						$entityManager->merge($contadorAposta);
						$entityManager->flush();

					}
					else{
						$novoContadorAposta= new ContadorAposta($atualizacaoContadorAposta,$campeonato,$jogo);
						$entityManager->persist($novoContadorAposta);
						$entityManager->flush();
							
					}
				}
			}
			else{
				if (($palpite_time1_jogo<>'') && ($palpite_time2_jogo<>'')){
					$apostaNova = new Aposta($usuario, $campeonato, $jogo);
					$atualizacaoContadorAposta=$palpite_time1_jogo."  X  ".$palpite_time2_jogo;
					$apostaNova->setApostaGolsTime1($palpite_time1_jogo);
					$apostaNova->setApostaGolsTime2($palpite_time2_jogo);
					$entityManager->persist($apostaNova);
					$entityManager->flush();
					$publica = true;
					$contador++;

					$contadorAposta = $entityManager->find("ContadorAposta", array (
							"campeonato"=>$jogo_campeonato,
							"jogo"=> $jogo_numero,
							"opcaoCadastrada"=>$atualizacaoContadorAposta
					));

					//Cria um objeto ContadorAposta para uma Aposta no Campeonato do Jogo que apostou se ainda nÃ£o existir

					if ($contadorAposta instanceof ContadorAposta){
						$contadorAposta->inclementaQuantidadeApostas();
						$entityManager->merge($contadorAposta);
						$entityManager->flush();

					}
					else{
						$novoContadorAposta= new ContadorAposta($atualizacaoContadorAposta,$campeonato,$jogo);
						$entityManager->persist($novoContadorAposta);
						$entityManager->flush();

					}
				}
			}
				
			if($publica){
				if($palpite_time1_jogo > $palpite_time2_jogo){
					$time1 = $entityManager->find("Time", $jogo->getCodtime1());
					$name = $usuario->getPrimeiroNomeUsuario().'
					chuta '.$palpite_time1_jogo.'
					Ã  '.$palpite_time2_jogo.'
					para o '.$time1->getNomeTime();
				}
				elseif($palpite_time1_jogo < $palpite_time2_jogo){
					$time2 = $entityManager->find("Time", $jogo->getCodtime2());
					$name = $usuario->getPrimeiroNomeUsuario().'
					chuta '.$palpite_time2_jogo.'
					Ã  '.$palpite_time1_jogo.'
					para o '.$time2->getNomeTime();
				}
				elseif($palpite_time1_jogo == $palpite_time2_jogo){
					$time1 = $entityManager->find("Time", $jogo->getCodtime1());
					$time2 = $entityManager->find("Time", $jogo->getCodtime2());
					$name = $usuario->getPrimeiroNomeUsuario().'
					chuta '.$palpite_time1_jogo.'
					Ã  '.$palpite_time2_jogo.'
					para '.$time1->getNomeTime().'
					e '.$time2->getNomeTime();
				}

				$message = 'AlguÃ©m chuta melhor que eu!? =D';
				$picture = 'http://www.chutabolao.com.br/facebook/'.$jogo->getEscudosJogo();
				$link = 'http://apps.facebook.com/chutabolao';
				$caption = 'Mostre que vocÃª sabe mais!';
				$description = "Jogo em ".$jogo->getDataLogica().". FaÃ§a seu chute atÃ© ".$jogo->getDataLogicaFimApostas();
				/*
				 $ret_obj = $facebook->api('/me/feed', 'POST',	array(
				 		'link' => $link,
				 		'message' => $message,
				 		'name' => $name,
				 		'picture' => $picture,
				 		'caption' => $caption,
				 		'description' => $description
				 ));
				*/
			}
		}
		if($contador>0){
			echo"<p align='center'>
			<table id='tabela'>
			<tr class=\"linha\">
			<td class=\"coluna\">
			<p align='center'>Aposta realizada com sucesso</p>
			</td>
			</tr>
			</table>";
		}
		if($contador1>0){
			echo"<p align='center'>
			<table id='tabela'>
			<tr class=\"linha\">
			<td class=\"coluna\">
			<p align='center'>Aposta atualizada com sucesso</p>
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
		<p align='center'>Não foi possível gravar seu Chute. Tente outra vez mais tarde.</p>
		</td>
		</tr>
		</table>";
	}
	$conn->close();
}


/////////////////////////////////////////////////////////////////////////////////////////////////////

$conn = $entityManager->getConnection();
$conn->beginTransaction();
try{
	$dataAgora = new DateTime('now', new DateTimeZone('America/Sao_Paulo'));
	$dataAtual = $dataAgora->format( "Y-m-d H:i:s" );

	$dql = "SELECT c FROM Campeonato c WHERE c.status='ativo' ";
	$query= $entityManager->createQuery($dql);
	$campeonatos= $query->getResult();

	if($campeonatos<>NULL){

		$opcaoVazia=' ';
		$imprimeLetraX= "X";
	  
		foreach ($campeonatos as $campeonato){
				
			//Essa parte do codigo busca os jogos cadastradas dentro do banco de dados.

			$dql = "SELECT j FROM Jogo j WHERE'$dataAtual'>= j.dataInicioApostas AND '$dataAtual
			'<=j.dataFimApostas AND j.campeonato=".$campeonato->getCodCampeonato()." ORDER BY j.dataJogo ";
			$query = $entityManager->createQuery($dql);
			$jogos = $query->getResult();

			//Aqui esta testando se a busca voltou com algum jogo ou nao

			if($jogos<>NULL){

				echo '
				<table id="tabela" cellspacing=0>
				<td id="aposta" align="center" colspan="7">
				<h3>'
				.$campeonato->getNomeCampeonato().' '
				.$campeonato->getAnoCampeonato().'
				</h3>
				</td>
				<form action="" method="POST" >';
				$contadorArray=0;

				foreach ($jogos as $jogo){
					$aux=$contadorArray << 2;
					$numero_campeonato= $aux ;
					$numeroJogo= $aux+1;
					$apostaGolsUsuarioTime1=$aux+2;
					$apostaGolsUsuarioTime2=$aux+3;
						
					// Essa parte do codigo busca aposta do usuario de acordo com o numero do
					//jogo cadastradas dentro do banco de dados.
						
					$aposta = $entityManager->find("Aposta", array(
							"campeonato" =>	$campeonato->getCodCampeonato(),
							"usuario" => $user_id,
							"jogo" => $jogo->getCodJogo()
					));
						
					//Aqui esta buscando os nomes dos times do jogo
					$time = $entityManager->find("Time", $jogo->getCodtime1());
					$time1 = $time->getNomeTime();
					$escudo1 = $time->getEscudo();

					//Aqui esta buscando os nomes dos times do jogo
					$time = $entityManager->find("Time", $jogo->getCodtime2());
					$time2 = $time->getNomeTime();
					$escudo2 = $time->getEscudo();

					//Aqui esta testando se a busca voltou com alguma aposta ou nao

					if ($aposta instanceof Aposta){
						$apostaGolsTime1=$aposta->getApostaGolsTime1();
						$apostaGolsTime2=$aposta->getApostaGolsTime2();
						echo "
						<tr>
						<td class=\"data\" align='center' colspan='7' >
						Em ".$jogo->getDataLogica()." -
						Chute atÃ© ".$jogo->getDataLogicaFimApostas().";
						</td>
						</tr>
						<tr class=\"linha\" align='center'>
						<td class=\"nomeTime\" align=\"right\">
						$time1
						</td>
						<td class=\"coluna\">
						<img class=\"escudo\" src='$escudo1'>
						</td>
						<td class=\"coluna\">
						<INPUT type='hidden' name='$numero_campeonato' value=".$campeonato->getCodCampeonato().">
						<INPUT type='hidden' name='$numeroJogo' value=".$jogo->getCodJogo().">
						<SELECT name=$apostaGolsUsuarioTime1>
						<OPTION VALUE=$apostaGolsTime1>$apostaGolsTime1</OPTION>";
						opcaoUsuario();
						echo "
						</SELECT>
						</td>
						<td class=\"coluna\">
						$imprimeLetraX
						</td>
						<td class=\"coluna\">
						<SELECT name=$apostaGolsUsuarioTime2>
						<OPTION VALUE=$apostaGolsTime2>$apostaGolsTime2</OPTION>";
						opcaoUsuario();
						echo "
						</SELECT>
						</td>
						<td class=\"coluna\">
						<img class=\"escudo\" src='$escudo2'>
						</td>
						<td class=\"nomeTime\" align=\"left\">
						$time2
						</td>
						</tr>";
					}
					else {
						// Esse for serve para imprimir todo os jogos corrente da rodada.
							
						echo "
						<tr>
						<td class=\"data\" align='center' colspan='7' >
						Em ".$jogo->getDataLogica()." -
						Chute atÃ© ".$jogo->getDataLogicaFimApostas().";
						</td>
						</tr>
						<tr class=\"linha\" align='center'>
						<td class=\"nomeTime\" align=\"right\">
						$time1
						</td>
						<td class=\"coluna\">
						<img class=\"escudo\" src='$escudo1'>
						</td>
						<td class=\"coluna\">
						<INPUT type='hidden' name='$numero_campeonato' value=".$campeonato->getCodCampeonato().">
						<INPUT type='hidden' name='$numeroJogo' value=".$jogo->getCodJogo().">
						<SELECT name=$apostaGolsUsuarioTime1>
						<OPTION VALUE=$opcaoVazia>$opcaoVazia</OPTION>";
						opcaoUsuario();
						echo "
						</SELECT>
						</td>
						<td class=\"coluna\">
						$imprimeLetraX
						</td>
						<td class=\"coluna\">
							
						<SELECT name=$apostaGolsUsuarioTime2>
						<OPTION VALUE=$opcaoVazia>$opcaoVazia</OPTION>";
						opcaoUsuario();
						echo "
						</SELECT>
						</td>
						<td class=\"coluna\">
						<img class=\"escudo\" src='$escudo2'>
						</td>
						<td class=\"nomeTime\"  align=\"left\">
						$time2
						</td>
						</tr>";
					}
					$contadorArray++;
				}
				echo "
				<tr>
				<td cellpadding=2 align='center'  colspan='7' >
				<input  type='submit' value='Salvar'>
				</td>
				</tr>
				</form>
				</table>";
			}
		}
	}
	else{
		echo
		"<p align='center'>
		<table id='tabela'>
		<tr class=\"linha\">
		<td class=\"coluna\">
		<p align='center'>Não existem apostas abertas no momento.<br/>
		O início das apostas começa sempre 2 dias antes de cada jogo e encerra 1 hora antes.<br>/
		Volte amanhã para conferir novamente.</p>
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
	<p align='center'>Não existem apostas abertas no momento.<br/>
		O início das apostas começa sempre 2 dias antes de cada jogo e encerra 1 hora antes.<br>/
		Volte amanhã para conferir novamente.</p>
	</td>
	</tr>
	</table>";
}
$conn->close();
/////////////////////////////////////////////////////////////////////////////////////////////////////
?>
