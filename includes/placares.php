<?php
require "bootstrap.php";

function opcaoUsuario(){
	for($indiceEscolhaUsuario = 0 ; $indiceEscolhaUsuario < 100 ; $indiceEscolhaUsuario++ ){
		echo "<OPTION VALUE=$indiceEscolhaUsuario>$indiceEscolhaUsuario</OPTION>";
	}
}

if(!isset($_GET['campeonato'])){
	$dql = "SELECT c FROM Campeonato c WHERE c.status='ativo'";
	$query= $entityManager->createQuery($dql);
	$campeonatos= $query->getResult();
	
	$classeGeral='geralRankingAtivo';
}
else{
	$dql = "SELECT c FROM Campeonato c WHERE c.codCampeonato = ".$_GET['campeonato'];
	$query= $entityManager->createQuery($dql);
	$campeonatos= $query->getResult();
	
	$classeGeral='geralRankingInativo';
}

?>
<div id="colunaEsquerda">
<?php
$conn = $entityManager->getConnection();
$conn->beginTransaction();
try{
	$dataAgora = new DateTime('now', new DateTimeZone('America/Sao_Paulo'));
	$dataAtual = $dataAgora->format( "Y-m-d H:i:s" );

	if($campeonatos<>NULL){
			
		foreach ($campeonatos as $campeonato){
				
			//Essa parte do codigo busca os jogos cadastradas dentro do banco de dados.

			/*
			$dql = "SELECT j FROM Jogo j WHERE'$dataAtual'>= j.dataInicioApostas AND '$dataAtual
			'<=j.dataFimApostas AND j.campeonato=".$campeonato->getCodCampeonato()." ORDER BY j.dataJogo ";
			$query = $entityManager->createQuery($dql);
			$jogos = $query->getResult();
			*/
			
			$dql = "SELECT j FROM Jogo j WHERE'$dataAtual'>= j.dataInicioApostas
					AND j.campeonato=".$campeonato->getCodCampeonato()." ORDER BY j.dataJogo DESC";
			$query = $entityManager->createQuery($dql);
			$query->setMaxResults(15);
			$jogos = $query->getResult();
				
			?>
			<div id="jogos">
			<h3 class="titulo"><?php echo $campeonato->getNomeCampeonato().' '.$campeonato->getAnoCampeonato();?></h3>
			<?php
				
			//Aqui esta testando se a busca voltou com algum jogo ou nao
				
			if($jogos<>NULL){

				//Essa parte do codigo busca os jogos cadastradas dentro do banco de dados.

				foreach ($jogos as $jogo){

					// Essa parte do codigo busca aposta do usuario de acordo com o numero do
					//jogo cadastradas dentro do banco de dados.
		
					$time = $entityManager->find("Time", $jogo->getCodtime1());
					$time1 = $time->getNomeTime();
					$escudo1 = $time->getEscudo();
						
					//Aqui esta buscando os nomes dos times do jogo
					$time = $entityManager->find("Time", $jogo->getCodtime2());
					$time2 = $time->getNomeTime();
					$escudo2 = $time->getEscudo();
					?>
					<div class="jogoPlacares">
						<span class="nomeTimePlacares"><?php echo $time1;?></span>
						<img class="escudoTimePlacares" src="<?php echo $escudo1;?>">
						<span class="letraX">X</span>
						<img class="escudoTimePlacares" src="<?php echo $escudo2;?>">
						<span class="nomeTimePlacares"><?php echo $time2?></span>
					</div>
						<?php

					$dql = "SELECT ca FROM ContadorAposta ca WHERE ca.campeonato=".$campeonato->getCodCampeonato().
					" AND ca.jogo=".$jogo->getCodjogo()."ORDER BY ca.quantidadeApostas DESC";
					
					$query = $entityManager->createQuery($dql);
					$query->setMaxResults(3);
					$contadorApostas = $query->getResult();
					
					//Aqui esta testando se a busca voltou com algum jogo ou nao
					if ($contadorApostas<>NULL){
						$contador=1;
						?>
						<div class="top3Placares">
						<?php 
							foreach ($contadorApostas as $contadorAposta){	//Aqui esta buscando os nomes dos times do jogo
								?>
									<?php echo $contadorAposta->getOpcaoCadastrada();?> com 
									<?php echo $contadorAposta->getQuantidadeApostas();?> chutes<br/>
								<?php
								$contador++;
							}
						?>
						</div>
						<?php 
					}
					else{
						?>
						<div class="top3Placares">Ainda n�o existem chutes para este jogo.</div>
						<?php 
					}
					?>
					<div class="divisoria"></div>
					<?php 
				}
			}
			else{
				echo
				"<center>
				<table id='tabela'>
				<tr class=\"linha\">
				<td class=\"coluna\">
				<p class=\"aviso\" align='center'>N�o existem chutes para este campeonato. Volte amanh� para conferir.</p>
				</td>
				</tr>
				</table>
				</center>";

			}
			?>
			</div>
			<?php 
		}
	}
	$conn->commit();
} catch(Exception $e) {
$conn->rollback();
echo
"<center>
	<table id='tabela'>
	<tr class=\"linha\">
	<td class=\"coluna\" align='center'>
	<p class=\"aviso\" align=\"center\">Ainda n�o existem chutes para nenhum jogo.<br/>
	O in�cioo das apostas come�a sempre 2 dias antes de cada jogo e encerra 1 hora antes.<br/>
	Volte amanh� para conferir novamente.</p>
	</td>
	</tr>
	</table>
	</center>";
}
$conn->close();

?>
</div>
<div id="colunaDireita">
	<h3 class="titulo">Campeonatos</h3>
		<form name="formRankingGeral" action="" method="GET">
			<INPUT type='hidden' name="conteudo" value="<?php echo $_GET['conteudo'];?>">
			<button class="<?php echo $classeGeral;?>" type="submit" name="geral" value="geral">Todos</button><br/>
		</form>
		<div class="divisoriaRanking"></div>

		<?php
		$dql = "SELECT c FROM Campeonato c WHERE c.status = 'ativo' ORDER BY c.codCampeonato ASC";
		$query = $entityManager->createQuery($dql);
		$campeonatos = $query->getResult();
		foreach($campeonatos as $campeonato) {
			if($campeonato instanceof $campeonato){
				$classe = 'campeonatoRankingInativo';
				if(isset($_GET['campeonato'])){
					if($_GET['campeonato'] == $campeonato->getCodCampeonato()){
						$classe = 'campeonatoRankingAtivo';
					}
				}
				?>
				<form name="<?php echo 'form'.$campeonato->getCodCampeonato();?>" action="" method="GET">
				<INPUT type='hidden' name="conteudo" value="<?php echo $_GET['conteudo'];?>">
					<button class="<?php echo $classe;?>" type="submit" name="campeonato" value="<?php echo $campeonato->getCodCampeonato();?>">
						<?php echo $campeonato->getNomeCampeonato();?>
					</button>
				</form>
				<?php
			}
		}
		
		?>
</div>