<?php
if ($pedidoAjax) {
    require_once "../models/MainModel.php";
} else {
    require_once "./models/MainModel.php";
}

class LiquidacaoController extends MainModel
{
    /**
     * @param int|string $idPedido
     * @return stdClass
     */
    public function recuperaLiquidacao($idPedido):stdClass
    {
        $idPedido = MainModel::decryption($idPedido);
        return DbModel::consultaSimples("SELECT * FROM liquidacao WHERE pedido_id = '$idPedido'")->fetchObject();
    }
}