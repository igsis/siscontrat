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
        if (gettype($origem_id) == "string") {
            $origem_id = MainModel::decryption($origem_id);
        }

        /** Tipo Evento */
        if ($origem_tipo_id == 1){
            $pedido = PedidoModel::recuperaBasePedido($origem_tipo_id, $origem_id);

            $parecer = DbModel::consultaSimples("SELECT * FROM parecer_artisticos WHERE pedido_id = '$origem_id'")->fetch(PDO::FETCH_ASSOC);
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
                $pedido = array_merge($pedido,$pj);
                //representante
                $repObj = new RepresentanteController();
                if ($pj->representante_legal1_id){
                    $idRep1 = $this->encryption($pfj->representante_legal1_id);
                    $rep1 = $repObj->recuperaRepresentante($idRep1)->fetch(PDO::FETCH_ASSOC);
                    $pedido = array_merge($pedido,$rep1);
                }
                if ($pfj->representante_legal2_id){
                    $idRep2 = $this->encryption($pfj->representante_legal2_id);
                    $rep2 = $repObj->recuperaRepresentante($idRep2)->fetch(PDO::FETCH_ASSOC);
                    $pedido = array_merge($pedido,$rep2);
                }
            } else{ //pessoa física
                $pfObj = new PessoaFisicaController();
                $idPf = $this->encryption($pedido['pessoa_fisica_id']);
                $pf = $pfObj->recuperaPessoaFisica($idPf);
                $pedido = array_merge($pedido,$pf);
            }
        }
        /** Tipo Formação */
        if ($origem_tipo_id == 2){
            $formObj = new FormacaoContratacaoController();
            $pedido = PedidoModel::recuperaBasePedido($origem_tipo_id, $origem_id);
            $formacao = $formObj->recuperar($origem_id);
            $pedido = array_merge($pedido,array($formacao));
        }
        /** Tipo EMIA */
        if ($origem_tipo_id == 3){
            $pedido = PedidoModel::recuperaBasePedido($origem_tipo_id, $origem_id);
            $emia = array("dados"=>"construir controller emia");
            $pedido = array_merge($pedido,$emia);
        }

        return (object)$pedido;
    }

    public function listaPedidos($origem_tipo_id, $ano = false)
    {
        $pedidos = PedidoModel::listaBasePedido($origem_tipo_id);
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
                $pedido->proponente = $form->nome;
                $pedido->documento = $form->cpf;
                $pedido->protocolo = $form->protocolo;
                $pedido->ano = $form->ano;
            }
        }
        return (object)$pedidos;
    }

    /**
     * @param int $origem_tipo_id
     * @param int|string $origem_id
     * @return string
     * @throws Exception
     */
    public function recuperaFormaPagto(int $origem_tipo_id,$origem_id):string
    {
        if (gettype($origem_id == "string")){
            $origem_id = MainModel::decryption($origem_id);
        }
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

    public function retornaPenalidades($penal_id){
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
    public function existePedido(int $tipo_origem_id, $origem_id):stdClass
    {
        if (gettype($origem_id) == "string") {
            $origem_id = MainModel::decryption($origem_id);
        }
        return DbModel::consultaSimples("SELECT id FROM pedidos WHERE origem_tipo_id = '$tipo_origem_id' AND origem_id = '$origem_id' AND publicado = 1")->fetchObject();
    }
}