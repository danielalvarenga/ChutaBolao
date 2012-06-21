<?php
$url = file_get_contents('http://www.band.com.br/esporte/futebol/brasileirao-serie-a/2012/');
preg_match_all('/Posi(.+)Verde/s', $url, $conteudo);
//print_r($conteudo);
$exibir = $conteudo[0][0];
$retirar = array('Posição','Classificação','Verde');
$exibir = str_replace($retirar, '', $exibir);
$exibir = strip_tags($exibir);
$exibir = nl2br($exibir);
$exibir = str_replace('<br />
					', ' ', $exibir);
$exibir = str_replace(' 			<br />
                					 ', ' ', $exibir);
$exibir = str_replace('<br />
				<br />
			 		<br />
                					 ', ' ', $exibir);
$exibir = str_replace(' 			<br />
			<br />
		<br />
		<br />
			<br />
				', ' ', $exibir);
$exibir = str_replace('   ', ' ', $exibir);
$exibir = trim(str_replace('  ', ' ', $exibir));
print_r($exibir);


$str = explode(' ', $exibir);
print_r($str);