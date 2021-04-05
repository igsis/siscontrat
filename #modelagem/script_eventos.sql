USE siscontrat;


ALTER TABLE eventos
MODIFY tipo_evento_id TINYINT(1) NULL;

ALTER TABLE eventos
MODIFY fomento TINYINT(1) NULL;

ALTER TABLE eventos
MODIFY relacao_juridica_id TINYINT(2) NULL;

ALTER TABLE eventos
MODIFY projeto_especial_id TINYINT(2) NULL;

ALTER TABLE eventos
MODIFY nome_responsavel VARCHAR(70) NULL;


ALTER TABLE eventos
MODIFY tel_responsavel VARCHAR(70) NULL;

ALTER TABLE eventos
MODIFY contratacao TINYINT(1) NULL;

ALTER TABLE eventos
MODIFY evento_status_id TINYINT(2) NULL;

