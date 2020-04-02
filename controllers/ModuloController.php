<?php
if ($pedidoAjax) {
    require_once "../models/ModuloModel.php";
} else {
    require_once "./models/ModuloModel.php";
}


class ModuloController extends ModuloModel{
    
    public function insereModulo($post){
        unset($post['_method']);
        $dados = MainModel::limpaPost($post);
        $insert = DbModel::insert('modulos', $dados, false);
        if ($insert->rowCount() >= 1) {
            $modulo_id = DbModel::connection(true)->lastInsertId();
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Edital Cadastrado!',
                'texto' => 'Dados cadastrados com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL . 'administrativo/cadastrar_modulo&id=' . MainModel::encryption($modulo_id)
            ];
        } else {
            $alerta = [
                'alerta' => 'simples',
                'titulo' => 'Oops! Algo deu Errado!',
                'texto' => 'Falha ao salvar os dados no servidor, tente novamente mais tarde',
                'tipo' => 'error',
            ];
        }
        return MainModel::sweetAlert($alerta);
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

    public function recuperaModulo($modulo_id) {
        $modulo_id = MainModel::decryption($modulo_id);
        return DbModel::getInfo('modulos', $modulo_id, false)->fetchObject();
    }

    public function editaModulo($post) {
        $modulo_id = MainModel::decryption($post['id']);
        unset($post['id']);
        unset ($post['_method']);
        $dados = MainModel::limpaPost($post);
        $update = DbModel::update('modulos', $dados, $modulo_id, false);
        if ($update->rowCount() >= 1 || DbModel::connection()->errorCode() == 0) {
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Edital Atualizado!',
                'texto' => 'Dados atualizados com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL . 'administrativo/cadastrar_modulo&id=' . MainModel::encryption($modulo_id)
            ];
        } else {
            $alerta = [
                'alerta' => 'simples',
                'titulo' => 'Oops! Algo deu Errado!',
                'texto' => 'Falha ao salvar os dados no servidor, tente novamente mais tarde',
                'tipo' => 'error',
            ];
        }
        return MainModel::sweetAlert($alerta);
    }
    
}