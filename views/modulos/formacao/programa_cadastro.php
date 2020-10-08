<?php

require_once "./controllers/FormacaoController.php";

$id = isset($_GET['id']) ? $_GET['id'] : null;
$programaObj = new FormacaoController();
$programa = $programaObj->recuperaPrograma($id);
$verbaObj = new FormacaoController();
$listaVerba = $verbaObj->listaVerbas();
?>
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-12">
                <h1 class="m-0 text-dark">Programa</h1>
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
                        <h3 class="card-title">Dados</h3>
                    </div><!-- /.card-header -->
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <form class="form-horizontal formulario-ajax" action="<?= SERVERURL ?>ajax/formacaoAjax.php" method="POST" role="form" data-form="<?= ($id) ? "update" : "save" ?>">
                                    <input type="hidden" name="_method" value="<?= ($id) ? "editarPrograma" : "cadastrarPrograma" ?>">
                                    <?php if ($id) : ?>
                                        <input type="hidden" name="id" id="modulo_id" value="<?= $id ?>">
                                    <?php endif; ?>
                                    <div class="row">
                                        <div class="form-group col-md-4">
                                            <label for="programa">Programa: *</label>
                                            <input type="text" id="programa" name="programa" required value="<?= $programa->programa ?? "" ?>" class="form-control">
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="edital">Edital: *</label>
                                            <input type="text" id="edital" name="edital" required value="<?= $programa->edital ?? "" ?>" class="form-control">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="verba">Verba: *</label>
                                            <select name="verba_id" id="verba_id" required class="form-control select2bs4">
                                                <option value="">Selecione uma opção</option>
                                                <?php $programaObj->geraOpcao("verbas", $programa->verba_id ?? "") ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-12">
                                            <label for="descricao">Descrição: *</label>
                                            <textarea name="descricao" id="descricao" rows="3" required class="form-control"><?= $programa->descricao ?? "" ?></textarea>
                                        </div>
                                    </div>
                                    <div class="resposta-ajax"></div>
                            </div>
                        </div>
                    </div><!-- /.card-body -->
                    <div class="card-footer">
                        <a href="<?= SERVERURL ?>formacao/programa_lista">
                            <button type="button" class="btn btn-default pull-left">Voltar</button>
                        </a>
                        <button type="submit" name="cadastra" id="cadastra" class="btn btn-primary float-right">
                            Gravar
                        </button>
                    </div>
                    </form>
                </div><!-- /.card-info-->
            </div>
        </div> <!-- /.row -->
    </div><!-- /.container-fluid -->
</div>