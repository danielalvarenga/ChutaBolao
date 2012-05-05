/** Código para criar o Banco de Dados "chutabol_facebook" no localhost */
CREATE DATABASE IF NOT EXISTS `chutabol_facebook`;
USE `chutabol_facebook`;

/** Código para criar o usuário "chutabol_admin" com senha "corporativa10" com todos os privilégios sobre o "chutabol_facebook" */
GRANT ALL PRIVILEGES ON *.* TO 'chutabol_admin'@'localhost' IDENTIFIED BY PASSWORD '*EEDE3CD56ADE00288A5D5939141F8369A419085F' WITH GRANT OPTION;
GRANT ALL PRIVILEGES ON `chutabol_facebook`.* TO 'chutabol_admin'@'localhost' WITH GRANT OPTION;


/** Código para criar a tabela Usuario */
CREATE TABLE Usuario (
	idUsuario BIGINT,
	primeiroNomeUsuario VARCHAR(255),
	segundoNomeUsuario VARCHAR(255),
	emailUsuario VARCHAR(255),
	pontosGeral INT,
	tokenUsuario VARCHAR(255),
	PRIMARY KEY(idUsuario));
	

/** Código para criar a tabela Campeonato */
CREATE TABLE Campeonato (
	codCampeonato INT,
	nomeCampeonato VARCHAR(255),
	anoCampeonato YEAR,
	quantidadeRodadas INT,
	status SET('ativo','finalizado'),
	PRIMARY KEY(codCampeonato));
	

/** Código para criar a tabela Time */
CREATE TABLE Time (
	codTime INT AUTO_INCREMENT,
	nomeTime VARCHAR(255),
	PRIMARY KEY(codTime));
	

/** Código para criar a tabela PremiosUsuario */
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
	

/** Código para criar a tabela Jogo */
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
	

/** Código para criar a tabela Aposta */
CREATE TABLE Aposta (
	apostaGolsTime1 INT,
	apostaGolsTime2 INT,
	pontosAposta INT,
	usuario_id BIGINT,
	campeonato_id INT,
	jogo_id INT,
	PRIMARY KEY (usuario_id, jogo_id, campeonato_id));

	
/** Código que identifica quais são as chaves estrangeiras da tabela PremiosUsuario e de quais tabelas elas vieram */
ALTER TABLE PremiosUsuario ADD FOREIGN KEY (usuario_id) REFERENCES Usuario (idUsuario);
ALTER TABLE PremiosUsuario ADD FOREIGN KEY (campeonato_id) REFERENCES Campeonato (codCampeonato);

/** Código que identifica quais são as chaves estrangeiras da tabela Jogo e de quais tabelas elas vieram */
ALTER TABLE Jogo ADD FOREIGN KEY (campeonato_id) REFERENCES Campeonato (codCampeonato);
ALTER TABLE Jogo ADD FOREIGN KEY (codTime1) REFERENCES Time (codTime);
ALTER TABLE Jogo ADD FOREIGN KEY (codTime2) REFERENCES Time (codTime);

/** Código que identifica quais são as chaves estrangeiras da tabela Aposta e de quais tabelas elas vieram */
ALTER TABLE Aposta ADD FOREIGN KEY (usuario_id) REFERENCES Usuario (idUsuario);
ALTER TABLE Aposta ADD FOREIGN KEY (campeonato_id) REFERENCES Campeonato (codCampeonato);
ALTER TABLE Aposta ADD FOREIGN KEY (jogo_id) REFERENCES Jogo (codJogo);

