<?php
 require "bootstrap.php";
 
 $dql = 'SELECT p FROM PremiosUsuario p WHERE p.usuario ='.$user_id;
 $query = $entityManager->createQuery($dql);
 $premiacoes = $query->getResult();
 
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
 
 foreach($premiacoes as $premiacoes) {
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
		    <div id="pontos">
		      <div class="texto">
		        <img border="0" class="icon" src="imagens/premios/pontos.png" />
		        <span id="pontos">
		          Total de Pontos de Conquista: 
		            <span class="total_pontos"><?php echo $pontosGeral; ?></span>
		          
		        </span>
		      </div>
		    </div>
		
		    <div id="medalhas">
		      <div class="texto">
		        <img border="0" class="icon" src="imagens/premios/medalha-ouro.png" />  
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
		        <img border="0" class="icon" src="imagens/premios/chuteira-ouro.png" />  
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
		        <img border="0" class="icon" src="imagens/premios/trofeu.png" />
		        <span>
		        <?php
					if ($trofeus == 0){
					 	echo 'Conquiste seu primeiro troféu sendo o melhor do Campeonato!';
					 } else if ($trofeus == 1){
					 	echo $trofeus.' Troféu Conquistado';
					 } else{
					 	echo $trofeus.' Troféus Conquistados';
					 }
				?>
		        
		        </span>
		      </div>
		    </div>
		
		    <div id="divulgar">
		      <div class="texto">
		        <img border="0" class="icon" src="/images/compartilhe.jpg?1298213892" />
		        <a href="" target="_blank"><img border="0" class="divulge" id="twitter" src="/images/divulgar_twitter.png?1289390536" /></a>
		        <a href="" target="_blank"><img border="0" class="divulge" id="facebook" src="/images/divulgar_facebook.png?1289390536" /></a>
		      </div>
		    </div>
		    <br/>
 
<?php 

?>
  

    