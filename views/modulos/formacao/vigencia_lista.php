<?php
    require_once "./controllers/FormacaoController.php";
    $vigenciaObj = new FormacaoController();
    
    $vigencias = $vigenciaObj->listaVigencias();
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
                            <a href="<?= SERVERURL ?>formacao/pf_cadastro" class="btn btn-success btn-sm" >
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
                                    <th width="15%">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($vigencias as $vigencia): ?>
                                <tr>
                                    <td><?=$vigencia->ano?></td>
                                    <td><?=$vigencia->descricao?></td>
                                    <td>
                                        <button type="submit" class="btn bg-gradient-danger btn-sm">
                                            <i class="fas fa-trash"></i> Apagar
                                        </button>
                                        <button type="submit" class="btn bg-gradient-primary btn-sm">
                                            <i class="fas fa-user-edit"></i> Editar
                                        </button>
                                    </td>
                                </tr>
                                <?php endforeach; ?>    
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Ano</th>
                                    <th>Descrição</th>
                                    <th width="15%">Ações</th>
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

</div>