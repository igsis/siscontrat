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

    protected function getIdModulo($dados) {
        $pdo = parent::connection();
        $sql = "SELECT * FROM modulos WHERE id = :id";
        $statement = $pdo->prepare($sql);
        $statement->bindParam(":id", $dados['id']);
        $statement->execute();
        return $statement;
    }

    protected function getSiglaModulo($dados) {
        $pdo = parent::connection();
        $sql = "SELECT * FROM modulos WHERE sigla = :sigla";
        $statement = $pdo->prepare($sql);
        $statement->bindParam(":sigla", $dados['sigla']);
        $statement->execute();
        return $statement;
    }

    protected function getDescricaoModulo($dados) {
        $pdo = parent::connection();
        $sql = "SELECT * FROM modulos WHERE descricao = :descricao";
        $statement = $pdo->prepare($sql);
        $statement->bindParam(":descricao", $dados['descricao']);
        $statement->execute();
        return $statement;
    }
}