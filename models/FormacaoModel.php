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
        
        $sql = "SELECT p.id as id, p.programa as programa, p.verba_id , p.edital as edital, p.descricao as descricao, p.publicado, v.verba as nome_verba 
                FROM programas p
                INNER JOIN verbas v ON p.verba_id = v.id
                WHERE p.publicado = 1"
                ;
        $pdo = parent::connection();
        $statement = $pdo->prepare($sql);
        $statement->execute();
        return $statement;
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
    protected function getVigencias() {
        return DbModel::consultaSimples("SELECT * FROM formacao_vigencias where publicado = 1")->fetchAll(PDO::FETCH_OBJ);
    }

    protected function getVerbas() {
        return DbModel::consultaSimples("SELECT * FROM verbas where publicado = 1")->fetchAll(PDO::FETCH_OBJ);
    }
}

