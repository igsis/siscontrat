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
$nome_arquivo = "pedidos_formacao_" . $ano . "_" . date("his") . ".xls";

// Podemos renomear o nome das planilha atual, lembrando que um único arquivo pode ter várias planilhas
$objPHPExcel->getProperties()->setCreator("Sistema SisContrat");
$objPHPExcel->getProperties()->setLastModifiedBy("Sistema SisContrat");
$objPHPExcel->getProperties()->setTitle("Relatório de Pedidos");
$objPHPExcel->getProperties()->setSubject("Relatório de Pedidos");
$objPHPExcel->getProperties()->setDescription("Gerado automaticamente a partir do Sistema SisContrat");
$objPHPExcel->getProperties()->setKeywords("office 2007 openxml php");
$objPHPExcel->getProperties()->setCategory("Formação");

$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:M1')
    ->setCellValue("A1","Lista de Pedidos da Formacação");

//Colorir o header
$objPHPExcel->getActiveSheet()->getStyle("A1:M1")->applyFromArray
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
    ->setCellValue("M1")
    ->setCellValue("N1")
    ->setCellValue("O1")
    ->setCellValue("P1");

//ajustando tamanho do cabeçalho e centralizando o texto
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 1, "PEDIDOS DE CONTRATAÇÃO");
$objPHPExcel->getActiveSheet()->getStyle('A1:P1')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->mergeCells('A1:P1');
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
    ->setCellValue("D2", "Gênero")
    ->setCellValue("E2", "Pessoa Trans")
    ->setCellValue("F2", "PCD")
    ->setCellValue("G2", "Endereço (Proponente)")
    ->setCellValue("H2", "CEP (Proponente)")
    ->setCellValue("I2", "E-mail")
    ->setCellValue("J2", "Telefone(s) do Proponente")
    ->setCellValue("K2", "Programa")
    ->setCellValue("L2", "Função")
    ->setCellValue("M2", "Linguagem")
    ->setCellValue("N2", "Local")
    ->setCellValue("O2", "Subprefeituras")
    ->setCellValue("P2", "Status do Pedido");

// Definimos o estilo da fonte das colunas
$objPHPExcel->getActiveSheet()->getStyle('A2:P2')->getFont()->setBold(true);

//define o tamanho de cada célula de cada coluna
$objPHPExcel->getActiveSheet()->getStyle('A2:P2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getRowDimension('2')->setRowHeight(30);
$objPHPExcel->getActiveSheet()->getStyle('A2:P2')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

//colorir as primeiras células de cada coluna
$objPHPExcel->getActiveSheet()->getStyle("A2:P2")->applyFromArray
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
    $subprefeituras = $formacaoObj->recuperaSubprefeituraContratacao($dadosPedido->origem_id);

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
    $n = "N" . $contador;
    $o = "O" . $contador;
    $p = "P" . $contador;

    $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue($a, $dadosPedido->protocolo)
        ->setCellValue($b, $dadosPedido->numero_processo)
        ->setCellValue($c, $dadosPedido->nome)
        ->setCellValue($d, $dadosPedido->genero)
        ->setCellValue($e, $dadosPedido->trans ? 'Sim' : 'Não')
        ->setCellValue($f, $dadosPedido->pcd ? 'Sim' : 'Não')
        ->setCellValue($g, $dadosPedido->endereco)
        ->setCellValue($h, $dadosPedido->cep)
        ->setCellValue($i, $dadosPedido->email)
        ->setCellValue($j, $tel)
        ->setCellValue($k, $dadosPedido->programa)
        ->setCellValue($l, $dadosPedido->funcao)
        ->setCellValue($m, $dadosPedido->linguagem)
        ->setCellValue($n, $dadosPedido->local)
        ->setCellValue($o, $subprefeituras)
        ->setCellValue($p, $dadosPedido->status);

    $contador++;
}

//setando tamanho das colunas
for ($col = 'A'; $col !== 'P'; $col++) {
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

//Consertando a coluna referente ao Subprefeitura
$objPHPExcel->getActiveSheet()->getColumnDimension('O')->setAutoSize(false);
$objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(50);

//Consertando a coluna referente ao status
$objPHPExcel->getActiveSheet()->getColumnDimension('P')->setAutoSize(false);
$objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(50);

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