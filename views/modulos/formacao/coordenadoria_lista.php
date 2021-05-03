<?php
    require_once "./controllers/FormacaoCoordenadoriaController.php";
    $coordenadoriaObj = new FormacaoCoordenadoriaController();
    
    $coordenadorias = $coordenadoriaObj->listar();
?>
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-9">
                <h1 class="m-0 text-dark">Lista de Coordenadorias</h1>
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
                            <a href="<?= SERVERURL ?>formacao/coordenadoria_cadastro" class="btn btn-success btn-sm" >
                                <i class="fas fa-plus"></i> Cadastrar Novo
                            </a>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="tabela" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Coordenadoria</th>
                                    <th>Editar</th>
                                    <th>Apagar</th>
                                                                    </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($coordenadorias as $cordenadoria): ?>
                                <tr>
                                    <td><?=$cordenadoria->coordenadoria?></td>
                                    <td>
                                        <a href="<?= SERVERURL . "formacao/coordenadoria_cadastro&id=" . $coordenadoriaObj->encryption($cordenadoria->id) ?>" class="btn bg-gradient-primary btn-sm">
                                            <i class="fas fa-user-edit"></i> Editar
                                        </a>
                                    </td>
                                    <td>
                                        <form class="form-horizontal formulario-ajax" method="POST" action="<?=SERVERURL?>ajax/formacaoAjax.php" role="form" data-form="update">
                                            <input type="hidden" name="_method" value="apagarCoordenadoria">
                                            <input type="hidden" name="id" value="<?= $coordenadoriaObj->encryption($cordenadoria->id)?>">
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
                                    <th>Coordenadoria</th>
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

