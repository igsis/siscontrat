<?php
require_once "./controllers/FomentoController.php";
$fomentoObj = new FomentoController();

$fomentos = $fomentoObj->listaEditaisArquivados();
?>
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-9">
                <h1 class="m-0 text-dark">Editais</h1>
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
                        <h3 class="card-title">Editais Arquivados</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="tabela" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Título</th>
                                    <th>Tipo</th>
                                    <th>Data de encerramento</th>
                                    <th>Ação</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($fomentos as $fomento): ?>
                                <tr>
                                    <td><?=$fomento->titulo?></td>
                                    <td><?=$fomento->tipo_contratacao?></td>
                                    <td><?=$fomentoObj->dataParaBR($fomento->data_encerramento)?></td>
                                    <td>
<!--                                        <a href="--><?//= SERVERURL . "fomentos/edital_cadastro&id=" . $fomentoObj->encryption($fomento->id) ?><!--" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i> Editar</a>-->
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Título</th>
                                    <th>Tipo</th>
                                    <th>Data de encerramento</th>
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