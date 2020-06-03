<?php
if ($pedidoAjax) {
    require_once "../models/FomentoModel.php";
} else {
    require_once "./models/FomentoModel.php";
}

class FomentoController extends FomentoModel
{
    /**
     * <p>Retorna todos os editais cadastrados no sistema CAPAC</p>
     * @return array
     */
    public function listaEditais()
    {
        $fomentos = DbModel::listaPublicado("fom_editais", null,true);
        foreach ($fomentos as $key => $fomento) {
            $tipo_contratacao = DbModel::getInfo('tipos_contratacoes', $fomento->tipo_contratacao_id, true)->fetchObject();
            $fomentos[$key]->tipo_contratacao = $tipo_contratacao->tipo_contratacao;
        }
        return $fomentos;
    }

    /**
     * <p>Retorna todos os editais cadastrados no sistema CAPAC ique estão arquivados</p>
     * @return array
     */
    public function listaEditaisArquivados()
    {
        $fomentos = DbModel::consultaSimples("SELECT * FROM fom_editais WHERE publicado = 0",true)->fetchAll(PDO::FETCH_OBJ);
        //$fomentos = DbModel::listaPublicado("fom_editais", null,true);
        foreach ($fomentos as $key => $fomento) {
            $tipo_contratacao = DbModel::getInfo('tipos_contratacoes', $fomento->tipo_contratacao_id, true)->fetchObject();
            $fomentos[$key]->tipo_contratacao = $tipo_contratacao->tipo_contratacao;
        }
        return $fomentos;
    }

    /**
     * @param $edital_id <p>ID do edital a ser consultado no sistema CAPAC</p>
     * @return mixed
     */
    public function recuperaEdital($edital_id) {
        $edital_id = MainModel::decryption($edital_id);
        return DbModel::getInfo('fom_editais', $edital_id, true)->fetchObject();
    }

    /**
     * <p>Verifica se o edital está com inscrições abertas</p>
     * @param string $dataAbertura
     * <p>Recebe a data de abertura do edital no padrão <strong><i>SQL</strong> - AAAA-MM-DD</i></p>
     * @param string $dataEncerramento
     * <p>Recebe a data de encerramento do edital no padrão <strong><i>SQL</strong> - AAAA-MM-DD</i></p>
     * @return bool
     * <p>Caso o edital esteja ativo, retorna <i>TRUE</i>. Caso não, retorna <i>FALSE</i></p>
     * @throws Exception
     */
    public function verificaEditalAtivo($dataAbertura, $dataEncerramento) {
        $dataAtual = new DateTime();
        $dataAbertura = new DateTime($dataAbertura);
        $dataEncerramento = new DateTime($dataEncerramento);

        if (($dataAtual >= $dataAbertura) && ($dataAtual <= $dataEncerramento)) {
            return true;
        } else {
            return false;
        }
    }

    public function contadorFomento($tabela, $where)
    {
        return DbModel::consultaSimples("SELECT id FROM $tabela WHERE $where",true)->rowCount();
    }

    /**
     * <p>Insere um novo edital no sistema CAPAC</p>
     * @param array $post
     * @return string
     */
    public function insereEdital($post) {
        unset ($post['_method']);

        $dados = MainModel::limpaPost($post);

        $dados['valor_max_projeto'] = MainModel::dinheiroDeBr($dados['valor_max_projeto']);
        $dados['valor_edital'] = MainModel::dinheiroDeBr($dados['valor_edital']);
        $dados['data_abertura'] = MainModel::dataHoraParaSQL($dados['data_abertura']);
        $dados['data_encerramento'] = MainModel::dataHoraParaSQL($dados['data_encerramento']);

        $insert = DbModel::insert('fom_editais', $dados, true);
        if ($insert->rowCount() >= 1) {
            $edital_id = DbModel::connection(true)->lastInsertId();
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Edital Cadastrado!',
                'texto' => 'Dados cadastrados com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL . 'fomentos/edital_cadastro&id=' . MainModel::encryption($edital_id)
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

    public function editaEdital($post) {
        $edital_id = MainModel::decryption($post['id']);
        unset($post['id']);
        unset ($post['_method']);

        $dados = MainModel::limpaPost($post);

        $dados['valor_max_projeto'] = MainModel::dinheiroDeBr($dados['valor_max_projeto']);
        $dados['valor_edital'] = MainModel::dinheiroDeBr($dados['valor_edital']);
        $dados['data_abertura'] = MainModel::dataHoraParaSQL($dados['data_abertura']);
        $dados['data_encerramento'] = MainModel::dataHoraParaSQL($dados['data_encerramento']);

        $update = DbModel::update('fom_editais', $dados, $edital_id, true);
        if ($update->rowCount() >= 1 || DbModel::connection()->errorCode() == 0) {
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Edital Atualizado!',
                'texto' => 'Dados atualizados com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL . 'fomentos/edital_cadastro&id=' . MainModel::encryption($edital_id)
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

    /** @TODO: Verificar se esta função é realmente necessária
     * @param int $edital_id
     * @return mixed
     */
    public function recuperaTipoContratacao($edital_id) {
        $tipo = gettype($edital_id);
        if ($tipo == "string") {
            $edital_id = MainModel::decryption($edital_id);
        }
        $sql = "SELECT tipo_contratacao_id FROM fom_editais WHERE id = '$edital_id'";
        return DbModel::consultaSimples($sql,true)->fetchColumn();
    }

    public  function pesquisaEdital($pesquisa){
        $query = "SELECT id,titulo, data_abertura, data_encerramento FROM fom_editais WHERE titulo LIKE '%$pesquisa%';";
        $result = DbModel::consultaSimples($query,true)->fetchAll(PDO::FETCH_ASSOC);
        if (count($result) > 0){
            for ($i = 0; $i < count($result); $i++) {
                $result[$i]['id'] = MainModel::encryption($result[$i]['id']);
            }
            return json_encode(array($result));
        }

        return '0';
    }

    /**
     * <p>Retorna todos os projetos inscritos no edital especificado</p>
     * @param string $edital_id <p>Recebe o ID do edital criptografado</p>
     * @return array|bool
     */
    public function listaInscritos($edital_id) {
        $edital_id = MainModel::decryption($edital_id);

        return parent::recuperaInscritos($edital_id);
    }

    public function recuperaProjeto($idInscrito){
        $id = MainModel::decryption($idInscrito);
        $resultado = DbModel::getInfo('fom_projetos',$id,true)->fetch(PDO::FETCH_ASSOC);
        $resultado['responsavel_inscricao'] = DbModel::consultaSimples("SELECT nome FROM usuarios WHERE id='{$resultado['usuario_id']}'")->fetchColumn();
        return $resultado;
    }

    public function statusEdital($edital_id) {
        $edital_id = MainModel::decryption($edital_id);
        $statusEdital = new stdClass();

        $statusEdital->aprovados = DbModel::consultaSimples("SELECT id FROM fom_projetos WHERE fom_edital_id = '$edital_id' AND publicado = 2")->rowCount();
        $statusEdital->valor_disponivel = parent::valorDisponivel($edital_id);
        $valorTotal = DbModel::getInfo("fom_editais", $edital_id, true)->fetchObject()->valor_edital;
        $statusEdital->valor_total = $valorTotal;

        return $statusEdital;
    }

    public function aprovarProjeto($id,$valor,$edital_id){
        $valorDisponivel = parent::valorDisponivel($edital_id);
        if ($valorDisponivel > $valor){
            DbModel::update('fom_projetos',['publicado' =>'2'],$id,true);
            $status =  1;
        }else{
            $status = 0;
        }

        return $status;
    }

    public function reprovarProjeto($id){
        DbModel::update('fom_projetos',['publicado' =>'3'],$id,true);
        return 1;
    }

    public function exibeNomeEdital($id)
    {
        $id = MainModel::decryption($id);
        return DbModel::getInfo("fom_editais",$id,true)->fetchColumn(3);
    }

    public function recuperaTipoEdital($edital_id)
    {
        $edital_id = $this->decryption($edital_id);
        return DbModel::getInfo('fom_editais', $edital_id, true)->fetchObject()->tipo_contratacao_id;
    }

    public function insereTipoContratacao($post) {
        $edital_id = isset($post['id']) ? "&id=".$post['id'] : "";
        $dados['tipo_contratacao'] = MainModel::limparString($post['tipo_contratacao']);
        $insert = DbModel::insert('tipos_contratacoes', $dados, true);
        if ($insert) {
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Tipo de Edital Inserido!',
                'texto' => 'Dados inseridos com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL . 'fomentos/edital_cadastro' . $edital_id
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

    public function listaDocumentosEdital($edital_id) {
        $tipoContratacao = $this->recuperaTipoEdital($edital_id);
        return DbModel::consultaSimples("SELECT cd.id, cd.tipo_contratacao_id, cd.fom_lista_documento_id, cd.anexo, cd.ordem, cd.obrigatorio, fld.documento FROM contratacao_documentos cd INNER JOIN fom_lista_documentos fld ON fld.id = cd.fom_lista_documento_id WHERE tipo_contratacao_id = '$tipoContratacao'",true)->fetchAll(PDO::FETCH_OBJ);
    }

    public function recuperaDocumentoEdital($id)
    {
        $id = $this->decryption($id);
        return $this->getInfo("contratacao_documentos",$id,true)->fetch(PDO::FETCH_OBJ);
    }

    public function insereAnexoEdital($post)
    {
        unset($post['_method']);
        $edital_id = $post['edital_id'];
        unset($post['edital_id']);
        $dados = MainModel::limpaPost($post);
        $dados['tipo_contratacao_id'] = $this->recuperaTipoEdital($edital_id);

        $insert = DbModel::insert('contratacao_documentos', $dados, true);
        if ($insert->rowCount() >= 1) {
            $anexo_id = DbModel::connection(true)->lastInsertId();
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Anexo do Edital',
                'texto' => 'Dados cadastrados com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL . 'fomentos/edital_anexos_cadastro&edital=' . $edital_id .'&id=' . MainModel::encryption($anexo_id)
            ];
        } else {
            $alerta = [
                'alerta' => 'simples',
                'titulo' => 'Oops! Algo deu Errado!',
                'texto' => 'Falha ao salvar os dados no servidor, tente novamente mais tarde',
                'tipo' => 'error',
                'location' => SERVERURL . 'fomentos/edital_anexos_cadastro&edital=' . $edital_id
            ];
        }
        return MainModel::sweetAlert($alerta);
    }

    public function editaAnexoEdital($post)
    {
        unset($post['_method']);
        $id = MainModel::decryption($post['id']);
        unset($post['id']);
        $edital_id = $post['edital_id'];
        unset($post['edital_id']);
        $dados = MainModel::limpaPost($post);
        $dados['tipo_contratacao_id'] = $this->recuperaTipoEdital($edital_id);

        $this->update("contratacao_documentos",$dados,$id,true);
        if (DbModel::connection()->errorCode() == 0) {
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Anexo do Edital!',
                'texto' => 'Dados atualizados com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL . 'fomentos/edital_anexos_cadastro&edital=' .$edital_id . '&id=' . MainModel::encryption($id)
            ];
        } else {
            $alerta = [
                'alerta' => 'simples',
                'titulo' => 'Oops! Algo deu Errado!',
                'texto' => 'Falha ao salvar os dados no servidor, tente novamente mais tarde',
                'tipo' => 'error',
                'location' => SERVERURL . 'fomentos/edital_anexos_cadastro&edital=' .$edital_id . '&id=' . MainModel::encryption($id)
            ];
        }

        return MainModel::sweetAlert($alerta);
    }
}