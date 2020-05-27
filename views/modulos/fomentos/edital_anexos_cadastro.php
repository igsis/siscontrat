<?php
require_once "./controllers/FomentoController.php";

$tipo = $_GET['tipo'];

$id = isset($_GET['id']) ? $_GET['id'] : null;
$fomentoObj = new FomentoController();

$arquivos = $fomentoObj->listaArquivosEdital($id)->fetch(PDO::FETCH_OBJ);
?>
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Cadastro de editais</h1>
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
                    <form class="form-horizontal formulario-ajax" method="POST" action="<?= SERVERURL ?>ajax/fomentoAjax.php" role="form" data-form="<?= ($id) ? "update" : "save" ?>">
                        <input type="hidden" name="_method" value="<?= ($id) ? "editar" : "cadastrar" ?>">
                        <input type="hidden" name="tipo_contratacao_id" value="<?= $tipo ?>">
                        <?php if ($id): ?>
                            <input type="hidden" name="id" id="edital_id" value="<?= $id ?>">
                        <?php endif; ?>
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-md-2">
                                    <label for="ordem">Ordem: *</label>
                                    <input type="number" class="form-control" id="ordem" name="ordem" value="<?= $arquivos->ordem ?? null ?>" required>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="anexo">Anexo: *</label>
                                    <input type="text" class="form-control" id="anexo" name="anexo" value="<?= $arquivos->anexo ?? null ?>" maxlength="10" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="documento">Documento: *</label>
                                    <select>

                                    </select>
                                </div>
                                <div class="form-group col-md-1">
                                    <label for="obrigatorio">Obrigatório</label>
                                    <input>
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