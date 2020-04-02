<?php

if ($pedidoAjax) {
    require_once "../models/CategoriaModel.php";
} else {
    require_once "./models/CategoriaModel.php";
}

    class CategoriaController extends CategoriaModel{
        public function listaCategorias(){
            $categorias = DbModel::listaPublicado("categoria_atracoes", null, false);
            
            return $categorias;
        }

        public function cadastrarCategoria(){

            unset ($post['_method']);

        $dados = MainModel::limpaPost($post);

        $dado = MainModel::limparString(['categoria_atracao']);

            $insert = DbModel::insert('categoria_atracoes', $dados, false);
            if ($insert->rowCount() >= 1) {
                $categoria_id = DbModel::connection(true)->lastInsertId();
                $alerta = [
                    'alerta' => 'sucesso',
                    'titulo' => 'Categoria Cadastrada!',
                    'texto' => 'Dados cadastrados com sucesso!',
                    'tipo' => 'success',
                    'location' => SERVERURL . 'administrativo/categoria_cadastro&id=' . MainModel::encryption($categoria_id)
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

        public function editarCategoria($post) {
            $categoria_id = MainModel::decryption($post['id']);
            unset($post['id']);
            unset ($post['_method']);
    
            $dados = MainModel::limpaPost($post);
    
            $dado = MainModel::limparString(['categoria_atracao']);
    
            $update = DbModel::update('categoria_atracoes', $dados, $categoria_id, false);
            if ($update->rowCount() >= 1 || DbModel::connection()->errorCode() == 0) {
                $alerta = [
                    'alerta' => 'sucesso',
                    'titulo' => 'Categoria Atualizada!',
                    'texto' => 'Dados atualizados com sucesso!',
                    'tipo' => 'success',
                    'location' => SERVERURL . 'administrativo/categoria_cadastro&id=' . MainModel::encryption($categoria_id)
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

        public function recuperaCategoria($categoria_id) {
            $categoria_id = MainModel::decryption($categoria_id);
            return DbModel::getInfo('categoria_atracoes', $categoria_id, false)->fetchObject();
        }


    }
    
?>