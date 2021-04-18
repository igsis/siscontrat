<?php
if ($pedidoAjax) {
    require_once "../models/MainModel.php";
} else {
    require_once "./models/MainModel.php";
}

class OcorrenciaController extends MainModel
{
    /**
     * @param int|string $id
     * @param string $tipo <p>Recupera por evento como padrão, declarar "atracao" para ocorrência por atracção</p>
     * @return array
     */
    public function recuperaOcorrencia($id, $tipo = false)
    {
        if (gettype($id) == "string") {
            $id = MainModel::decryption($id);
        }
        if ($tipo == "atracao"){
            $filtro = "atracao_id = $id";
        } else{
            $filtro = "origem_ocorrencia_id = $id";
        }
        return DbModel::consultaSimples("
            SELECT o.*, i.sigla,l.local,e.espaco,s.subprefeitura,ri.retirada_ingresso 
            FROM ocorrencias o
            LEFT JOIN instituicoes i on o.instituicao_id = i.id
            LEFT JOIN locais l on o.local_id = l.id
            LEFT JOIN espacos e on o.espaco_id = e.id
            LEFT JOIN subprefeituras s on o.subprefeitura_id = s.id
            LEFT JOIN retirada_ingressos ri on o.retirada_ingresso_id = ri.id
            WHERE  $filtro AND o.publicado = 1")->fetchAll(PDO::FETCH_OBJ);
    }

    public function recuperaOcorrenciaOrigem($tipo,$origem)
    {
        if ($tipo == 1){ // atração
            $origem = DbModel::consultaSimples("SELECT nome_atracao FROM atracoes WHERE id = '$origem'")->fetchColumn();
        } elseif ($tipo == 2){ // filme
            $origem = DbModel::consultaSimples("SELECT titulo FROM filmes WHERE id = '$origem'")->fetchColumn();
        }
        return $origem;
    }

    public function recuperaOcorrenciaExcecao($idAtracao):string
    {
        $datas = DbModel::consultaSimples("SELECT data_excecao FROM ocorrencia_excecoes WHERE atracao_id = '$idAtracao'")->fetchAll(PDO::FETCH_OBJ);
        $lista = "";
        foreach ($datas as $data) {
            $lista .= date('d/m/Y', strtotime($data->data_excecao)) . ", ";
        }
        return substr($lista,0,-2);
    }

    public function diadasemanaocorrencia($idOcorrencia){
        $array = [];
        $ocorrencia = DbModel::consultaSimples("SELECT segunda,terca,quarta,quinta,sexta,sabado,domingo FROM ocorrencias WHERE id = '$idOcorrencia'")->fetch(PDO::FETCH_ASSOC);

        if($ocorrencia['domingo'] == 1){
            array_push($array, "domingo");
        }
        if($ocorrencia['segunda'] == 1){
            array_push($array,"segunda");
        }
        if($ocorrencia['terca'] == 1){
            array_push($array, "terça");
        }
        if($ocorrencia['quarta'] == 1){
            array_push($array, "quarta");
        }
        if($ocorrencia['quinta'] == 1){
            array_push($array,"quinta");
        }
        if($ocorrencia['sexta'] == 1){
            array_push($array, "sexta");
        }
        if($ocorrencia['sabado'] == 1){
            array_push($array, "sábado");
        }
        return implode(", ",$array);
    }
}