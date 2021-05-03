<?php
require_once "./controllers/FormacaoEditalController.php";

$formacaoObj =  new FormacaoEditalController();
$aberturas = $formacaoObj->listar();

?>

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-9">
                <h1 class="m-0 text-dark">Abertura</h1>
            </div><!-- /.col -->
            <div class="col-sm-3">
                <a href="<?= SERVERURL ?>formacao/abertura_cadastro"><button class="btn btn-success btn-block">Adicionar</button></a>
            </div>
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
                        <h3 class="card-title">Abertura Formação</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="tabela" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Título</th>
                                    <th>Data de abertura</th>
                                    <th>Data de encerramento</th>
                                    <th>Data de publicação</th>
                                    <th>Ação</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($aberturas as $abertura): ?>
                                <tr>
                                    <td><?=$abertura->titulo?></td>
                                    <td> <?= isset($abertura->data_abertura) ? $formacaoObj->dataHora($abertura->data_abertura) : "" ?> </td>
                                    <td> <?= isset($abertura->data_encerramento) ? $formacaoObj->dataHora($abertura->data_encerramento) : "" ?> </td>
                                    <td ><?=$formacaoObj->dataHora($abertura->data_publicacao) ?? "-"?></td>
                                    <td>
                                        <div class="row">
                                            <div class="col-md">
                                                <a href="<?= SERVERURL . "formacao/abertura_cadastro&id=" . $formacaoObj->encryption($abertura->id) ?>"
                                                   class="btn btn-sm btn-primary"><i class="fas fa-edit"></i> Editar
                                                </a>
                                            </div>
                                            <div class="col-md">
                                                <form class="form-horizontal formulario-ajax" method="POST" action="<?=SERVERURL?>ajax/formacaoAjax.php" role="form" data-form="update">
                                                    <input type="hidden" name="_method" value="apagarAbertura">
                                                    <input type="hidden" name="id" value="<?= $formacaoObj->encryption($abertura->id)?>">
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
                                    <th>Título</th>
                                    <th>Data de abertura</th>
                                    <th>Data de encerramento</th>
                                    <th>Data de publicação</th>
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
