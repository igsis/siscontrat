<?php
if ($pedidoAjax) {
    require_once "../models/AtracaoModel.php";
    require_once "../controllers/ProdutorController.php";
} else {
    require_once "./models/AtracaoModel.php";
    require_once "./controllers/ProdutorController.php";
}

class AtracaoController extends AtracaoModel
{
    public function insereAtracao($post){
        /* executa limpeza nos campos */
        $dadosAtracao = [];
        unset($post['_method']);
        foreach ($post as $campo => $valor) {
            if ($campo != "acoes") {
                $dadosAtracao[$campo] = MainModel::limparString($valor);
                unset($post[$campo]);
            }
        }
        $dadosAtracao['evento_id'] = MainModel::decryption($_SESSION['origem_id_s']);
        $dadosAtracao['valor_individual'] = MainModel::dinheiroDeBr($dadosAtracao['valor_individual']);
        /* /.limpeza */

        /* cadastro */
        $insere = DbModel::insert('atracoes', $dadosAtracao);
        if ($insere->rowCount() >= 1) {
            $atracao_id = DbModel::connection()->lastInsertId();
            $_SESSION['atracao_id_s'] = MainModel::encryption($atracao_id);
            $atualizaRelacionamentoAcoes = MainModel::atualizaRelacionamento('acao_atracao', 'atracao_id', $atracao_id, 'acao_id', $post['acoes']);

            if ($atualizaRelacionamentoAcoes) {
                $alerta = [
                    'alerta' => 'sucesso',
                    'titulo' => 'Atração Cadastrada!',
                    'texto' => 'Dados cadastrados com sucesso!',
                    'tipo' => 'success',
                    'location' => SERVERURL . 'eventos/atracao_cadastro&key=' . MainModel::encryption($atracao_id)
                ];
            } else {
                $alerta = [
                    'alerta' => 'simples',
                    'titulo' => 'Oops! Algo deu Errado!',
                    'texto' => 'Falha ao salvar os dados no servidor, tente novamente mais tarde',
                    'tipo' => 'error',
                ];
            }
        } else {
            $alerta = [
                'alerta' => 'simples',
                'titulo' => 'Oops! Algo deu Errado!',
                'texto' => 'Falha ao salvar os dados no servidor, tente novamente mais tarde',
                'tipo' => 'error',
            ];
        }
        /* /.cadastro */
        return MainModel::sweetAlert($alerta);
    }

    public function editaAtracao($post,$atracao_id){
        /* executa limpeza nos campos */
        $dadosAtracao = [];
        unset($post['_method']);
        unset($post['id']);
        foreach ($post as $campo => $valor) {
            if ($campo != "acoes") {
                $dadosAtracao[$campo] = MainModel::limparString($valor);
                if ($campo == "valor_individual") {
                    $dadosAtracao[$campo] = MainModel::dinheiroDeBr($dadosAtracao[$campo]);
                }
                unset($post[$campo]);
            }
        }
        /* /.limpeza */

        // edição
        $edita = DbModel::update("atracoes",$dadosAtracao,$atracao_id);
        if ($edita->rowCount() >= 1 || DbModel::connection()->errorCode() == 0) {
            $atualizaRelacionamentoPublicos = MainModel::atualizaRelacionamento('acao_atracao', 'atracao_id', $atracao_id, 'acao_id', $post['acoes']);
            if ($atualizaRelacionamentoPublicos) {
                $alerta = [
                    'alerta' => 'sucesso',
                    'titulo' => 'Atração Atualizada!',
                    'texto' => 'Dados atualizados com sucesso!',
                    'tipo' => 'success',
                    'location' => SERVERURL . 'eventos/atracao_cadastro&key=' . MainModel::encryption($atracao_id)
                ];
            } else {
                $alerta = [
                    'alerta' => 'simples',
                    'titulo' => 'Oops! Algo deu Errado!',
                    'texto' => 'Falha ao salvar os dados no servidor, tente novamente mais tarde',
                    'tipo' => 'error',
                ];
            }

        } else {
            $alerta = [
                'alerta' => 'simples',
                'titulo' => 'Oops! Algo deu Errado!',
                'texto' => 'Falha ao salvar os dados no servidor, tente novamente mais tarde',
                'tipo' => 'error',
            ];
        }
        /* /.edicao */
        return MainModel::sweetAlert($alerta);
    }

    public function apagaAtracao($id){
        $apaga = DbModel::apaga("atracoes", $id);
        if ($apaga){
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Atração',
                'texto' => 'Atração apagada com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL.'eventos/atracao_lista'
            ];
        }else {
            $alerta = [
                'alerta' => 'simples',
                'titulo' => 'Oops! Algo deu Errado!',
                'texto' => 'Falha ao salvar os dados no servidor, tente novamente mais tarde',
                'tipo' => 'error',
            ];
        }
        return MainModel::sweetAlert($alerta);
    }
    
    public function exibeDescricaoAcao() {
        $acoes = DbModel::consultaSimples("SELECT acao, descricao FROM acoes WHERE publicado = '1' ORDER BY 1");
        foreach ($acoes->fetchAll() as $acao) {
            ?>
            <tr>
                <td><?= $acao['acao'] ?></td>
                <td><?= $acao['descricao'] ?></td>
            </tr>
            <?php
        }
    }
}