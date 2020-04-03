<?php
    require_once "./controllers/AdministrativoController.php";
    $moduloObj = new AdministrativoController();
    
    $modulos = $moduloObj->listaModulo();
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
                        <div class="col mb-2">
                            <a href="<?= SERVERURL ?>administrativo/cadastrar_modulo" class="btn btn-info  float-right mb-2"> Cadastrar módulo </a>
                        </div>
                    </div>
                    <div class="row" >
                        <div class="col-12">
                            <table id="tabela" class="table table-hover">
                                <thead>
                                <tr class="text-center">
                                    <th scope="col">Sigla</th>
                                    <th scope="col">Descrição</th>
                                    <th scope="col">Ações</th>
                                </tr>
                                </thead>
                                <?php foreach ($modulos as $modulo): ?>
                                <tr>
                                    <td><?=$modulo->sigla?></td>
                                    <td ><?=$modulo->descricao?></td>
                                    <td class="text-center">
                                        <a href="<?= SERVERURL . "administrativo/cadastrar_modulo&id=" . $moduloObj->encryption($modulo->id) ?>"
                                          class="btn btn-sm btn-primary"> Editar</a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                                </tbody>
                            </table>        
                        </div>  
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
        $('#modulo').addClass('active');
    })
</script>