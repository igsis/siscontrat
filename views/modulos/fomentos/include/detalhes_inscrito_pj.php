<?php
/**
 * @var FomentoController $fomentoObj
 * @var array $projeto
 */

require_once "./controllers/PessoaJuridicaController.php";
require_once "./controllers/RepresentanteController.php";
$pessoaJuridicaObj = new PessoaJuridicaController();
$repObj = new RepresentanteController();
$pj = $pessoaJuridicaObj->recuperaPessoaJuridica(MainModel::encryption($projeto['pessoa_juridica_id']), true);
$repre = $repObj->recuperaRepresentante(MainModel::encryption($pj->representante_legal1_id), true);
?>
<div class="tab-pane fade" id="custom-tabs-one-profile" role="tabpanel"
     aria-labelledby="custom-tabs-one-profile-tab">
    <p>
        <span class="font-weight-bold">Protocolo: </span> <?= $projeto['protocolo'] ?>
        <span class="font-weight-bold ml-5">Data da Inscrição:</span>
        <?= $fomentoObj->dataHora($projeto['data_inscricao']) ?>
    </p>
    <hr/>
    <p>
        <span class="font-weight-bold">Razão Social:</span>
        <span class="text-left"><?= $pj->razao_social ?></span>
        <span class="font-weight-bold ml-5">CNPJ:</span>
        <span class="text-left"> <?= $pj->cnpj ?></span>
    </p>
    <p>
        <span class="font-weight-bold">E-mail:</span>
        <span class="text-left"> <?= $pj->email ?></span>
    </p>
    <p>
        <span class="font-weight-bold">Telefone #1:</span> <?= $pj->telefones['tel_0'] ?>
        <?php if (isset($pj->telefones['tel_1'])): ?>
            <span class="font-weight-bold ml-5">Telefone #2:</span> <?= $pj->telefones['tel_1'] ?>
        <?php endif;
        if (isset($pj->telefones['tel_2'])): ?>
            <span class="font-weight-bold ml-5">Telefone #3:</span> <?= $pj->telefones['tel_2'] ?>
        <?php endif; ?>
    </p>
    <p>
        <span class="font-weight-bold mr-2"> Endereço: </span> <?= "{$pj->logradouro}, {$pj->numero}  {$pj->complemento} - {$pj->bairro}, {$pj->cidade} - {$pj->uf}, {$pj->cep}" ?>
    </p>
    <p>
        <span class="font-weight-bold">Representante: </span> <?= $repre->nome ?>
        <span class="text-left ml-5 font-weight-bold">CPF: </span> <?= $repre->cpf ?>
        <span class="ml-5 font-weight-bold">RG: </span> <?= $repre->rg ?>
    </p>
</div>