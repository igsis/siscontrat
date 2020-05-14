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
                    <form class="form-horizontal formulario-ajax" method="POST"
                          action="<?= SERVERURL ?>ajax/fomentoAjax.php" role="form"
                          data-form="<?= ($id) ? "update" : "save" ?>">
                        <input type="hidden" name="_method" value="<?= ($id) ? "editar" : "cadastrar" ?>">
                        <input type="hidden" name="data_publicacao" value="<?= date('Y-m-d H:i:s') ?>">
                        <?php if ($id): ?>
                            <input type="hidden" name="id" id="edital_id" value="<?= $id ?>">
                        <?php endif; ?>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Tipo de Cadastro: *</label>
                                        <select class="form-control" name="pessoa_tipos_id" id="pessoa_tipos_id"
                                                required>
                                            <option value="">Selecione uma opção...</option>
                                            <?php $fomentoObj->geraOpcao('pessoa_tipos', $fomento->pessoa_tipos_id ?? "", false, true, true); ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="tipo_contratacao_id">Tipo do Edital: *</label>
                                        <select class="form-control" name="tipo_contratacao_id" id="tipo_contratacao_id"
                                                required>
                                            <option value="">Selecione uma opção...</option>
                                            <?php $fomentoObj->geraOpcao('tipos_contratacoes', $fomento->tipo_contratacao_id ?? "", false, false, true); ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="">Adicionar Tipo</label>
                                        <button type="button" class="form-control btn btn-primary" data-toggle="modal"
                                                data-target="#insereTipo">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <label for="titulo">Título: *</label>
                                        <input type="text" class="form-control" id="titulo" name="titulo"
                                               value="<?= $fomento->titulo ?? "" ?>" required>
                                    </div>
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
                                           value="<?= isset($fomento->valor_edital) ? $fomentoObj->dinheiroParaBr($fomento->valor_edital) : "" ?>"
                                           required>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="data_abertura">Data de abertura: *</label>
                                    <input type="text" class="form-control date-picker" id="data_abertura"
                                           name="data_abertura"
                                           value="<?= isset($fomento->data_abertura) ? $fomentoObj->dataHora($fomento->data_abertura) : "" ?>"
                                           required>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="data_encerramento">Data de encerramento: *</label>
                                    <input type="text" class="form-control date-picker" id="data_encerramento"
                                           name="data_encerramento"
                                           value="<?= isset($fomento->data_encerramento) ? $fomentoObj->dataHora($fomento->data_encerramento) : "" ?>"
                                           required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col">
                                    <label for="descricao">Descrição: *</label>
                                    <textarea name="descricao" id="descricao" class="form-control textarea" required>
                                        <?= $fomento->descricao ?? "" ?>
                                    </textarea>
                                </div>
                            </div>
                        </div>
                        <div class="resposta-ajax"></div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <a href="<?= SERVERURL ?>fomentos/edital_anexos&id=<?= $id ?>" class="btn btn-warning">Anexos solicitados</a>
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

<div class="modal fade" id="insereTipo" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Adicionar Tipo de Edital</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form class="form-horizontal formulario-ajax" method="POST"
                  action="<?= SERVERURL ?>ajax/fomentoAjax.php" role="form"
                  data-form="save">
                <input type="hidden" name="_method" value="adicionar_tipo">
                <?php if ($id): ?>
                    <input type="hidden" name="id" id="edital_id" value="<?= $id ?>">
                <?php endif; ?>
                <div class="modal-body">

                        <div class="form-group">
                            <label for="tipo_contratacao">Tipo do Edital: *</label>
                            <input type="text" class="form-control" id="tipo_contratacao" name="tipo_contratacao" required maxlength="35">
                        </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success">Inserir</button>
                </div>
                <div class="resposta-ajax"></div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

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

    $(function () {
        // Summernote
        $('.textarea').summernote({
            lang: 'pt-BR',
            cleaner:{
                action: 'both', // both|button|paste 'button' only cleans via toolbar button, 'paste' only clean when pasting content, both does both options.
                newline: '<br>', // Summernote's default is to use '<p><br></p>'
                notStyle: 'position:absolute;top:0;left:0;right:0', // Position of Notification
                icon: '<i class="note-icon">[Your Button]</i>',
                keepHtml: false, // Remove all Html formats
                keepOnlyTags: ['<p>', '<br>', '<ul>', '<li>', '<b>', '<strong>','<i>', '<a>'], // If keepHtml is true, remove all tags except these
                keepClasses: true, // Remove Classes
                badTags: ['style', 'script', 'applet', 'embed', 'noframes', 'noscript', 'html'], // Remove full tags with contents
                badAttributes: ['style', 'start'], // Remove attributes from remaining tags
                limitChars: false, // 0/false|# 0/false disables option
                limitDisplay: 'both', // text|html|both
                limitStop: false // true/false
            }
        })
    });
</script>