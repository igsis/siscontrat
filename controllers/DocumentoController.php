<?php
if ($pedidoAjax) {
    require_once "../models/MainModel.php";
} else {
    require_once "./models/MainModel.php";
}

class DocumentoController extends MainModel
{
    public function listaDocumentos()
    {
        return $this->listaPublicado("fom_lista_documentos",null,true);
    }

    public function recuperaDocumento($id)
    {
        $id = $this->decryption($id);
        return $this->getInfo("fom_lista_documentos",$id,true)->fetch(PDO::FETCH_OBJ);
    }

    public function insereDocumento($post)
    {
        $dados = [];
        unset($post['_method']);
        foreach ($post as $campo => $valor) {
            $dados[$campo] = MainModel::limparString($valor);
            unset($post[$campo]);
        }
        $insere = $this->insert("fom_lista_documentos",$dados,true);
        if ($insere || DbModel::connection()->errorCode() == 0){
            $documento_id = $this->encryption(DbModel::connection()->lastInsertId());
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Documento',
                'texto' => 'Cadastro realizado com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL . 'fomentos/documento_cadastro&id=' . $documento_id
            ];
        } else{
            $alerta = [
                'alerta' => 'simples',
                'titulo' => 'Erro!',
                'texto' => 'Erro ao salvar!',
                'tipo' => 'error',
                'location' => SERVERURL . 'fomentos/documento_cadastro'
            ];
        }
        return MainModel::sweetAlert($alerta);
    }

    public function editaDocumento($post,$id)
    {
        $dados = [];
        unset($post['_method']);
        unset($post['id']);
        foreach ($post as $campo => $valor) {
            $dados[$campo] = MainModel::limparString($valor);
            unset($post[$campo]);
        }
        $documento_id = $this->decryption($id);
        $edita = $this->update("fom_lista_documentos",$dados,$documento_id,true);
        if ($edita || DbModel::connection()->errorCode() == 0){
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Documento',
                'texto' => 'Cadastro realizado com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL . 'fomentos/documento_cadastro&id=' . $id
            ];
        } else{
            $alerta = [
                'alerta' => 'simples',
                'titulo' => 'Erro!',
                'texto' => 'Erro ao salvar!',
                'tipo' => 'error',
                'location' => SERVERURL . 'fomentos/documento_cadastro' . $id
            ];
        }
        return MainModel::sweetAlert($alerta);
    }
}