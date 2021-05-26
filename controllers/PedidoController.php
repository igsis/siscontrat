<?php
if ($pedidoAjax) {
    require_once "../models/PedidoModel.php";
    require_once "../controllers/PessoaFisicaController.php";
    require_once "../controllers/PessoaJuridicaController.php";
    require_once "../controllers/RepresentanteController.php";
    require_once "../controllers/FormacaoController.php";
    require_once "../controllers/FormacaoContratacaoController.php";
} else {
    require_once "./models/PedidoModel.php";
    require_once "./controllers/PessoaFisicaController.php";
    require_once "./controllers/PessoaJuridicaController.php";
    require_once "./controllers/RepresentanteController.php";
    require_once "./controllers/FormacaoController.php";
    require_once "./controllers/FormacaoContratacaoController.php";
}

class PedidoController extends PedidoModel
{
    public function inserePedido($origem_tipo_id,$pagina)
    {
        unset($_POST['_method']);

        $dados = MainModel::limpaPost($_POST);

        $insert = DbModel::insert('pedidos', $dados);
        if ($insert->rowCount() >= 1) {
            $pedido_id = DbModel::connection()->lastInsertId();
            $dados['id'] = $pedido_id;
            if ($origem_tipo_id == 2){//formacao
                DbModel::updateEspecial("formacao_contratacoes",$dados,"id",$dados['origem_id']);
            }
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Pedido Cadastrado',
                'texto' => 'Dados cadastrados com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL . $pagina . '&pedido_id=' . MainModel::encryption($pedido_id)
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

    public function cadastrarPedido($post, $pagina)
    {
        unset($post['_method']);

        if (isset($post['valor_total'])) {
            $post['valor_total'] = MainModel::dinheiroDeBr($post['valor_total']);
        }

        $dados = MainModel::limpaPost($post);

        $insert = DbModel::insert('pedidos', $dados);
        if ($insert->rowCount() >= 1) {
            $pedido_id = DbModel::connection()->lastInsertId();

            DbModel::consultaSimples("UPDATE formacao_contratacoes SET pedido_id = '$pedido_id' WHERE publicado = 1 AND id = " . $dados['origem_id']);
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Pedido Cadastrado',
                'texto' => 'Dados cadastrados com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL . $pagina . '&pedido_id=' . MainModel::encryption($pedido_id)
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
     * @param int $origem_tipo_id <p>1-Evento; 2-Formação; 3-EMIA</p>
     * @param int|string $origem_id <p>id do evento, formação ou emia</p>
     * @return object
     */
    public function recuperaPedido(int $origem_tipo_id, $origem_id):stdClass
    {
        $origem_id = MainModel::decryption($origem_id);


        switch ($origem_tipo_id){
            case 1: /** Tipo Evento */
                $pedido = PedidoModel::recuperaBasePedido($origem_tipo_id, $origem_id);

                $parecer = DbModel::consultaSimples("SELECT topico1,topico2,topico3,topico4 FROM parecer_artisticos WHERE pedido_id = '$origem_id'")->fetch(PDO::FETCH_ASSOC);
                if ($parecer){
                    $pedido['topico1'] = $parecer['topico1'] ?? null;
                    $pedido['topico2'] = $parecer['topico2'] ?? null;
                    $pedido['topico3'] = $parecer['topico3'] ?? null;
                    $pedido['topico4'] = $parecer['topico4'] ?? null;
                }

                if ($pedido['pessoa_tipo_id'] == 2){ //pessoa jurídica
                    $pjObj = new PessoaJuridicaController();
                    $idPj = $this->encryption($pedido['pessoa_juridica_id']);
                    $pj = $pjObj->recuperaPessoaJuridica($idPj);
                    unset($pj->id);
                    $pedido = array_merge((array)$pedido,(array)$pj);
                    //representante
                    $repObj = new RepresentanteController();
                    if ($pj->representante_legal1_id){
                        $idRep1 = $this->encryption($pj->representante_legal1_id);
                        $rep1 = $repObj->recuperaRepresentante($idRep1);
                        $pedido['rep1'] = (array)$rep1;
                    }
                    if ($pj->representante_legal2_id){
                        $idRep2 = $this->encryption($pj->representante_legal2_id);
                        $rep2 = $repObj->recuperaRepresentante($idRep2);
                        $pedido['rep2'] = (array)$rep2;
                    }
                } else{ //pessoa física
                    $pfObj = new PessoaFisicaController();
                    $idPf = $this->encryption($pedido['pessoa_fisica_id']);
                    $pf = $pfObj->recuperaPessoaFisica($idPf);
                    unset($pf->id);
                    $pedido = array_merge((array)$pedido,(array)$pf);
                }
                break;
            case 2: /** Tipo Formação */
                $formObj = new FormacaoContratacaoController();
                $pedido = PedidoModel::recuperaBasePedido($origem_tipo_id, $origem_id);
                $formacao = (array) $formObj->recuperar($origem_id);
                unset($formacao->id);
                $pedido = array_merge($pedido,$formacao);
                break;
            case 3:
                $pedido = PedidoModel::recuperaBasePedido($origem_tipo_id, $origem_id);
                $emia = array("dados"=>"construir controller emia");
                unset($emia->id);
                $pedido = array_merge($pedido,$emia);
                break;
            default:
                $pedido = [];
        }

        return (object)$pedido;
    }

    public function listaPedidos($origem_tipo_id, $ano = false, $statusPedido = false)
    {
        $whereStatusPedido = "";
        $whereAno = "";
        if ($ano) {
            $whereAno = "AND fc.ano = {$ano}";
        }
        if ($statusPedido) {
            if ($statusPedido == 2) {
                $whereStatusPedido = "AND p.status_pedido_id = 2";
            } else {
                $whereStatusPedido = "AND p.status_pedido_id != 2";
            }
        }
        $filtro = "{$whereAno} {$whereStatusPedido}";
        $pedidos = PedidoModel::listaBasePedido($origem_tipo_id, $filtro);
        if ($origem_tipo_id == 1) { //evento
            foreach ($pedidos as $pedido) {
                if ($pedido->pessoa_tipo_id == 2) { //pessoa jurídica
                    $pjObj = new PessoaJuridicaController();
                    $idPj = $this->encryption($pedido->pessoa_juridica_id);
                    $pj = $pjObj->recuperaPessoaJuridica($idPj);
                    $pedido->proponente = $pj->razao_social;
                    $pedido->documento = $pj->cnpj;
                } else {
                    $pfObj = new PessoaFisicaController();
                    $idPf = $this->encryption($pedido->pessoa_fisica_id);
                    $pf = $pfObj->recuperaPessoaFisica($idPf);
                    $pedido->proponente = $pf->nome;
                    $pedido->documento = $pf->cpf;
                }
            }
        }
        if ($origem_tipo_id == 2){ //formação

            $formObj = new FormacaoContratacaoController();
            foreach ($pedidos as $pedido) {
                $form = $formObj->recuperar(intval($pedido->origem_id));
                if ($form) {
                    $pedido->proponente = $form->nome;
                    $pedido->documento = $form->documento;
                    $pedido->protocolo = $form->protocolo;
                    $pedido->ano = $form->ano;
                }
            }
        }
        return $pedidos;
    }

    /**
     * @param int $origem_tipo_id
     * @param int|string $origem_id
     * @return string
     * @throws Exception
     */
    public function recuperaFormaPagto(int $origem_tipo_id,$origem_id):string
    {
        $origem_id = MainModel::decryption($origem_id);
        if ($origem_tipo_id == 2){
            $dadosParcelas = DbModel::consultaSimples("SELECT fp.* FROM formacao_parcelas AS fp INNER JOIN formacao_contratacoes AS fc ON fc.form_vigencia_id = fp.formacao_vigencia_id WHERE fp.publicado = 1 AND fc.id = $origem_id")->fetchAll(PDO::FETCH_OBJ);
            $formaCompleta = "";
            for ($i = 0; $i < count($dadosParcelas); $i++) :
                $forma = $i + 1 . "º parcela R$ " . MainModel::dinheiroParaBr($dadosParcelas[$i]->valor) . ". Entrega de documentos a partir de " . MainModel::dataParaBR($dadosParcelas[$i]->data_pagamento) . ".\n";
                $formaCompleta .= $forma;
            endfor;
            $formaCompleta .= "A liquidação de cada parcela se dará em 3 (três) dias úteis após a data de confirmação da correta execução do(s) serviço(s).";
        }
        return $formaCompleta;
    }

    public function getParcelarPedidoFomentos($id)
    {
        $pedido_id = MainModel::decryption($id);

        $sql = "SELECT  fp.id,
                        CONCAT(DATE_FORMAT(fp.data_inicio,'%d/%m/%Y'),' à ', DATE_FORMAT(fp.data_fim,'%d/%m/%Y')) AS periodo, 
                        fp.numero_parcelas,
                        fp.data_inicio, 
                        fp.data_fim, 
                        fp.data_pagamento, 
                        fp.valor, fc.pedido_id
                FROM formacao_contratacoes AS fc
                INNER JOIN formacao_vigencias AS fv ON fc.form_vigencia_id = fv.id
                INNER JOIN formacao_parcelas AS fp ON fv.id = fp.formacao_vigencia_id
                WHERE fc.pedido_id = $pedido_id AND fp.publicado = 1";

        return DbModel::consultaSimples($sql)->fetchAll(PDO::FETCH_OBJ);

    }

    public function recuperaPenalidades($penal_id){
        return DbModel::consultaSimples("SELECT texto FROM penalidades WHERE id = $penal_id")->fetchObject()->texto;
    }

    public function recuperaVerba($id)
    {
        return DbModel::getInfo("verbas",$id)->fetchObject();
    }

    /**
     * @param $idPedido
     * @return array
     */
    public function recuperaValorLocal($idPedido)
    {
        if (gettype($idPedido) == "string") {
            $idPedido = MainModel::decryption($idPedido);
        }
        return DbModel::consultaSimples("SELECT l.local, ve.valor FROM valor_equipamentos AS ve
            INNER JOIN locais l on ve.local_id = l.id
            WHERE pedido_id = '$idPedido'")->fetchAll(PDO::FETCH_OBJ);
    }

    /**
     * <p>Retorna o valor investido por região</p>
     * @param int|string $idEvento
     * @param int $zona_id <p>1- Norte | 2 - Sul | 3 - Leste | 4 - Oeste | 5 - Centro
     * @return mixed
     */
    public function recuperaValorRegiao($idEvento, int $zona_id)
    {
        $idEvento = MainModel::decryption($idEvento);
        return DbModel::consultaSimples("SELECT SUM(ve.valor) AS valor
            FROM ocorrencias AS o
            INNER JOIN locais l on o.local_id = l.id
            LEFT JOIN valor_equipamentos ve on l.id = ve.local_id
            WHERE o.publicado = 1 AND l.publicado = 1 AND o.origem_ocorrencia_id = '$idEvento' AND l.zona_id = '$zona_id'")->fetchColumn();
    }

    /**
     * @param $idPedido
     * @return object
     */
    public function recuperaParecer($idPedido):stdClass
    {
        if (gettype($idPedido) == "string") {
            $idPedido = MainModel::decryption($idPedido);
        }
        return DbModel::consultaSimples("SELECT * FROM parecer_artisticos WHERE pedido_id = '$idPedido'")->fetchObject();
    }

    /**
     * @param $idPedido
     * @return array
     */
    public function recuperaPedidoEtapas($idPedido)
    {
        if (gettype($idPedido) == "string") {
            $idPedido = MainModel::decryption($idPedido);
        }
        return DbModel::consultaSimples("SELECT * FROM pedido_etapas WHERE pedido_id = '$idPedido'")->fetchAll(PDO::FETCH_OBJ);
    }

    /**
     * <p>Função para verificar se existe um pedido</p>
     * @param int $tipo_origem_id
     * @param int| string $origem_id
     * @return stdClass
     */
    public function existePedido(int $tipo_origem_id, $origem_id)
    {
        $origem_id = MainModel::decryption($origem_id);
        return DbModel::consultaSimples("SELECT id FROM pedidos WHERE origem_tipo_id = '$tipo_origem_id' AND origem_id = '$origem_id' AND publicado = 1")->fetch(PDO::FETCH_OBJ);
    }

    public function recuperarAnos()
    {
        $sql = "SELECT MIN(ano) AS min, MAX(ano) AS max
            FROM pedidos p
            INNER JOIN formacao_contratacoes fc ON fc.id = p.origem_id
            INNER JOIN pessoa_fisicas pf ON fc.pessoa_fisica_id = pf.id
            INNER JOIN verbas v on p.verba_id = v.id
            INNER JOIN formacao_status fs on fc.form_status_id = fs.id
            WHERE fc.form_status_id != 5 AND p.publicado = 1 AND p.origem_tipo_id = 2";
        return DbModel::consultaSimples($sql)->fetchObject();
    }

    public function inserePedidoEtapa(int $idPedido, string $tipo)
    {
        $dateNow = date('Y-m-d H:i:s');
        $status = [];
        $dados = [];
        switch ($tipo){
            case "proposta":
                $status['status_pedido_id'] = 14;
                $dados['data_proposta'] = $dateNow;
                session_start(['name' => 'sis']);
                $idPenal = $_GET['penal'];
                $userContrato = $_SESSION['usuario_id_s'];
                DbModel::consultaSimples("INSERT INTO contratos (pedido_id, penalidade_id,usuario_contrato_id) VALUES ('$idPedido','$idPenal','$userContrato') ON DUPLICATE KEY UPDATE penalidade_id = '$idPenal', usuario_contrato_id = '$userContrato'");
                break;
            case "reserva":
                $status['status_pedido_id'] = 7;
                $dados['data_reserva'] = $dateNow;
                break;
            case "juridico":
                $status['status_pedido_id'] = 15;
                $dados['data_juridico'] = $dateNow;
                break;
            case "contabilidade":
                $status['status_pedido_id'] = 17;
                $dados['data_contabilidade'] = $dateNow;
                break;
            case "pagamento":
                $status['status_pedido_id'] = 19;
                $dados['data_pagamento'] = $dateNow;
                break;
        }
        DbModel::update("pedidos",$status,$idPedido);
        DbModel::updateEspecial("pedido_etapas",$dados,"pedido_id",$idPedido);
    }
}