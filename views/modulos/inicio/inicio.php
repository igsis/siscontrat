<?php
unset($_SESSION['origem_id_s']);
unset($_SESSION['pedido_id_s']);
unset($_SESSION['modulo']);

$viewObj = new ViewsController();
$avisos = $viewObj->listaAvisos();
?>
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Bem-vindo ao SisContrat</h1>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h5 class="m-0">Mural de Atualizações</h5>
            </div>
            <div class="card-body">
                <?php foreach($avisos as $aviso):
                    $publicacao = new DateTime($aviso->data)
                    ?>
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h5 class="card-title"><?=$aviso->titulo?></h5>
                            <div class="card-tools text-right">
                                <?= $publicacao->format('d/m/Y') ?>
                            </div>
                        </div>
                        <div class="card-body">
                            <p class="card-text"><?=$aviso->mensagem?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
</div>
<!-- /.content -->