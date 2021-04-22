<?php

if ($pedidoAjax) {
    require_once "../models/FormacaoModel.php";
    require_once "../controllers/PessoaFisicaController.php";
} else {
    require_once "./models/FormacaoModel.php";
    require_once "./controllers/PessoaFisicaController.php";
}

class FormacaoNotaEmpenhoController extends FormacaoModel
{
    public function inserir($post)
    {
        unset($post['_method']);
        $post['pedido_id'] = MainModel::decryption($post['pedido_id']);
        $dados = MainModel::limpaPost($post);

        $insert = DbModel::insert('pagamentos', $dados);
        if ($insert->rowCount() >= 1) {
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Nota de Empenho Cadastrada!',
                'texto' => 'Dados cadastrados com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL . 'formacao/empenho_cadastro&id=' . MainModel::encryption($post['pedido_id'])
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
        unset($post['_method']);
        $pedido_id = MainModel::decryption($post['pedido_id']);
        $post['pedido_id'] = $pedido_id;
        $dados = MainModel::limpaPost($post);

        $update = DbModel::updateEspecial('pagamentos', $dados, "pedido_id", $pedido_id);

        if ($update || DbModel::connection()->errorCode() == 0) {
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Nota de Empenho',
                'texto' => 'Alteração realizada com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL . 'formacao/empenho_cadastro&id=' . MainModel::encryption($pedido_id)
            ];
        } else {
            $alerta = [
                'alerta' => 'simples',
                'titulo' => 'Erro!',
                'texto' => 'Erro ao salvar!',
                'tipo' => 'error',
                'location' => SERVERURL . 'formacao/empenho_cadastro&id=' . MainModel::encryption($pedido_id)
            ];
        }

        return MainModel::sweetAlert($alerta);
    }



    public function pesquisar($post, $where)
    {
        $sqlProtocolo = "";
        $sqlProponente = "";
        $sqlProcesso = "";
        $sqlStatus = "";

        if ($where == "protocolo") {
            $protocolo = $post;
            $sqlProtocolo = " AND fc.protocolo LIKE '%$protocolo%'";
        }

        if ($where == "proponente") {
            $proponente = $post;
            $sqlProponente = " AND p.pessoa_fisica_id = '$proponente'";
        }
        if ($where == "processo") {
            $processo = $post;
            $sqlProcesso = " AND p.numero_processo LIKE '%$processo%'";
        }
        if ($where == "status") {
            $status = $post;
            $sqlStatus = " AND p.status_pedido_id = '$status'";
        }


        $consulta = DbModel::consultaSimples("SELECT p.id AS pedido_id, fc.protocolo, pf.nome, ns.nome_social, p.numero_processo, s.status 
                                                  FROM formacao_contratacoes fc 
                                                  INNER JOIN pedidos p ON fc.id = p.origem_id
                                                  LEFT JOIN pessoa_fisicas pf ON p.pessoa_fisica_id = pf.id
                                                  LEFT JOIN pf_nome_social ns ON ns.pessoa_fisica_id = pf.id
                                                  INNER JOIN pedido_status s ON s.id = p.status_pedido_id
                                                  WHERE p.origem_tipo_id = 2 AND p.publicado = 1$sqlProponente $sqlProcesso $sqlProtocolo $sqlStatus")->fetchAll(PDO::FETCH_ASSOC);
        if (count($consulta) > 0) {
            for ($i = 0; $i < count($consulta); $i++) {
                $consulta[$i]['pedido_id'] = MainModel::encryption($consulta[$i]['pedido_id']);
            }
            return json_encode(array($consulta));
        }

        return '0';
    }

    public function recuperar($pedido_id)
    {
        $pedido_id = MainModel::decryption($pedido_id);
        return DbModel::consultaSimples("SELECT nota_empenho, emissao_nota_empenho, entrega_nota_empenho FROM pagamentos WHERE pedido_id = $pedido_id")->fetchObject();
    }
}