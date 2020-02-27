<?php
if ($pedidoAjax) {
    require_once "../models/MainModel.php";
} else {
    require_once "./models/MainModel.php";
}

class FomentoModel extends MainModel
{
    protected function recuperaInscritos($edital_id) {
        $queryInscritos = DbModel::consultaSimples("SELECT * FROM fom_projetos WHERE fom_edital_id = '$edital_id' AND protocolo IS NOT NULL", true);
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
}