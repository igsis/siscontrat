<?php
setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');

$pedidoAjax = true;
require_once "../config/configGeral.php";
require_once "../views/plugins/phpexcel/PHPExcel.php";
require_once "../controllers/FormacaoController.php";

$objPHPExcel = new PHPExcel();
$formacaoObj = new FormacaoController();

$ano = $_GET['ano'];

$dadosContratacoes = $formacaoObj->consultaSimples("SELECT fc.id AS 'contratacao_id', fc.protocolo, pf.nome, pf.email, pf.cpf, pf.passaporte, pf.data_nascimento,
                                                                    fc.form_cargo_id, fca.form_cargo2_id, fca.form_cargo3_id, fc.linguagem_id, 
                                                                    e.descricao AS 'etnia', r.regiao, det.trans, det.pcd
                                                             FROM form_cadastros AS fc
		                                                     LEFT JOIN form_cargos_adicionais AS fca ON fc.id = fca.form_cadastro_id
                                                             LEFT JOIN pessoa_fisicas AS pf ON pf.id = fc.pessoa_fisica_id
                                                             LEFT JOIN pf_detalhes AS det ON det.pessoa_fisica_id = fc.pessoa_fisica_id
                                                             LEFT JOIN etnias AS e ON e.id = det.etnia_id
                                                             LEFT JOIN regiaos AS r ON fc.regiao_preferencial_id = r.id
                                                             WHERE fc.ano = $ano AND fc.publicado = 1 AND fc.protocolo IS NOT NULL", TRUE)->fetchAll(PDO::FETCH_OBJ);
if(count($dadosContratacoes) != NULL){
    foreach ($dadosContratacoes AS $key=>$dadosContratacao){
        $dadosContratacoes[$key]->cargo1 = $formacaoObj->consultaSimples("SELECT cargo FROM formacao_cargos WHERE id = '{$dadosContratacao->form_cargo_id}'")->fetchColumn();
        $dadosContratacoes[$key]->cargo2 = $formacaoObj->consultaSimples("SELECT cargo FROM formacao_cargos WHERE id = '{$dadosContratacao->form_cargo2_id}'")->fetchColumn();
        $dadosContratacoes[$key]->cargo3 = $formacaoObj->consultaSimples("SELECT cargo FROM formacao_cargos WHERE id = '{$dadosContratacao->form_cargo3_id}'")->fetchColumn();
        $dadosContratacoes[$key]->linguagem = $formacaoObj->consultaSimples("SELECT linguagem FROM linguagens WHERE id = '{$dadosContratacao->linguagem_id}'")->fetchColumn();
    }
}

$nome_arquivo = "formacao_inscritos_capac_" . $ano . ".xls";

$linkStyle = [
    'font' => [
        'underline' => PHPExcel_Style_Font::UNDERLINE_SINGLE,
        'color' => ['rgb' => '17a2b8']
    ]
];

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
$objPHPExcel->getActiveSheet()->getStyle("A1:N1")->applyFromArray
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
    ->setCellValue("J1")
    ->setCellValue("K1")
    ->setCellValue("L1")
    ->setCellValue("M1")
    ->setCellValue("N1");

//ajustando tamanho do cabeçalho e centralizando o texto
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 1, "LISTA DE INSCRITOS");
$objPHPExcel->getActiveSheet()->getStyle('A1:N1')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->mergeCells('A1:N1');
$objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->applyFromArray(
    array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER)
);
$objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(40);

//criar colunas
$objPHPExcel->setActiveSheetIndex(0)
    ->setCellValue("A2", "Nº Inscrição")
    ->setCellValue("B2", "Nome")
    ->setCellValue("C2", "CPF/Passaporte")
    ->setCellValue("D2", "E-mail")
    ->setCellValue("E2", "Data de Nascimento")
    ->setCellValue("F2", "Função (1ª opção)")
    ->setCellValue("G2", "Função (2º opção)")
    ->setCellValue("H2", "Função (3º opção)")
    ->setCellValue("I2", "Linguagem")
    ->setCellValue("J2", "Etnia")
    ->setCellValue("K2", "Região preferencial")
    ->setCellValue("L2", "Trans")
    ->setCellValue("M2", "PCD")
    ->setCellValue("N2", "Arquivos");

// Definimos o estilo da fonte das colunas
$objPHPExcel->getActiveSheet()->getStyle('A2:N2')->getFont()->setBold(true);

//define o tamanho de cada célula de cada coluna
$objPHPExcel->getActiveSheet()->getStyle('A2:N2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getRowDimension('2')->setRowHeight(30);
$objPHPExcel->getActiveSheet()->getStyle('A2:N2')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

//colorir as primeiras células de cada coluna
$objPHPExcel->getActiveSheet()->getStyle("A2:N2")->applyFromArray
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

foreach ($dadosContratacoes AS $dadosContratacao) {

    $contratacao_id = $dadosContratacao->contratacao_id;

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

    $testa = DbModel::consultaSimples("SELECT * FROM form_arquivos WHERE form_cadastro_id = $contratacao_id AND publicado = 1", TRUE)->rowCount();
    if ($testa > 0):
        $zip = SERVERURL . "api/downloadInscritos.php?id=" . $contratacao_id . "&formacao=1";
        $objPHPExcel->getActiveSheet()->getCell($n)->getHyperlink()->setUrl($zip);
        $objPHPExcel->getActiveSheet()->getCell($n)->getStyle()->applyFromArray($linkStyle);
        $texto = "Download";
    else:
        $texto = "Não possuí anexos";
    endif;

    $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue($a, $dadosContratacao->protocolo)
        ->setCellValue($b, $dadosContratacao->nome)
        ->setCellValue($c, $dadosContratacao->cpf == NULL ? $dadosContratacao->passaporte : $dadosContratacao->cpf)
        ->setCellValue($d, $dadosContratacao->email)
        ->setCellValue($e, $formacaoObj->dataParaBR($dadosContratacao->data_nascimento))
        ->setCellValue($f, $dadosContratacao->cargo1)
        ->setCellValue($g, $dadosContratacao->cargo2)
        ->setCellValue($h, $dadosContratacao->cargo3)
        ->setCellValue($i, $dadosContratacao->linguagem)
        ->setCellValue($j, $dadosContratacao->etnia)
        ->setCellValue($k, $dadosContratacao->regiao)
        ->setCellValue($l, $dadosContratacao->trans == 1 ? "SIM" : "NÃO")
        ->setCellValue($m, $dadosContratacao->pcd == 1 ? "SIM" : "NÃO")
        ->setCellValue($n, $texto);

    $contador++;
}

//setando tamanho das colunas
for ($col = 'A'; $col !== 'N'; $col++) {
    $objPHPExcel->getActiveSheet()
        ->getColumnDimension($col)
        ->setAutoSize(true);
}

//Consertando a coluna referente aos arquivos
$objPHPExcel->getActiveSheet()->getColumnDimension('N')->setAutoSize(false);
$objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(30);

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