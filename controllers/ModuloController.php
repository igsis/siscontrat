<?php
if ($pedidoAjax) {
    require_once "../models/ModuloModel.php";
} else {
    require_once "./models/ModuloModel.php";
}


class ModuloController extends ModuloModel{
    
    public function insereModulo($post){
        unset($post['_method']);
        $dadosModulo = [];
        $insere = DbModel::insert('modulos', $dadosModulo);
    }

    public function listaModulo(){
        $pdo = self::connection($capac=false);
        $sql = "SELECT * FROM modulos";
        $statement = $pdo->query($sql);
        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_OBJ);
        foreach ($modulos as $key => $modulo) {
            $modulos = DbModel::getInfo('modulos', $modulo->modulo_id, false)->fetchObject();
            $modulos[$key]->modulos = $modulos->modulos;
        }
        return $modulos;
    
    }
}