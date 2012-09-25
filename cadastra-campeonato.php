<?php
include "valida_cookies.inc";
use Doctrine\DBAL\Types\ArrayType;

use Doctrine\ORM\Query\AST\Functions\LengthFunction;

require "bootstrap.php";
require 'metodos-bd.php';

if(isset($_POST['excluir'])){
	$conn = $entityManager->getConnection();
	$conn->beginTransaction();
	try{
		$campeonato = $entityManager->find("Campeonato", $_POST['campeonato']);
		$nomeCampeonato = $campeonato->getNomeCampeonato();
		$anoCampeonato = $campeonato->getAnoCampeonato();
		$logo = $campeonato->getUrlLogo();
		removeBancoDados($campeonato);
		unlink("$campeonato->getUrlLogo()");
		echo "<script> alert('Exclu�do Campeonato $nomeCampeonato $anoCampeonato')
		location = ('cadastra-campeonato.php');
		</script>";
		$conn->commit();
	} catch(Exception $e) {
		$conn->rollback();
		echo $e->getMessage() . "<br/><font color=red>N�o foi poss�vel gravar os dados. Verifique o Banco de Dados.</font><br/>";
	}
	$conn->close();
}

if(isset($_POST['nome'])){
	$conn = $entityManager->getConnection();
	$conn->beginTransaction();
	try{		
		
		if(empty($_POST['nome'])){
			echo "<script> alert('Campo \"Nome\" obrigatorio!')
			location = ('cadastra-time.php');
			</script>";
		}
		elseif(empty($_POST['ano'])){
			echo "<script> alert('Campo \"Ano\" obrigatorio!')
			location = ('cadastra-time.php');
			</script>";
		}
		elseif(empty($_POST['quant'])){
			echo "<script> alert('Campo \"Quantidade de Rodadas\" obrigatorio!')
			location = ('cadastra-time.php');
			</script>";
		}
		else{
			$nome = $_POST['nome'];
			$ano = $_POST['ano'];
			$quant = $_POST['quant'];
			$imagem = $_FILES["logo"];
			// Se a foto estiver sido selecionada
			if (!empty($imagem["name"])) {
					
				// Largura m�xima em pixels
				$largura = 90;
				// Altura m�xima em pixels
				$altura = 90;
		
				$dimensoes = getimagesize($imagem["tmp_name"]);
		
				if($dimensoes[0] <= $largura && $dimensoes[1] <= $altura){
					$dql = "SELECT c FROM Campeonato c WHERE c.nomeCampeonato = '$nome'
								AND c.anoCampeonato = '$ano'";
					$campeonatos = consultaDqlMaxResult(1, $dql);
					$contador = 0;
					foreach($campeonatos as $campeonato) {
						if($campeonato instanceof Campeonato){
							$contador++;
						}
					}
					if($contador == 0){
						// Pega extens�o da imagem
						preg_match("/\.(gif|bmp|png|jpg|jpeg){1}$/i", $imagem["name"], $ext);
		
						$nomeUrlLogo = strtolower(trim(
										str_replace('�', 'a',
										str_replace('�', 'e',
										str_replace('�', 'i',
										str_replace('�', 'o',
										str_replace('�', 'u',
										str_replace('�', 'a',
										str_replace('�', 'e',
										str_replace('�', 'i',
										str_replace('�', 'o',
										str_replace('�', 'u',
										str_replace('�', 'e',
										str_replace('�', 'o',
										str_replace('�', 'a', 
										str_replace('�', 'i', 
										str_replace('�', 'u', 
										str_replace('�', 'e',
										str_replace('�', 'u',
										str_replace('�', 'o',
										str_replace('�', 'i',
										str_replace('�', 'a', 
										str_replace('�', 'o',
										str_replace('�', 'a',
										str_replace('�', 'a',
										str_replace('�', 'e',
										str_replace('�', 'i',
										str_replace('�', 'o',
										str_replace('�', 'u',
										str_replace('�', 'c',
										str_replace('�', 'c',
										str_replace('(', '-',
										str_replace(')', '-',
										str_replace('[', '-',
										str_replace(']', '-',
										str_replace('{', '-',
										str_replace('}', '-',
										str_replace('/', '-',
										str_replace('\\', '-',
										str_replace('|', '-',
										str_replace(' ', '-',
										$nome.'-'.$ano))))))))))))))))))))))))))))))))))))))))).'-'.$largura.'x'.$altura;
		
						// Gera um nome �nico para a imagem
						$nome_imagem = $nomeUrlLogo."." . $ext[1];
		
						// Caminho de onde ficar� a imagem
						$caminho_imagem = "imagens/logo-campeonatos/" . $nome_imagem;
		
						// Faz o upload da imagem para seu respectivo caminho
						move_uploaded_file($imagem["tmp_name"], $caminho_imagem);
		
						$campeonato = new Campeonato($nome, $ano, $quant, $caminho_imagem);
						salvaBancoDados($campeonato);
						
						for($i = 1; $i <= $quant; $i++){
							$rodada = new Rodada($i, $campeonato);
							salvaBancoDados($rodada);
							}
						
						echo "Campeonato criado com: ";
						echo "Codigo: ".$campeonato->getCodCampeonato()."\n";
						echo "Nome: ".$campeonato->getNomeCampeonato()."\n";
						echo "Ano: ".$campeonato->getAnoCampeonato()."\n";
						echo "Quantidade de rodadas: ".$campeonato->getQuantidadeRodadas()."\n";
					}
					else{
						echo "<font color='red'><b>Este campeonato j� existe.</b></font>";
					}
				}
				else{
					echo "<script> alert('Campo \"logo\" obrigatorio!')
					location = ('cadastra-time.php');
					</script>";
				}
			}
		}
		
		$conn->commit();
	} catch(Exception $e) {
		$conn->rollback();
		echo $e->getMessage() . "<br/><font color=red>N�o foi poss�vel gravar os dados. Verifique o Banco de Dados.</font><br/>";
	}
	$conn->close();
}

?>

<html>
<head>
<title>
cadastro de time
</title>
</head>
<body>

	<h1>Inserir Campeonato</h1>
	
	<form action="" method="POST" enctype="multipart/form-data">
			
			<p>
				<label for="nome">Nome do campeonato:</label>
				<input type="text" name="nome" id="nome" size="60" maxlength="30">
			</p>
            <p>
	            <label for="ano">Ano:</label>
	            <input type="text" name="ano" id="ano" size="60" maxlength="4"></p>
            <p>
	            <label for="rodadas">Quantidade de rodadas:</label>
	            <input type="text" name="quant" id="rodadas" size="60" maxlength="2"></p>
            <p>
	            <label for="logo">Logo do Campeonato:</label>
	            <input type="file" name="logo" id="logo"/>
	        </p>
            <p><input type="submit" name="salvar" value="Salvar" /></p>
    </form>
		
			<h2>Campeonatos Cadastrados</h2>
<table border="1">
	<tr vertical-align="middle" align="center">
		<td>C�digo</td>
		<td>Nome</td>
		<td>Logo</td>
		<td>Ano</td>
		<td>Rodadas</td>
		<td>Status</td>
		<td></td>
	</tr>

<?php
	$conn = $entityManager->getConnection();
	$conn->beginTransaction();
	try{
		$dqlCampeonatos = "SELECT c FROM Campeonato c ORDER BY c.codCampeonato ASC";
		$campeonatos = consultaDql($dqlCampeonatos);
		foreach($campeonatos as $campeonato) {
			if($campeonato instanceof Campeonato){
				echo '<tr vertical-align="middle" align="center">
						<td>'.$campeonato->getCodCampeonato().'</td>
						<td>'.$campeonato->getNomeCampeonato().'</td>
						<td><img src="'.$campeonato->getUrlLogo().'"></td>
						<td>'.$campeonato->getAnoCampeonato().'</td>
						<td>'.$campeonato->getQuantidadeRodadas().'</td>
						<td>'.$campeonato->getStatus().'</td>
						<td>
							<form method="POST" action="">
							<input type="hidden" name="campeonato" value='.$campeonato->getCodCampeonato().'>
							<input type="submit" name="excluir" value="Excluir"><br/>
							</form>
						</td>
					</tr>';
			}
		}
		$conn->commit();
	} catch(Exception $e) {
		$conn->rollback();
		echo $e->getMessage() . "<br/><font color=red>Dados n�o encontrados. Verifique o Banco de Dados.</font><br/>";
	}
	$conn->close();
?>
</table>
		<p align="center"><a href="cadastra-time.php">Cadastrar Time</a></p>
		<p align="center"><a href="cadastra-jogo.php">Cadastrar Jogo</a></p>
		<p align="center"><a href="admin.php">Menu Principal</a></p>
</body>
</html>
