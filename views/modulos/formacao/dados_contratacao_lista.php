<?php
    require_once "./controllers/FormacaoController.php";
    $id = isset($_GET['id']) ? $_GET['id'] : null;
    $dados_contratacaoObj = new FormacaoController();
    
    $dados_contratacao = $dados_contratacaoObj->listaDadosContratacao();
    //var_dump($dados_contratacao);
?>
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-9">
                <h1 class="m-0 text-dark">Dados Para Contratação</h1>
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
                <div class="card card-info card-outline">
                    <div class="card-header">
                        <h3 class="card-title">Listagem</h3>
                        <div class="card-tools">
                            <!-- button with a dropdown -->
                            <a href="<?= SERVERURL ?>formacao/dados_contratacao_cadastro" class="btn btn-success btn-sm" >
                                <i class="fas fa-plus"></i> Cadastrar Novo
                            </a>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="tabela" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Protocolo</th>
                                    <th>Nome</th>
                                    <th>Ano</th>
                                    <th>Programa</th>
                                    <th>Linguagem</th>
                                    <th>Cargo</th>
                                    <th style="width:15%">Visualizar</th>
                                    <th style="width:15%">Editar</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($dados_contratacao as $contratacao): ?>
                                <tr>
                                    <td><?=$contratacao['protocolo']?></td>
                                    <td><?=$contratacao['pessoa']?></td>
                                    <td><?=$contratacao['ano']?></td>
                                    <td><?=$contratacao['programa']?></td>
                                    <td><?=$contratacao['linguagem']?></td>
                                    <td><?=$contratacao['cargo']?></td>
                                    <td>
                                        <a href="<?= SERVERURL . "formacao/detalhes_contratacao&id=" . $dados_contratacaoObj->encryption($contratacao['id']) ?>">
                                            <button type="submit" class="btn bg-gradient-info btn-sm float-left mr-2">
                                                <i class="fas fa-user-edit"></i> Visualizar
                                            </button>
                                        </a>
                                    </td>
                                    <td>
                                    <a href="<?= SERVERURL . "formacao/dados_contratacao_cadastro&id=" . $dados_contratacaoObj->encryption($contratacao['id']) ?>">
                                        <button type="submit" class="btn bg-gradient-primary btn-sm">
                                            <i class="fas fa-user-edit"></i> Editar
                                        </button>
                                    </td>
                                </tr>
                                <?php endforeach; ?> 
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Protocolo</th>
                                    <th>Nome</th>
                                    <th>Ano</th>
                                    <th>Programa</th>
                                    <th>Linguagem</th>
                                    <th>Cargo</th>
                                    <th style="width:15%">Visualizar</th>
                                    <th style="width:15%">Editar</th>

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
<!-- /.content -->

<div class="modal fade" id="arquivarEdital" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Arquivar Edital</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <p> </p>
            </div>
            <form class="form-horizontal formulario-ajax" method="POST" action="<?= SERVERURL ?>ajax/fomentoAjax.php" role="form" data-form="save">
                <input type="hidden" name="_method" value="arquivaEdital">
                <input type="hidden" name="id" id="id" value="">
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success">Arquivar</button>
                </div>
                <div class="resposta-ajax"></div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>