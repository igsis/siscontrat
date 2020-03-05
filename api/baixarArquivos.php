<?php

$data = date('YmdHis');
$nome_arquivo = $data . ".zip";
$path = "../../capac/uploads/";



if (isset($_GET['arquivos'])) {
    $arquivos = explode(":", $_GET['arquivos']);
}

$zip = new ZipArchive();

if( $zip->open( 'zips/arquivo.zip' , ZipArchive::CREATE )  === true) {

    foreach ($arquivos as $arquivo){
        if ($arquivo != ""){
            $file = $path.$arquivo;
            $file2 = "fom/".$arquivo;
            $zip->addFile($file,$file2);
        }
    }
}

$zip->close();

header('Content-Description: File Transfer');
header('Content-Disposition: attachment; filename="' . $nome_arquivo . '"');
header('Content-Type: application/octet-stream');
header('Content-Transfer-Encoding: binary');
header('Content-Length: ' . filesize($nome_arquivo));
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
header('Pragma: public');
header('Expires: 0');


readfile($nome_arquivo);

unlink($data . ".zip");

ob_end_clean(); //essas duas linhas antes do readfile
flush();

?>