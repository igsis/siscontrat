<?php
require_once "./controllers/FormacaoController.php";

$formObj = new FormacaoController();

$pedidos = $formObj->listaPedidos();

//Ano máximo
$ano = date("Y");
?>
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-9">
                <h1 class="m-0 text-dark">Pedido de Contratação</h1>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <!-- Horizontal Form -->
                <div class="card card-info card-outline">
                    <div class="card-header">
                        <h3 class="card-title">Listagem</h3>
                        <div class="card-tools">
                            <!-- button with a dropdown -->
                            <button class="btn btn-success btn-sm" data-toggle="modal"
                                    data-target="#modal-exportar-pedido">
                                <i class="fas fa-file-excel"></i> Exportar para Excel
                            </button>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="tabela" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>Protocolo</th>
                                <th>Processo</th>
                                <th>Proponente</th>
                                <th>Local</th>
                                <th>Ano</th>
                                <th>Verba</th>
                                <th>Status</th>
                                <th width="17%">Ações</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($pedidos as $pedido): ?>
                                <tr>
                                    <td><?= $pedido->protocolo ?></td>
                                    <td><?= $pedido->numero_processo ?></td>
                                    <td><?= $pedido->nome ?></td>
                                    <td><?= $formObj->retornaLocaisFormacao($pedido->origem_id) ?></td>
                                    <td><?= $pedido->ano ?></td>
                                    <td><?= $pedido->verba ?></td>
                                    <td><?= $pedido->status ?></td>
                                    <td style="text-align: center">
                                        <a href="<?= SERVERURL . "formacao/pedido_contratacao_cadastro&pedido_id=" . $formObj->encryption($pedido->id) ?>">
                                            <button type="submit" class="btn bg-gradient-primary btn-sm float-left">
                                                <i class="fas fa-user-edit"></i> Editar
                                            </button>
                                        </a>
                                        <form action="<?= SERVERURL ?>ajax/formacaoAjax.php"
                                              class="form-horizontal formulario-ajax" method="POST">
                                            <input type="hidden" name="_method" value="deletarPedido">
                                            <input type="hidden" name="id"
                                                   value="<?= $formObj->encryption($pedido->id) ?>">
                                            <button type="submit" class="btn bg-gradient-danger btn-sm">
                                                <i class="fas fa-trash"></i> Apagar
                                            </button>
                                            <div class="resposta-ajax"></div>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                            <tfoot>
                            <tr>
                                <th>Protocolo</th>
                                <th>Processo</th>
                                <th>Proponente</th>
                                <th>Local</th>
                                <th>Ano</th>
                                <th>Verba</th>
                                <th>Status</th>
                                <th width="17%">Ações</th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-exportar-pedido">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Escolha ano dos pedidods</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="./include/excel_pedido_contrato.php" method="GET" target="_blank">
                <div class="modal-body">
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="ano">Ano:</label>
                                <input type="number" name="ano" class="form-control" min="2020" max="<?= $ano ?>"
                                       value="<?= $ano ?>">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                    <button type="submit" class="btn btn-primary">Exportar</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->