<?php

if ($pedidoAjax) {
    require_once "../models/InstituicaoModel.php";
} else {
    require_once "./models/InstituicaoModel.php";
}

class InstituicaoController extends InstituicaoModel
{
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

    public function editaInstituicao($post, $id)
    {
        unset ($post['_method']);
        $id = MainModel::decryption($id);
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
?>