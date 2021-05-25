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
require_once "../controllers/FilmeController.php";

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
} elseif ($tipo == 2) {//filme
    $filmeObj = new FilmeController();
    $idEvento = $filmeObj->getIdEvento($id);
}

$pedido = $pedidoObj->recuperaPedido(1,$idEvento);
$penalidade = $pedidoObj->recuperaPenalidades($idPenal);
$evento = $eventoObj->recuperaEvento($idEvento);
$objeto = $eventoObj->recuperaObjetoEvento($idEvento);
$periodo = $eventoObj->retornaPeriodo($idEvento);
$local = $eventoObj->retornaLocais($idEvento);

$pedidoObj->inserePedidoEtapa(intval($pedido->id),"proposta");

header("Content-type: application/vnd.ms-word");
header("Content-Disposition: attachment;Filename=proposta_edital_pf_$pedido->id.doc");
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
<p><strong>Objeto:</strong> <?= $objeto ?></p>
<p><strong>Data / Período:</strong> <?= $periodo ?>
<p style="text-align: justify"><strong>Local(ais):</strong> <?= $local ?></p>
<p><strong>Valor:</strong> <?= "R$ " . (new MainModel)->dinheiroParaBr(($pedido->valor_total)) . " ( " .  (new MainModel)->valorPorExtenso($pedido->valor_total) . " )"?></p>
<p style="text-align: justify"><strong>Forma de Pagamento:</strong> <?= $pedido->forma_pagamento ?></p>
<p style="text-align: justify"><strong>Justificativa:</strong> <?= $pedido->justificativa ?></p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>___________________________<br>
    <?= $pedido->nome ?> <br>
    <?= $pedido->cpf ? "CPF: ".$pedido->cpf : "Passaporte: ".$pedido->passaporte ?>
</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>(C)</p>
<p style="text-align: center"><strong>OBSERVAÇÃO</strong></p>
<p style="text-align: justify">As idéias e opiniões expressas durante as apresentações artísticas e culturais não representam a posição da Secretaria Municipal de Cultura, sendo os artistas e seus representantes os únicos e exclusivos responsáveis pelo conteúdo de suas manifestações, ficando a Municipalidade de São Paulo com direito de regresso sobre os mesmos, inclusive em caso de indenização por dano material, moral ou à imagem de terceiros.</p>
<p style="text-align: justify">Os registros das atividades e ações poderão ser utilizados para fins institucionais de divulgação, promoção e difusão do Programa e da Secretaria Municipal de Cultura.</p>
<p>&nbsp;</p>
<p style="text-align: center"><strong>DECLARAÇÕES</strong></p>
<p style="text-align: justify">Declaro que não tenho débitos perante as fazendas públicas, federal, estadual e, em especial perante a Prefeitura do Município de São Paulo.</p>
<p style="text-align: justify">Declaro que estou ciente e de acordo com todas as regras do [INSIRA O TÍTULO DO EDITAL AQUI. Ex: Edital de Concurso Programa de Exposições 2016].</p>
<p style="text-align: justify">Declaro que estou ciente da aplicação das penalidades previstas na cláusula [INSIRA A CLÁUSULA DA PENALIDADE AQUI. Ex: na cláusula 10 do Edital de Concurso Programa de Exposições 2016.].As penalidades serão aplicadas sem prejuízo das demais sanções previstas na legislação que rege a matéria.</p>
<p style="text-align: justify">Declaro, ainda, estar ciente que do valor do serviço serão descontados os impostos cabíveis.</p>
<p style="text-align: justify">Declaro, sob as penas da Lei, que não sou servidor público municipal e que não há, de minha parte, impedimento para contratar com a [INSIRA A UNIDADE AQUI. Ex: Prefeitura do Município de São Paulo/Secretaria Municipal de Cultura/Centro Cultural São Paulo], mediante o pagamento de cachê.</p>
<p style="text-align: justify">Todas as informações precedentes são formadas sob as penas da Lei.</p>
<p>&nbsp;</p>
<p>Data: ____ / ____ / <?=$ano?>.</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>___________________________<br>
    <?= $pedido->nome ?> <br>
    <?= $pedido->cpf ? "CPF: ".$pedido->cpf : "Passaporte: ".$pedido->passaporte ?>
</p>
<p>&nbsp;</p>
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
                <strong>Local: </strong> ($ocorrencia->sigla) {$ocorrencia->local} - Localizado em {$ocorrencia->logradouro}, $ocorrencia->numero $ocorrencia->complemento - $ocorrencia->bairro - $ocorrencia->cidade / $ocorrencia->uf CEP: $ocorrencia->cep<br>
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
elseif ($tipo == 2) {//filme
    $filmes = $filmeObj->listaFilme($id);
    foreach ($filmes as $filme) {
        $ocorrencias = $ocorrenciaObj->recuperaOcorrencia($idEvento,$tipo,$filme->id);
        $excecao = $ocorrenciaObj->recuperaOcorrenciaExcecao($filme->id);
        $detalheFilme = $filmeObj->recuperaDetalheFilme($filme->id);
        echo "<p>
            <strong>Título:</strong> $detalheFilme->titulo<br>
            <strong>Gênero:</strong> $detalheFilme->genero<br>
            <strong>Duração:</strong> $detalheFilme->duracao<br>
        ";
        foreach ($ocorrencias as $ocorrencia) {
            echo "
            <strong>Data/Período:</strong> Data: ".date('d/m/Y',strtotime($ocorrencia->data_inicio));
            if ($ocorrencia->data_fim != "0000-00-00" ){
                echo " à ".date('d/m/Y', strtotime($ocorrencia->data_fim));
            }
            echo " das ".substr($ocorrencia->horario_inicio,0,-3)." às ".substr($ocorrencia->horario_fim,0,-3)." (".$ocorrenciaObj->diadasemanaocorrencia($ocorrencia->id).")<br>
                <strong>Local: </strong> ($ocorrencia->sigla) $ocorrencia->local<br>
                <strong>Subprefeitura:</strong> $ocorrencia->subprefeitura<br>";
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
    <?= $pedido->nome ?> <br>
    <?= $pedido->cpf ? "CPF: ".$pedido->cpf : "Passaporte: ".$pedido->passaporte ?>
</p>
</body>
</html>