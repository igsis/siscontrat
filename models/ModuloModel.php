<?php
if ($pedidoAjax) {
    require_once "../models/MainModel.php";
} else {
    require_once "./models/MainModel.php";
}

class ModuloModel extends MainModel
{
    protected function getId($dados) {
        $pdo = parent::connection();
        $sql = "SELECT * FROM modulos WHERE id = :id";
        $statement = $pdo->prepare($sql);
        $statement->bindParam(":id", $dados['id']);
        $statement->execute();
        return $statement;
    }

    protected function getSigla($dados) {
        $pdo = parent::connection();
        $sql = "SELECT * FROM modulos WHERE sigla = :sigla";
        $statement = $pdo->prepare($sql);
        $statement->bindParam(":sigla", $dados['sigla']);
        $statement->execute();
        return $statement;
    }

    protected function getDescricao($dados) {
        $pdo = parent::connection();
        $sql = "SELECT * FROM modulos WHERE descricao = :descricao";
        $statement = $pdo->prepare($sql);
        $statement->bindParam(":descricao", $dados['descricao']);
        $statement->execute();
        return $statement;
    }
}