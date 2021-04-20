<?php
if ($pedidoAjax) {
    require_once "../models/PedidoModel.php";
    require_once "../controllers/PessoaFisicaController.php";
    require_once "../controllers/PessoaJuridicaController.php";
    require_once "../controllers/RepresentanteController.php";
    require_once "../controllers/FormacaoController.php";
} else {
    require_once "./models/PedidoModel.php";
    require_once "./controllers/PessoaFisicaController.php";
    require_once "./controllers/PessoaJuridicaController.php";
    require_once "./controllers/RepresentanteController.php";
    require_once "./controllers/FormacaoController.php";
}

class PedidoController extends PedidoModel
{
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
                    $idRep1 = $this->encryption($pfj>representante_legal1_id);
                    $rep1 = $repObj->recuperaRepresentante($idRep1)->fetch(PDO::FETCH_ASSOC);
                    $pedido = array_merge($pedido,$rep1);
                }
                if ($pfj>representante_legal2_id){
                    $idRep2 = $this->encryption($pfj>representante_legal2_id);
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
            $formObj = new FormacaoController();
            $pedido = PedidoModel::recuperaBasePedido($origem_tipo_id, $origem_id);
            $formacao = $formObj->recuperaFormacaoContratacao($origem_id);
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
}