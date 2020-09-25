<?php
$id = isset($_GET['id']) ? $_GET['id'] : "";
require_once "./controllers/formacaoController.php";

$pedidoObj = new FormacaoController();

$pedido = $pedidoObj->recuperaPedido($id);
$parcelas = $pedidoObj->recuperaParcelasPedido($id);
?>
<div class="content-header">
    <div class="container-fluid">
        <div class="row md-2">
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
                    <h4 class="card-title">Editar parcelas do pedido</h4>
                </div>

                <div class="card-body">
                    <form action="<?= SERVERURL ?>ajax/formacaoAjax.php" method="POST"
                          class="form-horizontal formulario-ajax"
                          data-form="<?= ($id) ? "update" : "save" ?>">
                        <input type="hidden" name="_method" value="<?= ($id) ? "editarParcela" : "cadastrarParcela" ?>">
                        <?php if ($id): ?>
                            <input type="hidden" name="id" value="<?= $id ?>">
                        <?php endif; ?>
                        <?php for ($i = 0; $i < $pedido->numero_parcelas; $i++): ?>
                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <label for="parcela[]">Parcela:</label>
                                        <input type="text" readonly class="form-control" value="<?= $i + 1 ?>"
                                               name="numero_parcela[]" required>
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label for="valor[]">Valor:</label>
                                        <input type="text" name="valor[<?= $i ?>]"
                                               class="form-control valor" maxlength="10"
                                               value="<?= isset($parcelas[$i]->valor) ? MainModel::dinheiroParaBr($parcelas[$i]->valor) : "" ?>">
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label for="data_pagamento">Data pagamento: </label>
                                        <input type="date" name="data_pagamento[<?= $i ?>]" class="form-control"
                                               placeholder="DD/MM/AAAA"
                                               value="<?= isset($parcelas[$i]->data_pagamento) ? $parcelas[$i]->data_pagamento : "" ?>">
                                    </div>
                                </div>
                        <?php endfor; ?>
                        <div class="resposta-ajax"></div>
                </div>

                <div class="card-footer">
                    <div class="row">
                        <div class="col-md-4">
                            <strong> Valor Total: </strong> R$
                            <span id="valorTotal" data-id="<?= $pedido->valor_total ?>"> <?= MainModel::dinheiroParaBr($pedido->valor_total) ?></span>
                        </div>

                        <div class="col-md-4">
                            <strong> Valor somado das parcelas: </strong> R$
                            <span id="totalSomado"> <?= MainModel::dinheiroParaBr($pedido->valor_total) ?></span>
                        </div>
                    <div class="col-md-4">
                        <input type="hidden" value="#" name="idPedido">
                        <input type="hidden" value="<?= $pedido->numero_parcelas ?>" name="numParcelas">
                        <button type="submit" name="parcelaEditada" id="grava"
                                class="btn btn-primary float-right">
                            Gravar
                        </button>
                    </div>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    let msgValorErrado = $('#msgValorErrado');
    msgValorErrado.hide();
    var valorSomado = $('#totalSomado');

    function valores() {
        var total = parseFloat($('#valorTotal').attr('data-id'));
        var sum = 0;
        let msgValorOk = $('#msgValorOk');
        var btnGravar = $('#grava');

        $(".valor").each(function () {
            let valor = $(this).val().replace('.', '').replace(',', '.');
            sum += +valor;
        });

        var diferenca = total - sum;

        valorSomado.text(sum.toLocaleString('pt-br', {minimumFractionDigits: 2}));

        if (diferenca != 0) {
            btnGravar.attr('disabled', true);
            msgValorOk.hide();
            msgValorErrado.show();
        } else {
            btnGravar.attr('disabled', false);
            msgValorOk.show();
            msgValorErrado.hide();
        }
    }
    $(document).ready(valores);
    $('.valor').keyup(valores);

    $(document).ready(function () {
        $('.valor').mask('00.000,00', {reverse: true});
    });
</script>