<?php
require_once "./controllers/FormacaoController.php";

$formObj = new FormacaoController();

$anoPedido = isset($_GET['ano']) ? $_GET['ano'] : 0;
$pedidoEnviado = isset($_GET['pedidoEnviado']) ? $_GET['pedidoEnviado'] : 0;


if ($anoPedido || $pedidoEnviado) {
    $pedidos = $formObj->listaPedidos($anoPedido, $pedidoEnviado);
} else {
    $pedidos = $formObj->listaPedidos();
}

$anos = $formObj->anosPedido();

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
                            <a href="<?= SERVERURL ?>formacao/pedido_contratacao_lista&pedidoEnviado=2"
                               class="btn btn-info btn-sm">Enviados</a>
                            <a href="<?= SERVERURL ?>formacao/pedido_contratacao_lista&pedidoEnviado=3"
                               class="btn btn-info btn-sm">Não Enviados</a>
                            <button class="btn bg-purple btn-sm" data-toggle="modal"
                                    data-target="#modal-escolher-ano">
                                <i class="far fa-calendar"></i>
                                Escolha o Ano
                            </button>
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
                                <th style="width:17%">Ações</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($pedidos as $pedido): ?>
                                <tr>
                                    <td><?= $pedido->protocolo ?></td>
                                    <td><?= $pedido->numero_processo ?></td>
                                    <td><?= $pedido->nome_social != null ? "$pedido->nome ($pedido->nome_social)" : $pedido->nome ?></td>
                                    <td><?= $formObj->retornaLocaisFormacao($pedido->origem_id) ?></td>
                                    <td><?= $pedido->ano ?></td>
                                    <td><?= $pedido->verba ?></td>
                                    <td><?= $pedido->status ?></td>
                                    <td style="text-align: center">
                                        <div class="row">
                                            <div class="col">
                                                <a href="<?= SERVERURL . "formacao/pedido_contratacao_cadastro&pedido_id=" . $formObj->encryption($pedido->id) ?>">
                                                    <button type="submit"
                                                            class="btn bg-gradient-primary btn-sm float-left">
                                                        <i class="fas fa-user-edit"></i> Editar
                                                    </button>
                                                </a>
                                            </div>
                                            <div class="col">
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
                                            </div>
                                        </div>
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
                                <th style="width:17%">Ações</th>
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
            <form action="<?= SERVERURL ?>pdf/formacao_pedido_excel.php" method="GET" target="_blank">
                <div class="modal-body">
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="ano">Ano:</label>
                                <input type="number" name="ano" class="form-control" min="<?= $anos->min ?>"
                                       max="<?= $anos->max ?>"
                                       value="<?= $anos->min ?>">
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
    </div>
</div>

<div class="modal fade" id="modal-escolher-ano">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Escolha Ano dos Pedidodos</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label for="ano">Ano:</label>
                            <input type="number" name="ano" id="ano" class="form-control" min="<?= $anos->min ?>"
                                   max="<?= $anos->max ?>"
                                   value="<?= $anos->min ?>">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                <button class="btn btn-primary" id="btn-filtrar">Filtrar</button>
            </div>
        </div>
    </div>
</div>

<script>
    let btnFiltrar = document.querySelector('#btn-filtrar');
    let url = "<?= SERVERURL ?>formacao/pedido_contratacao_lista";

    btnFiltrar.addEventListener('click', () => {
        let ano = document.querySelector('#ano').value;
        window.location.href = `${url}&ano=${ano}`;
    });

</script>