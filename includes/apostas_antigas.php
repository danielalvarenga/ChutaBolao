 <?php
require ("bootstrap.php");

if(!isset($_POST['campeonatoMenu'])){
	$dql = "SELECT c FROM Campeonato c WHERE c.status='ativo'";
	$campeonatos= consultaDql($dql);

	$classeGeral='todosAtivo';
}
else{
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
/*	$dataAgora = new DateTime('now', new DateTimeZone('America/Sao_Paulo'));
	$dataAtual = $dataAgora->format( "Y-m-d H:i:s" );
	*/
	
	$semChutes = true;
	if($campeonatos<>NULL){
 
		$opcaoVazia=' ';
		$imprimeLetraX= "X";
	    
		foreach ($campeonatos as $campeonato){
			
			//Essa parte do codigo busca os jogos cadastradas dentro do banco de dados.
		
			$dql = "SELECT a FROM Aposta a WHERE a.campeonato=".$campeonato->getCodCampeonato()." AND a.usuario=".$user_id."
			ORDER BY a.jogo DESC";
			$apostas = consultaDql($dql);
		
			//Aqui esta testando se a busca voltou com algum jogo ou nao
			if ($apostas<>NULL){
				$semChutes = false;
				?>
				<div id="jogos">
				<h3 class="titulo"><?php echo $campeonato->getNomeCampeonato().' '.$campeonato->getAnoCampeonato();?></h3>
				<?php
					
						// Essa parte do codigo busca aposta do usuario de acordo com o numero do
						//jogo cadastradas dentro do banco de dados.
			
					foreach ($apostas as $aposta){	//Aqui esta buscando os nomes dos times do jogo
						$time = $entityManager->find("Time", $aposta->getJogo()->getCodtime1());
						$time1 = $time->getNomeTime();
						$escudo1 = $time->getEscudo();
						
						//Aqui esta buscando os nomes dos times do jogo
						$time = $entityManager->find("Time", $aposta->getJogo()->getCodtime2());
						$time2 = $time->getNomeTime();
						$escudo2 = $time->getEscudo();
						
						//Aqui esta testando se a busca voltou com alguma aposta ou nao
						$golsTime1 = $aposta->getJogo()->getGolstime1();
						$golsTime2 = $aposta->getJogo()->getGolstime2();
						
						if(($golsTime1 === NULL) && ($golsTime2 === NULL)){
							$resultado = 'AGUARDANDO RESULTADO REAL';
						}
						else{
							$resultado = 'O RESULTADO REAL FOI '.$golsTime1.' X '.$golsTime2;
						}
						
						//$resultado = 'O RESULTADO REAL FOI '.$golsTime1.' X '.$golsTime2;
						?>
						
							<span class="dataJogo">Realizado em <?php echo $aposta->getJogo()->getDataLogica();?></span>
							<span class="statusJogo"><?php echo $resultado;?></span>
							<div class="jogoLiberado">
							<span class="nomeTimeChutesFeitos"><?php echo $time1;?></span>
							<img class="escudoTime" src="<?php echo $escudo1;?>">
							<div class="chute">
								<?php echo $aposta->getApostaGolsTime1();?>
							</div>
							<span class="letraX">X</span>
							<div class="chute">
								<?php echo $aposta->getApostaGolsTime2();?>
							</div>
							<img class="escudoTime" src="<?php echo $escudo2;?>">
							<span class="nomeTimeChutesFeitos"><?php echo $time2?></span>
							<div class="divisoria"></div>
						</div>
						<?php 
					}
					?>
					</div>
					<?php	
			}
		}
	}
	if($semChutes){
		?>
		<p class="aviso">Você ainda não deu seu Chute em nenhum jogo.</p>
		<?php
	}	
	$conn->commit();
} catch(Exception $e) {
	$conn->rollback();
	?>
	<p class="aviso">Você ainda não deu seu Chute em nenhum jogo.</p>
	<?php
}
$conn->close();

?>
</div>
<div id="colunaDireita">
<?php
include "includes/menu-campeonatos-ativos.php";
include "includes/menu-campeonatos-inativos.php";
?>
</div>