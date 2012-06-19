<?php
$conn = $entityManager->getConnection();
$conn->beginTransaction();
try{

$usuario = $entityManager->find("Usuario", $user_id);
 
echo "<table id='tabela' align='center' cellspacing=0>
			<td id='aposta'align='center' colspan='6'>
				Ranking Classificacao Geral
			</td class=\"coluna\">
		<tr align='center'class=\"linha\">
				<td>
					Usuario Teste
				</td class=\"coluna\">
				<td >
					Classificacao Geral
				</td>
				<td >
					Classificacao Medalhas
				</td class=\"coluna\">
				<td >
					<img  src='..\ChutaBolao\imagens\premios\medalha-ouro.png'>
				</td class=\"coluna\">
				<td >
					<img  src='..\ChutaBolao\imagens\premios\medalha-ouro.png'>
				</tdclass=\"coluna\">
				<td >
					<img  src='..\ChutaBolao\imagens\premios\medalha-ouro.png'>
				</td class=\"coluna\">
		
		</tr><br>	
    	   
		<tr align='center' bgcolor='lime'>
		   	<font size='4'>
		    	<td>
		    		Sua Classificacao
		    	</td>
		    	<td>"
		    		.$usuario->getClassificacaoGeral()."
		    	</td>
		    	<td>	
		    		Teste
		    	</td>
		    	<td>"
		    		.$usuario->getPontosGeral()."
		    	</td>
		    	<td>"
		    		.$usuario->getPrimeiroNomeUsuario()."
		    	</td>
		    	<td>"
		    		.$usuario->getSegundoNomeUsuario()."
		    	</td>
		    </font>
		</tr>";
 
$dql = "SELECT u FROM Usuario u ORDER BY u.classificacaoGeral ";
$query= $entityManager->createQuery($dql);
$query->setMaxResults(10);
$usuarios= $query->getResult();
    
       
       if($usuarios<>NULL){	
		    foreach ($usuarios as $usuario){
		    	if ($user_id==$usuario->getIdUsuario()) {
		    	echo "<tr align='center'  bgcolor='lime'>
		    				<font size='4'>
		    					<td>"
		    						.$usuario->getIdUsuario()."
		    					</td>
		    					<td>"
		    						.$usuario->getClassificacaoGeral()."
		    					</td>
		    					<td>
		    						Teste
		    					</td>
		    					<td>"
		    						.$usuario->getPontosGeral()."
		    					</td>
		    					<td>"
		    						.$usuario->getPrimeiroNomeUsuario()."
		    					</td>
		    					<td>"
		    						.$usuario->getSegundoNomeUsuario()."
		    					</td>
		    				</font>
		    		</tr>";
		    	}
		    	else{
		    		echo "<tr align='center' bgcolor='#FFA500'>
							<font size='4'>		    		
		    					<td>"
		    						.$usuario->getIdUsuario()."
		    					</td>
		    					<td>"
		    						.$usuario->getClassificacaoGeral()."
		    					</td>
		    					<td>
		    						Teste
		    					</td>
		    					<td>"
		    						.$usuario->getPontosGeral()."
		    					</td>
		    					<td>"
		    						.$usuario->getPrimeiroNomeUsuario()."
		    					</td>
		    					<td>"
		    						.$usuario->getSegundoNomeUsuario()."
		    					</td>
		    				</font>
		    			</tr>";
		    		 
			        }
		    }
echo "</table>";  
    }
	//classificao geral ok
$dql = "SELECT c FROM Campeonato c WHERE c.status='ativo' ";
$query= $entityManager->createQuery($dql);
$campeonatos= $query->getResult();

if($campeonatos<>NULL){
	foreach ($campeonatos as $campeonato)	{
			$dql = "SELECT p FROM PremiosUsuario p WHERE p.campeonato=".$campeonato->getCodCampeonato() ;
			$query= $entityManager->createQuery($dql);
			$query->setMaxResults(10);
			$premiosUsuario= $query->getResult();
				
if ($premiosUsuario<>NULL) {
	 $premioUsuario=$entityManager->find("PremiosUsuario", array(
								"campeonato" =>	$campeonato->getCodCampeonato(),
								"usuario" => $user_id
								));
	 	
	echo "<table id='tabela' align='center' cellspacing=0 >
				<td id='aposta'align='center' colspan='6'>
					Ranking ".$campeonato->getNomeCampeonato()." ".$campeonato->getAnoCampeonato()."
				</td class=\"coluna\">
			<tr align='center'class=\"linha\" >
					<td >
						Usuario Teste
					</tdclass=\"coluna\">
					<td>
						Classificacao Campeonato
					</td class=\"coluna\">
					<td >
						Classificacao Medalhas
					</td class=\"coluna\">
					<td>
						<img  src='..\ChutaBolao\imagens\premios\medalha-ouro.png'>
					</td class=\"coluna\">
					<td >
						<img  src='..\ChutaBolao\imagens\premios\medalha-ouro.png'>
					</td class=\"coluna\">
					<td >
						<img  src='..\ChutaBolao\imagens\premios\medalha-ouro.png'>
					</td class=\"coluna\">
			
			</tr><br>	
	    	   
			<tr align='center' bgcolor='lime'>
			   	<font size='4'>
			    	<td >
			    		Sua Classificacao
			    	</td>
			    	<td >"
						.$premioUsuario->getClassificacaoCampeonato()."
			    	</td>
			    	<td >"	
			    		.$premioUsuario->getClassificacaoMedalhas()."
			    	</td>
			    	<td >"
						.$premioUsuario->getMedalhasOuro()."
			    	</td>
			    	<td >"
						.$premioUsuario->getMedalhasPrata()."
			    	</td>
			    	<td >"
						.$premioUsuario->getMedalhasBronze()."
			    	</td>
			    </font>
			</tr>";
	
	
foreach ($premiosUsuario as $premioUsuario)	{
	if ($user_id==$premioUsuario->getUsuario()->getIdUsuario()) {
			echo "<tr align='center' bgcolor='lime'>
							<font size='4'>		    		
		    					<td>"
		    						.$premioUsuario->getUsuario()->getIdUsuario()."
		    					</td>
		    					<td>"
									.$premioUsuario->getClassificacaoCampeonato()."
			    				</td>
			    				<td>"	
			    					.$premioUsuario->getClassificacaoMedalhas()."
			    				</td>
			    				<td>"
									.$premioUsuario->getMedalhasOuro()."
			    				</td>
			    				<td>"
									.$premioUsuario->getMedalhasPrata()."
			    				</td>
			    				<td>"
									.$premioUsuario->getMedalhasBronze()."
			    				</td>
			    			</font>
		    	</tr>";
		    		 
			        }
		    

else{
	echo "<tr align='center' bgcolor='#FFA500'>
								<font size='4'>		    		
			    					<td>"
										.$premioUsuario->getUsuario()->getIdUsuario()."
			    					</td>
			    					<td>"
										.$premioUsuario->getClassificacaoCampeonato()."
			    					</td>
			    					<td>"
			    						.$premioUsuario->getClassificacaoMedalhas()."
			    					</td>
			    					<td>"
										.$premioUsuario->getMedalhasOuro()."
			    					</td>
			    					<td>"
										.$premioUsuario->getMedalhasPrata()."
			    					</td>
			    					<td>"
										.$premioUsuario->getMedalhasBronze()."
			    					</td>
			    				</font>
		 </tr>";
	 
									}

							}

					}
			}
	}
echo "</table>";
$conn->commit();
} catch(Exception $e) {
	$conn->rollback();

	echo
		"<p align='center'>
		<table id='tabela'>
		<tr class=\"linha\">
		<td class=\"coluna\">
		<p align='center'>Não existem dados a serem exibidos. Volte amanhã para conferir.</p>
		</td>
		</tr>
		</table>";
	}
	$conn->close();

       ?>