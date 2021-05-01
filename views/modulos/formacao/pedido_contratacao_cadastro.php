<?php
$pedido_id = isset($_GET['pedido_id']) ? $_GET['pedido_id'] : "";
require_once "./controllers/FormacaoPedidoController.php";
require_once "./controllers/FormacaoContratacaoController.php";
require_once "./controllers/FormacaoController.php";

$pedidoObj = new FormacaoPedidoController();
$contratacaoObj =  new FormacaoContratacaoController();
$pfObj =  new PessoaFisicaController();

if ($pedido_id != ''):
    $pedido = $pedidoObj->recuperar($pedido_id);
    $contratacao_id = $pedido->origem_id;
    $contratacao = $contratacaoObj->recuperar($contratacao_id);
else:
    $contratacao_id = isset($_GET['contratacao_id']) ? $_GET['contratacao_id'] : "";
    $contratacao = $contratacaoObj->recuperar($contratacao_id);
endif;

?>
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-9">
                <h1 class="m-0 text-dark">Pedido de Contratação</h1>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="card card-info">
                <div class="card-header">
                    <h4 class="card-title">Cadastro de Pedido de Contratação</h4>
                </div>

                <form class="form-horizontal formulario-ajax" method="POST"
                      action="<?= SERVERURL ?>ajax/formacaoAjax.php" role="form"
                      data-form="<?= ($pedido_id) ? "update" : "save" ?>">
                    <input type="hidden" name="_method" value="<?= ($pedido_id) ? "editarPedido" : "cadastrarPedido" ?>">
                    <?php if ($pedido_id): ?>
                        <input type="hidden" name="id" value="<?= $pedido_id ?>">
                    <?php endif; ?>
                    <div class="card-body">

                        <div class="row">
                            <div class="form-group col-md">
                                <label for="origem_id">Código de Dados para Contratação:</label>
                                <input type="text" name="origem_id" class="form-control" readonly
                                       value="<?= $contratacao->formacao_contratacao_id ?>">
                            </div>

                            <div class="form-group col-md">
                                <label for="pessoa_fisica_id">Proponente:</label>
                                <select name="pessoa_fisica_id" id="pf_id" tabindex="-1" aria-disabled="true"
                                        style="background: #eee; pointer-events: none; touch-action: none;"
                                        class="form-control">
                                    <option value="">Selecione uma opção...</option>
                                    <?php $pfObj->geraOpcaoPf($contratacao->pessoa_fisica_id ?? "") ?>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md">
                                <label for="objeto">Objeto:</label>
                                <textarea name="objeto" class="form-control" rows="3"
                                          disabled><?= (new FormacaoController)->retornarObjeto($contratacao_id) ?>
                                </textarea>
                            </div>

                            <div class="form-group col-md">
                                <label for="local">Local(ais): </label>
                                <textarea name="local" class="form-control" rows="3"
                                          disabled><?= (new FormacaoController)->retornaLocaisFormacao($contratacao_id, '') ?>
                                </textarea>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md">
                                <label for="periodo">Período:</label>
                                <input type="text" name="periodo" class="form-control" disabled
                                       value="<?= (new FormacaoController)->retornaPeriodoFormacao($contratacao_id) ?>">
                            </div>

                            <div class="form-group col-md">
                                <label for="cargaHoraria">Carga Horária:</label>
                                <input type="text" name="cargaHoraria" class="form-control" disabled
                                       value="<?= (new FormacaoController)->retornaCargaHoraria($contratacao_id)  ?>">
                            </div>

                            <div class="form-group col-md">
                                <label for="valor_total">Valor: (R$)</label>
                                <input type="text" name="valor_total" class="form-control" readonly
                                       value="<?= $pedidoObj->dinheiroParaBr($pedido->valor_total) ?>">
                            </div>

                            <div class="form-group col-md">
                                <label for="verba">Verba:</label>
                                <select name="verba_id" id="verba" tabindex="-1" class="form-control">
                                    <option value="">Selecione uma opção...</option>
                                    <?php $pedidoObj->geraOpcao("verbas", $pedido->verba_id ?? $contratacao->programa_verba_id) ?>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md">
                                <label for="forma_pagamento">Forma de pagamento: *</label>
                                <textarea name="forma_pagamento" class="form-control" rows="8"
                                          placeholder="A FORMA DE PAGAMENTO É PREENCHIDA AUTOMATICAMENTE APÓS O CADASTRO DO PEDIDO"
                                          readonly><?= isset($pedido->forma_pagamento) ? $pedido->forma_pagamento : "" ?></textarea>
                            </div>

                            <div class="form-group col-md">
                                <label for="justificativa">Justificativa: *</label>
                                <textarea name="justificativa" class="form-control" rows="8" required><?=  $contratacao->cargo_justificativa ?></textarea>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md">
                                <label for="observacao">Observação:</label>
                                <textarea name="observacao" rows="4" class="form-control"><?= isset($pedido->observacao) ? $pedido->observacao : "" ?></textarea>
                            </div>
                        </div>

                        <?php if ($pedido_id): ?>
                            <br>
                            <div class="row">
                                <div class="form-group col-md">
                                    <label for="numero_processo">Número do Processo:</label>
                                    <input type="text" name="numero_processo" class="form-control"
                                           value="<?= isset($pedido->numero_processo) ? $pedido->numero_processo : "" ?>"
                                           data-mask="9999.9999/9999999-9" minlength="19">
                                </div>
                            </div>
                        <?php endif; ?>

                        <div class="row">
                            <div class="form-group col-md">
                                <label for="fiscal">Fiscal:</label>
                                <input type="text" name="fiscal" class="form-control"
                                       value="<?= isset($contratacao->fiscal_nome) ? $contratacao->fiscal_nome : "" ?>"
                                       disabled>
                            </div>

                            <div class="form-group col-md">
                                <label for="suplente">Suplente:</label>
                                <input type="text" name="suplente" class="form-control"
                                       value="<?= isset($contratacao->suplente_nome) ? $contratacao->suplente_nome : "" ?>"
                                       disabled>
                            </div>
                        </div>

                        <input type="hidden" name="pessoa_tipo_id" value="1">
                        <input type="hidden" name="status_pedido_id" value="2">
                        <input type="hidden" name="origem_tipo_id" value="2">
                        <div class="resposta-ajax"></div>
                    </div>

                    <div class="card-footer">
                        <div class="row">
                            <div class="col-md">
                                <a href="<?= SERVERURL ?>formacao/pedido_contratacao_lista">
                                    <button type="button" class="btn btn-default">Voltar</button>
                                </a>
                            </div>

                            <?php if(isset($pedido_id) && $pedido_id != ""): ?>
                            <div class="col-md" style="text-align: center">
                                <a href="<?= SERVERURL ?>formacao/area_impressao&pedido_id=<?= $pedido_id ?>">
                                    <button type="button" class="btn btn-success">Ir para área de impressão</button>
                                </a>
                            </div>
                            <?php endif; ?>

                            <div class="col-md">
                                <button type="submit" class="btn btn-info float-right" id="finaliza">
                                    Gravar
                                </button>
                            </div>

                        </div>
                    </div>
                    <div class="resposta-ajax"></div>
                </form>
            </div>
        </div>
    </div>
</div>

