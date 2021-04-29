<?php
$pedido_id = isset($_GET['id']) ? $_GET['id'] : "";
require_once "./controllers/FormacaoNotaEmpenhoController.php";
$formObj = new FormacaoNotaEmpenhoController();

$nota = $formObj->recuperar($pedido_id);
$readonly = "";
if (isset($nota->nota_empenho))
    $readonly = "readonly";

$link_empenho = SERVERURL . "pdf/formacao_ne.php";
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
            <div class="card card-info">
                <div class="card-header">
                    <h4 class="card-title">Nota de empenho</h4>
                </div>

                <div class="card-body">
                    <form action="<?= SERVERURL ?>ajax/formacaoAjax.php" class="form-horizontal formulario-ajax"
                          method="POST" data-form="save" id="formulario">
                        <input type="hidden" name="_method" value="<?= ($nota) ? "editarNotaEmpenho" : "cadastrarNotaEmpenho" ?>">
                        <input type="hidden" name="pedido_id" value="<?= $pedido_id ?? NULL ?>">
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="nota_empenho">Número da Nota de Empenho:</label>
                                <input type="text" name="nota_empenho" id="nota_empenho" maxlength="6"
                                       value="<?= isset($nota->nota_empenho) ? $nota->nota_empenho : "" ?>"
                                       class="form-control" <?= $readonly ?> required>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="emissao_nota_empenho">Data de emissão da nota de empenho:</label>
                                <input type="date" name="emissao_nota_empenho" id="data_emissao"
                                       placeholder="DD/MM/AAAA" class="form-control"
                                       value="<?= isset($nota->emissao_nota_empenho) ? $nota->emissao_nota_empenho : "" ?>"
                                       onchange="comparaData()" <?= $readonly ?> required>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="entrega_nota_empenho">Data de entrega da nota de empenho:</label>
                                <input type="date" name="entrega_nota_empenho" id="data_entrega"
                                       placeholder="DD/MM/AAAA" class="form-control"
                                       value="<?= isset($nota->entrega_nota_empenho) ? $nota->entrega_nota_empenho : "" ?>"
                                       onchange="comparaData()" <?= $readonly ?> required>
                            </div>
                        </div>
                        <div class="row" id="msg">
                            <div class="form-group col-md-12">
                                <span class="float-right" style="color: red;"><b>Data de entrega precisa ser maior ou igual a de emissão!</b></span>
                            </div>
                        </div>
                        <?php if (isset($nota->nota_empenho)): ?>
                            <button type="button" class="btn btn-primary float-right" id="btnEditar" onclick="habilitarEdicao()">
                                Editar nota de empenho
                            </button>
                        <?php endif; ?>

                        <div class="resposta-ajax"></div>
                </div>
                <input type="hidden" name="usuario_pagamento_id" value="<?= $_SESSION['usuario_id_s'] ?>">

                <div class="card-footer">
                    <a href="<?= SERVERURL ?>formacao/pagamento_busca">
                        <button type="button" class="btn btn-default">Voltar</button>
                    </a>
                    <?php if (isset($nota->nota_empenho)): ?>
                        <a href="<?= SERVERURL ?>pdf/formacao_ne.php?id=<?= $pedido_id ?>" target="_blank">
                            <button type="button" class="btn btn-warning float-right" id="btnEmitir">
                                Emitir nota de empenho
                            </button>
                        </a>
                    <?php else: ?>
                        <button type="submit" class="btn btn-info float-right" id="btn">
                            Cadastrar
                        </button>
                    <?php endif; ?>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function comparaData() {
        var msg = $('#msg');
        var dataInicio = document.querySelector('#data_emissao').value;
        var dataFim = document.querySelector('#data_entrega').value;
        let btn = $('#btn')

        msg.hide();

        if (dataInicio != "" && dataFim != "") {
            var dataInicio = parseInt(dataInicio.split("-")[0].toString() + dataInicio.split("-")[1].toString() + dataInicio.split("-")[2].toString());
            var dataFim = parseInt(dataFim.split("-")[0].toString() + dataFim.split("-")[1].toString() + dataFim.split("-")[2].toString());
            msg.hide();
        }

        btn.attr("disabled", true);

        if (dataFim < dataInicio) {
            btn.attr("disabled", true);
            msg.show();
        } else {
            btn.attr("disabled", false);
            msg.hide();
        }
    }

    $(document).ready(comparaData());

    function habilitarEdicao() {
        var notaEmpenho = document.getElementById('nota_empenho');
        var dataEmissao = document.getElementById('data_emissao');
        var dataEntrega = document.getElementById('data_entrega');
        var btnEmitir  = document.getElementById('btnEmitir');

        if (notaEmpenho.readOnly == true){
            notaEmpenho.readOnly = false;
            dataEmissao.readOnly = false;
            dataEntrega.readOnly = false;
            btnEmitir.disabled = true;
        } else {
            document.getElementById('btnEditar').type = 'submit';
        }
    }
</script>