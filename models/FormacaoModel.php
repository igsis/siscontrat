<?php
if ($pedidoAjax) {
    require_once "../models/MainModel.php";
} else {
    require_once "./models/MainModel.php";
}

class FormacaoModel extends MainModel
{

    protected function getCargos() {
            return DbModel::consultaSimples("SELECT * FROM formacao_cargos where publicado = 1")->fetchAll(PDO::FETCH_OBJ);
    }

}

