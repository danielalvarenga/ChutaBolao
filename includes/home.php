﻿<?php
  
 $dql = "SELECT p FROM PremiosUsuario p WHERE p.usuario = $user_id";
 $query = $entityManager->createQuery($dql);
 $premiosUsuario = $query->getResult();
 
 $pontosGeral = 0;
 $acertosPlacarGeral = 0;
 $acertosTimeGanhadorGeral = 0;
 $acertosPlacarInvertidoGeral = 0;
 $medalhasOuroGeral = 0;
 $medalhasPrataGeral = 0;
 $medalhasBronzeGeral = 0;
 $chuteirasOuroGeral = 0;
 $chuteirasPrataGeral = 0;
 $chuteirasBronzeGeral = 0;
 $trofeus = 0;
 
 foreach($premiosUsuario as $premiacoes) {
	if($premiacoes instanceof PremiosUsuario){
		$pontosGeral += $premiacoes->getPontosCampeonato();
		$acertosPlacarGeral += $premiacoes->getAcertosPlacar();
		$acertosTimeGanhadorGeral += $premiacoes->getAcertosTimeGanhador();
		$acertosPlacarInvertidoGeral += $premiacoes->getAcertosPlacarInvertido();
		$medalhasOuroGeral += $premiacoes->getMedalhasOuro();
		$medalhasPrataGeral += $premiacoes->getMedalhasPrata();
		$medalhasBronzeGeral += $premiacoes->getMedalhasBronze();
		$chuteirasOuroGeral += $premiacoes->getChuteirasOuro();
		$chuteirasPrataGeral += $premiacoes->getChuteirasPrata();
		$chuteirasBronzeGeral += $premiacoes->getChuteirasBronze();
		if($premiacoes->getTrofeu()){
			$trofeus += 1;
		}
	}
 }
 ?>
 			<div id="Mural">

	 			<span class="titulo">Premiação Geral</span></td>
				<a href="" target="_blank"><img align="right" height="25" width="150"; border="0" src="imagens/compartilhe.png" /></a>
		        
		    <div id="pontos">
		      <div class="texto">
		        <img align="left" border="0" class="icon" src="imagens/premios/pontos.png" />
		        <span id="pontos">
		            <span class="total_pontos"><?php echo $pontosGeral; ?></span>
		            Pontos
		        </span>
		      </div>
		    </div>

		    <div id="medalhas">
		      <div class="texto">
		        <img align="left" border="0" class="icon" src="imagens/premios/medalha-ouro.png" />  
		        <table border="0" celpadding="0" celspacing="0" style="display:inline-block; *display:inline; _display:inline;" height="58">
		          <tr height="25">
								<td id="prata"><span><?php echo 'Prata '.$medalhasPrataGeral; ?></span></td>
								<td id="bronze"><span><?php echo 'Bronze '.$medalhasBronzeGeral; ?></span></td>
							</tr>
		          <tr height="30">
								<td id="ouro"><span><?php echo 'Ouro '.$medalhasOuroGeral; ?></span></td>
							</tr>
		        </table>
		      </div>
		    </div>
		    
		    <div id="chuteiras">
		      <div class="texto">
		        <img align="left" border="0" class="icon" src="imagens/premios/chuteira-ouro.png" />  
		        <table border="0" celpadding="0" celspacing="0" style="display:inline-block; *display:inline; _display:inline;" height="58">
		          <tr height="25">
								<td id="prata"><span><?php echo 'Prata '.$chuteirasPrataGeral; ?></span></td>
								<td id="bronze"><span><?php echo 'Bronze '.$chuteirasBronzeGeral; ?></span></td>
							</tr>
		          <tr height="30">
								<td id="ouro"><span><?php echo 'Ouro '.$chuteirasOuroGeral; ?></span></td>
							</tr>
		        </table>
		      </div>
		    </div>
		    
		    <div id="trofeu">
		      <div class="texto">
		        <img align="left" border="0" class="icon" src="imagens/premios/trofeu.png" />  
		        <table border="0" celpadding="0" celspacing="0" style="display:inline-block; *display:inline; _display:inline;" height="58">
		        <tr height="55">
					<td id="ouro">
					<span>
					<?php
					if ($trofeus == 0){
					 	echo 'Conquiste troféus sendo o melhor do Campeonato!';
					 } else if ($trofeus == 1){
					 	echo $trofeus.' Troféu Conquistado';
					 } else{
					 	echo $trofeus.' Troféus Conquistados';
					 }
					?>
					</span>
					</td>
				</tr>
		        </table>
		      </div>
		    </div>
		
		    <div id="divulgar">
		      <div class="texto">
		        <img align="left" border="0" class="icon" src="" />
		        <a href="" target="_blank"><img border="0" class="divulge" id="twitter" src="" /></a>
		        <a href="" target="_blank"><img border="0" class="divulge" id="facebook" src="" /></a>
		      </div>
		    </div>
			</div>
			<br/>
 
<?php 

$posicao = "MuralDireita";

foreach($premiosUsuario as $premiacoes) {
	if($premiacoes instanceof PremiosUsuario){
//		$statusCampeonato = $premiacoes->getCampeonato()->getStatus();
//		if($statusCampeonato == "ativo"){
/*			echo $premiacoes->getCampeonato()->getNomeCampeonato().' '.$premiacoes->getCampeonato()->getAnoCampeonato().'<br/><br/>';
			echo $premiacoes->getPontosCampeonato().' Pontos'.'<br/>';
			echo 'Medalhas de Prata '.$premiacoes->getMedalhasPrata().'<br/>';
			echo 'Medalhas de Bronze '.$premiacoes->getMedalhasBronze().'<br/>';
			echo 'Medalhas de Ouro '.$premiacoes->getMedalhasOuro().'<br/>';
			echo 'Chuteiras de Prata '.$premiacoes->getChuteirasPrata().'<br/>';
			echo 'Chuteiras de Bronze '.$premiacoes->getChuteirasBronze().'<br/>';
			echo 'Chuteiras de Ouro '.$premiacoes->getChuteirasOuro().'<br/><br/>';*/
?>
			<div id="<?php  echo $posicao; ?>">
			
			<span class="titulo"><?php echo $premiacoes->getCampeonato()->getNomeCampeonato().' '.$premiacoes->getCampeonato()->getAnoCampeonato();?></span></td>
			<a href="" target="_blank"><img align="right" height="25" width="149"; border="0" src="imagens/compartilhe.png" /></a>
			
			<div id="pontos">
			<div class="texto">
			<img align="left" border="0" class="icon" src="imagens/premios/pontos.png" />
			<span id="pontos">
			<span class="total_pontos"><?php echo $premiacoes->getPontosCampeonato(); ?></span>
					            Pontos
					        </span>
					      </div>
					    </div>
			
					    <div id="medalhas">
					      <div class="texto">
					        <img align="left" border="0" class="icon" src="imagens/premios/medalha-ouro.png" />  
					        <table border="0" celpadding="0" celspacing="0" style="display:inline-block; *display:inline; _display:inline;" height="58">
					          <tr height="25">
											<td id="prata"><span><?php echo 'Prata '.$premiacoes->getMedalhasPrata(); ?></span></td>
											<td id="bronze"><span><?php echo 'Bronze '.$premiacoes->getMedalhasBronze(); ?></span></td>
										</tr>
					          <tr height="30">
											<td id="ouro"><span><?php echo 'Ouro '.$premiacoes->getMedalhasOuro(); ?></span></td>
										</tr>
					        </table>
					      </div>
					    </div>
					    
					    <div id="chuteiras">
					      <div class="texto">
					        <img align="left" border="0" class="icon" src="imagens/premios/chuteira-ouro.png" />  
					        <table border="0" celpadding="0" celspacing="0" style="display:inline-block; *display:inline; _display:inline;" height="58">
					          <tr height="25">
											<td id="prata"><span><?php echo 'Prata '.$premiacoes->getChuteirasPrata(); ?></span></td>
											<td id="bronze"><span><?php echo 'Bronze '.$premiacoes->getChuteirasBronze(); ?></span></td>
										</tr>
					          <tr height="30">
											<td id="ouro"><span><?php echo 'Ouro '.$premiacoes->getChuteirasOuro(); ?></span></td>
										</tr>
					        </table>
					      </div>
					    </div>
					
					    <div id="divulgar">
					      <div class="texto">
					        <img align="left" border="0" class="icon" src="" />
					        <a href="" target="_blank"><img border="0" class="divulge" id="twitter" src="" /></a>
					        <a href="" target="_blank"><img border="0" class="divulge" id="facebook" src="" /></a>
					      </div>
					    </div>
						</div>
						<br/>
<?php
	//	}
	}
	if($posicao == "MuralDireita"){
		$posicao = "Mural";
	} else{
		$posicao = "MuralDireita";
	}
}

?>
  

    