<?php
    require_once "./controllers/AdministrativoController.php";
    $moduloObj = new AdministrativoController();
    
    $modulos = $moduloObj->listaModulo();
?>
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-9">
                <h1 class="m-0 text-dark">Lista de Módulos</h1>
            </div><!-- /.col -->
            <div class="col-3">
                <a href="<?= SERVERURL ?>administrativo/cadastrar_modulo"><button class="btn btn-success btn-block">Adicionar módulo</button></a>
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
                        <h3 class="card-title">Listagem</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                    <div class="row" >
                        <div class="col-12">
                            <table id="tabela" class="table table-bordered table-striped">
                                <thead>
                                <tr class="text-center">
                                    <th scope="col">Sigla</th>
                                    <th scope="col">Descrição</th>
                                    <th scope="col">Ação</th>
                                </tr>
                                </thead>
                                <?php foreach ($modulos as $modulo): ?>
                                <tr>
                                    <td><?=$modulo->sigla?></td>
                                    <td ><?=$modulo->descricao?></td>
                                    <td class="text-center">
                                        <a href="<?= SERVERURL . "administrativo/cadastrar_modulo&id=" . $moduloObj->encryption($modulo->id) ?>"
                                          class="btn btn-sm btn-primary"> <i class="fas fa-edit"></i>Editar</a>
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