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
                                <th>Id</th>
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
                                    <td><?= $evento->id ?></td>
                                    <td><?=$evento->nome_evento ?></td>
                                    <td>
                                        <button type="button" class="btn btn-secondary" data-toggle="tooltip" data-html="true" title="<?= $eventoObj->retornaLocais($evento->id) ?>">Ver Locais</button>
                                    </td>
                                    <td><?= $eventoObj->retornaPeriodo($evento->id) ?></td>
                                    <td><?=$evento->fiscal?></td>
                                    <td><?=$evento->operador ?? "não cadastrado" ?></td>
                                    <td>
                                        <div class="row">
                                            <div class="col-md">
                                                <a href="<?=SERVERURL?>pdf/resumo_evento.php?id=<?= MainModel::encryption($evento->id) ?>" target="_blank"
                                                   class="btn btn-sm btn-primary"><i class="far fa-file-alt"></i> Detalhes</a>
                                            </div>
                                            <!-- aprovar -->
                                            <div class="col-md">
                                                <form class="form-horizontal formulario-ajax" action="<?= SERVERURL ?>ajax/gestaoPrazoAjax.php" method="POST" role="form" data-form="update">
                                                    <input type="hidden" name="_method" value="aprovar">
                                                    <input type="hidden" name="id" value="<?= $evento->id ?>">
                                                    <button type="submit" name="cadastra" class="btn btn-sm btn-success">
                                                        <i class="far fa-thumbs-up"></i> Aprovar
                                                    </button>
                                                    <div class="resposta-ajax"></div>
                                                </form>
                                            </div>
                                            <!-- desaprovar -->
                                            <div class="col-md">
                                                <button type="button" class="btn btn-sm btn-danger" id="vetarEvento"
                                                        data-toggle="modal" data-target="#vetacao"
                                                        data-name="<?= $evento->nome_evento ?>"
                                                        data-id="<?= $evento->id ?>">
                                                    <i class="far fa-thumbs-down"></i> Vetar
                                                </button>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                            <tfoot>
                            <tr>
                                <th>Id</th>
                                <th>Nome do evento</th>
                                <th>Locais</th>
                                <th>Período</th>
                                <th>Fiscal</th>
                                <th>Operador</th>
                                <th style="width: 20%">Ação</th>
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

<!-- modal -->
<div class="modal fade" id="vetacao" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Confirmação do Veto</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form class="form-horizontal formulario-ajax" action="<?= SERVERURL ?>ajax/gestaoPrazoAjax.php" method="POST" role="form" data-form="update">
                <input type="hidden" name="_method" value="desaprovar">
                <input type="hidden" name="evento_id" id="evento_id" value="">
                <input type="hidden" name="titulo" value="Evento fora do prazo">
                <div class="modal-body">
                    <p></p>
                    <label for="chamado_tipo_id">Motivo da Vetação: *</label>
                    <select id="chamado_tipo_id" name="chamado_tipo_id" class="form-control" required>
                        <option value="">Selecione o Motivo</option>
                        <?php
                        $motivos = $gestaoObj->consultaSimples("SELECT * FROM chamado_tipos WHERE id NOT IN (1)")->fetchAll(PDO::FETCH_OBJ);
                        foreach ($motivos as $motivo){
                            echo "<option value='$motivo->id'>$motivo->tipo</option>";
                        } ?>
                    </select>
                    <label for="justificativa">Justificativa: *</label>
                    <textarea name="justificativa" id="justificativa" class="form-control" rows="3" required></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
                    <input type="submit" class="btn btn-danger btn-outline" name="vetar" value="Vetar">
                </div>
                <div class="resposta-ajax"></div>
            </form>
        </div>
    </div>
</div>

<script type="application/javascript">
    $(document).ready(function () {
        $('.nav-link').removeClass('active');
        $('#gestaoPrazo_inicio').addClass('active');
    })
</script>