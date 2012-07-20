<div id="homeTimesFavoritos">
<?php 
require 'metodos-bd.php';

		$dql = "SELECT t FROM Time t WHERE t.nomeTime <> 'Boca Juniors' ORDER BY t.nomeTime ASC";
		$times = consultaDqlMaxResult(20, $dql);
		foreach($times as $time) {
			?>
			<img class="timeFavorito" src="<?php echo $time->getEscudo();?>">
			<?php 
		}
?>
</div>
<div id="colunaEsquerda">
<?php
$conn = $entityManager->getConnection();
$conn->beginTransaction();
try{
	$imgMedalhaOuro = "imagens/medalha-ouro.png";
	$imgMedalhaPrata = "imagens/medalha-prata.png";
	$imgMedalhaBronze = "imagens/medalha-bronze.png";
	$imgAcertoPlacar = "imagens/acerto-placar.png";
	$imgAcertoTimeGanhador = "imagens/acerto-time-ganhador.png";
	$imgAcertoPlacarInvertido = "imagens/acerto-placar-invertido.png";
	$imgPontos = "imagens/pontos.png";
	$imgTrofeus = "imagens/trofeu.png";
	
	$pontuacaoGeral = $entityManager->find("PontuacaoGeral", $user_id);
	
?>	
	<div class="titulo">Suas Conquistas</div>
	<div id="mural">
		<div class="tituloMural">
			Conquistas até Hoje
		</div>
		
		<div class="divisoriaMural"></div>
		
		<div class="muralTrofeus">
			<img class="muralImg" src="<?php echo $imgTrofeus;?>">
			<span class="muralQtd"><?php echo $pontuacaoGeral->getTrofeus();?> troféus conquistados</span>
		</div>
		
		<div class="divisoriaMural"></div>
		
		<div class="muralPontos">
			<img class="muralImg" src="<?php echo $imgPontos;?>">
			<span class="muralQtd"><?php echo $pontuacaoGeral->getPontosGeral();?> pontos conquistados</span>
		</div>
		
		<div class="divisoriaMural"></div>
		
		<div class="muralAcertos">
			<img class="muralImg" src="<?php echo $imgAcertoPlacar;?>">
			<span class="muralQtd"><?php echo $pontuacaoGeral->getAcertosPlacarGeral();?> placares corretos</span>
		</div>
		<div class="muralAcertos">
			<img class="muralImg" src="<?php echo $imgAcertoTimeGanhador;?>">
			<span class="muralQtd"><?php echo $pontuacaoGeral->getAcertosTimeGanhadorGeral();?> acertos de ganhador</span>
		</div>
		<div class="muralAcertos">
			<img class="muralImg" src="<?php echo $imgAcertoPlacarInvertido;?>">
			<span class="muralQtd"><?php echo $pontuacaoGeral->getAcertosPLacarInvertidoGeral();?> placares invertidos</span>
		</div>
		
		<div class="divisoriaMural"></div>
		
		<div class="muralMedalhas">
			<img class="muralImg" src="<?php echo $imgMedalhaOuro;?>">
			<span class="muralQtd"><?php echo $pontuacaoGeral->getMedalhasOuroGeral();?> medalhas de ouro</span>
		</div>
		<div class="muralMedalhas">
			<img class="muralImg" src="<?php echo $imgMedalhaPrata;?>">
			<span class="muralQtd"><?php echo $pontuacaoGeral->getMedalhasPrataGeral();?> medalhas de prata</span>
		</div>
		<div class="muralMedalhas">
			<img class="muralImg" src="<?php echo $imgMedalhaBronze;?>">
			<span class="muralQtd"><?php echo $pontuacaoGeral->getMedalhasBronzeGeral();?> medalhas de bronze</span>
		</div>
	</div>
	<?php 
	
	$dql = "SELECT p FROM PremiosUsuario p WHERE p.usuario = $user_id";
	$premiosUsuario = consultaDql($dql);
	foreach($premiosUsuario as $premiacoes) {
		if($premiacoes instanceof PremiosUsuario){
			$statusCampeonato = $premiacoes->getCampeonato()->getStatus();
			if($statusCampeonato == "ativo"){
	?>
				<div id="mural">
					<img class="muralLogoCampeonato" src="<?php echo $premiacoes->getCampeonato()->getUrlLogo();?>">
				
					<div class="tituloMural">
						<?php echo $premiacoes->getCampeonato()->getNomeCampeonato();?>
					</div>
					
					<div class="divisoriaMural"></div>
					
					<div class="muralPontos">
						<img class="muralImg" src="<?php echo $imgPontos;?>">
						<span class="muralQtd"><?php echo $premiacoes->getPontosCampeonato();?> pontos conquistados</span>
					</div>
					
					<div class="divisoriaMural"></div>
					
					<div class="muralAcertos">
						<img class="muralImg" src="<?php echo $imgAcertoPlacar;?>">
						<span class="muralQtd"><?php echo $premiacoes->getAcertosPlacar();?> placares corretos</span>
					</div>
					<div class="muralAcertos">
						<img class="muralImg" src="<?php echo $imgAcertoTimeGanhador;?>">
						<span class="muralQtd"><?php echo $premiacoes->getAcertosTimeGanhador();?> acertos de ganhador</span>
					</div>
					<div class="muralAcertos">
						<img class="muralImg" src="<?php echo $imgAcertoPlacarInvertido;?>">
						<span class="muralQtd"><?php echo $premiacoes->getAcertosPlacarInvertido();?> placares invertidos</span>
					</div>
					
					<div class="divisoriaMural"></div>
					
					<div class="muralMedalhas">
						<img class="muralImg" src="<?php echo $imgMedalhaOuro;?>">
						<span class="muralQtd"><?php echo $premiacoes->getMedalhasOuro();?> medalhas de ouro</span>
					</div>
					<div class="muralMedalhas">
						<img class="muralImg" src="<?php echo $imgMedalhaPrata;?>">
						<span class="muralQtd"><?php echo $premiacoes->getMedalhasPrata();?> medalhas de prata</span>
					</div>
					<div class="muralMedalhas">
						<img class="muralImg" src="<?php echo $imgMedalhaBronze;?>">
						<span class="muralQtd"><?php echo $premiacoes->getMedalhasBronze();?> medalhas de bronze</span>
					</div>
				</div>
			      
	<?php
			}
		}
	}
	$conn->commit();
} catch(Exception $e) {
	$conn->rollback();
	?>
	<p class="aviso">Estamos atualizando. Volte amanhã para conferir a novidade.</p>
	<?php 
}
$conn->close();
?>
</div>
<div id="colunaDireita">
<div id="menuCampeonatos">
		<h3 class="titulo">Dê seus Chutes</h3>
		<?php
		$dql = "SELECT c FROM Campeonato c WHERE c.status = 'ativo' ORDER BY c.codCampeonato ASC";
		$campeonatos = consultaDql($dql);
		foreach($campeonatos as $campeonato) {
			if($campeonato instanceof Campeonato){
				$classe = 'campeonatoInativo';
				if(isset($_POST['campeonatoMenu'])){
					if($_POST['campeonatoMenu'] == $campeonato->getCodCampeonato()){
						$classe = 'campeonatoAtivo';
					}
				}
				?>
				<form name="<?php echo 'form'.$campeonato->getCodCampeonato();?>" action="index.php?conteudo=chutes" method="POST">
					<button class="<?php echo $classe;?>" type="submit" name="campeonatoMenu" value="<?php echo $campeonato->getCodCampeonato();?>">
						<span class="nomeCampeonato">
							Dê seu Chute
						</span>
						<img class="logoCampeonato" src="<?php echo $campeonato->getUrlLogo();?>">
						<span class="nomeCampeonato">
							<?php echo $campeonato->getNomeCampeonato();?>
						</span>
					</button>
				</form>
				<?php
			}
		}
		
?>
</div>
<div id="boxTopTorcidas">
<h2 class="titulo">TOP 10 Torcidas</h2>
<a target="_blank" href="https://www.facebook.com/corinthians">
	<img class="timeFanpage" src="https://graph.facebook.com/corinthians/picture">
</a>
<div class="curtirTopTorcidas">
	<iframe src="//www.facebook.com/plugins/like.php?href=https%3A%2F%2Fwww.facebook.com%2Fcorinthians&amp;send=false&amp;layout=button_count&amp;width=150&amp;show_faces=false&amp;action=like&amp;colorscheme=light&amp;font&amp;height=21&amp;appId=104984016274497" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:150px; height:21px;" allowTransparency="true"></iframe>
</div>
<div class="divisoriaTopTorcidas"></div>
<a target="_blank" href="https://www.facebook.com/FlamengoOficial">
	<img class="timeFanpage" src="https://graph.facebook.com/FlamengoOficial/picture">
</a>
<div class="curtirTopTorcidas">
<iframe src="//www.facebook.com/plugins/like.php?href=https%3A%2F%2Fwww.facebook.com%2FFlamengoOficial&amp;send=false&amp;layout=button_count&amp;width=150&amp;show_faces=false&amp;action=like&amp;colorscheme=light&amp;font&amp;height=21&amp;appId=104984016274497" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:150px; height:21px;" allowTransparency="true"></iframe>
</div>
<div class="divisoriaTopTorcidas"></div>
<a target="_blank" href="https://www.facebook.com/saopaulofc">
	<img class="timeFanpage" src="https://graph.facebook.com/saopaulofc/picture">
</a>
<div class="curtirTopTorcidas">
<iframe src="//www.facebook.com/plugins/like.php?href=https%3A%2F%2Fwww.facebook.com%2Fsaopaulofc&amp;send=false&amp;layout=button_count&amp;width=150&amp;show_faces=false&amp;action=like&amp;colorscheme=light&amp;font&amp;height=21&amp;appId=104984016274497" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:150px; height:21px;" allowTransparency="true"></iframe>
</div>
<div class="divisoriaTopTorcidas"></div>
<a target="_blank" href="https://www.facebook.com/sePalmeiras">
	<img class="timeFanpage" src="https://graph.facebook.com/sePalmeiras/picture">
</a>
<div class="curtirTopTorcidas">
<iframe src="//www.facebook.com/plugins/like.php?href=https%3A%2F%2Fwww.facebook.com%2FsePalmeiras&amp;send=false&amp;layout=button_count&amp;width=150&amp;show_faces=false&amp;action=like&amp;colorscheme=light&amp;font&amp;height=21&amp;appId=104984016274497" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:150px; height:21px;" allowTransparency="true"></iframe>
</div>
<div class="divisoriaTopTorcidas"></div>
<a target="_blank" href="https://www.facebook.com/santosfc">
	<img class="timeFanpage" src="https://graph.facebook.com/santosfc/picture">
</a>
<div class="curtirTopTorcidas">
<iframe src="//www.facebook.com/plugins/like.php?href=https%3A%2F%2Fwww.facebook.com%2Fsantosfc&amp;send=false&amp;layout=button_count&amp;width=150&amp;show_faces=false&amp;action=like&amp;colorscheme=light&amp;font&amp;height=21&amp;appId=104984016274497" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:150px; height:21px;" allowTransparency="true"></iframe>
</div>
<div class="divisoriaTopTorcidas"></div>
<a target="_blank" href="https://www.facebook.com/oficialvasco">
	<img class="timeFanpage" src="https://graph.facebook.com/oficialvasco/picture">
</a>
<div class="curtirTopTorcidas">
<iframe src="//www.facebook.com/plugins/like.php?href=https%3A%2F%2Fwww.facebook.com%2Foficialvasco&amp;send=false&amp;layout=button_count&amp;width=150&amp;show_faces=false&amp;action=like&amp;colorscheme=light&amp;font&amp;height=21&amp;appId=104984016274497" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:150px; height:21px;" allowTransparency="true"></iframe>
</div>
<div class="divisoriaTopTorcidas"></div>
<a target="_blank" href="https://www.facebook.com/cruzeirooficial">
	<img class="timeFanpage" src="https://graph.facebook.com/cruzeirooficial/picture">
</a>
<div class="curtirTopTorcidas">
<iframe src="//www.facebook.com/plugins/like.php?href=https%3A%2F%2Fwww.facebook.com%2Fcruzeirooficial&amp;send=false&amp;layout=button_count&amp;width=150&amp;show_faces=false&amp;action=like&amp;colorscheme=light&amp;font&amp;height=21&amp;appId=104984016274497" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:150px; height:21px;" allowTransparency="true"></iframe>
</div>
<div class="divisoriaTopTorcidas"></div>
<a target="_blank" href="https://www.facebook.com/Gremio.Futebol.Portoalegrense">
	<img class="timeFanpage" src="https://graph.facebook.com/Gremio.Futebol.Portoalegrense/picture">
</a>
<div class="curtirTopTorcidas">
<iframe src="//www.facebook.com/plugins/like.php?href=https%3A%2F%2Fwww.facebook.com%2FGremio.Futebol.Portoalegrense&amp;send=false&amp;layout=button_count&amp;width=150&amp;show_faces=false&amp;action=like&amp;colorscheme=light&amp;font&amp;height=21&amp;appId=104984016274497" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:150px; height:21px;" allowTransparency="true"></iframe>
</div>
<div class="divisoriaTopTorcidas"></div>
<a target="_blank" href="https://www.facebook.com/FluminenseFC">
	<img class="timeFanpage" src="https://graph.facebook.com/FluminenseFC/picture">
</a>
<div class="curtirTopTorcidas">
<iframe src="//www.facebook.com/plugins/like.php?href=https%3A%2F%2Fwww.facebook.com%2FFluminenseFC&amp;send=false&amp;layout=button_count&amp;width=150&amp;show_faces=false&amp;action=like&amp;colorscheme=light&amp;font&amp;height=21&amp;appId=104984016274497" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:150px; height:21px;" allowTransparency="true"></iframe>
</div>
<div class="divisoriaTopTorcidas"></div>
<a target="_blank" href="https://www.facebook.com/BotafogoOficial">
	<img class="timeFanpage" src="https://graph.facebook.com/BotafogoOficial/picture">
</a>
<div class="curtirTopTorcidas">
<iframe src="//www.facebook.com/plugins/like.php?href=https%3A%2F%2Fwww.facebook.com%2FBotafogoOficial&amp;send=false&amp;layout=button_count&amp;width=150&amp;show_faces=false&amp;action=like&amp;colorscheme=light&amp;font&amp;height=21&amp;appId=104984016274497" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:150px; height:21px;" allowTransparency="true"></iframe>
</div>
<div class="divisoriaTopTorcidas"></div>
</div>
</div>