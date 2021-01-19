USE siscontrat;

SET FOREIGN_KEY_CHECKS = 0;

UPDATE `siscontrat`.`tipo_eventos` SET `tipo_evento`='Oficina' WHERE  `id`=3;

ALTER TABLE `eventos`
    CHANGE COLUMN `tipo_evento_id` `tipo_evento_id` TINYINT(1) NOT NULL COMMENT 'tipo:\n1-atracação\n2-fime\n3-oficina' AFTER `protocolo`;

INSERT INTO `siscontrat`.`modulos` (`sigla`, `descricao`, `cor_id`, `sistema`) VALUES ('oficina', 'Oficina', '12', '1');
INSERT INTO `siscontrat`.`modulo_perfis` (`modulo_id`, `perfil_id`) VALUES ('17', '1');

ALTER TABLE `oficinas`
    ADD COLUMN `evento_id` INT(11) NOT NULL AFTER `id`,
    CHANGE COLUMN `atracao_id` `atracao_id` INT(11) NULL AFTER `evento_id`,
    ADD COLUMN `oficina_nivel_id` TINYINT(1) NOT NULL AFTER `carga_horaria`,
    ADD COLUMN `oficina_linguagem_id` TINYINT(1) NOT NULL AFTER `oficina_nivel_id`,
    ADD COLUMN `oficina_sublinguagem_id` TINYINT(1) NOT NULL AFTER `oficina_linguagem_id`,
    ADD COLUMN `integrantes` LONGTEXT NULL DEFAULT NULL COLLATE 'utf8_general_ci' AFTER `oficina_sublinguagem_id`,
    ADD COLUMN `classificacao_indicativa_id` TINYINT(1) NOT NULL AFTER `integrantes`,
    ADD COLUMN `links` LONGTEXT NULL DEFAULT NULL COLLATE 'utf8_general_ci' AFTER `classificacao_indicativa_id`,
    ADD COLUMN `quantidade_apresentacao` TINYINT(2) NOT NULL AFTER `links`,
    ADD INDEX `fk_oficinas_eventos_idx` (`evento_id`),
    ADD INDEX `fk_oficinas_niveis_idx` (`oficina_nivel_id`),
    ADD INDEX `fk_oficinas_linguagens_idx` (`oficina_linguagem_id`),
    ADD INDEX `fk_oficinas_sublinguagens_idx` (`oficina_sublinguagem_id`),
    ADD INDEX `fk_oficinas_classificacao_idx` (`classificacao_indicativa_id`),
    ADD CONSTRAINT `fk_oficinas_eventos` FOREIGN KEY (`evento_id`) REFERENCES `eventos` (`id`) ON UPDATE NO ACTION ON DELETE NO ACTION,
    ADD CONSTRAINT `fk_oficinas_niveis` FOREIGN KEY (`oficina_nivel_id`) REFERENCES `oficina_niveis` (`id`) ON UPDATE NO ACTION ON DELETE NO ACTION,
    ADD CONSTRAINT `fk_oficinas_linguagens` FOREIGN KEY (`oficina_linguagem_id`) REFERENCES `oficina_linguagens` (`id`) ON UPDATE NO ACTION ON DELETE NO ACTION,
    ADD CONSTRAINT `fk_oficinas_sublinguagens` FOREIGN KEY (`oficina_sublinguagem_id`) REFERENCES `oficina_sublinguagens` (`id`) ON UPDATE NO ACTION ON DELETE NO ACTION,
    ADD CONSTRAINT `fk_oficinas_classificacao` FOREIGN KEY (`classificacao_indicativa_id`) REFERENCES `classificacao_indicativas` (`id`) ON UPDATE NO ACTION;

INSERT INTO `oficina_niveis` (`id`, `nivel`) VALUES (1, 'Iniciante');
INSERT INTO `oficina_niveis` (`id`, `nivel`) VALUES (2, 'Intermediário');
INSERT INTO `oficina_niveis` (`id`, `nivel`) VALUES (3, 'Avançado');

SET FOREIGN_KEY_CHECKS = 1;