<?php
require_once "./controllers/FomentoController.php";

$id = isset($_GET['id']) ? $_GET['id'] : null;
$fomentoObj = new FomentoController();

$arquivos = $fomentoObj->listaArquivosEdital($id);
?>
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Arquivos Solicitados</h1>
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
                <div class="card card-default">
                    <div class="card-header">
                        <h3 class="card-title">Arquivos</h3>
                        <div class="card-tools">
                            <button class="btn btn-sm btn-success">Adicionar Documento</button>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <div class="card-body">
                        <table id="tabela" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>Ordem</th>
                                <th>Nº do anexo</th>
                                <th>Documento</th>
                                <th>Ação</th>
                            </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($arquivos as $arquivo) : ?>
                                <tr>
                                    <td><?= $arquivo->ordem ?></td>
                                    <td><?= $arquivo->anexo ?></td>
                                    <td><?= $arquivo->documento ?></td>
                                    <td></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                            <tfoot>
                            <tr>
                                <th>Ordem</th>
                                <th>Nº do anexo</th>
                                <th>Documento</th>
                                <th>Ação</th>
                            </tr>
                            </tfoot>
                        </table>
                        <!--<div class="row">
                            <div class="form-group col-9">
                                <label for="documento">Documento:</label>
                                <select class="form-control" name="documento" id="documento">
                                    <option value="">Selecione uma Opção...</option>
                                    <?php /*$fomentoObj->geraOpcao('fom_lista_documentos', $arquivo->fom_lista_documento_id, false, false, true) */?>
                                </select>
                            </div>
                            <div class="form-group col-2">
                                <label for="anexo">Nº do Anexo:</label>
                                <input class="form-control" name="anexo" id="anexo" value="<?/*= $arquivo->anexo */?>">
                            </div>
                            <div class="form-group col-1">
                                <label for="anexo">Ordem:</label>
                                <input class="form-control" name="anexo" id="anexo" value="<?/*= $arquivo->ordem */?>">
                            </div>
                        </div>-->
                    </div>
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