<?php

//Colorir o header
$objPHPExcel->getActiveSheet()->getStyle("A1:AA1")->applyFromArray
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
    ->setCellValue("A2", "Protocolo")
    ->setCellValue("B2", "Data de Inscrição")
    ->setCellValue("C2", "Nome do Projeto")
    ->setCellValue("D2", "Instituição Responsável")
    ->setCellValue("E2", "Site")
    ->setCellValue("F2", "Responsável pela inscrição")
    ->setCellValue("G2", "Valor do projeto")
    ->setCellValue("H2", "Duração")
    ->setCellValue("I2", "Nome do núcleo artístico/coletivo artístico")
    ->setCellValue("J2", "Nome do representante do núcleo")
    ->setCellValue("K2", "Nome do produtor independente")
    ->setCellValue("L2", "Integrantes de Núcleo")
    ->setCellValue("M2", "Razão Social")
    ->setCellValue("N2", "CNPJ")
    ->setCellValue("O2", "E-mail")
    ->setCellValue("P2", "Representante Legal da Empresa")
    ->setCellValue("Q2", "RG do Representante Legal")
    ->setCellValue("R2", "CPF do Representante Legal")
    ->setCellValue("S2", "Telefone #1")
    ->setCellValue("T2", "Telefone #2")
    ->setCellValue("U2", "CEP")
    ->setCellValue("V2", "Rua")
    ->setCellValue("W2", "Número")
    ->setCellValue("X2", "Bairro")
    ->setCellValue("Y2", "Cidade")
    ->setCellValue("Z2", "Estado")
    ->setCellValue("AA2", "Anexos");

// Definimos o estilo da fonte
$objPHPExcel->getActiveSheet()->getStyle('A2:AA2')->getFont()->setBold(true);

//Colorir a primeira linha
$objPHPExcel->getActiveSheet()->getStyle('A2:AA2')->applyFromArray
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
    $u = "U" . $cont;
    $v = "V" . $cont;
    $w = "W" . $cont;
    $x = "X" . $cont;
    $y = "Y" . $cont;
    $z = "Z" . $cont;
    $aa = "AA" . $cont;

    require_once "../controllers/PessoaJuridicaController.php";
    require_once "../controllers/RepresentanteController.php";
    $pessoaJuridicaObj = new PessoaJuridicaController();
    $repObj = new RepresentanteController();
    $pj = $pessoaJuridicaObj->recuperaPessoaJuridica($pessoaJuridicaObj->encryption($inscrito->pessoa_juridica_id), true);
    $rep = $repObj->recuperaRepresentante($pessoaJuridicaObj->encryption($pj['representante_legal1_id']), true)->fetch();
    $dadosComp = $pessoaJuridicaObj->consultaSimples("SELECT * FROM fom_projeto_dado_pjs WHERE fom_projeto_id = $inscrito->id", true)->fetchObject();
    $usuario = $pessoaJuridicaObj->consultaSimples("SELECT nome FROM `usuarios` WHERE `id` = $inscrito->usuario_id", true)->fetchColumn();

    $zip = SERVERURL."api/downloadInscritos.php?id=".$inscrito->id;

    $objPHPExcel->getActiveSheet()->getStyle($l)->getAlignment()->setWrapText(true);

    $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue($a, $inscrito->protocolo)
        ->setCellValue($b, $fomentoObj->dataHora($inscrito->data_inscricao))
        ->setCellValue($c, $inscrito->nome_projeto)
        ->setCellValue($d, $dadosComp->instituicao)
        ->setCellValue($e, $dadosComp->site)
        ->setCellValue($f, $usuario)
        ->setCellValue($g, $fomentoObj->dinheiroParaBr($inscrito->valor_projeto))
        ->setCellValue($h, $inscrito->duracao)
        ->setCellValue($i, $inscrito->nome_nucleo)
        ->setCellValue($j, $inscrito->representante_nucleo)
        ->setCellValue($k, $inscrito->coletivo_produtor)
        ->setCellValue($l, $inscrito->nucleo_artistico)
        ->setCellValue($m, $pj['razao_social'])
        ->setCellValue($n, $pj['cnpj'])
        ->setCellValue($o, $pj['email'])
        ->setCellValue($p, $rep['nome'])
        ->setCellValue($q, $rep['rg'])
        ->setCellValue($r, $rep['cpf'])
        ->setCellValue($s, $pj['telefones']['tel_0'])
        ->setCellValue($t, $pj['telefones']['tel_1'] ?? "Não Cadastrado")
        ->setCellValue($u, $pj['cep'])
        ->setCellValue($v, $pj['logradouro'])
        ->setCellValue($w, $pj['numero'])
        ->setCellValue($x, $pj['bairro'])
        ->setCellValue($y, $pj['cidade'])
        ->setCellValue($z, $pj['uf'])
        ->setCellValue($aa, 'download');


    $objPHPExcel->getActiveSheet()->getCell($aa)->getHyperlink()->setUrl($zip);
    $objPHPExcel->getActiveSheet()->getCell($aa)->getStyle()->applyFromArray($linkStyle);

    $cont++;
}

// Renomeia a guia
$objPHPExcel->getActiveSheet()->setTitle('Inscritos Aprovados');

$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(40);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(30);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(40);;
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('N')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('O')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('P')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('R')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('S')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('T')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('U')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('V')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('W')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('X')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('Y')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('Z')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('AA')->setAutoSize(true);
