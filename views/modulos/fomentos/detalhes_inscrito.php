<?php
$id = $_GET['id'];

require_once "./controllers/ArquivoController.php";
require_once "./controllers/FomentoController.php";

$arqObj = new ArquivoController();
$fomentoObj = new FomentoController();

$projeto = $fomentoObj->recuperaProjeto($id);

if($projeto['pessoa_tipo_id'] == 1){
    require_once "./controllers/PessoaFisicaController.php";
    $pessoaFisicaObj = new PessoaFisicaController();
    $pf = $pessoaFisicaObj->recuperaPessoaFisica(MainModel::encryption($projeto['pessoa_fisica_id']),true);
}

/* arquivos */
$tipo_contratacao_id = $fomentoObj->recuperaTipoContratacao((string)MainModel::encryption($projeto['fom_edital_id']));
$lista_documento_ids = $arqObj->recuperaIdListaDocumento(MainModel::encryption($projeto['fom_edital_id']), true)->fetchAll(PDO::FETCH_COLUMN);
$arqEnviados = $arqObj->listarArquivosEnviados(MainModel::encryption($projeto['id']), $lista_documento_ids, $tipo_contratacao_id)->fetchAll(PDO::FETCH_OBJ);
$strArquivos = '';
?>

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-9">
                <h1 class="m-0 text-dark">Detalhes do Inscrito</h1>
            </div><!-- /.col -->
            <div class="col-sm-3 status-projeto">
                <?php if ($projeto['publicado'] == 1): ?>
                    <div class="btn-group">
                        <button type="button" id="reprovar" class="btn btn-danger">
                            <i class="fas fa-times"></i> &nbsp;Reprovar
                        </button>
                        <button type="button" id="aprovar" class="btn btn-success">
                            <i class="fas fa-check"></i> &nbsp;Aprovar
                        </button>
                    </div>
                <?php elseif ($projeto['publicado'] == 2): ?>
                    <h3 class="text-success text-right mr-3">Aprovado</h3>
                <?php elseif ($projeto['publicado'] == 3): ?>
                    <h3 class="text-danger text-right mr-3">Reprovado</h3>
                <?php endif; ?>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->


<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <!-- Horizontal Form -->
                <div class="col-12">
                    <div class="card card-info card-tabs">
                        <div class="card-header p-0 pt-1">
                            <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="custom-tabs-one-home-tab" data-toggle="pill"
                                       href="#custom-tabs-one-home" role="tab" aria-controls="custom-tabs-one-home"
                                       aria-selected="true">Projeto</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="custom-tabs-one-profile-tab" data-toggle="pill"
                                       href="#custom-tabs-one-profile" role="tab"
                                       aria-controls="custom-tabs-one-profile" aria-selected="false">
                                        <?php
                                        if ($projeto['pessoa_tipo_id'] == 2) {
                                            echo "Empresa";
                                        } else {
                                            echo "Pessoa";
                                        }
                                        ?>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="custom-tabs-one-messages-tab" data-toggle="pill"
                                       href="#custom-tabs-one-messages" role="tab"
                                       aria-controls="custom-tabs-one-messages" aria-selected="false">Anexos</a>
                                </li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <div class="tab-content" id="custom-tabs-one-tabContent">
                                <div class="tab-pane fade show active" id="custom-tabs-one-home" role="tabpanel"
                                     aria-labelledby="custom-tabs-one-home-tab">
                                    <p>
                                        <span class="font-weight-bold">Protocolo: </span> <?= $projeto['protocolo'] ?>
                                        <span class="font-weight-bold ml-5">Data da Inscrição:</span>
                                        <?= $fomentoObj->dataHora($projeto['data_inscricao']) ?>
                                    </p>
                                    <hr/>
                                    <p>
                                        <span class="font-weight-bold">Nome do projeto:</span> <?= $projeto['nome_projeto'] ?>
                                    </p>
                                    <?php if ($projeto['pessoa_tipo_id'] == 2): ?>
                                        <p>
                                            <span class="font-weight-bold">Instituição responsável: </span>
                                            <?= $projeto['instituicao'] ?? null ?>
                                        </p>
                                        <p>
                                            <span class="font-weight-bold">Site: </span><?= $projeto['site'] ?? null?>
                                        </p>
                                    <?php endif; ?>
                                    <p>
                                        <span class="font-weight-bold">Responsável pela inscrição:</span>
                                        <span class="text-left"><?= $projeto['responsavel_inscricao'] ?></span>
                                    </p>

                                    <?php if($tipo_contratacao_id == 24): ?>
                                        <p>
                                            <span class="font-weight-bold">Área de inscrição:</span>
                                            <span class="text-left"><?= $fomentoObj->recuperaDadosEditalPeriferia($projeto['id']) ?></span>
                                        </p>
                                    <?php endif; ?>

                                    <p>
                                        <span class="font-weight-bold">Valor do projeto:</span>
                                        <span id="dinheiro"> <?= $projeto['valor_projeto'] ?></span>
                                        <span class="font-weight-bold ml-5">Duração (em meses):</span>
                                        <span class="text-left"><?= $projeto['duracao'] ?></span>
                                    </p>
                                    <p>
                                        <span class="font-weight-bold">Nome do núcleo artístico/coletivo artístico:</span> <?= $projeto['nome_nucleo'] ?>
                                        <span class="font-weight-bold ml-5">Nome do representante do núcleo:</span>
                                        <?= $projeto['representante_nucleo'] ?>
                                    </p>
                                    <p>
                                        <span class="font-weight-bold">Nome do produtor independente:</span> <?= $projeto['coletivo_produtor'] ?>
                                    </p>
                                    <?php
                                    if ($projeto['nucleo_artistico'] != NULL){
                                        ?>
                                        <p class="flex-wrap text-justify">
                                            <span class="font-weight-bold mr-2">Núcleo artístico:</span>
                                            <?= nl2br($projeto['nucleo_artistico']) ?>
                                        </p>
                                    <?php
                                    }
                                    ?>
                                </div>
                                <?php
                                if ($projeto['pessoa_tipo_id'] == 1):
                                    include "include/detalhes_inscrito_pf.php";
                                else:
                                    include "include/detalhes_inscrito_pj.php";
                                endif;
                                ?>
                                <div class="tab-pane fade" id="custom-tabs-one-messages" role="tabpanel"
                                     aria-labelledby="custom-tabs-one-messages-tab">
                                    <p>
                                        <span class="font-weight-bold">Protocolo: </span> <?= $projeto['protocolo'] ?>
                                        <span class="font-weight-bold ml-5">Data da Inscrição:</span>
                                        <?= $fomentoObj->dataHora($projeto['data_inscricao']) ?>
                                    </p>
                                    <hr/>
                                    <div class="row justify-content-center align-items-center">
                                        <div class="col-8">
                                            <div class="card card-gray">
                                                <div class="card-header  text-center">
                                                    <h3 class="card-title">Lista de arquivos</h3>
                                                </div>
                                                <div class="card-body p-0">
                                                    <table class="table table-bordered">
                                                        <tbody>
                                                        <?php foreach ($arqEnviados as $arquivo) {
                                                            $strArquivos .= "{$arquivo->arquivo}:";
                                                            ?>

                                                            <tr>
                                                                <td class="text-justify">
                                                                    <?= "{$arquivo->anexo} - {$arquivo->documento}" ?>
                                                                </td>
                                                                <td>
                                                                    <a href="<?= "http://{$_SERVER['HTTP_HOST']}/capac/uploads/" . $arquivo->arquivo ?>"
                                                                       target="_blank"
                                                                       class="btn btn-sm bg-purple text-light"><i
                                                                                class="fas fa-file-download"></i> Baixar
                                                                        Arquivo
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                        <?php } ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="card-footer p-0">
                                                    <a href="<?= SERVERURL ?>api/downloadInscritos.php?id=<?= $projeto['id'] ?>" target="_blank" class="btn bg-gradient-purple btn-lg btn-block rounded-bottom"><i class="fas fa-file-archive"></i> Baixar todos os arquivos</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.card -->
                        <div class="card-footer">
                            <button class="btn btn-primary" onclick="window.history.back();">Voltar</button>
                        </div>
                    </div>
                </div>
                <!-- /.card -->
            </div>
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</div>


<script>
    document.querySelector('#aprovar').addEventListener('click', (event) => {
        event.preventDefault();

        Swal.fire({
            title: "Tem Certeza?",
            text: "Você deseja realmente aprovar este projeto?",
            type: "question",
            showCancelButton: true,
            confirmButtonText: "Confirmar",
            cancelButtonText: "Cancelar"
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type: "POST",
                    url: "<?= SERVERURL ?>ajax/fomentoAjax.php",
                    data: {
                        _method: 'aprovar',
                        id: <?= $projeto['id'] ?>,
                        valor_projeto: <?= $projeto['valor_projeto'] ?>,
                        edital_id: <?= $projeto['fom_edital_id'] ?>
                    },
                    success: (data, text) => {
                        if (data) {
                            Swal.fire({
                                title: "Projeto Aprovado!",
                                text: "Projeto aprovado com sucesso!",
                                type: text,
                                button: "Fechar",
                            });
                            colocarStatus('Aprovado');
                        } else {
                            Swal.fire({
                                title: "Não foi possível aprovar!",
                                text: "Não foi possível aprovar o projeto, pois o valor disponível é menor que o valor do projeto.",
                                type: "error",
                                button: "Fechar",
                            });
                        }

                    },
                    error: () => {
                        Swal.fire({
                            title: "Erro!",
                            text: "Ocorreu um erro, por favor tente novamente.",
                            type: "error",
                            button: "Fechar",
                        });
                    }
                })
            }
        })
    });
    document.querySelector('#reprovar').addEventListener('click', (event) => {
        event.preventDefault();

        Swal.fire({
            title: "Tem Certeza?",
            text: "Você deseja realmente aprovar este projeto?",
            type: "question",
            showCancelButton: true,
            confirmButtonText: "Confirmar",
            cancelButtonText: "Cancelar"
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type: "POST",
                    url: "<?= SERVERURL ?>ajax/fomentoAjax.php",
                    data: {
                        _method: 'reprovar',
                        id: <?= $projeto['id'] ?>
                    },
                    success: () => {
                        Swal.fire({
                            title: "Projeto Reprovado!",
                            text: "Projeto reprovado com sucesso!",
                            type: "success",
                            button: "Fechar",
                        });
                        colocarStatus('Reprovado');
                    },
                    error: () => {
                        Swal.fire({
                            title: "Erro!",
                            text: "Ocorreu um erro, por favor tente novamente.",
                            type: "error",
                            button: "Fechar",
                        });
                    }
                })

            }
        });
    });


    function colocarStatus(status) {
        document.querySelector(".btn-group").style.display = "none";
        let h3 = document.createElement('h3');
        h3.textContent = status;
        h3.classList.add('text-right');
        h3.classList.add('mr-3');
        if (status == 'Aprovado') {
            h3.classList.add('text-success');
        } else {
            h3.classList.add('text-danger');
        }
        document.querySelector('.status-projeto').appendChild(h3);
    }
</script>