<?php
setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');

$pedidoAjax = true;
require_once "../config/configGeral.php";
require_once "../views/plugins/phpexcel/PHPExcel.php";
require_once "../controllers/FomentoController.php";
require_once "../controllers/ArquivoController.php";

$id = $_GET['id'];

$objPHPExcel = new PHPExcel();
$fomentoObj = new FomentoController();
$arqObj = new ArquivoController();

$nomeEdital = $fomentoObj->recuperaEdital($id)->titulo;
$inscritos = $fomentoObj->listaInscritos($id);

// Podemos renomear o nome das planilha atual, lembrando que um único arquivo pode ter várias planilhas
$objPHPExcel->getProperties()->setCreator("Sistema SisContrat");
$objPHPExcel->getProperties()->setLastModifiedBy("Sistema SisContrat");
$objPHPExcel->getProperties()->setTitle("Relatório de Inscritos");
$objPHPExcel->getProperties()->setSubject("Relatório de Inscritos");
$objPHPExcel->getProperties()->setDescription("Gerado automaticamente a partir do Sistema SisContrat");
$objPHPExcel->getProperties()->setKeywords("office 2007 openxml php");
$objPHPExcel->getProperties()->setCategory("Fomentos");

$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:H1')
    ->setCellValue("A1","Lista de Inscristos Edital - $nomeEdital");

//Colorir o header
$objPHPExcel->getActiveSheet()->getStyle("A1:H1")->applyFromArray
(
    array
    (
        'fill' => array
        (
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('rgb' => '3c8dbc')
        ),
    )
);


// Criamos as colunas
$objPHPExcel->setActiveSheetIndex(0)
    ->setCellValue("A2", "CNPJ")
    ->setCellValue("B2", "Protocolo")
    ->setCellValue("C2", "Responsável pelo núcleo artístico")
    ->setCellValue("D2", "Representante legal da empresa")
    ->setCellValue("E2", "Razão social / Proponente")
    ->setCellValue("F2", "Valor do projeto")
    ->setCellValue("G2", "Duração")
    ->setCellValue("H2", "Arquivos");

// Definimos o estilo da fonte
$objPHPExcel->getActiveSheet()->getStyle('A2:H2')->getFont()->setBold(true);

//Colorir a primeira linha
$objPHPExcel->getActiveSheet()->getStyle('A2:H2')->applyFromArray
(
    array
    (
        'fill' => array
        (
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('rgb' => 'E0EEEE')
        ),
    )
);


$cont = 3;

foreach ($inscritos as $inscrito){
    $a = "A" . $cont;
    $b = "B" . $cont;
    $c = "C" . $cont;
    $d = "D" . $cont;
    $e = "E" . $cont;
    $f = "F" . $cont;
    $g = "G" . $cont;
    $h = "H" . $cont;

    if($inscrito->pessoa_tipo_id == 1){
        require_once "../controllers/PessoaFisicaController.php";
        $pessoaFisicaObj = new PessoaFisicaController();
        $pf = $pessoaFisicaObj->recuperaPessoaFisica($inscrito->pessoa_fisica_id)->fetch();
        $proponente = $pf['nome'];
        $documento = $pf['cpf'];
        $nomeRep = "não aplicável";
    } else{
        require_once "../controllers/PessoaJuridicaController.php";
        require_once "../controllers/RepresentanteController.php";
        $pessoaJuridicaObj = new PessoaJuridicaController();
        $repObj = new RepresentanteController();
        $pj = $pessoaJuridicaObj->recuperaPessoaJuridica($pessoaJuridicaObj->encryption($inscrito->pessoa_juridica_id));
        $rep = $repObj->recuperaRepresentante($pessoaJuridicaObj->encryption($pj['representante_legal1_id']))->fetch();
        $proponente = $pj['razao_social'];
        $documento = $pj['cnpj'];
        $nomeRep = $rep['nome'];
    }

    $zip = SERVERURL."/api/downloadInscritos&id=".$inscrito->id;

    $objPHPExcel->getActiveSheet()->getStyle($c)->getAlignment()->setWrapText(true);
    $objPHPExcel->getActiveSheet()->getStyle($f)->getNumberFormat()->setFormatCode("#,##0.00");

    $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue($a, $documento)
        ->setCellValue($b, $inscrito->protocolo)
        ->setCellValue($c, $inscrito->nucleo_artistico)
        ->setCellValue($d, $nomeRep)
        ->setCellValue($e, $proponente)
        ->setCellValue($f, $inscrito->valor_projeto)
        ->setCellValue($g, $inscrito->duracao)
        ->setCellValue($h, 'download');
    $objPHPExcel->getActiveSheet()->getCell($h)->getHyperlink()->setUrl($zip);

    $cont++;
}

// Renomeia a guia
$objPHPExcel->getActiveSheet()->setTitle('Inscritos');

$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(40);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(30);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(40);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);

$objPHPExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(-1);

$objPHPExcel->setActiveSheetIndex(0);
ob_end_clean();
ob_start();

$nome_arquivo = "inscritos_" . date("d-m-Y") . ".xls";


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