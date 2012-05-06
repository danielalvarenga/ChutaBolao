INSERT INTO Usuario (`id`, `primeiroNomeUsuario`, `segundoNomeUsuario`, `emailUsuario`, `pontosGeral`, `tokenUsuario`) VALUES
	(100000885523518, 'Daniel', 'Alvarenga Lima', 'alvarenga_daniel@hotmail.com', 0, 'AAADUkCMlzxoBAAde2WKyZAMFkBgDMxuGcNoXsZB37g3eiPRVGe2nQXTIbN0StDRO2Bh4xf2mCHZBfOSQOp9qbAbpFMhqp2amsijqxK5GhLnMfRr8Ycl');


INSERT INTO Time (`id`, `nomeTime`) VALUES
					(1, 'Flamengo'),
					(2, 'Vasco'),
					(3, 'Botafogo'),
					(4, 'Fluminense'),
					(5, 'Corinthians'),
					(6, 'Corinthians'),
					(7, 'Gremio');

INSERT INTO Campeonato (`id`, `nomeCampeonato`, `anoCampeonato`, `quantidadeRodadas`, `status`) VALUES
			(1, 'Brasileirão', '2012', 38, 'ativo'),
			(2, 'Brasileirão', '2011', 38, 'finalizado'),
			(3, 'Brasileirão', '2010', 38, 'finalizado'),
			(4, 'Copa do Brasil', '2012', 23, 'Ativo');

INSERT INTO PremiosUsuario (`codTimeFavorito`, `acertosPlacar`, `acertosTimeGanhador`, `acertosPlacarInvertido`, `pontosCampeonato`, `medalhasOuro`, `medalhasPrata`, `medalhasBronze`, `chuteirasOuro`, `chuteirasPrata`, `chuteirasBronze`, `trofeu`, `usuario_id`, `campeonato_id`) VALUES
			(1,0,0,0,0,0,0,0,0,0,0,false,100000885523518, 1),
			(2, 20, 30, 40, 500, 25, 50, 75, 40, 60, 80, true, 100000885523518, 2),
			(3, 10, 15, 20, 300, 5, 6, 7, 2, 3, 4, false, 100000885523518, 3),
			(NULL, 2, 4, 6, 150, 7, 8, 9, 1, 2, 3, false, 100000885523518, 4);
	
INSERT INTO Jogo (`id`, `dataJogo`, `rodada`, `codTime1`, `codTime2`, `golsTime1`, `golsTime2`, `campeonato_id`, `dataInicioApostas`, `dataFimApostas`, `apostasJogo`) VALUES
					(1, '2012-04-30', 1, 1, 2, NULL, NULL, 1, '2012-04-30 00:00:00', '2012-04-30 00:00:00', NULL),
					(2, '2012-04-30', 1, 3, 4, NULL, NULL, 1, '2012-04-30 00:00:00', '2012-04-30 00:00:00', NULL),
					(3, '2012-05-30', 2, 3, 1, NULL, NULL, 1, '2012-04-30 23:01:25', '2012-04-30 23:01:28', NULL),
					(4, '2012-05-29', 2, 4, 2, NULL, NULL, 1, '2012-04-30 23:01:23', '2012-04-30 23:01:27', NULL),
					(5, '0000-00-00', 2, 1, 2, NULL, NULL, NULL, NULL, NULL, NULL),
					(6, '2013-01-02', 3, 2, 3, NULL, NULL, NULL, NULL, NULL, NULL),
					(7, '2012-12-02', 5, 1, 2, NULL, NULL, NULL, NULL, NULL, NULL),
					(8, '2012-06-25', 7, 1, 3, NULL, NULL, NULL, NULL, NULL, NULL),
					(9, '2013-04-07', 1, 1, 2, NULL, NULL, NULL, NULL, NULL, NULL),
					(10, '2013-04-07', 2, 1, 2, NULL, NULL, NULL, NULL, NULL, NULL),
					(11, '2013-04-07', 3, 1, 3, NULL, NULL, NULL, NULL, NULL, NULL),
					(12, '2012-01-01', 27, 1, 3, NULL, NULL, NULL, NULL, NULL, NULL);


