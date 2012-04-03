CREATE TABLE Usuario (
		idUsuario INT NOT NULL,
		tokenUsuario INT NOT NULL,
		primeiroNome VARCHAR(255) NOT NULL,
		segundoNome VARCHAR(255) NOT NULL,
		emailUsuario VARCHAR(255) NOT NULL,
		pontosGeralUsuario INT DEFAULT 0,
		PRIMARY KEY(idUsuario))
		ENGINE = InnoDB;
CREATE TABLE PremiosUsuario (
		codPremiosUsuario INT AUTO_INCREMENT NOT NULL,
		codCampeonato INT NOT NULL,
		codTimeFavorito INT DEFAULT NULL,
		codRodada INT DEFAULT NULL,
		acertosPlacar INT DEFAULT 0,
		acertosTimeGanhador INT DEFAULT 0,
		acertosPlacarInvertido INT DEFAULT 0,
		pontosCampeonato INT DEFAULT 0,
		pontosRodada INT DEFAULT 0,
		medalhasOuro INT DEFAULT 0,
		medalhasPrata INT DEFAULT 0,
		medalhasBronze INT DEFAULT 0,
		chuteirasOuro INT DEFAULT 0,
		chuteirasPrata INT DEFAULT 0,
		chuteirasBronze INT DEFAULT 0,
		trofeus INT DEFAULT 0,	
		usuario_id INT NOT NULL,
		INDEX IDX_1CDFAB829586CC8 (usuario_id),
		PRIMARY KEY(codPremiosUsuario))
		ENGINE = InnoDB;
ALTER TABLE PremiosUsuario ADD CONSTRAINT FK_1CDFAB829586CC8 FOREIGN KEY (usuario_id) REFERENCES usuario (idUsuario)