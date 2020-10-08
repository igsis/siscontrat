<?php
require_once "./controllers/FormacaoController.php";

$formacaoObj =  new FormacaoController();
$aberturas = $formacaoObj->listaAbertura();

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
                                    <th>Descrição</th>
                                    <th>Data da abertura</th>
                                    <th colspan="2">Ação</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($aberturas as $abertura): ?>
                                <tr>
                                    <td><?=$abertura->titulo?></td>
                                    <td><?=$abertura->descricao?></td>
                                    <td ><?=$formacaoObj->dataHora($abertura->data_abertura)?></td>
                                    <td>
                                       <a href="<?= SERVERURL . "formacao/abertura_cadastro&id=" . $formacaoObj->encryption($abertura->id) ?>"
                                                   class="btn btn-sm btn-primary"><i class="fas fa-edit"></i> Editar</a>
                                    </td>
                                    <td>
                                        <form class="form-horizontal formulario-ajax" method="POST" action="<?=SERVERURL?>ajax/formacaoAjax.php" role="form" data-form="update">
                                            <input type="hidden" name="_method" value="apagarAbertura">
                                            <input type="hidden" name="id" value="<?= $formacaoObj->encryption($abertura->id)?>">
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <i class="fas fa-trash"></i> Apagar
                                            </button>
                                            <div class="resposta-ajax"></div>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Título</th>
                                    <th>Descrição</th>
                                    <th>Data da abertura</th>
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
