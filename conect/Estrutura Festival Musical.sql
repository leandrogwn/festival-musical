SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

-- --------------------------------------------------------

--
-- Estrutura da tabela `f_config`
--

CREATE TABLE IF NOT EXISTS `f_config` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` int(11) NOT NULL,
  `festival_ativo` int(11) NOT NULL,
  `registros_pagina` int(11) NOT NULL,
  `exclusao_notas` int(11) NOT NULL,
  `qtd_class_seg_fase` int(11) NOT NULL,
  `qtd_class_final` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `f_fase`
--

CREATE TABLE IF NOT EXISTS `f_fase` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `festival` varchar(255) NOT NULL,
  `fase` varchar(255) NOT NULL,
  `data` varchar(20) NOT NULL,
  `informacao` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `f_festival`
--

CREATE TABLE IF NOT EXISTS `f_festival` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL,
  `periodo` varchar(100) NOT NULL,
  `informacao` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `f_inscricao`
--

CREATE TABLE IF NOT EXISTS `f_inscricao` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `festival` int(255) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `nascimento` date NOT NULL,
  `rg` varchar(15) NOT NULL,
  `cpf` varchar(20) NOT NULL,
  `telefone` varchar(20) NOT NULL,
  `celular` varchar(20) NOT NULL,
  `email` varchar(255) NOT NULL,
  `informacoes_interprete` varchar(255) DEFAULT NULL,
  `cep` varchar(15) NOT NULL,
  `uf` varchar(2) NOT NULL,
  `rua` varchar(255) NOT NULL,
  `numero` varchar(5) DEFAULT NULL,
  `bairro` varchar(255) NOT NULL,
  `cidade` varchar(255) NOT NULL,
  `categoria` varchar(50) NOT NULL,
  `cancao` varchar(255) NOT NULL,
  `compositor` varchar(255) NOT NULL,
  `gravado_por` varchar(255) NOT NULL,
  `link` varchar(255) NOT NULL,
  `informacao_cancao` varchar(255) DEFAULT NULL,
  `letra` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `f_jurado`
--

CREATE TABLE IF NOT EXISTS `f_jurado` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `festival` varchar(255) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `informacao` varchar(255) NOT NULL,
  `login` varchar(200) NOT NULL,
  `senha` varchar(255) NOT NULL COMMENT 'sha1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `f_liberacao`
--

CREATE TABLE IF NOT EXISTS `f_liberacao` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_festival` int(11) NOT NULL,
  `id_interprete` int(11) NOT NULL,
  `fase` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `f_login`
--

CREATE TABLE IF NOT EXISTS `f_login` (
  `id_login` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(200) NOT NULL,
  `login` varchar(200) NOT NULL,
  `senha` varchar(100) NOT NULL COMMENT 'sha1',
  `perfil` int(11) NOT NULL,
  PRIMARY KEY ('id_login')
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `f_login` (`nome`, `login`, `senha`, `perfil`) VALUES
('Leandro Goncalves', 'leandro', '66c5b19afa03ef580ef3e867a0e8390b7805f88e', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `f_nota`
--

CREATE TABLE IF NOT EXISTS `f_nota` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fase` varchar(10) NOT NULL,
  `id_interprete` int(11) NOT NULL,
  `id_jurado` int(11) NOT NULL,
  `nota` decimal(10,0) NOT NULL,
  `genero` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `f_primeira_fase`
--

CREATE TABLE IF NOT EXISTS `f_primeira_fase` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_festival` int(11) NOT NULL,
  `id_interprete` int(11) NOT NULL,
  `categoria` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;