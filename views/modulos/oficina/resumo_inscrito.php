<?php

require_once "./controllers/OficinaController.php";

$oficinaObj = new OficinaController();

$id = $_GET['id'];


$oficina = $oficinaObj->recuperaOficinaCapac($id);

$publicos = $oficinaObj->recuperaPublico($id);

$count = 0;

?>
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Resumo oficina CAPAC</h1>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col">
                <div class="text-center">
                    <span class="font-weight-bold">Cadastrado enviado em:</span> <?= date("d/m/Y h:i", strtotime($oficina->data_envio)) ?>
                </div>
            </div>
        </div>
        <!-- /.row -->
        <div class="row">
            <div class="col-md-12">
                <!-- Horizontal Form -->
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">Dados oficina</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <span class="font-weight-bold">Protocolo: </span> <?= $oficina->protocolo ?>
                            </div>
                            <div class="col">
                                <span class="font-weight-bold">Nome do Evento: </span> <?= $oficina->nome_evento ?>
                            </div>
                            <div class="col">
                                <span class="font-weight-bold">Espaço Público: </span> <?= $oficina->espaco_publico ? 'Sim' : 'Não' ?>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col">
                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th colspan="2">
                                            Público (Representatividade e Visibilidade Sócio-cultural)
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach ($publicos as $publico) {
                                        ?>
                                        <tr>
                                            <td><?= $publico->publico ?></td>
                                            <td><?= $publico->descricao ?></td>
                                        </tr>
                                        <?php
                                    } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col">
                                <span class="font-weight-bold">Linguagem: </span> <?= $oficina->linguagem ?>
                            </div>
                            <div class="col">
                                <span class="font-weight-bold">Sub-linguagem: </span> <?= $oficina->sublinguagem ?>
                            </div>
                            <div class="col">
                                <span class="font-weight-bold">Nível: </span> <?= $oficina->nivel ?>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col">
                                <span class="font-weight-bold">Sinopse: </span> <?= $oficina->sinopse ?>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col">
                                <span class="font-weight-bold">Tipo Contratação: </span> <?= $oficina->tipo_contratacao ?>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col">
                                <span class="font-weight-bold">Integrantes: </span> <?= $oficina->integrantes ?>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col">
                                <span class="font-weight-bold">Links: </span> <?= $oficina->links ?>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col">
                                <span class="font-weight-bold">Data de Cadastro: </span> <?= date("d/m/Y", strtotime($oficina->data_cadastro)) ?>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col">
                                <span class="font-weight-bold">Data Inicio: </span> <?= date("d/m/Y", strtotime($oficina->data_inicio)) ?>
                                &nbsp; &nbsp; &nbsp; &nbsp;
                                <span class="font-weight-bold">Data Fim: </span> <?= date("d/m/Y", strtotime($oficina->data_fim)) ?>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col">
                                <span class="font-weight-bold">Dia execução 1: </span> <?= $oficinaObj->exibeExecucaoDia($oficina->execucao_dia1_id) ?>
                                &nbsp; &nbsp; &nbsp; &nbsp;
                                <span class="font-weight-bold">Dia execução 2: </span> <?= $oficinaObj->exibeExecucaoDia($oficina->execucao_dia2_id) ?>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col">
                                <span class="font-weight-bold">Modalidade: </span> <?= $oficina->modalidade ?>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card -->
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">Dados do Proponente</h3>
                    </div>
                    <div class="card-body">
                        <?php if ($oficina->pessoa_tipo_id == 1):
                                $pf = $oficinaObj->recuperaPfCapac($oficina->pessoa_fisica_id);
                            ?>

                            <div class="row">
                                <div class="col">
                                    <span class="font-weight-bold">Nome: </span> <?= $pf['nome'] ?>
                                </div>
                                <div class="col">
                                    <span class="font-weight-bold">Nome Artístico: </span> <?= $pf['nome_artistico'] ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <span class="font-weight-bold">Etnia: </span> <?= $pf['descricao'] ?>
                                </div>
                                <div class="col">
                                    <span class="font-weight-bold">Gênero: </span> <?= $pf['genero'] ?>
                                </div>
                                <div class="col">
                                    <span class="font-weight-bold">Grau de Instrução: </span> <?= $pf['grau_instrucao'] ?>
                                </div>
                                <div class="col">
                                    <span class="font-weight-bold">Trans: </span> <?= $pf['trans'] ? 'Sim' : 'Não' ?>
                                </div>
                                <div class="col">
                                    <span class="font-weight-bold">PCD: </span> <?= $pf['pcd'] ? 'Sim' : 'Não' ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <span class="font-weight-bold">Data de nascimento: </span> <?= date('d/m/Y', strtotime($pf['data_nascimento'])) ?>
                                </div>
                                <div class="col">
                                    <span class="font-weight-bold">Nacionalidade: </span> <?= $pf['nacionalidade'] ?>
                                </div>
                            </div>
                            <div class="row">
                                <?php if ($pf['rg'] != ''): ?>
                                    <div class="col">
                                        <span class="font-weight-bold">RG: </span> <?= $pf['rg'] ?>
                                    </div>
                                <?php else: ?>
                                    <div class="col">
                                        <span class="font-weight-bold">Passaporte: </span> <?= $pf['passaporte'] ?>
                                    </div>
                                <?php endif; ?>
                                <div class="col">
                                    <span class="font-weight-bold">CPF: </span> <?= $pf['cpf'] ?>
                                </div>
                                <div class="col">
                                    <span class="font-weight-bold">CCM: </span> <?= $pf['ccm'] ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <span class="font-weight-bold">E-mail: </span> <?= $pf['email'] ?>
                                </div>
                            </div>
                            <div class="row">
                                <?php foreach ($pf['telefones'] as $telefone) {
                                    ?>
                                    <div class="col">
                                        <span class="font-weight-bold">Telefones#<?= ++$count ?>:</span> <?= $telefone ?>
                                    </div>
                                <?php } ?>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <span class="font-weight-bold">NIT: </span> <?= $pf['nit'] ?>
                                </div>
                                <div class="col">
                                    <span class="font-weight-bold">DRT: </span><?= $pf['drt'] ?>
                                </div>
                            </div>
                        <?php elseif ($oficina->pessoa_tipo_id == 2): ?>
                            <div class="row">

                            </div>
                        <?php endif; ?>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <a href="<?= SERVERURL ?>formacao/listar_inscritos"
                           class="btn btn-default float-left">Voltar</a>
                        <form class="formulario-ajax" action="<?= SERVERURL ?>ajax/formacaoAjax.php" method="POST">
                            <input type="hidden" name="_method" value="importarInscrito">
                            <input type="hidden" name="id" value="<?= $oficinaObj->encryption($oficina->id) ?>">
                            <button class="btn btn-info float-right" id="importar">Importar Inscrito</button>
                            <div class="resposta-ajax"></div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.row -->

        <!-- /.row -->

    </div><!-- /.container-fluid -->
</div>
<!-- /.content -->