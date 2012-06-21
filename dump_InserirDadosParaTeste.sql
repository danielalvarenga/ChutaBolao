INSERT INTO `usuario` (`id`,
			`primeiroNomeUsuario`,
			`segundoNomeUsuario`,
			`emailUsuario`,
			`tokenUsuario`)
	VALUES	(
	100000885523518,
	'Daniel',
	'Alvarenga Lima',
	'alvarenga_daniel@hotmail.com',
	'AAADUkCMlzxoBAAde2WKyZAMFkBgDMxuGcNoXsZB37g3eiPRVGe2nQXTIbN0StDRO2Bh4xf2mCHZBfOSQOp9qbAbpFMhqp2amsijqxK5GhLnMfRr8Ycl'
	);
	
	
INSERT INTO `time` (`id`, `nomeTime`, `escudo`) VALUES
(1, 'Atlético-go', 'imagens/escudos/atletico-go47x47.png'),
(2, 'Atlético-mg', 'imagens/escudos/atletico-mg47x47.png'),
(3, 'Bahia', 'imagens/escudos/bahia47x47.png'),
(4, 'Botafogo', 'imagens/escudos/botafogo47x47.png'),
(5, 'Corinthians', 'imagens/escudos/corinthians47x47.png'),
(6, 'Coritiba', 'imagens/escudos/coritiba47x47.png'),
(7, 'Cruzeiro', 'imagens/escudos/cruzeiro47x47.png'),
(8, 'Figueirense', 'imagens/escudos/figueirense47x47.png'),
(9, 'Flamengo', 'imagens/escudos/flamengo47x47.png'),
(10, 'Fluminense', 'imagens/escudos/fluminense47x47.png'),
(11, 'Grêmio', 'imagens/escudos/gremio47x47.png'),
(12, 'Internacional', 'imagens/escudos/internacional47x47.png'),
(13, 'Náutico', 'imagens/escudos/nautico47x47.png'),
(14, 'Palmeiras', 'imagens/escudos/palmeiras47x47.png'),
(15, 'Ponte Preta', 'imagens/escudos/ponte-preta47x47.png'),
(16, 'Portuguesa-sp', 'imagens/escudos/portuguesa-sp47x47.png'),
(18, 'Santos', 'imagens/escudos/santos47x47.png'),
(19, 'São Paulo', 'imagens/escudos/sao-paulo47x47.png'),
(20, 'Sport', 'imagens/escudos/sport47x47.png'),
(21, 'Vasco', 'imagens/escudos/vasco47x47.png');



INSERT INTO `pontuacaogeral`(`usuario_id`,
			`acertosPlacarGeral`,
			`acertosTimeGanhadorGeral`,
			`acertosPlacarInvertidoGeral`,
			`errosPlacarGeral`,
			`pontosGeral`,
			`classificacaoGeral`,
			`pontosMedalhasGeral`,
			`classificacaoMedalhasGeral`,
			`medalhasOuroGeral`,
			`medalhasPrataGeral`,
			`medalhasBronzeGeral`,
			`trofeus`)
	VALUES (0,0,0,0,0,0,0,0,0,0,0,0,0);
