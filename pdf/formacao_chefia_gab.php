<?php
setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
$pedidoAjax = true;
// INSTALAÇÃO DA CLASSE NA PASTA FPDF.
require_once "../config/configGeral.php";
?>


<html>
<head>
    <meta http-equiv=\"Content-Type\" content=\"text/html. charset=Windows-1252\">

    <style>

        .texto {
            width: 900px;
            border: solid;
            padding: 20px;
            font-size: 12px;
            font-family: Arial, Helvetica, sans-serif;
            text-align: justify;
        }
    </style>
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="<?= SERVERURL ?>views/plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= SERVERURL ?>views/dist/css/adminlte.min.css">
    <title>Chefia/Gab</title>
</head>

<br>
<body>


<?php

$texto =
    "<p><strong>SMC - CONTABILIDADE</strong></p>".
    "<p><strong>Sr.(a) Contador(a)</strong></p>".
    "<p>&nbsp;</p>".
    "<p>Autorizo o presente para providências quanto ao pagamento, uma vez que os serviços foram realizados e confirmados a contento conforme o documento <strong>link SEI (ateste do fiscal)</strong>.</p>"

?>

<div align="center">
    <div id="texto" class="texto"><?php echo $texto; ?></div>
</div>

<div align="center">
    <button id="botao-copiar" class="btn btn-primary" onclick="copyText(getElementById('texto'))">
        CLIQUE AQUI PARA COPIAR O TEXTO
        <i class="fa fa-copy"></i>
    </button>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <a href="http://sei.prefeitura.sp.gov.br" target="_blank">
        <button class="btn btn-primary">CLIQUE AQUI PARA ACESSAR O <img src="../views/dist/img/logo_sei.jpg"></button>
    </a>
</div>

<script>
    function copyText(element) {
        var range, selection, worked;

        if (document.body.createTextRange) {
            range = document.body.createTextRange();
            range.moveToElementText(element);
            range.select();
        } else if (window.getSelection) {
            selection = window.getSelection();
            range = document.createRange();
            range.selectNodeContents(element);
            selection.removeAllRanges();
            selection.addRange(range);
        }

        try {
            document.execCommand('copy');
            alert('Copiado com sucesso!');
        }
        catch (err) {
            alert('Texo não copiado, tente novamente.');
        }
    }
</script>

</body>
</html>