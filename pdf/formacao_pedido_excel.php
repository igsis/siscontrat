<?php
setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');

$pedidoAjax = true;
require_once "../config/configGeral.php";
require_once "../views/plugins/phpexcel/PHPExcel.php";
require_once "../controllers/FormacaoController.php";


$objPHPExcel = new PHPExcel();
$formacaoObj = new FormacaoController();

$ano = $_GET['ano'];

$dadosPedidos = $formacaoObj->recuperaPedido('', 1, $ano);
$nome_arquivo = "pedidos_formacao_" . $ano . ".xls";

// Podemos renomear o nome das planilha atual, lembrando que um único arquivo pode ter várias planilhas
$objPHPExcel->getProperties()->setCreator("Sistema SisContrat");
$objPHPExcel->getProperties()->setLastModifiedBy("Sistema SisContrat");
$objPHPExcel->getProperties()->setTitle("Relatório de Inscritos Aprovados");
$objPHPExcel->getProperties()->setSubject("Relatório de Inscritos Aprovados");
$objPHPExcel->getProperties()->setDescription("Gerado automaticamente a partir do Sistema SisContrat");
$objPHPExcel->getProperties()->setKeywords("office 2007 openxml php");
$objPHPExcel->getProperties()->setCategory("Fomentos");

$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:H1')
    ->setCellValue("A1","Lista de Inscristos Edital ");

$objPHPExcel->setActiveSheetIndex(0)
    ->setCellValue("A1")
    ->setCellValue("B1")
    ->setCellValue("C1")
    ->setCellValue("D1")
    ->setCellValue("E1", "PEDIDO DE CONTRATAÇÃO")
    ->setCellValue("F1")
    ->setCellValue("G1");

//Colorir o header
$objPHPExcel->getActiveSheet()->getStyle("A1:I1")->applyFromArray
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

//ajustando tamanho do cabeçalho e centralizando o texto
$objPHPExcel->getActiveSheet()->getStyle('A' . '1' . ':G' . '1')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('A' . '1' . ':G' . '1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(40);
$objPHPExcel->getActiveSheet()->getStyle('A' . '1' . ':G' . '1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

//criar colunas
$objPHPExcel->setActiveSheetIndex(0)
    ->setCellValue("A2", "Protocolo")
    ->setCellValue("B2", "Número do Processo")
    ->setCellValue("C2", "Nome Completo")
    ->setCellValue("D2", "Programa")
    ->setCellValue("E2", "Função")
    ->setCellValue("F2", "Linguagem")
    ->setCellValue("G2", "E-mail")
    ->setCellValue("H2", "Telefone(s) do Proponente")
    ->setCellValue("I2", "Status do Pedido");

// Definimos o estilo da fonte das colunas
$objPHPExcel->getActiveSheet()->getStyle('A2:G2')->getFont()->setBold(true);

//define o tamanho de cada célula de cada coluna
$objPHPExcel->getActiveSheet()->getStyle('A' . '2' . ':I' . '2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getRowDimension('2')->setRowHeight(30);
$objPHPExcel->getActiveSheet()->getStyle('A' . '2' . ':I' . '2')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

//colorir as primeiras células de cada coluna
$objPHPExcel->getActiveSheet()->getStyle("A2:I2")->applyFromArray
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
foreach ($dadosPedidos AS $dadosPedido){
    //recupera os telefones de cada pf
    $tel = $formacaoObj->recuperaTelPf($dadosPedido->id);

    $a = "A" . $contador;
    $b = "B" . $contador;
    $c = "C" . $contador;
    $d = "D" . $contador;
    $e = "E" . $contador;
    $f = "F" . $contador;
    $g = "G" . $contador;
    $h = "H" . $contador;
    $i = "I" . $contador;

    $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue($a, $dadosPedido->protocolo)
        ->setCellValue($b, $dadosPedido->numero_processo)
        ->setCellValue($c, $dadosPedido->nome)
        ->setCellValue($d, $dadosPedido->programa)
        ->setCellValue($e, $dadosPedido->funcao)
        ->setCellValue($f, $dadosPedido->linguagem)
        ->setCellValue($g, $dadosPedido->email)
        ->setCellValue($h, $tel)
        ->setCellValue($i, $dadosPedido->status);

    $contador++;
}

//setando tamanho das colunas
for ($col = 'A'; $col !== 'I'; $col++) {
    $objPHPExcel->getActiveSheet()
        ->getColumnDimension($col)
        ->setAutoSize(true);
}

//Consertando a coluna referente ao telefone
$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(false);
$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(125);

//Consertando a coluna referente ao status
$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(false);
$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(50);

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