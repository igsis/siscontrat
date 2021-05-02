<?php

if ($pedidoAjax) {
    require_once "../models/FormacaoModel.php";
    require_once "../controllers/PessoaFisicaController.php";
} else {
    require_once "./models/FormacaoModel.php";
    require_once "./controllers/PessoaFisicaController.php";
}

class FormacaoVigenciaController extends FormacaoModel
{
    public function inserir($post)
    {
        unset($post['_method']);
        $dados = MainModel::limpaPost($post);
        $insert = DbModel::insert('formacao_vigencias', $dados);
        if ($insert->rowCount() >= 1) {
            $vigencia_id = DbModel::connection()->lastInsertId();
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Vigência Cadastrada!',
                'texto' => 'Dados cadastrados com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL . 'formacao/vigencia_cadastro&id=' . MainModel::encryption($vigencia_id)
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
        $vigencia_id = MainModel::decryption($post['id']);
        unset($post['id']);
        unset ($post['_method']);
        $dados = MainModel::limpaPost($post);;
        $update = DbModel::update('formacao_vigencias', $dados, $vigencia_id);
        if ($update->rowCount() >= 1 || DbModel::connection()->errorCode() == 0) {
            $queryParcelas = DbModel::consultaSimples("SELECT * FROM formacao_parcelas WHERE formacao_vigencia_id = '$vigencia_id' ORDER BY id DESC");
            $numParcelas = $queryParcelas->rowCount();
            if ($numParcelas > 0) {
                $parcelas = $queryParcelas->fetchAll(PDO::FETCH_ASSOC);
                if ($dados['numero_parcelas'] < $numParcelas) {
                    for ($i = 0; $i < ($numParcelas - $dados['numero_parcelas']); $i++) {
                        DbModel::deleteEspecial('formacao_parcelas', 'id', $parcelas[$i]['id']);
                    }
                } else {
                    $data = $parcelas[0];
                    $parcela = $data['numero_parcelas'];
                    unset($data['id']);
                    for ($i = 0; $i < ($dados['numero_parcelas'] - $numParcelas); $i++) {
                        $data['numero_parcelas'] = $parcela + 1;
                        DbModel::insert('formacao_parcelas', $data);
                        $parcela++;
                    }
                }
            }
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Vigência Atualizada!',
                'texto' => 'Dados atualizados com sucesso! Lembre-se de editar as parcelas se necessário.',
                'tipo' => 'success',
                'location' => SERVERURL . 'formacao/vigencia_cadastro&id=' . MainModel::encryption($vigencia_id)
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
        $apagaParcelas = DbModel::deleteEspecial('formacao_parcelas', 'formacao_vigencia_id', $id);
        if ($apagaParcelas) {
            $apaga = DbModel::apaga("formacao_vigencias", $id);
            if ($apaga) {
                $alerta = [
                    'alerta' => 'sucesso',
                    'titulo' => 'Vigência Deletada!',
                    'texto' => 'Dados atualizados com sucesso!',
                    'tipo' => 'success',
                    'location' => SERVERURL . 'formacao/vigencia_lista'
                ];
            } else {
                $alerta = [
                    'alerta' => 'simples',
                    'titulo' => 'Oops! Algo deu Errado!',
                    'texto' => 'Falha ao apagar os dados no servidor, tente novamente mais tarde',
                    'tipo' => 'error',
                ];
            }
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

    public function recuperar($vigencia_id)
    {
        $vigencia_id = MainModel::decryption($vigencia_id);
        return DbModel::getInfo('formacao_vigencias', $vigencia_id)->fetchObject();
    }

    public function retornaValorTotal($contratacao_id, $decryption = 0)
    {
        if ($decryption != 0) {
            $contratacao_id = MainModel::decryption($contratacao_id);
        }

        $valor = 0;
        $consultaValores = DbModel::consultaSimples("SELECT fp.valor FROM formacao_parcelas AS fp INNER JOIN formacao_contratacoes AS fc ON fc.form_vigencia_id = fp.formacao_vigencia_id WHERE fc.id = $contratacao_id AND fp.publicado = 1 AND fp.valor != 0.00");
        $count = $consultaValores->rowCount();
        if ($count > 0) {
            $arrayValores = $consultaValores->fetchAll(PDO::FETCH_OBJ);
            for ($i = 0; $i < $count; $i++):
                $valor = $valor + $arrayValores[$i]->valor;
            endfor;
        }
        return $valor;
    }

    public function listar()
    {
        return DbModel::listaPublicado("formacao_vigencias", null);
    }
}