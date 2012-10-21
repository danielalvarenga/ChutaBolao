<?php
include "valida_cookies.inc";
require "bootstrap.php";
require 'metodos-bd.php';
require_once "lib/WideImage.php";






if(isset($_POST['mudaimg'])){
	$conn = $entityManager->getConnection();
	$conn->beginTransaction();
	try{
		$codPais = $_POST["cod-pais"];
		$imagem = $_FILES["img-bandeira"];

		$pais = buscaObjeto("Pais", $codPais);
		$nome = $pais->getNomePais();
		$largura = "48";
		$altura = "48";
			
		$caminho_imagem = 'imagens/bandeiras/bandeira'.'-'.
				strtolower(trim(
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
				$nome)
				)))))))))))))))))))))))))))))))))))))))).$largura.'x'.$altura.'.png';
			
		move_uploaded_file($imagem["tmp_name"], $caminho_imagem);
			
	/*	$imagemObj = WideImage::load($caminho_imagem);
		$imagemExata = $imagemObj->resize($largura, $altura,'inside','any');
		$imagemExata->saveToFile($caminho_imagem, null, 100);
		$imagemObj->destroy();
	*/		
		$pais->setBandeira($caminho_imagem);
		atualizaBancoDados($pais);

		$conn->commit();
	} catch(Exception $e) {
		$conn->rollback();
		unlink($caminho_imagem);
		echo $e->getMessage() . "<br/><font color=red>N�o foi poss�vel gravar os dados. Verifique o Banco de Dados.</font><br/>";
	}
	$conn->close();
}






if(isset($_POST['excluir-pais'])){
	$conn = $entityManager->getConnection();
	$conn->beginTransaction();
	try{
		
		$pais = buscaObjeto("Pais", $_POST['excluir-pais']);
		$imagem = $pais->getBandeira();
		$nome = $pais->getNomePais();
		removeBancoDados($pais);
		unlink("$imagem");
		echo "<script> alert('Exclu�do pa�s com o nome $nome')
		location = ('cadastra-pais.php');
		</script>";
		
		$conn->commit();
	} catch(Exception $e) {
		$conn->rollback();
		echo $e->getMessage() . "<br/><font color=red>N�o foi poss�vel excluir. Verifique o Banco de Dados.</font><br/>";
	}
	$conn->close();
}

if(isset($_POST['nome'])){
	$conn = $entityManager->getConnection();
	$conn->beginTransaction();
	try{
		
		if(empty($_POST['nome'])){
			echo "<script> alert('Campo \"nome\" obrigatorio!')
			location = ('cadastra-pais.php');
			</script>";
		}
		elseif(empty($_POST['sigla2letras'])){
			echo "<script> alert('Campo \"Sigla Alfa-2\" obrigatorio!')
			location = ('cadastra-pais.php');
			</script>";
		}
		elseif(empty($_POST['sigla3letras'])){
			echo "<script> alert('Campo \"Sigla Alfa-3\" obrigatorio!')
			location = ('cadastra-pais.php');
			</script>";
		}
		else{
			
			$nome = $_POST['nome'];
			$sigla2letras = $_POST["sigla2letras"];
			$sigla3letras = $_POST["sigla3letras"];
			$imagem = $_FILES["bandeira"];
			
			// Se a foto estiver sido selecionada
			if (!empty($imagem["name"])) {
				$dql = "SELECT p FROM Pais p WHERE p.nomePais = '$nome'";
				$paises = consultaDqlMaxResult(1, $dql);
				$contador = 0;
				foreach($paises as $pais) {
					if($pais instanceof $pais){
						$contador++;
					}
				}
				if($contador == 0){
					$largura = "47";
					$altura = "47";
					
					$caminho_imagem = 'imagens/bandeiras/bandeira'.'-'.
									strtolower(trim(
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
									str_replace(' ', '-', $nome)
											))))))))))))))))))))))))))))).$largura.'x'.$altura.'.png';
					
					move_uploaded_file($imagem["tmp_name"], $caminho_imagem);
					
					$imagemObj = WideImage::load($caminho_imagem);
					$imagemExata = $imagemObj->resize('47', '47','inside','any');
					$imagemExata->saveToFile($caminho_imagem, null, 80);
					$imagemObj->destroy();
					
					$pais = new Pais($nome, $sigla2letras, $sigla3letras, $caminho_imagem);
					salvaBancoDados($pais);
					}
				else{
					echo "<font color='red'><b>Este Pa�s j� existe.</b></font>";
				}
				
			}
		}
		
		$conn->commit();
	} catch(Exception $e) {
		$conn->rollback();
		unlink($caminho_imagem);
		echo $e->getMessage() . "<br/><font color=red>N�o foi poss�vel gravar os dados. Verifique o Banco de Dados.</font><br/>";
	}
	$conn->close();
}
?>

<html>
<head>
<title>
cadastro de pa�s / sele��o
</title>
</head>
<body>

	<h1>Cadastrar Pa�s</h1>
	
	<form action="" method="POST" enctype="multipart/form-data">
			
			<p>Preencher de acordo com a norma ISO 3166-1. <a href="http://pt.wikipedia.org/wiki/ISO_3166-1" target="_blank">Clique aqui para ver</a>.
			<p>Pa�s: <input type="text" name="nome" size="60"></p>
			<p>Sigla Alfa-2 (2 letras): <input type="text" name="sigla2letras" size="2"></p>
			<p>Sigla Alfa-3 (3 letras): <input type="text" name="sigla3letras" size="3"></p>
           	<p>Bandeira: <input type="file" name="bandeira"/></p>
            <p><input type="submit" name="salvar" value="Salvar" /></p>
    </form>
		
		<h2>Pa�ses Cadastrados</h2>
<table border="1">
	<tr vertical-align="middle" align="center">
		<td>C�digo</td>
		<td>Pa�s</td>
		<td>Sigla Alfa-2</td>
		<td>Sigla Alfa-3</td>
		<td>Bandeira</td>
		<td></td>
	</tr>

<?php
	$dql = "SELECT p FROM Pais p ORDER BY p.nomePais ASC";
	$paises = consultaDql($dql);
	foreach($paises as $pais) {
		if($pais instanceof Pais){
			echo '<tr vertical-align="middle" align="center">
					<td>'.$pais->getCodPais().'</td>
					<td>'.$pais->getNomePais().'</td>
					<td>'.$pais->getSigla2Letras().'</td>
					<td>'.$pais->getSigla3Letras().'</td>
					<td><img src="'.$pais->getBandeira().'"></td>
					<td>
						<form method="POST" action="">
							<input type="hidden" name="excluir-pais" value='.$pais->getCodPais().'>
							<input type="submit" name="excluir" value="Excluir"><br/>
						</form>
						<form action="" method="POST" enctype="multipart/form-data">
							<input type="hidden" name="cod-pais" value='.$pais->getCodPais().'>
				           	<p>Bandeira: <input type="file" name="img-bandeira"/></p>
				            <p><input type="submit" name="mudaimg" value="Salvar" /></p>
					    </form>
					</td>
				</tr>';
		}
	}
?>
</table>
		<p align="center"><a href="cadastra-campeonato.php">Cadastrar Campeonato</a></p>
		<p align="center"><a href="cadastra-jogo.php">Cadastrar Jogo</a></p>
		<p align="center"><a href="admin.php">Menu Principal</a></p>
</body>
</html>
