<?php
require_once "./controllers/InstituicaoController.php";
$instituicaoObj = new InstituicaoController();

$instituicoes = $instituicaoObj->listaInstituicoes();
?>
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-12">
                <h1 class="m-0 text-dark">Instituições</h1>
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
                        <div class="row my-3 justify-content-end">
                            <div class="col-md-2">
                                <a href="<?= SERVERURL ?>administrativo/instituicao_cadastro" class="btn btn-success btn-block">
                                    <i class="fas fa-plus"></i>
                                    Adicionar
                                </a>
                            </div>
                        </div>
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