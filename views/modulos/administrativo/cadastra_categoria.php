<?php
require_once "./controllers/AdministrativoController.php";

$id = isset($_GET['id']) ? $_GET['id'] : null;
$categoriaObj = new AdministrativoController();

$categoriaObj = $categoriaObj->recuperaCategoria($id);
?>

<div class="content">
    <div class="content-header">
        <h1>Categoria</h1>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card card-info">
                <div class="card-header">
                    <h4 class="card-title">Cadastro de categoria</h4>
                </div>
                <div class="card-body">
                    <form class="form-horizontal formulario-ajax" method="POST"
                          action="<?= SERVERURL ?>ajax/administrativoAjax.php" role="form"
                          data-form="<?= ($id) ? "update" : "save" ?>">
                        <input type="hidden" name="_method" value="<?= ($id) ? "editarCategoria" : "cadastrarCategoria" ?>">
                        <?php if ($id): ?>
                            <input type="hidden" name="id" id="categoria_id" value="<?= $id ?>">
                        <?php endif; ?>
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="nome">Categoria da Atração *</label>
                                <input type="text" name="categoria_atracao" class="form-control" value="<?= isset($categoriaObj->categoria_atracao) ? $categoriaObj->categoria_atracao : "" ?>" required>
                            </div>
                        </div>
                        <div class="resposta-ajax"></div>
                </div>
                <div class="card-footer">
                    <a href="<?= SERVERURL ?>administrativo/categoria">
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
