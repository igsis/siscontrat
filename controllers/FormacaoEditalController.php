<?php

if ($pedidoAjax) {
    require_once "../models/FormacaoModel.php";
    require_once "../controllers/PessoaFisicaController.php";
} else {
    require_once "./models/FormacaoModel.php";
    require_once "./controllers/PessoaFisicaController.php";
}

class FormacaoEditalController extends FormacaoModel
{
    public function inserir($post)
    {
        $dados = [];
        unset($post['_method']);

        $dados = MainModel::limpaPost($post);

        //validação para forçar null em campos vazios
        if ($dados['ano_referencia'] == "")
            $dados['ano_referencia'] = null;

        if ($dados['data_abertura'] != "")
            $dados['data_abertura'] = MainModel::dataHoraParaSQL($dados['data_abertura']);
        else
            $dados['data_abertura'] = null;

        if ($dados['data_encerramento'] != "")
            $dados['data_encerramento'] = MainModel::dataHoraParaSQL($dados['data_encerramento']);
        else
            $dados['data_encerramento'] = null;

        $insere = DbModel::insert("form_aberturas", $dados, true);

        if ($insere || DbModel::connection()->errorCode() == 0) {
            $abertura_id = $this->encryption(DbModel::connection()->lastInsertId());
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Abertura',
                'texto' => 'Cadastro realizado com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL . 'formacao/abertura_cadastro&id=' . $abertura_id
            ];
        } else {
            $alerta = [
                'alerta' => 'simples',
                'titulo' => 'Erro!',
                'texto' => 'Erro ao salvar!',
                'tipo' => 'error',
                'location' => SERVERURL . 'formacao/abertura_cadastro'
            ];
        }
        return MainModel::sweetAlert($alerta);
    }

    public function editar($post)
    {
        $id = MainModel::decryption($post['id']);
        $dados = [];
        unset($post['_method']);
        unset($post['id']);

        $dados = MainModel::limpaPost($post);

        //validação para forçar null em campos vazios
        if ($dados['ano_referencia'] == "")
            $dados['ano_referencia'] = null;

        if ($dados['data_abertura'] != "")
            $dados['data_abertura'] = MainModel::dataHoraParaSQL($dados['data_abertura']);
        else
            $dados['data_abertura'] = null;

        if ($dados['data_encerramento'] != "")
            $dados['data_encerramento'] = MainModel::dataHoraParaSQL($dados['data_encerramento']);
        else
            $dados['data_encerramento'] = null;

        $edita = $this->update("form_aberturas", $dados, $id, true);

        if ($edita || DbModel::connection()->errorCode() == 0) {
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Abertura',
                'texto' => 'Alteração realizada com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL . 'formacao/abertura_cadastro&id=' . MainModel::encryption($id)
            ];
        } else {
            $alerta = [
                'alerta' => 'simples',
                'titulo' => 'Erro!',
                'texto' => 'Erro ao salvar!',
                'tipo' => 'error',
                'location' => SERVERURL . 'formacao/abertura_cadastro' . MainModel::encryption($id)
            ];
        }

        return MainModel::sweetAlert($alerta);
    }

    public function apagar($post)
    {
        $id = MainModel::decryption($post['id']);
        $apaga = DbModel::apaga("form_aberturas", $id, true);
        if ($apaga || DbModel::connection()->errorCode() == 0) {
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Abertura Deletada!',
                'texto' => 'Dados atualizados com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL . 'formacao/abertura_lista'
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

    public function recuperar($id)
    {
        $id = MainModel::decryption($id);
        return DbModel::getInfo('form_aberturas', $id, true)->fetchObject();
    }

    public function listar()
    {
        return DbModel::listaPublicado("form_aberturas", null, true);
    }
}