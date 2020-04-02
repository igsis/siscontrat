<?php
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
                                <form class="form-horizontal formulario-ajax" action="<?= SERVERURL ?>ajax/moduloAjax" method="POST" role="form">
                                    <input type="hidden" name="_method" value="<?= ($id) ? "editar" : "cadastra" ?>">
                                    <div class="row">
                                        <div class="form-group col-md-4">
                                            <label for="sigla">Sigla: </label>
                                            <input type="text" class="form-control" id="sigla" name="sigla"
                                                maxlength="70" required>
                                        </div>

                                        <div class=" form-group col-md-4 ">
                                            <label for="descricao">Descrição</label>
                                            <input type="text" class="form-control" name="descricao" id="descricao">
                                        </div>

                                        <div class="col-md-4 form-group">
                                            <label for="cor">Cor</label>
                                            <input type="text" class="form-control" name="cor" id="cor">
                                        </div>
                                        <div class="form-group col-md-1 cor text-center" style="margin-top: 6px; display: none;">
                                        </div>   

                                    </div>

                                    <div class="box-footer">
                                        <a href="<?= SERVERURL ?>administrativo/modulo">
                                            <button type="button" class="btn btn-default pull-left">Voltar</button>
                                        </a>
                                        <button type="submit" name="cadastra" id="cadastra" class="btn btn-primary pull-right">
                                            Cadastrar
                                        </button>
                                    </div class="resposta-ajax">
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