<?php
$pedido_id = isset($_GET['id']) ? $_GET['id'] : "";
require_once "./controllers/FormacaoController.php";
require_once "./controllers/PedidoController.php";

$formObj = new FormacaoController();
$pedObj = new PedidoController();

$pedido = $formObj->recuperaPedido($pedido_id);
$pessoa = $formObj->recuperaPf($pedido->pessoa_fisica_id);
$contratacao = $formObj->recuperaContratacao(MainModel::encryption($pedido->origem_id), 1);
$parcelas = $pedObj->getParcelarPedidoFomentos($pedido_id);

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
                                <a href="<?= SERVERURL ?>pdf/rlt_fac_pf.php?id=<?= MainModel::encryption($pedido->pessoa_fisica_id) ?>"
                                   target="_blank">
                                    <button class="btn btn-primary">Gerar FACC</button>
                                </a>

                                <a href="<?= SERVERURL ?>formacao/concluir_pedido&id=<?= $pedido_id ?>"
                                   target="_blank">
                                    <button class="btn btn-primary float-right">Concluir Processo</button>
                                </a>
                            </div>
                        </div>

                        <hr>
                        <table class="table table-striped table-bordered p-0">
                            <thead>
                            <tr>
                                <th>Nº Parcela</th>
                                <th>Período</th>
                                <th>Valor</th>
                                <th>Pagamento</th>
                                <th style="text-align:center">Gerar</th>
                            </tr>
                            </thead>

                            <tbody>
                            <?php foreach ($parcelas as $parcela): ?>
                                <tr>
                                    <td><?= $i ?></td>
                                    <td><?= $parcela->periodo ?></td>
                                    <td><?= "R$" . MainModel::dinheiroParaBr($parcela->valor) ?></td>
                                    <td><?= MainModel::dataParaBR($parcela->data_pagamento) ?></td>

                                    <th class="d-flex justify-content-between align-items-md-center">
                                        <a href="<?= SERVERURL ?>pdf/formacao_pagamento.php?id=<?= $pedido_id ?>&parcela=<?= $parcela->id ?>"
                                           target="_blank" class="btn btn-sm btn-info">
                                            Pagamento
                                        </a>

                                        <a href="<?= SERVERURL ?>pdf/formacao_recibo.php?id=<?= $pedido_id ?>&parcela=<?= $parcela->id ?>"
                                           target="_blank" class="btn btn-sm btn-info">
                                            Recibo
                                        </a>

                                        <a href="<?= SERVERURL ?>pdf/formacao_confirmacao_servicos.php?id=<?= $pedido_id ?>&parcela=<?= $parcela->id ?>"
                                           target="_blank" class="btn btn-sm btn-info">
                                            Atestado Serviço
                                        </a>

                                        <a href="<?= SERVERURL ?>pdf/formacao_chefia_gab.php" target="_blank" class="btn btn-sm btn-info">
                                            Chefia/Gab
                                        </a>

                                        <a href="<?= SERVERURL ?>pdf/formacao_contabilidade.php?id=<?= $pedido_id ?>"
                                           target="_blank" class="btn btn-sm btn-info">
                                            Contabilidade
                                        </a>
                                    </th>
                                </tr>

                                <?php $i++; endforeach; ?>
                            </tbody>

                            <tfoot>
                            <tr>
                                <th>Nº Parcela</th>
                                <th>Período</th>
                                <th>Valor</th>
                                <th>Pagamento</th>
                                <th style="text-align:center">Gerar</th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>

                    <div class="card-footer">

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
