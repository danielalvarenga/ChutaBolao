 <?php
 require "bootstrap.php";
 
 $dql = "SELECT p FROM PremiosUsuario p WHERE p.idUsuario = ".$user_id;
 $query = $entityManager->createQuery($dql);
 if($query != NULL){
 	$premios = $query->getResult();
 	
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
 	foreach($premios as $premios) {
 		$pontosGeral = $pontosGeral + $premios->getPontosCampeonato();
 		$acertosPlacarGeral = $acertosPlacarGeral + $premios->getAcertosPlacar();
 		$acertosTimeGanhadorGeral = $acertosTimeGanhadorGeral + $premios->getAcertosTimeGanhador();
 		$acertosPlacarInvertidoGeral = $acertosPlacarInvertidoGeral + $premios->getAcertosPlacarInvertido();
 		$medalhasOuroGeral = $medalhasOuroGeral + $premios->getMedalhasOuro();
 		$medalhasPrataGeral = $medalhasPrataGeral + $premios->getMedalhasPrata();
 		$medalhasBronzeGeral = $medalhasBronzeGeral + $premios->getMedalhasBronze();
 		$chuteirasOuroGeral = $chuteirasOuroGeral + $premios->getChuteirasOuro();
 		$chuteirasPrataGeral = $chuteirasPrataGeral + $premios->getChuteirasPrata();
 		$chuteirasBronzeGeral = $chuteirasBronzeGeral + $premios->getChuteirasBronze();
 		if($premios->getCampeonato()->getSatus() == "ativo"){
 ?>
 
 			<div id="Mural">
		    <div id="pontos">
		      <div class="texto">
		        <img border="0" class="icon" src="imagens/premios/pontos.png" />
		        <span id="pontos_promocao">
		          
		            <span class="contador_regressivo">12:36:35</span>
		          
		        </span>
		      </div>
		    </div>
		
		    <div id="medalhas">
		      <div class="texto">
		        <img border="0" class="icon" src="imagens/premios/medalha-ouro.png" />  
		        <table border="0" celpadding="0" celspacing="0" style="display:inline-block; *display:inline; _display:inline;" height="58">
		          <tr height="25">
								<td id="de"><span>de R$ 29,90</span></td>
							</tr>
		          <tr height="30">
								<td id="por">por <span>R$ 14,95</span></td>
							</tr>
		        </table>
		      </div>
		    </div>
		
		    <div id="chuteiras">
		      <div class="texto">
		        <img border="0" class="icon" src="imagens/premios/chuteira-ouro.png" />
		        desconto de
		        <span>
		        
		          50%
		        
		        </span>
		      </div>
		    </div>
		    
		    <div id="trofeu">
		      <div class="texto">
		        <img border="0" class="icon" src="imagens/premios/trofeu.png" />
		        desconto de
		        <span>
		        
		          50%
		        
		        </span>
		      </div>
		    </div>
		
		    <div id="divulgar">
		      <div class="texto">
		        <img border="0" class="icon" src="/images/compartilhe.jpg?1298213892" />
		        <a href="http://twitter.com/intent/tweet?related=os_mosqueteiros&amp;text=Aquele+prato+que+voc%C3%AA+j%C3%A1+adora+voltou%21+50%25+de+desconto+em+01+Frango+Desossado+Grelhado+%2B+Pur%C3%AA+de+ba...&amp;url=http://OsMosqueteiros.com.br/teresina&amp;via=Os_Mosqueteiros" alt="Espalhe pelo Twitter" target="_blank" title="Espalhe pelo Twitter"><img alt="Divulgar_twitter" border="0" class="divulge" id="twitter" src="/images/divulgar_twitter.png?1289390536" /></a>
		        <a href="http://www.facebook.com/sharer.php?t=Aquele+prato+que+voc%C3%AA+j%C3%A1+adora+voltou%21+50%25+de+desconto+em+01+Frango+Desossado+Grelhado+%2B+Pur%C3%AA+de+batata+%2B+Salada+Verde+%2B+Vinagrete+e+Farofa.+De+R%24+29%2C90+por+R%24+14%2C95+na+Churrascaria+Prime&amp;u=http%3A%2F%2Fwww.osmosqueteiros.com.br%2Fofertas%2Fshow%2F493%3Fcidade%3Dteresina" alt="Espalhe pelo Facebook" name="fb_share" share_url="http://www.OsMosqueteiros.com.br" target="_blank" title="Espalhe pelo Facebook" type="icon"><img alt="Divulgar_facebook" border="0" class="divulge" id="facebook" src="/images/divulgar_facebook.png?1289390536" /></a>
		        <a href="http://promote.orkut.com/preview?cn=Aquele+prato+que+voc%C3%AA+j%C3%A1+adora+voltou%21+50%25+de+desconto+em+01+Frango+Desossado+Grelhado+%2B+Pur%C3%AA+de+batata+%2B+Salada+Verde+%2B+Vinagrete+e+Farofa.+De+R%24+29%2C90+por+R%24+14%2C95+na+Churrascaria+Prime&amp;du=http%3A%2F%2FOsMosqueteiros.com.br%2Fteresina&amp;nt=orkut.com&amp;tn=%2Fsystem%2Fbanners%2F493%2Foriginal%2Fcompra-coletiva-os-mosqueteiros-teresina-churrascaria-picanharia-residencia-prime.jpg&amp;tt=Aquele+prato+que+voc%C3%AA+j%C3%A1+adora+voltou%21+50%25+de+desconto+em+01+Frango+Desossado+Grelhado+%2B+Pur%C3%AA+de+batata+%2B+Salada+Verde+%2B+Vinagrete+e+Farofa.+De+R%24+29%2C90+por+R%24+14%2C95+na+Churrascaria+Prime" alt="Espalhe pelo Orkut" target="_blank" title="Espalhe pelo Orkut"><img alt="Divulgar_orkut" border="0" class="divulge" id="orkut" src="/images/divulgar_orkut.png?1289390536" /></a>
		        <a href="mailto:?subject=Aquele prato que você já adora voltou! 50% de desconto em 01 Frango Desossado Grelhado + Purê de batata + Salada Verde + Vinagrete e Farofa. De R$ 29,90 por R$ 14,95 na Churrascaria Prime &amp;body=http://OsMosqueteiros.com.br/teresina Aquele prato que você já adora voltou! 50% de desconto em 01 Frango Desossado Grelhado + Purê de batata + Salada Verde + Vinagrete e Farofa. De R$ 29,90 por R$ 14,95 na Churrascaria Prime" alt="Espalhe por email" target="_blank" title="Espalhe por email"><img alt="Divulgar_email" border="0" class="divulge" id="email" src="/images/divulgar_email.png?1289390536" /></a>
		      </div>
		    </div>
		    <br/>
<?php 
 		} else{

 		echo $cidade->getId() . " - " . $cidade->getNome() . " - " . $cidade->getUf() . "<br/ >";
 	}
 } 
 
?>
  

    