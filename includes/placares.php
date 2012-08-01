<?php
require "bootstrap.php";


if(!isset($_POST['campeonatoMenu'])){
	$dql = "SELECT c FROM Campeonato c WHERE c.status='ativo' ORDER BY c.codCampeonato DESC";
	$campeonatos= consultaDql($dql);
	
	$classeGeral='todosAtivo';
}
else{
	$codCampeonatoMenu = 
	$dql = "SELECT c FROM Campeonato c WHERE c.codCampeonato = ".$_POST['campeonatoMenu'];
	$campeonatos= consultaDql($dql);
	
	$classeGeral='todosInativo';
}
$tituloMenu = 'Campeonatos';
$todosMenu = 'Todos';

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
				
		$dql = "SELECT j FROM Jogo j WHERE'$dataAtual'>= j.dataInicioApostas
				AND j.campeonato=".$campeonato->getCodCampeonato()." ORDER BY j.dataJogo DESC";
		$jogos = consultaDqlMaxResult(15, $dql);
				
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
					<span class="dataJogoPlacares">Em <?php echo $jogo->getDataLogica();?></span>
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
					$contadorApostas = consultaDqlMaxResult(3, $dql);
					
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
						<div class="top3Placares">Ainda não existem chutes para este jogo.</div>
						<?php 
					}
					?>
					<div class="divisoriaPlacares"></div>
					<?php 
				}
			}
			else{
				?>
				<p class="aviso">Ainda não existem chutes para este campeonato. Volte amanhã para conferir</p>
				<?php 
			}
			?>
			</div>
			<?php 
		}
	}
	$conn->commit();
} catch(Exception $e) {
$conn->rollback();

?>
		<p class="aviso">Ainda não existem chutes para nenhum jogo.<br/>
	O início das apostas começa sempre 2 dias antes de cada jogo e encerra 1 hora antes.<br/>
	Volte amanhã para conferir novamente.</p>
		<?php 
		
}
$conn->close();

?>
</div>
<div id="colunaDireita">
<?php include "includes/menu-campeonatos-ativos.php";?>
</div>