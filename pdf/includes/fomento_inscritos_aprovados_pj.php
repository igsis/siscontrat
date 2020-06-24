<?php

// Criamos as colunas
$objPHPExcel->setActiveSheetIndex(0)
    ->setCellValue("A2", "Nome do Projeto")
    ->setCellValue("B2", "Nome do coletivo artístico")
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
        $pf = $pessoaFisicaObj->recuperaPessoaFisica($pessoaFisicaObj->encryption($inscrito->pessoa_fisica_id));
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

    $zip = SERVERURL."api/downloadInscritos.php?id=".$inscrito->id;

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