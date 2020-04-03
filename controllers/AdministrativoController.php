<?php
if ($pedidoAjax) {
    require_once "../models/AdministrativoModel.php";
} else {
    require_once "./models/AdministrativoModel.php";
}

class AdministrativoController extends AdministrativoModel
{
    public function listaMural()
    {
        return parent::getAvisos();
    }

    public function recuperaAviso($id)
    {
        $id = MainModel::decryption($id);
        return DbModel::getInfo('avisos', $id)->fetchObject();
    }

    public function insereAviso($post)
    {
        unset ($post['_method']);

        $dados = MainModel::limpaPost($post);
        $dados['data'] = MainModel::dataHoraParaSQL($dados['data']);

        $insert = DbModel::insert('avisos', $dados);
        if ($insert->rowCount() >= 1) {
            $aviso_id = DbModel::connection(true)->lastInsertId();
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Aviso Cadastrado!',
                'texto' => 'Dados cadastrados com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL . 'administrativo/aviso_cadastro&id=' . MainModel::encryption($aviso_id)
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

    public function editaAviso($post)
    {
        $aviso_id = MainModel::decryption($post['id']);
        unset($post['id']);
        unset($post['_method']);

        $dados = MainModel::limpaPost($post);
        $dados['data'] = MainModel::dataHoraParaSQL($dados['data']);

        $update = DbModel::update('avisos', $dados, $aviso_id);
        if ($update->rowCount() >= 1 || DbModel::connection()->errorCode() == 0) {
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Aviso Editado!',
                'texto' => 'Dados atualizados com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL . 'administrativo/aviso_cadastro&id=' . MainModel::encryption($aviso_id)
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

    public function insereModulo($post){
        unset($post['_method']);
        $dados = MainModel::limpaPost($post);
        $insert = DbModel::insert('modulos', $dados, false);
        if ($insert->rowCount() >= 1) {
            $modulo_id = DbModel::connection(true)->lastInsertId();
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Módulo Cadastrado!',
                'texto' => 'Dados cadastrados com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL . 'administrativo/cadastrar_modulo&id=' . MainModel::encryption($modulo_id)
            }

    public function listaCategorias()
    {
        $categorias = DbModel::listaPublicado("categoria_atracoes", null, false);

        return $categorias;
    }

    public function cadastrarCategoria($post)
    {

        unset ($post['_method']);

        $dados = MainModel::limpaPost($post);

        $insert = DbModel::insert('categoria_atracoes', $dados, false);
        if ($insert->rowCount() >= 1) {
            $categoria_id = DbModel::connection()->lastInsertId();
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Categoria Cadastrada!',
                'texto' => 'Dados cadastrados com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL . 'administrativo/cadastra_categoria&id=' . MainModel::encryption($categoria_id)
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
        // foreach ($modulos as $key => $modulo) {
        //     $modulos = DbModel::getInfo('modulos', $modulo->modulo_id, false)->fetchObject();
        //     $modulos[$key]->modulos = $modulos->modulos;
        // }
        // return $modulos;
    
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
                'titulo' => 'Módulo Atualizado!',
                'texto' => 'Dados atualizados com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL . 'administrativo/cadastrar_modulo&id=' . MainModel::encryption($modulo_id)
            }
        }
    public function editarCategoria($post)
    {
        $categoria_id = MainModel::decryption($post['id']);
        unset($post['id']);
        unset ($post['_method']);

        $dados = MainModel::limpaPost($post);

        $update = DbModel::update('categoria_atracoes', $dados, $categoria_id, false);
        if ($update->rowCount() >= 1 || DbModel::connection()->errorCode() == 0) {
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Categoria Atualizada!',
                'texto' => 'Dados atualizados com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL . 'administrativo/cadastra_categoria&id=' . MainModel::encryption($categoria_id)
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

    public function deletaCategoria($post)
    {
        $categoria_id = MainModel::decryption($post['idCategoria']);
        unset($post['idCategoria']);

        $update = DbModel::apaga('categoria_atracoes', $categoria_id, false);
        if ($update->rowCount() >= 1 || DbModel::connection()->errorCode() == 0) {
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Categoria Deletada!',
                'texto' => 'Dados atualizados com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL . 'administrativo/categoria&id=' . MainModel::encryption($categoria_id)
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


    public function recuperaCategoria($categoria_id)
    {
        $categoria_id = MainModel::decryption($categoria_id);
        return DbModel::getInfo('categoria_atracoes', $categoria_id, false)->fetchObject();
    }

}