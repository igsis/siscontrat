<?php
if ($pedidoAjax) {
    require_once "../models/ArquivoModel.php";
    require_once "../controllers/FomentoController.php";
    define('UPLOADDIR', "../uploads/");
} else {
    require_once "./models/ArquivoModel.php";
    require_once "./controllers/FomentoController.php";
    define('UPLOADDIR', "./uploads/");
}

class ArquivoController extends ArquivoModel
{
    public function recuperaIdListaDocumento($tipo_documento_id, $fomento = false) {
        if (!$fomento) {
            $sql = "SELECT id FROM lista_documentos WHERE tipo_documento_id = '$tipo_documento_id'";
        } else {
            $tipo_documento_id = MainModel::decryption($tipo_documento_id);
            $tipo_documento_id = (new FomentoController())->recuperaTipoContratacao((int) $tipo_documento_id);
            $sql = "SELECT fld.id FROM fom_lista_documentos AS fld
                INNER JOIN contratacao_documentos AS cd on fld.id = cd.fom_lista_documento_id
                WHERE cd.tipo_contratacao_id = '$tipo_documento_id'";
        }

        return DbModel::consultaSimples($sql,true);
    }

    public function listarArquivos($tipo_documento_id) {
        $sql = "SELECT * FROM lista_documentos WHERE tipo_documento_id = '$tipo_documento_id' AND publicado = '1'";
        return DbModel::consultaSimples($sql);
    }

    public function listarArquivosFomento($edital_id){
        $edital_id = MainModel::decryption($edital_id);
        $sqlTipoContratacao = "SELECT tipo_contratacao_id FROM fom_editais WHERE id = '$edital_id'";
        $tipo_contratacao_id = DbModel::consultaSimples($sqlTipoContratacao)->fetchColumn();
        return parent::listaArquivosFomentos($tipo_contratacao_id);
    }

    public function listarArquivosFormacao()
    {
        return MainModel::consultaSimples("SELECT * FROM formacao_lista_documentos WHERE publicado = 1 ORDER BY 'ordem'");
    }

    public function listarArquivosLider() {
        $sql = "SELECT * FROM lista_documentos WHERE tipo_documento_id = '1' AND publicado = '1' AND id IN (1,2,47,89)";
        return ArquivoModel::consultaSimples($sql);
    }

    public function listarArquivosEnviadosComProd($origem_id) {
        $origem_id = MainModel::decryption($origem_id);
        $sql = "SELECT * FROM arquivos WHERE `origem_id` = '$origem_id' AND lista_documento_id = (SELECT id FROM lista_documentos WHERE tipo_documento_id = 8) AND publicado = '1'";
        return DbModel::consultaSimples($sql);
    }

    public function enviarArquivoComProd($origem_id, $modulo) {
        $origem_id = MainModel::decryption($origem_id);
        $lista_documento_id = DbModel::consultaSimples('SELECT id FROM lista_documentos WHERE tipo_documento_id = 8')->fetchColumn();
        $arquivos = ArquivoModel::separaArquivosComProd($lista_documento_id);
        $erros = ArquivoModel::enviaArquivos($arquivos, $origem_id, 15);
        $erro = MainModel::in_array_r(true, $erros, true);

        if ($erro) {
            foreach ($erros as $erro) {
                if ($erro['bol']){
                    $lis[] = "'<li>" . $erro['arquivo'] . ": " . $erro['motivo'] . "</li>'";
                }
            }
            $alerta = [
                'alerta' => 'arquivos',
                'titulo' => 'Oops! Tivemos alguns Erros!',
                'texto' => $lis,
                'tipo' => 'error',
                'location' => SERVERURL.$modulo.'/arquivos_com_prod'
            ];
        } else {
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Arquivos Enviados!',
                'texto' => 'Arquivos enviados com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL.$modulo.'/arquivos_com_prod'
            ];
        }

        return MainModel::sweetAlert($alerta);
    }

    public function listarArquivosEnviados($origem_id, $lista_documentos_ids, $fomentos = false, $formacao = false) {
        $origem_id = MainModel::decryption($origem_id);
        if ($lista_documentos_ids != ""){
            $documentos = implode(", ", $lista_documentos_ids);
        }
        if ($fomentos) {
            $sql = DbModel::consultaSimples(
                "SELECT fa.id, fa.arquivo, fa.data, fld.documento, cd.anexo FROM fom_arquivos AS fa
                        INNER JOIN fom_lista_documentos AS fld on fa.fom_lista_documento_id = fld.id
                        INNER JOIN contratacao_documentos AS cd on cd.fom_lista_documento_id = fa.fom_lista_documento_id
                        WHERE `fom_projeto_id` = '$origem_id'
                          AND fa.fom_lista_documento_id IN ($documentos)
                          AND fa.publicado = '1'
                          AND cd.tipo_contratacao_id = '$fomentos'
                          ORDER BY ordem", true);
        } elseif ($formacao) {
            $sql = DbModel::consultaSimples(
                "SELECT a.id, a.arquivo, a.data, ld.documento FROM formacao_arquivos AS a
                        INNER JOIN formacao_lista_documentos AS ld on a.formacao_lista_documento_id = ld.id
                        WHERE formacao_contratacao_id = '$origem_id'  AND a.publicado = '1'");
        } else {
            $sql = DbModel::consultaSimples(
                "SELECT a.id, a.arquivo, a.data, ld.documento FROM arquivos AS a
                        INNER JOIN lista_documentos AS ld on a.lista_documento_id = ld.id
                        WHERE `origem_id` = '$origem_id' AND lista_documento_id IN ($documentos) AND a.publicado = '1'");
        }
        return $sql;
    }

    public function enviarArquivo($origem_id, $pagina) {
        $fomentos = $pagina == "fomentos/anexos" ? true : false;
        $formacao = $pagina == "formacao/anexos" ? true : false;
        unset($_POST['pagina']);
        $origem_id = MainModel::decryption($origem_id);
        foreach ($_FILES as $key => $arquivo){
            $_FILES[$key]['lista_documento_id'] = $_POST[$key];
        }
        $erros = ArquivoModel::enviaArquivos($_FILES, $origem_id,6, true, $fomentos, $formacao);
        $erro = MainModel::in_array_r(true, $erros, true);

        $pagina = $pagina . '&id=' . MainModel::encryption($origem_id);

        if ($erro) {
            foreach ($erros as $erro) {
                if ($erro['bol']){
                    $lis[] = "'<li>" . $erro['arquivo'] . ": " . $erro['motivo'] . "</li>'";
                }
            }
            $alerta = [
                'alerta' => 'arquivos',
                'titulo' => 'Oops! Tivemos alguns Erros!',
                'texto' => $lis,
                'tipo' => 'error',
                'location' => SERVERURL . $pagina
            ];
        } else {
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Arquivos Enviados!',
                'texto' => 'Arquivos enviados com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL . $pagina
            ];
        }

        return MainModel::sweetAlert($alerta);
    }

    public function apagarArquivo ($arquivo_id, $pagina, $origem_id = false){
        $fomentos = $pagina == "fomentos/anexos" ? true : false;
        $formacao = $pagina == "formacao/anexos" ? true : false;

        if($origem_id){
            $pagina = $pagina . '&id=' . $origem_id;
        }

        $arquivo_id = MainModel::decryption($arquivo_id);
        if ($fomentos) {
            $remover = DbModel::apaga('fom_arquivos', $arquivo_id);
        } elseif ($formacao) {
            $remover = DbModel::apaga('formacao_arquivos', $arquivo_id);
        } else {
            $remover = DbModel::apaga('arquivos', $arquivo_id);
        }

        if ($remover->rowCount() > 0) {
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Arquivo Apagado!',
                'texto' => 'Arquivo apagado com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL . $pagina
            ];
        } else {
            $alerta = [
                'alerta' => 'simples',
                'titulo' => 'Oops! Algo deu Errado!',
                'texto' => 'Falha ao remover o arquivo do servidor, tente novamente mais tarde',
                'tipo' => 'error',
            ];
        }

        return MainModel::sweetAlert($alerta);
    }

    public function consultaArquivoEnviado($lista_documento_id, $origem_id, $fomentos = false, $formacao = false) {
        $origem_id = MainModel::decryption($origem_id);
        if ($fomentos) {
            $sql = DbModel::consultaSimples("SELECT * FROM fom_arquivos WHERE fom_lista_documento_id = '$lista_documento_id' AND fom_projeto_id = '$origem_id' AND publicado = '1'", true);
        } elseif ($formacao) {
            $sql = DbModel::consultaSimples("SELECT * FROM formacao_arquivos WHERE formacao_lista_documento_id = '$lista_documento_id' AND formacao_contratacao_id = '$origem_id' AND publicado = '1'");
        }else {
            $sql = DbModel::consultaSimples("SELECT * FROM arquivos WHERE lista_documento_id = '$lista_documento_id' AND origem_id = '$origem_id' AND publicado = '1'");
        }
        $arquivo = $sql->rowCount();
        return $arquivo > 0 ? true : false;
    }

    public function downloadArquivos($fom_projeto_id, $formacao = 0, $form_cadastro_id = 0)
    {
        $path = "../../capac/uploads/";
        $data = date('YmdHis');
        $nome_arquivo = $data . ".zip";

        $zip = new ZipArchive();

        if ($zip->open($nome_arquivo, ZipArchive::CREATE) === true) {

            if($formacao != 0 && $form_cadastro_id != 0):
                $query = DbModel::consultaSimples("SELECT * FROM form_arquivos WHERE form_cadastro_id = '$form_cadastro_id' AND publicado = 1", TRUE)->fetchAll(PDO::FETCH_ASSOC);
            else:
                $query = DbModel::consultaSimples(" SELECT * FROM fom_arquivos WHERE publicado = 1 AND fom_projeto_id = '$fom_projeto_id'",true)->fetchAll(PDO::FETCH_ASSOC);
            endif;

            foreach ($query as $arquivo) {
                $file = $path . $arquivo['arquivo'];
                $file2 = $arquivo['arquivo'];
                if ($zip->addFile($file, $file2)) {
                    $zipou = true;
                } else {
                    $zipou = false;
                }
            }

            $zip->close();
        }

        header('Content-Description: File Transfer');
        header('Content-Disposition: attachment; filename="' . $nome_arquivo . '"');
        header('Content-Type: application/octet-stream');
        header('Content-Transfer-Encoding: binary');
        header('Content-Length: ' . filesize($nome_arquivo));
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Pragma: public');
        header('Expires: 0');

        ob_end_clean(); //essas duas linhas antes do readfile
        flush();

        readfile($nome_arquivo);

        unlink($data . ".zip");
    }

    public function downloadArquivosCapac($id)
    {
        $path = "../../capac/uploads/";
        $data = date('YmdHis');
        $nome_arquivo = $data . ".zip";

        $zip = new ZipArchive();

        if ($zip->open($nome_arquivo, ZipArchive::CREATE) === true) {

            $idPf = MainModel::decryption($id);

            $sql = "SELECT fa.* FROM form_arquivos AS fa 
                    INNER JOIN  form_cadastros AS fc ON fa.form_cadastro_id = fc.id
                    INNER JOIN pessoa_fisicas AS pf ON pf.id = fc.pessoa_fisica_id
                    WHERE pf.id = '{$idPf}' AND fa.publicado = 1";
            $query = DbModel::consultaSimples($sql, TRUE)->fetchAll(PDO::FETCH_ASSOC);

            foreach ($query as $arquivo) {
                $file = $path . $arquivo['arquivo'];
                $file2 = $arquivo['arquivo'];
                if ($zip->addFile($file, $file2)) {
                    $zipou = true;
                } else {
                    $zipou = false;
                }
            }

            $zip->close();
        }

        header('Content-Description: File Transfer');
        header('Content-Disposition: attachment; filename="' . $nome_arquivo . '"');
        header('Content-Type: application/octet-stream');
        header('Content-Transfer-Encoding: binary');
        header('Content-Length: ' . filesize($nome_arquivo));
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Pragma: public');
        header('Expires: 0');

        ob_end_clean(); //essas duas linhas antes do readfile
        flush();

        readfile($nome_arquivo);

        unlink($data . ".zip");
    }

    public function listarArquivosCapac($origem_id)
    {
        $origem_id = MainModel::decryption($origem_id);
        return  DbModel::consultaSimples("SELECT * FROM form_arquivos WHERE form_cadastro_id = '$origem_id' AND publicado = '1'", true);
    }

    public function getDocumento($idDocumento)
    {
        return DbModel::consultaSimples("SELECT documento FROM formacao_lista_documentos WHERE id = $idDocumento")->fetchObject()->documento;
    }

}