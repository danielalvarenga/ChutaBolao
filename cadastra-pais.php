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
				str_replace('Á', 'a',
				str_replace('É', 'e',
				str_replace('Í', 'i',
				str_replace('Ó', 'o',
				str_replace('Ú', 'u',
				str_replace('Â', 'a',
				str_replace('Ê', 'e',
				str_replace('Î', 'i',
				str_replace('Ô', 'o',
				str_replace('Û', 'u',
				str_replace('é', 'e',
				str_replace('ó', 'o',
				str_replace('á', 'a', 
				str_replace('í', 'i', 
				str_replace('ú', 'u', 
				str_replace('ê', 'e',
				str_replace('û', 'u',
				str_replace('ô', 'o',
				str_replace('î', 'i',
				str_replace('â', 'a', 
				str_replace('õ', 'o',
				str_replace('ã', 'a',
				str_replace('ä', 'a',
				str_replace('ë', 'e',
				str_replace('ï', 'i',
				str_replace('ö', 'o',
				str_replace('ü', 'u',
				str_replace('ç', 'c',
				str_replace('Ç', 'c',
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
		echo $e->getMessage() . "<br/><font color=red>Não foi possível gravar os dados. Verifique o Banco de Dados.</font><br/>";
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
		echo "<script> alert('Excluído país com o nome $nome')
		location = ('cadastra-pais.php');
		</script>";
		
		$conn->commit();
	} catch(Exception $e) {
		$conn->rollback();
		echo $e->getMessage() . "<br/><font color=red>Não foi possível excluir. Verifique o Banco de Dados.</font><br/>";
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
									str_replace('Á', 'a',
									str_replace('É', 'e',
									str_replace('Í', 'i',
									str_replace('Ó', 'o',
									str_replace('Ú', 'u',
									str_replace('Â', 'a',
									str_replace('Ê', 'e',
									str_replace('Î', 'i',
									str_replace('Ô', 'o',
									str_replace('Û', 'u',
									str_replace('é', 'e',
									str_replace('ó', 'o',
									str_replace('á', 'a', 
									str_replace('í', 'i', 
									str_replace('ú', 'u', 
									str_replace('ê', 'e',
									str_replace('û', 'u',
									str_replace('ô', 'o',
									str_replace('î', 'i',
									str_replace('â', 'a', 
									str_replace('õ', 'o',
									str_replace('ã', 'a',
									str_replace('ä', 'a',
									str_replace('ë', 'e',
									str_replace('ï', 'i',
									str_replace('ö', 'o',
									str_replace('ü', 'u',
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
					echo "<font color='red'><b>Este País já existe.</b></font>";
				}
				
			}
		}
		
		$conn->commit();
	} catch(Exception $e) {
		$conn->rollback();
		unlink($caminho_imagem);
		echo $e->getMessage() . "<br/><font color=red>Não foi possível gravar os dados. Verifique o Banco de Dados.</font><br/>";
	}
	$conn->close();
}
?>

<html>
<head>
<title>
cadastro de país / seleção
</title>
</head>
<body>

	<h1>Cadastrar País</h1>
	
	<form action="" method="POST" enctype="multipart/form-data">
			
			<p>Preencher de acordo com a norma ISO 3166-1. <a href="http://pt.wikipedia.org/wiki/ISO_3166-1" target="_blank">Clique aqui para ver</a>.
			<p>País: <input type="text" name="nome" size="60"></p>
			<p>Sigla Alfa-2 (2 letras): <input type="text" name="sigla2letras" size="2"></p>
			<p>Sigla Alfa-3 (3 letras): <input type="text" name="sigla3letras" size="3"></p>
           	<p>Bandeira: <input type="file" name="bandeira"/></p>
            <p><input type="submit" name="salvar" value="Salvar" /></p>
    </form>
		
		<h2>Países Cadastrados</h2>
<table border="1">
	<tr vertical-align="middle" align="center">
		<td>Código</td>
		<td>País</td>
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
