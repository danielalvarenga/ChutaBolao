<?php
 require "bootstrap.php";
 
 $premiacoes = $entityManager->find('PremiosUsuario', $usuario_id);
 $user->getGroups()->add($group);
 $premiacoes = $usuario->getPremiacoesUsuario();
 if($premiacoes != NULL){
 	
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
 	foreach($premiacoes as $premiacoes) {
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
 		if($premiacoes->getCampeonato()->getSatus() == "ativo"){
 			
 		}
 	}
 }
 ?>
 
 			<div id="Mural">
		    <div id="pontos">
		      <div class="texto">
		        <img border="0" class="icon" src="imagens/premios/pontos.png" />
		        <span id="pontos">
		          Total de Pontos de Apostas: 
		            <span class="contador_regressivo">852</span>
		          
		        </span>
		      </div>
		    </div>
		
		    <div id="medalhas">
		      <div class="texto">
		        <img border="0" class="icon" src="imagens/premios/medalha-ouro.png" />  
		        <table border="0" celpadding="0" celspacing="0" style="display:inline-block; *display:inline; _display:inline;" height="58">
		          <tr height="25">
								<td id="de"><span>Prata 12</span></td>
								<td id="de"><span>Bronze 05</span></td>
							</tr>
		          <tr height="30">
								<td id="por"><span>Ouro 07</span></td>
							</tr>
		        </table>
		      </div>
		    </div>
		    
		    <div id="chuteiras">
		      <div class="texto">
		        <img border="0" class="icon" src="imagens/premios/chuteira-ouro.png" />  
		        <table border="0" celpadding="0" celspacing="0" style="display:inline-block; *display:inline; _display:inline;" height="58">
		          <tr height="25">
								<td id="de"><span>Prata 12</span></td>
								<td id="de"><span>Bronze 05</span></td>
							</tr>
		          <tr height="30">
								<td id="por"><span>Ouro 07</span></td>
							</tr>
		        </table>
		      </div>
		    </div>
		    
		    <div id="trofeu">
		      <div class="texto">
		        <img border="0" class="icon" src="imagens/premios/trofeu.png" />
		        <span>
		        
		          Troféus: 01
		        
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
<?php /*
 		} else{

 		echo $cidade->getId() . " - " . $cidade->getNome() . " - " . $cidade->getUf() . "<br/ >";
 	}
 } 
 
*/?>
  

    