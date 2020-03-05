<?php
require_once "./controllers/FomentoController.php";

$id = isset($_GET['id']) ? $_GET['id'] : null;
$fomentoObj = new FomentoController();

$fomento = $fomentoObj->recuperaEdital($id);
?>
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Cadastro de editais</h1>
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
                        <h3 class="card-title">Dados</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form class="form-horizontal formulario-ajax" method="POST" action="<?= SERVERURL ?>ajax/fomentoAjax.php" role="form" data-form="<?= ($id) ? "update" : "save" ?>">
                        <input type="hidden" name="_method" value="<?= ($id) ? "editar" : "cadastrar" ?>">
                        <input type="hidden" name="data_publicacao" value="<?= date('Y-m-d H:i:s') ?>">
                        <?php if ($id): ?>
                            <input type="hidden" name="id" id="edital_id" value="<?= $id ?>">
                        <?php endif; ?>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="tipo_contratacao_id">Tipo: *</label>
                                        <select class="form-control" name="tipo_contratacao_id" id="tipo_contratacao_id"
                                                required>
                                            <option value="">Selecione uma opção...</option>
                                            <?php $fomentoObj->geraOpcao('tipos_contratacoes', $fomento->tipo_contratacao_id ?? "", false, false, true); ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="titulo">Título: *</label>
                                        <input type="text" class="form-control" id="titulo" name="titulo" maxlength="20"
                                               value="<?= $fomento->titulo ?? "" ?>" required>
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="descricao">Descrição: *</label>
                                    <textarea name="descricao" id="descricao" class="form-control" rows="5" required><?=$fomento->descricao ?? ""?></textarea>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-3">
                                    <label for="valor_max_projeto">Valor máximo por projeto: *</label>
                                    <input type="text" class="form-control" id="valor_max_projeto"
                                           name="valor_max_projeto" onKeyPress="return(moeda(this,'.',',',event))"
                                           value="<?= isset($fomento->valor_max_projeto) ? $fomentoObj->dinheiroParaBr($fomento->valor_max_projeto) : "" ?>"
                                           required>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="valor_edital">Valor edital: *</label>
                                    <input type="text" class="form-control" id="dinheiro" name="valor_edital"
                                           onKeyPress="return(moeda(this,'.',',',event))"
                                           value="<?= isset($fomento->valor_edital) ? $fomentoObj->dinheiroParaBr($fomento->valor_edital) : "" ?>" required>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="data_abertura">Data de abertura: *</label>
                                    <input type="text" class="form-control date-picker" id="data_abertura" name="data_abertura"
                                           value="<?= isset($fomento->data_abertura) ? $fomentoObj->dataHora($fomento->data_abertura) : "" ?>"
                                           required>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="data_encerramento">Data de encerramento: *</label>
                                    <input type="text" class="form-control date-picker" id="data_encerramento" name="data_encerramento"
                                           value="<?= isset($fomento->data_encerramento) ? $fomentoObj->dataHora($fomento->data_encerramento) : "" ?>"
                                           required>
                                </div>
                            </div>
                        </div>
                        <div class="resposta-ajax"></div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <?php if ($id): ?>
                                <a href="<?=SERVERURL?>fomentos/edital_anexos&id=<?=$id?>" class="btn btn-danger">Anexos Solicitados</a>
                            <?php endif ?>
                            <button type="submit" class="btn btn-info float-right">Gravar</button>
                        </div>
                        <!-- /.card-footer -->
                        <div class="resposta-ajax"></div>
                    </form>
                </div>
                <!-- /.card -->
            </div>
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content -->

<script>
    $(function () {
        let datePicker = $('.date-picker');
        datePicker.daterangepicker({
            "locale": {
                "format": "DD/MM/YYYY HH:mm:ss",
                "separator": " - ",
                "applyLabel": "Selecionar",
                "cancelLabel": "Cancelar",
                "daysOfWeek": [
                    "Dom",
                    "Seg",
                    "Ter",
                    "Qua",
                    "Qui",
                    "Sex",
                    "Sab"
                ],
                "monthNames": [
                    "Janeiro",
                    "Fevereiro",
                    "Março",
                    "Abril",
                    "Maio",
                    "Junho",
                    "Julho",
                    "Agosto",
                    "Setembro",
                    "Outubro",
                    "Novembro",
                    "Dezembro"
                ],
            },
            "singleDatePicker": true,
            "timePicker": true,
            "timePicker24Hour": true,
            "timePickerSeconds": true,
        });

        if (!$('#edital_id').length) {
            datePicker.val('');
            datePicker.attr("placeholder", "Selecione o Dia / hora");
        }
    });
</script>