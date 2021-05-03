<?php
/** @var PHPExcel $objPHPExcel */
/** @var FomentoController $fomentoObj */
/** @var object $inscritos */
/** @var int $tipo_contratacao */

//Colorir o header

$objPHPExcel->getActiveSheet()->getStyle("A1:AB1")->applyFromArray
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
    ->setCellValue("D2", "Responsável pela inscrição")
    ->setCellValue("E2", "Valor do projeto")
    ->setCellValue("F2", "Duração")
    ->setCellValue("G2", "Nome do núcleo artístico/coletivo artístico")
    ->setCellValue("H2", "Nome do representante do núcleo")
    ->setCellValue("I2", "Nome do produtor independente")
    ->setCellValue("J2", "Integrantes de Núcleo")
    ->setCellValue("K2", "Nome Completo")
    ->setCellValue("L2", "CPF")
    ->setCellValue("M2", "Genero")
    ->setCellValue("N2", "Raça ou Cor")
    ->setCellValue("O2", "Data de Nascimento")
    ->setCellValue("P2", "Rede Social")
    ->setCellValue("Q2", "Escolaridade")
    ->setCellValue("R2", "E-mail")
    ->setCellValue("S2", "Telefone #1")
    ->setCellValue("T2", "Telefone #2")
    ->setCellValue("U2", "CEP")
    ->setCellValue("V2", "Rua")
    ->setCellValue("W2", "Número")
    ->setCellValue("X2", "Bairro")
    ->setCellValue("Y2", "Cidade")
    ->setCellValue("Z2", "Estado")
    ->setCellValue("AA2", "Subprefeitura");

if ($tipo_contratacao == 24) {
    $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue("AB2", "Area de Inscrição")
        ->setCellValue("AC2", "Anexos");
    $celulas = "A2:AC2";
} else {
    $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue("AB2", "Anexos");
    $celulas = "A2:AB2";
}

// Definimos o estilo da fonte
$objPHPExcel->getActiveSheet()->getStyle($celulas)->getFont()->setBold(true);

//Colorir a primeira linha
$objPHPExcel->getActiveSheet()->getStyle($celulas)->applyFromArray
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
    $ab = "AB" . $cont;
    if ($tipo_contratacao == 24) {
        $ac = "AC" . $cont;
    }

    require_once "../controllers/PessoaFisicaController.php";
    $pessoaFisicaObj = new PessoaFisicaController();
    $pf = $pessoaFisicaObj->recuperaPessoaFisica($pessoaFisicaObj->encryption($inscrito->pessoa_fisica_id), true);
    $usuario = $pessoaFisicaObj->consultaSimples("SELECT nome FROM `usuarios` WHERE `id` = $inscrito->usuario_id", true)->fetchColumn();
    $pfDados = $pessoaFisicaObj->recuperaPfDados($pf->id)->fetchObject();

    $zip = SERVERURL."api/downloadInscritos.php?id=".$inscrito->id;

    $objPHPExcel->getActiveSheet()->getStyle($j)->getAlignment()->setWrapText(true);

    $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue($a, $inscrito->protocolo)
        ->setCellValue($b, $fomentoObj->dataHora($inscrito->data_inscricao))
        ->setCellValue($c, $inscrito->nome_projeto)
        ->setCellValue($d, $usuario)
        ->setCellValue($e, $fomentoObj->dinheiroParaBr($inscrito->valor_projeto))
        ->setCellValue($f, $inscrito->duracao)
        ->setCellValue($g, $inscrito->nome_nucleo)
        ->setCellValue($h, $inscrito->representante_nucleo)
        ->setCellValue($i, $inscrito->coletivo_produtor)
        ->setCellValue($j, $inscrito->nucleo_artistico)
        ->setCellValue($k, $pf->nome)
        ->setCellValue($l, $pf->cpf)
        ->setCellValue($m, $pfDados->genero)
        ->setCellValue($n, $pfDados->descricao)
        ->setCellValue($o, $fomentoObj->dataParaBR($pf->data_nascimento))
        ->setCellValue($p, $pfDados->rede_social)
        ->setCellValue($q, $pfDados->grau_instrucao)
        ->setCellValue($r, $pf->email)
        ->setCellValue($s, $pf->telefones['tel_0'])
        ->setCellValue($t, $pf->telefones['tel_1'])
        ->setCellValue($u, $pf->cep)
        ->setCellValue($v, $pf->logradouro)
        ->setCellValue($w, $pf->numero)
        ->setCellValue($x, $pf->bairro)
        ->setCellValue($y, $pf->cidade)
        ->setCellValue($z, $pf->uf)
        ->setCellValue($aa,$pfDados->subprefeitura);

    if ($tipo_contratacao == 24) {
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue($ab, $inscrito->area)
            ->setCellValue($ac, 'download');
    } else {
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue($ab, 'download');
    }

    if ($tipo_contratacao == 24) {
        $objPHPExcel->getActiveSheet()->getCell($ac)->getHyperlink()->setUrl($zip);
        $objPHPExcel->getActiveSheet()->getCell($ac)->getStyle()->applyFromArray($linkStyle);
    } else {
        $objPHPExcel->getActiveSheet()->getCell($ab)->getHyperlink()->setUrl($zip);
        $objPHPExcel->getActiveSheet()->getCell($ab)->getStyle()->applyFromArray($linkStyle);
    }

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
$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(50);
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
$objPHPExcel->getActiveSheet()->getColumnDimension('AB')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('AC')->setAutoSize(true);