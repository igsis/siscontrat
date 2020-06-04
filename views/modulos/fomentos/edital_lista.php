<?php
require_once "./controllers/FomentoController.php";
$fomentoObj = new FomentoController();

$fomentos = $fomentoObj->listaEditais();
?>
<style>
    .quadr{
        width: 50px;
        height: 15px;
        margin-right: 10px;
        border-radius: 2px;
        text-align: center;
    }
</style>
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
                                    <th width="15%">Ação</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($fomentos as $fomento): ?>
                                <tr>
                                    <td><?=$fomento->titulo?></td>
                                    <td><?=$fomento->tipo_contratacao?></td>
                                    <td><?=$fomentoObj->dataHora($fomento->data_abertura)?></td>
                                    <td><?=$fomentoObj->dataHora($fomento->data_encerramento)?></td>
                                    <td align="center">
                                        <?=$fomentoObj->verificaEditalAtivo($fomento->data_abertura, $fomento->data_encerramento) ?
                                            "<div class=\"quadr bg-green\" data-toggle=\"popover\" data-trigger=\"hover\" data-content=\"Abertas\"></div>" :
                                            "<div class=\"quadr bg-red\" data-toggle=\"popover\" data-trigger=\"hover\" data-content=\"Encerradas\"></div>"?>
                                    </td>
                                    <td>
                                        <div class="row">
                                            <div class="col-md">
                                                <a href="<?= SERVERURL . "fomentos/edital_cadastro&id=" . $fomentoObj->encryption($fomento->id) ?>"
                                                   class="btn btn-sm btn-primary"><i class="fas fa-edit"></i> Editar</a>
                                            </div>
                                            <div class="col-md">
                                                <?=$fomentoObj->verificaEditalAtivo($fomento->data_abertura, $fomento->data_encerramento) ? "" :
                                                    "<button type=\"button\" class=\"btn btn-sm btn-danger\" data-toggle=\"modal\" data-target=\"#arquivarEdital\" data-id=\"{$fomentoObj->encryption($fomento->id)}\" data-name='{$fomento->titulo}'><i class=\"fas fa-archive\"></i> Arquivar</button>"?>
                                            </div>
                                        </div>

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

<div class="modal fade" id="arquivarEdital" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Arquivar Edital</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <p> </p>
            </div>
            <form class="form-horizontal formulario-ajax" method="POST" action="<?= SERVERURL ?>ajax/fomentoAjax.php" role="form" data-form="save">
                <input type="hidden" name="_method" value="arquivarEdital">
                <input type="hidden" name="id" id="id" value="">
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success">Arquivar</button>
                </div>
                <div class="resposta-ajax"></div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<script type="text/javascript">
    $(document).ready(function () {
        $('[data-toggle="popover"]').popover();
    });
</script>