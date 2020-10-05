<?php

require_once "./controllers/FormacaoController.php";

$id = isset($_GET['id']) ? $_GET['id'] : null;
$linguagemObj = new FormacaoController();

$linguagem = $linguagemObj->recuperaLinguagem($id);

?>
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-12">
                <h1 class="m-0 text-dark">Linguagem</h1>
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
                                <form class="form-horizontal formulario-ajax" action="<?= SERVERURL ?>ajax/formacaoAjax.php" 
                                method="POST" role="form" data-form="<?= ($id) ? "update" : "save" ?>">
                                    <input type="hidden" name="_method" value="<?= ($id) ? "editarLinguagem" : "cadastrarLinguagem" ?>">
                                    <?php if ($id): ?>
                                        <input type="hidden" name="id" id="modulo_id" value="<?= $id ?>">
                                    <?php endif; ?>
                                    <div class="row">
                                        <div class="form-group col">
                                            <label for="sigla">Linguagem: *</label>
                                            <input type="text" class="form-control" id="linguagem" name="linguagem"
                                                maxlength="20" value="<?= $linguagem->linguagem ?? "" ?>"
                                                required>
                                        </div>                                    
                                    
                                    </div>
                                    
                                    <div class="card-footer">
                                        <a href="<?= SERVERURL ?>formacao/linguagem_lista">
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
