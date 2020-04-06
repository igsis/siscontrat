<?php

require_once "./controllers/AdministrativoController.php";

$id = isset($_GET['id']) ? $_GET['id'] : null;
$relacaoObj = new AdministrativoController();

$relacao = $relacaoObj->recuperaRelacoesJuridicas($id);

?>
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-12">
                <h1 class="m-0 text-dark">Cadastrar Relação Jurídica</h1>
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
                    <div class="card-body">
                    <div class="row justify-content-center"> 
                    </div>
                    </div>
                    <div class="row" >
                        <div class="col-12">
                        <div class="row mx-2">
                            <div class="col-12">
                                <form class="form-horizontal formulario-ajax" action="<?= SERVERURL ?>ajax/administrativoAjax.php" 
                                method="POST" role="form" data-form="<?= ($id) ? "update" : "save" ?>">
                                    <input type="hidden" name="_method" value="<?= ($id) ? "editarRelacoes" : "cadastrarRelacoes" ?>">
                                    <?php if ($id): ?>
                                        <input type="hidden" name="id" id="modulo_id" value="<?= $id ?>">
                                    <?php endif; ?>
                                    <div class="row">
                                        <div class="form-group col">
                                            <label for="sigla">Título: </label>
                                            <input type="text" class="form-control" id="relacao_juridica" name="relacao_juridica"
                                                maxlength="70" value="<?= $relacao->relacao_juridica ?? "" ?>" 
                                                required>
                                        </div>

                                    </div>
                                    
                                    <div class="card-footer">
                                        <a href="<?= SERVERURL ?>administrativo/relacoes_juridicas">
                                            <button type="button" class="btn btn-default pull-left">Voltar</button>
                                        </a>
                                        <button type="submit" name="cadastra" id="cadastra" class="btn btn-primary float-right">
                                            Gravar
                                        </button>
                                    </div >
                                    <div class="resposta-ajax"></div>
                                </form>
                            </div>
                        </div>
                        </div>  
                    </div>
                </div>
                <!-- /.card -->
            </div>
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content -->
<script type="application/javascript">
    $(document).ready(function () {
        $('.nav-link').removeClass('active');
        $('#relacoes_juridicas').addClass('active');
    })
</script>
