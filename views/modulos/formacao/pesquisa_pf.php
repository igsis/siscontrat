<?php

require_once "./controllers/FormacaoController.php";

$id = isset($_GET['id']) ? $_GET['id'] : null;


?>
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-12">
                <h1 class="m-0 text-dark">Formação</h1>
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
                <div class="card card-info card-outline ">
                    <div class="card-header">
                        <h3 class="card-title">Pesquisar por pessoa física</h3>
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
                                    <input type="hidden" name="_method" value="">
                                    <?php if ($id): ?>
                                        <input type="hidden" name="id" id="modulo_id" value="<?= $id ?>">
                                    <?php endif; ?>
                                    <div class="row">
                                        <label for="tipoDocumento">Tipo de documento: </label>
                                        <label class="radio-inline">
                                            <input type="radio" name="tipoDocumento" value="1" checked>CPF
                                        </label>
                                        <label class="radio-inline">
                                            <input type="radio" name="tipoDocumento" value="2">Passaporte
                                        </label>
                                    </div>
                                    <div class="row">
                                        <label for="procurar">Pesquisar:</label>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col">
                                            <label for="cpf" id="textoDocumento">CPF *</label>
                                                <input type="text" class="form-control" minlength=14 name="procurar"
                                                value="" id="cpf" data-mask="000.000.000-00" minlength="14">
                                            <!-- <input type="text" class="form-control" name="passaporte" id="passaporte"
                                                value="" maxlength="10"> -->
                                                
                                        </div>        
                                    </div>                                        
                                    
                                    <div class="card-footer">
                                        <a href="<?= SERVERURL ?>formacao/pf_lista">
                                            <button type="button" class="btn btn-default pull-left">Voltar</button>
                                        </a>
                                        <button type="submit" name="cadastra" id="cadastra" class="btn btn-primary float-right">
                                            Buscar
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
