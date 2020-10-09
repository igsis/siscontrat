<?php
if ($pedidoAjax) {
    require_once "../models/MainModel.php";
} else {
    require_once "./models/MainModel.php";
}

class FormacaoModel extends MainModel
{
    protected function getDadosContratacao()
    {

        $sql = "SELECT
                c.id AS 'id',
                c.protocolo AS 'protocolo',
                pf.nome AS 'pessoa',
                c.ano AS 'ano',
                p.programa AS 'programa',
                l.linguagem AS 'linguagem',
                fc.cargo AS 'cargo'
                FROM formacao_contratacoes AS c
                INNER JOIN pessoa_fisicas AS pf ON pf.id = c.pessoa_fisica_id
                INNER JOIN programas AS p ON p.id = c.programa_id
                INNER JOIN linguagens AS l ON l.id = c.linguagem_id
                INNER JOIN formacao_cargos AS fc ON fc.id = c.form_cargo_id
                WHERE c.publicado = 1";
        $pdo = parent::connection();
        $statement = $pdo->prepare($sql);
        $statement->execute();
        return $statement;
    }

    protected function getDocumento($documento,$tipo_doc){
        if($tipo_doc == 'cpf'){
            $consulta = DbModel::consultaSimples("SELECT id, nome, cpf as 'documento', email FROM pessoa_fisicas WHERE cpf LIKE '%$documento%'")->fetchAll(PDO::FETCH_ASSOC);
        }else if($tipo_doc == 'passaporte'){
            $consulta = DbModel::consultaSimples("SELECT id, nome, passaporte as 'documento', email FROM pessoa_fisicas WHERE passaporte LIKE '%$documento%'")->fetchAll(PDO::FETCH_ASSOC);
        }

        if (count($consulta) > 0) {
            for ($i = 0; $i < count($consulta); $i++) {
                $consulta[$i]['id'] = MainModel::encryption($consulta[$i]['id']);
            }
            return json_encode(array($consulta));
        }
        return 0;
        
    }

    protected function getPF()
    {
        return DbModel::consultaSimples("SELECT * FROM pessoa_fisicas")->fetchAll(PDO::FETCH_OBJ);
    }

    protected function getClassificacao()
    {
        return DbModel::consultaSimples("SELECT * FROM classificacao_indicativas")->fetchAll(PDO::FETCH_OBJ);
    }

    protected function getRegiaoPreferencial()
    {
        return DbModel::consultaSimples("SELECT * FROM regiao_preferencias")->fetchAll(PDO::FETCH_OBJ);
    }

    protected function getFiscalSuplente()
    {
        return DbModel::consultaSimples("SELECT * FROM usuarios")->fetchAll(PDO::FETCH_OBJ);
    }

}

