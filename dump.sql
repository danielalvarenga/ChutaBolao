CREATE TABLE Usuario (
		idUsuario VARCHAR(255) NOT NULL UNIQUE,
		tokenUsuario VARCHAR(255) NOT NULL,
		primeiroNomeUsuario VARCHAR(255) NOT NULL,
		segundoNomeUsuario VARCHAR(255) NOT NULL,
		emailUsuario VARCHAR(255) NOT NULL,
		pontosGeral INT,
		PRIMARY KEY(idUsuario))
		ENGINE = InnoDB;
		
CREATE TABLE PremiosUsuario (
		codPremiosUsuario INT AUTO_INCREMENT NOT NULL,
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
		usuario_id VARCHAR(255) NOT NULL PRIMARY KEY,
		campeonato_cod INT NOT NULL PRIMARY KEY,
		PRIMARY KEY(codPremiosUsuario))
		ENGINE = InnoDB;
	ALTER TABLE PremiosUsuario FOREIGN KEY (usuario_id) REFERENCES Usuario (idUsuario)
	ALTER TABLE PremiosUsuario FOREIGN KEY (campeonato_cod) REFERENCES Campeonato (codCampeonato)
		
CREATE TABLE Time (
		codTime INT AUTO_INCREMENT NOT NULL,
		nomeTime VARCHAR(255) NOT NULL,
		PRIMARY KEY(codTime))
		ENGINE = InnoDB;
		
CREATE TABLE Pessoa (
id INT AUTO_INCREMENT NOT NULL,
cidade_id INT DEFAULT NULL,
nome VARCHAR(255) NOT NULL,
dataHoraCadastro DATETIME NOT NULL,
INDEX IDX_1CDFAB829586CC8 (cidade_id),
PRIMARY KEY(id)) ENGINE = InnoDB;
ALTER TABLE pessoa ADD CONSTRAINT FK_1CDFAB829586CC8 FOREIGN KEY (cidade_id) REFERENCES cidade (id)

