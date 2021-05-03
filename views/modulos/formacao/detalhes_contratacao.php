<?php
    require_once "./controllers/FormacaoController.php";
    $id = isset($_GET['id']) ? $_GET['id'] : null;
    $detalhesObj = new FormacaoController();
    
    $detalhe = $detalhesObj->recuperaDetalhesContratacao($id);
?>
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-9">
                <h1 class="m-0 text-dark">Contratação Selecionada</h1>
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
                        <h3 class="card-title">Dados da contratação</h3>
                        <div class="card-tools">
                           
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <tr>
                                    <th style="width:30%">Ano:</th>
                                    <td><?= $detalhe->ano ?></td>
                                </tr>

                                <tr>
                                    <th style="width:30%">Chamado:</th>
                                    <td><?= $detalhe->chamado ?></td>
                                </tr>

                                <tr>
                                    <th style="width:30%">Classificacao Indicativa:</th>
                                    <td><?= $detalhe->classificacao_indicativa ?></td>
                                </tr>

                                <tr>
                                    <th style="width:30%">Território:</th>
                                    <td><?= $detalhe->territorio ?></td>
                                </tr>

                                <tr>
                                    <th style="width:30%">Coordenadoria:</th>
                                    <td><?= $detalhe->coordenadoria ?></td>
                                </tr>

                                <tr>
                                    <th style="width:30%">Subprefeitura:</th>
                                    <td><?= $detalhe->subprefeitura ?></td>
                                </tr>

                                <tr>
                                    <th style="width:30%">Programa:</th>
                                    <td><?= $detalhe->programa ?></td>
                                </tr>

                                <tr>
                                    <th style="width:30%">Linguagem:</th>
                                    <td><?= $detalhe->linguagem ?></td>
                                </tr>

                                <tr>
                                    <th style="width:30%">Projeto:</th>
                                    <td><?= $detalhe->projeto ?></td>
                                </tr>

                                <tr>
                                    <th style="width:30%">Cargo:</th>
                                    <td><?= $detalhe->cargo ?></td>
                                </tr>

                                <tr>
                                    <th style="width:30%">Vigência:</th>
                                    <td><?= $detalhe->vigencia ?></td>
                                </tr>

                                <tr>
                                    <th style="width:30%">Observação:</th>
                                    <td><?= $detalhe->observacao ?? 'Não Cadastrado' ?></td>
                                </tr>

                                <tr>
                                    <th style="width:30%">Fiscal:</th>
                                    <td><?= $detalhe->fiscal ?></td>
                                </tr>

                                <tr>
                                    <th style="width:30%">Suplente:</th>
                                    <td><?= $detalhe->suplente ?? "Não cadastrado" ?></td>
                                </tr>

                                <tr>
                                    <th style="width:30%">Número do Processo de Pagamento:</th>
                                    <td><?= $detalhe->numpgt ?? "Não cadastrado" ?></td>
                                </tr>
                            </table>
                        </div>
                        
                        <div class="card-footer">
                            <a href="<?= SERVERURL ?>formacao/dados_contratacao_lista">
                                <button type="button" class="btn btn-default pull-left">Voltar</button>
                            </a>
                            <form class="form-horizontal formulario-ajax" method="POST" action="<?=SERVERURL?>ajax/formacaoAjax.php" role="form" data-form="update">
                                <input type="hidden" name="_method" value="apagarDadosContratacao">
                                <input type="hidden" name="id" value="<?= $detalhesObj->encryption($detalhe->id)?>">
                                <button type="submit" class="btn bg-gradient-danger btn-sm  float-right">
                                    <i class="fas fa-trash"></i> Apagar
                                </button>
                                <div class="resposta-ajax"></div>
                            </form>
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