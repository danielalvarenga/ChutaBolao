<?php
require ("bootstrap.php");

function opcaoUsuario(){
	for($indiceEscolhaUsuario = 0 ; $indiceEscolhaUsuario < 100 ; $indiceEscolhaUsuario++ ){
		echo "<OPTION VALUE=$indiceEscolhaUsuario>$indiceEscolhaUsuario</OPTION>";
	}
}

if(!isset($_POST['campeonatoMenu'])){
	$dqlMenu = "SELECT c FROM Campeonato c WHERE c.status='ativo'";
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
					
				//Cria um objeto PontuacaoRodada para o Usuario na Rodada do Jogo que apostou se ainda nÃƒÂ£o existir
					
				$pontuacaoRodada = buscaObjeto("PontuacaoRodada", array(
						"campeonato" =>	$jogo_campeonato,
						"rodada" => $jogo->getRodada()->getNumRodada(),
						"usuario" => $user_id
				));
				if(!$pontuacaoRodada instanceof PontuacaoRodada){
					$pontuacaoRodada = new PontuacaoRodada($jogo->getRodada(), $campeonato, $usuario);
					salvaBancoDados($pontuacaoRodada);
					}
					
				//Cria um objeto PremiosUsuario para o Usuario no Campeonato do Jogo que apostou se ainda nÃƒÂ£o existir
	
				$premiosUsuario = buscaObjeto("PremiosUsuario", array(
						"campeonato" =>	$jogo_campeonato,
						"usuario" => $user_id
				));
				if(!$premiosUsuario instanceof PremiosUsuario){
					$premiosUsuario = new PremiosUsuario($usuario, $campeonato);
					salvaBancoDados($premiosUsuario);
					}
					
				//Cria nova aposta se ainda nÃƒÂ£o existir
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
						
						//Cria um objeto ContadorAposta para uma Aposta no Campeonato do Jogo que apostou se ainda nÃƒÂ£o existir
	
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
				else{
					if (($palpite_time1_jogo<>'') && ($palpite_time2_jogo<>'')){
						$apostaNova = new Aposta($usuario, $campeonato, $jogo);
						$atualizacaoContadorAposta=$palpite_time1_jogo."  X  ".$palpite_time2_jogo;
						$apostaNova->setApostaGolsTime1($palpite_time1_jogo);
						$apostaNova->setApostaGolsTime2($palpite_time2_jogo);
						salvaBancoDados($apostaNova);
						$publica = true;
						$contador++;
	
						$contadorAposta = buscaObjeto("ContadorAposta", array (
								"campeonato"=>$jogo_campeonato,
								"jogo"=> $jogo_numero,
								"opcaoCadastrada"=>$atualizacaoContadorAposta
						));
	
						//Cria um objeto ContadorAposta para uma Aposta no Campeonato do Jogo que apostou se ainda nÃƒÂ£o existir
	
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
				
			if($publica && $contadorPublicacoesMural <= 3){
				if($palpite_time1_jogo > $palpite_time2_jogo){
					$time1 = buscaObjeto("Time", $jogo->getCodtime1());
					$name = $usuario->getPrimeiroNomeUsuario().'
					chuta '.$palpite_time1_jogo.'
					x  '.$palpite_time2_jogo.'
					para o '.$time1->getNomeTime();
				}
				elseif($palpite_time1_jogo < $palpite_time2_jogo){
					$time2 = buscaObjeto("Time", $jogo->getCodtime2());
					$name = $usuario->getPrimeiroNomeUsuario().'
					chuta '.$palpite_time2_jogo.'
					x  '.$palpite_time1_jogo.'
					para o '.$time2->getNomeTime();
				}
				elseif($palpite_time1_jogo == $palpite_time2_jogo){
					$time1 = buscaObjeto("Time", $jogo->getCodtime1());
					$time2 = buscaObjeto("Time", $jogo->getCodtime2());
					$name = $usuario->getPrimeiroNomeUsuario().'
					chuta '.$palpite_time1_jogo.'
					x  '.$palpite_time2_jogo.'
					para '.$time1->getNomeTime().'
					e '.$time2->getNomeTime();
				}

				$picture = 'http://www.chutabolao.com.br/facebook/'.$jogo->getEscudosJogo();
				$link = 'http://apps.facebook.com/chutabolao';
				$caption = 'Mostre que você sabe mais!';
				$description = "Jogo em ".$jogo->getDataLogica().". Faça seu chute até ".$jogo->getDataLogicaFimApostas();
				
					$ret_obj = $facebook->api('/me/feed', 'POST',	array(
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
					Chutes não salvos.
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
if(isset($contador) || isset($contador1)){
	if($contador>0){
		?>
		<p class="aviso">Aposta realizada com sucesso</p>
		<?php 
	}
	if($contador1>0){
		?>
		<p class="aviso">Aposta atualizada com sucesso</p>
		<?php
	}
}
$conn = $entityManager->getConnection();
$conn->beginTransaction();
try{
	$dataAgora = new DateTime('now', new DateTimeZone('America/Sao_Paulo'));
	$dataAtual = $dataAgora->format( "Y-m-d H:i:s" );
	
	$semChutes = true;
	
	$campeonatos=consultaDql($dqlMenu);
	foreach ($campeonatos as $campeonato){
		if($campeonato instanceof Campeonato){

			$opcaoVazia='';
			
			//Essa parte do codigo busca os jogos cadastradas dentro do banco de dados.

			$dql = "SELECT j FROM Jogo j WHERE'$dataAtual'>= j.dataInicioApostas AND '$dataAtual
			'<=j.dataFimApostas AND j.campeonato=".$campeonato->getCodCampeonato()." ORDER BY j.dataJogo ASC";
			$jogos = consultaDql($dql);

			//Aqui esta testando se a busca voltou com algum jogo ou nao

			if($jogos<>NULL){
				$semChutes = false;
				?>
				<div id="jogos">
					<h3 class="titulo"><?php echo $campeonato->getNomeCampeonato().' '.$campeonato->getAnoCampeonato();?></h3>
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
					$time1 = $time->getNomeTime();
					$escudo1 = $time->getEscudo();

					//Aqui esta buscando os nomes dos times do jogo
					$time = buscaObjeto("Time", $jogo->getCodtime2());
					$time2 = $time->getNomeTime();
					$escudo2 = $time->getEscudo();

					//Aqui esta testando se a busca voltou com alguma aposta ou nao

					if ($aposta instanceof Aposta){
						$apostaGolsTime1=$aposta->getApostaGolsTime1();
						$apostaGolsTime2=$aposta->getApostaGolsTime2();
						
						?>
						
							<span class="dataJogo">Em <?php echo $jogo->getDataLogica();?></span>
							<span class="statusJogo">Chute até <?php echo $jogo->getDataLogicaFimApostas();?></span>
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
							<div class="divisoria"></div>
							</div>
						
						<?php
						
					}
					else {
						// Esse for serve para imprimir todo os jogos corrente da rodada.
						
						?>
												
						<span class="dataJogo">Em <?php echo $jogo->getDataLogica();?></span>
						<span class="statusJogo">Chute até <?php echo $jogo->getDataLogicaFimApostas();?></span>
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
							<div class="divisoria"></div>
						</div>
						
						<?php
							
					}
					$contadorArray++;
				}
				?>
				<p><button class="salvarChutes" type="submit" value="salvar">Salvar Todos</button></p>
				</form>
				</div>
				<div class="divisoriaCampeonatos"></div>
				<?php
			}
		}
		if($semChutes){
			?>
			<p class="aviso">
				Não existem jogos liberados no momento.<br/>
				O início dos chutes começa sempre 2 dias antes de cada jogo e encerra 1 hora antes.<br/>
				Volte amanhã para conferir novamente.</p>
			<?php
			break;
		}
	}
	$conn->commit();
} catch(Exception $e) {
	desfazTransacao($e);
	?>
	<p class="aviso">Não existem jogos liberados no momento.</p>
	<?php
}
$conn->close();
/////////////////////////////////////////////////////////////////////////////////////////////////////
?>
</div>
<div id="colunaDireita">
<?php include "includes/menu-campeonatos-ativos.php";?>
</div>
