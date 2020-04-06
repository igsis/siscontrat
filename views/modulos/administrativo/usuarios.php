<?php
    require_once "./controllers/AdministrativoController.php";
    $usuarioObj = new AdministrativoController();
    
    $usuarios = $usuarioObj->listaUsuarios();
?>
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-9">
                <h1 class="m-0 text-dark">Lista de Usuários</h1>
            </div><!-- /.col -->
            <div class="col-3">
                <a href="<?= SERVERURL ?>administrativo/cadastrar_usuario"><button class="btn btn-success btn-block">Adicionar usuários</button></a>
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
                                    <th scope="col">Nome</th>
                                    <th scope="col">Usuário</th>
                                    <th scope="col">RF/RG</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Telefone</th>
                                    <th scope="col">Editar</th>
                                    <th scope="col">Excluir</th>
                                </tr>
                                </thead>
                                <?php foreach ($usuarios as $usuario): ?>
                                <tr>
                                    <td><?=$usuario->nome_completo?></td>
                                    <td><?=$usuario->usuario?></td>
                                    <td><?=$usuario->rf_rg?></td>
                                    <td><?=$usuario->email?></td>
                                    <td><?=$usuario->telefone?></td>
                                    <td class="text-center">
                                        <a href="<?= SERVERURL . "administrativo/cadastrar_usuario&id=" . $usuarioObj->encryption($usuario->id) ?>"
                                          class="btn btn-sm btn-primary"><i class="fas fa-edit"></i> Editar</a>
                                    </td>
                                    <td class="text-center">
                                        <form class="form-horizontal formulario-ajax" method="POST" action="<?=SERVERURL?>ajax/administrativoAjax.php" role="form" data-form="update">
                                            <input type="hidden" name="_method" value="apagarUsuario">
                                            <input type="hidden" name="id" value="<?= $usuarioObj->encryption($usuario->id)?>">
                                            <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i> Excluir</button>
                                                <div class="resposta-ajax"></div>
                                        </form>
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
        $('#usuarios').addClass('active');
    })
</script>