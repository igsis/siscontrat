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

    public function insereDocumento($post)
    {
        $dados = [];
        unset($post['_method']);
        foreach ($post as $campo => $valor) {
            $dados[$campo] = MainModel::limparString($valor);
            unset($post[$campo]);
        }
        $insere = $this->insert($dados);
        if ($insere){
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Documento',
                'texto' => 'Cadastro realizado com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL . 'fomentos/documento_cadastro'
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
}