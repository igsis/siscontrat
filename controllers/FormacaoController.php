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

    public function insereCoordenadoria($post){
        unset($post['_method']);
        $dados = MainModel::limpaPost($post);
        $insert = DbModel::insert('coordenadorias', $dados, false);
        if ($insert->rowCount() >= 1) {
            $coordenadoria_id = DbModel::connection(true)->lastInsertId();
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Coordenadoria Cadastrada!',
                'texto' => 'Dados cadastrados com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL . 'formacao/coordenadoria_cadastro&id=' . MainModel::encryption($coordenadoria_id)
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

    public function recuperaCoordenadoria($coordenadoria_id) {
        $coordenadoria_id = MainModel::decryption($coordenadoria_id);
        return DbModel::getInfo('coordenadorias', $coordenadoria_id, false)->fetchObject();
    }


    public function editaCoordenadoria($post)
    {
        $coordenadoria_id = MainModel::decryption($post['id']);
        unset($post['id']);
        unset ($post['_method']);
        $dados = MainModel::limpaPost($post);
        $update = DbModel::update('coordenadorias', $dados, $coordenadoria_id, false);
        if ($update->rowCount() >= 1 || DbModel::connection()->errorCode() == 0) {
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Coordenadoria Atualizada!',
                'texto' => 'Dados atualizados com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL . 'formacao/coordenadoria_cadastro&id=' . MainModel::encryption($coordenadoria_id)
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

    public function apagaCoordenadoria($id)
    {
        $id = MainModel::decryption($id['id']);
        $apaga = DbModel::apaga("coordenadorias", $id, false);
        if ($apaga){
                $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Coordenadoria Deletada!',
                'texto' => 'Dados atualizados com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL.'formacao/coordenadoria_lista'
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

    public function listaProgramas()
    {
        return parent::getProgramas();
    }

    public function listaVerbas()
    {
        return parent::getVerbas();
    }


    public function recuperaPrograma($programa_id) {
        $programa_id = MainModel::decryption($programa_id);
        return DbModel::getInfo('programas', $programa_id, false)->fetchObject();
    }

    public function inserePrograma($post){
        unset($post['_method']);
        $dados = MainModel::limpaPost($post);
        $insert = DbModel::insert('programas', $dados, false);
        if ($insert->rowCount() >= 1) {
            $programa_id = DbModel::connection(true)->lastInsertId();
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Programa Cadastrado!',
                'texto' => 'Dados cadastrados com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL . 'formacao/programa_cadastro&id=' . MainModel::encryption($programa_id)
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


    public function editaPrograma($id)
    {
        $programa_id = MainModel::decryption($post['id']);
        unset($post['id']);
        unset ($post['_method']);
        $dados = MainModel::limpaPost($post);
        $update = DbModel::update('programas', $dados, $programa_id, false);
        if ($update->rowCount() >= 1 || DbModel::connection()->errorCode() == 0) {
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Programa Atualizado!',
                'texto' => 'Dados atualizados com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL . 'formacao/programa_cadastro&id=' . MainModel::encryption($programa_id)
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

    public function apagaPrograma($id)
    {
        $id = MainModel::decryption($id['id']);
        $apaga = DbModel::apaga("programas", $id, false);
        if ($apaga){
                $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Programa Deletado!',
                'texto' => 'Dados atualizados com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL.'formacao/programa_lista'
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

    public function listaLinguagens()
    {
        return parent::getLinguagens();
    }

    public function recuperaLinguagem($linguagem_id) {
        $linguagem_id = MainModel::decryption($linguagem_id);
        return DbModel::getInfo('linguagens', $linguagem_id, false)->fetchObject();
    }

    public function insereLinguagem($post){
        unset($post['_method']);
        $dados = MainModel::limpaPost($post);
        $insert = DbModel::insert('linguagens', $dados, false);
        if ($insert->rowCount() >= 1) {
            $linguagem_id = DbModel::connection(true)->lastInsertId();
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Linguagem Cadastrada!',
                'texto' => 'Dados cadastrados com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL . 'formacao/linguagem_cadastro&id=' . MainModel::encryption($linguagem_id)
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

    public function editaLinguagem($post)
    {
        $linguagem_id = MainModel::decryption($post['id']);
        unset($post['id']);
        unset ($post['_method']);
        $dados = MainModel::limpaPost($post);
        $update = DbModel::update('linguagens', $dados, $linguagem_id, false);
        if ($update->rowCount() >= 1 || DbModel::connection()->errorCode() == 0) {
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Linguagem Atualizada!',
                'texto' => 'Dados atualizados com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL . 'formacao/linguagem_cadastro&id=' . MainModel::encryption($linguagem_id)
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

    public function apagaLinguagem($id)
    {
        $id = MainModel::decryption($id['id']);
        $apaga = DbModel::apaga("linguagens", $id, false);
        if ($apaga){
                $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Linguagem Deletada!',
                'texto' => 'Dados atualizados com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL.'formacao/linguagem_lista'
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