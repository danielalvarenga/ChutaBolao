<?php
require ("bootstrap.php");

function opcaoUsuario(){
	for($indiceEscolhaUsuario = 0 ; $indiceEscolhaUsuario < 100 ; $indiceEscolhaUsuario++ ){
		echo "<OPTION VALUE=$indiceEscolhaUsuario>$indiceEscolhaUsuario</OPTION>";
	}
}

if(!isset($_POST['campeonatoMenu'])){
	$dqlMenu = "SELECT c FROM Campeonato c WHERE c.status='ativo' ORDER BY c.codCampeonato ASC";
	$classeGeral='todosAtivo';
}
else{
	$dqlMenu = "SELECT c FROM Campeonato c WHERE c.codCampeonato = ".$_POST['campeonatoMenu'];
	$classeGeral='todosInativo';
}
$tituloMenu = 'Campeonatos';
$todosMenu = 'Todos';

if(isset($_POST[0])){
	$conn = $entityManager->getConnection();
	$conn->beginTransaction();
	try{
		$contador=0;
		$contador1=0;
		$jogo_campeonato=$_POST[0];
		$usuario = buscaObjeto("Usuario", $user_id);
		$campeonato= buscaObjeto("Campeonato", $jogo_campeonato);
		
		$contadorPublicacoesMural = 1;
		for ($i=0;$i<sizeof($_POST)>>2;$i++){
			$auxContadorAposta[0]=null;
			$aux=$i <<2;
			$jogo_numero= $_POST[$aux + 1 ];
			$palpite_time1_jogo= $_POST[$aux + 2 ];
			$palpite_time2_jogo= $_POST[$aux + 3 ];
				
			//Busca objeto Jogo, Campeonato e Aposta
				
			$jogo = buscaObjeto("Jogo", $jogo_numero);
			
			$dataAtual = new DateTime('now', new DateTimeZone('America/Sao_Paulo'));
			$dataAgora = $dataAtual->format( "Y-m-d H:i:s" );
			$dataFimApostas = $jogo->getDataFimApostas();
			if($dataAgora < $dataFimApostas){
			
				$apostaCadastrada = buscaObjeto("Aposta", array(
						"campeonato" =>	$jogo_campeonato,
						"usuario" => $user_id,
						"jogo" => $jogo_numero
				));
					
				//Cria um objeto PontuacaoRodada para o Usuario na Rodada do Jogo que apostou se ainda nÃ£o existir
				
				$pontuacaoRodada = buscaObjeto("PontuacaoRodada", array(
						"campeonato" =>	$jogo_campeonato,
						"rodada" => $jogo->getRodada()->getNumRodada(),
						"usuario" => $user_id
				));
				
				if(!($pontuacaoRodada instanceof PontuacaoRodada)){
					$rodada = $jogo->getRodada();
					$pontuacaoRodada = new PontuacaoRodada($rodada, $campeonato, $usuario);
					salvaBancoDados($pontuacaoRodada);
					}

					
				//Cria um objeto PremiosUsuario para o Usuario no Campeonato do Jogo que apostou se ainda nÃ£o existir
	
				$premiosUsuario = buscaObjeto("PremiosUsuario", array(
						"campeonato" =>	$jogo_campeonato,
						"usuario" => $user_id
				));
				if(!$premiosUsuario instanceof PremiosUsuario){
					$premiosUsuario = new PremiosUsuario($usuario, $campeonato);
					salvaBancoDados($premiosUsuario);
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
						atualizaBancoDados($apostaCadastrada);
						$publica = true;
						$contador1++;
						$indice++;
					}
					
					if($apostaCadastrada->getApostaGolsTime2()<>$palpite_time2_jogo){
						$auxContadorAposta[$indice]=$apostaCadastrada->getApostaGolsTime1()."  X  ".$apostaCadastrada->getApostaGolsTime2();
						$apostaCadastrada->setApostaGolsTime2($palpite_time2_jogo);
						$atualizacaoContadorAposta=$apostaCadastrada->getApostaGolsTime1()."  X  ".$palpite_time2_jogo;
						$auxiliar_jogo=$apostaCadastrada->getJogo()->getCodjogo();
						atualizaBancoDados($apostaCadastrada);
						$publica = true;
						$contador1++;
					}
					
					if($auxContadorAposta[0]<>NULL){
						$contadorAposta = buscaObjeto("ContadorAposta", array (
								"campeonato"=>$jogo_campeonato,
								"jogo"=> $auxiliar_jogo,
								"opcaoCadastrada"=>$auxContadorAposta[0]
						));
						if($contadorAposta instanceof ContadorAposta){
							$contadorAposta->decrementaQuantidadeApostas();
							atualizaBancoDados($contadorAposta);
							
							$contadorAposta = buscaObjeto("ContadorAposta", array (
									"campeonato"=>$jogo_campeonato,
									"jogo"=> $auxiliar_jogo,
									"opcaoCadastrada"=>$atualizacaoContadorAposta
							));
						}
						
						//Cria um objeto ContadorAposta para uma Aposta no Campeonato do Jogo que apostou se ainda nÃ£o existir
	
						if ($contadorAposta instanceof ContadorAposta){
							$contadorAposta->incrementaQuantidadeApostas();
							atualizaBancoDados($contadorAposta);
							
						}
						else{
							$novoContadorAposta = new ContadorAposta($atualizacaoContadorAposta,$campeonato,$jogo);
							salvaBancoDados($novoContadorAposta);
							//echo "CHUTA BOL�O";
						}
						
					}
				}
				else{
					if (($palpite_time1_jogo<>'') && ($palpite_time2_jogo<>'')){
						$apostaNova = new Aposta($usuario, $campeonato, $jogo, $palpite_time1_jogo, $palpite_time2_jogo);
						$atualizacaoContadorAposta=$palpite_time1_jogo."  X  ".$palpite_time2_jogo;
						salvaBancoDados($apostaNova);
						$publica = true;
						$contador++;
	
						$contadorAposta = buscaObjeto("ContadorAposta", array (
								"campeonato"=>$jogo_campeonato,
								"jogo"=> $jogo_numero,
								"opcaoCadastrada"=>$atualizacaoContadorAposta
						));
	
						//Cria um objeto ContadorAposta para uma Aposta no Campeonato do Jogo que apostou se ainda nÃ£o existir
	
						if ($contadorAposta instanceof ContadorAposta){
							$contadorAposta->incrementaQuantidadeApostas();
							atualizaBancoDados($contadorAposta);
							
						}
						else{
							$novoContadorAposta= new ContadorAposta($atualizacaoContadorAposta,$campeonato,$jogo);
							salvaBancoDados($novoContadorAposta);
							
						}
					}
				}
			}
			
			$time1 = buscaObjeto("Time", $jogo->getCodtime1());
			$time2 = buscaObjeto("Time", $jogo->getCodtime2());
			if(($time1 === $usuario->getTimeFavorito()) || ($time2 === $usuario->getTimeFavorito())){
				$contadorPublicacoesMural--;
			}
			if(($time1->getNomeTime() == "Brasil") || ($time2->getNomeTime() == "Brasil")){
				$contadorPublicacoesMural--;
			}
			if(($publica) && ($contadorPublicacoesMural <= 3) && (!$teste)){
				if($palpite_time1_jogo > $palpite_time2_jogo){
					$name = $usuario->getPrimeiroNomeUsuario().'
					chuta '.$palpite_time1_jogo.'
					x� '.$palpite_time2_jogo.'
					para o '.$time1->getNomeTime();
				}
				elseif($palpite_time1_jogo < $palpite_time2_jogo){
					$name = $usuario->getPrimeiroNomeUsuario().'
					chuta '.$palpite_time2_jogo.'
					x� '.$palpite_time1_jogo.'
					para o '.$time2->getNomeTime();
				}
				elseif($palpite_time1_jogo == $palpite_time2_jogo){
					$name = $usuario->getPrimeiroNomeUsuario().'
					chuta '.$palpite_time1_jogo.'
					x� '.$palpite_time2_jogo.'
					para '.$time1->getNomeTime().'
					e '.$time2->getNomeTime();
				}

				$picture = 'http://www.chutabolao.com.br/facebook/'.$jogo->getEscudosJogo();
				$link = 'http://apps.facebook.com/chutabolao/?'.$usuario->getIdUsuario().'-'.
					$palpite_time1_jogo.'x'.$palpite_time2_jogo.'-'.$time1->getNomeTime().'-'.$time2->getNomeTime();
				$caption = 'Mostre que voc� sabe mais!';
				$description = "Jogo em ".$jogo->getDataLogica().". Fa�a seu chute at� ".$jogo->getDataLogicaFimApostas();
				
				$ret_obj = $facebook->api('/'.$user_id.'/feed', 'POST',	array(
				 		'link' => utf8_encode($link),
						'name' => utf8_encode($name),
						'picture' => $picture,
						'caption' => utf8_encode($caption),
						'description' => utf8_encode($description)
				 ));
				 
				 $contadorPublicacoesMural++;
			}
			elseif ($dataAgora > $dataFimApostas){
				$time1 = buscaObjeto("Time", $jogo->getCodtime1());
				$time2 = buscaObjeto("Time", $jogo->getCodtime2());
				?>
				<p class="aviso">
					Chutes encerrados para o jogo <?php echo $time1->getNomeTime();?> X <?php echo $time2->getNomeTime();?>.
					Chutes n�o salvos.
				</p>
				<?php
			}
		}
		$conn->commit();
	} catch(Exception $e) {
		desfazTransacao($e);
	}
	$conn->close();
}


/////////////////////////////////////////////////////////////////////////////////////////////////////
?>
<div id="colunaEsquerda">
<?php
$conn = $entityManager->getConnection();
$conn->beginTransaction();
try{
	$dataAgora = new DateTime('now', new DateTimeZone('America/Sao_Paulo'));
	$dataAtual = $dataAgora->format( "Y-m-d H:i:s" );
	
	$semChutes = true;
	
	$campeonatos=consultaDql($dqlMenu);
	foreach ($campeonatos as $campeonato){
		if($campeonato instanceof Campeonato){
			?>
			<h3 class="titulo"><?php echo $campeonato->getNomeCampeonato().' '.$campeonato->getAnoCampeonato();?></h3>
			<?php 
			$opcaoVazia='';
			
			//Essa parte do codigo busca os jogos cadastradas dentro do banco de dados.
			$codCampeonato = $campeonato->getCodCampeonato();
			$dql = "SELECT j FROM Jogo j WHERE j.dataInicioApostas <= '$dataAtual' 
			AND j.dataFimApostas >= '$dataAtual'
			AND j.campeonato = '$codCampeonato'
			ORDER BY j.dataJogo ASC";
			$jogos = consultaDql($dql);

			//Aqui esta testando se a busca voltou com algum jogo ou nao

			if($jogos<>NULL){
				$semChutes = false;
				?>
				<div id="jogos">
					<form action="" method="POST" >
				<?php
				$contadorArray=0;

				foreach ($jogos as $jogo){
					$aux=$contadorArray << 2;
					$numero_campeonato= $aux ;
					$numeroJogo= $aux+1;
					$apostaGolsUsuarioTime1=$aux+2;
					$apostaGolsUsuarioTime2=$aux+3;
						
					// Essa parte do codigo busca aposta do usuario de acordo com o numero do
					//jogo cadastradas dentro do banco de dados.
						
					$aposta = buscaObjeto("Aposta", array(
							"campeonato" =>	$campeonato->getCodCampeonato(),
							"usuario" => $user_id,
							"jogo" => $jogo->getCodJogo()
					));
						
					//Aqui esta buscando os nomes dos times do jogo
					$time = buscaObjeto("Time", $jogo->getCodtime1());
					$rendimentoTime1 = buscaObjeto("RendimentoTime", $codCampeonato."x".$jogo->getCodtime1());
					$time1 = $time->getNomeTime();
					$escudo1 = $time->getEscudo();

					//Aqui esta buscando os nomes dos times do jogo
					$time = buscaObjeto("Time", $jogo->getCodtime2());
					$rendimentoTime2 = buscaObjeto("RendimentoTime", $codCampeonato."x".$jogo->getCodtime2());
					$time2 = $time->getNomeTime();
					$escudo2 = $time->getEscudo();

					//Aqui esta testando se a busca voltou com alguma aposta ou nao

					if ($aposta instanceof Aposta){
						$apostaGolsTime1=$aposta->getApostaGolsTime1();
						$apostaGolsTime2=$aposta->getApostaGolsTime2();
						
						?>
						
							<span class="dataJogo">Em <?php echo $jogo->getDataLogica();?></span>
							<span class="statusJogo">Chute at� <?php echo $jogo->getDataLogicaFimApostas();?></span>
						<div class="jogoLiberado">
							<span class="nomeTimeChutes"><?php echo $time1;?></span>
							<img class="escudoTime" src="<?php echo $escudo1;?>">
							<div class="chute">
								<INPUT type='hidden' name="<?php echo $numero_campeonato;?>" value="<?php echo $campeonato->getCodCampeonato();?>">
								<INPUT type='hidden' name="<?php echo $numeroJogo;?>" value="<?php echo $jogo->getCodJogo();?>">
								<SELECT name="<?php echo $apostaGolsUsuarioTime1;?>">
								<OPTION VALUE="<?php echo $apostaGolsTime1;?>"><?php echo $apostaGolsTime1;?></OPTION>
								<?php echo opcaoUsuario();?>
								</SELECT>
							</div>
							<span class="letraX">X</span>
							<div class="chute">
								<SELECT name="<?php echo $apostaGolsUsuarioTime2;?>">
								<OPTION VALUE="<?php echo $apostaGolsTime2;?>"><?php echo $apostaGolsTime2;?></OPTION>
								<?php echo opcaoUsuario();?>
								</SELECT>
							</div>
							<img class="escudoTime" src="<?php echo $escudo2;?>">
							<span class="nomeTimeChutes"><?php echo $time2?></span>
							<button class="okChutes" type="submit" value="salvar">OK</button>
							</div>
							<div class="botaoRendimento" style="height: 10px;">
								<span class="classificacaoTimeFavorito" style="font-size: 10px;">ver rendimentos dos times</span>
							</div>
							<div class="rendimentos">
								<div class="rendimentoTimeChute">
									<?php if(substr_count($campeonato->getNomeCampeonato(), 'Brasileir�o') > 0) {?>
										<div class="classificacaoTimeFavorito"><?php echo $rendimentoTime1->getClassificacao()."� no Campeonato";?></div>
									<?php }?>
									<div class="divisoriaTimeFavorito"></div>
									<div class="infoRendimento" title="Vit�rias"><?php echo "V ".$rendimentoTime1->getVitorias();?></div>
									<div class="infoRendimento" title="Empates"><?php echo "E ".$rendimentoTime1->getEmpates();?></div>
									<div class="infoRendimento" title="Derrotas"><?php echo "D ".$rendimentoTime1->getDerrotas();?></div>
									<div style="clear: both;"></div>
									<div class="infoRendimento" title="Gols Pr�"><?php echo "GP ".$rendimentoTime1->getGolsPro();?></div>
									<div class="infoRendimento" title="Gols Contra"><?php echo "GC ".$rendimentoTime1->getGolsContra();?></div>
									<div class="infoRendimento" title="Saldo de Gols"><?php echo "SG ".$rendimentoTime1->getSaldoGols();?></div>
								</div>
								<div class="divisoriaRendimentoTime"></div>
								<div class="rendimentoTimeChute">
									<?php if(substr_count($campeonato->getNomeCampeonato(), 'Brasileir�o') > 0) {?>
										<div class="classificacaoTimeFavorito"><?php echo $rendimentoTime2->getClassificacao()."� no Campeonato";?></div>
									<?php }?>
									<div class="divisoriaTimeFavorito"></div>
									<div class="infoRendimento" title="Vit�rias"><?php echo "V ".$rendimentoTime2->getVitorias();?></div>
									<div class="infoRendimento" title="Empates"><?php echo "E ".$rendimentoTime2->getEmpates();?></div>
									<div class="infoRendimento" title="Derrotas"><?php echo "D ".$rendimentoTime2->getDerrotas();?></div>
									<div style="clear: both;"></div>
									<div class="infoRendimento" title="Gols Pr�"><?php echo "GP ".$rendimentoTime2->getGolsPro();?></div>
									<div class="infoRendimento" title="Gols Contra"><?php echo "GC ".$rendimentoTime2->getGolsContra();?></div>
									<div class="infoRendimento" title="Saldo de Gols"><?php echo "SG ".$rendimentoTime2->getSaldoGols();?></div>
								</div>
							</div>
							<div class="divisoria"></div>
						
						<?php
						
					}
					else {
						// Esse for serve para imprimir todo os jogos corrente da rodada.
						
						?>
												
						<span class="dataJogo">Em <?php echo $jogo->getDataLogica();?></span>
						<span class="statusJogo">Chute at� <?php echo $jogo->getDataLogicaFimApostas();?></span>
						<div class="jogoLiberado">
							<span class="nomeTimeChutes"><?php echo $time1;?></span>
							<img class="escudoTime" src="<?php echo $escudo1;?>">
							<div class="chute">
								<INPUT type='hidden' name="<?php echo $numero_campeonato;?>" value="<?php echo $campeonato->getCodCampeonato();?>">
								<INPUT type='hidden' name="<?php echo $numeroJogo;?>" value="<?php echo $jogo->getCodJogo();?>">
								<SELECT name="<?php echo $apostaGolsUsuarioTime1;?>">
								<OPTION VALUE="<?php echo $opcaoVazia;?>"><?php echo $opcaoVazia;?></OPTION>
								<?php echo opcaoUsuario();?>
								</SELECT>
							</div>
							<span class="letraX">X</span>
							<div class="chute">
								<SELECT name="<?php echo $apostaGolsUsuarioTime2;?>">
								<OPTION VALUE="<?php echo $opcaoVazia;?>"><?php echo $opcaoVazia;?></OPTION>
								<?php echo opcaoUsuario();?>
								</SELECT>
							</div>
							<img class="escudoTime" src="<?php echo $escudo2;?>">
							<span class="nomeTimeChutes"><?php echo $time2?></span>
							<button class="okChutes" type="submit" value="salvar">OK</button>
						</div>
						<div class="botaoRendimento" style="height: 10px;">
							<span class="classificacaoTimeFavorito" style="font-size: 10px;">ver rendimentos dos times</span>
						</div>
						<div class="rendimentos">
								<div class="rendimentoTimeChute">
									<?php if(substr_count($campeonato->getNomeCampeonato(), 'Brasileir�o') > 0) {?>
										<div class="classificacaoTimeFavorito"><?php echo $rendimentoTime1->getClassificacao()."� no Campeonato";?></div>
									<?php }?>
									<div class="divisoriaTimeFavorito"></div>
									<div class="infoRendimento" title="Vit�rias"><?php echo "V ".$rendimentoTime1->getVitorias();?></div>
									<div class="infoRendimento" title="Empates"><?php echo "E ".$rendimentoTime1->getEmpates();?></div>
									<div class="infoRendimento" title="Derrotas"><?php echo "D ".$rendimentoTime1->getDerrotas();?></div>
									<div style="clear: both;"></div>
									<div class="infoRendimento" title="Gols Pr�"><?php echo "GP ".$rendimentoTime1->getGolsPro();?></div>
									<div class="infoRendimento" title="Gols Contra"><?php echo "GC ".$rendimentoTime1->getGolsContra();?></div>
									<div class="infoRendimento" title="Saldo de Gols"><?php echo "SG ".$rendimentoTime1->getSaldoGols();?></div>
								</div>
								<div class="divisoriaRendimentoTime"></div>
								<div class="rendimentoTimeChute">
									<?php if(substr_count($campeonato->getNomeCampeonato(), 'Brasileir�o') > 0) {?>
										<div class="classificacaoTimeFavorito"><?php echo $rendimentoTime2->getClassificacao()."� no Campeonato";?></div>
									<?php }?>
									<div class="divisoriaTimeFavorito"></div>
									<div class="infoRendimento" title="Vit�rias"><?php echo "V ".$rendimentoTime2->getVitorias();?></div>
									<div class="infoRendimento" title="Empates"><?php echo "E ".$rendimentoTime2->getEmpates();?></div>
									<div class="infoRendimento" title="Derrotas"><?php echo "D ".$rendimentoTime2->getDerrotas();?></div>
									<div style="clear: both;"></div>
									<div class="infoRendimento" title="Gols Pr�"><?php echo "GP ".$rendimentoTime2->getGolsPro();?></div>
									<div class="infoRendimento" title="Gols Contra"><?php echo "GC ".$rendimentoTime2->getGolsContra();?></div>
									<div class="infoRendimento" title="Saldo de Gols"><?php echo "SG ".$rendimentoTime2->getSaldoGols();?></div>
								</div>
							</div>
							<div class="divisoria"></div>
						
						<?php
							
					}
					$contadorArray++;
				}
				?>
				<p><button class="salvarChutes" type="submit" value="salvar">Salvar Todos</button></p>
				</form>
				</div>
				
				<?php
			}
			?>
			<div class="divisoriaCampeonatos"></div>
			<?php
			if($semChutes){
				?>
				<p class="aviso">
					Aguardando novos jogos.<br/>
					O in�cio dos chutes come�a sempre 2 dias antes de cada jogo e encerra 1 hora antes.<br/></p>
				<?php
			}
		}
	}
	$conn->commit();
} catch(Exception $e) {
	desfazTransacao($e);
	?>
	<p class="aviso">N�o existem jogos liberados no momento.</p>
	<?php
}
$conn->close();
/////////////////////////////////////////////////////////////////////////////////////////////////////
?>
</div>
<div id="colunaDireita">
<?php include "includes/menu-campeonatos-ativos.php";?>
</div>
<?php
if(isset($contador) || isset($contador1)){
	if($contador>0){
		echo "<script> alert('Chute realizado com sucesso.'); </script>";
	}
	if($contador1>0){
		echo "<script> alert('Chute atualizado com sucesso.'); </script>";
	}
}
?>
<div id="fundoOpaco" style="position: absolute; top:0px; left: 0px; width: 100%; height: 100%; z-index:5; background-image: url('imagens/fundo-black-85opaco.png');">
<div id="espera" style="width: 100px; height: 120px; margin-left: -50px; margin-top: -60px;position: fixed; top: 50%; left: 50%; z-index:; background-color: #ffffff; border:solid 0px #000000; -moz-border-radius: 10px; -webkit-border-radius: 10px;border-radius: 10px;">
<img style="margin-top: 25px; margin-left: 25px; margin-right: 25px;" src="imagens/espera.gif" />
<p class="aviso" style="background-color: #ffffff;">salvando...</p>
</div>
</div>

<script>
	$('.rendimentos').hide();
	$('#fundoOpaco').hide();
	$('#espera').hide();
	
	$('.salvarChutes').click(function() {
		$('html, body').animate({ scrollTop: 0 }, 0);
		$('#fundoOpaco').show();
		$('#espera').show();
	});

	$('.okChutes').click(function() {
		$('html, body').animate({ scrollTop: 0 }, 0);
		$('#fundoOpaco').show();
		$('#espera').show();
	});

	$('.jogoLiberado').click(function() {
		$(this).next().toggle("speed");
		$(this).next().next().toggle("speed");
	});

	$('.botaoRendimento').click(function() {
		$(this).toggle("speed");
		$(this).next().toggle("speed");
	});

	$('.rendimentos').click(function() {
		$('.botaoRendimento').show("speed");
		$(this).toggle("speed");
	});

</script>