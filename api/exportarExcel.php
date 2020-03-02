<?php
$pedidoAjax = true;
require_once "../controllers/FomentoController.php";

$id = $_GET['id'];
$data = date('YmdHis');

$fomentoObj = new FomentoController();
$nomeEdital = $fomentoObj->recuperaEdital($id)->titulo;
$inscritos = $fomentoObj->listaInscritos($id);

$arquivo = "inscritos_".$data.".xls";

$html = "<html>";
$html .= "<head>";
$html .= "<meta charset='utf-8'>";
$html .= "<style>";
$html .= "tr,td{ border: 1px solid black }";
$html .= "</style>";
$html .= "</head>";
$html .= "<body>";
$html .= "<table>";
$html .= "<tr>";
$html .= "<td colspan='5'>Lista de Inscristos Edital - $nomeEdital</tr>";
$html .= "</tr>";
$html .= "<tr>";
$html .= "<td><b>Protocolo</b></td>";
$html .= "<td><b>Instituicao</b></td>";
$html .= "<td><b>Nucleo Artistico</b></td>";
$html .= "<td><b>Representante Nucleo</b></td>";
$html .= "</tr>";
foreach ($inscritos as $inscrito){
    $html .= "<tr>";
    $html .= "<td>$inscrito->protocolo</td>";
    $html .= "<td>$inscrito->instituicao</td>";
    $html .= "<td>$inscrito->nucleo_artistico</td>";
    $html .= "<td>$inscrito->representante_nucleo</td>";
    $html .= "</tr>";
}
$html .= "</table>";
$html .= "</body>";
$html.= "</html>";


//// Configurações header para forçar o download
//header ("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
//header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
//header ("Cache-Control: no-cache, must-revalidate");
//header ("Pragma: no-cache");
//header ("Content-type: application/x-msexcel");
//header ("Content-Disposition: attachment; filename=\"{$arquivo}\"" );
//header ("Content-Description: PHP Generated Data" );

echo $html;

exit;