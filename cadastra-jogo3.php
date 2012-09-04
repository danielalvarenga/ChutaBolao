<?php
include "valida_cookies.inc";
require "bootstrap.php";
require 'metodos-bd.php';
require_once "lib/WideImage.php";

if(empty($_GET['campeonato'])){
	echo "<script> alert('Você não informou o nome do Campeonato.')
	location = ('cadastra-jogo.php');
	</script>";
}
elseif(empty($_GET['rodada'])){
	echo "<script> alert('Você não informou o número da Rodada.')
	location = ('cadastra-jogo.php');
	</script>";
}

if(isset($_GET['rodada']) && isset($_GET['campeonato'])){
	$objCampeonato = $entityManager->find("Campeonato", $_GET['campeonato']);
	$objRodada = $entityManager->find("Rodada", array(
			"numRodada" => $_GET['rodada'],
			"campeonato" => $_GET['campeonato']
	));
}
else{
	echo '<p align="center">Você não escolheu um Campeonato e uma rodada. <br/>
	<a href="cadastra-jogo.php">Escolher</a></p>';
}

if (isset($_GET['selecao1']) && isset($_GET['selecao2'])) {
	$conn = $entityManager->getConnection();
	$conn->beginTransaction();
	try{
		$pais1 = buscaObjeto("Pais", $_GET['selecao1']);
		$nomePais1 = $pais1->getNomePais();
		$dql = "SELECT t FROM Time t WHERE t.nomeTime = '$nomePais1'";
		$times1 = consultaDqlMaxResult(1, $dql);
		if($times1 <> NULL){
			foreach ($times1 as $time1){
				$codTime1 = $time1->getCodTime();
			}
		}
		else{
			$time1 = new Time($nomePais1, $pais1->getBandeira(), $pais1);
			salvaBancoDados($time1);
			$codTime1 = $time1->getCodTime();
		}

		$pais2 = buscaObjeto("Pais", $_GET['selecao2']);
		$nomePais2 = $pais2->getNomePais();
		$dql = "SELECT t FROM Time t WHERE t.nomeTime = '$nomePais2'";
		$times2 = consultaDqlMaxResult(1, $dql);
		if($times2 <> NULL){
			foreach ($times2 as $time2){
				$codTime2 = $time2->getCodTime();
			}
		}
		else{
			$time2 = new Time($nomePais2, $pais2->getBandeira(), $pais2);
			salvaBancoDados($time2);
			$codTime2 = $time2->getCodTime();
		}
		$conn->commit();
	} catch(Exception $e) {
		$conn->rollback();
		echo $e->getMessage() . "<br/><font color=red>Não foi possível gravar os dados. Verifique o Banco de Dados.</font><br/>";
	}
	$conn->close();
}
elseif (isset($_GET['codtime1']) && isset($_GET['codtime2'])) {
	$codTime1 = $_GET['codtime1'];
	$codTime2 = $_GET['codtime2'];
}

		
if (isset($codTime1) && isset($codTime2)) {
	$conn = $entityManager->getConnection();
	$conn->beginTransaction();
	try{
		$codCampeonato = $_GET['campeonato'];
		
		$data = $_GET['ano'].'-'.$_GET['mes'].'-'.$_GET['dia'].' '.$_GET['hora'].':'.$_GET['minuto'].':00';
		$dataJogo = new DateTime(''.$data.'', new DateTimeZone('America/Sao_Paulo'));
		$dataJogoString = $dataJogo->format( "Y-m-d H:i:s" );
		
		$dqlJogo = "SELECT j FROM Jogo j WHERE
					j.codTime1 = '$codTime1' AND
					j.codTime2 = '$codTime2' AND
					j.campeonato = '$codCampeonato' AND
					j.dataJogo ='$dataJogoString'";
		$queryJ = $entityManager->createQuery($dqlJogo);
		$jogos = consultaDql($dqlJogo);
		
		if($jogos <> NULL){
			echo '<font color="red"><b>Este jogo já existe.</b></font><br/>';
		} else{
		
			$time1 = $entityManager->find("Time", $codTime1);
			$time2 = $entityManager->find("Time", $codTime2);
			
			// Cria a imagem de publicação do jogo
			$urlEscudosJogo = 'imagens/jogos/'.
						strtolower(trim(
						str_replace('Á', 'a',
						str_replace('É', 'e',
						str_replace('Í', 'i',
						str_replace('Ó', 'o',
						str_replace('Ú', 'u',
						str_replace('Â', 'a',
						str_replace('Ê', 'e',
						str_replace('Î', 'i',
						str_replace('Ô', 'o',
						str_replace('Û', 'u',
						str_replace('é', 'e',
						str_replace('ó', 'o',
						str_replace('á', 'a', 
						str_replace('í', 'i', 
						str_replace('ú', 'u', 
						str_replace('ê', 'e',
						str_replace('û', 'u',
						str_replace('ô', 'o',
						str_replace('î', 'i',
						str_replace('â', 'a', 
						str_replace('õ', 'o',
						str_replace('ã', 'a',
						str_replace('ä', 'a',
						str_replace('ë', 'e',
						str_replace('ï', 'i',
						str_replace('ö', 'o',
						str_replace('ü', 'u',
						str_replace('ç', 'c',
						str_replace('Ç', 'c',
						str_replace('(', '-',
						str_replace(')', '-',
						str_replace('[', '-',
						str_replace(']', '-',
						str_replace('{', '-',
						str_replace('}', '-',
						str_replace('/', '-',
						str_replace('\\', '-',
						str_replace('|', '-',
						str_replace(' ', '-',
						$time1->getNomeTime()
								)))))))))))))))))))))))))))))))))))))))))
						.'x'.
						strtolower(trim(
						str_replace('Á', 'a',
						str_replace('É', 'e',
						str_replace('Í', 'i',
						str_replace('Ó', 'o',
						str_replace('Ú', 'u',
						str_replace('Â', 'a',
						str_replace('Ê', 'e',
						str_replace('Î', 'i',
						str_replace('Ô', 'o',
						str_replace('Û', 'u',
						str_replace('é', 'e',
						str_replace('ó', 'o',
						str_replace('á', 'a', 
						str_replace('í', 'i', 
						str_replace('ú', 'u', 
						str_replace('ê', 'e',
						str_replace('û', 'u',
						str_replace('ô', 'o',
						str_replace('î', 'i',
						str_replace('â', 'a', 
						str_replace('õ', 'o',
						str_replace('ã', 'a',
						str_replace('ä', 'a',
						str_replace('ë', 'e',
						str_replace('ï', 'i',
						str_replace('ö', 'o',
						str_replace('ü', 'u',
						str_replace('ç', 'c',
						str_replace('Ç', 'c',
						str_replace('(', '-',
						str_replace(')', '-',
						str_replace('[', '-',
						str_replace(']', '-',
						str_replace('{', '-',
						str_replace('}', '-',
						str_replace('/', '-',
						str_replace('\\', '-',
						str_replace('|', '-',
						str_replace(' ', '-',
						$time2->getNomeTime()
								)))))))))))))))))))))))))))))))))))))))))
						.'.png';
			$escudo1 = WideImage::load($time1->getEscudo());
			$escudo2 = WideImage::load($time2->getEscudo());
			$letraX = WideImage::load('imagens/jogos/x.png');
				
			$escudo1->resizeCanvas( 90, 90, 0, 'top', null, 'any', false);
			$escudo2->resizeCanvas( 90, 90, 'right', 'botton', null, 'any', false);
				
			$escudosJogo = $escudo1->resizeCanvas( 90, 90, 0, 'top', null, 'any', false)
			->merge($escudo2, "right", "bottom", 100)->merge($letraX);
			
			// Salva a imagem em um novo arquivo com 80% de qualidade
			$escudosJogo->saveToFile($urlEscudosJogo, null, 80);
			// Limpa a imagem da memória
			$escudo1->destroy();
			$escudo2->destroy();
			$letraX->destroy();
			
			//---------------------------------------------------------------------------------
						
			// Instancia um objeto RendimentoTime para cada Time deste jogo no Campeonato
					
				$rendimentoTime1 = buscaObjeto("RendimentoTime", $_GET['campeonato']."x".$codTime1);
				$rendimentoTime2 = $entityManager->find("RendimentoTime", $_GET['campeonato']."x".$codTime2);
					
				if(!$rendimentoTime1 instanceof RendimentoTime){
					$rendimentoTime1 = new RendimentoTime($objCampeonato, $time1);
					salvaBancoDados($rendimentoTime1);
					}
				if(!$rendimentoTime2 instanceof RendimentoTime){
					$rendimentoTime2 = new RendimentoTime($objCampeonato, $time2);
					salvaBancoDados($rendimentoTime2);
					}
		// -------------------------------------------------------------------------------------------------------------------
				
				$jogo = new Jogo($data,$objRodada,$codTime1,$codTime2, $objCampeonato, $urlEscudosJogo);
				salvaBancoDados($jogo);
				}
		$conn->commit();
	} catch(Exception $e) {
		$conn->rollback();
		echo $e->getMessage() . "<br/><font color=red>Não foi possível gravar os dados. Verifique o Banco de Dados.</font><br/>";
	}
	$conn->close();
}

	

?>
<html>
<head>
<title>
Cadastro de Jogos e Resultados
</title>
</head>
<body>

	<h1>Cadastro de Jogos e Resultados</h1>

<p>

<form method="GET" action="">					
	<?php
	if(isset($_GET['rodada']) && isset($_GET['campeonato']) && isset($_GET['tipo'])){ ?>
		<input type="hidden" name="campeonato" value="<?php echo $_GET['campeonato'];?>">
		<input type="hidden" name="rodada" value="<?php echo $_GET['rodada'];?>">
		<input type="hidden" name="tipo" value="<?php echo $_GET['tipo'];?>">
		<?php
		echo '<b>Campeonato:</b> '.$objCampeonato->getNomeCampeonato().' '.$objCampeonato->getAnoCampeonato().'<br/>';
		echo '<b>Rodada:</b> '.$objRodada->getNumRodada().
		'<br/><font size="1"><a href="cadastra-jogo.php">Escolher Novamente</a></font></p>';
		?>
		<p>Data do Jogo 
	 	<select name="dia">
	 	<option>dia</option>
			<?php
				for($dia = 1 ; $dia <= 31 ; $dia++ ){
				$dia2 = $dia;
					if($dia2 <= 9){
						$dia2 = '0'.$dia;
						echo "<option value=$dia2>$dia2</option>";
					} else{
						echo "<option value=$dia>$dia</option>";
					}
				};
			?>
		</select>
		<select name="mes">
		<option>mês</option>
			<?php
				for($mes = 1 ; $mes <= 12 ; $mes++ ){
					$mes2 = $mes;
					if($mes2 <= 9){
						$mes2 = '0'.$mes;
						echo "<option value=$mes2>$mes2</option>";
					} else{
						echo "<option value=$mes>$mes</option>";
					}
				};
			?>
		</select>
		<select name="ano">
		<option>ano</option>
			<?php
				for($ano = 2012 ; $ano <= 2020 ; $ano++ ){
					echo "<option value=$ano>$ano</option>";
				};
			?>
		</select></p>
		<p>Horário 
	 	<select name="hora">
	 	<option>hora</option>
			<?php
				for($hora = 23 ; $hora >= 0 ; $hora-- ){
					$hora2 = $hora;
					if($hora2 <= 9){
						$hora2 = '0'.$hora;
						echo "<option value=$hora2>$hora2</option>";
					} else{
						echo "<option value=$hora>$hora</option>";
					}
				};
			?>
		</select>
		<select name="minuto">
		<option>minuto</option>
			<?php
				for($minuto = 0 ; $minuto <= 59 ; $minuto +=5 ){
					$minuto2 = $minuto;
					if($minuto2 <= 9){
						$minuto2 = '0'.$minuto;
						echo "<option value=$minuto2>$minuto2</option>";
					} else{
						echo "<option value=$minuto>$minuto</option>";
					}
				};
			?>
		</select></p>
		<?php
		$tipoCampeonato = $_GET['tipo'];
		if($tipoCampeonato == "nacional"){
			$dql = "SELECT t FROM Time t ORDER BY t.nomeTime ASC";
			$times = consultaDql($dql);
			?>
			<p>Time1: 
				<select size="1" name="codtime1">
				<option></option>
				<?php 
					foreach($times as $time1) {
						if($time1->getNomeTime() != $time1->getPais()->getNomePais()){
							echo "<option value=".$time1->getCodTime().">".$time1->getNomeTime()."</option>";
						}
					}
				?>
				</select>
			 </p>
			 <p>Time2: 
				<select size="1" name="codtime2">
				<option></option>
				<?php
					foreach($times as $time2) {
						if($time2->getNomeTime() != $time2->getPais()->getNomePais()){				
							echo "<option value=".$time2->getCodTime().">".$time2->getNomeTime()."</option>";
						}
					}
				?>
				</select>
			  </p>
		<?php
		}
		elseif($tipoCampeonato == "mundial"){
			$dql = "SELECT p FROM Pais p ORDER BY p.nomePais ASC";
			$selecoes = consultaDql($dql);
			?>
						<p>Seleção 1: 
							<select size="1" name="selecao1">
							<option></option>
							<?php 
								foreach($selecoes as $selecao1) {
									echo "<option value=".$selecao1->getCodPais().">".$selecao1->getNomePais()."</option>";
								}
							?>
							</select>
						 </p>
						 <p>Seleção 2: 
							<select size="1" name="selecao2">
							<option></option>
							<?php
								foreach($selecoes as $selecao2) {
									echo "<option value=".$selecao2->getCodPais().">".$selecao2->getNomePais()."</option>";
								}
							?>
							</select>
						  </p>
		<?php
		}
		
		?>
  <p><input type="submit" value="Salvar Jogo" name="salvarJogo"></p>
</form>

</p>
		<?php
		}
		
		?>

<h2>Jogos Cadastrados</h2>
<?php
$numRodada = $_GET['rodada'];
$codCampeonato = $_GET['campeonato'];
if($numRodada == 1){
	$rodadaAnterior = $numRodada;
}
else{
	$rodadaAnterior = $numRodada-1;
}
if($numRodada == $objCampeonato->getQuantidadeRodadas()){
	$rodadaPosterior = $numRodada;
}
else{
	$rodadaPosterior = $numRodada+1;
}

?>
				<table>
					<tr>
						<td>
							<form method="GET" action="cadastra-jogo3.php">
								<input type="hidden" name="campeonato" value="<?php echo $_GET['campeonato'];?>">
								<input type="hidden" name="tipo" value="<?php echo $_GET['tipo'];?>">
								<input type="hidden" name="rodada" value="<?php echo $rodadaAnterior;?>">
								<input type="submit" value="Ir para Rodada <?php echo $rodadaAnterior;?>" name="anterior">
							</form>
						</td>
						<td>
							<form method="GET" action="cadastra-jogo3.php">
								<input type="hidden" name="campeonato" value="<?php echo $_GET['campeonato'];?>">
								<input type="hidden" name="tipo" value="<?php echo $_GET['tipo'];?>">
								<input type="hidden" name="rodada" value="<?php echo $numRodada;?>">
								<input type="submit" value="Todos os Jogos do Campeonato" name="todos">
							</form>
						</td>
						<td>
							<form method="GET" action="cadastra-jogo3.php">
								<input type="hidden" name="campeonato" value="<?php echo $_GET['campeonato'];?>">
								<input type="hidden" name="tipo" value="<?php echo $_GET['tipo'];?>">
								<input type="hidden" name="rodada" value="<?php echo $rodadaPosterior;?>">
								<input type="submit" value="Ir para Rodada <?php echo $rodadaPosterior;?>" name="posterior">
							</form>
						</td>
					</tr>
				</table>



				<table border="1">
					<tr vertical-align="middle" align="center">
						<td>Data</td>
						<td>Campeonato</td>
						<td>Rodada</td>
						<td>Escudos</td>
						<td>Resultado</td>
						<td>Início de Apostas</td>
						<td>Fim de Apostas</td>
						<td></td>
					</tr>
				
			<?php
			$conn = $entityManager->getConnection();
			$conn->beginTransaction();
			try{
				if(isset($_GET['todos'])){
					$dqlJogo = "SELECT j FROM Jogo j ORDER BY j.rodada ASC";
				}
				else{
					$dqlJogo = "SELECT j FROM Jogo j WHERE j.campeonato = '$codCampeonato'
					AND j.rodada = '$numRodada'
					ORDER BY j.dataJogo ASC";
				}
				
				
				$jogos = consultaDql($dqlJogo);
					
				foreach($jogos as $jogo) {
				
					if($jogo instanceof Jogo){
						//if($jogo->getCampeonato()->getStatus() != "finalizado"){
							
							$time1 = $entityManager->find("Time", $jogo->getCodtime1());
							$time2 = $entityManager->find("Time", $jogo->getCodtime2());
							
							?>
								<tr vertical-align="middle" align="center">
									<td><?php echo $jogo->getDataLogica();?></td>
									<td><?php echo $jogo->getCampeonato()->getNomeCampeonato();?> 
										<?php echo $jogo->getCampeonato()->getAnoCampeonato();?>
									</td>
									<td><?php echo $jogo->getRodada()->getNumRodada();?></td>
									<td>
											<img src="<?php echo $jogo->getEscudosJogo();?>" width="50px" height="50px">
									</td>
									<td>
										<?php
										if(($jogo->getGolstime1() === NULL) && ($jogo->getGolstime2() === NULL)){
										?>
											<form method="GET" action="insere-gols.php">
											 	<p align="center">
											 	<?php echo $time1->getNomeTime().' ';?>
											 	<img class="escudoTime" src="<?php echo $time1->getEscudo();?>" width="25px" height="25px"> 
											 	<select name="golsTime1">
											 		<option value="<?php echo $jogo->getGolstime1();?>"><?php echo $jogo->getGolstime1();?></OPTION>
													<?php
														for($gols = 0 ; $gols < 100 ; $gols++ ){
															echo "<option value=$gols>$gols</option>";
														};
													?>
												</select>
												 X 
												<select name="golsTime2">
													<option value="<?php echo $jogo->getGolstime2();?>"><?php echo $jogo->getGolstime2();?></OPTION>
													<?php
														for($gols = 0 ; $gols < 100 ; $gols++ ){
															echo "<option value=$gols>$gols</option>";
														};
													?>
												</select>
												<img class="escudoTime" src="<?php echo $time2->getEscudo();?>" width="25px" height="25px"> 
												<?php echo ' '.$time2->getNomeTime();?>
												<br/>
												<input type="hidden" name="tipo" value="<?php echo $_GET['tipo'];?>">
												<input type="hidden" name="jogo" value="<?php echo $jogo->getCodJogo();?>">
												<input type="submit" name="registra-resultado" value="Registrar Resultado">
												</p>
											</form>
										<?php
										}
										else{
											echo $time1->getNomeTime().' '.$jogo->getGolstime1().' X '.
												$jogo->getGolstime2().' '.$time2->getNomeTime();
											?>
											<form action="desfaz-insere-gols.php" method ="get">
											<input type="hidden" name="tipo" value="<?php echo $_GET['tipo'];?>">
											<input type="hidden" name="jogo" value="<?php echo $jogo->getCodjogo();?>">
											<input type="submit" name="desfazer" value="Desfazer Resultado">
											</form>
											<?php 
									//	}
										?>
									</td>
									<td><?php echo $jogo->getDataLogicaInicioApostas();?></td>
									<td><?php echo $jogo->getDataLogicaFimApostas();?></td>
									<td>
										<form method="GET" action="edita-jogo.php">
										<input type="hidden" name="tipo" value="<?php echo $_GET['tipo'];?>">
										<input type="hidden" name="codJogo" value="<?php echo $jogo->getCodjogo();?>">
										<input type="submit" name="editar" value="Alterar"><br/>
										</form>
									</td>
								</tr>
							<?php
				}
			}
		}
		$conn->commit();
	} catch(Exception $e) {
		$conn->rollback();
		echo $e->getMessage() . "<br/><font color=red>Dados não encontrados. Verifique o Banco de Dados.</font><br/>";
	}
	$conn->close();
?>
</table>

	<p align="center"><a href="admin.php">Menu Principal</a></p>
</body>
</html>
