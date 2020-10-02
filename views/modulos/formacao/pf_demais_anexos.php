<?php
require_once "./controllers/FormacaoController.php";
$listaPfObj = new FormacaoController();
$id = isset($_GET['id']) ? $_GET['id'] : "";
$tipo_documento_id = 6;
$documentosPf = $listaPfObj->recuperaDocumentosEnviados($id, $tipo_documento_id);
$documentosRestantes = $listaPfObj->listaDocumentoRestante($id, $tipo_documento_id);

?>

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-9">
                <h1 class="m-0 text-dark">Formação</h1>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<div class="content">
    <div class="container-fluid">
        <div class="card card-info card-outline">
            <div class="card-header">
                <h3 class="card-title">Upload de arquivos</h3>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12 col-md-offset-2 mt-3 text-center">
                        <h5> <strong>Upload de arquivos somente em PDF!</strong></h5><br>
                    </div>
                </div>

                <div class="row ">
                    <div class="col-md-12 mt-3 text-center">
                        <div class="table-responsive list_info">
                            <?php if ($documentosPf > null): ?>

                                <table class='table text-center table-striped table-bordered table-condensed'>
                                    <thead>
                                    <tr class='bg-info text-bold'>
                                        <td>Tipo de arquivo</td>
                                        <td>Nome do documento</td>
                                        <td>Data de envio</td>
                                        <td width='15%'></td>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    <?php foreach ($documentosPf as $documentoPf): ?>
                                        <tr>
                                            <td><?= $documentoPf->documento?></td>
                                            <td> <a href="#"> <?=mb_strimwidth($documentoPf->arquivo, 15, 25, "...") ?> </a></td>
                                            <td><?= date("d/m/Y", strtotime($documentoPf->data))?></td>
                                            <td>
                                                <button class="btn btn-danger" onclick="excluirArquivo('<?=$documentoPf->idArquivo?>', '<?= $documentoPf->arquivo?>')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                    </tbody>
                                </table>


                            <?php else: ?>
                                <p>Não há anexos disponíveis no momento.<p/>
                            <?php endif; ?>

                        </div>
                    </div>
                    <hr/>
                    <div class="col-md-12 mt-3 text-center">
                        <div class="table-responsive list_info">
                            <div class="col-md-12 col-md-offset-2 mt-3 text-center">
                                <h5> <strong>Envio de Arquivos</strong></h5><br>
                                <h6 class="text-center">Nesta página, você envia documentos
                                    digitalizados. O tamanho máximo do arquivo deve ser
                                    05MB.</h6>
                            </div>

                            <form class="formulario-ajax" method="POST" action="<?= SERVERURL ?>ajax/arquivosAjax.php"
                                  data-form="save" enctype="multipart/form-data">
                                <input type="hidden" name="_method" value="enviarArquivo">
                                <input type="hidden" name="origem_id" value="<?= $id ?>">
                                <input type="hidden" name="pagina" value="formacao/pf_demais_anexos&id=<?= $id ?>">
                                <table class="table text-center table-striped">
                                    <tbody>
                                    <?php
                                    foreach ($documentosRestantes as $documento){
                                        if (!$listaPfObj->checaEnviado($id, $documento->id)) {
                                            ?>
                                            <tr>
                                                <td>
                                                    <label for=""><?= "$documento->documento" ?></label>
                                                </td>
                                                <td>
                                                    <input type="hidden" name="<?= $documento->sigla ?>"
                                                           value="<?= $documento->id ?>">
                                                    <input class="text-center" type='file'
                                                           name='<?= $documento->sigla ?>'><br>
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                    }
                                    ?>
                                    </tbody>
                                </table>
                                <center>
                                    <div class="col-md-7 mt-3 text-center">
                                        <input type="submit" class="btn btn-success btn-md btn-block" name="enviar" value='Enviar'>
                                    </div>
                                </center>


                                <div class="resposta-ajax"></div>
                            </form>
                        </div>
                    </div>
                    <div class="col-md-12 mt-3">
                        <div class="card-footer">
                            <form method="POST" action="<?= SERVERURL . "formacao/pf_lista"?>">
                                <input type="hidden" value="<?= $id ?>" name="idPf">
                                <button type="submit" name="Voltar" class="btn btn-default pull-left">Voltar</button>
                            </form>
                        </div >
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!--.modal-->
<div class="modal fade" id="exclusao">
    <div class="modal-dialog">
        <div class="modal-content bg-danger">
            <div class="modal-header">
                <h4 class="modal-title">Confirmação de exclusão</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="form-horizontal formulario-ajax" method="POST" action="<?= SERVERURL ?>ajax/formacaoAjax.php" role="form" data-form="update">
                <input type="hidden" name="_method" value="removerArquivo">
                <input type="hidden" name="arquivo_id" id="arquivo_id" value="">
                <input type="hidden" name="id" value="<?= $id ?>">
                <div class="modal-body">
                    <p id="paragrafo"></p>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Não</button>
                    <button type="submit" class="btn btn-default">Sim</button>
                </div>
                <div class="resposta-ajax"></div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<script>
    function excluirArquivo(idArquivo, arquivo){
        limpaModal();
        $( "#paragrafo" ).text("Deseja realmente excluir o arquivo " + arquivo + "?");
        $( "#arquivo_id" ).val(idArquivo);
        $('#exclusao').modal('show')
    }

    function limpaModal() {
        $( "#paragrafo" ).text("");
        $( "#arquivo_id" ).val("");
    }
</script>
