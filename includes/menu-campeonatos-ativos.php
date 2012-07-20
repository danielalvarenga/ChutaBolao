<div id="menuCampeonatos">
<h3 class="titulo"><?php echo $tituloMenu;?></h3>
		<form action="" method="POST">
			<!-- <input type="hidden" name="geral" value="geral"> -->
			<button class="<?php echo $classeGeral;?>" type="submit" name="geral" value="geral">
				<?php echo $todosMenu;?>
			</button><br/>
		</form>
		<div class="divisoriaMenuCampeonatos"></div>

		<?php
		$dql = "SELECT c FROM Campeonato c WHERE c.status = 'ativo' ORDER BY c.codCampeonato ASC";
		$query = $entityManager->createQuery($dql);
		$campeonatos = $query->getResult();
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
							<?php echo $campeonato->getNomeCampeonato();?>
						</span>
					</button>
				</form>
				<?php
			}
		}
		
?>
</div>