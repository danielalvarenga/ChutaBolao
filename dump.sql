/** Código para criar o Banco de Dados "chutabol_facebook" no localhost */
CREATE DATABASE IF NOT EXISTS `chutabol_facebook`;
USE `chutabol_facebook`;

/** Código para criar o usuário "chutabol_admin" com senha "corporativa10" com todos os privilégios sobre o "chutabol_facebook" */
GRANT ALL PRIVILEGES ON *.* TO 'chutabol_admin'@'localhost' IDENTIFIED BY PASSWORD '*EEDE3CD56ADE00288A5D5939141F8369A419085F' WITH GRANT OPTION;
GRANT ALL PRIVILEGES ON `chutabol_facebook`.* TO 'chutabol_admin'@'localhost' WITH GRANT OPTION;



CREATE TABLE `Usuario` (
	`id` BIGINT,
	`tokenUsuario` VARCHAR(255),
	`primeiroNomeUsuario` VARCHAR(255),
	`segundoNomeUsuario` VARCHAR(255),
	`emailUsuario` VARCHAR(255),
	`pontosGeral` INT NULL,
	PRIMARY KEY (`id`)
)
COLLATE='latin1_swedish_ci'
ENGINE=InnoDB;



CREATE TABLE `Time` (
	`id` INT AUTO_INCREMENT,
	`nomeTime` VARCHAR(255),
	`escudo` TEXT,
	PRIMARY KEY (`id`)
)
COLLATE='latin1_swedish_ci'
ENGINE=InnoDB;



CREATE TABLE `Jogo` (
	`id` INT AUTO_INCREMENT,
	`campeonato_id` INT,
	`rodada_id` INT,
	`dataJogo` VARCHAR(50),
	`codTime1` INT,
	`codTime2` INT,
	`golsTime1` INT NULL DEFAULT NULL,
	`golsTime2` INT NULL DEFAULT NULL,
	`dataInicioApostas` DATETIME NULL DEFAULT NULL,
	`dataFimApostas` DATETIME NULL DEFAULT NULL,
	PRIMARY KEY (`id`)
)
COLLATE='latin1_swedish_ci'
ENGINE=InnoDB;


CREATE TABLE `Rodada` (
	`id` INT,
	`campeonato_id` INT,
	PRIMARY KEY (`id`, `campeonato_id`)
)
COLLATE='latin1_swedish_ci'
ENGINE=InnoDB;


CREATE TABLE `Aposta` (
	`usuario_id` BIGINT,
	`campeonato_id` INT(255),
	`jogo_id` INT,
	`apostaGolsTime1` INT,
	`apostaGolsTime2` INT,
	`pontosAposta` INT,
	PRIMARY KEY (`usuario_id`, `campeonato_id`, `jogo_id`)
)
COLLATE='latin1_swedish_ci'
ENGINE=InnoDB;


CREATE TABLE `Campeonato` (
	`id` INT AUTO_INCREMENT,
	`nomeCampeonato` VARCHAR(255),
	`anoCampeonato` INT,
	`quantidadeRodadas` INT,
	`status` SET('ativo', 'finalizado'),
	PRIMARY KEY (`id`)
)
COLLATE='latin1_swedish_ci'
ENGINE=InnoDB;



CREATE TABLE `PremiosUsuario` (
	`usuario_id` BIGINT,
	`campeonato_id` INT,
	`codTimeFavorito` INT,
	`acertosPlacar` INT,
	`acertosTimeGanhador` INT,
	`acertosPlacarInvertido` INT,
	`pontosCampeonato` INT,
	`medalhasOuro` INT,
	`medalhasPrata` INT,
	`medalhasBronze` INT,
	`chuteirasOuro` INT,
	`chuteirasPrata` INT,
	`chuteirasBronze` INT,
	`trofeu` TINYINT,
	PRIMARY KEY (`usuario_id`, `campeonato_id`)
)
COLLATE='latin1_swedish_ci'
ENGINE=InnoDB;


CREATE TABLE `RendimentoTime` (
	`campeonato_id` INT,
	`time_id` INT,
	`vitorias` INT,
	`derrotas` INT,
	`empates` INT,
	`golsPro` INT,
	`golsContra` INT,
	`pontos` INT,
	`saldoGols` INT,
	`classificacao` INT,
	PRIMARY KEY (`campeonato_id`, `time_id`)
)
COLLATE='latin1_swedish_ci'
ENGINE=InnoDB;


ALTER TABLE `PremiosUsuario`
	ADD INDEX `usuario_id` (`usuario_id`),
	ADD INDEX `campeonato_id` (`campeonato_id`),
	ADD CONSTRAINT `FK_premiosusuario_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `Usuario` (`id`),
	ADD CONSTRAINT `FK_premiosusuario_campeonato` FOREIGN KEY (`campeonato_id`) REFERENCES `Campeonato` (`id`);
	
ALTER TABLE `RendimentoTime`
	ADD INDEX `time_id` (`time_id`),
	ADD INDEX `campeonato_id` (`campeonato_id`),
	ADD CONSTRAINT `FK_rendimentotime_time` FOREIGN KEY (`time_id`) REFERENCES `Time` (`id`),
	ADD CONSTRAINT `FK_rendimentotime_campeonato` FOREIGN KEY (`campeonato_id`) REFERENCES `Campeonato` (`id`);

ALTER TABLE `Rodada`
	ADD INDEX `campeonato_id` (`campeonato_id`),
	ADD CONSTRAINT `FK_rodada_campeonato` FOREIGN KEY (`campeonato_id`) REFERENCES `Campeonato` (`id`);

ALTER TABLE `Jogo`
	ADD INDEX `campeonato_id` (`campeonato_id`),
	ADD INDEX `rodada_id` (`rodada_id`),
	ADD CONSTRAINT `FK_jogo_campeonato` FOREIGN KEY (`campeonato_id`) REFERENCES `Campeonato` (`id`),
	ADD CONSTRAINT `FK_jogo_rodada` FOREIGN KEY (`rodada_id`) REFERENCES `Rodada` (`id`);
	
ALTER TABLE `Aposta`
	ADD INDEX `usuario_id` (`usuario_id`),
	ADD INDEX `campeonato_id` (`campeonato_id`),
	ADD INDEX `jogo_id` (`jogo_id`),
	ADD CONSTRAINT `FK_aposta_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `Usuario` (`id`),
	ADD CONSTRAINT `FK_aposta_campeonato` FOREIGN KEY (`campeonato_id`) REFERENCES `Campeonato` (`id`),
	ADD CONSTRAINT `FK_aposta_jogo` FOREIGN KEY (`jogo_id`) REFERENCES `Jogo` (`id`);
	