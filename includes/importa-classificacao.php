<?php
$url = file_get_contents('http://www.cbf.com.br/competicoes/campeonato-brasileiro/serie-a/2012');
//print_r($url);
preg_match_all('/tabela-campeonato-brasileiro(.+)ltima/s', $url, $conteudo);
print_r($conteudo);
$exibir = $conteudo[0][0];
$retirar = array('tabela-campeonato-brasileiro">','ClassificaÃ§Ã£o',' da Gama','Verde');
$exibir = str_replace($retirar, '', $exibir);
$exibir = strip_tags($exibir);
$exibir = nl2br($exibir);
$exibir = str_replace("<br />", " ", $exibir);
$exibir = str_replace("\r", " ", $exibir);
$exibir = str_replace("\t", " ", $exibir);
$exibir = str_replace("\n", " ", $exibir);
$exibir = trim(str_replace("  ", " ", $exibir));
$exibir = str_replace("Ãª", "ê", $exibir);
$exibir = str_replace("Ã£", "ã", $exibir);
$exibir = str_replace("Ã¡", "á", $exibir);
$exibir = str_replace("Ã©", "é", $exibir);
$exibir = str_replace("São Paulo", "SãoPaulo", $exibir);
$exibir = str_replace("Ponte Preta", "PontePreta", $exibir);
$exibir = 'Classificação Time '.$exibir;
print_r($exibir);
/*$str = explode(' ', $exibir);
echo '<br/>';
for($i = 0; $i <= 230; $i++){
	echo '$str['.$i.'] = '.$str[$i].'<br/>';
}
print_r($str);
*/












