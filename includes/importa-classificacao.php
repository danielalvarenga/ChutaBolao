<?php
$url = file_get_contents('http://www.band.com.br/esporte/futebol/brasileirao-serie-a/2012/');
preg_match_all('/Posi(.+)Verde/s', $url, $conteudo);
//print_r($conteudo);
$exibir = $conteudo[0][0];
$retirar = array('Posição','Classificação',' da Gama','Verde');
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
$exibir = str_replace('ê', '�', $exibir);
$exibir = str_replace('ã', '�', $exibir);
$exibir = str_replace('á', '�', $exibir);
$exibir = str_replace('é', '�', $exibir);
$exibir = str_replace('S�o Paulo', 'S�oPaulo', $exibir);
$exibir = str_replace('Ponte Preta', 'PontePreta', $exibir);
$exibir = 'Classifica��o Time '.$exibir;
//print_r($exibir);
$str = explode(' ', $exibir);
/*echo '<br/>';
for($i = 0; $i <= 230; $i++){
	echo '$str['.$i.'] = '.$str[$i].'<br/>';
}
print_r($str);*/













