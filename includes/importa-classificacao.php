<?php
$url = file_get_contents('http://www.band.com.br/esporte/futebol/brasileirao-serie-a/2012/');
preg_match_all('/Posi(.+)Verde/s', $url, $conteudo);
//print_r($conteudo);
$exibir = $conteudo[0][0];
$retirar = array('PosiÃ§Ã£o','ClassificaÃ§Ã£o',' da Gama','Verde');
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
$exibir = str_replace('Ãª', 'ê', $exibir);
$exibir = str_replace('Ã£', 'ã', $exibir);
$exibir = str_replace('Ã¡', 'á', $exibir);
$exibir = str_replace('Ã©', 'é', $exibir);
$exibir = str_replace('São Paulo', 'SãoPaulo', $exibir);
$exibir = str_replace('Ponte Preta', 'PontePreta', $exibir);
$exibir = 'Classificação Time '.$exibir;
//print_r($exibir);
$str = explode(' ', $exibir);
/*echo '<br/>';
for($i = 0; $i <= 230; $i++){
	echo '$str['.$i.'] = '.$str[$i].'<br/>';
}
print_r($str);*/













