<?php

require_once "./controllers/FormacaoController.php";

$id = isset($_GET['id']) ? $_GET['id'] : null;
$cargoObj = new FormacaoController();

$cargo = $cargoObj->recuperaCargo($id);

?>
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-12">
                <h1 class="m-0 text-dark">Cargo</h1>
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
                    </div> <!-- /.card-header -->
                    <form class="form-horizontal formulario-ajax" action="<?= SERVERURL ?>ajax/formacaoAjax.php" method="POST" role="form" data-form="<?= ($id) ? "update" : "save" ?>">
                        <input type="hidden" name="_method" value="<?= ($id) ? "editarCargo" : "cadastrarCargo" ?>">
                        <?php if ($id) : ?>
                            <input type="hidden" name="id" id="modulo_id" value="<?= $id ?>">
                        <?php endif; ?>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">

                                    <div class="row">
                                        <div class="form-group col-md">
                                            <label for="sigla">Cargo*: </label>
                                            <input type="text" class="form-control" id="cargo" name="cargo" maxlength="70" value="<?= $cargo->cargo ?? "" ?>" required>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md">
                                            <label for="justificativa">Justificativa*: </label>
                                            <textarea name="justificativa" id="justificativa" class="form-control textarea" rows="4" required><?= $cargo->justificativa ?? "" ?></textarea>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div><!-- /.card-body -->
                        <div class="card-footer">
                            <a href="<?= SERVERURL ?>formacao/cargo_lista">
                                <button type="button" class="btn btn-default pull-left">Voltar</button>
                            </a>
                            <button type="submit" name="cadastra" id="cadastra" class="btn btn-primary float-right">
                                Gravar
                            </button>
                        </div>
                        <div class="resposta-ajax"></div>
                    </form>
                </div><!-- /.card-info -->
            </div>
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>