<?php
if ($pedidoAjax) {
    require_once "../models/AdministradorModel.php";
} else {
    require_once "./models/AdministradorModel.php";
}

class AdministradorController extends AdministradorModel
{

    public function listaPerfis()
    {
        $perfis = DbModel::listaPublicado("perfis", null);
        foreach ($perfis as $key => $perfil) {
            $modelo = DbModel::getInfo('modulos', $perfil->id)->fetchObject();
            $perfis[$key]->sigla = $modelo->descricao;
        }
        return $perfis;
    }

    public function inserePerfil($post){
    unset($_POST['_method']);
    $inset = DbModel::insert('perfis',false);
    }
}