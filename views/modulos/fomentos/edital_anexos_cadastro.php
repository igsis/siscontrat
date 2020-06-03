<?php
require_once "./controllers/FomentoController.php";

$id = isset($_GET['id']) ? $_GET['id'] : null;
$fomentoObj = new FomentoController();

$edital_id = $_GET['edital'] ?? null;
$tipo = $fomentoObj->recuperaTipoEdital($edital_id);

$arquivos = $fomentoObj->recuperaDocumentoEdital($id);
?>
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-12">
                <h1 class="m-0 text-dark">Cadastro de documento</h1>
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
                        <h3 class="card-title">Edital <?= $fomentoObj->exibeNomeEdital($edital_id)?></h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form class="form-horizontal formulario-ajax" method="POST" action="<?= SERVERURL ?>ajax/fomentoAjax.php" role="form" data-form="<?= ($id) ? "update" : "save" ?>">
                        <input type="hidden" name="_method" value="<?= ($id) ? "editarAnexo" : "cadastrarAnexo" ?>">
                        <input type="hidden" name="edital_id" value="<?=$edital_id?>">
                        <?php if ($id): ?>
                            <input type="hidden" name="id" id="id" value="<?= $id ?>">
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
                                    <label for="fom_lista_documento_id">Documento: *</label>
                                    <select class="form-control" name="fom_lista_documento_id" id="fom_lista_documento_id">
                                        <option value="">Selecione uma Opção...</option>
                                        <?php $fomentoObj->geraOpcao('fom_lista_documentos', $arquivos->fom_lista_documento_id, false, false, true) ?>
                                    </select>
                                </div>
                                <div class="form-group col-md-1">
                                    <label for="obrigatorio">Obrigatório</label>
                                    <input type="checkbox" class="form-control" id="obrigatorio" name="obrigatorio" value="1"
                                        <?php
                                        if(isset($arquivos->obrigatorio)) {
                                            if ($arquivos->obrigatorio == 1 ) {
                                                echo 'checked';
                                            }
                                        }
                                        ?> >
                                </div>
                            </div>
                        </div>
                        <div class="resposta-ajax"></div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <a href="<?= SERVERURL.'fomentos/edital_anexos&id='.$edital_id ?>" class="btn btn-default">Voltar</a>
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