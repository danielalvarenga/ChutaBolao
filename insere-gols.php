<?php
include "valida_cookies.inc";
require "bootstrap.php";
require "funcoes-insere-gols.php";


if (isset($_POST['jogo'])) {
	
	$codJogo = $_POST['jogo'];
	$jogo = $entityManager->find("Jogo", $codJogo);
	
	$codTime1 = $jogo->getCodTime1();
	$codTime2 = $jogo->getCodTime2();
	$time1 = $entityManager->find("Time", $codTime1);
	$time2 = $entityManager->find("Time", $codTime2);
	
	
	if(isset($_POST['golsTime1'])){
		
		$conn = $entityManager->getConnection();
		$conn->beginTransaction();
		try{
		
		// Atualiza resultado do jogo com os gols
		
			$golsTime1 = $_POST['golsTime1'];
			$golsTime2 = $_POST['golsTime2'];
			$jogo->setResultado($golsTime1, $golsTime2);
			
			atualizaBancoDados($jogo);
			
			$jogo = $entityManager->find("Jogo", $_POST['jogo']);
			
		//Atualização do rendimento dos times --------------------------------
		
			//Time1
			$rendimentoTime1 = $entityManager->find("RendimentoTime", array(
					"time" => $codTime1,
					"campeonato" => $jogo->getCampeonato()->getCodCampeonato()
					));
			$golsPro1 = $golsTime1;
			$golsContra1 = $golsTime2;
			$rendimentoTime1->calculaRendimentoTime($golsPro1, $golsContra1);
			
			atualizaBancoDados($rendimentoTime1);
			
			//Time2
			$rendimentoTime2 = $entityManager->find("RendimentoTime", array(
					"time" => $codTime2,
					"campeonato" => $jogo->getCampeonato()->getCodCampeonato()
			));
			$golsPro2 = $golsTime2;
			$golsContra2 = $golsTime1;
			$rendimentoTime2->calculaRendimentoTime($golsPro2, $golsContra2);
			
			atualizaBancoDados($rendimentoTime2);
			
		//--------------------------------------------------------------------
			$numRodada = $jogo->getRodada()->getNumRodada();
			$codJogo = $jogo->getCodJogo();
			$dqlApostas = "SELECT a FROM Aposta a WHERE a.jogo = $codJogo";
			$apostas = consultaDql($dqlApostas);
			
			foreach ($apostas as $aposta){
				if ($aposta instanceof Aposta){
					$aposta->calculaPontosAposta($jogo->getGolsTime1(),$jogo->getGolsTime2());
					atualizaBancoDados($aposta);
					
					//Atualiza PremiosUsuario do Usuário no Campeonato
					
					$premiosUsuario = $entityManager->find("PremiosUsuario", array(
						"campeonato" =>	$jogo->getCampeonato()->getCodCampeonato(),
						"usuario" => $aposta->getUsuario()->getIdUsuario()
					));
					$premiosUsuario->calculaPontos($aposta->getPontosAposta());
					atualizaBancoDados($premiosUsuario);
					
					//Atualiza Pontos de cada Usuário na Rodada
					
					$pontuacaoRodada = $entityManager->find("PontuacaoRodada", array(
							"campeonato" =>	$jogo->getCampeonato()->getCodCampeonato(),
							"rodada" => $numRodada,
							"usuario" => $aposta->getUsuario()->getIdUsuario()
					));
					$pontuacaoRodada->calculaPontosRodada($aposta->getPontosAposta());
					atualizaBancoDados($pontuacaoRodada);
					
					//Atualiza PontosGeral de cada Usuário
					
					$pontuacaoGeral = $entityManager->find("PontuacaoGeral", $aposta->getUsuario()->getIdUsuario());
					$pontuacaoGeral->calculaPontosGeral($aposta->getPontosAposta());
					atualizaBancoDados($pontuacaoGeral);
					
				} else {
					echo "NÃO EXISTEM APOSTAS PARA ESTE JOGO";
				}
			}
			
			atualizaClassificacaoPontosGeral();
			atualizaClassificacaoPontosCampeonato($jogo);
			atualizaClassificacaoPontosRodada($numRodada, $jogo);
			verificaFimRodada($numRodada, $jogo);
			verificaFinalCampeonato($numRodada, $jogo);
			
			$conn->commit();
		} catch(Exception $e) {
			$conn->rollback();
			echo $e->getMessage() . "<br/><font color=red>Não foi possível gravar os dados. Verifique o Banco de Dados.</font><br/>";
		}
		$conn->close();
		
	}

?>
<html>
<head>
<title>
inserir gols
</title>
</head>
<body>

	<h1 align="center">Inserir Gols</h1>
<br/><br/>
		<h2 align="center">Jogo</h2>
	<table border="1" align="center">
		<tr vertical-align="middle" align="center">
			<td><b>Data</b></td>
			<td><b>Campeonato</b></td>
			<td><b>Rodada</b></td>
			<td><b>Time1</b></td>
			<td><b>Time2</b></td>
			<td><b>Resultado</b></td>
			<td><b>Início de Apostas</b></td>
			<td><b>Fim de Apostas</b></td>
		</tr>
<?php
	echo '
			<tr vertical-align="middle" align="center">
				<td>'.$jogo->getDataJogo().'</td>
				<td>'.$jogo->getCampeonato()->getNomeCampeonato().' '.$jogo->getCampeonato()->getAnoCampeonato().'</td>
				<td>'.$jogo->getRodada()->getNumRodada().'</td>
				<td>'.$time1->getNomeTime().'</td>
				<td>'.$time2->getNomeTime().'</td>
				<td>'.$jogo->getGolsTime1().' X '.$jogo->getGolsTime2().'</td>
				<td>'.$jogo->getDataInicioApostas().'</td>
				<td>'.$jogo->getDataFimApostas().'</td>
			</tr>';
?>
</table>
<br/><br/>
		<h2 align="center">Resultado</h2>
	<form method="POST" action="">
	 	<p align="center"><?php echo $time1->getNomeTime()?> 
	 	<select name="golsTime1">';
	 		<option value="NULL"></OPTION>
			<?php
				for($gols = 0 ; $gols < 100 ; $gols++ ){
					echo "<option value=$gols>$gols</option>";
				};
			?>
		</select>
		 X 
		<select name="golsTime2">
			<option value="NULL"></OPTION>
			<?php
				for($gols = 0 ; $gols < 100 ; $gols++ ){
					echo "<option value=$gols>$gols</option>";
				};
			?>
		</select> <?php echo $time2->getNomeTime();?>
		<br/>
		<input type="hidden" name="jogo" value=<?php echo $jogo->getCodJogo();?>>
		<input type="submit" name="registra-resultado" value="Registrar Resultado"><br/>
		</p>
	</form>
<?php
}
?>
	<br/><br/><br/>
	<p align="center"><a href="cadastra-jogo.php">Voltar para Jogos</a></p>
		<p align="center"><a href="admin.php">Menu Principal</a></p>
</body>
</html>