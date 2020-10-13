<?php
$pedido_id = isset($_GET['id']) ? $_GET['id'] : "";
require_once "./controllers/FormacaoController.php";

$formObj = new FormacaoController();

$pedido = $formObj->recuperaPedido($pedido_id);
$pessoa = $formObj->recuperaPf($pedido->pessoa_fisica_id);
$contratacao = $formObj->recuperaContratacao(MainModel::encryption($pedido->origem_id),1);
$parcelas = $formObj->retornaDadosParcelas($pedido->origem_id);

//contador de parcelas
$i = 1;
?>
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-9">
                <h1 class="m-0 text-dark">Pagamento</h1>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-info">
                    <div class="card-header">
                        <h4 class="card-title"><?= $pessoa->nome ?> (<?= $pessoa->cpf ?>)</h4>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="protocolo">Protocolo:</label>
                                <input type="text" class="form-control" value="<?= $contratacao->protocolo ?>"
                                       disabled>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="numero_processo">Número do Processo:</label>
                                <input type="text" class="form-control" value="<?= $pedido->numero_processo ?>"
                                       disabled name="numero_processo">
                            </div>

                            <div class="form-group col-md-4">
                                <label for="local">Local(ais):</label>
                                <input type="text" class="form-control" name="local"
                                       value="<?= $formObj->retornaLocaisFormacao($pedido->origem_id) ?>" disabled>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md">
                                <a href="<?= SERVERURL ?>pdf/rlt_fac_pf.php?id=<?= MainModel::encryption($pedido->pessoa_fisica_id) ?>" target="_blank">
                                    <button class="btn btn-primary float-right">Gerar FACC</button>
                                </a>
                            </div>
                        </div>

                        <hr>

                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th>Parcela</th>
                                        <th>Período</th>
                                        <th>Valor</th>
                                        <th>Pagamento</th>
                                        <th></th>
                                        <th></th>
                                        <th style="text-align:center">Gerar</th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    <?php foreach ($parcelas as $parcela): ?>
                                        <tr>
                                            <td><?= $i ?></td>
                                            <td><?= $formObj->retornaPeriodoFormacao($pedido->origem_id, '', '1', $parcela->id) ?></td>
                                            <td><?= "R$" . MainModel::dinheiroParaBr($parcela->valor) ?></td>
                                            <td><?= MainModel::dataParaBR($parcela->data_pagamento) ?></td>

                                            <th style="text-align:center">
                                                <a href="<?= SERVERURL ?>pdf/formacao_pagamento.php?id=<?= $pedido_id ?>&parcela=<?= $parcela->id ?>"
                                                    target="_blank">
                                                    <button type="button" class="btn btn-primary">Pedido</button>
                                                </a>
                                            </th>

                                            <th style="text-align:center">
                                                <a href="<?= SERVERURL ?>pdf/formacao_recibo.php?id=<?= $pedido_id ?>&parcela=<?= $parcela->id ?>" target="_blank">
                                                    <button type="button" class="btn btn-primary">Recibo</button>
                                                </a>
                                            </th>

                                            <th style="text-align:center">
                                                <a href="<?= SERVERURL ?>pdf/formacao_confirmacao_servicos.php?id=<?= $pedido_id ?>&parcela=<?= $parcela->id ?>" target="_blank">
                                                    <button type="button" class="btn btn-primary">Atestado Serviço</button>
                                                </a>
                                            </th>

                                            <th style="text-align:center">
                                                <a href="<?= SERVERURL ?>pdf/formacao_chefia_gab.php" target="_blank">
                                                    <button type="button" class="btn btn-primary">Chefia/Gab</button>
                                                </a>
                                            </th>

                                            <th style="text-align:center">
                                                <a href="<?= SERVERURL ?>pdf/formacao_contabilidade.php?id=<?= $pedido_id ?>" target="_blank">
                                                    <button type="button" class="btn btn-primary">Contabilidade</button>
                                                </a>
                                            </th>
                                        </tr>

                                        <?php $i++; endforeach; ?>
                                    </tbody>

                                    <tfoot>
                                    <tr>
                                        <th>Parcela</th>
                                        <th>Período</th>
                                        <th>Valor</th>
                                        <th>Pagamento</th>
                                        <th></th>
                                        <th></th>
                                        <th style="text-align:center">Gerar</th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
