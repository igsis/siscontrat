<?php
require_once "../extras/MainModel.php";
$mainObj = new MainModel();

$idPedido = $_POST['idPedido'];

$pedido = $mainObj->consultaSimples("SELECT id, origem_tipo_id, origem_id, pessoa_tipo_id, pessoa_fisica_id, pessoa_juridica_id FROM pedidos WHERE id = '$idPedido'")->fetchObject();


function box_bottom($pedido,$titulo,$link){
    $mainObj = new MainModel();
    $tipo_evento = $mainObj->consultaSimples("SELECT tipo_evento_id FROM eventos WHERE id = '$pedido->origem_id'")->fetchColumn();

    if ($tipo_evento == 1){ //atracao
        $atracoes = $mainObj->consultaSimples("SELECT id,nome_atracao FROM atracoes WHERE evento_id = {$pedido->origem_id} AND publicado = 1 ")->fetchAll(PDO::FETCH_ASSOC);
        $numAtracoes = count($atracoes);

        if ($numAtracoes > 1){
            $inicio_box = "
                <div class='box box-primary box-solid collapsed-box'>
                    <div class='box-header with-border' data-widget='collapse'>$titulo
                        <div class='pull-right'><i class='fa fa-plus'></i></div>
                    </div>
                    <div class='box-body' style='display: none;'>
                        <ul class='nav nav-stacked'>";
            $lista="";
            foreach ($atracoes as $atracao){
                $lista .= "
                <li>
                    <a target='_blank' href='".PDFURL.$link.$mainObj->encryption($atracao['id'])."&tipo=".$tipo_evento."'> 
                        Atração: ".mb_strimwidth($atracao['nome_atracao'],0,50,"...")."
                    </a>
                </li>";
            }
            $fim_box = "</ul></div></div>";

            return $inicio_box.$lista.$fim_box;
        } else{
            return "<a href='".PDFURL.$link.$mainObj->encryption($atracoes[0]['id'])."&tipo=".$tipo_evento."' target='_blank' class='btn btn-primary btn-block'>$titulo</a>";
        }
    }
    else {
        return "<a href='".PDFURL.$link.$mainObj->encryption($pedido->origem_id)."&tipo=".$tipo_evento."' target='_blank' class='btn btn-primary btn-block'>$titulo</a><br/>";
    }
}

/*
$link_exclusividade_pf = $http . "rlt_exclusividade_pf.php";
$link_exclusividade_pj = $http . "rlt_exclusividade_pj.php";
$link_reserva_global = $http . "rlt_reserva_global.php";
$link_reserva_padrao = $http."rlt_reserva_padrao.php";

$link_pedido_contratacao = $http . "pedido_contratacao.php";
if ($pedido->pessoa_tipo_id == 1) {
    $link_reversao = $link_reversao_pf;
    $link_exclusividade = $link_exclusividade_pf;
} else if ($pedido->pessoa_tipo_id == 2) {
    $link_exclusividade = $link_exclusividade_pj;
}*/

?>
<div class="content-wrapper">
    <section class="content">
        <h3 class="page-header">Área de Impressão</h3>

        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">PEDIDO</h3>
                    </div>
                    <div class="box-body">
                        <div class="col-md-4">
                            <?= box_bottom($pedido,"Pedido de Contratação","pedido_contratacao.php?tipo=$pedido->origem_tipo_id&id=");?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">PROPOSTA</h3>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12">
                                <?php
                                if ($pedido->pessoa_tipo_id == 1) {
                                    echo box_bottom($pedido,"Editais","proposta_edital_word_pf.php?penal=13&id=");
                                }
                                else{
                                    echo box_bottom($pedido,"Editais","proposta_edital_word_pj.php?penal=13&id=");
                                }
                                ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <?php
                                if ($pedido->pessoa_tipo_id == 1) {
                                    echo box_bottom($pedido,"Contratações gerais - Com cachê","proposta_padrao_pf.php?penal=13&id=");
                                }
                                else{
                                     echo box_bottom($pedido,"Contratações gerais - Com cachê","proposta_padrao_pj.php?penal=13&id=");
                                }
                                ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <?php
                                if ($pedido->pessoa_tipo_id == 1) {
                                    echo box_bottom($pedido,"Contratações gerais - Reversão de Bilheteria","proposta_reversao_pf.php?penal=13&id=");
                                }
                                else{
                                    echo box_bottom($pedido,"Contratações gerais - Reversão de Bilheteria","proposta_reversao_pj.php?penal=13&id=");
                                }
                                ?>
                            </div>
                        </div>
                        <?php
                        if ($pedido->pessoa_tipo_id == 1){
                        ?>
                            <div class="row">
                                <div class="col-md-12">
                                    <?= box_bottom($pedido,"Proposta Oficinas / Convênio MINC","proposta_oficina_convenio.php?penal=13&id="); ?>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">DECLARAÇÃO</h3>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12">
                                <form action="<?= $link_exclusividade ?>" target="_blank" method="post">
                                    <input type="hidden" name="idPedido" value="<?= $idPedido ?>">
                                    <button type="submit" class="btn btn-primary btn-block">
                                        Exclusividade
                                    </button>
                                </form>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <?php
                                if ($pedido->pessoa_tipo_id == 1) {
                                    echo box_bottom($pedido,"Convênio 500","declaracao_convenio500_pf.php?id=$pedido->pessoa_fisica_id&idPedido=");
                                }
                                else{
                                    echo box_bottom($pedido,"Convênio 500","declaracao_convenio500_pj.php?id=$pedido->pessoa_juridica_id&idPedido=");
                                }
                                ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <a href="<?=PDFURL."declaracao_condicionamento.php?id=".$mainObj->encryption($pedido->origem_id)?>" target='_blank' class='btn btn-primary btn-block' style="text-align: left">Condicionamento</a><br>
                            </div>
                        </div>
                        <?php
                        if ($pedido->pessoa_tipo_id == 1) { ?>
                            <div class="row">
                                <div class="col-md-12">
                                    <a href="<?=PDFURL."declaracao_direitos_conexos.php?id=".$mainObj->encryption($pedido->origem_id)?>" target='_blank' class='btn btn-primary btn-block' style="text-align: left">Direitos Conexos</a><br>
                                </div>
                            </div>
                        <?php }?>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">OUTROS</h3>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12">
                                <?php
                                if ($pedido->pessoa_tipo_id == 1) {
                                    echo box_bottom($pedido,"FACC","facc_pf.php?id=$pedido->pessoa_fisica_id&idPedido=");
                                }
                                else{
                                    echo box_bottom($pedido,"FACC","facc_pj.php?id=$pedido->pessoa_juridica_id&idPedido=");
                                }
                                ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <a href="<?=PDFURL."parecer_comissao.php?id=".$mainObj->encryption($pedido->origem_id)?>" target='_blank' class='btn btn-primary btn-block' style="text-align: left">Parecer da Comissão</a><br>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <?php
                                if ($pedido->pessoa_tipo_id == 1) {
                                    echo box_bottom($pedido,"Normas Internas - Teatros Municipais","normas_internas_teatros.php?id=$pedido->pessoa_fisica_id&tipoPessoa=1&idPedido=");
                                }
                                else{
                                    echo box_bottom($pedido,"Normas Internas - Teatros Municipais","normas_internas_teatros.php?id=$pedido->pessoa_juridica_id&tipoPessoa=2&idPedido=");
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">PEDIDO DE RESERVA</h3>
                    </div>
                    <div class="box-body">
                        <div class="col-md-3">
                            <form action="<?= $link_reserva_padrao ?>" target="_blank" method="post">
                                <input type="hidden" name="idPedido" value="<?= $idPedido ?>">
                                <button type="submit" class="btn btn-primary btn-block">
                                    Reserva Padrão
                                </button>
                            </form>
                        </div>

                        <div class="col-md-3">
                            <form action="<?= $link_reserva_global ?>" target="_blank" method="post">
                                <input type="hidden" name="idPedido" value="<?= $idPedido ?>">
                                <button type="submit" class="btn btn-primary btn-block">
                                    Reserva Global
                                </button>
                            </form>
                        </div>

                    </div>
                </div>
            </div>

        </div>

    </section>
</div>