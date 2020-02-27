<?php

require_once "./controllers/FomentoController.php";
require_once "./controllers/PessoaJuridicaController.php";
require_once "./controllers/RepresentanteController.php";
$id = $_GET['id'];

$fomentoObj = new FomentoController();
$pessoaJuridicaObj = new PessoaJuridicaController();
$repObj = new RepresentanteController();

$projeto = $fomentoObj->recuperaProjeto($id);

$pj = $pessoaJuridicaObj->recuperaPessoaJuridica(MainModel::encryption($projeto['pessoa_juridica_id']), true);

$repre = $repObj->recuperaRepresentante(MainModel::encryption($pj['representante_legal1_id']))->fetch(PDO::FETCH_ASSOC);

?>

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-9">
                <h1 class="m-0 text-dark">Detalhes do Inscrito</h1>
            </div><!-- /.col -->
            <div class="col-sm-3">
                <div class="btn-group">
                    <button type="button" class="btn btn-danger"><i class="fas fa-times"></i> &nbsp;Reprovar</button>
                    <button type="button" class="btn btn-success"><i class="fas fa-check"></i> &nbsp;Aprovar</button>
                </div>
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
                                       aria-controls="custom-tabs-one-profile" aria-selected="false">Empresa</a>
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
                                    </p>
                                    <p>
                                        <span class="font-weight-bold">Instituição responsável: </span>
                                        <span class="text-left"><?= $projeto['instituicao'] ?></span>
                                    </p>
                                    <p>
                                        <span class="font-weight-bold">Responsável pela inscrição:</span>
                                        <span class="text-left"><?= $projeto['responsavel_inscricao'] ?></span>
                                    </p>
                                    <p>
                                        <span class="font-weight-bold">Valor do projeto:</span>
                                        <span id="dinheiro"> <?= $projeto['valor_projeto'] ?></span>
                                        <span class="font-weight-bold ml-5">Duração: (em meses):</span>
                                        <span class="text-left"><?= $projeto['duracao'] ?></span>
                                    </p>
                                    <p class="flex-wrap text-justify">
                                        <span class="font-weight-bold mr-2">Núcleo artístico:</span>
                                        <?= $projeto['nucleo_artistico'] ?>
                                    </p>
                                    <p>
                                        <span class="font-weight-bold">Representante do núcleo:</span>
                                        <?= $projeto['representante_nucleo'] ?>
                                    </p>
                                    <p>
                                        <span class="font-weight-bold">Data da Inscrição: </span>
                                        <?= $fomentoObj->dataHora($projeto['data_inscricao']) ?>
                                    </p>
                                </div>
                                <div class="tab-pane fade" id="custom-tabs-one-profile" role="tabpanel"
                                     aria-labelledby="custom-tabs-one-profile-tab">
                                    <p>
                                        <span class="font-weight-bold">Razão Social:</span>
                                        <span class="text-left"><?= $pj['razao_social'] ?></span>
                                        <span class="font-weight-bold ml-5">CNPJ:</span>
                                        <span class="text-left"> <?= $pj['cnpj'] ?></span>
                                    </p>
                                    <p>
                                        <span class="font-weight-bold">E-mail:</span>
                                        <span class="text-left"> <?= $pj['email'] ?></span>
                                    </p>
                                    <p>
                                        <span class="font-weight-bold">Telefone #1:</span> <?= $pj['telefones']['tel_0'] ?>
                                        <?php if (isset($pj['telefones']['tel_1'])): ?>
                                        <span class="font-weight-bold ml-5">Telefone #2:</span> <?= $pj['telefones']['tel_1'] ?>
                                        <?php endif;
                                        if (isset($pj['telefones']['tel_2'])): ?>
                                        <span class="font-weight-bold ml-5">Telefone #3:</span> <?= $pj['telefones']['tel_2'] ?>
                                        <?php  endif; ?>
                                    </p>
                                    <p>
                                        <span class="font-weight-bold mr-2"> Endereço: </span> <?= "{$pj['logradouro']}, {$pj['numero']}  {$pj['complemento']} - {$pj['bairro']}, {$pj['cidade']} - {$pj['uf']}, {$pj['cep']}" ?>
                                    </p>
                                    <p>
                                        <span class="font-weight-bold">Representante: </span> <?= $repre['nome'] ?>
                                        <span class="text-left ml-5 font-weight-bold">CPF: </span> <?= $repre['cpf'] ?>
                                        <span class="ml-5 font-weight-bold">RG: </span> <?= $repre['rg'] ?>
                                    </p>
                                </div>
                                <div class="tab-pane fade" id="custom-tabs-one-messages" role="tabpanel"
                                     aria-labelledby="custom-tabs-one-messages-tab">
                                    <div class="row justify-content-center align-items-center">
                                        <div class="col-6">
                                            <div class="card card-gray">
                                                <div class="card-header  text-center">
                                                    <h3 class="card-title">Lista de arquivos</h3>
                                                </div>
                                                <div class="card-body p-0">
                                                    <table class="table table-bordered">
                                                        <tbody>
                                                        <tr>
                                                            <td class="text-justify text-center">
                                                                Anexo 0 - Projeto
                                                            </td>
                                                            <td>
                                                                <button class="btn btn-sm bg-purple text-light"><i
                                                                            class="fas fa-file-download"></i> Baixar
                                                                    Arquivo
                                                                </button>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="text-justify text-center">
                                                                Anexo I - Requerimento de Inscrição
                                                            </td>
                                                            <td>
                                                                <button class="btn btn-sm bg-purple text-light"><i
                                                                            class="fas fa-file-download"></i> Baixar
                                                                    Arquivo
                                                                </button>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="text-justify text-center">
                                                                Anexo II - Declaração de Proponente Pessoa Jurídica
                                                            </td>
                                                            <td>
                                                                <button class="btn btn-sm bg-purple text-light"><i
                                                                            class="fas fa-file-download"></i> Baixar
                                                                    Arquivo
                                                                </button>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="text-justify text-center">
                                                                Anexo III - Declaração da Não Ocorrência de Impedimentos
                                                            </td>
                                                            <td>
                                                                <button class="btn btn-sm bg-purple text-light"><i
                                                                            class="fas fa-file-download"></i> Baixar
                                                                    Arquivo
                                                                </button>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="text-justify text-center">
                                                                Anexo IV - Declaração
                                                            </td>
                                                            <td>
                                                                <button class="btn btn-sm bg-purple text-light"><i
                                                                            class="fas fa-file-download"></i> Baixar
                                                                    Arquivo
                                                                </button>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="text-justify text-center">
                                                                Anexo V - Declaração do Núcleo Artístico
                                                            </td>
                                                            <td>
                                                                <button class="btn btn-sm bg-purple text-light"><i
                                                                            class="fas fa-file-download"></i> Baixar
                                                                    Arquivo
                                                                </button>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="text-justify text-center">
                                                                Anexo VI - Declaração dos Artistas Relevantes para a
                                                                Realização
                                                                do Projeto
                                                            </td>
                                                            <td>
                                                                <button class="btn btn-sm bg-purple text-light"><i
                                                                            class="fas fa-file-download"></i> Baixar
                                                                    Arquivo
                                                                </button>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="text-justify text-center">
                                                                Anexo VII - Declaração de Proponente Pessoa Jurídica
                                                            </td>
                                                            <td>
                                                                <button class="btn btn-sm bg-purple text-light"><i
                                                                            class="fas fa-file-download"></i> Baixar
                                                                    Arquivo
                                                                </button>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="text-justify text-center">
                                                                Anexo VIII - Declaração Sobre Trabalho de Menores
                                                            </td>
                                                            <td>
                                                                <button class="btn btn-sm bg-purple text-light"><i
                                                                            class="fas fa-file-download"></i> Baixar
                                                                    Arquivo
                                                                </button>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="text-justify text-center">
                                                                Anexo IX - Portifólio / Clipping
                                                            </td>
                                                            <td>
                                                                <button class="btn btn-sm bg-purple text-light"><i
                                                                            class="fas fa-file-download"></i> Baixar
                                                                    Arquivo
                                                                </button>
                                                            </td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="card-footer p-0">
                                                    <button class="btn bg-gradient-purple btn-lg btn-block"><i
                                                                class="fas fa-file-archive"></i> Baixar todos os
                                                        arquivos
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.card -->
                    </div>
                </div>
                <!-- /.card -->
            </div>
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<table class="table">

</table>