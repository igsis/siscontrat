<?php
if ($pedidoAjax) {
    require_once "../models/MainModel.php";
} else {
    require_once "./models/MainModel.php";
}

class AdministrativoModel extends MainModel
{
    protected function getAvisos() {
        return DbModel::consultaSimples("SELECT * FROM avisos WHERE publicado = 1")->fetchAll(PDO::FETCH_OBJ);
    }
    protected function getPerfil(){
        return DbModel::consultaSimples("SELECT * FROM perfis where publicado = 1")->fetchAll(PDO::FETCH_OBJ);
    }
}