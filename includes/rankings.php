<?php
require "bootstrap.php";


if(!isset($_POST['campeonatoMenu'])){
	$pontuacaoGeral = $entityManager->find("PontuacaoGeral", $user_id);
	
	$dql = 'SELECT p FROM PontuacaoGeral p WHERE p.classificacaoGeral > 0
			ORDER BY p.classificacaoGeral ASC';
	$query = $entityManager->createQuery($dql);
	$query->setMaxResults(100);
	$rankingPontos = $query->getResult();
	
	$dql = 'SELECT p FROM PontuacaoGeral p WHERE p.classificacaoMedalhasGeral > 0
			ORDER BY p.classificacaoMedalhasGeral ASC';
	$query = $entityManager->createQuery($dql);
	$query->setMaxResults(100);
	$rankingMedalhas = $query->getResult();
	
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
	$query = $entityManager->createQuery($dql);
	$query->setMaxResults(100);
	$rankingPontos = $query->getResult();
	
	$dql = 'SELECT p FROM PremiosUsuario p WHERE p.campeonato = '.$_POST['campeonatoMenu'].'
			AND p.classificacaoMedalhas > 0
			ORDER BY p.classificacaoMedalhas ASC';
	$query = $entityManager->createQuery($dql);
	$query->setMaxResults(100);
	$rankingMedalhas = $query->getResult();
	
	if($premiacoes instanceof PremiosUsuario){
		$posicaoPontos = $premiacoes->getClassificacaoCampeonato();
		$posicaoMedalhas = $premiacoes->getClassificacaoMedalhas();
	}
	$classeGeral='todosInativo';
}
$tituloMenu = 'Rankings Disponíveis';
$todosMenu = 'Todos';

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
						}
						elseif($colocado instanceof PremiosUsuario){
							$objValido = true;
							$classificacaoPontos = $colocado->getClassificacaoCampeonato();
						}
						if($objValido){
							$nome =
									$colocado->getUsuario()->getPrimeiroNomeUsuario().' '.
									$colocado->getUsuario()->getSegundoNomeUsuario();
							$id = $colocado->getUsuario()->getIdUsuario();
							$perfil = 'http://www.facebook.com/'.$id;
							$foto = 'https://graph.facebook.com/'.$id.'/picture';
							?>
								<div class="classificado<?php echo $cor;?>">
									<div class="posicao"><?php echo $classificacaoPontos;?></div>
									<div class="classificadoFoto"><img class="ranking" src="<?php echo $foto;?>"></div>
									<div class="classificadoNome"><a class="ranking" href="<?php echo $perfil;?>" target="_blank"><?php echo $nome;?></a></div>
									<div class="divisoriaRanking"></div>
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
						}
						elseif($colocado instanceof PremiosUsuario){
							$objValido = true;
							$classificacaoMedalhas = $colocado->getClassificacaoMedalhas();
						}
						if($objValido){
							$nome =
							$colocado->getUsuario()->getPrimeiroNomeUsuario().' '.
							$colocado->getUsuario()->getSegundoNomeUsuario();
							$id = $colocado->getUsuario()->getIdUsuario();
							$perfil = 'http://www.facebook.com/'.$id;
							$foto = 'https://graph.facebook.com/'.$id.'/picture';
							?>
							<div class="classificado<?php echo $cor;?>">
							<div class="posicao"><?php echo $classificacaoMedalhas;?></div>
								<div class="classificadoFoto"><img class="ranking" src="<?php echo $foto;?>"></div>
								<div class="classificadoNome"><a class="ranking" href="<?php echo $perfil;?>" target="_blank"><?php echo $nome;?></a></div>
								<div class="divisoriaRanking"></div>
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
<?php include "includes/menu-campeonatos-ativos.php";?>
</div>