
<?php
    require_once "./controllers/FormacaoController.php";
    $territorioObj = new FormacaoController();
    
    $territorios = $territorioObj->listaTerritorios();
?>
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-9">
                <h1 class="m-0 text-dark">Lista de Territórios</h1>
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
                                    <th>Território</th>
                                    <th width="15%">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($territorios as $territorio): ?>
                                <tr>
                                    <td><?=$territorio->territorio?></td>
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
                                    <th>Território</th>
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