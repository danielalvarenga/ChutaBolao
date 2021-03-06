<?php
/** @Entity @Table(name="premiosusuario")*/
class PremiosUsuario{
	
	/** @Column(type="integer", nullable=true) */
	private $codTimeFavorito; // Time para o qual o usu�rio torce no campeonato
	
	/** @Column(type="integer") */
	private $acertosPlacar; // Quantidade de vezes que acertou o placar exato
	
	/** @Column(type="integer") */
	private $acertosTimeGanhador; // Quantidade de vezes que acertou o ganhador, mesmo errando o placar
	
	/** @Column(type="integer") */
	private $acertosPlacarInvertido; // Quantidade de vezes que acertou o placar invertido
	
	/** @Column(type="integer") */
	private $errosPlacar; // Quantidade de vezes que errou o placar completamente
	
	/** @Column(type="integer") */
	private $pontosCampeonato; // Quantidade de pontos acumulados no campeonato
	
	/** @Column(type="integer") */
	private $pontosMedalhas; // Quantidade de pontos acumulados no campeonato de acordo com as medalhas conquistadas
	
	/** @Column(type="integer") */
	private $classificacaoCampeonato;//classificacao no ranking do campeonato
	
	/** @Column(type="integer") */
	private $classificacaoMedalhas;//classificacao no ranking de medalhas no campeonato
	
	/** @Column(type="integer") */
	private $medalhasOuro; // Quantidade de medalhas de ouro acumuladas no campeonato
	
	/** @Column(type="integer") */
	private $medalhasPrata; // Quantidade de medalhas de prata acumuladas no campeonato
	
	/** @Column(type="integer") */
	private $medalhasBronze; // Quantidade de medalhas de bronze acumuladas no campeonato
	
	/** @Column(type="integer") */
	private $chuteirasOuro; // Quantidade de chuteiras de ouro acumuladas no campeonato
	
	/** @Column(type="integer") */
	private $chuteirasPrata; // Quantidade de chuteiras de prata acumuladas no campeonato
	
	/** @Column(type="integer") */
	private $chuteirasBronze; // Quantidade de chuteiras de bronze acumuladas no campeonato
	
	/** @Column(type="integer") */
	private $trofeu; // "true" se o usu�rio ganhou trof�u do campeonato. "false" por default.
	
	/** @Id @ManyToOne(targetEntity="Usuario", inversedBy="premiacoesUsuario")
	* @var Usuario
	*/
	protected $usuario; // Objeto da Classe Usuario a quem pertence os pr�mios
	
	/** @Id @ManyToOne(targetEntity="Campeonato", inversedBy="premiacoesCampeonato")
	 * @var Campeonato
	 */
	protected $campeonato; // Objeto da Classe Campeonato que refer�ncia em qual Campeonato foram ganhos os pr�mios
	
	function __construct($usuario, $campeonato, $codTimeFavorito = NULL){
		$this->codTimeFavorito = $codTimeFavorito;
		$this->acertosPlacar = 0;
		$this->acertosTimeGanhador = 0;
		$this->acertosPlacarInvertido = 0;
		$this->errosPlacar = 0;
		$this->pontosCampeonato = 0;
		$this->pontosMedalhas = 0;
		$this->classificacaoCampeonato = 0;
		$this->classificacaoMedalhas = 0;
		$this->medalhasOuro = 0;
		$this->medalhasPrata = 0;
		$this->medalhasBronze = 0;
		$this->chuteirasOuro = 0;
		$this->chuteirasPrata = 0;
		$this->chuteirasBronze = 0;
		$this->trofeu = 0;
		$this->usuario = $usuario;
		$this->campeonato = $campeonato;
		
	}
	
	function getUsuario(){
		return $this->usuario;
	}
	function getCampeonato(){
		return $this->campeonato;
	}
	function setUsuario($usuario){
		$this->usuario = $usuario;
	}
	function setCampeonato($campeonato){
		$this->campeonato = $campeonato;
	}
	function getClassificacaoCampeonato(){
		return $this->classificacaoCampeonato;
	}
	function getClassificacaoMedalhas(){
		return $this->classificacaoMedalhas;
	}
	function getPontosMedalhas(){
		return $this->pontosMedalhas;
	}
	function getCodTimeFavorito(){
		return $this->codTimeFavorito;
	}
	function setCodTimeFavorito($codTimeFavorito){
		$this->codTimeFavorito = $codTimeFavorito;
	}
	function getAcertosPlacar(){
		return $this->acertosPlacar;
	}
	function getAcertosTimeGanhador(){
		return $this->acertosTimeGanhador;
	}
	function getAcertosPlacarInvertido(){
		return $this->acertosPlacarInvertido;
	}
	function getErrosPlacar(){
		return $this->errosPlacar;
	}
	function getPontosCampeonato(){
		return $this->pontosCampeonato;;
	}
	function getMedalhasOuro(){
		return $this->medalhasOuro;
	}
	function getMedalhasPrata(){
		return $this->medalhasPrata;
	}
	function getMedalhasBronze(){
		return $this->medalhasBronze;
	}
	function getChuteirasOuro(){
		return $this->chuteirasOuro;
	}
	function getChuteirasPrata(){
		return $this->chuteirasPrata;
	}
	function getChuteirasBronze(){
		return $this->chuteirasBronze;
	}
	function getTrofeu(){
		return $this->trofeu;
	}
	function setClassificacaoCampeonato($classificacaoCampeonato){
		$this->classificacaoCampeonato=$classificacaoCampeonato;
	}
	function setClassificacaoMedalhas($classificacaoMedalhas){
		$this->classificacaoMedalhas=$classificacaoMedalhas;
	}
	/* Incrementa em +1 o atributo acertosPlacar */
	function acertaPlacar(){
		$this->acertosPlacar++;
	}
	/* Incrementa em +1 o atributo acertosTimeGanhador */
	function acertaTimeGanhador(){
		$this->acertosTimeGanhador++;
	}
	/* Incrementa em +1 o atributo acertosPlacarInvertido */
	function acertaPlacarInvertido(){
		$this->acertosPlacarInvertido++;
	}
	/* Recebe a quantidade de pontos ganhos por par�metro e soma com pontosCampeonato */
	function ganhaPontosCampeonato($pontos){
		$this->pontosCampeonato += $pontos;
	}
	/* Incrementa em +1 o atributo medalhasOuro */
	function ganhaMedalhaOuro(){
		$this->medalhasOuro++;
		$this->calculaPontosMedalhas();
	}
	/* Incrementa em +1 o atributo medalhasPrata */
	function ganhaMedalhaPrata(){
		$this->medalhasPrata++;
		$this->calculaPontosMedalhas();
	}
	/* Incrementa em +1 o atributo medalhasBronze */
	function ganhaMedalhaBronze(){
		$this->medalhasBronze++;
		$this->calculaPontosMedalhas();
	}
	/* Incrementa em +1 o atributo chuteirasOuro */
	function ganhaChuteiraOuro(){
		$this->chuteirasOuro++;
	}
	/* Incrementa em +1 o atributo chuteirasPrata */
	function ganhaChuteiraPrata(){
		$this->chuteirasPrata++;
	}
	/* Incrementa em +1 o atributo chuteirasBronze */
	function ganhaChuteiraBronze(){
		$this->chuteirasBronze++;
	}
	/* Atribue "true" ao atributo trofeu */
	function ganhaTrofeu(){
		if($this->trofeu == 0){
			$this->trofeu++;
		}
		else{
			$this->trofeu = 1;
		}
	}
	function calculaPontos($pontosAposta){
		switch($pontosAposta){
			case 10 : {
				$this->acertosPlacar++;
				break;
			}
			case 5 : {
				$this->acertosTimeGanhador++;
				break;
			}
			case 2 : {
				$this->acertosPlacarInvertido++;
				break;
			}
			case 0 : {
				$this->errosPlacar++;
				break;
			}
		}
		$this->ganhaPontosCampeonato($pontosAposta);
	}
	function calculaPontosMedalhas(){
		$this->pontosMedalhas=($this->medalhasOuro <<13) +($this->medalhasPrata<<7)+($this->medalhasBronze<<1) ;
	}
	
	/* Decrementa em +1 o atributo acertosPlacar */
	function subtraiAcertaPlacar(){
		$this->acertosPlacar--;
		$this->pontosCampeonato-=10;
	}
	/* Decrementa em +1 o atributo acertosTimeGanhador */
	function subtraiAcertaTimeGanhador(){
		$this->acertosTimeGanhador--;
		$this->pontosCampeonato-=5;
	}
	/* Decrementa em +1 o atributo acertosPlacarInvertido */
	function subtraiAcertaPlacarInvertido(){
		$this->acertosPlacarInvertido--;
		$this->pontosCampeonato-=2;
	}
	function subtraiErroPlacar(){
		$this->errosPlacar--;
	}
	
	function subtraiMedalhaOuro(){
		$this->medalhasOuro--;
	}
	function subtraiMedalhaPrata(){
		$this->medalhasPrata--;
	}
	function subtraiMedalhaBronze(){
		$this->medalhasBronze--;
	}
	function subtraiTrofeu(){
		$this->trofeu=0;
	}
	/* Decrementa em +1 o atributo chuteirasOuro */
	function subtraiChuteiraOuro(){
		$this->chuteirasOuro=0;
	}
	/* Decrementa em +1 o atributo chuteirasPrata */
	function subtraiChuteiraPrata(){
		$this->chuteirasPrata=0;
	}
	/* Decrementa em +1 o atributo chuteirasBronze */
	function subtraiChuteiraBronze(){
		$this->chuteirasBronze=0;
	}
	function subtraiCalculaPontos($pontosAposta){
		switch($pontosAposta){
			case 10 : {
				$this->subtraiAcertaPlacar();
				break;
			}
			case 5 : {
				$this->subtraiAcertaTimeGanhador();
				break;
			}
			case 2 : {
				$this->subtraiAcertaPlacarInvertido();
				break;
			}
			case 0 : {
				$this->subtraiErroPlacar();
				break;
			}
		}
	
	}
	
	
}
?>