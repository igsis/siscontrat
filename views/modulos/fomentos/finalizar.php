<?php
//CONFIGS
require_once "./config/configAPP.php";

//CONTROLLERS
require_once "./controllers/ProjetoController.php";
require_once "./controllers/PessoaJuridicaController.php";
require_once "./controllers/RepresentanteController.php";
require_once "./controllers/UsuarioController.php";

$projetoObj = new ProjetoController();
$pjObj = new PessoaJuridicaController();
$repObj = new RepresentanteController();

//Projeto
$idProj = $_SESSION['projeto_s'];
$projeto = $projetoObj->recuperaProjeto($idProj);

//Pessoa Juridica
$pj = $pjObj->recuperaPessoaJuridica(MainModel::encryption($projeto['pessoa_juridica_id']));

//Representante
$repre = $repObj->recuperaRepresentante(MainModel::encryption($pj['representante_legal1_id']))->fetch(PDO::FETCH_ASSOC);

$status = $projetoObj->recuperaStatusProjeto($projeto['fom_status_id']);
if ($projeto['data_inscricao']) {
    $dataEnvio = MainModel::dataHora($projeto['data_inscricao']);
}

$validacaoArquivos = $projetoObj->validaProjeto($idProj, $_SESSION['edital_s']);
?>

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Finalizado Projeto</h1>
            </div><!-- /.col -->
        </div><!-- /.row -->
        <?php
        if ($validacaoArquivos) {
            ?>
            <div class="row erro-validacao">
                <?php foreach ($validacaoArquivos as $titulo => $erros): ?>
                    <div class="col-md-4">
                        <div class="card bg-danger">
                            <div class="card-header">
                                <h3 class="card-title"><i class="fa fa-exclamation mr-3"></i><strong>Erros
                                        em <?= $titulo ?></strong></h3>
                            </div>
                            <div class="card-body">
                                <?php foreach ($erros as $erro): ?>
                                    <li><?= $erro ?></li>
                                <?php endforeach; ?>
                            </div>
                            <!-- /.card-body -->
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <?php
        }
        ?>
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
                        <h3 class="card-title">Dados</h3>
                    </div>
                    <?php if ($projeto['protocolo'] == null || $projeto['data_inscricao'] == null): ?>
                        <div class="row justify-content-center mt-3">
                            <div class="col-md-10">
                                <div class="alert alert-warning alert-dismissible">
                                    <h5><i class="icon fas fa-exclamation-triangle"></i> Atenção!</h5>
                                    <p class="mb-1">Antes de finalizar verifique se todos os dados estão
                                        corretos.</p>
                                    <p>Após verificar clique no botão "Clique aqui para enviar seu projeto"</p>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                    <!-- /.card-header -->
                    <ul id="lista-finalizar-fom">
                        <?= $projeto['protocolo'] ? "<li class=\"my-2\"><span class=\"subtitulos mr-2\">Código de cadastro:</span> {$projeto['protocolo']}</li>" : '' ?>
                        <li class="my-2"><span
                                    class="subtitulos mr-2">Instituição responsável: </span> <?= $projeto['instituicao'] ?>
                        </li>
                        <li class="my-2"><span
                                    class="subtitulos mr-2">Responsável pela inscrição: </span> <?= $_SESSION['nome_s'] ?>
                        </li>
                        <li class="my-2"><span
                                    class="subtitulos mr-2">Razão social: </span><?= $pj['razao_social'] ?>
                            <span class="ml-5 subtitulos mr-2">CNPJ: </span> <?= $pj['cnpj'] ?> </li>
                        <li class="my-2"><span
                                    class="subtitulos mr-2">Representante Legal da empresa: </span> <?= $repre['nome'] ?? '' ?>
                            <span class="ml-5 subtitulos mr-2">RG: </span> <?= $repre['rg'] ?? '' ?> <span
                                    class="ml-5 subtitulos mr-2">CPF: </span> <?= $repre['cpf'] ?? '' ?></li>
                        <li class="my-2"><span class="subtitulos mr-2">E-mail: </span> teste@test.com <span
                                    class="ml-5 subtitulos mr-2">Telefone: </span> (11) 99999-9999
                        </li>
                        <li class="my-2"><span
                                    class="subtitulos mr-2">Endereço: </span> <?= "{$pj['logradouro']}, {$pj['numero']}  {$pj['complemento']} - {$pj['bairro']}, {$pj['cidade']} - {$pj['uf']}, {$pj['cep']}" ?>
                        </li>
                        <li class="my-2"><span class="subtitulos mr-2">Site:</span> <a
                                    href="<?= "http://{$projeto['site']}" ?>"
                                    target="_blank"><?= $projeto['site'] ?></a></li>
                        <li class="my-2"><span class="subtitulos mr-2">Valor do projeto:</span> <span
                                    id="dinheiro"><?= $projeto['valor_projeto'] ?></span></li>
                        <li class="my-2"><span
                                    class="subtitulos mr-2">Duração do projeto em meses: </span> <?= $projeto['duracao'] ?>
                            meses
                        </li>
                        <li class="my-2"><span
                                    class="subtitulos mr-2">Núcleo artístico: </span> <?= $projeto['nucleo_artistico'] ?>
                        </li>
                        <li class="my-2"><span
                                    class="subtitulos mr-2">Representante do núcleo: </span> <?= $projeto['representante_nucleo'] ?>
                        </li>
                        <li class="my-2"><span class="subtitulos mr-2">Status: </span> <?= $status ?> </li>
                        <li class="my-2"><span class="subtitulos mr-2">Edição: </span> Edição</li>
                        <?= $projeto['data_inscricao'] ? "<li class=\"my-2\"><span class=\"subtitulos mr-2\">Data de Envio: </span> {$dataEnvio} </li>" : '' ?>
                    </ul>
                    <?php if ($projeto['protocolo'] == null && $projeto['data_inscricao'] == null): ?>
                        <div class="row justify-content-center mb-4">
                            <form class="formulario-ajax" method="post"
                                  action="<?= SERVERURL ?>ajax/projetoAjax.php"
                                  role="form"
                                  data-form="save">
                                <input type="hidden" name="_method" value="finalizar_fom">
                                <input type="hidden" name="id" value="<?= $projeto['id'] ?>">
                                <input type="hidden">
                                <button type="submit" id="btnEnviar" class="btn btn-success btn-lg">
                                    Clique aqui para enviar seu projeto
                                </button>
                                <div class="resposta-ajax"></div>
                            </form>
                        </div>
                    <?php endif; ?>
                </div>
                <!-- /.card -->
            </div>
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content -->
<script>
    $(document).ready(function () {
        if ($('.erro-validacao').length) {
            $('#btnEnviar').attr('disabled', true);
        } else {
            $('#btnEnviar').attr('disabled', false);
        }
    })
</script>
<script type="application/javascript">
    $(document).ready(function () {
        $('.nav-link').removeClass('active');
        $('#finalizar').addClass('active');
    })
</script>