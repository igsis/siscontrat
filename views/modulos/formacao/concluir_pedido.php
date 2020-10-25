<?php
$id = isset($_GET['id']) ? $_GET['id'] : "";

require_once "./controllers/FormacaoController.php";
$formObj = new FormacaoController();

$pedido = $formObj->recuperaPedido($id);
?>

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-9">
                <h1 class="m-0 text-dark">Conclusão</h1>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="card card-info">
                <div class="card-header">
                    <h4>Concluir pedido de contratação</h4>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="">Número do Processo:</label>
                            <input type="text"
                                   value="<?= isset($pedido->numero_processo) ? $pedido->numero_processo : "" ?>"
                                   class="form-control" disabled>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="">Protocolo:</label>
                            <input type="text" value="<?= isset($pedido->protocolo) ? $pedido->protocolo : "" ?>"
                                   class="form-control" disabled>
                        </div>

                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="">Proponente:</label>
                            <input type="text" value="<?= isset($pedido->nome) ? $pedido->nome : "" ?>"
                                   class="form-control" disabled>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="">Status do Pedido:</label>
                            <input type="text" value="<?= isset($pedido->status) ? $pedido->status : "" ?>"
                                   class="form-control" disabled>
                        </div>
                    </div>
                    <form class="form-horizontal formulario-ajax" action="<?= SERVERURL ?>ajax/formacaoAjax.php"
                          method="POST" data-form="save">
                        <input type="hidden" name="_method" value="concluirPedido">
                        <div class="resposta-ajax"></div>
                </div>

                <div class="card-footer">
                    <a href="<?= SERVERURL ?>formacao/conclusao_busca">
                        <button type="button" class="btn btn-default float-left">Voltar</button>
                    </a>

                        <input type="hidden" name="id" value="<?= $id ?>">
                        <button type="submit" class="btn btn-info float-right">Concluir</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>