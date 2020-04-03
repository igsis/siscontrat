<?php
if ($pedidoAjax) {
    require_once "../models/AdministradorModel.php";
} else {
    require_once "./models/AdministradorModel.php";
}

class AdministradorController extends AdministradorModel
{
    /**
     * <p>Retorna todos os perfis cadastrados no sistema siscontrat <3 </p>
     * @return array
     */
    public function listaPerfis()
    {
        $perfis = DbModel::listaPublicado("perfis",null);
        foreach ($perfis as $key => $perfil){
            $modelo = DbModel::getInfo('modulos',$perfil->id)->fetchObject();
            $perfis[$key]->sigla = $modelo ->descricao;
        }
        return $perfis;
    }
}