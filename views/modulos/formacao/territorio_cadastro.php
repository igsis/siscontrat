<?php

require_once "./controllers/FormacaoTerritorioController.php";

$id = isset($_GET['id']) ? $_GET['id'] : null;
$territorioObj = new FormacaoTerritorioController();

$territorio = $territorioObj->recuperar($id);

?>
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-12">
                <h1 class="m-0 text-dark">Território</h1>
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
                        <input type="hidden" name="_method" value="<?= ($id) ? "editarTerritorio" : "cadastrarTerritorio" ?>">
                        <?php if ($id) : ?>
                            <input type="hidden" name="id" id="modulo_id" value="<?= $id ?>">
                        <?php endif; ?>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="row">
                                        <div class="form-group col">
                                            <label for="sigla">Território: *</label>
                                            <input type="text" class="form-control" id="territorio" name="territorio" maxlength="15" value="<?= $territorio->territorio ?? "" ?>" required>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div> <!-- /.card-body -->
                        <div class="card-footer">
                            <a href="<?= SERVERURL ?>formacao/territorio_lista">
                                <button type="button" class="btn btn-default pull-left">Voltar</button>
                            </a>
                            <button type="submit" name="cadastra" id="cadastra" class="btn btn-primary float-right">
                                Gravar
                            </button>
                        </div>
                        <div class="resposta-ajax"></div>
                    </form>
                </div> <!-- /.card-info -->
            </div>
        </div> <!-- /.row -->
    </div><!-- /.container-fluid -->
</div>