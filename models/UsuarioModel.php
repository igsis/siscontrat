<?php
if ($pedidoAjax) {
    require_once "../models/MainModel.php";
} else {
    require_once "./models/MainModel.php";
}

class UsuarioModel extends MainModel
{
    protected function getUsuario($dados) {
        $pdo = parent::connection();
        $sql = "SELECT * FROM usuarios WHERE usuario = :usuario AND senha = :senha";
        $statement = $pdo->prepare($sql);
        $statement->bindParam(":usuario", $dados['usuario']);
        $statement->bindParam(":senha", $dados['senha']);
        $statement->execute();
        return $statement;
    }

    protected function getEmail($dados) {
        $pdo = parent::connection();
        $sql = "SELECT * FROM usuarios WHERE email = :email";
        $statement = $pdo->prepare($sql);
        $statement->bindParam(":email", $dados['email']);
        $statement->execute();
        return $statement;
    }

    protected function getPerfil($codigo) {
        $consultaPerfil = parent::consultaSimples("SELECT id FROM perfis WHERE token = '$codigo' AND publicado = 1");

        if ($consultaPerfil->rowCount() > 0) {
            return $consultaPerfil->fetchObject()->id;
        } else {
            return false;
        }
    }
}