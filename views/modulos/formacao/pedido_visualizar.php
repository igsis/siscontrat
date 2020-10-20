<?php
$pedido_id = isset($_GET['pedido_id']) ? $_GET['pedido_id'] : "";
require_once "./controllers/FormacaoController.php";

$formObj = new FormacaoController();
if ($pedido_id != ''):
    $pedido = $formObj->recuperaPedido($pedido_id);
    $contratacao_id = $pedido->origem_id;
    $contratacao = $formObj->recuperaContratacao($contratacao_id);
endif;

?>
<div class="content-header" xmlns="http://www.w3.org/1999/html">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-9">
                <h1 class="m-0 text-dark">Pedido de Contratação</h1>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="card card-info">
                <div class="card-header">
                    <h4 class="card-title">Resumo de Pedido de Contratação</h4>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-md">
                            <b>Código de Dados para Contratação:</b> <?= $contratacao->id ?>
                        </div>

                        <div class="form-group col-md">
                            <b>Proponente:</b> <?= $contratacao->nome_pf ?>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="form-group col-md">
                            <b>Objeto:</b> <?= isset($_GET['contratacao_id']) ? $formObj->retornaObjetoFormacao($contratacao_id, '1') : $formObj->retornaObjetoFormacao($contratacao_id) ?>

                        </div>

                        <div class="form-group col-md">
                            <b>Local(ais): </b> <?= isset($_GET['contratacao_id']) ? $formObj->retornaLocaisFormacao($contratacao_id, '', '1') : $formObj->retornaLocaisFormacao($contratacao_id) ?>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="form-group col-md">
                            <b>Período:</b> <?= isset($_GET['contratacao_id']) ? $formObj->retornaPeriodoFormacao($contratacao_id, '1') : $formObj->retornaPeriodoFormacao($contratacao_id) ?>
                        </div>

                        <div class="form-group col-md">
                            <b>Carga Horária:</b> <?= isset($_GET['contratacao_id']) ? $formObj->retornaCargaHoraria($contratacao_id, '1') : $formObj->retornaCargaHoraria($contratacao_id) ?>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="form-group col-md">
                            <b>Valor: (R$)</b> <?= isset($_GET['contratacao_id']) ? MainModel::dinheiroParaBr($formObj->retornaValorTotalVigencia($contratacao_id, '1')) : MainModel::dinheiroParaBr($formObj->retornaValorTotalVigencia($contratacao_id)) ?>
                        </div>

                        <div class="form-group col-md">
                            <b>Verba:</b> <?= $contratacao->verba ?>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="form-group col-md">
                            <b>Forma de pagamento: </b> <?= isset($pedido->forma_pagamento) ? $pedido->forma_pagamento : "" ?></textarea>
                        </div>

                        <div class="form-group col-md">
                            <b>Justificativa: </b> <?= isset($pedido->justificativa) ? $pedido->justificativa : "" ?>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md">
                            <b>Observação:</b> <?= isset($pedido->observacao) ? $pedido->observacao : "" ?>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="form-group col-md">
                            <b>Número do Processo: </b> <?= isset($pedido->numero_processo) ? $pedido->numero_processo : "" ?>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="form-group col-md">
                            <b>Fiscal:</b> <?= isset($contratacao->fiscal) ? $contratacao->fiscal : "" ?>
                        </div>

                        <div class="form-group col-md">
                            <b>Suplente:</b> <?= isset($contratacao->suplente) ? $contratacao->suplente : "" ?>
                        </div>
                    </div>

                </div>

                <div class="card-footer">
                    <div class="row">
                        <div class="col-md">
                            <a href="<?= SERVERURL ?>formacao/pf_lista">
                                <button type="button" class="btn btn-default">Voltar</button>
                            </a>
                        </div>

                        <div class="col-md" style="text-align: center">
                            <a href="<?= SERVERURL ?>formacao/area_impressao&pedido_id=<?= $pedido_id ?>">
                                <button type="button" class="btn btn-success float-right">Ir para área de impressão</button>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

