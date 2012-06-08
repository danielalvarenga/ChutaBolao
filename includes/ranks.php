<?php 
$dql = "SELECT u FROM Usuario u  GROUP BY u.pontosGeral ORDER BY u.pontosGeral DESC";
$query= $entityManager->createQuery($dql);
$usuarios= $query->getResult();
if($usuarios<>NULL){
echo '<div id="Mural">
				
	 			<span class="titulo">Classificacao Geral</span>
	 			<span id="compartilharMural">
					<a class="compartilhar" href="" target="_blank">compartilhar</a>
		        </span><br>';
		    foreach ($usuarios as $usuario){
		    	if ($user_id==$usuario->getIdUsuario()) {
		    		echo "<table border='0' celpadding='0' celspacing='0' style='display:inline-block; *display:inline; _display:inline;' height='58'>
		    				        <tr><td><span id='pontos' >".$usuario->getIdUsuario()." pontucacao geral ".$usuario->getPontosGeral()."</span></td ></tr></table><br>";
		    	}
		    	else{
		    echo "<br> ".$usuario->getIdUsuario()." pontucao geral ".$usuario->getPontosGeral()."<br>";	
		    }
		    }
	echo '</div>';
$dql = "SELECT c FROM Campeonato c WHERE c.status='ativo' ";
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
}
?>