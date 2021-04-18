<?php
if ($pedidoAjax) {
    require_once "../models/MainModel.php";
} else {
    require_once "./models/MainModel.php";
}


class PedidoModel extends MainModel
{
    protected function recuperaBasePedido ($origem_tipo_id, $origem_id)
    {
        return DbModel::consultaSimples("SELECT p.*, v.verba, ps.status, uc.nome_completo as operador_contrato, up.nome_completo as operador_pagamento 
                FROM pedidos p
                INNER JOIN verbas v on p.verba_id = v.id
                INNER JOIN pedido_status ps on p.status_pedido_id = ps.id
                LEFT JOIN usuarios uc on p.operador_id = uc.id
                LEFT JOIN usuarios up on p.operador_pagamento_id = up.id
                WHERE p.origem_tipo_id = '$origem_tipo_id' AND p.origem_id = '$origem_id' AND p.publicado = 1"
        )->fetch(PDO::FETCH_ASSOC);
    }

}