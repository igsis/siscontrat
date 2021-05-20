<?php
setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
$pedidoAjax = true;

// INSTALAÇÃO DA CLASSE NA PASTA FPDF.
require_once "../config/configGeral.php";
require_once "../views/plugins/fpdf/fpdf.php";
require_once "../controllers/PedidoController.php";
require_once "../controllers/EventoController.php";
require_once "../controllers/OcorrenciaController.php";
require_once "../controllers/AtracaoController.php";

$tipo = $_GET['tipo'];
$id = $_GET['id'];
$idPenal = $_GET['penal'];
$ano = date('Y');

$eventoObj = new EventoController();
$pedidoObj = new PedidoController();
$ocorrenciaObj = new OcorrenciaController();

if ($tipo == 1){//atração
    $atracaoObj = new AtracaoController();
    $atracao = $atracaoObj->recuperaAtracao($id);
    $idEvento = $atracao->evento_id;
}

$pedido = $pedidoObj->recuperaPedido(1,$idEvento);
$penalidade = $pedidoObj->recuperaPenalidades($idPenal);
$evento = $eventoObj->recuperaEvento($idEvento);
$objeto = $eventoObj->recuperaObjetoEvento($idEvento);
$periodo = $eventoObj->retornaPeriodo($idEvento);
$local = $eventoObj->retornaLocais($idEvento);

$pedidoObj->inserePedidoEtapa(intval($pedido->id),"proposta");

header("Content-type: application/vnd.ms-word");
header("Content-Disposition: attachment;Filename=Proposta_Oficina_Convenio.doc");
?>
<html lang="pt-br">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<body>
<table style="width: 100%; border: 0">
    <tr>
        <td style="width: 5%">(A)</td>
        <td style="width: 100%; text-align: center"><strong>CONTRATADO</strong></td>
    </tr>
</table>
<p><i>(Quando se tratar de grupo, o líder do grupo)</i></p>

<p>
    <strong>Nome:</strong> <?= $pedido->nome ?><br>
    <strong>Nome Artístico:</strong> <?= $pedido->nome_artistico == null ? "Não cadastrado" : $pedido->nome_artistico ?><br>
    <?php if ($pedido->passaporte != NULL) {?>
        <strong>Passaporte:</strong> <?= $pedido->passaporte ?><br>
    <?php } else { ?>
        <strong>RG:</strong> <?= $pedido->rg == NULL ? "Não cadastrado" : $pedido->rg ?><br>
        <strong>CPF:</strong> <?= $pedido->cpf ?><br>
    <?php } ?>
    <strong>CCM:</strong> <?= $pedido->ccm ?>
    <strong>DRT:</strong> <?= $pedido->drt ?>
    <strong>Endereço:</strong> <?= $pedido->logradouro . ", " . $pedido->numero . " " . $pedido->complemento . " / - " . $pedido->bairro . " - " . $pedido->cidade . " / " . $pedido->uf ?><br>
    <strong>Telefone(s):</strong> <?= $pedido->telefones['tel_0'] ?? null . " " .$pedido->telefones['tel_1'] ?? null. " ".$pedido->telefones['tel_2'] ?? null ?><br>
    <strong>E-mail:</strong> <?= $pedido->email ?><br>
    <strong>Inscrição no INSS ou nº PIS / PASEP:</strong> <?= $pedido->nit ?? null ?>
</p>
<hr>
<table style="width: 100%; border: 0">
    <tr>
        <td style="width: 5%">(B)</td>
        <td style="width: 100%; text-align: center"><strong>PROPOSTA</strong></td>
    </tr>
</table>
<p style="text-align: right"><?=$evento->protocolo?></p>
<p><strong>Objeto:</strong> <?= $objeto ?> - <strong>CONVÊNIO FEDERAL N° 849979/2017</strong> cujo o objeto é a
    Contratação artística de oficinas de dança, teatro, circo, literatura e música para realização em Bibliotecas, Casas
    de Cultura e Centros Culturais da Secretaria Municipal de Cultura.</p>
<p><strong>Data / Período:</strong> <?= $periodo ?> - conforme cronograma</p>
<p style="text-align: justify"><strong>Local(ais):</strong> <?= $local ?></p>
<p><strong>Valor:</strong> <?= "R$ " . (new MainModel)->dinheiroParaBr(($pedido->valor_total)) . " ( " .  (new MainModel)->valorPorExtenso($pedido->valor_total) . " )"?></p>
<p style="text-align: justify"><strong>Forma de Pagamento:</strong> <?= $pedido->forma_pagamento ?></p>
<p style="text-align: justify"><strong>Justificativa:</strong> <?= $pedido->justificativa ?></p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>___________________________<br>
    <?= $pedido->nome ?><br>
    RG: <?= $pedido->rg ?> <br>
    CPF: <?= $pedido->cpf ?>
</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>(C)</p>
<p style="text-align: center"><strong>EDITAL DE CREDENCIAMENTO Nº 02/2018 – SMC/GAB</strong></p>
<p style="text-align: center"><strong>CONVÊNIO FEDERAL N° 849979/2017</strong>, cujo o objeto é a Contratação artística de oficinas de dança, teatro, circo, literatura e música para realização em Bibliotecas, Casas de Cultura e Centros Culturais da Secretaria Municipal de Cultura.</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p><strong>Declaro que:</strong></p>
<ul>
    <li>Conheço e aceito incondicionalmente as regras do Edital n. 02/2018 – SMC/GAB de Credenciamento.</li>
    <li>Em caso de seleção, responsabilizo-me pelo cumprimento da agenda acordada entre o equipamento municipal e o
        Oficineiro, no tocante ao local, data e horário, para a realização da Oficina. Em acordo com o previsto no
        convênio federal n° 849979/2017.</li>
    <li>Não sou servidor público municipal.</li>
    <li>Estou ciente de que a contratação não gera vínculo trabalhista entre a Municipalidade e o Contratado.</li>
    <li>Estou ciente da aplicação de penalidades conforme item 11 do Edital de Credenciamento nº 02/2018 SMC/GAB.</li>
</ul>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>Data: ____ / ____ / <?= $ano ?></p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>___________________________<br>
    <?= $pedido->nome ?><br>
    RG: <?= $pedido->rg ?> <br>
    CPF: <?= $pedido->cpf ?>
</p>

<p style="text-align: center"><strong>CRONOGRAMA</strong></p>
<p>&nbsp;</p>
<?php
if ($tipo == 1){//atracao
    $atracoes = $atracaoObj->listaAtracao($idEvento);
    foreach ($atracoes as $atracao){
        $ocorrencias = $ocorrenciaObj->recuperaOcorrencia($idEvento,$tipo,$atracao->id);
        $excecao = $ocorrenciaObj->recuperaOcorrenciaExcecao($atracao->id);
        echo "<p><strong>$atracao->nome_atracao</strong></p>";
        foreach ($ocorrencias as $ocorrencia) {
            echo "<p>
                <strong>Ação:</strong> {$atracaoObj->recuperaAcaoAtracao($ocorrencia->atracao_id)} <br>
                <strong>Data/Período:</strong> Data: ".date('d/m/Y',strtotime($ocorrencia->data_inicio));
            if ($ocorrencia->data_fim != "0000-00-00" ){
                echo " à ".date('d/m/Y', strtotime($ocorrencia->data_fim));
            }
            echo " das ".substr($ocorrencia->horario_inicio,0,-3)." às ".substr($ocorrencia->horario_fim,0,-3)." (".$ocorrenciaObj->diadasemanaocorrencia($ocorrencia->id).")<br>
                <strong>Local: </strong> ($ocorrencia->sigla) $ocorrencia->local<br>
                <strong>Subprefeitura:</strong> $ocorrencia->subprefeitura<br>";
            if($ocorrencia->libras == 1 || $ocorrencia->audiodescricao == 1) {
                if ($ocorrencia->libras == 1) {
                    $libras = "Libras";
                } else {
                    $libras = "";
                }
                if ($ocorrencia->audiodescricao == 1) {
                    $audio = "Audiodescrição";
                } else {
                    $audio = "";
                }
                echo "<strong>Especial:</strong> " . $libras . " " . $audio."<br>";
            }
            echo "
                <strong>Retirada de ingresso:</strong> $ocorrencia->retirada_ingresso
                <strong>Valor:</strong> R$ ". (new MainModel)->dinheiroParaBr($ocorrencia->valor_ingresso)."<br>";
            if ($ocorrencia->observacao) {
                echo "<strong>Observação:</strong> $ocorrencia->observacao";
            }
        }
        if ($excecao){
            echo "<p>Dia(s): $excecao</p>";
        }
        echo "</p><br>";
    }
}
?>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>___________________________<br>
    <?= $pedido->nome ?><br>
    RG: <?= $pedido->rg ?> <br>
    CPF: <?= $pedido->cpf ?>
</p>

</body>
</html>
