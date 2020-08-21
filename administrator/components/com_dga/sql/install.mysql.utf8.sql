CREATE TABLE IF NOT EXISTS `#__dga_categorias_cat` (
  `id_cat` int(11) NOT NULL AUTO_INCREMENT,
  `nome_cat` varchar(100) NOT NULL,
  `descricao_cat` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`id_cat`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__dga_documentos_doc` (
  `id_doc` int(10) NOT NULL AUTO_INCREMENT,
  `id_cat` int(11) NOT NULL,
  `title_doc` varchar(150) NOT NULL,
  `description_doc` varchar(500) DEFAULT NULL,
  `extension_doc` varchar(5) NOT NULL,
  `filename_doc` varchar(255) NOT NULL,
  `filesize_doc` varchar(30) DEFAULT NULL,
  `create_user_doc` int(11) unsigned NOT NULL,
  `create_date_doc` datetime NOT NULL,
  `update_user_doc` int(11) DEFAULT NULL,
  `update_date_doc` datetime DEFAULT NULL,
  `data_inicio_publicacao_doc` datetime DEFAULT NULL,
  `data_fim_publicacao_doc` datetime DEFAULT NULL,
  `downloads_count_doc` bigint(20) DEFAULT '0',
  `published` tinyint(1) unsigned zerofill NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_doc`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__dga_documentos_grupos_dcg` (
  `id_dcg` int(11) NOT NULL AUTO_INCREMENT,
  `id_doc` int(11) NOT NULL,
  `id_grupo` int(11) NOT NULL,
  PRIMARY KEY (`id_dcg`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__dga_documentos_usuarios_dcu` (
  `id_dcu` int(11) NOT NULL AUTO_INCREMENT,
  `id_doc` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  PRIMARY KEY (`id_dcu`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__dga_usuarios_downloads_documentos_udd` (
  `id_udd` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_doc` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `create_date_udd` datetime NOT NULL,
  `last_date_download_udd` datetime DEFAULT NULL,
  `downloads_count_udd` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_udd`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

