<?php

//Colorir o header
$objPHPExcel->getActiveSheet()->getStyle("A1:AC1")->applyFromArray
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
    ->setCellValue("M2", "CPF")
    ->setCellValue("N2", "Genero")
    ->setCellValue("O2", "Raça ou Cor")
    ->setCellValue("P2", "Data de Nascimento")
    ->setCellValue("Q2", "Rede Social")
    ->setCellValue("R2", "Escolaridade")
    ->setCellValue("S2", "E-mail")
    ->setCellValue("T2", "Telefone #1")
    ->setCellValue("U2", "Telefone #2")
    ->setCellValue("V2", "CEP")
    ->setCellValue("W2", "Rua")
    ->setCellValue("X2", "Número")
    ->setCellValue("Y2", "Bairro")
    ->setCellValue("Z2", "Cidade")
    ->setCellValue("AA2", "Estado")
    ->setCellValue("AB2", "Subprefeitura")
    ->setCellValue("AC2", "Anexos");

// Definimos o estilo da fonte
$objPHPExcel->getActiveSheet()->getStyle('A2:AC2')->getFont()->setBold(true);

//Colorir a primeira linha
$objPHPExcel->getActiveSheet()->getStyle('A2:AC2')->applyFromArray
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
    $ac = "AC" . $cont;

    require_once "../controllers/PessoaFisicaController.php";
    $pessoaFisicaObj = new PessoaFisicaController();
    $pf = $pessoaFisicaObj->recuperaPessoaFisica($pessoaFisicaObj->encryption($inscrito->pessoa_fisica_id), true);
    $usuario = $pessoaFisicaObj->consultaSimples("SELECT nome FROM `usuarios` WHERE `id` = $inscrito->usuario_id", true)->fetchColumn();

    $sqlpfDados = "SELECT pfd.nome_grupo, pfd.rede_social, g.genero, s.subprefeitura, e.descricao, gi.grau_instrucao FROM `fom_pf_dados` AS pfd
                    INNER JOIN generos g on pfd.genero_id = g.id
                    INNER JOIN subprefeituras s on pfd.subprefeitura_id = s.id
                    INNER JOIN etnias e on pfd.etnia_id = e.id
                    INNER JOIN grau_instrucoes gi on pfd.grau_instrucao_id = gi.id
                    WHERE pessoa_fisicas_id = {$pf['id']}";
    $pfDados = $pessoaFisicaObj->consultaSimples($sqlpfDados, true)->fetchObject();

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
        ->setCellValue($k, $pf['nome'])
        ->setCellValue($m, $pf['cpf'])
        ->setCellValue($n, $pfDados->genero)
        ->setCellValue($o, $pfDados->descricao)
        ->setCellValue($p, $fomentoObj->dataParaBR($pf['data_nascimento']))
        ->setCellValue($q, $pfDados->rede_social)
        ->setCellValue($r, $pfDados->grau_instrucao)
        ->setCellValue($s, $pf['email'])
        ->setCellValue($t, $pf['telefones']['tel_0'])
        ->setCellValue($u, $pf['telefones']['tel_1'])
        ->setCellValue($v, $pf['cep'])
        ->setCellValue($w, $pf['logradouro'])
        ->setCellValue($x, $pf['numero'])
        ->setCellValue($y, $pf['bairro'])
        ->setCellValue($z, $pf['cidade'])
        ->setCellValue($aa, $pf['uf'])
        ->setCellValue($ab,$pfDados->subprefeitura)
        ->setCellValue($ac, 'download');


    $objPHPExcel->getActiveSheet()->getCell($ac)->getHyperlink()->setUrl($zip);
    $objPHPExcel->getActiveSheet()->getCell($ac)->getStyle()->applyFromArray($linkStyle);

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
$objPHPExcel->getActiveSheet()->getColumnDimension('AB')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('AC')->setAutoSize(true);