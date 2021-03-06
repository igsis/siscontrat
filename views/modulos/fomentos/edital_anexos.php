<?php
require_once "./controllers/FomentoController.php";

$id = isset($_GET['id']) ? $_GET['id'] : null;
$fomentoObj = new FomentoController();

$arquivos = $fomentoObj->listaDocumentosEdital($id);
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
                        <h3 class="card-title">Edital <?= $fomentoObj->exibeNomeEdital($id)?></h3>
                        <div class="card-tools">
                            <a href="<?= SERVERURL.'fomentos/edital_anexos_cadastro&edital='.$id ?>"><button class="btn btn-sm btn-success">Adicionar Documento</button></a>
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
                                <th>Obrigatório</th>
                                <th width="15%">Ação</th>
                            </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($arquivos as $arquivo) : ?>
                                <tr>
                                    <td><?= $arquivo->ordem ?></td>
                                    <td><?= $arquivo->anexo ?></td>
                                    <td><?= $arquivo->documento ?></td>
                                    <td><?php if($arquivo->obrigatorio == 1) echo "sim"; else echo "não" ?></td>
                                    <td>
                                        <a href="<?= SERVERURL . "fomentos/edital_anexos_cadastro&id=" . $fomentoObj->encryption($arquivo->id)."&edital=".$id ?>" class="btn btn-sm btn-primary float-left mr-2"><i class="fas fa-edit"></i> Editar</a>
                                        <form class="form-horizontal formulario-ajax" method="POST" action="<?= SERVERURL ?>ajax/fomentoAjax.php" role="form" data-form="delete">
                                            <input type="hidden" name="_method" value="apagarAnexo">
                                            <input type="hidden" name="anexo_id" value="<?=$fomentoObj->encryption($arquivo->id)?>">
                                            <input type="hidden" name="edital_id" value="<?=$id?>">
                                            <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i> Apagar</button>
                                            <div class="resposta-ajax"></div>
                                        </form>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                            <tfoot>
                            <tr>
                                <th>Ordem</th>
                                <th>Nº do anexo</th>
                                <th>Documento</th>
                                <th>Obrigatório</th>
                                <th>Ação</th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <a href="<?= SERVERURL.'fomentos/edital_cadastro&id='.$id ?>" class="btn btn-default">Voltar</a>
                    </div>
                    <!-- /.card-footer -->
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