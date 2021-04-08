<?php
if ($pedidoAjax) {
    require_once "../models/MainModel.php";
} else {
    require_once "./models/MainModel.php";
}

class FomentoModel extends MainModel
{
    protected function recuperaInscritos($edital_id, $tipo_pessoa, $aprovados = false) {
        $tipo_contratacao = DbModel::consultaSimples("SELECT tipo_contratacao_id FROM fom_editais WHERE id = '$edital_id'", true)->fetchColumn();
        if ($tipo_contratacao == 24) {
            $campo = ", fa.area ";
            $joinPeriferias = "LEFT JOIN fom_edital_periferias fep ON fep.fom_projeto_id = fp.id
                               LEFT JOIN fom_areas fa ON fa.id = fep.fom_area_id ";
        } else {
            $campo = "";
            $joinPeriferias = "";
        }

        if ($tipo_pessoa == 1){
            $sql = "SELECT fp.* {$campo} FROM fom_projetos fp
                LEFT JOIN fom_projeto_dado_pfs fpd ON fpd.fom_projeto_id = fp.id
                $joinPeriferias
                WHERE fom_edital_id = '$edital_id' AND protocolo IS NOT NULL";
        } else {
            $sql = "SELECT fp.*, fpd.instituicao, fpd.site {$campo} FROM fom_projetos fp
                LEFT JOIN fom_projeto_dado_pjs fpd ON fpd.fom_projeto_id = fp.id
                $joinPeriferias
                WHERE fom_edital_id = '$edital_id' AND protocolo IS NOT NULL";
        }

        if ($aprovados) {
            $sql .= " AND publicado = 2";
        } else{
            $sql .= " AND publicado != 0";
        }
        $queryInscritos = DbModel::consultaSimples($sql, true);
        if ($queryInscritos->rowCount() > 0) {
            return $queryInscritos->fetchAll(PDO::FETCH_OBJ);
//            foreach ($inscritos as $key => $inscrito) {
//
//            }
//            return true;
        } else {
            return false;
        }
    }

    protected function retornaInscrito($inscrito_id){
        $query = DbModel::consultaSimples('SELECT');

    }

    protected function valorDisponivel($edital_id) {
        $valorTotal = DbModel::getInfo("fom_editais", $edital_id, true)->fetchObject()->valor_edital;

        $sql = "SELECT SUM(valor_projeto) AS 'valor_aprovados' FROM fom_projetos WHERE fom_edital_id = '$edital_id' AND publicado = 2";
        $valorAprovados = DbModel::consultaSimples($sql)->fetchObject()->valor_aprovados;

        return $valorTotal - $valorAprovados;
    }

    protected function recuperaArquivosEdital($edital_id) {
        $tipoContratacao = DbModel::getInfo('fom_editais', $edital_id, true)->fetchObject()->tipo_contratacao_id;
        $queryArquivos = DbModel::consultaSimples("SELECT * FROM contratacao_documentos WHERE tipo_contratacao_id = '$tipoContratacao'");
        if ($queryArquivos->rowCount() > 0) {
            return $queryArquivos->fetchAll(PDO::FETCH_OBJ);
        } else {
            return false;
        }
    }
}