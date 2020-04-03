<?php
if ($pedidoAjax) {
    require_once "../models/AdministrativoModel.php";
} else {
    require_once "./models/AdministrativoModel.php";
}

class AdministrativoController extends AdministrativoModel
{
    public function listaMural() {
        return parent::getAvisos();
    }

    public function recuperaAviso($id){
        $id = MainModel::decryption($id);
        return DbModel::getInfo('avisos', $id)->fetchObject();
    }

    public function insereAviso($post) {
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

    public function editaAviso($post) {
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

    public function listaInstituicoes()
    {
        $instituicoes = DbModel::consultaSimples("
            SELECT * FROM instituicoes ")->fetchAll(PDO::FETCH_OBJ);
        return $instituicoes;
    }

    public function recuperaInstituicao($instituicao_id)
    {
        $instituicao_id = MainModel::decryption($instituicao_id);
        return DbModel::getInfo('instituicoes', $instituicao_id, false)->fetchObject();
    }

    public function insereInstituicao($post)
    {
        unset ($post['_method']);
        $dados = MainModel::limpaPost($post);
        $insert = DbModel::insert('instituicoes', $dados, false);
        if ($insert) {
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Instituição Inserido!',
                'texto' => 'Dados inseridos com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL . 'administrativo/instituicoes'
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

    public function editaInstituicao($post)
    {
        unset ($post['_method']);
        $id = MainModel::decryption($post['id']);
        $dados = MainModel::limpaPost($post);
        $dados['id'] = $id;
        $update = DbModel::update('instituicoes', $dados, $id, false);
        if ($update) {
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Instituição Editada!',
                'texto' => 'Dados editados com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL . 'administrativo/instituicoes'
            ];
        } else {
            $alerta = [
                'alerta' => 'simples',
                'titulo' => 'Oops! Algo deu Errado!',
                'texto' => 'Falha ao editar os dados no servidor, tente novamente mais tarde',
                'tipo' => 'error',
            ];
        }

        return MainModel::sweetAlert($alerta);
    }
}