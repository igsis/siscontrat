<?php

require_once "./controllers/FormacaoController.php";

$id = isset($_GET['id']) ? $_GET['id'] : null;
$vigenciaObj = new FormacaoController();

$vigencia = $vigenciaObj->recuperaVigencia($id);

?>
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-12">
                <h1 class="m-0 text-dark">Vigência</h1>
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
                                    <input type="hidden" name="_method" value="<?= ($id) ? "editarVigencia" : "cadastrarVigencia" ?>">
                                    <?php if ($id): ?>
                                        <input type="hidden" name="id" id="modulo_id" value="<?= $id ?>">
                                    <?php endif; ?>
                                    <div class="row">
                                        <div class="form-group col-md-2">
                                            <label for="sigla">Ano*: </label>
                                            <input type="text" class="form-control" id="ano" name="ano"
                                                maxlength="70" value="<?= $vigencia->ano ?? "" ?>" 
                                                required>
                                        </div>

                                        <div class="form-group col-md-2">
                                            <label for="sigla">Qnt. Parcelas*: </label>
                                            <input type="number" class="form-control" id="numero_parcelas" name="numero_parcelas"
                                                maxlength="70" value="<?= $vigencia->numero_parcelas ?? "" ?>" 
                                                required>
                                        </div>
                                        
                                        <div class="form-group col-md-8">
                                            <label for="sigla">Descricao*: </label>
                                            <input type="text" class="form-control" id="descricao" name="descricao"
                                                maxlength="70" value="<?= $vigencia->descricao ?? "" ?>" 
                                                required>
                                        </div>
                                    
                                    </div>
                                    
                                    <div class="card-footer">
                                        <a href="<?= SERVERURL ?>formacao/vigencia_lista">
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
