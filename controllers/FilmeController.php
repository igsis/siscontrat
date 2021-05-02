<?php
if ($pedidoAjax) {
    require_once "../models/MainModel.php";
} else {
    require_once "./models/MainModel.php";
}

class FilmeController extends MainModel
{
    public function recuperaFilme($idEvento)
    {
        return DbModel::consultaSimples("SELECT * FROM filme_eventos fe INNER JOIN filmes f on fe.filme_id = f.id WHERE evento_id = '$idEvento'")->fetchAll(PDO::FETCH_OBJ);
    }
}