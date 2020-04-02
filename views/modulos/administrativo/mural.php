<?php
require_once "./controllers/AdministrativoController.php";
$adminObj = new AdministrativoController();

$avisos = $adminObj->listaMural();
?>
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-9">
                <h1 class="m-0 text-dark">Mural de Atualizações</h1>
            </div><!-- /.col -->
            <div class="col-sm-3">
                <a href="<?= SERVERURL ?>administrativo/aviso_cadastro"><button class="btn btn-success btn-block">Adicionar Nova Atualização</button></a>
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
                        <h3 class="card-title">Atualizações Publicadas</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="tabela" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>Título</th>
                                <th>Mensagem</th>
                                <th>Data da publicação</th>
                                <th>Ação</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($avisos as $aviso): ?>
                                <td><?= $aviso->titulo ?></td>
                                <td><?= mb_strimwidth($aviso->mensagem, 0, 50, "...") ?></td>
                                <td><?= $adminObj->dataHora($aviso->data) ?></td>
                                <td>
                                    <a href="<?= SERVERURL . "administrativo/aviso_cadastro&id=" . $adminObj->encryption($aviso->id) ?>"
                                       class="btn btn-sm btn-primary"><i class="fas fa-edit"></i> Editar</a>
                                </td>
                            <?php endforeach; ?>
                            </tbody>
                            <tfoot>
                            <tr>
                                <th>Título</th>
                                <th>Mensagem</th>
                                <th>Data da publicação</th>
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
