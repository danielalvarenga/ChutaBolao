<?php

$pontuacaoGeral = $entityManager->find("PontuacaoGeral", $user_id);

$dql = "SELECT p FROM PremiosUsuario p WHERE p.usuario = $user_id";
$query = $entityManager->createQuery($dql);
$premiosUsuario = $query->getResult();

if(!isset($_POST['campeonato'])){
	$dql = "SELECT p FROM PontuacaoGeral p ORDER BY p.classificacaoGeral DESC";
	$query->setMaxResults(100);
	$query = $entityManager->createQuery($dql);
	$rankingPontos = $query->getResult();
	
	$dql = "SELECT p FROM PontuacaoGeral p ORDER BY p.classificacaoMedalhasGeral DESC";
	$query->setMaxResults(100);
	$query = $entityManager->createQuery($dql);
	$rankingMedalhas = $query->getResult();
	
	$classeGeral='rankingAtivo';
}
else{
	$dql = 'SELECT p FROM PremiosUsuario p WHERE p.campeonato = '.$_POST['campeonato'].'
			ORDER BY p.classificacaoCampeonato DESC';
	$query->setMaxResults(100);
	$query = $entityManager->createQuery($dql);
	$rankingPontos = $query->getResult();
	
	$dql = 'SELECT p FROM PremiosUsuario p WHERE p.campeonato = '.$_POST['campeonato'].'
			ORDER BY p.classificacaoMedalhas DESC';
	$query->setMaxResults(100);
	$query = $entityManager->createQuery($dql);
	$rankingMedalhas = $query->getResult();
	
	$classeGeral='rankingInativo';
}

?>

<center>
	<table id="tabelaExternaRanking">
		<tr>
			<td>
				<table class="tabelaRankingPontos" cellspacing="0" cellpadding="0">
					<tr>
						<td>
						<caption>PONTOS</caption>
						</td>
					</tr>
					<?php
					$valor = 1;
					foreach($rankingPontos as $colocado) {
						$objValido = false;
						if($colocado instanceof PontuacaoGeral){
							$objValido = true;
							$classificacaoPontos = $colocado->getClassificacaoGeral();
						}
						elseif($colocado instanceof PremiosUsuario){
							$objValido = true;
							$classificacaoPontos = $colocado->getClassificacaoCampeonato();
						}
						if($objValido){
							$nome =
									$colocado->getUsuario()->getPrimeiroNomeUsuario().' '.
									$colocado->getUsuario()->getSegundoNomeUsuario();
							$perfil = 'http://www.facebook.com/'.$colocado->getUsuario()->getIdUsuario();
							echo'
							<tr>
								<td class="rankingPontosClassificacao'.$valor.'">
									'.$classificacaoPontos.'
								</td>
								<td class="rankingPontosNome'.$valor.'">
									<a class="ranking" href="'.$perfil.'" target="_blank">'.$nome.'</a>
								</td>';
							if($valor == 1){
								$valor = 2;
							}
							else{
								$valor = 1;
							}
						}
						else{
							echo'
								<td class="rankingPontosClassificacao'.$valor.'">
									0
								</td>
								<td class="rankingPontosNome'.$valor.'">
									Não há nenhum classificado no momento.
								</td>
							</tr>';
						}
					}
					?>
					</tr>
				</table>
			</td>
			<td width="5px">
			</td>
			<td>
				<table class="tabelaRankingMedalhas" cellspacing="0" cellpadding="0">
					<tr>
						<td>
						<caption>MEDALHAS</caption>
						</td>
					</tr>
					<?php		
					$valor = 1;
					foreach($rankingMedalhas as $colocado) {
						$objValido = false;
						if($colocado instanceof PontuacaoGeral){
							$objValido = true;
							$classificacaoMedalhas = $colocado->getClassificacaoMedalhasGeral();
						}
						elseif($colocado instanceof PremiosUsuario){
							$objValido = true;
							$classificacaoMedalhas = $colocado->getClassificacaoMedalhas();
						}
						if($objValido){
							$nome =
							$colocado->getUsuario()->getPrimeiroNomeUsuario().' '.
							$colocado->getUsuario()->getSegundoNomeUsuario();
							$perfil = 'http://www.facebook.com/'.$colocado->getUsuario()->getIdUsuario();
							echo'
							<tr>
								<td class="rankingMedalhasClassificacao'.$valor.'">
									'.$classificacaoMedalhas.'
								</td>
								<td class="rankingMedalhasNome'.$valor.'">
									<a class="ranking" href="'.$perfil.'" target="_blank">'.$nome.'</a>
								</td>';
							if($valor == 1){
								$valor = 2;
							}
							else{
								$valor = 1;
							}
						}
						else{
							echo'
								<td class="rankingMedalhasClassificacao'.$valor.'">
									0
								</td>
								<td class="rankingMedalhasNome'.$valor.'">
									Não há nenhum classificado no momento.
								</td>
							</tr>';
						}
					}
					?>
				</table>
			</td>
			<td width="5px">
			</td>
			<td>
				<table class="tabelaOpcoesRanking" cellspacing="0" cellpadding="0">
				<tr>
						<td colspan="3">
						<h6>clique no campeonato para abrir</h6>
						</td>
					</tr>
					<tr>
						<td class="<?php echo $classeGeral;?>" rowspan="2">
							<?php echo "<<";?>
						</td>
						<td class="nomeRanking" rowspan="2">
							<form name="formRankingGeral" action="" method="POST">
								<!-- <input type="hidden" name="geral" value="geral"> -->
								<button type="submit" name="geral" value="geral">Ranking Geral</button><br/>
							</form>
						</td>
						<td class="posicaoPontos">
							<span class="descricaoPosicao">PONTOS<br/></span>
							<?php echo $pontuacaoGeral->getClassificacaoGeral();?>ª posição
						</td>
					</tr>
					<tr>
						<td class="posicaoMedalhas">
							<span class="descricaoPosicao">MEDALHAS<br/></span>
							<?php echo $pontuacaoGeral->getClassificacaoMedalhasGeral();?>ª posição
						</td>
					</tr>
					<?php
					foreach($premiosUsuario as $premiacoes) {
						if($premiacoes instanceof PremiosUsuario){
							$statusCampeonato = $premiacoes->getCampeonato()->getStatus();
							$classe = 'rankingInativo';
							if(isset($_POST['campeonato'])){
								if($_POST['campeonato'] == $premiacoes->getCampeonato()->getCodCampeonato()){
									$classe = 'rankingAtivo';
								}
							}
							if($statusCampeonato == "ativo"){
								?>
								<tr>
									<td height="10px" cowspan="3">
									</td>
								</tr>
								<tr>
									<td class="<?php echo $classe;?>" rowspan="2">
										<?php echo "<<";?>
									</td>
									<td class="nomeRanking" rowspan="2">
										<form name="<?php echo 'form'.$premiacoes->getCampeonato()->getCodCampeonato();?>" action="" method="POST">
											<button type="submit" name="campeonato" value="<?php echo $premiacoes->getCampeonato()->getCodCampeonato();?>">
													Ranking <?php echo $premiacoes->getCampeonato()->getNomeCampeonato();?>
											</button>
										</form>
									</td>
									<td class="posicaoPontos">
										<span class="descricaoPosicao">PONTOS<br/></span>
										<?php echo $premiacoes->getClassificacaoCampeonato();?>ª posição
									</td>
								</tr>
								<tr>
									<td class="posicaoMedalhas">
										<span class="descricaoPosicao">MEDALHAS<br/></span>
										<?php echo $premiacoes->getClassificacaoMedalhas();?>ª posição
									</td>
								</tr>
								<?php
							}
						}
					}
					
					?>
				</table>
			</td>
		</tr>
	</table>
</center>