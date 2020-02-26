<?php
if ($pedidoAjax) {
    require_once "../models/MainModel.php";
} else {
    require_once "./models/MainModel.php";
}

class FomentoModel extends MainModel
{
    protected function recuperaInscritos($edital_id) {
        $queryInscritos = DbModel::consultaSimples("SELECT * FROM fom_projetos WHERE fom_edital_id = '$edital_id'", true);
        if ($queryInscritos->rowCount() > 0) {
            $inscritos = $queryInscritos->fetchAll(PDO::FETCH_OBJ);
            foreach ($inscritos as $key => $inscrito) {
                
            }
            return true;
        } else {
            return false;
        }
    }
}