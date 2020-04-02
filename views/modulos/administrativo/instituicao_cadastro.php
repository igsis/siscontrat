<?php
require_once "./controllers/InstituicaoController.php";

$id = isset($_GET['id']) ? $_GET['id'] : null;
$instituicaoObj = new InstituicaoController();

$instituicao = $instituicaoObj->recuperaInstituicao($id);
?>
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Cadastro de instituição</h1>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

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
                    action="<?= SERVERURL ?>ajax/instituicaoAjax.php" role="form"
                    data-form="<?= ($id) ? "update" : "save" ?>">
                    <input type="hidden" name="_method" value="<?= ($id) ? "editar" : "cadastrar" ?>">
                    <?php if ($id): ?>
                        <input type="hidden" name="id" id="instituicao_id" value="<?= $id ?>">
                    <?php endif; ?>
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-md-8">
                                    <label for="instituicao">Instituição: *</label>
                                    <input type="text" class="form-control" id="nome" name="nome" placeholder="Digite a instituição" value="<?=($instituicao) ? $instituicao->nome : ""?>" required>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="sigla">Sigla: *</label>
                                    <input type="text" class="form-control" id="sigla" name="sigla" placeholder="Digite a sigla" value="<?=($instituicao) ? $instituicao->sigla : ""?>" required>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <button type="submit" class="btn btn-info float-right">Gravar</button>
                        </div>
                        <!-- /.card-footer -->
                        <div class="resposta-ajax">

                        </div>
                    </form>

                </div>
                <!-- /.card -->
            </div>
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</div>

<script type="application/javascript">
    $(document).ready(function () {
        $('.nav-link').removeClass('active');
        $('#instituicoes').addClass('active');
    })
</script>