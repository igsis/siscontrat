<?php

require_once "./controllers/FormacaoController.php";

$id = isset($_GET['id']) ? $_GET['id'] : "";
$vigenciaObj = new FormacaoController();
$vigencia = $vigenciaObj->recuperaVigencia($id);

?>
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-12">
                <h1 class="m-0 text-dark">Vigência</h1>
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
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">Dados da Vigencia</h3>
                    </div>
                    <form class="form-horizontal formulario-ajax" action="<?= SERVERURL ?>ajax/formacaoAjax.php" method="POST" role="form" data-form="<?= ($id) ? "update" : "save" ?>">
                        <div class="card-body">
                            <input type="hidden" name="_method" value="<?= ($id) ? "editarVigencia" : "cadastrarVigencia" ?>">
                            <?php if ($id): ?>
                                <input type="hidden" name="id" value="<?= $id ?>">
                            <?php endif ?>
                            <div class="row">
                                <div class="form-group col-md-2">
                                    <label for="sigla">Ano*: </label>
                                    <input type="number" class="form-control" id="ano" name="ano" maxlength="70" value="<?= $vigencia->ano ?? "" ?>" min="2018" required>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="sigla">Qnt. Parcelas*: </label>
                                    <input type="number" class="form-control" id="numero_parcelas" name="numero_parcelas" maxlength="70" value="<?= $vigencia->numero_parcelas ?? "" ?>" min="0" required>
                                </div>
                                <div class="form-group col-md-8">
                                    <label for="sigla">Descricao*: </label>
                                    <input type="text" class="form-control" id="descricao" name="descricao" maxlength="70" value="<?= $vigencia->descricao ?? "" ?>" required>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" name="cadastraVigencia" id="cadastraVigencia" class="btn btn-primary float-right">
                                Gravar
                            </button>
                        </div>
                        <div class="resposta-ajax"></div>
                    </form>
                </div>

                <?php if ($id) : ?>
                    <?php
                    $parcela_vigencia = $vigenciaObj->recuperaParcelasVigencias($id);
                    ?>
                    <div class="card <?= (!$parcela_vigencia) ? "card-danger" : "card-info"?>">
                        <div class="card-header">
                            <h3 class="card-title">Dados das Parcelas <?= (!$parcela_vigencia) ? '- <strong>Ainda não Cadastrados</strong>' : ''?></h3>
                        </div>
                        <form class="form-horizontal formulario-ajax" action="<?= SERVERURL ?>ajax/formacaoAjax.php"
                              method="POST" role="form" data-form="<?= $parcela_vigencia ? "update" : "save" ?>">
                            <input type="hidden" name="id" value="<?= $id ?>">
                            <div class="card-body">
                                <input type="hidden" name="_method" value="<?= $parcela_vigencia ? "editarParcelaVigencia" : "cadastrarParcelaVigencia" ?>">
                                <?php
                                $i = $vigencia->numero_parcelas;
                                for ($i = 0; $i < $vigencia->numero_parcelas; $i++) {
                                    ?>
                                    <?php if ($parcela_vigencia): ?>
                                        <input type="hidden" name="parcela_id[]" value="<?= $parcela_vigencia[$i]->id ?>">
                                    <?php endif ?>
                                    <div class="row linhaParcela">
                                        <div class="form-group col-md-2">
                                            <label for="parcela[]">Parcela:</label>
                                            <input type="number" readonly class="form-control" value="<?= $i + 1 ?>" name="numero_parcelas[]" id="parcela[]" required>
                                        </div>

                                        <div class="form-group col-md-2">
                                            <label for="valor[]">Valor:</label>
                                            <input type="text" id="valor<?= $i ?>" name="valor[]" onKeyPress="return(moeda(this,'.',',',event))" value="<?= $parcela_vigencia[$i]->valor ?? "" ?>" class="form-control valor">
                                        </div>

                                        <div class="form-group col-md-2">
                                            <label for="data_inicio">Data inicial:</label>
                                            <input type="date" name="data_inicio[]" class="form-control validaDatas" id="data_inicio_<?= $i ?>" value="<?= $parcela_vigencia[$i]->data_inicio ?? "" ?>" placeholder="DD/MM/AAAA">
                                            <span id="data_inicio_<?= $i ?>-error" class="error invalid-feedback">Esta <strong>data inicial</strong> deve ser maior que a <strong>data de pagamento</strong> anterior</span>
                                        </div>

                                        <div class="form-group col-md-2">
                                            <label for="data_fim">Data final: </label>
                                            <input type="date" name="data_fim[]" class="form-control validaDatas" id="data_fim_<?= $i ?>" value="<?= $parcela_vigencia[$i]->data_fim ?? "" ?>" placeholder="DD/MM/AAAA">
                                            <span id="data_fim_<?= $i ?>-error" class="error invalid-feedback">A <strong>data final</strong> deve ser maior que a <strong>data inicial</strong></span>
                                        </div>

                                        <div class="form-group col-md-2">
                                            <label for="data_pagamento">Data pagamento: </label>
                                            <input type="date" name="data_pagamento[]" class="form-control validaDatas" id="data_pagamento_<?= $i ?>" value="<?= $parcela_vigencia[$i]->data_pagamento ?? "" ?>" placeholder="DD/MM/AAAA">
                                            <span id="data_pagamento_<?= $i ?>-error" class="error invalid-feedback">A <strong>data de pagamento</strong> deve ser maior que a <strong>data final</strong></span>
                                        </div>

                                        <div class="form-group col-md-2">
                                            <label for="carga[]">Carga horária: </label>
                                            <input type="number" name="carga_horaria[]" class="form-control validaDatas" id="carga_horaria_<?= $i ?>" value="<?= $parcela_vigencia[$i]->carga_horaria ?? "" ?>" min="1">
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                            <div class="card-footer">
                                <a href="<?= SERVERURL ?>formacao/vigencia_lista" class="btn btn-default pull-left">
                                    Voltar
                                </a>
                                <button type="submit" name="cadastraParcelas" id="cadastraParcelas" class="btn btn-primary float-right">
                                    Gravar
                                </button>
                            </div>
                            <div class="resposta-ajax"></div>
                        </form>
                    </div>
                <?php endif ?>
            </div>
        </div>  <!-- /.row -->
    </div><!-- /.container-fluid -->
</div>

<script>
    $('.validaDatas').blur(function () {
        $('.linhaParcela').each(function (key) {
            let data_inicio = new Date($('#data_inicio_' + key).val());
            let data_fim = new Date($('#data_fim_' + key).val());
            let data_pagamento = new Date($('#data_pagamento_' + key).val());

            if (data_fim.getTime() <= data_inicio.getTime()) {
                $('#data_fim_' + key).addClass('is-invalid');
            } else {
                $('#data_fim_' + key).removeClass('is-invalid');
            }

            if (data_pagamento.getTime() <= data_fim.getTime()) {
                $('#data_pagamento_' + key).addClass('is-invalid');
            } else {
                $('#data_pagamento_' + key).removeClass('is-invalid');
            }

            if (key > 0) {
                let data_pagamento_anterior = new Date($('#data_pagamento_' + (key-1)).val());

                if (data_inicio.getTime() <= data_pagamento_anterior.getTime()) {
                    $('#data_inicio_' + key).addClass('is-invalid');
                } else {
                    $('#data_inicio_' + key).removeClass('is-invalid');
                }
            }
        });

        if ($('.is-invalid').length) {
            $('#cadastraParcelas').attr('disabled', true)
        } else {
            $('#cadastraParcelas').attr('disabled', false)
        }
    });
</script>