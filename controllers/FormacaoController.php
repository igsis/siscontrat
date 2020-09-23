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

    public function insereCargo($post){
        unset($post['_method']);
        $dados = MainModel::limpaPost($post);
        $insert = DbModel::insert('formacao_cargos', $dados, false);
        if ($insert->rowCount() >= 1) {
            $cargo_id = DbModel::connection(true)->lastInsertId();
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Cargo Cadastrado!',
                'texto' => 'Dados cadastrados com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL . 'formacao/cargo_cadastro&id=' . MainModel::encryption($cargo_id)
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

    public function recuperaCargo($cargo_id) {
        $cargo_id = MainModel::decryption($cargo_id);
        return DbModel::getInfo('formacao_cargos', $cargo_id, false)->fetchObject();
    }

    public function editaCargo($post)
    {
        $cargo_id = MainModel::decryption($post['id']);
        unset($post['id']);
        unset ($post['_method']);
        $dados = MainModel::limpaPost($post);
        $update = DbModel::update('formacao_cargos', $dados, $cargo_id, false);
        if ($update->rowCount() >= 1 || DbModel::connection()->errorCode() == 0) {
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Cargo Atualizado!',
                'texto' => 'Dados atualizados com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL . 'formacao/cargo_cadastro&id=' . MainModel::encryption($cargo_id)
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

    public function apagaCargo($id)
    {
        $id = MainModel::decryption($id['id']);
        $apaga = DbModel::apaga("formacao_cargos", $id, false);
        if ($apaga){
                $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Cargo Deletado!',
                'texto' => 'Dados atualizados com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL.'formacao/cargo_lista'
                ];
        }else {
            $alerta = [
                'alerta' => 'simples',
                'titulo' => 'Oops! Algo deu Errado!',
                'texto' => 'Falha ao apagar os dados no servidor, tente novamente mais tarde',
                'tipo' => 'error',
            ];
        }
        return MainModel::sweetAlert($alerta);
    
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

    public function listaSubprefeituras()
    {
        return parent::getSubprefeituras();
    }

    public function listaTerritorios()
    {
        return parent::getTerritorios();
    }
    
    public function editaTerritorio($id)
    {
        //
    }
    
    public function apagaTerritorio($id)
    {
        //
    }

    public function listaVigencias()
    {
        return parent::getVigencias();
    }
}