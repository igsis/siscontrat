<?php

if ($pedidoAjax) {
    require_once "../models/FormacaoModel.php";
    require_once "../controllers/PessoaFisicaController.php";
} else {
    require_once "./models/FormacaoModel.php";
    require_once "./controllers/PessoaFisicaController.php";
}

class FormacaoParcelaVigenciaController extends FormacaoModel
{
    public function inserir($post)
    {
        $id = $post['id'];
        $vigencia_id = MainModel::decryption($post['id']);
        unset($post['_method']);
        unset($post['id']);
        $dados = [];

        foreach ($post as $campo => $dado) {
            foreach ($dado as $key => $valor) {
                if ($campo === "valor")
                    $dados[$key][$campo] = MainModel::dinheiroDeBr($valor);
                else
                    $dados[$key][$campo] = MainModel::limparString($valor);
            }
        }

        foreach ($dados as $key => $dado) {
            $dado['formacao_vigencia_id'] = $vigencia_id;
            $insert = DbModel::insert('formacao_parcelas', $dado);
            if ($insert->rowCount() >= 1) {
                $erro = false;
            } else {
                $erro = true;
            }
        }

        if (!$erro) {
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Parcelas Cadastradas!',
                'texto' => 'Dados cadastrados com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL . 'formacao/vigencia_cadastro&id=' . $id
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
        $vigencia_id = $post['id'];
        unset($post['_method']);
        unset($post['id']);

        $dados = [];

        foreach ($post as $campo => $dado) {
            foreach ($dado as $key => $valor) {
                if ($campo === "valor")
                    $dados[$key][$campo] = MainModel::dinheiroDeBr($valor);
                else
                    $dados[$key][$campo] = MainModel::limparString($valor);
            }
        }

        foreach ($dados as $key => $dado) {
            $id = $dado['parcela_id'];
            unset($dado['parcela_id']);
            unset($dado['numero_parcelas']);
            $update = DbModel::update('formacao_parcelas', $dado, $id);
            if ($update->rowCount() >= 1 || DbModel::connection()->errorCode() == 0) {
                $erro = false;
            } else {
                $erro = true;
            }
        }

        if (!$erro) {
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Parcelas Atualizadas!',
                'texto' => 'Parcelas atualizadas com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL . 'formacao/vigencia_cadastro&id=' . $vigencia_id
            ];
        } else {
            $alerta = [
                'alerta' => 'simples',
                'titulo' => 'Oops! Algo deu errado!',
                'texto' => 'Falha ao salvar os dados no servidor, tente novamente mais tarde',
                'tipo' => 'error'
            ];
        }
        return MainModel::sweetAlert($alerta);
    }

    public function recuperar($id_parcela_vigencia)
    {
        $parcela_id = MainModel::decryption($id_parcela_vigencia) ?? "";
        return DbModel::consultaSimples("SELECT * FROM formacao_parcelas where formacao_vigencia_id = $parcela_id")->fetchAll(PDO::FETCH_OBJ);
    }
}