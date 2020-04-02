<?php
require_once "./controllers/AdministrativoController.php";
$instituicaoObj = new AdministrativoController();

$instituicoes = $instituicaoObj->listaInstituicoes();
?>
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-9">
                <h1 class="m-0 text-dark">Instituições</h1>
            </div><!-- /.col -->
            <div class="col-3">
                <a href="<?= SERVERURL ?>administrativo/instituicao_cadastro"><button class="btn btn-success btn-block">Adicionar nova instituição</button></a>
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
                        <h3 class="card-title">Listagem de instituições</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="tabela" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>Instituição</th>
                                <th>Sigla</th>
                                <th>Ação</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($instituicoes as $instituicao): ?>

                            <tr>
                                <td><?=$instituicao->nome?></td>
                                <td><?=$instituicao->sigla?></td>
                                <td>
                                    <a href="<?= SERVERURL . "administrativo/instituicao_cadastro&id=" . $instituicaoObj->encryption($instituicao->id) ?>"
                                       class="btn btn-sm btn-primary"><i class="fas fa-edit"></i> Editar</a>
                            </tr>
                            <?php endforeach; ?>
                            </tbody>
                            <tfoot>
                            <tr>
                                <th>Instituições</th>
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