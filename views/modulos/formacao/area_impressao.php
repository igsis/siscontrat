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
                            <div class="card card-cyan">
                                <div class="card-header">
                                    <h4 class="card-title">Pedido</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col">
                                            <a href="<?= SERVERURL ?>pdf/formacao_pedido_contratacao.php?id=<?= $id ?>"
                                               target="_blank">
                                                <button class="btn btn-primary">Pedido de Contratação - Formação</button>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="card card-gray">
                                <div class="card-header">
                                    <h4 class="card-title">Proposta</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col">
                                            <a href="<?= SERVERURL ?>pdf/formacao_proposta_vocacional.php?id=<?= $id ?>"
                                               target="_blank">
                                                <button class="btn btn-primary">Vocacional</button>
                                            </a>
                                        </div>
                                        <div class="col">
                                            <a href="<?= SERVERURL ?>pdf/formacao_proposta_vocacional.php?id=<?= $id ?>"
                                               target="_blank">
                                                <button class="btn btn-primary">PIÁ</button>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="card card-navy">
                                <div class="card-header">
                                    <h4 class="card-title">Outros</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col">
                                            <a href="<?= SERVERURL ?>pdf/rlt_fac_pf.php?id=<?= MainModel::encryption($pf_id) ?>" target="_blank">
                                                <button class="btn btn-primary">FACC</button>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="card card-gray-dark">
                                <div class="card-header">
                                    <h4 class="card-title">Despacho</h4>
                                </div>
                                <div class="card-body">
                                    <div class="col-md-12">
                                        <a href="<?= SERVERURL ?>pdf/formacao_despacho.php?id=<?= $id ?>"
                                           target="_blank">
                                            <button class="btn btn-primary">Vocacional/PIÁ</button>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="card card-purple">
                                <div class="card-header">
                                    <h4 class="card-title">Pedido de Reserva</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col">
                                            <a href="<?= SERVERURL ?>pdf/formacao_reserva.php?id=<?= $id ?>&tipo=vocacional"
                                               target="_blank">
                                                <button class="btn btn-primary">Vocacional</button>
                                            </a>
                                        </div>

                                        <div class="col">
                                            <a href="<?= SERVERURL ?>pdf/formacao_reserva.php?id=<?= $id ?>&tipo=sme"
                                               target="_blank">
                                                <button class="btn btn-primary">VOCACIONAL/PIÁ - SME</button>
                                            </a>
                                        </div>

                                        <div class="col">
                                            <a href="<?= SERVERURL ?>pdf/formacao_reserva.php?id=<?= $id ?>&tipo=pia"
                                               target="_blank">
                                                <button class="btn btn-primary">FORMAÇÃO - PIÁ</button>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
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
