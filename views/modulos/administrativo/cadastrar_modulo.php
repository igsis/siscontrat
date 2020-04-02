<?php

require_once "./controllers/ModuloController.php";

$id = isset($_GET['id']) ? $_GET['id'] : null;
$moduloObj = new ModuloController();

$modulo = $moduloObj->recuperaModulo($id);

?>
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-12">
                <h1 class="m-0 text-dark">Administrador</h1>
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
                    <!-- /.card-header -->
                    <div class="card-body">
                    <div class="row justify-content-center"> 
                    </div>
                    </div>
                    <div class="row" >
                        <div class="col-12">
                        <div class="row mx-2">
                            <div class="col-12">
                                <form class="form-horizontal formulario-ajax" action="<?= SERVERURL ?>ajax/moduloAjax" 
                                method="POST" role="form" data-form="<?= ($id) ? "update" : "save" ?>">
                                    <input type="hidden" name="_method" value="<?= ($id) ? "editar" : "cadastra" ?>">
                                    <?php if ($id): ?>
                                        <input type="hidden" name="id" id="modulo_id" value="<?= $id ?>">
                                    <?php endif; ?>
                                    <div class="row">
                                        <div class="form-group col-md-4">
                                            <label for="sigla">Sigla: </label>
                                            <input type="text" class="form-control" id="sigla" name="sigla"
                                                maxlength="70" value="<?= $modulo->sigla ?? "" ?>" 
                                                required>
                                        </div>

                                        <div class=" form-group col-md-4 ">
                                            <label for="descricao">Descrição</label>
                                            <input type="text" class="form-control" name="descricao" id="descricao" 
                                            value="<?= $modulo->descricao ?? "" ?>" required>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="cor_id">Cor</label>
                                                <select class="form-control" name="cor_id" id="cor_id"
                                                        required>
                                                    <option value="">Selecione uma opção...</option>
                                                    <?php $moduloObj->geraOpcao('cores', $modulo->cor_id ?? "", false, false, false); ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-1 cor text-center" style="margin-top: 6px; display: none;">
                                        </div>   

                                    </div>
                                    
                                    <div class="card-footer">
                                        <a href="<?= SERVERURL ?>administrativo/modulo">
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
        $('#modulo').addClass('active');
    })
</script>

<script>
    $("#cor").on("change", function () {

        let selecionado = $("#cor :selected").text();

        let cor = selecionado.split("-");

        if (cor.length > 2) {
            cor = cor[1] + "-" + cor[2];
        } else {
            cor = cor[1];
        }

        let div = document.querySelector(".cor");

        div.style.display = "block";

        $(".cor").html("<label for='cor'><span class='glyphicon glyphicon-eye-open'></span></label><input type='text' class='form-control bg-"+ cor + "' disabled>");

    });
</script>