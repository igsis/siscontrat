<?php
if ($pedidoAjax) {
    require_once "../models/MainModel.php";
} else {
    require_once "./models/MainModel.php";
}

class FilmeController extends MainModel
{
    public function listaFilme($idEvento)
    {
        $idEvento = $this->decryption($idEvento);
        return DbModel::consultaSimples("SELECT id, filme_id FROM filme_eventos WHERE evento_id = '$idEvento'")->fetchAll(PDO::FETCH_OBJ);
    }

    public function recuperaDetalheFilme($idFilme)
    {
        return DbModel::consultaSimples("SELECT titulo, genero, duracao FROM filmes WHERE id = $idFilme AND publicado = 1")->fetchObject();
    }

    public function getIdEvento($idEvento)
    {
        return $this->decryption($idEvento);
    }
}