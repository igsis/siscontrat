<?php
$id = isset($_GET['id']) ? $_GET['id'] : null;
require_once "./controllers/FomentoController.php";
$fomentoObj = new FomentoController();

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
                        <input type="hidden" name="pagina" value="fomentos">
                        <input type="hidden" name="data_publicacao" value="<?= date('Y-m-d H:i:s') ?>">
                        <?php if ($id): ?>
                            <input type="hidden" name="id" value="<?= $id ?>">
                        <?php endif; ?>
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="tipo_contratacao_id">Tipo: *</label>
                                    <select class="form-control" name="tipo_contratacao_id" id="tipo_contratacao_id" required>
                                        <option value="">Selecione uma opção...</option>
                                        <?php //$eventoObj->geraOpcao('fomentos', $evento->fomento_id ?? ""); ?>
                                    </select>
                                    <label for="titulo">Título: *</label>
                                    <input type="text" class="form-control" id="titulo" name="titulo" maxlength="20" value="<?= $fomento->titulo ?? "" ?>" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="descricao">Descrição: *</label>
                                    <textarea name="descricao" id="descricao" class="form-control" rows="5" required><?=$fomento->descricao ?? ""?></textarea>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-3">
                                    <label for="valor_max_projeto">Valor máximo do projeto: *</label>
                                    <input type="text" class="form-control" id="valor_max_projeto" name="valor_max_projeto" value="<?= $fomento->valor_max_projeto ?? "" ?>" required>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="valor_edital">Valor edital: *</label>
                                    <input type="text" class="form-control" id="valor_edital" name="valor_edital" value="<?= $fomento->valor_max_projeto ?? "" ?>" required>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="data_abertura">Data de abertura: *</label>
                                    <input type="datetime-local" class="form-control" id="data_abertura" name="data_abertura" value="<?= $fomento->data_abertura ?? "" ?>" required>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="data_encerramento">Data de encerramento: *</label>
                                    <input type="datetime-local" class="form-control" id="data_encerramento" name="data_encerramento" value="<?= $fomento->data_encerramento ?? "" ?>" required>
                                </div>
                            </div>
                        </div>
                        <div class="resposta-ajax"></div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <button type="submit" class="btn btn-info float-right">Gravar</button>
                        </div>
                        <!-- /.card-footer -->
                    </form>
                </div>
                <!-- /.card -->
            </div>
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content -->