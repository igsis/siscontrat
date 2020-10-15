<?php
require_once "./controllers/FormacaoController.php";

$id = isset($_GET['id']) ? $_GET['id'] : null;
$formacaoObj =  new FormacaoController();
$abertura = $formacaoObj->recuperaAbertura($id);

//para js
$dataAbertura = isset($abertura->data_abertura) ? 1 : null;
$dataEncerramento = isset($abertura->data_encerramento) ? 1 : null;


?>
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Cadastro de abertura</h1>
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
                          action="<?= SERVERURL ?>ajax/formacaoAjax.php" role="form"
                          data-form="<?= ($id) ? "update" : "save" ?>">
                        <input type="hidden" name="_method" value="<?= ($id) ? "editarAbertura" : "cadastrarAbertura" ?>">
                        <?php if ($id): ?>
                            <input type="hidden" name="id" id="abertura_id" value="<?= $id ?>">
                        <?php else: ?>
                            <input type="hidden" name="data_publicacao" value="<?= date('Y-m-d H:i:s') ?>">
                        <?php endif; ?>
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <label for="titulo">Título: *</label>
                                        <input type="text" class="form-control" id="titulo" name="titulo"
                                               value="<?= $abertura->titulo ?? "" ?>" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label for="data_abertura">Ano de referência: </label>
                                    <input type="number" class="form-control" id="ano_referencia" name="ano_referencia" maxlength="4" min="2020"                                 name="data_abertura"
                                           value="<?= isset($abertura->ano_referencia) ? $abertura->ano_referencia : "" ?>" >
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="data_abertura">Data de abertura: </label>
                                    <input type="text" class="form-control date-picker" id="data_abertura"
                                           name="data_abertura"
                                           value="<?= isset($abertura->data_abertura) ? $formacaoObj->dataHora($abertura->data_abertura) : "" ?>">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="data_encerramento">Data de encerramento: </label>
                                    <input type="text" class="form-control date-picker" id="data_encerramento"
                                           name="data_encerramento"
                                           value="<?= isset($abertura->data_encerramento) ? $formacaoObj->dataHora($abertura->data_encerramento) : "" ?>">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col">
                                    <label for="descricao">Descrição: *</label>
                                    <textarea name="descricao" id="descricao" class="form-control textarea" required>
                                        <?= $abertura->descricao ?? "" ?>
                                    </textarea>
                                </div>
                            </div>
                        </div>
                        <div class="resposta-ajax"></div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <a href="<?= SERVERURL ?>formacao/abertura_lista" class="btn btn-default float-left">Voltar</a>
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
    });

    $(function () {
        let dataAbertura = $("#data_abertura");
        let dataEncerramento = $("#data_encerramento");

        //apagar campo ao cancelat dataPicker
        dataAbertura.on('cancel.daterangepicker', function() {
            dataAbertura.val('');
            dataAbertura.attr("placeholder", "Selecione o Dia / hora");
        });

        dataEncerramento.on('cancel.daterangepicker', function() {
            dataEncerramento.val('');
            dataEncerramento.attr("placeholder", "Selecione o Dia / hora");
        });

        //verificar se veio vazio do banco
        <?php if ($dataAbertura == null): ?>
            dataAbertura.val('')
            dataAbertura.attr("placeholder", "Selecione o Dia / hora");
        <?php endif; ?>

        <?php if ($dataEncerramento == null): ?>
            dataEncerramento.val('')
            dataEncerramento.attr("placeholder", "Selecione o Dia / hora");
        <?php endif; ?>


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