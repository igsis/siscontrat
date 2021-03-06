<?php
require_once "./controllers/AdministrativoController.php";

$id = isset($_GET['id']) ? $_GET['id'] : null;
$perfilObj = new AdministrativoController();


$perfil = $perfilObj->recuperaPerfil($id)
?>
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-9">
                <h1 class="m-0 text-dark">Cadastro de Perfil</h1>
            </div><!-- /.col --><!-- /.col -->
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
                    <form class="form-horizontal formulario-ajax" method="POST"
                          action="<?= SERVERURL ?>ajax/administrativoAjax.php" role="form"
                          data-form="<?= ($id) ? "update" : "save" ?>">
                        <input type="hidden" name="_method" value="<?= ($id) ? "editaPerfil" : "cadastraPerfil" ?>">
                        <?php if ($id): ?>
                            <input type="hidden" name="id" id="id" value="<?= $id ?>">
                        <?php endif; ?>
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-md-9">
                                    <label for="titulo">Descrição do perfil :</label>
                                    <input type="text" class="form-control" id="descricao" name="descricao"
                                           value="<?= $perfil->descricao ?? "" ?>" required>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="titulo">Token: *</label>
                                    <input type="text" class="form-control" id="token" name="token"
                                           value="<?= $perfil->token ?? "" ?>" required>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-info float-right">Gravar</button>
                        </div>
                        <div class="resposta-ajax"></div>
                    </form>
                    <!-- /.card -->
                </div>
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>


</div>
<!-- /.card-body -->
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
        $('#perfil').addClass('active');
    })
</script>
