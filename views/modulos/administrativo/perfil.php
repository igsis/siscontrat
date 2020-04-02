<?php
require_once "./controllers/AdministradorController.php";
$AdmObj = new AdministradorController();

$Adms = $AdmObj->listaPerfis();

?>
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-9">
                <h1 class="m-0 text-dark">Lista de Perfis</h1>
            </div><!-- /.col -->
            <div class="col-sm-3">
                <a href="<?= SERVERURL . "administrativo/perfil_cadastro"?>">
                    <button class="btn btn-success btn-block">Adicionar</button>
                </a>
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
                        <div class="card-body">
                            <table id="tabela" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>Perfil</th>
                                    <th>Modulos</th>
                                    <th>Token</th>
                                    <th>Editar</th>
                                    <th>Excluir</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($Adms as $Adm): ?>
                                    <tr>
                                        <td><?= $Adm->descricao ?></td>
                                        <td></td>
                                        <td><?= $Adm->token ?></td>
                                        <td>
                                            <a href="<?= SERVERURL . "administrativo/perfil_cadastro&id=" . $AdmObj->encryption($Adm->id) ?>""
                                               class="btn btn-sm btn-primary"><i class="fas fa-edit"></i> Editar</a>
                                        </td>
                                        </td>
                                        <td><a href="#" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i>Excluir</a>
                                        </td>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th>Perfil</th>
                                    <th>Modulos</th>
                                    <th>Token</th>
                                    <th>Editar</th>
                                    <th>Excluir</th>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                        <!-- /.card-body -->

                    </div>
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
