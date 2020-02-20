<?php
require_once "./controllers/FomentoController.php";
$fomentoObj = new FomentoController();

$fomentos = $fomentoObj->listaFomentos();
?>
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-9">
                <h1 class="m-0 text-dark">Editais</h1>
            </div><!-- /.col -->
            <div class="col-sm-3">
                <a href="<?= SERVERURL ?>fomentos/edital_cadastro"><button class="btn btn-success btn-block">Adicionar</button></a>
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
                        <h3 class="card-title">Editais Ativos</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="tabela" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Título</th>
                                    <th>Tipo</th>
                                    <th>Data da abertura</th>
                                    <th>Data de encerramento</th>
                                    <th>Status das Inscrições</th>
                                    <th>Ação</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($fomentos as $fomento):
                                $ativo = $fomentoObj->verificaFomentoAtivo($fomento->data_abertura, $fomento->data_encerramento) ? "bg-teal" : "";
                                ?>
                                <tr class="<?=$ativo?>">
                                    <td><?=$fomento->titulo?></td>
                                    <td><?=$fomento->tipo_contratacao?></td>
                                    <td><?=$fomentoObj->dataParaBR($fomento->data_abertura)?></td>
                                    <td><?=$fomentoObj->dataParaBR($fomento->data_encerramento)?></td>
                                    <td><?=$fomentoObj->verificaFomentoAtivo($fomento->data_abertura, $fomento->data_encerramento) ? "Abertas" : "Encerradas"?></td>
                                    <td>
                                        <a href="<?= SERVERURL . "fomentos/edital_cadastro&key=" . $fomentoObj->encryption($fomento->id) ?>"
                                           class="btn btn-sm btn-primary"><i class="fas fa-edit"></i> Editar</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Título</th>
                                    <th>Tipo</th>
                                    <th>Data da abertura</th>
                                    <th>Data de encerramento</th>
                                    <th>Status das Inscrições</th>
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