<?php
setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');

$pedidoAjax = true;
require_once "../config/configGeral.php";
require_once "../views/plugins/phpexcel/PHPExcel.php";
require_once "../controllers/FormacaoController.php";


$objPHPExcel = new PHPExcel();
$formacaoObj = new FormacaoController();

$ano = $_GET['ano'];
$programa = $_GET['programa'];

$dadosPedidos = $formacaoObj->recuperaPedido('', 1, $ano, $programa);
$nome_arquivo = "pedidos_formacao_" . $ano . ".xls";

// Podemos renomear o nome das planilha atual, lembrando que um único arquivo pode ter várias planilhas
$objPHPExcel->getProperties()->setCreator("Sistema SisContrat");
$objPHPExcel->getProperties()->setLastModifiedBy("Sistema SisContrat");
$objPHPExcel->getProperties()->setTitle("Relatório de Pedidos");
$objPHPExcel->getProperties()->setSubject("Relatório de Pedidos");
$objPHPExcel->getProperties()->setDescription("Gerado automaticamente a partir do Sistema SisContrat");
$objPHPExcel->getProperties()->setKeywords("office 2007 openxml php");
$objPHPExcel->getProperties()->setCategory("Formação");

$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:K1')
    ->setCellValue("A1","Lista de Pedidos da Formacação");

//Colorir o header
$objPHPExcel->getActiveSheet()->getStyle("A1:K1")->applyFromArray
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
    ->setCellValue("I1")
    ->setCellValue("J1")
    ->setCellValue("K1")
    ->setCellValue("L1")
    ->setCellValue("M1");

//ajustando tamanho do cabeçalho e centralizando o texto
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 1, "PEDIDOS DE CONTRATAÇÃO");
$objPHPExcel->getActiveSheet()->getStyle('A1:M1')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->mergeCells('A1:M1');
$objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->applyFromArray(
    array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER)
);
$objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(40);

//criar colunas
$objPHPExcel->setActiveSheetIndex(0)
    ->setCellValue("A2", "Protocolo")
    ->setCellValue("B2", "Número do Processo")
    ->setCellValue("C2", "Nome Completo")
    ->setCellValue("D2", "Endereço (Proponente)")
    ->setCellValue("E2", "CEP (Proponente)")
    ->setCellValue("F2", "E-mail")
    ->setCellValue("G2", "Telefone(s) do Proponente")
    ->setCellValue("H2", "Programa")
    ->setCellValue("I2", "Função")
    ->setCellValue("J2", "Linguagem")
    ->setCellValue("K2", "Local")
    ->setCellValue("L2", "Subprefeitura")
    ->setCellValue("M2", "Status do Pedido");

// Definimos o estilo da fonte das colunas
$objPHPExcel->getActiveSheet()->getStyle('A2:M2')->getFont()->setBold(true);

//define o tamanho de cada célula de cada coluna
$objPHPExcel->getActiveSheet()->getStyle('A2:M2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getRowDimension('2')->setRowHeight(30);
$objPHPExcel->getActiveSheet()->getStyle('A2:M2')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

//colorir as primeiras células de cada coluna
$objPHPExcel->getActiveSheet()->getStyle("A2:M2")->applyFromArray
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
    $tel = $formacaoObj->recuperaTelPf($dadosPedido->pessoa_fisica_id);

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
    $k = "K" . $contador;
    $l = "L" . $contador;
    $m = "M" . $contador;

    $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue($a, $dadosPedido->protocolo)
        ->setCellValue($b, $dadosPedido->numero_processo)
        ->setCellValue($c, $dadosPedido->nome)
        ->setCellValue($d, $dadosPedido->endereco)
        ->setCellValue($e, $dadosPedido->cep)
        ->setCellValue($f, $dadosPedido->email)
        ->setCellValue($g, $tel)
        ->setCellValue($h, $dadosPedido->programa)
        ->setCellValue($i, $dadosPedido->funcao)
        ->setCellValue($j, $dadosPedido->linguagem)
        ->setCellValue($k, $dadosPedido->local)
        ->setCellValue($l, $dadosPedido->subprefeitura)
        ->setCellValue($m, $dadosPedido->status);

    $contador++;
}

//setando tamanho das colunas
for ($col = 'A'; $col !== 'M'; $col++) {
    $objPHPExcel->getActiveSheet()
        ->getColumnDimension($col)
        ->setAutoSize(true);
}



//Consertando a coluna referente ao Endereço
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);

//Consertando a coluna referente ao telefone
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(false);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(50);

//Consertando a coluna referente ao status
$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setAutoSize(false);
$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(50);

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