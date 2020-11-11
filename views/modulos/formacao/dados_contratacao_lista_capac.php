<?php
require_once "./controllers/FormacaoController.php";
$id = isset($_GET['id']) ? $_GET['id'] : null;
$getAno = isset($_GET['ano']) ? $_GET['ano'] : 0;
$dados_contratacaoObj = new FormacaoController();
$pfObj = new PessoaFisicaController();

if ($getAno) {
    $dados_contratacao = $dados_contratacaoObj->listaDadosContratacaoCapac($getAno);
} else {
    $dados_contratacao = $dados_contratacaoObj->listaDadosContratacaoCapac();
}

$ano = date("Y");

?>
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-9">
                <h1 class="m-0 text-dark">Importar - CAPAC</h1>
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
                        <h3 class="card-title">Listagem de dados para contratação</h3>
                        <div class="card-tools">
                            <button class="btn bg-purple btn-sm" data-toggle="modal"
                                    data-target="#modal-escolher-ano">
                                <i class="far fa-calendar"></i>
                                Escolha o Ano
                            </button>
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
                                <th>Ação</th>

                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($dados_contratacao as $contratacao) : ?>
                                <tr>
                                    <td><?= $contratacao->protocolo ?></td>
                                    <td><?= $contratacao->nome ?></td>
                                    <td><?= $contratacao->ano ?></td>
                                    <td><?= $contratacao->programa ?></td>
                                    <td><?= $contratacao->linguagem ?></td>
                                    <td><?= $contratacao->cargo ?></td>
                                    <td>
                                        <?php
                                        $buscaCpf = $pfObj->getCPF($contratacao->cpf)->rowCount();
                                        if ($buscaCpf > 0){ // cpf presente no sis
                                            $dadoCompativel = $pfObj->comparaPf($contratacao->cpf); //compara dados sis e capac
                                            if (!$dadoCompativel){ //dados divergentes
                                                $idPf = $pfObj->getCPF($contratacao->cpf)->fetchObject()->id;
                                                $idPf =  $dados_contratacaoObj->encryption($idPf);
                                                $idContratacao = $dados_contratacaoObj->encryption($contratacao->id);
                                                $onClick = "onclick='atualizarPf(\"". $idPf ."\", \"". $idContratacao ."\")'";
                                            } else {
                                                $onClick = "href=". SERVERURL . "formacao/dados_contratacao_cadastro&capac=" . $dados_contratacaoObj->encryption($contratacao->id);
                                            }
                                        } else {
                                            //pf a ser importado no sis
                                            $idPf =  $dados_contratacaoObj->encryption($contratacao->pf_id);
                                            $onClick = "onclick='importarPf(\"". $idPf ."\")'";
                                        }
                                        ?>
                                        <?php if (! $dados_contratacaoObj->chegaProtocolo($contratacao->protocolo)) : ?>
                                            <a <?= $onClick ?> class="btn bg-gradient-info btn-sm" style="color:black" >
                                                <i class="fas fa-arrow-alt-circle-down"></i> Importar
                                            </a>
                                        <?php else: ?>
                                        <?php
//                                            $idContratacao = recuperaIdContratacao($contratacao->protocolo);
//                                            $idContratacao = $dados_contratacaoObj->encryption($idContratacao);
                                        ?>
                                            <a href="<?= SERVERURL . 'formacao/dados_contratacao_cadastro&id=' . $idContratacao ?>" class="btn bg-gradient-warning btn-sm" style="color:black">
                                                <i class="fas fa-arrow-alt-circle-down"></i> Importado
                                            </a>
                                        <?php endif; ?>

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
                                <th>Ação</th>

                            </tr>
                            </tfoot>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
        </div>  <!-- /.row -->
        <div class="card-footer">
            <a href="<?= SERVERURL ?>formacao/dados_contratacao_lista">
                <button type="button" class="btn btn-default pull-left">Voltar</button>
            </a>
        </div>
    </div><!-- /.container-fluid -->
</div>
<!-- /.content -->

<div class="modal fade" id="modal-escolher-ano">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Escolha Ano dos Pedidos</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label for="ano">Ano:</label>
                            <input type="number" name="ano" id="ano" class="form-control" min="<?= $ano - 1 ?>"
                                   max="<?= $ano ?>"
                                   value="<?= $ano - 1 ?>">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                <button class="btn btn-primary" id="btn-filtrar">Filtrar</button>
            </div>
        </div>
    </div>
</div>

<script>
    let btnFiltrar = document.querySelector('#btn-filtrar');
    let url = "<?= SERVERURL ?>formacao/dados_contratacao_lista_capac";

    btnFiltrar.addEventListener('click', () => {
        let ano = document.querySelector('#ano').value;
        window.location.href = `${url}&ano=${ano}`;
    });

    function importarPf(idPf) {
        Swal.fire({
            title: '<strong>Importar Proponente</strong>',
            type: 'info',
            html:
                '<h6>O proponente deste cadastro precisa ser importado antes de continuar este processo.</h6>',
            showCloseButton: true,
            showCancelButton: true,
            focusConfirm: true,
            reverseButtons: true,
            confirmButtonText: 'Importar',
            cancelButtonText: 'Cancelar',
        }).then(function (result) {
            if (result.value) {
                window.location.href =  "<?= SERVERURL ?>formacao/pf_cadastro&capac=" + idPf;
            }
        })
    }

    function atualizarPf(idPf, idContratacao) {
        Swal.fire({
            title: '<strong>Atualizar Proponente</strong>',
            type: 'info',
            html:
                '<h6>O cadastro deste proponente contém dados no SisContrat que divergem do CAPAC, deseja atualiza-lo?</h6>',
            showCloseButton: true,
            showCancelButton: true,
            focusConfirm: true,
            reverseButtons: true,
            confirmButtonText: 'Atualizar proponente',
            cancelButtonText: 'Seguir importação',
        }).then(function (result) {
            if (result.value) {
                window.location.href =  "<?= SERVERURL ?>formacao/pf_cadastro&id=" + idPf;
            } else {
                window.location.href =  "<?= SERVERURL ?>formacao/dados_contratacao_cadastro&capac=" + idContratacao;
            }
        })
    }

</script>