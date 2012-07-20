<div id="menuCampeonatos">
<?php
$dql = "SELECT c FROM Campeonato c WHERE c.status = 'finalizado' ORDER BY c.codCampeonato ASC";
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
				<form name="<?php echo 'form'.$campeonato->getCodCampeonato();?>" action="" method="POST">
					<button class="<?php echo $classe;?>" type="submit" name="campeonatoMenu" value="<?php echo $campeonato->getCodCampeonato();?>">
					<img class="logoCampeonato" src="<?php echo $campeonato->getUrlLogo();?>">
						<span class="nomeCampeonato">
							<?php echo $campeonato->getNomeCampeonato();?><br/><font size="1">encerrado</font>
						</span>
					</button>
				</form>
				<?php
			}
		}
		
?>
</div>