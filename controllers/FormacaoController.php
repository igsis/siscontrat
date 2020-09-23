<?php
if ($pedidoAjax) {
    require_once "../models/FormacaoModel.php";
} else {
    require_once "./models/FormacaoModel.php";
}

class FormacaoController extends FormacaoModel
{
    public function listaCargos()
    {
        return parent::getCargos();
    }

    public function editaCargo($id)
    {
        //
    }

    public function apagaCargo($id)
    {

    }

    public function listaCoordenadorias()
    {
        return parent::getCoordenadorias();
    }

    public function editaCoordenadoria($id)
    {
        //
    }

    public function apagaCoordenadoria($id)
    {
        //
    }

    public function listaProgramas()
    {
        return parent::getProgramas();
    }

    public function editaPrograma($id)
    {
        //
    }

    public function apagaPrograma($id)
    {
        //
    }

    public function listaLinguagens()
    {
        return parent::getLinguagens();
    }

    public function editaLinguagem($id)
    {
        //
    }

    public function apagaLinguagem($id)
    {
        //
    }

    public function listaProjetos()
    {
        return parent::getProjetos();
    }

    public function editaProjeto($id)
    {
        //
    }

    public function apagaProjeto($id)
    {
        //
    }

    public function listaTerritorios()
    {
        //
    }
    
    public function editaTerritorio($id)
    {
        //
    }
    
    public function apagaTerritorio($id)
    {
        //
    }
}