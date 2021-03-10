<?php
setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');

$pedidoAjax = true;
require_once "../config/configGeral.php";
require_once "../views/plugins/phpexcel/PHPExcel.php";
require_once "../controllers/FomentoController.php";
require_once "../controllers/ArquivoController.php";

$id = $_GET['id'];
$aprovado = $_GET['aprovado'] ?? false;

if($aprovado){
    $aprovados = "Aprovados";
}
else{
    $aprovados = "";
}

$objPHPExcel = new PHPExcel();
$fomentoObj = new FomentoController();
$arqObj = new ArquivoController();

$edital = $fomentoObj->recuperaEdital($id);
$nomeEdital = $edital->titulo;
$pessoaTipo = $edital->pessoa_tipos_id;
$inscritos = $fomentoObj->listaInscritos($id, $pessoaTipo,$aprovado);

$linkStyle = [
    'font' => [
        'underline' => PHPExcel_Style_Font::UNDERLINE_SINGLE,
        'color' => ['rgb' => '17a2b8']
        ]
];

// Podemos renomear o nome das planilha atual, lembrando que um único arquivo pode ter várias planilhas
$objPHPExcel->getProperties()->setCreator("Sistema SisContrat");
$objPHPExcel->getProperties()->setLastModifiedBy("Sistema SisContrat");
$objPHPExcel->getProperties()->setTitle("Relatório de Inscritos $aprovados");
$objPHPExcel->getProperties()->setSubject("Relatório de Inscritos $aprovados");
$objPHPExcel->getProperties()->setDescription("Gerado automaticamente a partir do Sistema SisContrat");
$objPHPExcel->getProperties()->setKeywords("office 2007 openxml php");
$objPHPExcel->getProperties()->setCategory("Fomentos");

$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:H1')
    ->setCellValue("A1","Lista de Inscritos $aprovados Edital - $nomeEdital");

// Inicia Include
    if($pessoaTipo == 1) {
        include_once "./includes/fomento_inscritos_pf.php";
    } else {
        include_once "./includes/fomento_inscritos_pj.php";
    }
// Fim Include

$objPHPExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(-1);

$objPHPExcel->setActiveSheetIndex(0);
ob_end_clean();
ob_start();

$nome_arquivo = "inscritos_".$aprovados."_" . date("d-m-Y") . ".xls";


// Cabeçalho do arquivo para ele baixar(Excel2007)
header('Content-Type: text/html; charset=ISO-8859-1');
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="' . $nome_arquivo . '"');
header('Cache-Control: max-age=0');
// Se for o IE9, isso talvez seja necessário
header('Cache-Control: max-age=1');

// Acessamos o 'Writer' para poder salvar o arquivo
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');

// Salva diretamente no output, poderíamos mudar arqui para um nome de arquivo em um diretório ,caso não quisessemos jogar na tela
$objWriter->save('php://output');

exit;