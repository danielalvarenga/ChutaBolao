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
	<table id="tabelaHome" style ="border-style: solid; border-width: 1; color: #FFFFFF" width="90%" bgcolor="#E4E4E4" cellspacing="5" cellpadding="5">
		<tr>
			<td>
				<table  width="100%" cellspacing="0" cellpadding="0">
				<tr align="center" bottom="middle" style ="border-style: solid; border-width: 1">
					<td style="color: #FFFFFF" colspan=11 bgcolor="#56a102" height="40px">
						<h3>PODIUM GERAL</h3>
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
					<td bgcolor="#3B5998" width=80px height=60px>
						<span class="total_pontos">
							<?php echo $pontuacaoGeral->getAcertosPlacarGeral();?>
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
					<td bgcolor="#FFA500" width=80px height=60px>
						<?php echo $pontuacaoGeral->getMedalhasOuroGeral();?>
					</td>
					<td>
						<img src="<?php echo $imgMedalhaBronze;?>" /> 
					</td>
					<td>
					</td>
					<td bgcolor="#56a102" width=80px height=60px>
						<?php echo $pontuacaoGeral->getPontosGeral();?>
					</td>
					<td>
					</td>
					<td bgcolor="#dc143c" width=80px height=60px>
						<?php echo $pontuacaoGeral->getTrofeus();?>
					</td>
				</tr>
				<tr align="center" bottom="middle">
					<td bgcolor="#3B5998" width=80px height=60px>
						<?php echo $pontuacaoGeral->getAcertosTimeGanhadorGeral();?>
						Time Ganhador
					</td>
					<td bgcolor="#3B5998" width=80px height=60px>
						Placar Completo
					</td>
					<td bgcolor="#3B5998" width=80px height=60px>
						<?php echo $pontuacaoGeral->getAcertosPLacarInvertidoGeral();?>
						Placar Invertido
					</td>
					<td width=15px>
					</td>
					<td bgcolor="#FFA500" width=80px height=60px>
						<?php echo $pontuacaoGeral->getMedalhasPrataGeral();?>
						Prata
					</td>
					<td bgcolor="#FFA500" width=80px height=60px>
						Ouro
					</td>
					<td bgcolor="#FFA500" width=80px height=60px>
						<?php echo $pontuacaoGeral->getMedalhasBronzeGeral();?>
						Bronze
					</td>
					<td width=15px>
					</td>
					<td bgcolor="#56a102" width=80px height=60px>
						Pontos
					</td>
					<td width=15px>
					</td>
					<td  bgcolor="#dc143c" width=80px height=60px>
						Troféus
					</td>
				</tr>
				</table>
 			</td>
 		</tr>
 	</table>
 	</center>
	<?php 
	
	$dql = "SELECT p FROM PremiosUsuario p WHERE p.usuario = $user_id";
	$query = $entityManager->createQuery($dql);
	$premiosUsuario = $query->getResult();
	foreach($premiosUsuario as $premiacoes) {
		if($premiacoes instanceof PremiosUsuario){
			$statusCampeonato = $premiacoes->getCampeonato()->getStatus();
			if($statusCampeonato == "ativo"){
	?>
				<center>
				<table id="tabelaHome" style ="border-style: solid; border-width: 1; color: #FFFFFF" width="90%" bgcolor="#E4E4E4" cellspacing="5" cellpadding="5">
					<tr>
						<td>
							<table width="100%" cellspacing="0" cellpadding="0">
							<tr align="center" bottom="middle" style ="border-style: solid; border-width: 1">
								<td style="color: #FFFFFF" colspan=9 bgcolor="#56a102" height="40px">
									<h3><?php echo $premiacoes->getCampeonato()->getNomeCampeonato();?></h3>
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
								<td bgcolor="#3B5998" width=80px height=60px>
									<?php echo $premiacoes->getAcertosPlacar();?>
								</td>
								<td>
									<img src="<?php echo $imgAcertoPlacarInvertido;?>" />   
								</td>
								<td>
								</td>
								<td>
									<img src="<?php echo $imgMedalhaPrata;?>" /> 
								</td>
								<td bgcolor="#FFA500" width=80px height=60px>
									<?php echo $premiacoes->getMedalhasOuro();?>
								</td>
								<td>
									<img src="<?php echo $imgMedalhaBronze;?>" /> 
								</td>
								<td>
								</td>
								<td bgcolor="#56a102" width=80px height=60px>
									<?php echo $premiacoes->getPontosCampeonato();?>
								</td>
							</tr>
							<tr align="center" bottom="middle">
								<td bgcolor="#3B5998" width=80px height=60px>
									<?php echo $premiacoes->getAcertosTimeGanhador();?>
									Time Ganhador
								</td>
								<td bgcolor="#3B5998" width=80px height=60px>
									Placar Completo
								</td>
								<td bgcolor="#3B5998" width=80px height=60px>
									<?php echo $premiacoes->getAcertosPlacarInvertido();?>
									Placar Invertido
								</td>
								<td width=15px>
								</td>
								<td bgcolor="#FFA500" width=80px height=60px>
									<?php echo $premiacoes->getMedalhasPrata();?>
									Prata
								</td>
								<td bgcolor="#FFA500" width=80px height=60px>
									Ouro
								</td>
								<td bgcolor="#FFA500" width=80px height=60px>
									<?php echo $premiacoes->getMedalhasBronze();?>
									Bronze
								</td>
								<td width=15px>
								</td>
								<td bgcolor="#56a102" width=80px height=60px>
									Pontos
								</td>
							</tr>
							</table>
			 			</td>
			 		</tr>
			 	</table>
			 	</center>
			      
	<?php
			}
		}
	}
	$conn->commit();
} catch(Exception $e) {
	$conn->rollback();
	echo $e->getMessage() . "<br/><font color=red>Não foi possível gravar os dados. Verifique o Banco de Dados.</font><br/>";
}
$conn->close();
?>
  

    