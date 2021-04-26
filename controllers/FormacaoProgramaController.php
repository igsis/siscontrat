<?php

if ($pedidoAjax) {
    require_once "../models/FormacaoModel.php";
    require_once "../controllers/PessoaFisicaController.php";
} else {
    require_once "./models/FormacaoModel.php";
    require_once "./controllers/PessoaFisicaController.php";
}

class FormacaoProgramaController extends FormacaoModel
{
    public function inserir($post)
    {
        unset($post['_method']);
        $dados = MainModel::limpaPost($post);
        $insert = DbModel::insert('programas', $dados);
        if ($insert->rowCount() >= 1) {
            $programa_id = DbModel::connection()->lastInsertId();
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

    public function editar($post)
    {
        $programa_id = MainModel::decryption($post['id']);
        unset($post['id']);
        unset ($post['_method']);
        $dados = MainModel::limpaPost($post);
        $update = DbModel::update('programas', $dados, $programa_id);
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

    public function apagar($id)
    {
        $id = MainModel::decryption($id['id']);
        $apaga = DbModel::apaga("programas", $id);
        if ($apaga) {
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Programa Deletado!',
                'texto' => 'Dados atualizados com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL . 'formacao/programa_lista'
            ];
        } else {
            $alerta = [
                'alerta' => 'simples',
                'titulo' => 'Oops! Algo deu Errado!',
                'texto' => 'Falha ao apagar os dados no servidor, tente novamente mais tarde',
                'tipo' => 'error',
            ];
        }
        return MainModel::sweetAlert($alerta);
    }

    public function recuperaPrograma($programa_id)
    {
        $programa_id = MainModel::decryption($programa_id);
        return DbModel::getInfo('programas', $programa_id)->fetchObject();
    }

    public function listar()
    {
        return DbModel::consultaSimples(
            "SELECT p.id as id, p.programa as programa, p.verba_id as verba_id, p.edital as edital, p.descricao as descricao, p.publicado, v.verba as nome_verba 
                    FROM programas p
                    INNER JOIN verbas v ON p.verba_id = v.id
                    WHERE p.publicado = 1");
    }
}