<?php


if (isset($_POST['busca'])) {
    $dados = $_POST;

    array_splice($dados, 0, 1);
//    $resultados = $inscritoObj->listarIncritos($dados);
}

?>
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-9">
                <h1 class="m-0 text-dark">Listar Eventos</h1>
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
                        <h5>Formulario de pesquisa</h5>
                    </div>
                    <!-- /.card-header -->
                    <form method="post">
                        <input type="hidden" name="busca" value="1">
                        <div class="card-body">
                            <div class="row d-flex align-items-center">
                                <div class="col-sm-12 col-md-4">
                                    <label for="ano_inscricao">Ano de inscrição: </label>
                                    <input type="number" id="ano" name="ano" class="form-control inputs"
                                           value="<?= isset($dados['ano']) ? $dados['ano'] : '' ?>">
                                </div>
                                <div class="col-sm-12 col-md-2">
                                    <label for="dataInicio">Data Início:</label>
                                    <input type="date" class="form-control inputsData" name="data[]" id="dataInicio" value="<?= isset($dados['data'][0]) ? $dados['data'][0] : '' ?>">
                                </div>
                                <div class="col-sm-12 col-md-2">
                                    <label for="dataFim">Data Fim:</label>
                                    <input type="date" class="form-control inputsData" name="data[]" id="dataFim" value="<?= isset($dados['data'][1]) ? $dados['data'][1] : '' ?>">
                                </div>
                                <div class="col-sm-12 col-md-4">
                                    <label for="programa">Programa: </label>
                                    <select name="programa_id" id="programa_id" class="form-control inputs">
                                        <option value="">Selecione uma opção...</option>
                                        <?php
//                                        $inscritoObj->geraOpcao("programas", isset($dados['programa_id']) ? $dados['programa_id'] : '')
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-md-4">
                                    <label for="funcao">Função:</label>
                                    <select name="form_cargo_id" id="form_cargo_id" class="form-control inputs">

                                    </select>
                                </div>
                                <div class="col-sm-12 col-md-4">
                                    <label for="regiao_preferencial">Região Preferencial: </label>
                                    <select name="regiao_preferencial_id" id="regiao_preferencial_id"
                                            class="form-control inputs">
                                        <option value="">Selecione uma opção...</option>
                                        <?php
//                                        $inscritoObj->geraOpcao("regiao_preferencias", isset($dados['regiao_preferencial_id']) ? $dados['regiao_preferencial_id'] : '');
                                        ?>
                                    </select>
                                </div>
                                <div class="col-sm-12 col-md-4">
                                    <label for="linguagem">Linguagem</label>
                                    <select name="linguagem_id" id="linguagem_id" class="form-control inputs">
                                        <option value="">Selecione uma opção...</option>
                                        <?php
//                                        $inscritoObj->geraOpcao("linguagens", isset($dados['linguagem_id']) ? $dados['linguagem_id'] : '');
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row d-flex align-items-center">
                                <div class="col-sm-12 col-md-4">
                                    <label for="genero">Gênero: </label>
                                    <select name="genero_id" id="genero_id" class="form-control inputs">
                                        <option value="">Selecione uma opção...</option>
                                        <?php
//                                        $inscritoObj->geraOpcao("generos", isset($dados['genero_id']) ? $dados['genero_id'] : '', false, false, true);
                                        ?>
                                    </select>
                                </div>
                                <div class="col-sm-6 col-md-2 d-flex flex-column align-items-center">
                                    <label for="trans">Trans:</label>
                                    <input type="checkbox" name="trans" id="trans" class="form-control checks"
                                           value="1" <?= isset($dados['trans']) ? 'checked' : '' ?>>
                                </div>
                                <div class="col-sm-6 col-md-2 d-flex flex-column align-items-center">
                                    <label for="pcd">PCD: </label>
                                    <input type="checkbox" name="pcd" id="pcd" class="form-control checks"
                                           value="1" <?= isset($dados['pcd']) ? 'checked' : '' ?>>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <button id="pesquisa" class="btn btn-info float-right">Pesquisar</button>
                        </div>
                    </form>
                </div>
                <!-- /.card -->
            </div>
        </div>
<!--        --><?php //if (isset($_POST['busca'])): ?>
            <div class="row">
                <div class="col-12">
                    <div class="card card-info">
                        <div class="card-header">
                            <h5>Resultados</h5>
                        </div>
                        <div class="card-body overflow-auto">
                            <table id="tabela" class="table table-bordered table-striped">

                            </table>
                        </div>
                    </div>
                </div>
            </div>
<!--        --><?php //endif; ?>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content -->