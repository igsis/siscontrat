<?php
require_once "./controllers/GestaoPrazoController.php";
require_once "./controllers/EventoController.php";
$gestaoObj = new GestaoPrazoController();
$eventoObj = new EventoController();
$eventos = $gestaoObj->listaAprovar();
?>
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-12">
                <h1 class="m-0 text-dark">Gestão de Prazos</h1>
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
                        <h3 class="card-title">Eventos aguardando aprovação</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="tabela" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>Nome do evento</th>
                                <th>Locais</th>
                                <th>Período</th>
                                <th>Fiscal</th>
                                <th>Operador</th>
                                <th style="width: 20%">Ação</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($eventos as $evento): ?>
                                <tr>
                                    <td><?=$evento->nome_evento . $evento->id?></td>
                                    <td>
                                        <button type="button" class="btn btn-default" data-toggle="modal" data-target="#listaLocais">
                                            Launch Small Modal
                                        </button>
                                        <form class="form-horizontal formulario-ajax" method="POST"
                                              action="<?= SERVERURL ?>ajax/EventoAjax.php" role="form"
                                             >
                                            <input type="hidden" name="_method" value="listaLocais">
                                            <input type="hidden" name="id" value="<?= $evento->id ?>">
                                            <button type="submit" class="btn btn-primary">Ver locais</button>
                                        </form>
                                    </td>
                                    <td><?= $eventoObj->retornaPeriodo($evento->id) ?></td>
                                    <td><?=$evento->fiscal?></td>
                                    <td><?=$evento->operador ?? "não cadastrado" ?></td>
                                    <td>
                                        <div class="row">
                                            <div class="col-md">
                                                <a href="<?= SERVERURL  ?>"
                                                   class="btn btn-sm btn-primary"><i class="far fa-file-alt"></i> Detalhes</a>
                                            </div>
                                            <div class="col-md">
                                                <a href="<?= SERVERURL  ?>"
                                                   class="btn btn-sm btn-success"><i class="far fa-thumbs-up"></i> Aprovar</a>
                                            </div>
                                            <div class="col-md">
                                                <a href="<?= SERVERURL  ?>"
                                                   class="btn btn-sm btn-danger"><i class="far fa-thumbs-down"></i> Vetar</a>
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

<script type="application/javascript">
    $(document).ready(function () {
        $('.nav-link').removeClass('active');
        $('#gestaoPrazo_inicio').addClass('active');
    })
</script>