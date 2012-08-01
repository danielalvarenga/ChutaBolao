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
  `id` int(11) NOT NULL,
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 ;

-- --------------------------------------------------------


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
  
  
  
  
  
  
  
  
  
  
  
  
  

CREATE TABLE IF NOT EXISTS `pais` (
  `sigla2letras` CHAR(2) DEFAULT NULL,
  `sigla3letras` CHAR(3) DEFAULT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nomePais` varchar(255) DEFAULT NULL,
  `bandeira` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

INSERT INTO pais VALUES ('AF', 'AFG', '004', 'Afeganist�o', NULL);
INSERT INTO pais VALUES ('ZA', 'ZAF', '710', '�frica do Sul', NULL);
INSERT INTO pais VALUES ('AX', 'ALA', '248', '�land, Ilhas', NULL);
INSERT INTO pais VALUES ('AL', 'ALB', '008', 'Alb�nia', NULL);
INSERT INTO pais VALUES ('DE', 'DEU', '276', 'Alemanha', NULL);
INSERT INTO pais VALUES ('AD', 'AND', '020', 'Andorra', NULL);
INSERT INTO pais VALUES ('AO', 'AGO', '024', 'Angola', NULL);
INSERT INTO pais VALUES ('AI', 'AIA', '660', 'Anguilla', NULL);
INSERT INTO pais VALUES ('AQ', 'ATA', '010', 'Ant�rctida', NULL);
INSERT INTO pais VALUES ('AG', 'ATG', '028', 'Antigua e Barbuda', NULL);
INSERT INTO pais VALUES ('AN', 'ANT', '530', 'Antilhas Holandesas', NULL);
INSERT INTO pais VALUES ('SA', 'SAU', '682', 'Ar�bia Saudita', NULL);
INSERT INTO pais VALUES ('DZ', 'DZA', '012', 'Arg�lia', NULL);
INSERT INTO pais VALUES ('AR', 'ARG', '032', 'Argentina', NULL);
INSERT INTO pais VALUES ('AM', 'ARM', '051', 'Arm�nia', NULL);
INSERT INTO pais VALUES ('AW', 'ABW', '533', 'Aruba', NULL);
INSERT INTO pais VALUES ('AU', 'AUS', '036', 'Austr�lia', NULL);
INSERT INTO pais VALUES ('AT', 'AUT', '040', '�ustria', NULL);
INSERT INTO pais VALUES ('AZ', 'AZE', '031', 'Azerbeij�o', NULL);
INSERT INTO pais VALUES ('BS', 'BHS', '044', 'Bahamas', NULL);
INSERT INTO pais VALUES ('BH', 'BHR', '048', 'Bahrain', NULL);
INSERT INTO pais VALUES ('BD', 'BGD', '050', 'Bangladesh', NULL);
INSERT INTO pais VALUES ('BB', 'BRB', '052', 'Barbados', NULL);
INSERT INTO pais VALUES ('BE', 'BEL', '056', 'B�lgica', NULL);
INSERT INTO pais VALUES ('BZ', 'BLZ', '084', 'Belize', NULL);
INSERT INTO pais VALUES ('BJ', 'BEN', '204', 'Benin', NULL);
INSERT INTO pais VALUES ('BM', 'BMU', '060', 'Bermuda', NULL);
INSERT INTO pais VALUES ('BY', 'BLR', '112', 'Bielo-R�ssia', NULL);
INSERT INTO pais VALUES ('BO', 'BOL', '068', 'Bol�via', NULL);
INSERT INTO pais VALUES ('BA', 'BIH', '070', 'B�snia-Herzegovina', NULL);
INSERT INTO pais VALUES ('BW', 'BWA', '072', 'Botswana', NULL);
INSERT INTO pais VALUES ('BV', 'BVT', '074', 'Bouvet, Ilha', NULL);
INSERT INTO pais VALUES ('BR', 'BRA', '076', 'Brasil', NULL);
INSERT INTO pais VALUES ('BN', 'BRN', '096', 'Brunei', NULL);
INSERT INTO pais VALUES ('BG', 'BGR', '100', 'Bulg�ria', NULL);
INSERT INTO pais VALUES ('BF', 'BFA', '854', 'Burkina Faso', NULL);
INSERT INTO pais VALUES ('BI', 'BDI', '108', 'Burundi', NULL);
INSERT INTO pais VALUES ('BT', 'BTN', '064', 'But�o', NULL);
INSERT INTO pais VALUES ('CV', 'CPV', '132', 'Cabo Verde', NULL);
INSERT INTO pais VALUES ('KH', 'KHM', '116', 'Cambodja', NULL);
INSERT INTO pais VALUES ('CM', 'CMR', '120', 'Camar�es', NULL);
INSERT INTO pais VALUES ('CA', 'CAN', '124', 'Canad�', NULL);
INSERT INTO pais VALUES ('KY', 'CYM', '136', 'Cayman, Ilhas', NULL);
INSERT INTO pais VALUES ('KZ', 'KAZ', '398', 'Cazaquist�o', NULL);
INSERT INTO pais VALUES ('CF', 'CAF', '140', 'Centro-africana, Rep�blica', NULL);
INSERT INTO pais VALUES ('TD', 'TCD', '148', 'Chade', NULL);
INSERT INTO pais VALUES ('CZ', 'CZE', '203', 'Checa, Rep�blica', NULL);
INSERT INTO pais VALUES ('CL', 'CHL', '152', 'Chile', NULL);
INSERT INTO pais VALUES ('CN', 'CHN', '156', 'China', NULL);
INSERT INTO pais VALUES ('CY', 'CYP', '196', 'Chipre', NULL);
INSERT INTO pais VALUES ('CX', 'CXR', '162', 'Christmas, Ilha', NULL);
INSERT INTO pais VALUES ('CC', 'CCK', '166', 'Cocos, Ilhas', NULL);
INSERT INTO pais VALUES ('CO', 'COL', '170', 'Col�mbia', NULL);
INSERT INTO pais VALUES ('KM', 'COM', '174', 'Comores', NULL);
INSERT INTO pais VALUES ('CG', 'COG', '178', 'Congo, Rep�blica do', NULL);
INSERT INTO pais VALUES ('CD', 'COD', '180', 'Congo, Rep�blica Democr�tica do (antigo Zaire)', NULL);
INSERT INTO pais VALUES ('CK', 'COK', '184', 'Cook, Ilhas', NULL);
INSERT INTO pais VALUES ('KR', 'KOR', '410', 'Coreia do Sul', NULL);
INSERT INTO pais VALUES ('KP', 'PRK', '408', 'Coreia, Rep�blica Democr�tica da (Coreia do Norte)', NULL);
INSERT INTO pais VALUES ('CI', 'CIV', '384', 'Costa do Marfim', NULL);
INSERT INTO pais VALUES ('CR', 'CRI', '188', 'Costa Rica', NULL);
INSERT INTO pais VALUES ('HR', 'HRV', '191', 'Cro�cia', NULL);
INSERT INTO pais VALUES ('CU', 'CUB', '192', 'Cuba', NULL);
INSERT INTO pais VALUES ('DK', 'DNK', '208', 'Dinamarca', NULL);
INSERT INTO pais VALUES ('DJ', 'DJI', '262', 'Djibouti', NULL);
INSERT INTO pais VALUES ('DM', 'DMA', '212', 'Dominica', NULL);
INSERT INTO pais VALUES ('DO', 'DOM', '214', 'Dominicana, Rep�blica', NULL);
INSERT INTO pais VALUES ('EG', 'EGY', '818', 'Egipto', NULL);
INSERT INTO pais VALUES ('SV', 'SLV', '222', 'El Salvador', NULL);
INSERT INTO pais VALUES ('AE', 'ARE', '784', 'Emiratos �rabes Unidos', NULL);
INSERT INTO pais VALUES ('EC', 'ECU', '218', 'Equador', NULL);
INSERT INTO pais VALUES ('ER', 'ERI', '232', 'Eritreia', NULL);
INSERT INTO pais VALUES ('SK', 'SVK', '703', 'Eslov�quia', NULL);
INSERT INTO pais VALUES ('SI', 'SVN', '705', 'Eslov�nia', NULL);
INSERT INTO pais VALUES ('ES', 'ESP', '724', 'Espanha', NULL);
INSERT INTO pais VALUES ('US', 'USA', '840', 'Estados Unidos da Am�rica', NULL);
INSERT INTO pais VALUES ('EE', 'EST', '233', 'Est�nia', NULL);
INSERT INTO pais VALUES ('ET', 'ETH', '231', 'Eti�pia', NULL);
INSERT INTO pais VALUES ('FO', 'FRO', '234', 'Faroe, Ilhas', NULL);
INSERT INTO pais VALUES ('FJ', 'FJI', '242', 'Fiji', NULL);
INSERT INTO pais VALUES ('PH', 'PHL', '608', 'Filipinas', NULL);
INSERT INTO pais VALUES ('FI', 'FIN', '246', 'Finl�ndia', NULL);
INSERT INTO pais VALUES ('FR', 'FRA', '250', 'Fran�a', NULL);
INSERT INTO pais VALUES ('GA', 'GAB', '266', 'Gab�o', NULL);
INSERT INTO pais VALUES ('GM', 'GMB', '270', 'G�mbia', NULL);
INSERT INTO pais VALUES ('GH', 'GHA', '288', 'Gana', NULL);
INSERT INTO pais VALUES ('GE', 'GEO', '268', 'Ge�rgia', NULL);
INSERT INTO pais VALUES ('GS', 'SGS', '239', 'Ge�rgia do Sul e Sandwich do Sul, Ilhas', NULL);
INSERT INTO pais VALUES ('GI', 'GIB', '292', 'Gibraltar', NULL);
INSERT INTO pais VALUES ('GR', 'GRC', '300', 'Gr�cia', NULL);
INSERT INTO pais VALUES ('GD', 'GRD', '308', 'Grenada', NULL);
INSERT INTO pais VALUES ('GL', 'GRL', '304', 'Gronel�ndia', NULL);
INSERT INTO pais VALUES ('GP', 'GLP', '312', 'Guadeloupe', NULL);
INSERT INTO pais VALUES ('GU', 'GUM', '316', 'Guam', NULL);
INSERT INTO pais VALUES ('GT', 'GTM', '320', 'Guatemala', NULL);
INSERT INTO pais VALUES ('GG', 'GGY', '831', 'Guernsey', NULL);
INSERT INTO pais VALUES ('GY', 'GUY', '328', 'Guiana', NULL);
INSERT INTO pais VALUES ('GF', 'GUF', '254', 'Guiana Francesa', NULL);
INSERT INTO pais VALUES ('GW', 'GNB', '624', 'Guin�-Bissau', NULL);
INSERT INTO pais VALUES ('GN', 'GIN', '324', 'Guin�-Conacri', NULL);
INSERT INTO pais VALUES ('GQ', 'GNQ', '226', 'Guin� Equatorial', NULL);
INSERT INTO pais VALUES ('HT', 'HTI', '332', 'Haiti', NULL);
INSERT INTO pais VALUES ('HM', 'HMD', '334', 'Heard e Ilhas McDonald, Ilha', NULL);
INSERT INTO pais VALUES ('HN', 'HND', '340', 'Honduras', NULL);
INSERT INTO pais VALUES ('HK', 'HKG', '344', 'Hong Kong', NULL);
INSERT INTO pais VALUES ('HU', 'HUN', '348', 'Hungria', NULL);
INSERT INTO pais VALUES ('YE', 'YEM', '887', 'I�men', NULL);
INSERT INTO pais VALUES ('IN', 'IND', '356', '�ndia', NULL);
INSERT INTO pais VALUES ('ID', 'IDN', '360', 'Indon�sia', NULL);
INSERT INTO pais VALUES ('IQ', 'IRQ', '368', 'Iraque', NULL);
INSERT INTO pais VALUES ('IR', 'IRN', '364', 'Ir�o', NULL);
INSERT INTO pais VALUES ('IE', 'IRL', '372', 'Irlanda', NULL);
INSERT INTO pais VALUES ('IS', 'ISL', '352', 'Isl�ndia', NULL);
INSERT INTO pais VALUES ('IL', 'ISR', '376', 'Israel', NULL);
INSERT INTO pais VALUES ('IT', 'ITA', '380', 'It�lia', NULL);
INSERT INTO pais VALUES ('JM', 'JAM', '388', 'Jamaica', NULL);
INSERT INTO pais VALUES ('JP', 'JPN', '392', 'Jap�o', NULL);
INSERT INTO pais VALUES ('JE', 'JEY', '832', 'Jersey', NULL);
INSERT INTO pais VALUES ('JO', 'JOR', '400', 'Jord�nia', NULL);
INSERT INTO pais VALUES ('KI', 'KIR', '296', 'Kiribati', NULL);
INSERT INTO pais VALUES ('KW', 'KWT', '414', 'Kuwait', NULL);
INSERT INTO pais VALUES ('LA', 'LAO', '418', 'Laos', NULL);
INSERT INTO pais VALUES ('LS', 'LSO', '426', 'Lesoto', NULL);
INSERT INTO pais VALUES ('LV', 'LVA', '428', 'Let�nia', NULL);
INSERT INTO pais VALUES ('LB', 'LBN', '422', 'L�bano', NULL);
INSERT INTO pais VALUES ('LR', 'LBR', '430', 'Lib�ria', NULL);
INSERT INTO pais VALUES ('LY', 'LBY', '434', 'L�bia', NULL);
INSERT INTO pais VALUES ('LI', 'LIE', '438', 'Liechtenstein', NULL);
INSERT INTO pais VALUES ('LT', 'LTU', '440', 'Litu�nia', NULL);
INSERT INTO pais VALUES ('LU', 'LUX', '442', 'Luxemburgo', NULL);
INSERT INTO pais VALUES ('MO', 'MAC', '446', 'Macau', NULL);
INSERT INTO pais VALUES ('MK', 'MKD', '807', 'Maced�nia, Rep�blica da', NULL);
INSERT INTO pais VALUES ('MG', 'MDG', '450', 'Madag�scar', NULL);
INSERT INTO pais VALUES ('MY', 'MYS', '458', 'Mal�sia', NULL);
INSERT INTO pais VALUES ('MW', 'MWI', '454', 'Malawi', NULL);
INSERT INTO pais VALUES ('MV', 'MDV', '462', 'Maldivas', NULL);
INSERT INTO pais VALUES ('ML', 'MLI', '466', 'Mali', NULL);
INSERT INTO pais VALUES ('MT', 'MLT', '470', 'Malta', NULL);
INSERT INTO pais VALUES ('FK', 'FLK', '238', 'Malvinas, Ilhas (Falkland)', NULL);
INSERT INTO pais VALUES ('IM', 'IMN', '833', 'Man, Ilha de', NULL);
INSERT INTO pais VALUES ('MP', 'MNP', '580', 'Marianas Setentrionais', NULL);
INSERT INTO pais VALUES ('MA', 'MAR', '504', 'Marrocos', NULL);
INSERT INTO pais VALUES ('MH', 'MHL', '584', 'Marshall, Ilhas', NULL);
INSERT INTO pais VALUES ('MQ', 'MTQ', '474', 'Martinica', NULL);
INSERT INTO pais VALUES ('MU', 'MUS', '480', 'Maur�cia', NULL);
INSERT INTO pais VALUES ('MR', 'MRT', '478', 'Maurit�nia', NULL);
INSERT INTO pais VALUES ('YT', 'MYT', '175', 'Mayotte', NULL);
INSERT INTO pais VALUES ('UM', 'UMI', '581', 'Menores Distantes dos Estados Unidos, Ilhas', NULL);
INSERT INTO pais VALUES ('MX', 'MEX', '484', 'M�xico', NULL);
INSERT INTO pais VALUES ('MM', 'MMR', '104', 'Myanmar (antiga Birm�nia)', NULL);
INSERT INTO pais VALUES ('FM', 'FSM', '583', 'Micron�sia, Estados Federados da', NULL);
INSERT INTO pais VALUES ('MZ', 'MOZ', '508', 'Mo�ambique', NULL);
INSERT INTO pais VALUES ('MD', 'MDA', '498', 'Mold�via', NULL);
INSERT INTO pais VALUES ('MC', 'MCO', '492', 'M�naco', NULL);
INSERT INTO pais VALUES ('MN', 'MNG', '496', 'Mong�lia', NULL);
INSERT INTO pais VALUES ('ME', 'MNE', '499', 'Montenegro', NULL);
INSERT INTO pais VALUES ('MS', 'MSR', '500', 'Montserrat', NULL);
INSERT INTO pais VALUES ('NA', 'NAM', '516', 'Nam�bia', NULL);
INSERT INTO pais VALUES ('NR', 'NRU', '520', 'Nauru', NULL);
INSERT INTO pais VALUES ('NP', 'NPL', '524', 'Nepal', NULL);
INSERT INTO pais VALUES ('NI', 'NIC', '558', 'Nicar�gua', NULL);
INSERT INTO pais VALUES ('NE', 'NER', '562', 'N�ger', NULL);
INSERT INTO pais VALUES ('NG', 'NGA', '566', 'Nig�ria', NULL);
INSERT INTO pais VALUES ('NU', 'NIU', '570', 'Niue', NULL);
INSERT INTO pais VALUES ('NF', 'NFK', '574', 'Norfolk, Ilha', NULL);
INSERT INTO pais VALUES ('NO', 'NOR', '578', 'Noruega', NULL);
INSERT INTO pais VALUES ('NC', 'NCL', '540', 'Nova Caled�nia', NULL);
INSERT INTO pais VALUES ('NZ', 'NZL', '554', 'Nova Zel�ndia (Aotearoa)', NULL);
INSERT INTO pais VALUES ('OM', 'OMN', '512', 'Oman', NULL);
INSERT INTO pais VALUES ('NL', 'NLD', '528', 'Pa�ses Baixos (Holanda)', NULL);
INSERT INTO pais VALUES ('PW', 'PLW', '585', 'Palau', NULL);
INSERT INTO pais VALUES ('PS', 'PSE', '275', 'Palestina', NULL);
INSERT INTO pais VALUES ('PA', 'PAN', '591', 'Panam�', NULL);
INSERT INTO pais VALUES ('PG', 'PNG', '598', 'Papua-Nova Guin�', NULL);
INSERT INTO pais VALUES ('PK', 'PAK', '586', 'Paquist�o', NULL);
INSERT INTO pais VALUES ('PY', 'PRY', '600', 'Paraguai', NULL);
INSERT INTO pais VALUES ('PE', 'PER', '604', 'Peru', NULL);
INSERT INTO pais VALUES ('PN', 'PCN', '612', 'Pitcairn', NULL);
INSERT INTO pais VALUES ('PF', 'PYF', '258', 'Polin�sia Francesa', NULL);
INSERT INTO pais VALUES ('PL', 'POL', '616', 'Pol�nia', NULL);
INSERT INTO pais VALUES ('PR', 'PRI', '630', 'Porto Rico', NULL);
INSERT INTO pais VALUES ('PT', 'PRT', '620', 'Portugal', NULL);
INSERT INTO pais VALUES ('QA', 'QAT', '634', 'Qatar', NULL);
INSERT INTO pais VALUES ('KE', 'KEN', '404', 'Qu�nia', NULL);
INSERT INTO pais VALUES ('KG', 'KGZ', '417', 'Quirguist�o', NULL);
INSERT INTO pais VALUES ('GB', 'GBR', '826', 'Reino Unido da Gr�-Bretanha e Irlanda do Norte', NULL);
INSERT INTO pais VALUES ('RE', 'REU', '638', 'Reuni�o', NULL);
INSERT INTO pais VALUES ('RO', 'ROU', '642', 'Rom�nia', NULL);
INSERT INTO pais VALUES ('RW', 'RWA', '646', 'Ruanda', NULL);
INSERT INTO pais VALUES ('RU', 'RUS', '643', 'R�ssia', NULL);
INSERT INTO pais VALUES ('EH', 'ESH', '732', 'Saara Ocidental', NULL);
INSERT INTO pais VALUES ('AS', 'ASM', '016', 'Samoa Americana', NULL);
INSERT INTO pais VALUES ('WS', 'WSM', '882', 'Samoa (Samoa Ocidental)', NULL);
INSERT INTO pais VALUES ('PM', 'SPM', '666', 'Saint Pierre et Miquelon', NULL);
INSERT INTO pais VALUES ('SB', 'SLB', '090', 'Salom�o, Ilhas', NULL);
INSERT INTO pais VALUES ('KN', 'KNA', '659', 'S�o Crist�v�o e N�vis (Saint Kitts e Nevis)', NULL);
INSERT INTO pais VALUES ('SM', 'SMR', '674', 'San Marino', NULL);
INSERT INTO pais VALUES ('ST', 'STP', '678', 'S�o Tom� e Pr�ncipe', NULL);
INSERT INTO pais VALUES ('VC', 'VCT', '670', 'S�o Vicente e Granadinas', NULL);
INSERT INTO pais VALUES ('SH', 'SHN', '654', 'Santa Helena', NULL);
INSERT INTO pais VALUES ('LC', 'LCA', '662', 'Santa L�cia', NULL);
INSERT INTO pais VALUES ('SN', 'SEN', '686', 'Senegal', NULL);
INSERT INTO pais VALUES ('SL', 'SLE', '694', 'Serra Leoa', NULL);
INSERT INTO pais VALUES ('RS', 'SRB', '688', 'S�rvia', NULL);
INSERT INTO pais VALUES ('SC', 'SYC', '690', 'Seychelles', NULL);
INSERT INTO pais VALUES ('SG', 'SGP', '702', 'Singapura', NULL);
INSERT INTO pais VALUES ('SY', 'SYR', '760', 'S�ria', NULL);
INSERT INTO pais VALUES ('SO', 'SOM', '706', 'Som�lia', NULL);
INSERT INTO pais VALUES ('LK', 'LKA', '144', 'Sri Lanka', NULL);
INSERT INTO pais VALUES ('SZ', 'SWZ', '748', 'Suazil�ndia', NULL);
INSERT INTO pais VALUES ('SD', 'SDN', '736', 'Sud�o', NULL);
INSERT INTO pais VALUES ('SE', 'SWE', '752', 'Su�cia', NULL);
INSERT INTO pais VALUES ('CH', 'CHE', '756', 'Su��a', NULL);
INSERT INTO pais VALUES ('SR', 'SUR', '740', 'Suriname', NULL);
INSERT INTO pais VALUES ('SJ', 'SJM', '744', 'Svalbard e Jan Mayen', NULL);
INSERT INTO pais VALUES ('TH', 'THA', '764', 'Tail�ndia', NULL);
INSERT INTO pais VALUES ('TW', 'TWN', '158', 'Taiwan', NULL);
INSERT INTO pais VALUES ('TJ', 'TJK', '762', 'Tajiquist�o', NULL);
INSERT INTO pais VALUES ('TZ', 'TZA', '834', 'Tanz�nia', NULL);
INSERT INTO pais VALUES ('TF', 'ATF', '260', 'Terras Austrais e Ant�rticas Francesas (TAAF)', NULL);
INSERT INTO pais VALUES ('IO', 'IOT', '086', 'Territ�rio Brit�nico do Oceano �ndico', NULL);
INSERT INTO pais VALUES ('TL', 'TLS', '626', 'Timor-Leste', NULL);
INSERT INTO pais VALUES ('TG', 'TGO', '768', 'Togo', NULL);
INSERT INTO pais VALUES ('TK', 'TKL', '772', 'Toquelau', NULL);
INSERT INTO pais VALUES ('TO', 'TON', '776', 'Tonga', NULL);
INSERT INTO pais VALUES ('TT', 'TTO', '780', 'Trindade e Tobago', NULL);
INSERT INTO pais VALUES ('TN', 'TUN', '788', 'Tun�sia', NULL);
INSERT INTO pais VALUES ('TC', 'TCA', '796', 'Turks e Caicos', NULL);
INSERT INTO pais VALUES ('TM', 'TKM', '795', 'Turquemenist�o', NULL);
INSERT INTO pais VALUES ('TR', 'TUR', '792', 'Turquia', NULL);
INSERT INTO pais VALUES ('TV', 'TUV', '798', 'Tuvalu', NULL);
INSERT INTO pais VALUES ('UA', 'UKR', '804', 'Ucr�nia', NULL);
INSERT INTO pais VALUES ('UG', 'UGA', '800', 'Uganda', NULL);
INSERT INTO pais VALUES ('UY', 'URY', '858', 'Uruguai', NULL);
INSERT INTO pais VALUES ('UZ', 'UZB', '860', 'Usbequist�o', NULL);
INSERT INTO pais VALUES ('VU', 'VUT', '548', 'Vanuatu', NULL);
INSERT INTO pais VALUES ('VA', 'VAT', '336', 'Vaticano', NULL);
INSERT INTO pais VALUES ('VE', 'VEN', '862', 'Venezuela', NULL);
INSERT INTO pais VALUES ('VN', 'VNM', '704', 'Vietname', NULL);
INSERT INTO pais VALUES ('VI', 'VIR', '850', 'Virgens Americanas, Ilhas', NULL);
INSERT INTO pais VALUES ('VG', 'VGB', '092', 'Virgens Brit�nicas, Ilhas', NULL);
INSERT INTO pais VALUES ('WF', 'WLF', '876', 'Wallis e Futuna', NULL);
INSERT INTO pais VALUES ('ZM', 'ZMB', '894', 'Z�mbia', NULL);
INSERT INTO pais VALUES ('ZW', 'ZWE', '716', 'Zimbabwe', NULL);



-- Acr�scimos em 26/07/12
ALTER TABLE `time`
  ADD `pais_id` int(11) NOT NULL DEFAULT '076',
  ADD KEY `pais_id` (`pais_id`);
  
  
--
-- Restrições para a tabela `time`
--
ALTER TABLE `time`
  ADD CONSTRAINT `FK_time_pais` FOREIGN KEY (`pais_id`) REFERENCES `pais` (`id`) ON DELETE CASCADE;
