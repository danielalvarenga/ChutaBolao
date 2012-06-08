-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tempo de Geração: 08/06/2012 às 22h55min
-- Versão do Servidor: 5.5.16
-- Versão do PHP: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Extraindo dados da tabela `campeonato`
--

INSERT INTO `campeonato` (`id`, `nomeCampeonato`, `anoCampeonato`, `quantidadeRodadas`, `status`) VALUES
(1, 'Brasileirão série A', 2012, 38, 'ativo');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

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
  `pontosCampeonato` int(11) DEFAULT NULL,
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=21 ;

--
-- Extraindo dados da tabela `time`
--

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
(17, 'Santos', 'imagens/escudos/santos47x47.png'),
(18, 'São Paulo', 'imagens/escudos/são-paulo47x47.png'),
(19, 'Sport', 'imagens/escudos/sport47x47.png'),
(20, 'Vasco', 'imagens/escudos/vasco47x47.png');

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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `usuario`
--

INSERT INTO `usuario` (`id`, `tokenUsuario`, `primeiroNomeUsuario`, `segundoNomeUsuario`, `emailUsuario`, `pontosGeral`) VALUES
(100000885523518, 'AAADUkCMlzxoBAAde2WKyZAMFkBgDMxuGcNoXsZB37g3eiPRVGe2nQXTIbN0StDRO2Bh4xf2mCHZBfOSQOp9qbAbpFMhqp2amsijqxK5GhLnMfRr8Ycl', 'Daniel', 'Alvarenga Lima', 'alvarenga_daniel@hotmail.com', 0);

--
-- Restrições para as tabelas dumpadas
--

--
-- Restrições para a tabela `aposta`
--
ALTER TABLE `aposta`
  ADD CONSTRAINT `FK_aposta_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`id`),
  ADD CONSTRAINT `FK_aposta_campeonato` FOREIGN KEY (`campeonato_id`) REFERENCES `campeonato` (`id`),
  ADD CONSTRAINT `FK_aposta_jogo` FOREIGN KEY (`jogo_id`) REFERENCES `jogo` (`id`);

--
-- Restrições para a tabela `jogo`
--
ALTER TABLE `jogo`
  ADD CONSTRAINT `FK_jogo_campeonato` FOREIGN KEY (`campeonato_id`) REFERENCES `campeonato` (`id`),
  ADD CONSTRAINT `FK_jogo_rodada` FOREIGN KEY (`rodada_id`) REFERENCES `rodada` (`id`);

--
-- Restrições para a tabela `premiosusuario`
--
ALTER TABLE `premiosusuario`
  ADD CONSTRAINT `FK_premiosusuario_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`id`),
  ADD CONSTRAINT `FK_premiosusuario_campeonato` FOREIGN KEY (`campeonato_id`) REFERENCES `campeonato` (`id`);

--
-- Restrições para a tabela `rendimentotime`
--
ALTER TABLE `rendimentotime`
  ADD CONSTRAINT `FK_rendimentotime_time` FOREIGN KEY (`time_id`) REFERENCES `time` (`id`),
  ADD CONSTRAINT `FK_rendimentotime_campeonato` FOREIGN KEY (`campeonato_id`) REFERENCES `campeonato` (`id`);

--
-- Restrições para a tabela `rodada`
--
ALTER TABLE `rodada`
  ADD CONSTRAINT `FK_rodada_campeonato` FOREIGN KEY (`campeonato_id`) REFERENCES `campeonato` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
