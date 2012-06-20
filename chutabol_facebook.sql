/** C�digo para criar o Banco de Dados "chutabol_facebook" no localhost */
CREATE DATABASE IF NOT EXISTS `chutabol_facebook`;
USE `chutabol_facebook`;

/** C�digo para criar o usu�rio "chutabol_admin" com senha "corporativa10" com todos os privil�gios sobre o "chutabol_facebook" */
GRANT ALL PRIVILEGES ON *.* TO 'chutabol_admin'@'localhost' IDENTIFIED BY PASSWORD '*EEDE3CD56ADE00288A5D5939141F8369A419085F' WITH GRANT OPTION;
GRANT ALL PRIVILEGES ON `chutabol_facebook`.* TO 'chutabol_admin'@'localhost' WITH GRANT OPTION;



-- Banco de Dados: `chutabol_facebook`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `aposta`
--

CREATE TABLE IF NOT EXISTS `aposta` (
  `usuario_id` bigint(20) NOT NULL DEFAULT '0',
  `campeonato_id` int(255) NOT NULL DEFAULT '0',
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
  `status` set('ativo','finalizado') DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
  PRIMARY KEY (`id`),
  KEY `campeonato_id` (`campeonato_id`),
  KEY `rodada_id` (`rodada_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `pontuacaoRodada`
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
  `trofeu` tinyint(4) DEFAULT NULL,
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
  `pontosGeral` int(11) DEFAULT NULL,
  `classificacaoGeral` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Restrições para as tabelas dumpadas
--

--
-- Restrições para a tabela `aposta`
--
ALTER TABLE `aposta`
  ADD CONSTRAINT `FK_aposta_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_aposta_campeonato` FOREIGN KEY (`campeonato_id`) REFERENCES `campeonato` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_aposta_jogo` FOREIGN KEY (`jogo_id`) REFERENCES `jogo` (`id`) ON DELETE CASCADE;

--
-- Restrições para a tabela `jogo`
--
ALTER TABLE `jogo`
  ADD CONSTRAINT `FK_jogo_campeonato` FOREIGN KEY (`campeonato_id`) REFERENCES `campeonato` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_jogo_rodada` FOREIGN KEY (`rodada_id`) REFERENCES `rodada` (`id`) ON DELETE CASCADE;

--
-- Restrições para a tabela `pontuacaoRodada`
--
ALTER TABLE `pontuacaorodada`
  ADD CONSTRAINT `FK_pontuacaoRodada_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_pontuacaoRodada_campeonato` FOREIGN KEY (`campeonato_id`) REFERENCES `campeonato` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_pontuacaoRodada_rodada` FOREIGN KEY (`rodada_id`) REFERENCES `rodada` (`id`) ON DELETE CASCADE;
  
--
-- Restrições para a tabela `premiosusuario`
--
ALTER TABLE `premiosusuario`
  ADD CONSTRAINT `FK_premiosusuario_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_premiosusuario_campeonato` FOREIGN KEY (`campeonato_id`) REFERENCES `campeonato` (`id`) ON DELETE CASCADE;

--
-- Restrições para a tabela `rendimentotime`
--
ALTER TABLE `rendimentotime`
  ADD CONSTRAINT `FK_rendimentotime_timex` FOREIGN KEY (`time_id`) REFERENCES `time` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_rendimentotime_campeonato` FOREIGN KEY (`campeonato_id`) REFERENCES `campeonato` (`id`) ON DELETE CASCADE;

--
-- Restrições para a tabela `rodada`
--
ALTER TABLE `rodada`
  ADD CONSTRAINT `FK_rodada_campeonato` FOREIGN KEY (`campeonato_id`) REFERENCES `campeonato` (`id`) ON DELETE CASCADE;
