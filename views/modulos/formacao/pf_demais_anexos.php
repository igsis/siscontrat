<?php
require_once "./controllers/ArquivoController.php";
$arquivosObj = new ArquivoController();

$tipo_documento_id = 1;
$id = isset($_GET['id']) ? $_GET['id'] : null;
$lista_documento_ids = $arquivosObj->recuperaIdListaDocumento($tipo_documento_id)->fetchAll(PDO::FETCH_COLUMN);
?>
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Anexos dos documentos</h1>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="offset-3 col-md-6">
                <div class="card card-warning">
                    <div class="card-header">
                        <h3 class="card-title">Atenção!</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                        class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <ul>
                            <li><strong>Formato Permitido:</strong> PDF</li>
                            <li><strong>Tamanho Máximo:</strong> 6Mb</li>
                            <li>Clique nos arquivos após efetuar o upload e confira a exibição do documento!</li>
                        </ul>
                    </div>
                </div>
                <!-- /.card -->
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <!-- Horizontal Form -->
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">Lista de Arquivos</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- table start -->
                    <div class="card-body p-0">
                        <form class="formulario-ajax" method="POST" action="<?= SERVERURL ?>ajax/arquivosAjax.php"
                              data-form="save" enctype="multipart/form-data">
                            <input type="hidden" name="_method" value="enviarArquivo">
                            <input type="hidden" name="origem_id" value="<?= $id ?>">
                            <input type="hidden" name="pagina" value="<?= $_GET['views'] ?>">
                            <table class="table table-striped">
                                <tbody>
                                <?php
                                $arquivos = $arquivosObj->listarArquivos($tipo_documento_id)->fetchAll(PDO::FETCH_OBJ);
                                foreach ($arquivos as $arquivo) {
                                    if (!($arquivosObj->consultaArquivoEnviado($arquivo->id, $id))) {
                                        ?>
                                        <tr>
                                            <td>
                                                <div class="row">
                                                    <div class="col-md">
                                                        <label for=""><?= $arquivo->documento ?></label>
                                                    </div>

                                                    <div class="col-md">
                                                        <input type="hidden" name="<?= $arquivo->sigla ?>"
                                                               value="<?= $arquivo->id ?>">
                                                        <input class="text-center" type='file'
                                                               name='<?= $arquivo->sigla ?>'><br>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                }
                                ?>
                                </tbody>
                            </table>
                            <input type="submit" class="btn btn-success btn-md btn-block" name="enviar" value='Enviar'>

                            <div class="resposta-ajax"></div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- /.col -->
            <div class="col-md-6">
                <!-- Horizontal Form -->
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">Arquivos anexados</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- table start -->
                    <div class="card-body p-0">
                        <table class="table table-striped table-responsive">
                            <thead>
                            <tr>
                                <th>Tipo do documento</th>
                                <th>Nome do documento</th>
                                <th style="width: 30%">Data de envio</th>
                                <th style="width: 10%">Ação</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $arquivosEnviados = $arquivosObj->listarArquivosEnviados($id, $lista_documento_ids)->fetchAll(PDO::FETCH_OBJ);
                            if (count($arquivosEnviados) != 0) {
                                foreach ($arquivosEnviados as $arquivo) {
                                    ?>
                                    <tr>
                                        <td><?= $arquivo->documento ?></td>
                                        <td><a href="<?= SERVERURL . "uploads/" . $arquivo->arquivo ?>"
                                               target="_blank"><?= mb_strimwidth($arquivo->arquivo, '15', '25', '...') ?></a>
                                        </td>
                                        <td><?= $arquivosObj->dataParaBR($arquivo->data) ?></td>
                                        <td>
                                            <form class="formulario-ajax" action="<?= SERVERURL ?>ajax/arquivosAjax.php"
                                                  method="POST" data-form="delete">
                                                <input type="hidden" name="_method" value="removerArquivo">
                                                <input type="hidden" name="pagina" value="<?= $_GET['views'] ?>">
                                                <input type="hidden" name="arquivo_id"
                                                       value="<?= $arquivosObj->encryption($arquivo->id) ?>">
                                                <input type="hidden" name="origem_id" value="<?= $id ?>">
                                                <button type="submit" class="btn btn-sm btn-danger">Apagar</button>
                                                <div class="resposta-ajax"></div>
                                            </form>
                                        </td>
                                    </tr>
                                    <?php
                                }
                            } else {
                                ?>
                                <tr>
                                    <td class="text-center" colspan="4">Nenhum arquivo enviado</td>
                                </tr>
                                <?php
                            }
                            ?>
                            </tbody>
                        </table>
                    </div>

                </div>
                <!-- /.card -->
            </div>
        </div>
        <!-- /.row -->
        <div class="card-footer">
            <a href="<?= SERVERURL . "formacao/pf_cadastro&id=" . $id ?>" class="btn btn-default pull-left">
                Voltar
            </a>
        </div>
    </div><!-- /.container-fluid -->
</div>
<!-- /.content -->


<script type="application/javascript">
    $(document).ready(function () {
        $('.nav-link').removeClass('active');
        $('#itens-proponente').addClass('menu-open');
        $('#anexos-proponente').addClass('active');
    })
</script>