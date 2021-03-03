<?php
require_once "./controllers/AdministrativoController.php";

$id = isset($_GET['id']) ? $_GET['id'] : null;
$verbaObj = new AdministrativoController();

$verbas = $verbaObj->recuperaVerba($id);
?>

<div class="content">
    <div class="content-header">
        <h1>Verbas</h1>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card card-info">
                <div class="card-header">
                    <h4 class="card-title">Cadastro de verba</h4>
                </div>
                <div class="card-body">
                    <form class="form-horizontal formulario-ajax" method="POST"
                          action="<?= SERVERURL ?>ajax/administrativoAjax.php" role="form"
                          data-form="<?= ($id) ? "update" : "save" ?>">
                        <input type="hidden" name="_method" value="<?= ($id) ? "editarVerba" : "cadastrarVerba" ?>">
                        <?php if ($id): ?>
                            <input type="hidden" name="id" id="verba_id" value="<?= $id ?>">
                        <?php endif; ?>
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="nome">Titulo: *</label>
                                <input type="text" name="verba" class="form-control" value="<?= isset($verbas->verba) ? $verbas->verba : "" ?>" required>
                            </div>
                        </div>
                        <div class="resposta-ajax"></div>
                </div>
                <div class="card-footer">
                    <a href="<?= SERVERURL ?>administrativo/verbas">
                        <button type="button" class="btn btn-default">Voltar</button>
                    </a>
                    <button type="submit" class="btn btn-primary float-right">
                        <?= $id == null ? "Cadastrar" : "Gravar" ?>
                    </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
