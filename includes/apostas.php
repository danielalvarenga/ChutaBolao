<?php
require ("bootstrap.php");

function opcaoUsuario(){
	for($indiceEscolhaUsuario = 0 ; $indiceEscolhaUsuario < 100 ; $indiceEscolhaUsuario++ ){
		echo "<OPTION VALUE=$indiceEscolhaUsuario>$indiceEscolhaUsuario</OPTION>";
	}
}

if(isset($_POST)){
	$contador=0;
	$contador1=0;
	for ($i=0;$i<sizeof($_POST)/4;$i++){
		$aux=$i <<2;
		$jogo_campeonato=$_POST[$aux];
		
		$jogo_numero= $_POST[$aux + 1 ];

		$palpite_time1_jogo= $_POST[$aux + 2 ];

		$palpite_time2_jogo= $_POST[$aux + 3 ];
    	
		$dql = "SELECT a FROM Aposta a WHERE a.jogo='$jogo_numero' AND 
		a.usuario='100000885523520' AND a.campeonato='$jogo_campeonato'";
		
		$query = $entityManager->createQuery($dql);
		$apostasCadastrada = $query->getResult();

		$dql = "SELECT j FROM Jogo j WHERE j.codJogo='$jogo_numero' AND j.campeonato='$jogo_campeonato'";
		$query = $entityManager->createQuery($dql);
		$jogos = $query->getResult();

		$campeonato= $entityManager->find("Campeonato", $jogo_campeonato);
		$usuario = $entityManager->find("Usuario",$user_id);
		
	//Cria um objeto PremiosUsuario para o Usuario no Campeonato do Jogo que apostou se ainda não existir		
		$premiosUsuario = $entityManager->find("PremiosUsuario", array(
				"campeonato" =>	$jogo_campeonato,
				"usuario" => $user_id
		));
		if(!$premiosUsuario instanceof PremiosUsuario){
			$premiosUsuario = new PremiosUsuario($usuario, $campeonato);
			$entityManager->persist($premiosUsuario);
			$entityManager->flush();
		}
		
	//Cria um objeto PontuacaoRodada para o Usuario na Rodada do Jogo que apostou se ainda não existir
		$objJogo = $entityManager->find("Jogo", $jogo_numero);
		$pontuacaoRodada = $entityManager->find("PontuacaoRodada", array(
				"campeonato" =>	$jogo_campeonato,
				"rodada" => $objJogo->getRodada()->getNumRodada(),
				"usuario" => $user_id
		));
		if(!$pontuacaoRodada instanceof PontuacaoRodada){
			$pontuacaoRodada = new PontuacaoRodada($objJogo->getRodada(), $campeonato, $usuario);
			$entityManager->persist($pontuacaoRodada);
			$entityManager->flush();
		}

		if ($apostasCadastrada<>NULL){
			foreach ($apostasCadastrada as $apostaCadastrada){
			
			if ($apostaCadastrada->getApostaGolsTime1()<>$palpite_time1_jogo) {

				$apostaCadastrada->setApostaGolsTime1($palpite_time1_jogo);
				$entityManager->merge($apostaCadastrada);
				$entityManager->flush();
				$contador1++;
			}

			if($apostaCadastrada->getApostaGolsTime2()<>$palpite_time2_jogo){

				$apostaCadastrada->setApostaGolsTime2($palpite_time2_jogo);
				$entityManager->merge($apostaCadastrada);
				$entityManager->flush();
				$contador1++;
			}

		}

  }
		else{
			if (($palpite_time1_jogo<>'') && ($palpite_time2_jogo<>'')){
				foreach ($jogos as $jogo){
					$apostaNova = new Aposta($usuario, $campeonato, $jogo);
					$apostaNova->setApostaGolsTime1($palpite_time1_jogo);
					$apostaNova->setApostaGolsTime2($palpite_time2_jogo);
					$entityManager->persist($apostaNova);
					$entityManager->flush();
					$contador++;
				
				}
			}
		
		}
	}
	if($contador>0){
	echo"<p align='center'>
	<table id='painel'>
		<tr>
			<td>
				<p align='center'>Aposta realizada com sucesso</p>
			</td>
		</tr>
	</table>";	
	}
	if($contador1>0){
		echo"<p align='center'>
		<table id='painel'>
			<tr>
				<td>
					<p align='center'>Aposta atualizada com sucesso</p>
				</td>
			</tr>
		</table>";	
	}
}


/////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////
?>

<?php
/////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////

	require "bootstrap.php";

		$dataAgora = new DateTime('now', new DateTimeZone('America/Sao_Paulo'));
	    $dataAtual = $dataAgora->format( "Y-m-d H:i:s" );
	
	$dql = "SELECT c FROM Campeonato c WHERE c.status='ativo' ";
	$query= $entityManager->createQuery($dql);
	$campeonatos= $query->getResult();
	
	if($campeonatos<>NULL){
 
	$opcaoVazia=' ';
	$imprimeLetraX= " X ";
    
		foreach ($campeonatos as $campeonato){
	// Essa parte do codigo busca os jogos cadastradas dentro do banco de dados.
	$dql = "SELECT j FROM Jogo j WHERE'$dataAtual'>= j.dataInicioApostas AND '$dataAtual
	'<=j.dataFimApostas AND j.campeonato=".$campeonato->getCodCampeonato()." ORDER BY j.dataJogo ";

	$query = $entityManager->createQuery($dql);
	$jogos = $query->getResult();

	//Aqui esta testando se a busca voltou com algum jogo ou nao

	if($jogos<>NULL){

		echo '<html ><body><head >
	<link rel="stylesheet" type="text/css" href="estilos/folha_aposta.css"/>
</head >	
		<table  align="center" border="1">
		<td id="aposta" align="center" colspan="7">'
		.$campeonato->getNomeCampeonato().'</td>
		<form action="" method="POST" >';

				$contadorArray=0;

    		foreach ($jogos as $jogo){
            $aux=$contadorArray << 2;
			$numero_campeonato= $aux ;
			$numeroJogo= $aux+1;
			$apostaGolsUsuarioTime1=$aux+2;
			$apostaGolsUsuarioTime2=$aux+3;
				
			// Essa parte do codigo busca aposta do usuario de acordo com o numero do
			//jogo cadastradas dentro do banco de dados.

			$dql = "SELECT a FROM Aposta a WHERE a.jogo=".$jogo->getCodJogo()." AND a.usuario=".$user_id." 
			AND a.campeonato=".$campeonato->getCodCampeonato();
			$query = $entityManager->createQuery($dql);
			$apostas = $query->getResult();

			//Aqui esta buscando os nomes dos times do jogo

			$dql = "SELECT t FROM Time t WHERE t.codTime=".$jogo->getCodtime1();
			$query = $entityManager->createQuery($dql);

			$times = $query->getResult();
			foreach ($times as $time){
				$time1=$time->getNomeTime();
				$escudo1=$time->getEscudo();
			}
			//Aqui esta buscando os nomes dos times do jogo

			$dql = "SELECT t FROM Time t WHERE t.codTime=".$jogo->getCodtime2();
			$query = $entityManager->createQuery($dql);

			$times = $query->getResult();
			foreach ($times as $time){
				$time2=$time->getNomeTime();
				$escudo2=$time->getEscudo();
			}
			//Aqui esta testando se a busca voltou com alguma aposta ou nao

	if ($apostas<>NULL){
			foreach ($apostas as $aposta){
				$apostaGolsTime1=$aposta->getApostaGolsTime1();
				$apostaGolsTime2=$aposta->getApostaGolsTime2();

				}
		echo "<tr align='center'><td>$time1</td><td><img src='../ChutaBolao/$escudo1'>
		</td><td>
	    <INPUT type='hidden' name='$numero_campeonato' value=".$campeonato->getCodCampeonato().">
	    <INPUT type='hidden' name='$numeroJogo' value=".$jogo->getCodJogo().">
	    <SELECT name=$apostaGolsUsuarioTime1>
	    <OPTION VALUE=$apostaGolsTime1>$apostaGolsTime1</OPTION>";
				
		opcaoUsuario();
		echo "</SELECT></td><td>$imprimeLetraX</td><td>   
	       	  <SELECT name=$apostaGolsUsuarioTime2>
			  <OPTION VALUE=$apostaGolsTime2>$apostaGolsTime2</OPTION>";

				opcaoUsuario();
		echo "</SELECT></td><td><img src='../ChutaBolao/$escudo2'>
		</td><td>$time2</td></tr><br> ";

			}

			else {
				// Esse for serve para imprimir todo os jogos corrente da rodada.

				echo "<tr align='center'><td>$time1</td><td><img src='../ChutaBolao/$escudo1'></td><td>
			    <INPUT type='hidden' name='$numero_campeonato' value=".$campeonato->getCodCampeonato().">	
			    <INPUT type='hidden' name='$numeroJogo' value=".$jogo->getCodJogo().">
		        <SELECT name=$apostaGolsUsuarioTime1>
		        <OPTION VALUE=$opcaoVazia>$opcaoVazia</OPTION>";
			
   				opcaoUsuario();
				echo "</SELECT></td><td>$imprimeLetraX</td><td>   

				 <SELECT name=$apostaGolsUsuarioTime2>
		    	 <OPTION VALUE=$opcaoVazia>$opcaoVazia</OPTION>";
				
			 	opcaoUsuario();
			 	echo "</SELECT></td><td><img src='../ChutaBolao/$escudo2'>
			 	</td><td> $time2 </td></tr><br>";

			}
			$contadorArray++;
		}

		echo "<br><td align='center'  colspan='7' >
		<input  type='submit' value='Salvar Apostas'></td></table></form>";
	}
		}
	echo "</body></html>";
		
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////
?>
