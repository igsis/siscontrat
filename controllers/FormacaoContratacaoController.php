<?php

if ($pedidoAjax) {
    require_once "../models/FormacaoModel.php";
    require_once "../controllers/PessoaFisicaController.php";
    require_once "../controllers/PedidoController.php";
} else {
    require_once "./models/FormacaoModel.php";
    require_once "./controllers/PessoaFisicaController.php";
    require_once "./controllers/PedidoController.php";
}

class FormacaoContratacaoController extends FormacaoModel
{
    public function inserir($post)
    {
        unset($post['_method']);
        $locais_id = $post['local_id'];
        unset($post['local_id']);

        $dados = MainModel::limpaPost($post);

        $insert = DbModel::insert('formacao_contratacoes', $dados);
        if ($insert->rowCount() >= 1) {
            $contratacao_id = DbModel::connection()->lastInsertId();
            if (isset($post['protocolo'])) {
                //caso seja importação do capac, pegar o protocolo ja exixtente
                $protocolo = $post['protocolo'];
            } else {
                $protocolo = MainModel::geraProtocoloEFE($contratacao_id) . '-F';
            }
            DbModel::consultaSimples("UPDATE formacao_contratacoes SET protocolo = '$protocolo' WHERE id = $contratacao_id");
            for ($i = 0; $i < count($locais_id); $i++):
                if ($locais_id[$i] > 0):
                    $array = [
                        'form_pre_pedido_id' => $contratacao_id,
                        'local_id' => $locais_id[$i]
                    ];
                    DbModel::insert('formacao_locais', $array);
                endif;
            endfor;
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Dados de contratação Cadastrados',
                'texto' => 'Dados cadastrados com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL . 'formacao/dados_contratacao_cadastro&id=' . MainModel::encryption($contratacao_id)
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

    /**
     * @throws Exception
     */
    public function editar($post)
    {
        $contratacao_id = MainModel::decryption($post['id']);
        unset($post['id']);
        unset ($post['_method']);

        $consultaLocais = DbModel::consultaSimples("SELECT * FROM formacao_locais WHERE form_pre_pedido_id = $contratacao_id")->rowCount();
        if ($consultaLocais > 0) :
            DbModel::deleteEspecial('formacao_locais', 'form_pre_pedido_id', $contratacao_id);
        endif;

        for ($i = 0; $i < count($post['local_id']); $i++):
            if ($post['local_id'][$i] > 0):
                $array = [
                    'form_pre_pedido_id' => $contratacao_id,
                    'local_id' => $post['local_id'][$i]
                ];
                DbModel::insert('formacao_locais', $array);
            endif;
        endfor;
        unset ($post['local_id']);

        $dados = MainModel::limpaPost($post);
        $update = DbModel::update('formacao_contratacoes', $dados, $contratacao_id);
        if ($update->rowCount() >= 1 || DbModel::connection()->errorCode() == 0) {
            $pedido = (new PedidoController)->existePedido(2, $contratacao_id);
            if ($pedido){
                $dadosPedido['forma_pagamento'] = (new PedidoController)->recuperaFormaPagto(2,intval($contratacao_id));
                $valor = (new FormacaoController)->recuperaDadosParcelas($contratacao_id);
                $dadosPedido['valor_total'] = $valor['valor_total'];
                DbModel::update("pedidos", $dadosPedido, $pedido->id);
            }

            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Dados de Contratação Atualizados!',
                'texto' => 'Dados atualizados com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL . 'formacao/dados_contratacao_cadastro&id=' . MainModel::encryption($contratacao_id)
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

    public function apagar($post)
    {
        $contratacao_id = MainModel::decryption($post['id']);
        unset($post['_method']);
        unset($post['id']);

        $delete = DbModel::apaga('formacao_contratacoes', $contratacao_id);
        if ($delete->rowCount() >= 1 || DbModel::connection()->errorCode() == 0) {
            $pedido = (new PedidoController)->existePedido(2, $contratacao_id);
            if ($pedido) {
                DbModel::apaga('pedidos',$pedido->id);
            }
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Dados de contratação Apagados!',
                'texto' => 'Dados apagados com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL . 'formacao/dados_contratacao_lista'
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

    /**
     * @param int|string $contratacao_id <p>id da tabela formacao_contratacoes</p>
     * @return object
     */
    public function recuperar($contratacao_id):stdClass
    {
        $contratacao_id = MainModel::decryption($contratacao_id);
        $form = DbModel::consultaSimples("SELECT fc.*, fc.id as formacao_contratacao_id, fc.pessoa_fisica_id, fs.status, t.territorio, cor.coordenadoria, s.subprefeitura, pro.programa, l.linguagem, prj.projeto, c.cargo, fis.nome_completo as fiscal_nome, fis.rf_rg as fiscal_rf, sup.nome_completo as suplente_nome, sup.rf_rg as suplente_rf, user.nome_completo as usuario_nome, rp.regiao
            FROM formacao_contratacoes AS fc
                INNER JOIN formacao_status fs on fc.form_status_id = fs.id
                INNER JOIN territorios t on fc.territorio_id = t.id
                INNER JOIN coordenadorias AS cor ON cor.id = fc.coordenadoria_id
                INNER JOIN subprefeituras s on fc.subprefeitura_id = s.id
                INNER JOIN programas AS pro ON pro.id = fc.programa_id
                INNER JOIN linguagens AS l ON l.id = fc.linguagem_id
                INNER JOIN projetos prj on fc.projeto_id = prj.id
                INNER JOIN formacao_cargos AS c ON c.id = fc.form_cargo_id
                LEFT JOIN usuarios fis on fc.fiscal_id = fis.id
                LEFT JOIN usuarios sup on fc.suplente_id = sup.id
                LEFT JOIN usuarios user on fc.usuario_id = user.id
                INNER JOIN regiao_preferencias rp on fc.regiao_preferencia_id = rp.id
                WHERE fc.id = '$contratacao_id' AND fc.publicado = 1
        ")->fetch(PDO::FETCH_ASSOC);
        $pfObj = new PessoaFisicaController();
        $idPf = $this->encryption($form['pessoa_fisica_id']);
        $pf = $pfObj->recuperaPessoaFisicaResumo($idPf);
        $contratacao = array_merge($form,(array)$pf);
        return (object)$contratacao;
    }


    public function listar($ano = 0)
    {
        $whereAno = "";
        if ($ano) {
            $whereAno = " AND c.ano = {$ano}";
        }

        $sql = "SELECT
                    c.id AS 'id',
                    c.protocolo AS 'protocolo',
                    pf.nome AS 'pessoa',
                    ns.nome_social,
                    c.ano AS 'ano',
                    p.programa AS 'programa',
                    l.linguagem AS 'linguagem',
                    fc.cargo AS 'cargo'
                FROM formacao_contratacoes AS c
                INNER JOIN pessoa_fisicas AS pf ON pf.id = c.pessoa_fisica_id
                LEFT JOIN pf_nome_social AS ns ON pf.id = ns.pessoa_fisica_id                    
                INNER JOIN programas AS p ON p.id = c.programa_id
                INNER JOIN linguagens AS l ON l.id = c.linguagem_id
                INNER JOIN formacao_cargos AS fc ON fc.id = c.form_cargo_id
                WHERE c.publicado = 1 {$whereAno}";
        return DbModel::consultaSimples($sql);
    }

    public function recuperarCapac($capac_id)
    {
        $capac_id = MainModel::decryption($capac_id);
        return DbModel::getInfo('form_cadastros', $capac_id, true)->fetchObject();
    }
}