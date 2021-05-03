<?php
require_once "./controllers/FormacaoVigenciaController.php";
$vigenciaObj = new FormacaoVigenciaController();

$vigencias = $vigenciaObj->listar();
?>
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-9">
                <h1 class="m-0 text-dark">Lista das Vigências</h1>
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
                <div class="card card-info card-outline">
                    <div class="card-header">
                        <h3 class="card-title">Listagem</h3>
                        <div class="card-tools">
                            <!-- button with a dropdown -->
                            <a href="<?= SERVERURL ?>formacao/vigencia_cadastro" class="btn btn-success btn-sm" >
                                <i class="fas fa-plus"></i> Cadastrar Novo
                            </a>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="tabela" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Ano</th>
                                    <th>Descrição</th>
                                    <th>Quantidade de Parcelas</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($vigencias as $vigencia): ?>
                                <tr>
                                    <td><?=$vigencia->ano?></td>
                                    <td><?=$vigencia->descricao?></td>
                                    <td><?=$vigencia->numero_parcelas?> parcela(s)</td>
                                    <td style='width: 20%'>
                                        <form class="form-horizontal formulario-ajax" method="POST" action="<?=SERVERURL?>ajax/formacaoAjax.php" role="form" data-form="update">
                                            <a href="<?= SERVERURL . "formacao/vigencia_cadastro&id=" . $vigenciaObj->encryption($vigencia->id) ?>" class="btn bg-gradient-primary btn-sm">
                                                <i class="fas fa-user-edit"></i> Editar
                                            </a>

                                            <input type="hidden" name="_method" value="apagarVigencia">
                                            <input type="hidden" name="id" value="<?= $vigenciaObj->encryption($vigencia->id)?>">
                                            <button type="submit" class="btn bg-gradient-danger btn-sm">
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
                                    <th>Ano</th>
                                    <th>Descrição</th>
                                    <th>Quantidade de Parcelas</th>
                                    <th>Ações</th>
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
