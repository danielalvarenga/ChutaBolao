CREATE DATABASE IF NOT EXISTS `chutabol_facebook`;
USE `chutabol_facebook`;

GRANT ALL PRIVILEGES ON *.* TO 'chutabol_admin'@'localhost' IDENTIFIED BY PASSWORD '*EEDE3CD56ADE00288A5D5939141F8369A419085F' WITH GRANT OPTION;
GRANT ALL PRIVILEGES ON `chutabol_facebook`.* TO 'chutabol_admin'@'localhost' WITH GRANT OPTION;


CREATE TABLE Usuario (
	idUsuario BIGINT,
	primeiroNomeUsuario VARCHAR(255),
	segundoNomeUsuario VARCHAR(255),
	emailUsuario VARCHAR(255),
	pontosGeral INT,
	tokenUsuario VARCHAR(255),
	PRIMARY KEY(idUsuario));
	
	
CREATE TABLE Campeonato (
	codCampeonato INT,
	nomeCampeonato VARCHAR(255),
	anoCampeonato YEAR,
	quantidadeRodadas INT,
	status SET('ativo','finalizado'),
	PRIMARY KEY(codCampeonato));
	
	
CREATE TABLE Time (
	codTime INT AUTO_INCREMENT,
	nomeTime VARCHAR(255),
	PRIMARY KEY(codTime));
	
	
CREATE TABLE PremiosUsuario (
	codTimeFavorito INT,
	acertosPlacar INT,
	acertosTimeGanhador INT,
	acertosPlacarInvertido INT,
	$pontosCampeonato INT,
	medalhasOuro INT,
	medalhasPrata INT,
	medalhasBronze INT,
	chuteirasOuro INT,
	chuteirasPrata INT,
	chuteirasBronze INT,
	trofeu BOOLEAN,
	usuario_id BIGINT,
	campeonato_id INT,
	PRIMARY KEY(usuario_id, campeonato_id));
	

CREATE TABLE Jogo (
	codJogo INT AUTO_INCREMENT,
	codTime1 INT,
	codTime2 INT,
	rodada INT,
	dataJogo DATE,
	dataInicioApostas DATE,
	dataFimApostas DATE,
	golsTime1 INT DEFAULT NULL,
	golsTime2 INT DEFAULT NULL,
	campeonato_id INT,
	PRIMARY KEY (codJogo));
	
	
CREATE TABLE Aposta (
	apostaGolsTime1 INT,
	apostaGolsTime2 INT,
	pontosAposta INT,
	usuario_id BIGINT,
	campeonato_id INT,
	jogo_id INT,
	PRIMARY KEY (usuario_id, jogo_id, campeonato_id));

	
	
ALTER TABLE PremiosUsuario ADD FOREIGN KEY (usuario_id) REFERENCES Usuario (idUsuario);
ALTER TABLE PremiosUsuario ADD FOREIGN KEY (campeonato_id) REFERENCES Campeonato (codCampeonato);

ALTER TABLE Jogo ADD FOREIGN KEY (campeonato_id) REFERENCES Campeonato (codCampeonato);
ALTER TABLE Jogo ADD FOREIGN KEY (codTime1) REFERENCES Time (codTime);
ALTER TABLE Jogo ADD FOREIGN KEY (codTime2) REFERENCES Time (codTime);

ALTER TABLE Aposta ADD FOREIGN KEY (usuario_id) REFERENCES Usuario (idUsuario);
ALTER TABLE Aposta ADD FOREIGN KEY (campeonato_id) REFERENCES Campeonato (codCampeonato);
ALTER TABLE Aposta ADD FOREIGN KEY (jogo_id) REFERENCES Jogo (codJogo);

