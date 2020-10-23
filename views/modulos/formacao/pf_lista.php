<?php
    require_once "./controllers/FormacaoController.php";
    $formacaoObj = new FormacaoController();
    
    $lista_pf = $formacaoObj->listaPedidos();

    $anoVigencia = $formacaoObj->recuperaAnoVigente()->ano_vigente;

?>
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-9">
                <h1 class="m-0 text-dark">Pessoas Físicas</h1>
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
                        <h3 class="card-title">Listagem de pedidos de Pessoas Físicas</h3>
                        <div class="card-tools">
                            <!-- button with a dropdown -->
                            <a href="<?= SERVERURL ?>formacao/pesquisa_pf" class="btn btn-success btn-sm" >
                                <i class="fas fa-plus"></i> Cadastrar Novo
                            </a>
                            <button type="button" class="btn btn-info btn-sm">
                                <i class="fas fa-arrow-alt-circle-down"></i> Importar do CAPAC
                            </button>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="tabela" class="table table-bordered table-striped">
                            <thead>
                            <tr>

                                <th>Número Processo</th>
                                <th>Protocolo</th>
                                <th>Proponente</th>
                                <th>CPF/Passaporte</th>
                                <th>Ano</th>
                                <th>Status</th>
                                <th style="width:15%">Ação</th>
                            </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($lista_pf as $pf): ?>
                                <tr>
                                    <td><?= $pf->numero_processo?></td>
                                    <td><?= $pf->protocolo?></td>
                                    <td><?=$pf->nome?></td>
                                    <td>
                                        <?php
                                        if (isset($pf->cpf) && $pf->cpf != ""){
                                            echo $pf->cpf;
                                        }else{
                                            echo $pf->passaporte;
                                        }
                                        ?>
                                    </td>
                                    <td><?= $pf->ano?></td>
                                    <td><?= $pf->status?></td>
                                    <td>
                                        <?php if ($pf->ano >= $anoVigencia): ?>
                                            <a href="<?= SERVERURL . "formacao/pedido_contratacao_cadastro&pedido_id=" . $formacaoObj->encryption($pf->id) ?>" class="btn bg-gradient-primary btn-sm">
                                                <i class="fas fa-user-edit"></i> &nbsp; Editar &nbsp; &nbsp;
                                            </a>
                                        <?php else: ?>
                                            <a href="<?= SERVERURL . "formacao/pedido_visualizar&pedido_id=" . $formacaoObj->encryption($pf->id) ?>" class="btn bg-gradient-primary btn-sm">
                                                <i class="fas fa-list"></i> &nbsp; Visualizar
                                            </a>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php endforeach; ?>  
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Número Processo</th>
                                    <th>Protocolo</th>
                                    <th>Proponente</th>
                                    <th>CPF/Passaporte</th>
                                    <th>Ano</th>
                                    <th>Status</th>
                                    <th style="width:15%">Ação</th>
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