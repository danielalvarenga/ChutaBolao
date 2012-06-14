<?php 
$dql = "SELECT u FROM Usuario u  ORDER BY u.pontosGeral DESC";
$query= $entityManager->createQuery($dql);
$usuarios= $query->getResult();
    if($usuarios<>NULL){
       echo '<div id="Mural">
		    	<span class="titulo">Classificacao Geral</span>
	 		    	<span id="compartilharMural">
					<a class="compartilhar" href="" target="_blank">compartilhar</a>
		    </span>';

		    foreach ($usuarios as $usuario){
		    	if ($user_id==$usuario->getIdUsuario()) {
		    		echo "<table border='0' celpadding='0' celspacing='0' style='display:inline-block;
		    		         *display:inline; _display:inline;' height='58'><tr><td class='texto'>
		    		         <span id='pontos' >Sua Posicao: ".$usuario->getPrimeiroNomeUsuario().
		    		     " pontuacao de medalhas ".$usuario->getPontosGeral()."</span></td ></tr></table><br>";
		    	}
		    	else{
		            echo "<table border='0' celpadding='0' celspacing='0' style='display:inline-block;
		                     *display:inline; _display:inline;' height='58'><tr><td class='texto'>
		                     <span id='chuteiras' >".$usuario->getPrimeiroNomeUsuario().
		                 " pontuacao de medalhas ".$usuario->getPontosGeral()."</span></td ></tr></table><br>";
		    	}
		    }
	  echo '</div>';
  }
	$dql = "SELECT p FROM PremiosUsuario p  GROUP BY p.pontosMedalhas ORDER BY
	 p.pontosMedalhas  DESC";
	$query= $entityManager->createQuery($dql);
	$premios= $query->getResult();
	if($premios<>NULL){
		$contador=0;
		echo '<div id="Mural">
					
		 			<span class="titulo">Classificacao Geral Medalhas</span>
		 			    <span id="compartilharMural">
						<a class="compartilhar" href="" target="_blank">compartilhar</a>
			        </span><br>';
		foreach ($premios as $premio){
			$contador++;
			if ($user_id==$premio->getUsuario()->getIdUsuario()) {
				echo "<table border='0' celpadding='0' celspacing='0' style='display:inline-block; *display:inline; _display:inline;' height='58'>
			             <tr><td><span id='pontos' >classificacao".$contador." ".$premio->getUsuario()->getIdUsuario().
			                "<br> pontos medalhas ".$premio->getPontosMedalhas()."<br> medalhas de ouro ".$premio->getMedalhasOuro().
			                "<br> medalhas de prata".$premio->getMedalhasPrata().
			             "<br>medalhas de bronze".$premio->getMedalhasBronze().
				     "</span></td ></tr></table><br>";
			}
			else{
				echo "<br> classificacao".$contador." ".$premio->getUsuario()->getIdUsuario().
				        "<br> pontos medalhas ".$premio->getPontosMedalhas().
			                "<br> medalhas de ouro ".$premio->getMedalhasOuro().
			                "<br> medalhas de prata".$premio->getMedalhasPrata().
			            "<br>medalhas de bronze".$premio->getMedalhasBronze()."<br>";
			}
		}
	}
		echo '</div>';
	
/*$dql = "SELECT c FROM Campeonato c WHERE c.status='ativo' ";
$query= $entityManager->createQuery($dql);
$campeonatos= $query->getResult();

if($campeonatos<>NULL){

	foreach ($campeonatos as $campeonato)	{
$dql = "SELECT p FROM PremiosUsuario p WHERE p.campeonato=".$campeonato->getCodCampeonato();
			$query = $entityManager->createQuery($dql);
			$premiosUsuario = $query->getResult();
 echo '<div id="Mural"><span class="titulo">'.$campeonato->getNomeCampeonato().' '.$campeonato->getAnoCampeonato().'</span>';
if ($premiosUsuario<>NULL) {
	echo '
				
	 			<span id="compartilharMural">
					<a class="compartilhar" href="" target="_blank">compartilhar</a>
		        </span>
		    
	';	
foreach ($premiosUsuario as $premioUsuario)	{
	if ($user_id==$premioUsuario->getUsuario()->getIdUsuario()) {
		echo "<table border='0' celpadding='0' celspacing='0' style='display:inline-block; *display:inline; _display:inline;' height='58'>
			        <tr><td><span id='pontos' >".$premioUsuario->getUsuario()->getIdUsuario()." pontucacao ".$premioUsuario->getPontosCampeonato()."</span></td ></tr></table><br>";
	}
else{
echo " ".$premioUsuario->getUsuario()->getIdUsuario()."<br>";
}

}

}
echo "</div>";
}
}
}*/
?>