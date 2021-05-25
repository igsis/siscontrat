<?php
if ($pedidoAjax) {
    require_once "../models/MainModel.php";
} else {
    require_once "./models/MainModel.php";
}

class NotaEmpenhoController extends MainModel
{
    /**
     * @param int|string $idPedido
     * @return stdClass
     */
    public function recuperaNotaEmpenho($idPedido):stdClass
    {
        $idPedido = MainModel::decryption($idPedido);
        return DbModel::consultaSimples("SELECT * FROM pagamentos WHERE pedido_id='$idPedido'")->fetchObject();
    }
}