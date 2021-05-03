<?php
$id = isset($_GET['pedido_id']) ? $_GET['pedido_id'] : "";
require_once "./controllers/FormacaoController.php";

$formObj = new FormacaoController();

$pf_id = $formObj->recuperaPedido($id)->pessoa_fisica_id;
?>

<div class="content-header">
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
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Área de impressão</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <div class="card">
                                <div class="card-body">
                                    <a href="<?= SERVERURL ?>pdf/formacao_pedido_contratacao.php?id=<?= $id ?>" target="_blank">
                                        <button class="btn btn-primary btn-block">Pedido de Contratação</button>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <!-- ./col -->
                        <div class="col">
                            <div class="card">
                                <div class="card-body">
                                    <a href="<?= SERVERURL ?>pdf/formacao_proposta_vocacional.php?id=<?= $id ?>"  target="_blank">
                                        <button class="btn btn-primary btn-block">Proposta</button>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <!-- ./col -->
                        <div class="col">
                            <div class="card">
                                <div class="card-body">
                                    <a href="<?= SERVERURL ?>pdf/rlt_fac_pf.php?id=<?= MainModel::encryption($pf_id) ?>" target="_blank">
                                        <button class="btn btn-primary btn-block">FACC</button>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <!-- ./col -->
                        <div class="col">
                            <div class="card">
                                <div class="card-body">
                                    <a href="<?= SERVERURL ?>pdf/formacao_despacho.php?id=<?= $id ?>" target="_blank">
                                        <button class="btn btn-primary btn-block">Despacho</button>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <!-- ./col -->
                        <div class="col">
                            <div class="card">
                                <div class="card-body">
                                    <a href="<?= SERVERURL ?>pdf/formacao_reserva.php?id=<?= $id ?>" target="_blank">
                                        <button class="btn btn-primary btn-block">Pedido Reserva</button>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <!-- ./col -->
                    </div>
                </div>
                <div class="card-footer">
                    <a href="<?= SERVERURL ?>formacao/pedido_contratacao_cadastro&pedido_id=<?= $id ?>">
                        <button type="button" class="btn btn-default">Voltar</button>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
