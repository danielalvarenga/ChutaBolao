<?php
require "bootstrap.php";

if(!isset($_POST['campeonatoMenu'])){
	$pontuacaoGeral = $entityManager->find("PontuacaoGeral", $user_id);
	
	$dql = 'SELECT p FROM PontuacaoGeral p WHERE p.classificacaoGeral > 0
			ORDER BY p.classificacaoGeral ASC';
	$rankingPontos = consultaDqlMaxResult(100, $dql);
	
	$dql = 'SELECT p FROM PontuacaoGeral p WHERE p.classificacaoMedalhasGeral > 0
			ORDER BY p.classificacaoMedalhasGeral ASC';
	$rankingMedalhas = consultaDqlMaxResult(100, $dql);
	
	if($pontuacaoGeral instanceof PontuacaoGeral){
		$posicaoPontos = $pontuacaoGeral->getClassificacaoGeral();
		$posicaoMedalhas = $pontuacaoGeral->getClassificacaoMedalhasGeral();
	}
	$classeGeral='todosAtivo';
}
else{
	$premiacoes = $entityManager->find("PremiosUsuario", array(
			"usuario" => $user_id,
			"campeonato" => $_POST['campeonatoMenu']
	));
	
	$dql = 'SELECT p FROM PremiosUsuario p WHERE p.campeonato = '.$_POST['campeonatoMenu'].'
			AND p.classificacaoCampeonato > 0
			ORDER BY p.classificacaoCampeonato ASC';
	$rankingPontos = consultaDqlMaxResult(100, $dql);
	
	$dql = 'SELECT p FROM PremiosUsuario p WHERE p.campeonato = '.$_POST['campeonatoMenu'].'
			AND p.classificacaoMedalhas > 0
			ORDER BY p.classificacaoMedalhas ASC';
	$rankingMedalhas =consultaDqlMaxResult(100, $dql);
	
	if($premiacoes instanceof PremiosUsuario){
		$posicaoPontos = $premiacoes->getClassificacaoCampeonato();
		$posicaoMedalhas = $premiacoes->getClassificacaoMedalhas();
	}
	$classeGeral='todosInativo';
}
$tituloMenu = 'Rankings Disponíveis';
$todosMenu = 'Geral';

?>
<div id="colunaEsquerda">
<?php

if(isset($posicaoPontos) && isset($posicaoMedalhas)){

?>
	<div class="rankingPontos">
		<h3 class="titulo">Pontos</h3>
		<div class="posicaoUsuario">
			Você está na<br/>
			<?php echo $posicaoPontos;?>ª posição
		</div>
		<div class="topoRanking"></div>
					<?php
					$cor = "Escuro";
					foreach($rankingPontos as $colocado) {
						$objValido = false;
						if($colocado instanceof PontuacaoGeral){
							$objValido = true;
							$classificacaoPontos = $colocado->getClassificacaoGeral();
							$classificacaoMedalhas = $colocado->getClassificacaoMedalhasGeral();
							$qtdPontos = $colocado->getPontosGeral();
							$qtdTrofeus = $colocado->getTrofeus();
							$qtdAcertosPlc = $colocado->getAcertosPlacarGeral();
							$qtdAcertosTime = $colocado->getAcertosTimeGanhadorGeral();
							$qtdAcertosInv = $colocado->getAcertosPlacarInvertidoGeral();
							$qtdMedalO = $colocado->getMedalhasOuroGeral();
							$qtdMedalP = $colocado->getMedalhasPrataGeral();
							$qtdMedalB = $colocado->getMedalhasBronzeGeral();
						}
						elseif($colocado instanceof PremiosUsuario){
							$objValido = true;
							$classificacaoPontos = $colocado->getClassificacaoCampeonato();
							$qtdPontos = $colocado->getPontosCampeonato();
							$qtdTrofeus = $colocado->getTrofeu();
							$qtdAcertosPlc = $colocado->getAcertosPlacar();
							$qtdAcertosTime = $colocado->getAcertosTimeGanhador();
							$qtdAcertosInv = $colocado->getAcertosPlacarInvertido();
							$qtdMedalO = $colocado->getMedalhasOuro();
							$qtdMedalP = $colocado->getMedalhasPrata();
							$qtdMedalB = $colocado->getMedalhasBronze();
						}
						if($objValido){
							$nome = $colocado->getUsuario()->getPrimeiroNomeUsuario().' '.
									$colocado->getUsuario()->getSegundoNomeUsuario();
							$id = $colocado->getUsuario()->getIdUsuario();
							$perfil = 'http://www.facebook.com/'.$id;
							$foto = 'https://graph.facebook.com/'.$id.'/picture';
							$parametros = "$id, $qtdPontos, $qtdTrofeus, $qtdAcertosPlc, $qtdAcertosTime,
											$qtdAcertosInv, $qtdMedalO, $qtdMedalP, $qtdMedalB";
							?>
								<div class="classificado<?php echo $cor;?>">
									<div class="posicao"><?php echo $classificacaoPontos;?></div>
									<div class="classificadoFoto"><img class="ranking" src="<?php echo $foto;?>"></div>
									<div class="classificadoNome"><a class="ranking" href="<?php echo $perfil;?>" target="_blank"><?php echo $nome;?></a></div>
									<div class="divisoriaRanking"></div>
								</div>
								<div id="<?php echo $id."Pontos";?>"
									style="font-family:Helvetica, Arial, sans-serif;font-size:10px;color: #000000;
									text-align:center;vertical-align:middle;background-color:#00df00;background:#00df00;
									border:solid 0px #00df00;border-right-width:1px;border-left-width:1px;
									margin-top: 0px;margin-bottom: 0px;padding-top: 2px;padding-bottom: 1px;">
									<div onclick="exibeDadosUsuarioPontos(<?php echo $parametros;?>)" style="cursor:pointer;">
										<img src="imagens/seta-ranking-descer.png">
									</div>
								</div>
								<?php 
							if($cor == "Claro"){
								$cor = "Escuro";
							}
							else{
								$cor = "Claro";
							}
						}
						else{
							?>
							<p class="aviso">Não há nenhum classificado no momento.</p>
							<?php
						}
					}
					?>
			<div class="baseRanking"></div>
	</div>
	<div class="rankingMedalhas">			
		<h3 class="titulo">Medalhas</h3>
		<div class="posicaoUsuario">
			Você está na<br/>
			<?php echo $posicaoMedalhas?>ª posição
		</div>
		<div class="topoRanking"></div>
					<?php		
					$cor = "Escuro";
					foreach($rankingMedalhas as $colocado) {
						$objValido = false;
						if($colocado instanceof PontuacaoGeral){
							$objValido = true;
							$classificacaoMedalhas = $colocado->getClassificacaoMedalhasGeral();
							$qtdPontos = $colocado->getPontosGeral();
							$qtdTrofeus = $colocado->getTrofeus();
							$qtdAcertosPlc = $colocado->getAcertosPlacarGeral();
							$qtdAcertosTime = $colocado->getAcertosTimeGanhadorGeral();
							$qtdAcertosInv = $colocado->getAcertosPlacarInvertidoGeral();
							$qtdMedalO = $colocado->getMedalhasOuroGeral();
							$qtdMedalP = $colocado->getMedalhasPrataGeral();
							$qtdMedalB = $colocado->getMedalhasBronzeGeral();
						}
						elseif($colocado instanceof PremiosUsuario){
							$objValido = true;
							$classificacaoMedalhas = $colocado->getClassificacaoMedalhas();
							$qtdPontos = $colocado->getPontosCampeonato();
							$qtdTrofeus = $colocado->getTrofeu();
							$qtdAcertosPlc = $colocado->getAcertosPlacar();
							$qtdAcertosTime = $colocado->getAcertosTimeGanhador();
							$qtdAcertosInv = $colocado->getAcertosPlacarInvertido();
							$qtdMedalO = $colocado->getMedalhasOuro();
							$qtdMedalP = $colocado->getMedalhasPrata();
							$qtdMedalB = $colocado->getMedalhasBronze();
						}
						if($objValido){
							$nome = $colocado->getUsuario()->getPrimeiroNomeUsuario().' '.
									$colocado->getUsuario()->getSegundoNomeUsuario();
							$id = $colocado->getUsuario()->getIdUsuario();
							$perfil = 'http://www.facebook.com/'.$id;
							$foto = 'https://graph.facebook.com/'.$id.'/picture';
							$parametros = "$id, $qtdPontos, $qtdTrofeus, $qtdAcertosPlc, $qtdAcertosTime,
											$qtdAcertosInv, $qtdMedalO, $qtdMedalP, $qtdMedalB";
							?>
							<div class="classificado<?php echo $cor;?>">
								<div class="posicao"><?php echo $classificacaoMedalhas;?></div>
								<div class="classificadoFoto"><img class="ranking" src="<?php echo $foto;?>"></div>
								<div class="classificadoNome"><a class="ranking" href="<?php echo $perfil;?>" target="_blank"><?php echo $nome;?></a></div>
								<div class="divisoriaRanking"></div>
							</div>
							<div id="<?php echo $id."Medalhas";?>"
								style="font-family:Helvetica, Arial, sans-serif;font-size:10px;color: #000000;
								text-align:center;vertical-align:middle;background-color:#00df00;background:#00df00;
								border:solid 0px #00df00;border-right-width:1px;border-left-width:1px;
								margin-top: 0px;margin-bottom: 0px;padding-top: 2px;padding-bottom: 1px;">
								<div onclick="exibeDadosUsuarioMedalhas(<?php echo $parametros;?>)" style="cursor:pointer;">
									<img src="imagens/seta-ranking-descer.png">
								</div>
							</div>
							<?php
							if($cor == "Claro"){
								$cor = "Escuro";
							}
							else{
								$cor = "Claro";
							}
						}
						else{
							?>
							<p class="aviso">Não há nenhum classificado no momento.</p>
							<?php
						}
					}
					?>
			<div class="baseRanking"></div>
	</div>
<?php
}
else{
	?>
	<p class="aviso">Ainda não existe ranking para este campeonato.</p>
	<?php
}

?>
</div>
<div id="colunaDireita">
<?php
include "includes/menu-campeonatos-ativos.php";
include "includes/menu-campeonatos-inativos.php";
?>
</div>

<script type="text/javascript">
function exibeDadosUsuarioPontos(idUsuario, qtdPontos, qtdTrofeus, qtdAcertosPlc, qtdAcertosTime, qtdAcertosInv, qtdMedalO, qtdMedalP, qtdMedalB){
	imgMedalhaOuro = "imagens/medalha-ouro.png";
	imgMedalhaPrata = "imagens/medalha-prata.png";
	imgMedalhaBronze = "imagens/medalha-bronze.png";
	imgAcertoPlacar = "imagens/acerto-placar.png";
	imgAcertoTimeGanhador = "imagens/acerto-time-ganhador.png";
	imgAcertoPlacarInvertido = "imagens/acerto-placar-invertido.png";
	imgPontos = "imagens/pontos.png";
	imgTrofeus = "imagens/trofeu.png";
	
	idDiv = idUsuario+"Pontos";

	parametros = idUsuario +","+ qtdPontos +","+ qtdTrofeus +","+ qtdAcertosPlc +","+ qtdAcertosTime +","+
					qtdAcertosInv +","+ qtdMedalO +","+ qtdMedalP +","+ qtdMedalB;
	recolher = "<div onclick=\"ocultaDadosUsuarioPontos("
		+parametros+")\" style=\"cursor:pointer;\"><img src=\"imagens/seta-ranking-subir.png\"></div>";
		
	medalhasOuro = "<div class=\"muralRankMedalhas\"><img class=\"muralRankImg\" src=\"" +
					imgMedalhaOuro +
					"\"><span class=\"muralRankQtd\">" + qtdMedalO + " medalhas de ouro</span></div>";
	medalhasPrata = "<div class=\"muralRankMedalhas\"><img class=\"muralRankImg\" src=\"" +
					imgMedalhaPrata +
					"\"><span class=\"muralRankQtd\">" + qtdMedalP + " medalhas de prata</span></div>";
	medalhasBronze = "<div class=\"muralRankMedalhas\"><img class=\"muralRankImg\" src=\"" +
					imgMedalhaBronze +
					"\"><span class=\"muralRankQtd\">" + qtdMedalB + " medalhas de bronze</span></div>";
	acertosPlacar = "<div class=\"muralRankAcertos\"><img class=\"muralRankImg\" src=\"" +
					imgAcertoPlacar +
					"\"><span class=\"muralRankQtd\">" + qtdAcertosPlc + " acertos de placar</span></div>";
	acertosTimeGanhador = "<div class=\"muralRankAcertos\"><img class=\"muralRankImg\" src=\"" +
						imgAcertoTimeGanhador +
						"\"><span class=\"muralRankQtd\">" + qtdAcertosTime + " acertos de ganhador</span></div>";
	acertosPlacarInvertido = "<div class=\"muralRankAcertos\"><img class=\"muralRankImg\" src=\"" +
							imgAcertoPlacarInvertido +
							"\"><span class=\"muralRankQtd\">" + qtdAcertosInv + " acertos invertidos</span></div>";
	pontos = "<div class=\"muralRankPontos\"><img class=\"muralRankImg\" src=\"" +
			imgPontos +
			"\"><span class=\"muralRankQtd\">" + qtdPontos + " pontos</span></div>";
	trofeus = "<div class=\"muralRankTrofeus\"><img class=\"muralRankImg\" src=\"" +
			imgTrofeus +
			"\"><span class=\"muralRankQtd\">" + qtdTrofeus + " troféus</span></div>";

	document.getElementById(idDiv).innerHTML= recolher +"\n"+ pontos +"\n"+ trofeus +"\n"+ acertosPlacar +"\n"+ acertosTimeGanhador +"\n"+
												acertosPlacarInvertido +"\n"+ medalhasOuro +"\n"+
												medalhasPrata +"\n"+ medalhasBronze;
}

function ocultaDadosUsuarioPontos(idUsuario, qtdPontos, qtdTrofeus, qtdAcertosPlc, qtdAcertosTime, qtdAcertosInv, qtdMedalO, qtdMedalP, qtdMedalB){
	idDiv = idUsuario+"Pontos";
	parametros = idUsuario +","+ qtdPontos +","+ qtdTrofeus +","+ qtdAcertosPlc +","+ qtdAcertosTime +","+
				qtdAcertosInv +","+ qtdMedalO +","+ qtdMedalP +","+ qtdMedalB;
	document.getElementById(idDiv).innerHTML="<div onclick=\"exibeDadosUsuarioPontos("
						+parametros+")\" style=\"cursor:pointer;\"><img src=\"imagens/seta-ranking-descer.png\"></div>";
}

function exibeDadosUsuarioMedalhas(idUsuario, qtdPontos, qtdTrofeus, qtdAcertosPlc, qtdAcertosTime, qtdAcertosInv, qtdMedalO, qtdMedalP, qtdMedalB){
	imgMedalhaOuro = "imagens/medalha-ouro.png";
	imgMedalhaPrata = "imagens/medalha-prata.png";
	imgMedalhaBronze = "imagens/medalha-bronze.png";
	imgAcertoPlacar = "imagens/acerto-placar.png";
	imgAcertoTimeGanhador = "imagens/acerto-time-ganhador.png";
	imgAcertoPlacarInvertido = "imagens/acerto-placar-invertido.png";
	imgPontos = "imagens/pontos.png";
	imgTrofeus = "imagens/trofeu.png";
	
	idDiv = idUsuario+"Medalhas";

	parametros = idUsuario +","+ qtdPontos +","+ qtdTrofeus +","+ qtdAcertosPlc +","+ qtdAcertosTime +","+
					qtdAcertosInv +","+ qtdMedalO +","+ qtdMedalP +","+ qtdMedalB;
	recolher = "<div onclick=\"ocultaDadosUsuarioMedalhas("
		+parametros+")\" style=\"cursor:pointer;\"><img src=\"imagens/seta-ranking-subir.png\"></div>";
		
	medalhasOuro = "<div class=\"muralRankMedalhas\"><img class=\"muralRankImg\" src=\"" +
					imgMedalhaOuro +
					"\"><span class=\"muralRankQtd\">" + qtdMedalO + " medalhas de ouro</span></div>";
	medalhasPrata = "<div class=\"muralRankMedalhas\"><img class=\"muralRankImg\" src=\"" +
					imgMedalhaPrata +
					"\"><span class=\"muralRankQtd\">" + qtdMedalP + " medalhas de prata</span></div>";
	medalhasBronze = "<div class=\"muralRankMedalhas\"><img class=\"muralRankImg\" src=\"" +
					imgMedalhaBronze +
					"\"><span class=\"muralRankQtd\">" + qtdMedalB + " medalhas de bronze</span></div>";
	acertosPlacar = "<div class=\"muralRankAcertos\"><img class=\"muralRankImg\" src=\"" +
					imgAcertoPlacar +
					"\"><span class=\"muralRankQtd\">" + qtdAcertosPlc + " acertos de placar</span></div>";
	acertosTimeGanhador = "<div class=\"muralRankAcertos\"><img class=\"muralRankImg\" src=\"" +
						imgAcertoTimeGanhador +
						"\"><span class=\"muralRankQtd\">" + qtdAcertosTime + " acertos de ganhador</span></div>";
	acertosPlacarInvertido = "<div class=\"muralRankAcertos\"><img class=\"muralRankImg\" src=\"" +
							imgAcertoPlacarInvertido +
							"\"><span class=\"muralRankQtd\">" + qtdAcertosInv + " acertos invertidos</span></div>";
	pontos = "<div class=\"muralRankPontos\"><img class=\"muralRankImg\" src=\"" +
			imgPontos +
			"\"><span class=\"muralRankQtd\">" + qtdPontos + " pontos</span></div>";
	trofeus = "<div class=\"muralRankTrofeus\"><img class=\"muralRankImg\" src=\"" +
			imgTrofeus +
			"\"><span class=\"muralRankQtd\">" + qtdTrofeus + " troféus</span></div>";

	document.getElementById(idDiv).innerHTML= recolher +"\n"+ pontos +"\n"+ trofeus +"\n"+ acertosPlacar +"\n"+ acertosTimeGanhador +"\n"+
												acertosPlacarInvertido +"\n"+ medalhasOuro +"\n"+
												medalhasPrata +"\n"+ medalhasBronze;
}

function ocultaDadosUsuarioMedalhas(idUsuario, qtdPontos, qtdTrofeus, qtdAcertosPlc, qtdAcertosTime, qtdAcertosInv, qtdMedalO, qtdMedalP, qtdMedalB){
	idDiv = idUsuario+"Medalhas";
	parametros = idUsuario +","+ qtdPontos +","+ qtdTrofeus +","+ qtdAcertosPlc +","+ qtdAcertosTime +","+
				qtdAcertosInv +","+ qtdMedalO +","+ qtdMedalP +","+ qtdMedalB;
	document.getElementById(idDiv).innerHTML="<div onclick=\"exibeDadosUsuarioMedalhas("
						+parametros+")\" style=\"cursor:pointer;\"><img src=\"imagens/seta-ranking-descer.png\"></div>";
}
</script>