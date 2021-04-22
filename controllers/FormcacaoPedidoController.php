<?php

if ($pedidoAjax) {
    require_once "../models/FormacaoModel.php";
    require_once "../controllers/PessoaFisicaController.php";
} else {
    require_once "./models/FormacaoModel.php";
    require_once "./controllers/PessoaFisicaController.php";
}

class FormcacaoPedidoController extends FormacaoModel
{
    public function inserir($post)
    {
        unset($post['_method']);

        $dadosParcelas = DbModel::consultaSimples("SELECT fp.* FROM formacao_parcelas AS fp INNER JOIN formacao_contratacoes AS fc ON fc.form_vigencia_id = fp.formacao_vigencia_id WHERE fp.publicado = 1 AND fc.id = " . $post['origem_id'])->fetchAll(PDO::FETCH_OBJ);
        $formaCompleta = "";
        for ($i = 0; $i < count($dadosParcelas); $i++) :
            $forma = $i + 1 . "º parcela R$ " . MainModel::dinheiroParaBr($dadosParcelas[$i]->valor) . ". Entrega de documentos a partir de " . MainModel::dataParaBR($dadosParcelas[$i]->data_pagamento) . ".\n";
            $formaCompleta = $formaCompleta . $forma;
        endfor;
        $formaCompleta = $formaCompleta . "\nA liquidação de cada parcela se dará em 3 (três) dias úteis após a data de confirmação da correta execução do(s) serviço(s).";

        if (isset($post['valor_total'])) {
            $post['valor_total'] = MainModel::dinheiroDeBr($post['valor_total']);
        }

        $dados = MainModel::limpaPost($post);

        $insert = DbModel::insert('pedidos', $dados);
        if ($insert->rowCount() >= 1) {
            $pedido_id = DbModel::connection()->lastInsertId();
            DbModel::consultaSimples("UPDATE formacao_contratacoes SET pedido_id = '$pedido_id' WHERE publicado = 1 AND id = " . $dados['origem_id']);
            DbModel::consultaSimples("UPDATE pedidos SET forma_pagamento = '$formaCompleta' WHERE id = $pedido_id AND origem_tipo_id = 2");
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Pedido Cadastrado',
                'texto' => 'Dados cadastrados com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL . 'formacao/pedido_contratacao_cadastro&pedido_id=' . MainModel::encryption($pedido_id)
            ];
        } else {
            $alerta = [
                'Alerta' => 'simples',
                'titulo' => 'Oops! Algo deu errado!',
                'texto' => 'Falha ao salvar os dados no servidor, tente novamente mais tarde.',
                'tipo' => 'error'
            ];
        }
        return MainModel::sweetAlert($alerta);
    }

    public function editar($post)
    {
        $pedido_id = MainModel::decryption($post['id']);
        unset($post['_method']);
        unset($post['id']);

        if (isset($post['valor_total'])) {
            $post['valor_total'] = MainModel::dinheiroDeBr($post['valor_total']);
        }
        $dados = MainModel::limpaPost($post);
        $update = DbModel::update('pedidos', $dados, $pedido_id);
        if ($update->rowCount() >= 1 || DbModel::connection()->errorCode() == 0) {
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Pedido Atualizado',
                'texto' => 'Dados atualizados com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL . 'formacao/pedido_contratacao_cadastro&pedido_id=' . MainModel::encryption($pedido_id)
            ];
        } else {
            $alerta = [
                'alerta' => 'simples',
                'titulo' => 'Oops! Algo deu errado!',
                'texto' => 'Falha ao salvar os dados no servidor, tente novamente mais tarde',
                'tipo' => 'error',
            ];
        }
        return MainModel::sweetAlert($alerta);
    }

    public function apagar($post)
    {
        unset($post['_method']);
        $pedido_id = MainModel::decryption($post['id']);
        unset($post['id']);
        $delete = DbModel::apaga('pedidos', $pedido_id);
        if ($delete->rowCount() >= 1 || DbModel::connection()->errorCode() == 0) {
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Pedido Apagado!',
                'texto' => 'Pedido apagado com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL . 'formacao/pedido_contratacao_lista'
            ];
        } else {
            $alerta = [
                'alerta' => 'simples',
                'titulo' => 'Oops! Algo deu errado!',
                'texto' => 'Falha ao salvar os dados no servidos, tente novamente mais tarde',
                'tipo' => 'error'
            ];
        }
        return MainModel::sweetAlert($alerta);
    }

    public function concluir($post)
    {
        unset($post['_method']);
        $pedido_id = MainModel::decryption($post['id']);
        unset($post['id']);
        $update = DbModel::consultaSimples("UPDATE pedidos SET status_pedido_id = 21 WHERE id = $pedido_id AND origem_tipo_id = 2 AND publicado = 1");
        if ($update->rowCount() >= 1 || DbModel::connection()->errorCode() == 0) {
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Pedido Concluído!',
                'texto' => 'Pedido concluído com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL . 'formacao/conclusao_busca'
            ];
        } else {
            $alerta = [
                'alerta' => 'simples',
                'titulo' => 'Oops! Algo deu errado!',
                'texto' => 'Falha ao salvar os dados no servidos, tente novamente mais tarde',
                'tipo' => 'error'
            ];
        }
        return MainModel::sweetAlert($alerta);
    }

    public function recuperar($contratacao_id)
    {
        $contratacao_id = MainModel::decryption($contratacao_id);
        $testaPedido = DbModel::consultaSimples("SELECT id FROM pedidos WHERE origem_id = $contratacao_id AND publicado = 1 AND origem_tipo_id = 2")->rowCount();
        $consulta = $testaPedido > 0;
        return $consulta;
    }
}