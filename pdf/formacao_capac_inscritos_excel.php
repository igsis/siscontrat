<?php
setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');

$pedidoAjax = true;
require_once "../config/configGeral.php";
require_once "../views/plugins/phpexcel/PHPExcel.php";
require_once "../controllers/FormacaoController.php";


$objPHPExcel = new PHPExcel();
$formacaoObj = new FormacaoController();

$ano = $_GET['ano'];

$dadosContratacoes = $formacaoObj->recuperaContratacao('', '', 1, $ano);
$nome_arquivo = "formacao_inscritos_capac" . $ano . ".xls";

// Podemos renomear o nome das planilha atual, lembrando que um único arquivo pode ter várias planilhas
$objPHPExcel->getProperties()->setCreator("Sistema SisContrat");
$objPHPExcel->getProperties()->setLastModifiedBy("Sistema SisContrat");
$objPHPExcel->getProperties()->setTitle("Relatório de Pedidos");
$objPHPExcel->getProperties()->setSubject("Relatório de Pedidos");
$objPHPExcel->getProperties()->setDescription("Gerado automaticamente a partir do Sistema SisContrat");
$objPHPExcel->getProperties()->setKeywords("office 2007 openxml php");
$objPHPExcel->getProperties()->setCategory("Formação");

$objPHPExcel->setActiveSheetIndex(0)
    ->setCellValue("A1", "Lista de Inscritos");

//Colorir o header
$objPHPExcel->getActiveSheet()->getStyle("A1:J1")->applyFromArray
(
    array
    (
        'fill' => array
        (
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('rgb' => '408000')
        ),
    )
);

$objPHPExcel->setActiveSheetIndex(0)
    ->setCellValue("A1")
    ->setCellValue("B1")
    ->setCellValue("C1")
    ->setCellValue("D1")
    ->setCellValue("E1")
    ->setCellValue("F1")
    ->setCellValue("G1")
    ->setCellValue("H1")
    ->setCellValue("I1")
    ->setCellValue("J1");

//ajustando tamanho do cabeçalho e centralizando o texto
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 1, "LISTA DE INSCRITOS");
$objPHPExcel->getActiveSheet()->getStyle('A1:I1')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->mergeCells('A1:J1');
$objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->applyFromArray(
    array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
          'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER)
);
$objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(40);

//criar colunas
$objPHPExcel->setActiveSheetIndex(0)
    ->setCellValue("A2", "Protocolo")
    ->setCellValue("B2", "Nome Completo")
    ->setCellValue("C2", "Programa")
    ->setCellValue("D2", "Cargo 1")
    ->setCellValue("E2", "Cargo (2º opção)")
    ->setCellValue("F2", "Cargo (3º opção)")
    ->setCellValue("G2", "Linguagem")
    ->setCellValue("H2", "E-mail")
    ->setCellValue("I2", "Telefone(s) do Proponente")
    ->setCellValue("J2", "Arquivos");

// Definimos o estilo da fonte das colunas
$objPHPExcel->getActiveSheet()->getStyle('A2:J2')->getFont()->setBold(true);

//define o tamanho de cada célula de cada coluna
$objPHPExcel->getActiveSheet()->getStyle('A2:J2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getRowDimension('2')->setRowHeight(30);
$objPHPExcel->getActiveSheet()->getStyle('A2:J2')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

//colorir as primeiras células de cada coluna
$objPHPExcel->getActiveSheet()->getStyle("A2:J2")->applyFromArray
(
    array
    (
        'fill' => array
        (
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('rgb' => '336700')
        ),
    )
);

//contador de linhas, utilizado para que os dados comecem a ser preenchidos na linha 3, logo após o cabeçalho e a linha de colunas
$contador = 3;

foreach ($dadosContratacoes as $dadosContratacao) {
    //recupera os telefones de cada pf
    $tel = $formacaoObj->recuperaTelPf($dadosContratacao->pessoa_fisica_id, '', '1');

    $a = "A" . $contador;
    $b = "B" . $contador;
    $c = "C" . $contador;
    $d = "D" . $contador;
    $e = "E" . $contador;
    $f = "F" . $contador;
    $g = "G" . $contador;
    $h = "H" . $contador;
    $i = "I" . $contador;
    $j = "J" . $contador;

    $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue($a, $dadosContratacao->protocolo)
        ->setCellValue($b, $dadosContratacao->nome)
        ->setCellValue($c, $dadosContratacao->programa)
        ->setCellValue($d, $dadosContratacao->cargo)
        ->setCellValue($e, $dadosContratacao->cargo2)
        ->setCellValue($f, $dadosContratacao->cargo3)
        ->setCellValue($g, $dadosContratacao->linguagem)
        ->setCellValue($h, $dadosContratacao->email)
        ->setCellValue($i, $tel)
        ->setCellValue($j, 'Download');

    $contador++;
}

//setando tamanho das colunas
for ($col = 'A'; $col !== 'J'; $col++) {
    $objPHPExcel->getActiveSheet()
        ->getColumnDimension($col)
        ->setAutoSize(true);
}

//Consertando a coluna referente ao telefone
$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(false);
$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(50);

//Consertando a coluna referente ao telefone
$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setAutoSize(false);
$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(30);

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