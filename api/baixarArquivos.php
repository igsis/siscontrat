<?php

$data = date('YmdHis');
$nome_arquivo = $data . ".zip";
$path = "http://localhost/capac/uploads/";

if (isset($_GET['arquivos'])) {
    $arquivos = explode(":", $_GET['arquivos']);
}

$zip = new ZipArchive();


if ($zip->open($nome_arquivo, ZipArchive::CREATE) === true) {
    foreach ($arquivos as $arquivo) {
        if ($arquivo != ""){
            $file = $path . $arquivo;
            $zip->addFile($file,"fom/".$arquivo);
        }
    }

    $zip->close();
}


header('Content-Description: File Transfer');
header('Content-Disposition: attachment; filename="' . $nome_arquivo . '"');
header('Content-Type: application/octet-stream');
header('Content-Transfer-Encoding: binary');
header('Content-Length: ' . filesize($nome_arquivo));
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
header('Pragma: public');
header('Expires: 0');


ob_end_clean(); //essas duas linhas antes do readfile
flush();

readfile($nome_arquivo);

unlink($data . ".zip");

?>