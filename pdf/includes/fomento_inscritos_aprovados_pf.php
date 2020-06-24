<?php

// Criamos as colunas
$objPHPExcel->setActiveSheetIndex(0)
    ->setCellValue("A2", "Protocolo")
    ->setCellValue("B2", "Nome do Projeto")
    ->setCellValue("C2", "Nome do núcleo artístico/coletivo artístico")
    ->setCellValue("D2", "Nome do representante do núcleo")
    ->setCellValue("E2", "Nome do produtor independente")
    ->setCellValue("F2", "Valor do projeto")
    ->setCellValue("G2", "Duração")
    ->setCellValue("H2", "Nome Completo")
    ->setCellValue("I2", "CPF")
    ->setCellValue("J2", "Nome do Coletivo/Grupo")
    ->setCellValue("K2", "Data de Nascimento")
    ->setCellValue("L2", "E-mail")
    ->setCellValue("M2", "Telefone #1")
    ->setCellValue("N2", "Telefone #2")
    ->setCellValue("O2", "CEP")
    ->setCellValue("P2", "Rua")
    ->setCellValue("Q2", "Número")
    ->setCellValue("R2", "Bairro")
    ->setCellValue("S2", "Cidade")
    ->setCellValue("T2", "Estado");

// Definimos o estilo da fonte
$objPHPExcel->getActiveSheet()->getStyle('A2:T2')->getFont()->setBold(true);

//Colorir a primeira linha
$objPHPExcel->getActiveSheet()->getStyle('A2:T2')->applyFromArray
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
    $i = "I" . $cont;
    $j = "J" . $cont;
    $k = "K" . $cont;
    $l = "L" . $cont;
    $m = "M" . $cont;
    $n = "N" . $cont;
    $o = "O" . $cont;
    $p = "P" . $cont;
    $q = "Q" . $cont;
    $r = "R" . $cont;
    $s = "S" . $cont;
    $t = "T" . $cont;

    require_once "../controllers/PessoaFisicaController.php";
    $pessoaFisicaObj = new PessoaFisicaController();
    $pf = $pessoaFisicaObj->recuperaPessoaFisica($pessoaFisicaObj->encryption($inscrito->pessoa_fisica_id), true);

    $zip = SERVERURL."api/downloadInscritos.php?id=".$inscrito->id;

    $objPHPExcel->getActiveSheet()->getStyle($c)->getAlignment()->setWrapText(true);
    $objPHPExcel->getActiveSheet()->getStyle($f)->getNumberFormat()->setFormatCode("#,##0.00");

    $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue($a, $inscrito->protocolo)
        ->setCellValue($b, $inscrito->nome_projeto)
        ->setCellValue($c, $inscrito->nome_nucleo)
        ->setCellValue($d, $inscrito->representante_nucleo)
        ->setCellValue($e, $inscrito->coletivo_produtor)
        ->setCellValue($f, $inscrito->valor_projeto)
        ->setCellValue($g, $inscrito->duracao)
        ->setCellValue($h, $pf['nome'])
        ->setCellValue($i, $pf['cpf'])
        ->setCellValue($j, $pf[''])
        ->setCellValue($k, $pf[''])
        ->setCellValue($l, $pf[''])
        ->setCellValue($m, $pf[''])
        ->setCellValue($n, $pf[''])
        ->setCellValue($o, $pf[''])
        ->setCellValue($p, $pf[''])
        ->setCellValue($q, $pf[''])
        ->setCellValue($r, $pf[''])
        ->setCellValue($s, $pf[''])
        ->setCellValue($t, $pf['']);
    $objPHPExcel->getActiveSheet()->getCell($h)->getHyperlink()->setUrl($zip);
    $objPHPExcel->getActiveSheet()->getCell($h)->getStyle()->applyFromArray($linkStyle);

    $cont++;
}

// Renomeia a guia
$objPHPExcel->getActiveSheet()->setTitle('Inscritos Aprovados');

$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(40);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(30);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(40);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);