<?php
require "bootstrap.php";

if(!isset($_POST['campeonatoMenu'])){
	$dqlMenu = "SELECT c FROM Campeonato c WHERE c.status='ativo' ORDER BY c.codCampeonato ASC";
	$classeGeral='todosAtivo';
}
else{
	$dqlMenu = "SELECT c FROM Campeonato c WHERE c.codCampeonato = ".$_POST['campeonatoMenu'];
	$classeGeral='todosInativo';
}
$tituloMenu = 'Campeonatos';
$todosMenu = 'Todos';

?>
<div id="colunaEsquerda">

<?php 
$campeonatos = consultaDql($dqlMenu);
foreach ($campeonatos as $campeonato){
	if(substr_count($campeonato->getNomeCampeonato(), 'Brasileirão') > 0){
		$codCampeonato = $campeonato->getCodCampeonato();
		$dql = "SELECT r FROM RendimentoTime r WHERE r.campeonato = '$codCampeonato' ORDER BY r.classificacao, r.pontos DESC";
		$rendimentosTimes = consultaDql($dql);
		?>
		<h3 class="titulo"><?php echo $campeonato->getNomeCampeonato()." ".$campeonato->getAnoCampeonato();?></h3>
		<center>
		<table
			style="
			
			background-color: #00df00;
			background: #00df00;
			
			border:solid 2px #00df00;
			border-spacing: 0px;
			-moz-border-radius: 10px;
			-webkit-border-radius: 10px;
			border-radius: 10px;
			
			font-family: Helvetica, Arial, sans-serif;
			font-size: 16px;
			color: #006600;
			text-align: center;
			vertical-align: middle;
			
			margin-left: 10px;
			margin-right: 10px;
			
			padding-top: 3px;
			padding-bottom: 10px;
		">
			<tr
			style="
			width: 90%%;
			
			background-color: #00df00;
			background: #00df00;
			
			border:solid 0px #00df00;
			-moz-border-radius: 10px;
			-webkit-border-radius: 10px;
			border-radius: 10px;
			
			font-family: Helvetica, Arial, sans-serif;
			font-size: 16px;
			color: #006600;
			text-align: center;
			vertical-align: middle;
			font-weight: bold;
	
		">
				<td title="Classificação">
				Nº
				</td>
				<td colspan="2" title="Time">
				Time
				</td>
				<td title="Pontos">
				P
				</td>
				<td title="Vitórias">
				V
				</td>
				<td title="Empates">
				E
				</td>
				<td title="Derrotas">
				D
				</td>
				<td title="Gols Pró">
				GP
				</td>
				<td title="Gols Contra">
				GC
				</td>
				<td title="Saldo de Gols">
				SD
				</td>
			</tr>
			
		<?php 
		foreach ($rendimentosTimes as $classificacao){
			?>
			<tr
			style="
			width: 90%%;
			
			background-color: #c1ffc1;
			background: #c1ffc1;
			
			font-family: Helvetica, Arial, sans-serif;
			font-size: 16px;
			color: #006600;
			text-align: center;
			vertical-align: middle;
		">
				<td title="Classificação"
					style="
					width: 5%;
					font-weight: bold;
					padding-top: 3px;
					padding-bottom: 3px;
					;">
				<?php echo $classificacao->getClassificacao();?>
				</td>
				<td title="Time"
					style="
					width: 5%;
					font-size: 14px; font-weight: bold;">
				<img class="escudoTime" src="<?php echo $classificacao->getTime()->getEscudo();?>">
				</td>
				<td title="Time"
					style="
					width: 20%;
					font-size: 14px;
					font-weight: bold;
					text-align: left">
				<?php echo $classificacao->getTime()->getNomeTime();?>
				</td>
				<td title="Pontos"
					style="
					width: 5%;">
				<?php echo $classificacao->getPontos();?>
				</td>
				<td title="Vitórias"
					style="
					width: 5%;">
				<?php echo $classificacao->getVitorias();?>
				</td>
				<td title="Empates"
					style="
					width: 5%;">
				<?php echo $classificacao->getEmpates();?>
				</td>
				<td title="Derrotas"
					style="
					width: 5%;">
				<?php echo $classificacao->getDerrotas();?>
				</td>
				<td title="Gols Pró"
					style="
					width: 5%;">
				<?php echo $classificacao->getGolsPro();?>
				</td>
				<td title="Gols Contra"
					style="
					width: 5%;">
				<?php echo $classificacao->getGolsContra();?>
				</td>
				<td title="Saldo de Gols"
					style="
					width: 5%;">
				<?php echo $classificacao->getSaldoGols();?>
				</td>
			</tr>
			<tr
			style="
			height: 2px;
			
			background-color: #00df00;
			background: #00df00;
			
			border:solid 0px #00df00;
			-moz-border-radius: 10px;
			-webkit-border-radius: 10px;
			border-radius: 10px;
		">
			<?php
		}
		?>
		</table>
		</center>
		<br />
		<?php 
	}
	else{
		?>
		<h3 class="titulo"><?php echo $campeonato->getNomeCampeonato()." ".$campeonato->getAnoCampeonato();?></h3>
		<p class="aviso">Não Disponível para este Campeonato.</p>
		<?php
	}
}
?>
</div>
<div id="colunaDireita">
<?php include "includes/menu-campeonatos-ativos.php";?>
</div>