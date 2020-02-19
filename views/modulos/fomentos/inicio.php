<?php
/*require_once "./controllers/ProjetoController.php";
require_once "./controllers/FomentoController.php";
unset($_SESSION['projeto_s']);
unset($_SESSION['origem_id_s']);

$fomentoObj = new FomentoController();
$projetoObj = new ProjetoController();

$nomeEdital = $fomentoObj->recuperaNomeEdital($_SESSION['edital_s']);
$projetos = $projetoObj->listaProjetos();*/
?>
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-9">
                <h1 class="m-0 text-dark">Hello, world!</h1>
            </div><!-- /.col -->
            <div class="col-sm-3">

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
                        <h3 class="card-title">Projetos Cadastrados para o edital:</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">

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
        $('#fomentos_inicio').addClass('active');
    })
</script>