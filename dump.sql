
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

CREATE TABLE `jogo` (
	`codJogo` INT(10) NOT NULL AUTO_INCREMENT,
	`dataInicioApostas` VARCHAR(50) NOT NULL,
	`dataJogo` VARCHAR(50) NOT NULL,
	`campeonato_cod` INT(11) NOT NULL,
	`dataFimApostas` VARCHAR(50) NOT NULL,
	`codTime1` INT(11) NOT NULL,
	`codTime2` INT(11) NOT NULL,
	`rodada` INT(11) NOT NULL,
	`golsTime1` INT(11) NULL DEFAULT NULL,
	`golsTime2` INT(11) NULL DEFAULT NULL,
PRIMARY KEY (`codJogo`),
INDEX `campeonato_cod` (`campeonato_cod`),
CONSTRAINT `FK_jogo_campeonato` FOREIGN KEY (`campeonato_cod`) REFERENCES `campeonato` (`codCampeonato`)
)
COLLATE='latin1_swedish_ci'
ENGINE=InnoDB;

CREATE TABLE `aposta` (
`usuario` VARCHAR(255) NOT NULL,
`campeonato` INT(11) NOT NULL,
`jogo` INT(11) NOT NULL,
`apostaGolsTime1` INT(11) NOT NULL,
`apostaGolsTime2` INT(11) NOT NULL,
`pontosAposta` INT(11) NOT NULL,
PRIMARY KEY (`usuario`, `jogo`, `campeonato`),
	INDEX `usuario` (`usuario`),
	INDEX `campeonato` (`campeonato`),
	INDEX `jogo` (`jogo`),
CONSTRAINT `FK_aposta_jogo` FOREIGN KEY (`jogo`) REFERENCES `jogo` (`codJogo`),
	CONSTRAINT `FK_aposta_campeonato` FOREIGN KEY (`campeonato`) REFERENCES `campeonato` (`codCampeonato`),
	CONSTRAINT `FK_aposta_usuario` FOREIGN KEY (`usuario`) REFERENCES `usuario` (`idUsuario`)
)
COLLATE='latin1_swedish_ci'
ENGINE=InnoDB;

CREATE TABLE `premiosusuario` (
	`idUsuario` VARCHAR(255) NOT NULL,
`codCampeonato` INT(11) NOT NULL,
`codTimeFavorito` INT(11) NOT NULL,
`acertosPlacar` INT(11) NOT NULL,
`acertosTimeGanhador` INT(11) NOT NULL,
`acertosPlacarInvertido` INT(11) NOT NULL,
`pontosCampeonato` INT(11) NOT NULL,
`medalhasOuro` INT(11) NOT NULL,
`medalhasPrata` INT(11) NOT NULL,
`medalhasBronze` INT(11) NOT NULL,
`chuteirasOuro` INT(11) NOT NULL,
`chuteirasPrata` INT(11) NOT NULL,
`chuteirasBronze` INT(11) NOT NULL,
`trofeu` TINYINT(1) NOT NULL,
PRIMARY KEY (`idUsuario`, `codCampeonato`),
INDEX `codCampeonato` (`codCampeonato`),
	INDEX `idUsuario` (`idUsuario`),
	CONSTRAINT `FK_premiosusuario_campeonato` FOREIGN KEY (`codCampeonato`) REFERENCES `campeonato` (`codCampeonato`),
	CONSTRAINT `FK_premiosUsuario_usuario` FOREIGN KEY (`idUsuario`) REFERENCES `usuario` (`idUsuario`)
)
COLLATE='latin1_swedish_ci'
ENGINE=InnoDB;

CREATE TABLE `time` (
`codTime` INT(10) NOT NULL AUTO_INCREMENT,
`nomeTime` VARCHAR(255) NOT NULL,
PRIMARY KEY (`codTime`)
)
COLLATE='latin1_swedish_ci'
ENGINE=InnoDB;

CREATE TABLE `usuario` (
`idUsuario` VARCHAR(255) NOT NULL,
	`tokenUsuario` VARCHAR(255) NOT NULL,
	`primeiroNomeUsuario` VARCHAR(255) NOT NULL,
	`segundoNomeUsuario` VARCHAR(255) NOT NULL,
	`emailUsuario` VARCHAR(255) NOT NULL,
	`pontosGeral` INT(11) NULL DEFAULT NULL,
PRIMARY KEY (`idUsuario`)
)
COLLATE='latin1_swedish_ci'
ENGINE=InnoDB;

CREATE TABLE Pessoa (
id INT AUTO_INCREMENT NOT NULL,
cidade_id INT DEFAULT NULL,
nome VARCHAR(255) NOT NULL,
dataHoraCadastro DATETIME NOT NULL,
INDEX IDX_1CDFAB829586CC8 (cidade_id),
PRIMARY KEY(id)) ENGINE = InnoDB;
ALTER TABLE pessoa ADD CONSTRAINT FK_1CDFAB829586CC8 FOREIGN KEY (cidade_id) REFERENCES cidade (id)

