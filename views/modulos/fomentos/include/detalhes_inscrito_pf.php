<?php
require_once "./controllers/PessoaFisicaController.php";
$pessoaFisicaObj = new PessoaFisicaController();
$pf = $pessoaFisicaObj->recuperaPessoaFisica(MainModel::encryption($projeto['pessoa_fisica_id']), true);
$pfDados = $pessoaFisicaObj->recuperaPfDados($pf['id'])->fetch();
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
        <span class="font-weight-bold">Nome:</span>
        <span class="text-left"><?= $pf['nome'] ?></span>
        <span class="font-weight-bold ml-5">CPF:</span>
        <span class="text-left"> <?= $pf['cpf'] ?></span>
    </p>
    <p>
        <span class="font-weight-bold">Gênero:</span> <?= $pfDados['genero'] ?>
        <span class="font-weight-bold ml-5">Raça ou cor:</span> <?= $pfDados['descricao'] ?>
        <span class="font-weight-bold ml-5">Data de nascimento:</span> <?= date("d/m/Y", strtotime($pf['data_nascimento'])) ?>
    </p>
    <p>
        <span class="font-weight-bold">Rede social:</span> <?= $pfDados['rede_social'] ?>
    </p>
    <p>
        <span class="font-weight-bold">E-mail:</span>
        <span class="text-left"> <?= $pf['email'] ?></span>
    </p>
    <p>
        <span class="font-weight-bold">Telefone #1:</span> <?= $pf['telefones']['tel_0'] ?>
        <?php if (isset($pf['telefones']['tel_1'])): ?>
            <span class="font-weight-bold ml-5">Telefone #2:</span> <?= $pf['telefones']['tel_1'] ?>
        <?php endif;
        if (isset($pf['telefones']['tel_2'])): ?>
            <span class="font-weight-bold ml-5">Telefone #3:</span> <?= $pf['telefones']['tel_2'] ?>
        <?php endif; ?>
    </p>
    <p>
        <span class="font-weight-bold mr-2"> Endereço: </span> <?= "{$pf['logradouro']}, {$pf['numero']}  {$pf['complemento']} - {$pf['bairro']}, {$pf['cidade']} - {$pf['uf']}, {$pf['cep']}" ?>
    </p>
    <p><span class="font-weight-bold">Subprefeitura:</span> <?= $pfDados['subprefeitura'] ?></p>
</div>