<?php
abstract class ApostaAbstrata{
	private $codJogo;//Codigo que identifica qual o jogo que o usuario esta apostando da rodada;
	private $idUsuario;//Identificador do usuario q vai fazer a aposta;
	private $codCampeonato;//Codigo que identifica qual o campeonato o usuario esta participando; 
	private $apostaTime1;//Palpite que o usuario apostou para o primeiro time do jogo;
	private $apostaTime2;//Palpite que o usuario apostou para o segundo time do jogo;
	private $pontosAposta;//Pontuacao referente a determinado jogo;

 function __construct($idUsuario,$codCampeonato,$codRodada,$codJogo);
 //Cria nova aposta do usuario no banco de dados o codigo da aposta e formado por varias chaves
 //de classes diferentes;
 function setApostaGolsTime1($apostaGolsTime1);
 //Recebe como parametro o palpite referente ao primeiro time de determinado jogo ;
 function setApostaGolsTime2($apostaGolsTime2);
 //Recebe como parametro o palpite referente ao segundo time de determinado jogo ;
 function getApostaTime1();
 //Retorna o palpite do usuario de determinada aposta feita para o primeiro time;
 function getApostaTime2();
 //Retorna o palpite do usuario de determinada aposta feita para o segundo time;
 function getIdUsuario();
 //Retorna o Id do usuario de determinada aposta;
 function getCodCampeonato();
 //Retorna o codigo do campeonato de determinada aposta se refere;
 function getCodJogo();
 //Retorna o codigo de determinada jogo cadastrado na aposta;
 function calculaPontosAposta($golsTime1,$golsTime2);
 //Calcula a pontuacao de determinado jogo q o usuario dono da aposta ganhou;
 function getPontosAposta();
 //Retorna a pontuacao de determinada aposta ;
}
?>