<div id="homeTimesFavoritos">
<?php
//$usuario->setTimeFavorito(NULL); atualizaBancoDados($usuario); //para testar times diferentes
if(isset($_POST["codTime"])){
	$timeFavorito = buscaObjeto("Time", $_POST["codTime"]);
	$usuario->setTimeFavorito($timeFavorito);
	atualizaBancoDados($usuario);
}
if($usuario->getTimeFavorito() === NULL){
	?>
	<div class="tituloTimeFavorito">Qual seu Time do Coração?</div>
	<?php
	$pais = buscaObjeto("Pais", 76);
	$times = $pais->getTimes();
	$qtd = 1;
	foreach($times as $time) {
		if(($time instanceof Time) && ($qtd <=20) && ($time->getNomeTime() != "Brasil")){
			?>
			<form action="" method="post">
			<button class="buttonTime" type="submit" name="codTime" value="<?php echo $time->getCodTime();?>">
				<img class="timeFavorito" src="<?php echo $time->getEscudo();?>" alt="<?php echo $time->getNomeTime();?>" title="<?php echo $time->getNomeTime();?>">
			</button>
			<?php
			$qtd++;
		}
		else{
			$codTimes[] = $time->getCodTime();
			$escudos[] = $time->getEscudo();
			$nomeTimes[] = $time->getNomeTime();
		}
	}
	$codTimesStr = implode("\",\"", $codTimes);
	$escudosStr = implode("\",\"", $escudos);
	$nomeTimesStr = implode("\",\"", $nomeTimes);
	?>
	<div id="maisTimes">
	<div class="linkMaisTimes" onclick="exibeTodosTimes()" style="cursor:pointer;">ver mais times...</div>
	</div>
	</form>
	<?php
}
else{
	$dql = "SELECT r FROM RendimentoTime r WHERE r.time = '".$usuario->getTimeFavorito()->getCodTime()."' ORDER BY r.campeonato ASC";
	$rendimentosTimes = consultaDqlMaxResult(2, $dql);
	?>
	<div id="escudoTimeFavorito">
	<img src="<?php echo $usuario->getTimeFavorito()->getEscudo();?>" alt="<?php echo $usuario->getTimeFavorito()->getNomeTime();?>" title="<?php echo $usuario->getTimeFavorito()->getNomeTime();?>">
	</div>
	<?php
	foreach ($rendimentosTimes as $rendimentoTime){
	?>
		<div id="rendimentoTimeFavorito">
			<div class="classificacaoTimeFavorito"><?php echo $rendimentoTime->getClassificacao()."º no ".$rendimentoTime->getCampeonato()->getNomeCampeonato()." ".$rendimentoTime->getCampeonato()->getAnoCampeonato();?></div>
			<div class="divisoriaTimeFavorito"></div>
			<div class="infoTimeFavorito" title="Vitórias"><?php echo "V ".$rendimentoTime->getVitorias();?></div>
			<div class="infoTimeFavorito" title="Empates"><?php echo "E ".$rendimentoTime->getEmpates();?></div>
			<div class="infoTimeFavorito" title="Derrotas"><?php echo "D ".$rendimentoTime->getDerrotas();?></div>
			<div class="infoTimeFavorito" title="Gols Pró"><?php echo "GP ".$rendimentoTime->getGolsPro();?></div>
			<div class="infoTimeFavorito" title="Gols Contra"><?php echo "GC ".$rendimentoTime->getGolsContra();?></div>
			<div class="infoTimeFavorito" title="Saldo de Gols"><?php echo "SG ".$rendimentoTime->getSaldoGols();?></div>
		</div>
	<?php
	}
	?>
	<div class="divisoriaTimeFavorito"></div>
	<?php
}
?>
</div>

<script type="text/javascript">
function exibeTodosTimes(){
	var i;
	var codTimes = ["<?php echo $codTimesStr;?>"];
	var escudos = ["<?php echo $escudosStr;?>"];
	var nomeTimes = ["<?php echo $nomeTimesStr;?>"];
	var qtd = codTimes.length;
	var impressao = "";
	for(i = 0; i < qtd; i++){
		if(codTimes[i] != 25){
			impressao = impressao + "<button class=\"buttonTime\" type=\"submit\"  name=\"codTime\" value=\"" + codTimes[i] + "\">"+
			"<img class=\"timeFavorito\" src=\""+ escudos[i] +"\" alt=\""+ nomeTimes[i] +"\" title=\""+ nomeTimes[i] +"\"></button>";
		}
	}
	document.getElementById("maisTimes").innerHTML=impressao + "<div class=\"divisoriaTimeFavorito\"></div>";
}
</script>