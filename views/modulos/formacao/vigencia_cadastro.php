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
                            <input type="hidden" name="_method" value="<?= ($id) ? "editarParcelaVigencia" : "cadastrarVigencia" ?>">
                            <div class="row">
                                <div class="form-group col-md-2">
                                    <label for="sigla">Ano*: </label>
                                    <input type="number" class="form-control" id="ano" name="ano" maxlength="70" value="<?= $vigencia->ano ?? "" ?>" min="2018" required>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="sigla">Qnt. Parcelas*: </label>
                                    <input type="number" class="form-control" id="numero_parcelas" name="quantidade_parcelas" maxlength="70" value="<?= $vigencia->numero_parcelas ?? "" ?>" min="0" required>
                                </div>
                                <div class="form-group col-md-8">
                                    <label for="sigla">Descricao*: </label>
                                    <input type="text" class="form-control" id="descricao" name="descricao" maxlength="70" value="<?= $vigencia->descricao ?? "" ?>" required>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" name="cadastra" id="cadastra" class="btn btn-primary float-right">
                                Gravar
                            </button>
                        </div>
                        <div class="resposta-ajax"></div>
                    </form>
                </div>

                <?php if ($id) : ?>
                    <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title">Dados das Parcelas</h3>
                        </div>
                        <form class="form-horizontal formulario-ajax" action="<?= SERVERURL ?>ajax/formacaoAjax.php"
                              method="POST" role="form" data-form="update">
                            <input type="hidden" name="id" value="<?= $id ?>">
                            <input type="hidden" name="parcela_id[]" value="<?= $id ?>">
                            <div class="card-body">
                                <input type="hidden" name="_method" value="editarParcelaVigencia">
                                <?php
                                $parcela_vigencia = $vigenciaObj->recuperaParcelasVigencias($id);
                                $i = $vigencia->numero_parcelas;
                                for ($i = 0; $i < $vigencia->numero_parcelas; $i++) {
                                    ?>
                                    <div class="row">
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
                                            <input type="date" name="data_inicio[]" class="form-control" id="data_inicio<?= $i ?>" value="<?= $parcela_vigencia[$i]->data_inicio ?? "" ?>" placeholder="DD/MM/AAAA">
                                        </div>

                                        <div class="form-group col-md-2">
                                            <label for="data_fim">Data final: </label>
                                            <input type="date" name="data_fim[]" class="form-control" id="data_fim<?= $i ?>" value="<?= $parcela_vigencia[$i]->data_fim ?? "" ?>" placeholder="DD/MM/AAAA">
                                        </div>

                                        <div class="form-group col-md-2">
                                            <label for="data_pagamento">Data pagamento: </label>
                                            <input type="date" name="data_pagamento[]" class="form-control" id="data_pagamento<?= $i ?>" value="<?= $parcela_vigencia[$i]->data_pagamento ?? "" ?>" placeholder="DD/MM/AAAA">
                                        </div>

                                        <div class="form-group col-md-2">
                                            <label for="carga[]">Carga horária: </label>
                                            <input type="number" name="carga[]" class="form-control" id="carga<?= $i ?>" value="<?= $parcela_vigencia[$i]->carga_horaria ?? "" ?>" min="1">
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                            <div class="card-footer">
                                <a href="<?= SERVERURL ?>formacao/vigencia_lista" class="btn btn-default pull-left">
                                    Voltar
                                </a>
                                <button type="submit" name="cadastra" id="cadastra" class="btn btn-primary float-right">
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