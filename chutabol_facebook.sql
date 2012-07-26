--
-- Banco de Dados: `chutabol_facebook`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `admin`
--

CREATE TABLE IF NOT EXISTS `admin` (
  `nome` varchar(255) NOT NULL,
  `login` varchar(20) NOT NULL,
  `senha` varchar(20) NOT NULL,
  PRIMARY KEY (`login`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `admin`
--

INSERT INTO `admin` (`nome`, `login`, `senha`) VALUES
('Administrador', 'chutabolao', 'corporativa');

-- --------------------------------------------------------

--
-- Estrutura da tabela `log`
--

CREATE TABLE IF NOT EXISTS `log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descricao` text,
  `data` datetime DEFAULT NULL,
  `quantidade` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `aposta`
--

CREATE TABLE IF NOT EXISTS `aposta` (
  `usuario_id` bigint(20) NOT NULL DEFAULT '0',
  `campeonato_id` int(11) NOT NULL DEFAULT '0',
  `jogo_id` int(11) NOT NULL DEFAULT '0',
  `apostaGolsTime1` int(11) DEFAULT NULL,
  `apostaGolsTime2` int(11) DEFAULT NULL,
  `pontosAposta` int(11) DEFAULT NULL,
  PRIMARY KEY (`usuario_id`,`campeonato_id`,`jogo_id`),
  KEY `usuario_id` (`usuario_id`),
  KEY `campeonato_id` (`campeonato_id`),
  KEY `jogo_id` (`jogo_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `campeonato`
--

CREATE TABLE IF NOT EXISTS `campeonato` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nomeCampeonato` varchar(255) DEFAULT NULL,
  `anoCampeonato` int(11) DEFAULT NULL,
  `quantidadeRodadas` int(11) DEFAULT NULL,
  `urlLogo` text,
  `status` set('ativo','finalizado') DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Extraindo dados da tabela `campeonato`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `contadoraposta`
--

CREATE TABLE IF NOT EXISTS `contadoraposta` (
  `id` varchar(255) NOT NULL DEFAULT '',
  `campeonato_id` int(11) NOT NULL DEFAULT '0',
  `jogo_id` int(11) NOT NULL DEFAULT '0',
  `quantidadeApostas` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`,`campeonato_id`,`jogo_id`),
  KEY `campeonato_id` (`campeonato_id`),
  KEY `jogo_id` (`jogo_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `jogo`
--

CREATE TABLE IF NOT EXISTS `jogo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `campeonato_id` int(11) DEFAULT NULL,
  `rodada_id` int(11) DEFAULT NULL,
  `dataJogo` varchar(50) DEFAULT NULL,
  `codTime1` int(11) DEFAULT NULL,
  `codTime2` int(11) DEFAULT NULL,
  `golsTime1` int(11) DEFAULT NULL,
  `golsTime2` int(11) DEFAULT NULL,
  `dataInicioApostas` datetime DEFAULT NULL,
  `dataFimApostas` datetime DEFAULT NULL,
  `escudosJogo` text,
  PRIMARY KEY (`id`),
  KEY `campeonato_id` (`campeonato_id`),
  KEY `rodada_id` (`rodada_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=33 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `pontuacaogeral`
--

CREATE TABLE IF NOT EXISTS `pontuacaogeral` (
  `usuario_id` bigint(20) NOT NULL DEFAULT '0',
  `acertosPlacarGeral` int(11) DEFAULT NULL,
  `acertosTimeGanhadorGeral` int(11) DEFAULT NULL,
  `acertosPlacarInvertidoGeral` int(11) DEFAULT NULL,
  `errosPlacarGeral` int(11) DEFAULT NULL,
  `pontosGeral` int(11) DEFAULT NULL,
  `classificacaoGeral` int(11) DEFAULT NULL,
  `pontosMedalhasGeral` int(11) DEFAULT NULL,
  `classificacaoMedalhasGeral` int(11) DEFAULT NULL,
  `medalhasOuroGeral` int(11) DEFAULT NULL,
  `medalhasPrataGeral` int(11) DEFAULT NULL,
  `medalhasBronzeGeral` int(11) DEFAULT NULL,
  `trofeus` int(11) DEFAULT NULL,
  PRIMARY KEY (`usuario_id`),
  KEY `usuario_id` (`usuario_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `pontuacaorodada`
--

CREATE TABLE IF NOT EXISTS `pontuacaorodada` (
  `usuario_id` bigint(20) NOT NULL DEFAULT '0',
  `campeonato_id` int(11) NOT NULL DEFAULT '0',
  `rodada_id` int(11) NOT NULL DEFAULT '0',
  `pontosRodada` int(11) DEFAULT NULL,
  `classificacaoRodada` int(11) DEFAULT NULL,
  PRIMARY KEY (`usuario_id`,`campeonato_id`,`rodada_id`),
  KEY `usuario_id` (`usuario_id`),
  KEY `campeonato_id` (`campeonato_id`),
  KEY `rodada_id` (`rodada_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `premiosusuario`
--

CREATE TABLE IF NOT EXISTS `premiosusuario` (
  `usuario_id` bigint(20) NOT NULL DEFAULT '0',
  `campeonato_id` int(11) NOT NULL DEFAULT '0',
  `codTimeFavorito` int(11) DEFAULT NULL,
  `acertosPlacar` int(11) DEFAULT NULL,
  `acertosTimeGanhador` int(11) DEFAULT NULL,
  `acertosPlacarInvertido` int(11) DEFAULT NULL,
  `errosPlacar` int(11) DEFAULT NULL,
  `pontosCampeonato` int(11) DEFAULT NULL,
  `pontosMedalhas` int(11) DEFAULT NULL,
  `classificacaoCampeonato` int(11) DEFAULT NULL,
  `classificacaoMedalhas` int(11) DEFAULT NULL,
  `medalhasOuro` int(11) DEFAULT NULL,
  `medalhasPrata` int(11) DEFAULT NULL,
  `medalhasBronze` int(11) DEFAULT NULL,
  `chuteirasOuro` int(11) DEFAULT NULL,
  `chuteirasPrata` int(11) DEFAULT NULL,
  `chuteirasBronze` int(11) DEFAULT NULL,
  `trofeu` int(11) DEFAULT '0',
  PRIMARY KEY (`usuario_id`,`campeonato_id`),
  KEY `usuario_id` (`usuario_id`),
  KEY `campeonato_id` (`campeonato_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `rendimentotime`
--

CREATE TABLE IF NOT EXISTS `rendimentotime` (
  `campeonato_id` int(11) NOT NULL DEFAULT '0',
  `time_id` int(11) NOT NULL DEFAULT '0',
  `vitorias` int(11) DEFAULT NULL,
  `derrotas` int(11) DEFAULT NULL,
  `empates` int(11) DEFAULT NULL,
  `golsPro` int(11) DEFAULT NULL,
  `golsContra` int(11) DEFAULT NULL,
  `pontos` int(11) DEFAULT NULL,
  `saldoGols` int(11) DEFAULT NULL,
  `classificacao` int(11) DEFAULT NULL,
  PRIMARY KEY (`campeonato_id`,`time_id`),
  KEY `time_id` (`time_id`),
  KEY `campeonato_id` (`campeonato_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `rodada`
--

CREATE TABLE IF NOT EXISTS `rodada` (
  `id` int(11) NOT NULL DEFAULT '0',
  `status` set('ativa','finalizada') DEFAULT NULL,
  `campeonato_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`,`campeonato_id`),
  KEY `campeonato_id` (`campeonato_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `time`
--

CREATE TABLE IF NOT EXISTS `time` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nomeTime` varchar(255) DEFAULT NULL,
  `escudo` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=24 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuario`
--

CREATE TABLE IF NOT EXISTS `usuario` (
  `id` bigint(20) NOT NULL DEFAULT '0',
  `tokenUsuario` varchar(255) DEFAULT NULL,
  `primeiroNomeUsuario` varchar(255) DEFAULT NULL,
  `segundoNomeUsuario` varchar(255) DEFAULT NULL,
  `emailUsuario` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Restrições para as tabelas dumpadas
--

--
-- Restrições para a tabela `aposta`
--
ALTER TABLE `aposta`
  ADD CONSTRAINT `FK_aposta_campeonato` FOREIGN KEY (`campeonato_id`) REFERENCES `campeonato` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_aposta_jogo` FOREIGN KEY (`jogo_id`) REFERENCES `jogo` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_aposta_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`id`) ON DELETE CASCADE;

--
-- Restrições para a tabela `contadoraposta`
--
ALTER TABLE `contadoraposta`
  ADD CONSTRAINT `FK_contadoraposta_campeonato` FOREIGN KEY (`campeonato_id`) REFERENCES `campeonato` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_contadoraposta_jogo` FOREIGN KEY (`jogo_id`) REFERENCES `jogo` (`id`) ON DELETE CASCADE;

--
-- Restrições para a tabela `jogo`
--
ALTER TABLE `jogo`
  ADD CONSTRAINT `FK_jogo_campeonato` FOREIGN KEY (`campeonato_id`) REFERENCES `campeonato` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_jogo_rodada` FOREIGN KEY (`rodada_id`) REFERENCES `rodada` (`id`) ON DELETE CASCADE;

--
-- Restrições para a tabela `pontuacaogeral`
--
ALTER TABLE `pontuacaogeral`
  ADD CONSTRAINT `FK_pontuacaogeral_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`id`) ON DELETE CASCADE;

--
-- Restrições para a tabela `pontuacaorodada`
--
ALTER TABLE `pontuacaorodada`
  ADD CONSTRAINT `FK_pontuacaoRodada_campeonato` FOREIGN KEY (`campeonato_id`) REFERENCES `campeonato` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_pontuacaoRodada_rodada` FOREIGN KEY (`rodada_id`) REFERENCES `rodada` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_pontuacaoRodada_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`id`) ON DELETE CASCADE;

--
-- Restrições para a tabela `premiosusuario`
--
ALTER TABLE `premiosusuario`
  ADD CONSTRAINT `FK_premiosusuario_campeonato` FOREIGN KEY (`campeonato_id`) REFERENCES `campeonato` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_premiosusuario_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`id`) ON DELETE CASCADE;

--
-- Restrições para a tabela `rendimentotime`
--
ALTER TABLE `rendimentotime`
  ADD CONSTRAINT `FK_rendimentotime_campeonato` FOREIGN KEY (`campeonato_id`) REFERENCES `campeonato` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_rendimentotime_time` FOREIGN KEY (`time_id`) REFERENCES `time` (`id`) ON DELETE CASCADE;

--
-- Restrições para a tabela `rodada`
--
ALTER TABLE `rodada`
  ADD CONSTRAINT `FK_rodada_campeonato` FOREIGN KEY (`campeonato_id`) REFERENCES `campeonato` (`id`) ON DELETE CASCADE;
