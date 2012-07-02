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
	<center>
	<table id="tabelaHome" cellspacing="5" cellpadding="5">
		<tr>
			<td>
				<table class="tabelaInterna" cellspacing="0" cellpadding="0">
				<tr align="center" bottom="middle" style ="border-style: solid; border-width: 1">
					<td class="tituloHome" colspan=11>
						PODIUM GERAL
					</td>
				</tr>
				<tr>
					<td height="5px">
					</td>
				</tr>
				<tr align="center" bottom="middle">
					<td>
					</td>
					<td>
						<img src="<?php echo $imgAcertoPlacar;?>" />  
					</td>
					<td>
					</td>
					<td>
					</td>
					<td>
					</td>
					<td>
						<img src="<?php echo $imgMedalhaOuro;?>" />  
					</td>
					<td>
					</td>
					<td>
					</td>
					<td>
						<img src="<?php  echo $imgPontos;?>" />
					</td>
					<td>
					</td>
					<td>
						<img src="<?php  echo $imgTrofeus;?>" />
					</td>
				</tr>
				<tr align="center" bottom="middle">
					<td>
						<img src="<?php echo $imgAcertoTimeGanhador;?>" />   
					</td>
					<td class="topoPodium" bgcolor="#3B5998" rowspan="2">
						<span class="descricaoPodium">ACERTOS<br/><br/></span>
							<?php echo $pontuacaoGeral->getAcertosPlacarGeral();?>
							<span class="descricaoPodium"><br/>Placar Completo</span>
						</span>
					</td>
					<td>
						<img src="<?php echo $imgAcertoPlacarInvertido;?>" />   
					</td>
					<td>
					</td>
					<td>
						<img src="<?php echo $imgMedalhaPrata;?>" /> 
					</td>
					<td class="topoPodium" bgcolor="#FFA500" rowspan="2">
						<span class="descricaoPodium">MEDALHAS<br/><br/></span>
						<?php echo $pontuacaoGeral->getMedalhasOuroGeral();?>
						<span class="descricaoPodium"><br/>Ouro</span>
					</td>
					<td>
						<img src="<?php echo $imgMedalhaBronze;?>" /> 
					</td>
					<td>
					</td>
					<td class="topoPodium" bgcolor="#56a102" rowspan="2">
						<span class="descricaoPodium">PONTOS<br/><br/></span>
						<?php echo $pontuacaoGeral->getPontosGeral();?>
					</td>
					<td width=15px rowspan="2">
					</td>
					<td class="topoPodium" bgcolor="#dc143c" rowspan="2">
						<span class="descricaoPodium">TROF�US<br/><br/></span>
						<?php echo $pontuacaoGeral->getTrofeus();?>
					</td>
				</tr>
				<tr align="center" bottom="middle">
					<td class="podiumEsquerdo" bgcolor="#3B5998">
						<?php echo $pontuacaoGeral->getAcertosTimeGanhadorGeral();?>
						<br/><span class="descricaoPodium">Time Ganhador</span>
					</td>
					<td class="podiumDireito" bgcolor="#3B5998">
						<?php echo $pontuacaoGeral->getAcertosPLacarInvertidoGeral();?>
						<br/><span class="descricaoPodium">Placar Invertido</span>
					</td>
					<td width=15px>
					</td>
					<td class="podiumEsquerdo" bgcolor="#FFA500">
						<?php echo $pontuacaoGeral->getMedalhasPrataGeral();?>
						<br/><span class="descricaoPodium">Prata</span>
					</td>
					<td class="podiumDireito" bgcolor="#FFA500">
						<?php echo $pontuacaoGeral->getMedalhasBronzeGeral();?>
						<br/><span class="descricaoPodium">Bronze</span>
					</td>
					<td width=15px>
					</td>
				</tr>
				<tr>
					<td id="prateleira" colspan=11>
					</td>
				</tr>
				</table>
 			</td>
 		</tr>
	<?php 
	
	$dql = "SELECT p FROM PremiosUsuario p WHERE p.usuario = $user_id";
	$query = $entityManager->createQuery($dql);
	$premiosUsuario = $query->getResult();
	foreach($premiosUsuario as $premiacoes) {
		if($premiacoes instanceof PremiosUsuario){
			$statusCampeonato = $premiacoes->getCampeonato()->getStatus();
			if($statusCampeonato == "ativo"){
	?>
					<tr>
						<td>
							<table width="100%" cellspacing="0" cellpadding="0">
							<tr>
								<td height="10px">
								</td>
							</tr>
							<tr align="center" bottom="middle" style ="border-style: solid; border-width: 1">
								<td class="tituloHome" colspan=11>
									<?php echo $premiacoes->getCampeonato()->getNomeCampeonato();?>
								</td>
							</tr>
							<tr>
								<td height="5px">
								</td>
							</tr>
							<tr align="center" bottom="middle">
								<td>
								</td>
								<td>
									<img src="<?php echo $imgAcertoPlacar;?>" />  
								</td>
								<td>
								</td>
								<td>
								</td>
								<td>
								</td>
								<td>
									<img src="<?php echo $imgMedalhaOuro;?>" />  
								</td>
								<td>
								</td>
								<td>
								</td>
								<td>
									<img src="<?php  echo $imgPontos;?>" />
								</td>
							</tr>
							<tr align="center" bottom="middle">
								<td>
									<img src="<?php echo $imgAcertoTimeGanhador;?>" />   
								</td>
								<td class="topoPodium" bgcolor="#3B5998" rowspan="2">
									<span class="descricaoPodium">ACERTOS<br/><br/></span>
										<?php echo $premiacoes->getAcertosPlacar();?>
										<span class="descricaoPodium"><br/>Placar Completo</span>
									</span>
								</td>
								<td>
									<img src="<?php echo $imgAcertoPlacarInvertido;?>" />   
								</td>
								<td>
								</td>
								<td>
									<img src="<?php echo $imgMedalhaPrata;?>" /> 
								</td>
								<td class="topoPodium" bgcolor="#FFA500" rowspan="2">
									<span class="descricaoPodium">MEDALHAS<br/><br/></span>
									<?php echo $premiacoes->getMedalhasOuro();?>
									<span class="descricaoPodium"><br/>Ouro</span>
								</td>
								<td>
									<img src="<?php echo $imgMedalhaBronze;?>" /> 
								</td>
								<td>
								</td>
								<td class="topoPodium" bgcolor="#56a102" rowspan="2">
									<span class="descricaoPodium">PONTOS<br/><br/></span>
									<?php echo $premiacoes->getPontosCampeonato();?>
								</td>
							</tr>
							<tr align="center" bottom="middle">
								<td class="podiumEsquerdo" bgcolor="#3B5998">
									<?php echo $premiacoes->getAcertosTimeGanhador();?>
									<br/><span class="descricaoPodium">Time Ganhador</span>
								</td>
								<td class="podiumDireito" bgcolor="#3B5998">
									<?php echo $premiacoes->getAcertosPlacarInvertido();?>
									<br/><span class="descricaoPodium">Placar Invertido</span>
								</td>
								<td width=15px>
								</td>
								<td class="podiumEsquerdo" bgcolor="#FFA500">
									<?php echo $premiacoes->getMedalhasPrata();?>
									<br/><span class="descricaoPodium">Prata</span>
								</td>
								<td class="podiumDireito" bgcolor="#FFA500">
									<?php echo $premiacoes->getMedalhasBronze();?>
									<br/><span class="descricaoPodium">Bronze</span>
								</td>
								<td width=15px>
								</td>
							</tr>
							<tr>
								<td id="prateleira" colspan=11>
								</td>
							</tr>
							</table>
			 			</td>
			 		</tr>
			      
	<?php
			}
		}
	}
	echo '</table></center>';
	$conn->commit();
} catch(Exception $e) {
	$conn->rollback();
	echo $e->getMessage() . "<br/><font color=red>Não foi possível gravar os dados. Verifique o Banco de Dados.</font><br/>";
}
$conn->close();
?>
  

    