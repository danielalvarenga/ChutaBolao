<?php
$conn = $entityManager->getConnection();
$conn->beginTransaction();
try{  
	$pontuacaoGeral = $entityManager->find("PontuacaoGeral", $user_id);
?>
	 			<div id="Mural">
					
		 			<span class="titulo">Premiação Geral</span>
		 			<span id="compartilharMural">
						<a class="compartilhar" href="" target="_blank">compartilhar</a>
			        </span>
			        
			    <div id="pontos">
			      <div class="texto">
			        <span class="bordas">
			        	<img class="iconG" src="imagens/premios/pontos.png" />
			        	<table border="0" celpadding="0" celspacing="0" style="display:inline-block; *display:inline; _display:inline;" height="58">
				         	<tr height="55">
				         		<td>
						            <span class="total_pontos"><?php echo $pontuacaoGeral->getPontosGeral(); ?></span> 
						            Pontos
						        </td>
							</tr>
						</table>
			        </span>
			      </div>
			    </div>
			    
			    
	
			    <div id="medalhas">
			      <div class="texto">
			      	<span class="bordas">
				        <img class="iconG" src="imagens/premios/medalha-ouro.png" />  
				        <table border="0" celpadding="0" celspacing="0" style="display:inline-block; *display:inline; _display:inline;" height="58">
				          <tr height="25">
										<td  class="prata"><span><?php echo 'Prata '.$pontuacaoGeral->getMedalhasPrataGeral(); ?></span></td>
										<td class="bronze"><span><?php echo 'Bronze '.$pontuacaoGeral->getMedalhasBronzeGeral(); ?></span></td>
									</tr>
				          <tr height="30">
										<td class="ouro"><span><?php echo 'Ouro '.$pontuacaoGeral->getMedalhasOuroGeral(); ?></span></td>
									</tr>
				        </table>
			        </span>
			      </div>
			    </div>
			    
			    <div id="chuteiras">
			      <div class="texto">
			      	<span class="bordas">
				        <img class="iconG" src="imagens/premios/chuteira-ouro.png" />  
				        <table border="0" celpadding="0" celspacing="0" style="display:inline-block; *display:inline; _display:inline;" height="58">
				          <tr height="25">
										<td  class="prata"><span>000</span></td>
										<td class="bronze"><span>000</span></td>
									</tr>
				          <tr height="30">
										<td class="ouro"><span>000</span></td>
									</tr>
				        </table>
			        </span>
			      </div>
			    </div>
			    
			    <div id="trofeus">
			      <div class="texto">
			        <span class="bordas">
			        	<img class="iconG" src="imagens/premios/trofeu.png" />
			            <table border="0" celpadding="0" celspacing="0" style="display:inline-block; *display:inline; _display:inline;" height="58">
				         	<tr height="55">
				         		<td class="total_trofeus">
					            	<?php
									if ($pontuacaoGeral->getTrofeus() == 0){
									 	echo '<font size="2">Conquiste troféus sendo o melhor do Campeonato!</font>';
									 } else if ($pontuacaoGeral->getTrofeus() == 1){
									 	echo '<font size="3">'.$pontuacaoGeral->getTrofeus().' Troféu Conquistado</font>';
									 } else{
									 	echo '<font size="3">'.$pontuacaoGeral->getTrofeus().' Troféus Conquistados</font>';
									 }
									?>
								</td>
							</tr>
						</table>
			        </span>
			      </div>
			    </div>
			    
			
			    <div id="acertos">
			      <div class="texto">
			      	<span class="bordas">
				        <img class="iconG" src="imagens/premios/chuteira-ouro.png" />
				        <table border="0" celpadding="0" celspacing="0" style="display:inline-block; *display:inline; _display:inline;" height="58">
				          <tr height="25">
										<td><span class="timeGanhador"><?php echo $pontuacaoGeral->getAcertosTimeGanhadorGeral().' Acertos de Ganhador'; ?></span></td>
										<td><span class="placarInvertido"><?php echo $pontuacaoGeral->getAcertosPlacarInvertidoGeral().' Acertos Invertidos'; ?></span></td>
									</tr>
				          <tr height="30">
										<td><span class="placarCorreto"><?php echo $pontuacaoGeral->getAcertosPlacarGeral().' Acertos de Placar'; ?></span></td>
									</tr>
				        </table>
			        </span>
			      </div>
			    </div>
			    
			    </div>
	 
	<?php 
	
	$posicao = "MuralDireita";
	$dql = "SELECT p FROM PremiosUsuario p WHERE p.usuario = $user_id";
	$query = $entityManager->createQuery($dql);
	$premiosUsuario = $query->getResult();
	foreach($premiosUsuario as $premiacoes) {
		if($premiacoes instanceof PremiosUsuario){
			$statusCampeonato = $premiacoes->getCampeonato()->getStatus();
			if($statusCampeonato == "ativo"){
	?>
				<div id="Mural">
					
		 			<span class="titulo"><?php echo $premiacoes->getCampeonato()->getNomeCampeonato().' '.$premiacoes->getCampeonato()->getAnoCampeonato();?></span>
		 			<span id="compartilharMural">
						<a class="compartilhar" href="" target="_blank">compartilhar</a>
			        </span>
			        
			    <div id="pontos">
			      <div class="texto">
			        <span class="bordas">
			        	<img class="iconG" src="imagens/premios/pontos.png" />
			            <span class="total_pontos"><?php echo $premiacoes->getPontosCampeonato(); ?></span> 
			            Pontos
			        </span>
			      </div>
			    </div>
			    
			    
	
			    <div id="medalhas">
			      <div class="texto">
			      	<span class="bordas">
				        <img class="iconG" src="imagens/premios/medalha-ouro.png" />  
				        <span class="prata"><?php echo 'Prata '.$premiacoes->getMedalhasPrata(); ?></span>
						<span class="bronze"><?php echo 'Bronze '.$premiacoes->getMedalhasBronze(); ?></span>
						<span class="ouro"><?php echo 'Ouro '.$premiacoes->getMedalhasOuro(); ?></span>
			        </span>
			      </div>
			    </div>
			    
			    <div id="chuteiras">
			      <div class="texto">
			      	<span class="bordas">
				        <img class="iconG" src="imagens/premios/chuteira-ouro.png" />  
				        <span class="prata"><?php echo 'Prata '.$premiacoes->getChuteirasPrata(); ?></span>
						<span class="bronze"><?php echo 'Bronze '.$premiacoes->getChuteirasBronze(); ?></span>
						<span class="ouro"><?php echo 'Ouro '.$premiacoes->getChuteirasOuro(); ?></span>
			        </span>
			      </div>
			    </div>
			    
			
			    <div id="acertos">
			      <div class="texto">
			      	<span class="bordas">
				        <img class="iconG" src="imagens/premios/chuteira-ouro.png" />  
				        <span class="timeGanhador"><?php echo $premiacoes->acertaTimeGanhador().' Acertos de Ganhador'; ?></span>
						<span class="placarInvertido"><?php echo $premiacoes->acertaPlacarInvertido().' Acertos Invertidos'; ?></span>
						<span class="placarCorreto"><?php echo $premiacoes->acertaPlacar().' Acertos de Placar'; ?></span>
			        </span>
			      </div>
			    </div>
			    
			    </div>
							<br/>
	<?php
			}
		}
		if($posicao == "MuralDireita"){
			$posicao = "Mural";
		} else{
			$posicao = "MuralDireita";
		}
	}
	$conn->commit();
} catch(Exception $e) {
	$conn->rollback();
	echo $e->getMessage() . "<br/><font color=red>Não foi possível gravar os dados. Verifique o Banco de Dados.</font><br/>";
}
$conn->close();
?>
  

    