<?php

if ($pedidoAjax) {
    require_once "../models/FormacaoModel.php";
    require_once "../controllers/PessoaFisicaController.php";
} else {
    require_once "./models/FormacaoModel.php";
    require_once "./controllers/PessoaFisicaController.php";
}


class FormacaoDocumentoController extends FormacaoModel
{

    public function inserir($post)
    {
        $dados = [];
        unset($post['_method']);
        $dados = MainModel::limpaPost($post);

        $insere = DbModel::insert("formacao_lista_documentos", $dados, false);

        if ($insere || DbModel::connection()->errorCode() == 0) {
            $documento_id = $this->encryption(DbModel::connection()->lastInsertId());
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Documento',
                'texto' => 'Cadastro realizado com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL . 'formacao/documento_cadastro&id=' . $documento_id
            ];
        } else {
            $alerta = [
                'alerta' => 'simples',
                'titulo' => 'Erro!',
                'texto' => 'Erro ao salvar!',
                'tipo' => 'error',
                'location' => SERVERURL . 'formacao/documento_cadastro'
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

        $edita = $this->update("formacao_lista_documentos", $dados, $id);

        if ($edita || DbModel::connection()->errorCode() == 0) {
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Documento',
                'texto' => 'Alteração realizada com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL . 'formacao/documento_cadastro&id=' . MainModel::encryption($id)
            ];
        } else {
            $alerta = [
                'alerta' => 'simples',
                'titulo' => 'Erro!',
                'texto' => 'Erro ao salvar!',
                'tipo' => 'error',
                'location' => SERVERURL . 'formacao/documento_cadastro' . MainModel::encryption($id)
            ];
        }
        return MainModel::sweetAlert($alerta);
    }

    public function recuperar($id)
    {
        $id = $this->decryption($id);
        return $this->getInfo("formacao_lista_documentos", $id)->fetch(PDO::FETCH_OBJ);
    }

    public function apagar($post)
    {
        $id = MainModel::decryption($post['id']);
        $apaga = DbModel::apaga("formacao_lista_documentos", $id);
        if ($apaga || DbModel::connection()->errorCode() == 0) {
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Documento Deletado!',
                'texto' => 'Dados atualizados com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL . 'formacao/documento_lista'
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

    public function listar()
    {
        return $this->listaPublicado("formacao_lista_documentos", null);
    }

//    public function listaDocumento($documento, $tipo_documento)
//    {
//        return parent::getDocumento($documento, $tipo_documento);
//    }

}
