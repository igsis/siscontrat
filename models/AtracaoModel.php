<?php
if ($pedidoAjax) {
    require_once "../models/ValidacaoModel.php";
    require_once "../controllers/PessoaFisicaController.php";
} else {
    require_once "./models/ValidacaoModel.php";
    require_once "./controllers/PessoaFisicaController.php";
}

class AtracaoModel extends ValidacaoModel
{
    protected function validaProdutor($produtor_id, $nomeAtracao) {
        $naoObrigatorios = [
            'telefone2',
            'observacao'
        ];

        $produtor = DbModel::consultaSimples("SELECT * FROM produtores WHERE id = '$produtor_id'")->fetchObject();

        foreach ($produtor as $coluna => $valor) {
            if (!in_array($coluna, $naoObrigatorios)) {
                if ($valor == "") {
                    $erros[$coluna]['bol'] = true;
                    $erros[$coluna]['motivo'] = "Campo " . $coluna . " do produtor não preechido";
                }
            }
        }

        if (isset($erros)) {
            return $erros;
        } else {
            return false;
        }
    }

    protected function validaAtracaoModel($evento_id) {
        $naoObrigatorios = [
            'links'
        ];

        $atracoes = DbModel::consultaSimples("SELECT * FROM atracoes WHERE evento_id = '$evento_id'")->fetchAll(PDO::FETCH_OBJ);

        foreach ($atracoes as $atracao) {
            $nomeAtracao = $atracao->nome_atracao;

            $erros[$nomeAtracao] = ValidacaoModel::retornaMensagem($atracao, $naoObrigatorios);

            if ($atracao->produtor_id != null) {
                $produtor = AtracaoModel::validaProdutor($atracao->produtor_id, $nomeAtracao);
                if ($produtor) {
                    $erros[$nomeAtracao]['produtor'] = $produtor;
                }
            }

            $pedido = DbModel::consultaSimples("SELECT pessoa_tipo_id FROM pedidos WHERE origem_tipo_id = '1' AND origem_id = '$evento_id'");
            if ($pedido->rowCount() > 0 && $pedido->fetch()['pessoa_tipo_id'] == 2) {
                $lider = DbModel::consultaSimples("SELECT * FROM lideres WHERE atracao_id = '$atracao->id'");
                if ($lider->rowCount() == 0) {
                    $erros[$nomeAtracao]['lider']['bol'] = true;
                    $erros[$nomeAtracao]['lider']['motivo'] = 'Atração não possui Líder cadastrado';
                } else {
                    $lider = $lider->fetchObject();
                    $erros[$nomeAtracao]['lider'] = (new PessoaFisicaController)->validaPf((int)$lider->pessoa_fisica_id, 2);
                }
            }

            $acoes = DbModel::consultaSimples("SELECT * FROM acao_atracao WHERE atracao_id = '$atracao->id'");
            if ($acoes->rowCount() == 0) {
                $erros[$nomeAtracao]['acoes']['bol'] = true;
                $erros[$nomeAtracao]['acoes']['motivo'] = "Nenhuma Ação (Expressão Artístico-cultural) selecionada para esta atração";
            }

        }

        if (isset($erros)){
            return $erros;
        } else {
            return false;
        }
    }
}