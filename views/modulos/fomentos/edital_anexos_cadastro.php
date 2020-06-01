<?php
require_once "./controllers/FomentoController.php";

$tipo = isset($_GET['tipo']) ?? null;
$edital_id = $_GET['edital'];

$id = isset($_GET['id']) ? $_GET['id'] : null;
$fomentoObj = new FomentoController();

$arquivos = $fomentoObj->recuperaDocumentoEdital($tipo,$id);
?>
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-12">
                <h1 class="m-0 text-dark">Edital <?= $fomentoObj->exibeNomeEdital($edital_id)?></h1>
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
                        <h3 class="card-title">Cadastro de documento</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form class="form-horizontal formulario-ajax" method="POST" action="<?= SERVERURL ?>ajax/fomentoAjax.php" role="form" data-form="<?= ($id) ? "update" : "save" ?>">
                        <input type="hidden" name="_method" value="<?= ($id) ? "editar" : "cadastrar" ?>">
                        <input type="hidden" name="tipo_contratacao_id" value="<?= $tipo ?>">
                        <?php if ($id): ?>
                            <input type="hidden" name="id" id="edital_id" value="<?= $id ?>">
                        <?php endif; ?>
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-md-1">
                                    <label for="ordem">Ordem: *</label>
                                    <input type="number" class="form-control" id="ordem" name="ordem" value="<?= $arquivos->ordem ?? null ?>" required>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="anexo">Anexo: *</label>
                                    <input type="text" class="form-control" id="anexo" name="anexo" value="<?= $arquivos->anexo ?? null ?>" maxlength="10" required>
                                </div>
                                <div class="form-group col-md-7">
                                    <label for="documento">Documento: *</label>
                                    <select class="form-control" name="documento" id="documento">
                                        <option value="">Selecione uma Opção...</option>
                                        <?php $fomentoObj->geraOpcao('fom_lista_documentos', $arquivos->fom_lista_documento_id, false, false, true) ?>
                                    </select>
                                </div>
                                <div class="form-group col-md-1">
                                    <label for="obrigatorio">Obrigatório</label>
                                    <input type="checkbox" class="form-control" id="obrigatorio" name="obrigatorio" value="1"
                                        <?php
                                        if(isset($arquivos->obrigatorio)) {
                                            if ($arquivos->obrigatorio == 1 )
                                                echo 'checked';
                                        }
                                        ?> >
                                </div>
                            </div>
                        </div>
                        <div class="resposta-ajax"></div>
                        <!-- /.card-body -->
                        <div class="card-footer">
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