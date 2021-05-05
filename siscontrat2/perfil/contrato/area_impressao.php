<?php
require_once "../extras/MainModel.php";

$mainObj = new MainModel();

$idPedido = $_POST['idPedido'];

$pedido = $mainObj->consultaSimples("SELECT id, origem_tipo_id, origem_id, pessoa_tipo_id FROM pedidos WHERE id = '$idPedido'")->fetchObject();
$atracoes = $mainObj->consultaSimples("SELECT id,nome_atracao FROM atracoes WHERE evento_id = {$pedido->origem_id} AND publicado = 1 ")->fetchAll(PDO::FETCH_ASSOC);
$numAtracoes = count($atracoes);

$http = PDFURL;


$link_emia = $http . "rlt_proposta_emia.php";
$link_proposta_convenio = $http . "rlt_proposta_oficina_convenio.php?penal=";
$link_reversao_pf = $http . "rlt_reversao_proposta_pf.php?penal=";
$link_reversao_pj = $http . "rlt_reversao_proposta_pj.php?penal=";
$link_direitos = $http . "rlt_direitos_conexos.php";
$link_convenio_pf = $http . "rlt_convenio500_pf.php";
$link_convenio_pj = $http . "rlt_convenio500_pj.php";
$link_exclusividade_pf = $http . "rlt_exclusividade_pf.php";
$link_exclusividade_pj = $http . "rlt_exclusividade_pj.php";
$link_condicionamento_pf = $http . "rlt_condicionamento_pf.php";
$link_condicionamento_pj = $http . "rlt_condicionamento_pj.php";
$link_facc_pf = $http . "rlt_fac_pf.php";
$link_facc_pj = $http . "rlt_fac_pj.php";
$link_parecer_pf = $http . "rlt_parecer_pf.php";
$link_parecer_pj = $http . "rlt_parecer_pj.php";
$link_normas_pf = $http . "rlt_normas_internas_teatros_pf.php";
$link_normas_pj = $http . "rlt_normas_internas_teatros_pj.php";
$link_reserva_global = $http . "rlt_reserva_global.php";
$link_reserva_padrao = $http."rlt_reserva_padrao.php";



$link_pedido_contratacao = $http . "pedido_contratacao.php";
if ($pedido->pessoa_tipo_id == 1) {
    $link_edital = $http . "proposta_edital_word_pf.php?penal=";
    $link_proposta_padrao = $http . "proposta_padrao_pf.php?penal=";
    $link_reversao = $link_reversao_pf;
    $link_convenio = $link_convenio_pf;
    $link_exclusividade = $link_exclusividade_pf;
    $link_condicionamento = $link_condicionamento_pf;
    $link_facc = $link_facc_pf;
    $link_parecer = $link_parecer_pf;
    $idPessoa = $pedido['pessoa_fisica_id'];
    $link_normas = $link_normas_pf;
} else if ($pedido->pessoa_tipo_id == 2) {
    $link_edital = $http . "proposta_edital_word_pj.php?penal=";
    $link_proposta_padrao = $http . "proposta_padrao_pj.php?penal=";
    $link_reversao = $link_reversao_pj;
    $link_convenio = $link_convenio_pj;
    $link_exclusividade = $link_exclusividade_pj;
    $link_condicionamento = $link_condicionamento_pj;
    $link_facc = $link_facc_pj;
    $link_parecer = $link_parecer_pj;
    $link_normas = $link_normas_pj;
}

?>
<div class="content-wrapper">
    <section class="content">
        <h3 class="page-header"> Área de Impressão </h3>

        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">PEDIDO</h3>
                    </div>
                    <div class="box-body">
                        <?php if ($pedido->pessoa_tipo_id == 1) { ?>
                            <a href="<?=PDFURL?>pedido_contratacao.php&id=<?=$idPedido?>" class="btn btn-info" target="_blank">Pedido de Contratação</a>
                            <!--<form action="<?/*= $link_pedido_contratacao */?>" target="_blank" method="post">
                                <input type="hidden" name="idPedido" value="<?/*= $idPedido */?>">
                                <button type="submit" class="btn btn-primary center-block">Pedido de Contratação</button>
                            </form>-->
                        <?php
                        }else {
                            if ($numAtracoes > 1){
                                ?>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Pedido de Contratação <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <?php foreach ($atracoes as $atracao){?>
                                            <li><a target="_blank" href="<?=PDFURL?>pedido_contratacao.php?atracao=<?=$mainObj->encryption($atracao['id'])?>"><?=$atracao['nome_atracao'] ?></a></li>
                                        <?php } ?>
                                    </ul>
                                </div>
                            <?php
                            } else{
                            ?>
                                <a href="#" class="btn btn-info" target="_blank">Pedido de Contratação</a>
                            <?php } ?>
                        <?php } ?>
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
                                <form action="<?= $link_edital . "23" ?>" target="_blank" method="post">
                                    <input type="hidden" name="idPedido" value="<?= $idPedido ?>">
                                    <input type="hidden" name="idUser" value="<?= $idUser ?>">
                                    <button type="submit" class="btn btn-info btn-block">
                                        Editais
                                    </button>
                                </form>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <?php if ($pedido->pessoa_tipo_id == 1) { ?>
                                    <form action="<?= $link_proposta_padrao . "13" ?>" target="_blank" method="post">
                                        <input type="hidden" name="idPedido" value="<?= $idPedido ?>">
                                        <input type="hidden" name="idUser" value="<?= $idUser ?>">
                                        <button type="submit" class="btn btn-primary btn-block">
                                            Contratações gerais - Com cachê
                                        </button>
                                    </form>

                                    <?php
                                }else {
                                    if ($numAtracoes > 1){
                                        ?>
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Contratações gerais - Com cachê <span class="caret"></span>
                                            </button>
                                            <ul class="dropdown-menu">
                                                <?php foreach ($atracoes as $atracao){?>
                                                    <li><a target="_blank" href="<?=PDFURL?>proposta_padrao_pj.php?penal=13&tipo=1&id=<?=$mainObj->encryption($atracao['id'])?>"><?=$atracao['nome_atracao'] ?></a></li>
                                                <?php } ?>
                                            </ul>
                                        </div>
                                        <?php
                                    } else{
                                        ?>
                                        <a class="btn btn-info btn-block" target="_blank" href="<?=PDFURL?>proposta_padrao_pj.php?penal=13&tipo=1&id=<?=$mainObj->encryption($atracoes[0]['id'])?>">Pedido de Contratação</a>
                                    <?php } ?>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <form action="<?= $link_reversao . "13" ?>" target="_blank" method="post">
                                    <input type="hidden" name="idPedido" value="<?= $idPedido ?>">
                                    <input type="hidden" name="idUser" value="<?= $idUser ?>">
                                    <button type="submit" class="btn btn-primary btn-block">
                                        Contratações gerais - Reversão de Bilheteria
                                    </button>
                                </form>
                            </div>
                        </div>
                        <?php
                        if ($pedido->pessoa_tipo_id == 1){
                        ?>
                            <div class="row">
                                <div class="col-md-12">
                                    <form action="<?= $link_proposta_convenio . "13" ?>" target="_blank" method="post">
                                        <input type="hidden" name="idPedido" value="<?= $idPedido ?>">
                                        <input type="hidden" name="idUser" value="<?= $idUser ?>">
                                        <button type="submit" class="btn btn-primary btn-block">
                                            Proposta Oficinas / Convênio MINC
                                        </button>
                                    </form>
                                </div>
                            </div>
                        <?php
                        }
                        if ($pedido->origem_tipo_id == 2) { ?>
                            <div class="row">
                                <div class="col-md-12">
                                    <form action="<?= $link_proposta_padrao . "20" ?>" target="_blank" method="post">
                                        <input type="hidden" name="idPedido" value="<?= $idPedido ?>">
                                        <input type="hidden" name="idUser" value="<?= $idUser ?>">
                                        <button type="submit" class="btn btn-primary btn-block">
                                            Vocacional
                                        </button>
                                    </form>
                                    <hr/>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <form action="<?= $link_proposta_padrao . "21" ?>" target="_blank" method="post">
                                        <input type="hidden" name="idPedido" value="<?= $idPedido ?>">
                                        <input type="hidden" name="idUser" value="<?= $idUser ?>">
                                        <button type="submit" class="btn btn-primary btn-block">
                                            PIÁ
                                        </button>
                                    </form>
                                    <hr/>
                                </div>
                            </div>
                        <?php }
                        if ($pedido->origem_tipo_id == 3) {
                            ?>
                            <div class="row">
                                <div class="col-md-3">
                                    <form action="<?= $link_emia ?>" target="_blank" method="post">
                                        <input type="hidden" name="idPedido" value="<?= $idPedido ?>">
                                        <button type="submit" class="btn btn-primary btn-block">
                                            EMIA
                                        </button>
                                    </form>
                                    <hr/>
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
                                <form action="<?= $link_convenio ?>" target="_blank" method="post">
                                    <input type="hidden" name="idPedido" value="<?= $idPedido ?>">
                                    <button type="submit" class="btn btn-primary btn-block">
                                        Convênio 500
                                    </button>
                                </form>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <form action="<?= $link_condicionamento ?>" target="_blank" method="post">
                                    <input type="hidden" name="idPedido" value="<?= $idPedido ?>">
                                    <button type="submit" class="btn btn-primary btn-block">
                                        Condicionamento
                                    </button>
                                </form>
                            </div>
                        </div>
                        <?php
                        if ($pedido->pessoa_tipo_id == 1) { ?>
                            <div class="row">
                                <div class="col-md-12">
                                    <form action="<?= $link_direitos ?>" target="_blank" method="post">
                                        <input type="hidden" name="idPedido" value="<?= $idPedido ?>">
                                        <button type="submit" class="btn btn-primary btn-block">
                                            Direitos Conexos
                                        </button>
                                    </form>
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
                                <form action="<?= $link_facc ?>" target="_blank" method="post">
                                    <input type="hidden" name="idPessoa" value="<?= $idPessoa ?>">
                                    <input type="hidden" name="idPedido" value="<?= $idPedido ?>">
                                    <button type="submit" class="btn btn-primary btn-block">
                                        FACC
                                    </button>
                                </form>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <form action="<?= $link_parecer ?>" type="submit" target="_blank" method="post">
                                    <input type="hidden" name="idPedido" value="<?= $idPedido ?>">
                                    <button type="submit" class="btn btn-primary btn-block">
                                        Parecer da Comissão
                                    </button>
                                </form>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <form action="<?= $link_normas ?>" target="_blank" method="post">
                                    <input type="hidden" name="idPedido" value="<?= $idPedido ?>">
                                    <button type="submit" class="btn btn-primary btn-block">
                                        NORMAS INTERNAS - Teatros Municipais
                                    </button>
                                </form>
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