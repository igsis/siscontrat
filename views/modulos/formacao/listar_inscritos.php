<?php
require_once "./controllers/FormacaoController.php";
$formacaoObj = new FormacaoController();


?>
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-9">
                <h1 class="m-0 text-dark">Listar Cadastrados no CAPAC</h1>
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
                        <h3>Formulario de pesquisa</h3>
                    </div>
                    <!-- /.card-header -->
                    <form action="">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-12 col-md-2">
                                    <label for="ano_inscricao">Ano de inscrição: </label>
                                    <input type="number" name="ano_inscricao" class="form-control" min="2019"
                                           max="<?= date("Y") ?>">
                                </div>
                                <div class="col-sm-12 col-md-10">
                                    <label for="nome">Nome proponente: </label>
                                    <input type="text" name="nome" class="form-control" maxlength="">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-md-4">
                                    <label for="programa">Programa:</label>
                                    <select name="programa" id="" class="form-control"></select>
                                </div>
                                <div class="col-sm-12 col-md-4">
                                    <label for="funcao">Função:</label>
                                    <select name="funcao" id="" class="form-control"></select>
                                </div>
                                <div class="col-sm-12 col-md-4">
                                    <label for="linguagem">Linguagem</label>
                                    <select name="" id="" class="form-control"></select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-md-6">
                                    <label for="regiao_preferencial">Região Preferencial: </label>
                                    <select name="regiao_preferencial" id="" class="form-control"></select>
                                </div>
                                <div class="col-sm-12 col-md-6">
                                    <label for="tipo_cadastro">Tipo de Cadastro: </label>
                                    <select name="tipo_cadastro" id="" class="form-control"></select>
                                </div>
                            </div>


                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <button class="btn btn-info float-right">Pesquisar</button>
                        </div>
                    </form>
                </div>
                <!-- /.card -->
            </div>
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content -->