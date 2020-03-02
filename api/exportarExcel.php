<?php
$pedidoAjax = true;
require_once "../config/configGeral.php";
require_once "../controllers/FomentoController.php";
require_once "../controllers/PessoaJuridicaController.php";
require_once "../controllers/RepresentanteController.php";
require_once "../controllers/ArquivoController.php";

$id = $_GET['id'];

$fomentoObj = new FomentoController();
$pessoaJuridicaObj = new PessoaJuridicaController();
$repObj = new RepresentanteController();
$arqObj = new ArquivoController();

$nomeEdital = $fomentoObj->recuperaEdital($id)->titulo;
$inscritos = $fomentoObj->listaInscritos($id);

$data = date('YmdHis');


$nomeArquivoEx = "inscritos_".$data.".xls";

$html = "<html xmlns:x='urn:schemas-microsoft-com:office:excel'>";
$html .= "<head>";
$html .= "<meta http-equiv='content-type' content='text/plain; charset=UTF-8'/>";
$html .= "<xml>
            <x:ExcelWorkbook>
                <x:ExcelWorksheets>
                    <x:ExcelWorksheet>
                        <x:Name>Inscritos</x:Name>
                        <x:WorksheetOptions>
                            <x:DisplayGridlines/>
                        </x:WorksheetOptions>
                    </x:ExcelWorksheet>
                </x:ExcelWorksheets>
            </x:ExcelWorkbook>
        </xml>";
$html .= "</head>";
$html .= "<body>";
$html .= "<style>tr td{border: 1px solid black}</style>";
$html .= "<table border='1'>";
$html .= "<tr>";
$html .= "<td colspan='8'>Lista de Inscristos Edital - $nomeEdital</tr>";
$html .= "</tr>";
$html .= "<tr>";
$html .= "<td width='230'><b>CNPJ</b></td>";
$html .= "<td width='230'><b>Protocolo</b></td>";
$html .= "<td width='230'><b>Responsável pelo Núcleo Artístico</b></td>";
$html .= "<td width='230'><b>Representante Legal da Pessoa Jurídica</b></td>";
$html .= "<td width='230'><b>Razão Social da Pessoa Jurídica Proponente</b></td>";
$html .= "<td width='230'><b>Valor do Projeto</b></td>";
$html .= "<td width='230'><b>Duração </b></td>";
$html .= "<td width='230'><b>Arquivos </b></td>";
$html .= "</tr>";
foreach ($inscritos as $inscrito){
    $pj = $pessoaJuridicaObj->recuperaPessoaJuridica(MainModel::encryption($inscrito->pessoa_juridica_id), true);
    $repre = $repObj->recuperaRepresentante(MainModel::encryption($pj['representante_legal1_id']))->fetch(PDO::FETCH_ASSOC);
    $projeto = $fomentoObj->recuperaProjeto($id);
    $tipo_contratacao_id = $fomentoObj->recuperaTipoContratacao((string)MainModel::encryption($projeto['fom_edital_id']));
    $lista_documento_ids = $arqObj->recuperaIdListaDocumento(MainModel::encryption($projeto['fom_edital_id']), true)->fetchAll(PDO::FETCH_COLUMN);

    $arqEnviados = $arqObj->listarArquivosEnviados(MainModel::encryption($projeto['id']), $lista_documento_ids, $tipo_contratacao_id)->fetchAll(PDO::FETCH_OBJ);

    $strArquivos = '';

    foreach ($arqEnviados as $arquivo) {
        $strArquivos .= "{$arquivo->arquivo}:";
    }

    $html .= "<tr>";
    $html .= "<td>{$pj['cnpj']}</td>";
    $html .= "<td>$inscrito->protocolo</td>";
    $html .= "<td>$inscrito->nucleo_artistico</td>";
    $html .= "<td>{$repre['nome']}</td>";
    $html .= "<td>{$pj['razao_social']}</td>";
    $html .= "<td>R$ {$fomentoObj->dinheiroParaBr($projeto['valor_projeto'])}</td>";
    $html .= "<td>{$projeto['duracao']}</td>";
    $html .= "<td><a href='".SERVERURL."api/baixarArquivos.php?arquivo=$strArquivos'>.zip</a></td>";
    $html .= "</tr>";
}
$html .= "</table>";
$html .= "</body>";
$html.= "</html>";


// Configurações header para forçar o download
header ("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
header ("Cache-Control: no-cache, must-revalidate");
header ("Pragma: no-cache");
header ("Content-type: application/x-msexcel");
header ("Content-Disposition: attachment; filename=\"{$nomeArquivoEx}\" ");
header ("Content-Description: PHP Generated Data" );

echo $html;

exit;