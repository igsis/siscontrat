<?php
require_once "./controllers/FormacaoController.php";

$id = isset($_GET['id']) ? $_GET['id'] : NULL;
$pedidoObj = new FormacaoController();
if($id != NULL){
    $pedido = $pedidoObj->recuperaPedido($id);
}
$contratacao_id = isset($_POST['contratacao_id']) ? $_POST['contratacao_id'] : MainModel::encryption($pedido->origem_id);
$contratacao = $pedidoObj->recuperaContratacao($contratacao_id);

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

                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="ano">Ano:</label>
                            <input type="text" name="ano" class="form-control"
                                   value="<?= isset($contratacao->ano) ? $contratacao->ano : "" ?>"
                                   disabled>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="chamado">Chamado:</label>
                            <input type="text" name="chamado" class="form-control"
                                   value="<?= isset($contratacao->chamado) ? $contratacao->chamado : "" ?>"
                                   disabled>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="pessoa_fisica">Pessoa Fisica:</label>
                            <input type="text" name="pessoa_fisica" class="form-control"
                                   value="<?= isset($contratacao->nome) ? $contratacao->nome : "" ?>"
                                   disabled>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="classificacao_indicativa">Classificação Indicativa: </label>
                            <button type="button" class="btn bg-gradient-primary btn-sm" data-toggle="modal"
                                    data-target="#modal-default"><i
                                        class="fa fa-info"></i></button>
                            <input type="text" name="classificacao_indicativa" class="form-control"
                                   value="<?= isset($contratacao->classificacao_indicativa) ? $contratacao->classificacao_indicativa : "" ?>"
                                   disabled>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-3">
                            <label for="territorio">Território:</label>
                            <input type="text" name="territorio" class="form-control"
                                   value="<?= isset($contratacao->territorio) ? $contratacao->territorio : "" ?>"
                                   disabled>
                        </div>

                        <div class="form-group col-md-3">
                            <label for="coordenadoria">Coordenadoria:</label>
                            <input type="text" name="coordenadoria" class="form-control"
                                   value="<?= isset($contratacao->coordenadoria) ? $contratacao->coordenadoria : "" ?>"
                                   disabled>
                        </div>

                        <div class="form-group col-md-3">
                            <label for="subprefeitura">Subprefeitura:</label>
                            <input type="text" name="subprefeitura" class="form-control"
                                   value="<?= isset($contratacao->subprefeitura) ? $contratacao->subprefeitura : "" ?>"
                                   disabled>
                        </div>

                        <div class="form-group col-md-3">
                            <label for="programa">Programa:</label>
                            <input type="text" name="programa" class="form-control"
                                   value="<?= isset($contratacao->programa) ? $contratacao->programa : "" ?>"
                                   disabled>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="linguagem">Linguagem:</label>
                            <input type="text" name="linguagem" class="form-control"
                                   value="<?= isset($contratacao->linguagem) ? $contratacao->linguagem : "" ?>"
                                   disabled>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="projeto">Projeto:</label>
                            <input type="text" name="projeto" class="form-control"
                                   value="<?= isset($contratacao->projeto) ? $contratacao->projeto : "" ?>"
                                   disabled>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="cargo">Cargo:</label>
                            <input type="text" name="cargo" class="form-control"
                                   value="<?= isset($contratacao->cargo) ? $contratacao->cargo : "" ?>"
                                   disabled>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="vigencia">Vigência:</label>
                            <input type="text" name="vigencia" class="form-control"
                                   value="<?= isset($contratacao->vigencia) ? $contratacao->vigencia . ' (' . $contratacao->descricao . ')' : "" ?>"
                                   disabled>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="observacao">Observação:</label>
                            <textarea name="observacao" class="form-control" rows="3"
                                      disabled><?= isset($contratacao->observacao) ? $contratacao->observacao : "" ?></textarea>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="fiscal">Fiscal:</label>
                            <input type="text" name="fiscal" class="form-control"
                                   value="<?= isset($contratacao->fiscal) ? $contratacao->fiscal : "" ?>"
                                   disabled>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="suplente">Suplente:</label>
                            <input type="text" name="suplente" class="form-control"
                                   value="<?= isset($contratacao->suplente) ? $contratacao->suplente : "" ?>"
                                   disabled>
                        </div>
                    </div>

                    <hr>

                    <div class="row">
                        <div class="form-group col-md-12">
                            <br>
                            <form action="<?= SERVERURL ?>formacao/pedido_edita_parcelas" method="POST">
                                <input type="hidden" name="nParcelas" id="nParcelas" value="">
                                <input type="hidden" name="valor" id="valor" value="">
                                <input type="hidden" name="pedido_id" value="<?= $id ?? NULL?>">
                                <button type="submit" class="btn btn-info float-right">Editar parcelas</button>
                            </form>
                        </div>
                    </div>

                    <form class="form-horizontal formulario-ajax" method="POST"
                          action="<?= SERVERURL ?>ajax/formacaoAjax.php" role="form"
                          data-form="<?= ($id) ? "update" : "save" ?>">
                        <input type="hidden" name="_method"
                               value="<?= ($id) ? "editarPedido" : "cadastrarPedido" ?>">
                        <?php if ($id): ?>
                            <input type="hidden" name="id" value="<?= $id ?>">
                        <?php endif; ?>
                        <div class="row">
                            <div class="form-group col-md-3">
                                <label for="verba_id">Verba: * </label>
                                <select name="verba_id" required class="form-control">
                                    <option value="">Selecione uma opção...</option>
                                    <?php $pedidoObj->geraOpcao("verbas", $pedido->verba_id) ?>
                                </select>
                            </div>

                            <div class="form-group col-md-3">
                                <label for="dataKit">Data kit pagamento: *</label>
                                <input type="date" name="data_kit_pagamento" class="form-control" required
                                       value="<?= isset($pedido->data_kit_pagamento) ? $pedido->data_kit_pagamento : "" ?>"
                                       placeholder="DD/MM/AAAA">
                            </div>

                            <div class="form-group col-md-3">
                                <label for="numero_parcelas">Número de parcelas: *</label>
                                <input type="number" name="numero_parcelas" id="numero_parcelas"
                                       onkeyup="getCamposParcela();" min="1" pattern="[1-9]"
                                       maxlength="2" title="Apenas números, e o mínimo aceito no campo é 1"
                                       value="<?= isset($pedido->numero_parcelas) ? $pedido->numero_parcelas : $contratacao->numero_parcelas ?>"
                                       class="form-control" required>
                            </div>

                            <div class="form-group col-md-3">
                                <label for="valor">Valor: *</label>
                                <input type="text" name="valor_total" id="valor_total"
                                       onKeyPress="return(moeda(this,'.',',',event))" onkeyup="getCamposParcela()"
                                       value="<?= isset($pedido->valor_total) ? MainModel::dinheiroParaBr($pedido->valor_total) : MainModel::dinheiroParaBr($pedidoObj->retornaValorTotalVigencia($contratacao->idVigencia)) ?>"
                                       class="form-control" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="numero_processo">Número do Processo: *</label>
                                <input type="text" name="numero_processo" required class="form-control"
                                       value="<?= isset($pedido->numero_processo) ? $pedido->numero_processo : "" ?>"
                                       data-mask="9999.9999/9999999-9" minlength="19">
                            </div>

                            <div class="form-group col-md-6">
                                <label for="numero_processo_mae">Número do Processo Mãe: *</label>
                                <input type="text" name="numero_processo_mae" id="processoMae" required
                                       value="<?= isset($pedido->numero_processo_mae) ? $pedido->numero_processo_mae : "" ?>"
                                       class="form-control"
                                       data-mask="9999.9999/9999999-9" minlength="19">
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="forma_pagamento">Forma de pagamento: *</label>
                                <textarea id="forma_pagamento" name="forma_pagamento" required
                                          class="form-control"
                                          readonly
                                          placeholder="A FORMA DE PAGAMENTO É PREENCHIDA AUTOMATICAMENTE APÓS O CADASTRO DO PEDIDO/EDIÇÃO DE PARCELAS"
                                          rows="8"><?= isset($pedido->forma_pagamento) ? $pedido->forma_pagamento : "" ?></textarea>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="justificativa">Justificativa: *</label>
                                <textarea name="justificativa" required class="form-control"
                                          rows="8"><?= isset($pedido->justificativa) ? $pedido->justificativa : "" ?></textarea>
                            </div>
                        </div>

                        <div class="row">
                            <?php for ($i = 0; $i < 3; $i++) { ?>
                                <div class="form-group col-md-4">
                                    <label for="local_id[]">Local #<?= $i + 1 ?>
                                        : <?= $i == 0 ? " *" : "" ?></label>
                                    <select name="local_id[]" class="form-control">
                                        <option value="0">Selecione uma opção...</option>
                                        <?php $pedidoObj->geraOpcao('locais', $pedidoObj->retornaLocaisFormacao($pedido->origem_id, '1')[$i]['id']) ?>
                                    </select>
                                </div>
                            <?php } ?>
                        </div>

                        <div class="row">
                            <label for="observacao">Observação:</label>
                            <textarea name="observacao" rows="8" class="form-control"></textarea>
                        </div>

                        <input type="hidden" name="origem_tipo_id" value="2">
                        <?php if ($contratacao_id): ?>
                            <input type="hidden" name="contratacao_id" value="<?= $contratacao_id ?>">
                        <?php endif; ?>
                        <div class="resposta-ajax"></div>
                </div>

                <div class="card-footer">
                    <a href="<?= SERVERURL ?>formacao/pedido_contratacao_lista">
                        <button type="button" class="btn btn-default">Voltar</button>
                    </a>
                    <button type="submit" class="btn btn-info float-right">
                        <?= $id == NULL ? "Cadastrar" : "Editar" ?>
                    </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php MainModel::exibeModalClassificacaoIndicativa() ?>

<script>
    function getCamposParcela() {
        let qtParcela = $('#numero_parcelas').val();
        let valor = $('#valor_total').val();
        $('#nParcelas').attr('value', qtParcela);
        $('#valor').attr('value', valor);
    }

    document.getElementById("numero_parcelas").onkeypress = function (e) {
        var chr = String.fromCharCode(e.which);
        if ("1234567890".indexOf(chr) < 0)
            return false;
    };

    $(document).ready(function () {
        $('#numero_parcelas').mask('00', {reverse: true});
        getCamposParcela();
    });
</script>
