<?php
require_once "./controllers/FormacaoContratacaoController.php";
require_once "./controllers/FormacaoPedidoController.php";
require_once "./controllers/ArquivoController.php";

$id = isset($_GET['id']) ? $_GET['id'] : null;
$capacId = isset($_GET['capac']) ? $_GET['capac'] : null;
$contratacaoObj = new FormacaoContratacaoController();
$pfObj =  new PessoaFisicaController();

if($id){
    $dados_contratacao = $contratacaoObj->recuperar($id);
}
elseif($capacId){
    $arquivosObj =  new ArquivoController();
    $dados_contratacao = $contratacaoObj->recuperarCapac($capacId);
    $arquivos = $arquivosObj->listarArquivosCapac($capacId)->fetchAll(PDO::FETCH_OBJ);
    $idPf = $pfObj->recuperaIdPfSis($dados_contratacao->pessoa_fisica_id);
}

//caso haja um cadastro, torna a checkbox do proponente inalterável
$id != "" ? $readonly = "tabindex='-1' aria-disabled='true' style='background: #eee; pointer-events: none; touch-action: none;'" : $readonly = "";
$capacId != "" ? $readonly = "tabindex='-1' aria-disabled='true' style='background: #eee; pointer-events: none; touch-action: none;'" : $readonly = "";
?>

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Dados para contratação</h1>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">Dados</h3>
                    </div>

                    <div class="card-body">
                        <form class="form-horizontal formulario-ajax" action="<?= SERVERURL ?>ajax/formacaoAjax.php"
                              method="POST" role="form" data-form="<?= ($id) ? "update" : "save" ?>">
                            <input type="hidden" name="_method"
                                   value="<?= ($id) ? "editarDadosContratacao" : "cadastrarDadosContratacao" ?>">
                            <input type="hidden" name="usuario_id"
                                   value="<?= isset($_SESSION['usuario_id_s']) ? $_SESSION['usuario_id_s'] : "" ?>">
                            <?php if ($id): ?>
                                <input type="hidden" name="id" value="<?= $id ?>">
                            <?php endif; ?>
                            <div class="row">
                                <div class="col-md">
                                    <label for="pessoa_fisica_id">Proponente: *</label>
                                    <select name="pessoa_fisica_id" required
                                            class="form-control select2bs4" <?= $readonly ?>>
                                        <option value="">Selecione um proponente...</option>
                                        <?php
                                        if ($capacId){
                                            $contratacaoObj->geraOpcao('pessoa_fisicas', $idPf ?? "");
                                        } else {
                                            $pfObj->geraOpcaoPf($dados_contratacao->pessoa_fisica_id ?? "");
                                        }
                                        ?>
                                    </select>
                                    <?php if ($id): ?>
                                        <br>
                                        <a href="<?= SERVERURL ?>formacao/pf_cadastro&id=<?= $contratacaoObj->encryption($dados_contratacao->pessoa_fisica_id) ?>"
                                           target="_blank">
                                            <button type="button" class="btn btn-primary float-right">Abrir Proponente
                                            </button>
                                        </a>
                                    <?php endif; ?>

                                    <?php if ($capacId): ?>
                                        <br>
                                        <a href="<?= SERVERURL ?>formacao/pf_cadastro&id=<?= $contratacaoObj->encryption($idPf) ?>"
                                           target="_blank">
                                            <button type="button" class="btn btn-primary float-right">Abrir Proponente
                                            </button>
                                        </a>
                                        <input type="hidden" name="protocolo" value="<?= $dados_contratacao->protocolo?>">
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="form-group col-md">
                                    <label for="ano">Ano: *</label>
                                    <input type="number" min="2018" id="ano" name="ano"
                                           value="<?= $dados_contratacao->ano ?? "" ?>" required class="form-control">
                                </div>

                                <div class="form-group col-md">
                                    <label for="chamado">Chamado: *</label>
                                    <input type="number" min="0" max="127" name="chamado"
                                           value="<?= $dados_contratacao->chamado ?? "" ?>" required
                                           class="form-control">
                                </div>

                                <div class="form-group col-md">
                                    <label for="classificacao">Classificação: *</label>
                                    <input type="number" min="0" name="classificacao"
                                           value="<?= $dados_contratacao->classificacao ?? "" ?>" required
                                           class="form-control">
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="form-group col-md">
                                    <label for="territorio_id">Território: *</label>
                                    <select name="territorio_id" required class="form-control select2bs4">
                                        <option value="">Selecione um território...</option>
                                        <?php $contratacaoObj->geraOpcao('territorios', $dados_contratacao->territorio_id ?? "", '1') ?>
                                    </select>
                                </div>

                                <div class="form-group col-md">
                                    <label for="coordenadoria_id">Coordenadoria: *</label>
                                    <select name="coordenadoria_id" required class="form-control select2bs4">
                                        <option value="">Selecione uma coordenadoria...</option>
                                        <?php $contratacaoObj->geraOpcao('coordenadorias', $dados_contratacao->coordenadoria_id ?? "", '1') ?>
                                    </select>
                                </div>

                                <div class="form-group col-md">
                                    <label for="subprefeitura_id">Subprefeitura: *</label>
                                    <select name="subprefeitura_id" required class="form-control select2bs4">
                                        <option value="">Selecione uma subprefeitura...</option>
                                        <?php $contratacaoObj->geraOpcao('subprefeituras', $dados_contratacao->subprefeitura_id ?? "", '1') ?>
                                    </select>
                                </div>

                                <div class="form-group col-md">
                                    <label for="projeto_id">Projeto: *</label>
                                    <select name="projeto_id" required class="form-control select2bs4">
                                        <option value="">Selecione um projeto...</option>
                                        <?php $contratacaoObj->geraOpcao('projetos', $dados_contratacao->projeto_id ?? "", '1') ?>
                                    </select>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="form-group col-md">
                                    <label for="linguagem_id">Linguagem: *</label>
                                    <select name="linguagem_id" required class="form-control select2bs4">
                                        <option value="">Selecione uma linguagem...</option>
                                        <?php $contratacaoObj->geraOpcao('linguagens', $dados_contratacao->linguagem_id ?? "", '1') ?>
                                    </select>
                                </div>

                                <div class="form-group col-md">
                                    <label for="programa_id">Programa: *</label>
                                    <select name="programa_id" id="programa" required class="form-control select2bs4"
                                            onchange="getCargos()">
                                        <option value="">Selecione um programa...</option>
                                        <?php $contratacaoObj->geraOpcao('programas', $dados_contratacao->programa_id ?? "", '1') ?>
                                    </select>
                                </div>

                                <div class="form-group col-md">
                                    <label for="form_cargo_id">Cargo: *</label>
                                    <select name="form_cargo_id" id="cargo" required class="form-control select2bs4">
                                        <option value="">Selecione um cargo...</option>
                                        <?php $contratacaoObj->geraOpcao('formacao_cargos', $dados_contratacao->form_cargo_id ?? "", '1') ?>
                                    </select>
                                </div>

                                <div class="form-group col-md">
                                    <label for="programa_id">Vigencia: *</label>
                                    <select name="form_vigencia_id" required class="form-control select2bs4">
                                        <option value="">Selecione uma vigencia...</option>
                                        <?php $contratacaoObj->geraOpcaoVigencia('formacao_vigencias', $dados_contratacao->form_vigencia_id ?? "") ?>
                                    </select>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="form-group col-md">
                                    <label for="regiao_preferencia_id">Região Preferencial: *</label>
                                    <select name="regiao_preferencia_id" required class="form-control select2bs4">
                                        <option value="">Selecione uma região...</option>
                                        <?php $contratacaoObj->geraOpcao('regiao_preferencias', $dados_contratacao->regiao_preferencia_id ?? "") ?>
                                    </select>
                                </div>
                                <?php if ($id != ""): ?>
                                    <div class="form-group col-md">
                                        <label for="form_status_id">Status: *</label>
                                        <select name="form_status_id" required class="form-control select2bs4">
                                            <option value="">Selecione um status...</option>
                                            <?php $contratacaoObj->geraOpcao('formacao_status', $dados_contratacao->form_status_id ?? "") ?>
                                        </select>
                                    </div>
                                <?php else: ?>
                                    <input type="hidden" name="form_status_id" value="1">
                                <?php endif; ?>
                            </div>

                            <!-- gera 3 campos de instituições para 3 campos de locais, populando os mesmos com javascript caso necessário -->
                            <?php for ($i = 0; $i < 3; $i++) : ?>
                                <div class="row mt-3">
                                    <div class="form-group col-md">
                                        <label>Instituição #<?= $i + 1 ?>
                                            : <?= $i == 0 ? " *" : "" ?></label>
                                        <select class="form-control select2bs4" <?= $i == 0 ? "required" : "" ?>
                                                id="instituicao<?= $i ?>" onchange="popularLocal<?= $i + 1 ?>(<?= $i ?>)">
                                            <option value="0">Selecione uma opção...</option>
                                            <?php $contratacaoObj->geraOpcao('instituicoes') ?>
                                        </select>
                                    </div>

                                    <?php if ($id != ""):
                                        $local = (new FormacaoController)->retornaLocaisFormacao($id, '1', '1')[$i]['id'] ?? "";
                                    else:
                                        $local = "";
                                    endif; ?>
                                    <div class="form-group col-md">
                                        <label for="local_id[]">Local #<?= $i + 1 ?>
                                            : <?= $i == 0 ? " *" : "" ?></label>
                                        <select name="local_id[]" class="form-control select2bs4"
                                                onchange="bloqueandoLocais()"
                                                id="local<?= $i + 1 ?>" <?= $i == 0 ? "required" : "" ?>>
                                            <?php isset($local) && $local != "" ? $contratacaoObj->geraOpcao('locais', $local) : "" ?>
                                        </select>
                                    </div>
                                </div>
                            <?php endfor; ?>

                            <div class="row" id="msgEsconde" style="display: none;">
                                <div class="col-md">
                                    <span style="color: red;"><b>Selecione locais diferentes!</b></span>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md">
                                    <label for="observacao">Observação:</label>
                                    <textarea name="observacao" rows="3"
                                              class="form-control"><?= isset($pedido->observacao) ? $pedido->observacao : "" ?></textarea>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="form-group col-md">
                                    <label for="fiscal_id">Fiscal: *</label>
                                    <select name="fiscal_id" required class="form-control select2bs4">
                                        <option value="">Selecione um fiscal...</option>
                                        <?php $contratacaoObj->geraOpcaoUsuario($dados_contratacao->fiscal_id ?? "17", '') ?>
                                    </select>
                                </div>

                                <div class="form-group col-md">
                                    <label for="suplente_id">Suplente:</label>
                                    <select name="suplente_id" class="form-control select2bs4">
                                        <option value="">Selecione um suplente...</option>
                                        <?php $contratacaoObj->geraOpcaoUsuario($dados_contratacao->suplente_id ?? "6", '') ?>
                                    </select>
                                </div>
                            </div>

                            <div class="resposta-ajax"></div>
                            <!-- caso tenha exista o id da contratação e não haja pedido publicado com este id é exibido o botão para gerar um pedido-->
                            <?php if ($id && !(new FormacaoPedidoController)->recuperar($id)): ?>
                                <div class="row">
                                    <div class="col-md">
                                        <a href="<?= SERVERURL . "formacao/anexos&id=" . $contratacaoObj->encryption($dados_contratacao->id) ?>"
                                           class="btn btn-warning  float-right">
                                            Anexos para contratação
                                        </a>
                                    </div>
                                </div>

                                <div class="col" style="text-align: center;">
                                    <hr>
                                    <a href="<?= SERVERURL . "formacao/pedido_contratacao_cadastro&contratacao_id=" . $contratacaoObj->encryption($dados_contratacao->id) ?>"
                                       class="btn btn-success">
                                        Gerar pedido de contratação
                                    </a>
                                </div>
                            <?php endif; ?>
                    </div>

                    <?php if ($capacId && $arquivos): ?>
                        <div class="row" >
                            <div class="col-md-9" style="float:none;margin:auto;">
                                <div class="card card-warning">
                                    <div class="card-header">
                                        <h3 class="card-title">Anexos CAPAC</h3>
                                        <div class="card-tools">
                                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                                        class="fas fa-minus"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="row mt-2 mb-3">
                                            <div class="col-12">
                                                <small> <strong>Atenção: a opção de recuperar arquivos presentes no CAPAC só estará disponível antes da importação ser concluída. </strong> </small>
                                            </div>
                                        </div>

                                        <?php foreach ($arquivos as $arquivo): ?>
                                            <li class="list-group-item d-flex justify-content-between">
                                                <div>
                                                  <?= $arquivosObj->getDocumento($arquivo->form_lista_documento_id) ?>
                                                </div>
                                                <div>
                                                    <a href="<?= CAPACURL ?>/uploads/<?= $arquivo->arquivo ?>"
                                                       class="btn btn-sm btn-primary">
                                                        Baixar
                                                    </a>
                                                </div>
                                            </li>
                                        <?php endforeach; ?>

                                        <li class="list-group-item">
                                            <a href="<?= SERVERURL ?>api/downloadCapac.php?id=<?= $dados_contratacao->id ?>&formacao=1"
                                               target="_blank"
                                               class="btn bg-gradient-purple btn-lg btn-block rounded-bottom"><i
                                                        class="fas fa-file-archive"></i> Baixar todos os arquivos</a>
                                        </li>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                    <div class="card-footer">
                        <a href="<?= SERVERURL ?>formacao/dados_contratacao_lista">
                            <button type="button" class="btn btn-default pull-left">Voltar</button>
                        </a>
                        <button type="submit" name="cadastra" id="cadastra" class="btn btn-primary float-right">
                            Gravar
                        </button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script defer>
    const url = "<?= SERVERURL ?>api/locais_espacos.php/";
    const urlCargoPrograma = "<?= SERVERURL ?>api/lista_cargo_programas.php";
    
    let instituicao1 = document.querySelector('#instituicao1');
    let instituicao2 = document.querySelector('#instituicao2');
    let instituicao3 = document.querySelector('#instituicao3');

    function getCargos() {
        let idPrograma = $('#programa').select2('val');
        fetch(`${urlCargoPrograma}?id=${idPrograma}&select=1`)
            .then(response => response.json())
            .then(cargos => {
                $('#cargo option').remove();
                $('#cargo').append('<option value="">Selecione um cargo...</option>');
                for (const cargo of cargos) {
                    $('#cargo').append(`<option value='${cargo.id}'>${cargo.cargo}</option>`).focus();
                }
            })
    }

    function popularLocal1(id) {
        let instituicao = `#instituicao${id}`;
        let idInstituicao = $(instituicao).select2('val');
        fetch(`${url}?instituicao_id=${idInstituicao}`)
            .then(response => response.json())
            .then(locais => {
                $('#local1 option').remove();
                $('#local1').append(`<option value="">Selecione uma opção...</option>`);
                for (const local of locais) {
                    $('#local1').append(`<option value='${local.id}'>${local.local}</option>`).focus();
                }

                if (idInstituicao == 1) {
                    let locais = document.querySelector('#local1');
                    locais.value = 2;
                    $('#local1').attr('readonly', true);
                    $('#local1').on('mousedown', function (e) {
                        e.preventDefault();
                    });
                } else {
                    $('#local1').unbind('mousedown');
                    $('#local1').removeAttr('readonly');
                }
            })
    }

    function popularLocal2(id) {
        let instituicao = `#instituicao${id}`;
        let idInstituicao = $(instituicao).select2('val');
        fetch(`${url}?instituicao_id=${idInstituicao}`)
            .then(response => response.json())
            .then(locais => {
                $('#local2 option').remove();
                $('#local2').append(`<option value="">Selecione uma opção...</option>`);
                for (const local of locais) {
                    $('#local2').append(`<option value='${local.id}'>${local.local}</option>`).focus();
                }

                if (idInstituicao == 1) {
                    let locais = document.querySelector('#local2');
                    locais.value = 2;
                    $('#local2').attr('readonly', true);
                    $('#local2').on('mousedown', function (e) {
                        e.preventDefault();
                    });
                } else {
                    $('#local2').unbind('mousedown');
                    $('#local2').removeAttr('readonly');
                }
            })
    }

    function popularLocal3(id) {
        let instituicao = `#instituicao${id}`;
        let idInstituicao = $(instituicao).select2('val');
        fetch(`${url}?instituicao_id=${idInstituicao}`)
            .then(response => response.json())
            .then(locais => {
                $('#local3 option').remove();
                $('#local3').append(`<option value="">Selecione uma opção...</option>`);
                for (const local of locais) {
                    $('#local3').append(`<option value='${local.id}'>${local.local}</option>`).focus();
                }

                if (idInstituicao == 1) {
                    let locais = document.querySelector('#local3');
                    locais.value = 2;
                    $('#local3').attr('readonly', true);
                    $('#local3').on('mousedown', function (e) {
                        e.preventDefault();
                    });
                } else {
                    $('#local3').unbind('mousedown');
                    $('#local3').removeAttr('readonly');
                }
            })
    }

    /*instituicao2.addEventListener('change', async e => {
        let idInstituicao = $('#instituicao2 option:checked').val();
        fetch(`${url}?instituicao_id=${idInstituicao}`)
            .then(response => response.json())
            .then(locais => {
                $('#local2 option').remove();
                $('#local2').append('<option value="">Selecione uma opção...</option>');

                for (const local of locais) {
                    $('#local2').append(`<option value='${local.id}'>${local.local}</option>`).focus();

                }

                if (idInstituicao == 1) {
                    let locais = document.querySelector('#local2');
                    locais.value = 2;
                    $('#local2').attr('readonly', true);
                    $('#local2').on('mousedown', function (e) {
                        e.preventDefault();
                    });
                } else {
                    $('#local2').unbind('mousedown');
                    $('#local2').removeAttr('readonly');
                }
            })
    });

    instituicao3.addEventListener('change', async e => {
        let idInstituicao = $('#instituicao3 option:checked').val();
        fetch(`${url}?instituicao_id=${idInstituicao}`)
            .then(response => response.json())
            .then(locais => {
                $('#local3 option').remove();
                $('#local3').append('<option value="">Selecione uma opção...</option>');

                for (const local of locais) {
                    $('#local3').append(`<option value='${local.id}'>${local.local}</option>`).focus();

                }

                if (idInstituicao == 1) {
                    let locais = document.querySelector('#local3');
                    locais.value = 2;
                    $('#local3').attr('readonly', true);
                    $('#local3').on('mousedown', function (e) {
                        e.preventDefault();
                    });
                } else {
                    $('#local3').unbind('mousedown');
                    $('#local3').removeAttr('readonly');
                }
            })
    });*/

    function bloqueandoLocais() {
        let local1 = $('#local1 option:selected').text()
        let local2 = $('#local2 option:selected').text()
        let local3 = $('#local3 option:selected').text()
        var isMsg = $('#msgEsconde');
        isMsg.hide();
        let count = false;

        if (local1 == local2)
            count = true;

        if (local1 == local3)
            count = true;

        if (local2 == local3 && local2 != '' && local3 != '')
            count = true;

        if (count == true) {
            isMsg.show();
            $('#cadastra').attr('disabled', true);
        } else {
            isMsg.hide();
            $('#cadastra').attr('disabled', false);
        }
    }

    $(document).ready(bloqueandoLocais());

    /*let ano = $('#ano');
    let vigencia = $('#form_vigencia_id');
    let botao = $('#cadastra');
    var isMsgAno = $('#msgEscondeAno');
    isMsgAno.hide();

    function maior() {
        let valorVigencia = $('#form_vigencia_id option:selected').text();
        valorVigencia = parseInt(valorVigencia.substring(0, 80))
        if (ano.val() > valorVigencia) {
            botao.prop('disabled', true);
            isMsgAno.show();
        } else {
            botao.prop('disabled', false);
            isMsgAno.hide();
        }
    }

    ano.on('change', maior);
    vigencia.on('change', maior);

    $(document).ready(maior);*/
</script>
