
<?php
    require_once "./controllers/FormacaoController.php";
    $subprefeituraObj = new FormacaoController();
    
    $subprefeituras = $subprefeituraObj->listaSubprefeituras();
?>
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-9">
                <h1 class="m-0 text-dark">Lista de Subprefeituras</h1>
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
                            <a href="<?= SERVERURL ?>formacao/subprefeitura_cadastro" class="btn btn-success btn-sm" >
                                <i class="fas fa-plus"></i> Cadastrar Novo
                            </a>
                            <a href="<?= SERVERURL ?>pdf/exportar_equipamentos_excel.php" target="_blank" class="btn btn-success btn-sm">
                                <i class="fas fa-file-excel"></i> Exportar para Excel</a>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="tabela" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Subprefeitura</th>
                                    <th>Editar</th>
                                    <th>Apagar</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($subprefeituras as $subprefeitura): ?>
                                <tr>
                                    <td><?=$subprefeitura->subprefeitura?></td>
                                    <td>
                                        <a href="<?= SERVERURL . "formacao/subprefeitura_cadastro&id=" . $subprefeituraObj->encryption($subprefeitura->id) ?>">
                                        <button type="submit" class="btn bg-gradient-primary btn-sm">
                                            <i class="fas fa-user-edit"></i> Editar
                                        </button>
                                        </a>
                                    </td>
                                    <td>
                                        <form class="form-horizontal formulario-ajax" method="POST" action="<?=SERVERURL?>ajax/formacaoAjax.php" role="form" data-form="update">
                                            <input type="hidden" name="_method" value="apagarSubprefeitura">
                                            <input type="hidden" name="id" value="<?= $subprefeituraObj->encryption($subprefeitura->id)?>">
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
                                    <th>Subprefeitura</th>
                                    <th>Editar</th>
                                    <th>Apagar</th>
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

