<?php
require_once "./controllers/PedidoController.php";
$pedidoObj = new PedidoController();
$pedido = $pedidoObj->listaPedidos(2)
?>

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-9">
                <h1 class="m-0 text-dark">Pagamento</h1>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="card-body">
                <div class="row">
                    <div class="col-md">
                        <div class="card card-primary card-tabs">
                            <div class="card-header p-0 pt-1">
                                <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="custom-tabs-one-home-tab" data-toggle="pill" href="#custom-tabs-one-home" role="tab" aria-controls="custom-tabs-one-home" aria-selected="true"><?= date('Y')?></a>
                                    </li>
                                    <!--<li class="nav-item">
                                        <a class="nav-link" id="custom-tabs-one-profile-tab" data-toggle="pill" href="#custom-tabs-one-profile" role="tab" aria-controls="custom-tabs-one-profile" aria-selected="false">Profile</a>
                                    </li>-->
                                </ul>
                            </div>
                            <div class="card-body">
                                <div class="tab-content" id="custom-tabs-one-tabContent">
                                    <div class="tab-pane fade show active" id="custom-tabs-one-home" role="tabpanel" aria-labelledby="custom-tabs-one-home-tab">

                                        <?php $pedidos = $pedidoObj->listaPedidos(2, 2021)?>
                                        <div class="row">
                                            <table id="tabela" class="table table-bordered table-striped">
                                                <thead>
                                                <tr>
                                                    <th>Processo</th>
                                                    <th>Proponente</th>
                                                    <th>Documento</th>
                                                    <th>Verba</th>
                                                    <th>Status</th>
                                                    <th style="width:5%">Nota empenho</th>
                                                    <th style="width:5%">Pagamento</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php foreach ($pedidos as $pedido): ?>
                                                <tr>
                                                    <td><?= $pedido->numero_processo ?></td>
                                                    <td><?= $pedido->proponente ?></td>
                                                    <td><?= $pedido->documento ?></td>
                                                    <td><?= $pedido->verba ?></td>
                                                    <td><?= $pedido->status ?></td>
                                                    <td><a href="<?=SERVERURL?>formacao/empenho_cadastro&id=<?=$pedidoObj->encryption($pedido->id)?>" target="_blank" class="btn btn-sm btn-primary">Empenho</a></td>
                                                    <td><a href="<?=SERVERURL?>formacao/pagamento_lista_parcelas&id=<?=$pedidoObj->encryption($pedido->id)?>" target="_blank" class="btn btn-sm btn-primary">Pagamento</a></td>
                                                </tr>
                                                <?php endforeach;?>
                                                </tbody>
                                                <tfoot>
                                                <tr>
                                                    <th>Processo</th>
                                                    <th>Proponente</th>
                                                    <th>Documento</th>
                                                    <th>Verba</th>
                                                    <th>Status</th>
                                                    <th style="width:5%">Nota empenho</th>
                                                    <th style="width:5%">Pagamento</th>
                                                </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                    <!--<div class="tab-pane fade" id="custom-tabs-one-profile" role="tabpanel" aria-labelledby="custom-tabs-one-profile-tab">
                                        Mauris tincidunt mi at erat gravida, eget tristique urna bibendum. Mauris pharetra purus ut ligula tempor, et vulputate metus facilisis. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Maecenas sollicitudin, nisi a luctus interdum, nisl ligula placerat mi, quis posuere purus ligula eu lectus. Donec nunc tellus, elementum sit amet ultricies at, posuere nec nunc. Nunc euismod pellentesque diam.
                                    </div>-->
                                </div>
                            </div>
                            <!-- /.card -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>