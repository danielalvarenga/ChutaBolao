<?php
include "valida_cookies.inc";
require "bootstrap.php";
require 'metodos-bd.php';
require_once "lib/WideImage.php";

if(isset($_POST['time'])){
	$conn = $entityManager->getConnection();
	$conn->beginTransaction();
	try{
		
		$time = $entityManager->find("Time", $_POST['time']);
		$escudo = $time->getEscudo();
		$nomeTime = $time->getNomeTime();
		$codTime = $time->getCodTime();
		removeBancoDados($time);
		unlink("$escudo");
		echo "<script> alert('Excluído time com o nome $nomeTime com código $codTime')
		location = ('cadastra-time.php');
		</script>";
		
		$conn->commit();
	} catch(Exception $e) {
		$conn->rollback();
		echo $e->getMessage() . "<br/><font color=red>Não foi possível gravar os dados. Verifique o Banco de Dados.</font><br/>";
	}
	$conn->close();
}

if(isset($_POST['nome'])){
	$conn = $entityManager->getConnection();
	$conn->beginTransaction();
	try{
		
		if(empty($_POST['nome'])){
			echo "<script> alert('Campo \"nome\" obrigatorio!')
			location = ('cadastra-time.php');
			</script>";
		}
		elseif(empty($_POST['pais'])){
			echo "<script> alert('Campo \"País\" obrigatorio!')
			location = ('cadastra-time.php');
			</script>";
		}
		else{
			if(empty($_POST['uf'])){
				$nome = $_POST['nome'];
			}
			else{
				$uf = $_POST['uf'];
				$nome = $_POST['nome'].'-'.strtoupper($uf);
			}
			
			$codPais = $_POST['pais'];
			$pais = buscaObjeto("Pais", $codPais);
			
			$imagem = $_FILES['escudo'];
			// Se a foto estiver sido selecionada
			if (!empty($imagem["name"])) {
	
				$dqlTime = "SELECT t FROM Time t WHERE t.nomeTime = '$nome'";
				$times = consultaDqlMaxResult(1, $dqlTime);
				$contador = 0;
				foreach($times as $time) {
					if($time instanceof Time){
						$contador++;
					}
				}
				if($contador == 0){
					$largura = 47;
					$altura = 47;
					
					$caminho_imagem = 'imagens/escudos/'.
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
								$nome))))))))))))))))))))))))))))))))))))))))).$largura.'x'.$altura.'.png';
			
					// Faz o upload da imagem para seu respectivo caminho
					move_uploaded_file($imagem["tmp_name"], $caminho_imagem);
					
					//Muda o tamanho da imagem e salva novamente
					$imagemObj = WideImage::load($caminho_imagem);
					$imagemExata = $imagemObj->resize('47', '47','inside','any');
					$imagemExata->saveToFile($caminho_imagem, null, 80);
					$imagemObj->destroy();
					
					$time = new Time($nome, $caminho_imagem, $pais);
					salvaBancoDados($time);
					}
				else{
					echo "<font color='red'><b>Este time já existe.</b></font>";
				}
				
			}
		}
		
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
cadastro de time
</title>
</head>
<body>

	<h1>Inserir time</h1>
	
	<form action="" method="POST" enctype="multipart/form-data">
			
			<p>Nome: <input type="text" name="nome" size="60"></p>
			<p>UF (somente se necessário): <input type="text" name="uf" size="3"></p>
			<?php
			$conn = $entityManager->getConnection();
			$conn->beginTransaction();
			try{
				$dql = "SELECT p FROM Pais p ORDER BY p.nomePais ASC";
				$paises = consultaDql($dql);
				$conn->commit();
			} catch(Exception $e) {
				$conn->rollback();
				echo $e->getMessage() . "<br/><font color=red>Não foi possível apagar os dados. Verifique o Banco de Dados.</font><br/>";
			}
			$conn->close();
			?>
			<p>País: 
				<select size="1" name="pais">
				<?php 
					foreach($paises as $pais) {
						echo "<option value=".$pais->getCodPais().">".$pais->getNomePais()."</option>";
					}
				?>
				</select>
			 </p>
           	<p>Escudo: <input type="file" name="escudo"/></p>
            <p><input type="submit" name="salvar" value="Salvar" /></p>
    </form>
		
		<h2>Times Cadastrados</h2>
<table border="1">
	<tr vertical-align="middle" align="center">
		<td>Código</td>
		<td>Time</td>
		<td>País</td>
		<td>Escudo</td>
		<td></td>
	</tr>

<?php
	$dqlTimes = "SELECT t FROM Time t ORDER BY t.nomeTime ASC";
	$times = consultaDql($dqlTimes);
	foreach($times as $time) {
		if($time instanceof Time){
			echo '<tr vertical-align="middle" align="center">
					<td>'.$time->getCodtime().'</td>
					<td>'.$time->getNometime().'</td>
					<td>'.$time->getPais()->getNomePais().'</td>
					<td><img src="'.$time->getEscudo().'"></td>
					<td>
						<form method="POST" action="">
						<input type="hidden" name="time" value='.$time->getCodTime().'>
						<input type="submit" name="excluir" value="Excluir"><br/>
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
