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

    protected function getCoordenadorias() {
        return DbModel::consultaSimples("SELECT * FROM coordenadorias where publicado = 1")->fetchAll(PDO::FETCH_OBJ);
    }

    protected function getProgramas() {
        return DbModel::consultaSimples("SELECT * FROM programas where publicado = 1")->fetchAll(PDO::FETCH_OBJ);
    }

    protected function getLinguagens() {
        return DbModel::consultaSimples("SELECT * FROM linguagens where publicado = 1")->fetchAll(PDO::FETCH_OBJ);
    }

    protected function getProjetos() {
        return DbModel::consultaSimples("SELECT * FROM projetos where publicado = 1")->fetchAll(PDO::FETCH_OBJ);
    }
    protected function getSubprefeituras() {
        return DbModel::consultaSimples("SELECT * FROM subprefeituras where publicado = 1")->fetchAll(PDO::FETCH_OBJ);
    }
    protected function getTerritorios() {
        return DbModel::consultaSimples("SELECT * FROM territorios where publicado = 1")->fetchAll(PDO::FETCH_OBJ);
    }
}

