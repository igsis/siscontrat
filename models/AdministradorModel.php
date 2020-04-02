<?php
if ($pedidoAjax) {
    require_once "../models/MainModel.php";
} else {
    require_once "./models/MainModel.php";
}


class AdministradorModel extends MainModel
{
    protected  function recuperaPerfis(){
    $queryPerfil = DbModel::consultaSimples("SELECT * from perfis where publicado = 1");
        if ($queryPerfil->rowCount() > 0) {
            return $queryPerfil->fetchAll(PDO::FETCH_OBJ);
//            foreach ($perfis as $key => $perfil) {

//
//            }
//            return true;
        } else {
            return false;
        }

    }


}