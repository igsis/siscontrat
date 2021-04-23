<?php
require_once "./controllers/FormacaoDocumentoController.php";

$id = isset($_GET['id']) ? $_GET['id'] : null;
$documentoObj = new FormacaoDocumentoController();

$documento = $documentoObj->recuperar($id);
?>
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Cadastro de documentos</h1>
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
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form class="form-horizontal formulario-ajax" method="POST" action="<?= SERVERURL ?>ajax/formacaoAjax.php" role="form" data-form="<?= ($id) ? "update" : "save" ?>">
                        <input type="hidden" name="_method" value="<?= ($id) ? "editarDocumento" : "cadastrarDocumento" ?>">
                        <input type="hidden" name="publicado" value="1">
                        <?php if ($id): ?>
                            <input type="hidden" name="id" value="<?= $id ?>">
                        <?php endif; ?>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-7">
                                    <div class="form-group">
                                        <label for="documento">Nome do documento: *</label>
                                        <input type="text" class="form-control" id="documento" name="documento" value="<?= $documento->documento ?? "" ?>" required maxlength="145">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="sigla">Sigla: *</label>
                                        <input type="text" class="form-control" id="sigla" name="sigla" value="<?= $documento->sigla ?? "" ?>" required maxlength="10">
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <div class="form-group">
                                        <label for="ordem">Ordem: *</label>
                                        <input type="number" class="form-control" id="ordem" name="ordem" value="<?= $documento->ordem ?? "" ?>" required maxlength="2">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="sigla">Obrigatório: </label>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="obrigatorio" value="1" <?=$documento ? ($documento->obrigatorio == 1 ? "checked" : "") : ""?>>
                                            <label class="form-check-label">Sim</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" name="obrigatorio" type="radio" value="0" <?=$documento ? ($documento->obrigatorio == 0 ? "checked" : "") : "checked"?>>
                                            <label class="form-check-label">Não</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="resposta-ajax"></div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <a href="<?= SERVERURL ?>formacao/documento_lista" class="btn btn-default float-left">Voltar</a>
                            <button type="submit" class="btn btn-info float-right">Gravar</button>
                        </div>
                        <!-- /.card-footer -->
                        <div class="resposta-ajax"></div>
                    </form>
                </div>
                <!-- /.card -->
            </div>
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content -->