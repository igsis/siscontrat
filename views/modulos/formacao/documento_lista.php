<?php
require_once "./controllers/FormacaoDocumentoController.php";
$documentoObj = new FormacaoDocumentoController();

$documentos = $documentoObj->listar();
?>
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-9">
                <h1 class="m-0 text-dark">Documentos cadastrados</h1>
            </div><!-- /.col -->
            <div class="col-sm-3">
                <a href="<?= SERVERURL ?>formacao/documento_cadastro"><button class="btn btn-success btn-block">Adicionar</button></a>
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
                        <h3 class="card-title">Lista</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="tabela" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>Documento</th>
                                <th>Sigla</th>
                                <th>Ordem</th>
                                <th>Obrigatório</th>
                                <th>Ação</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($documentos as $documento): ?>
                                <tr>
                                    <td><?=$documento->documento?></td>
                                    <td><?=$documento->sigla?></td>
                                    <td><?=$documento->ordem?></td>
                                    <td><?= $documento->obrigatorio == 1 ? "Obrigatório" : "Opcional" ?></td>
                                    <td>
                                        <div class="row">
                                            <div class="col-md">
                                                <a href="<?= SERVERURL . "formacao/documento_cadastro&id=" . $documentoObj->encryption($documento->id) ?>" class="btn btn-sm btn-primary">
                                                    <i class="fas fa-edit"></i> Editar
                                                </a>
                                            </div>
                                            <div class="col-md">
                                                <form class="form-horizontal formulario-ajax" method="POST" action="<?=SERVERURL?>ajax/formacaoAjax.php" role="form" data-form="update">
                                                    <input type="hidden" name="_method" value="apagarDocumento">
                                                    <input type="hidden" name="id" value="<?= $documentoObj->encryption($documento->id)?>">
                                                    <button type="submit" class="btn btn-sm btn-danger">
                                                        <i class="fas fa-trash"></i> Apagar
                                                    </button>
                                                    <div class="resposta-ajax"></div>
                                                </form>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                            <tfoot>
                            <tr>
                                <th>Documento</th>
                                <th>Sigla</th>
                                <th>Ação</th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content -->