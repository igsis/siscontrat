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
     * @param int $tipo <p>Recupera por evento como padrão, declarar "atracao" para ocorrência por atração ou filme</p>
     * @param int $atracao_id <p>idAtração ou idFilme</p>
     * @return array
     */
    public function recuperaOcorrencia($id, $tipo = false, $atracao_id = false)
    {
        $id = MainModel::decryption($id);
        if ($tipo) {
            $filtro = "tipo_ocorrencia_id = $tipo AND atracao_id = $atracao_id";
        } else {
            $filtro = "origem_ocorrencia_id = $id";
        }
        return DbModel::consultaSimples("
            SELECT o.*, i.sigla, l.local, l.logradouro, l.numero, l.complemento, l.bairro, l.cidade, l.uf, l.cep, e.espaco, s.subprefeitura, ri.retirada_ingresso 
            FROM ocorrencias o
            LEFT JOIN instituicoes i on o.instituicao_id = i.id
            LEFT JOIN locais l on o.local_id = l.id
            LEFT JOIN espacos e on o.espaco_id = e.id
            LEFT JOIN subprefeituras s on o.subprefeitura_id = s.id
            LEFT JOIN retirada_ingressos ri on o.retirada_ingresso_id = ri.id
            WHERE  $filtro AND o.publicado = 1")->fetchAll(PDO::FETCH_OBJ);
    }

    /**
     * @param $tipo
     * <p>1 - Atração | 2 - Filme</p>
     * @param $origem
     * <p>idAtracao ou idFilme</p>
     * @return mixed
     */
    public function recuperaOcorrenciaOrigem($tipo, $origem)
    {
        if ($tipo == 1) { // atração
            $origem = DbModel::consultaSimples("SELECT nome_atracao FROM atracoes WHERE id = '$origem'")->fetchColumn();
        } elseif ($tipo == 2) { // filme
            $origem = DbModel::consultaSimples("SELECT titulo FROM filmes WHERE id = '$origem'")->fetchColumn();
        }
        return $origem;
    }

    public function recuperaOcorrenciaExcecao($idAtracao): string
    {
        $datas = DbModel::consultaSimples("SELECT data_excecao FROM ocorrencia_excecoes WHERE atracao_id = '$idAtracao'")->fetchAll(PDO::FETCH_OBJ);
        $lista = "";
        foreach ($datas as $data) {
            $lista .= date('d/m/Y', strtotime($data->data_excecao)) . ", ";
        }
        return substr($lista, 0, -2);
    }

    public function diadasemanaocorrencia($idOcorrencia)
    {
        $array = [];
        $ocorrencia = DbModel::consultaSimples("SELECT segunda,terca,quarta,quinta,sexta,sabado,domingo FROM ocorrencias WHERE id = '$idOcorrencia'")->fetch(PDO::FETCH_ASSOC);

        if ($ocorrencia['domingo'] == 1) {
            array_push($array, "domingo");
        }
        if ($ocorrencia['segunda'] == 1) {
            array_push($array, "segunda");
        }
        if ($ocorrencia['terca'] == 1) {
            array_push($array, "terça");
        }
        if ($ocorrencia['quarta'] == 1) {
            array_push($array, "quarta");
        }
        if ($ocorrencia['quinta'] == 1) {
            array_push($array, "quinta");
        }
        if ($ocorrencia['sexta'] == 1) {
            array_push($array, "sexta");
        }
        if ($ocorrencia['sabado'] == 1) {
            array_push($array, "sábado");
        }
        return implode(", ", $array);
    }

    public function retornaPeriodo($idEvento)
    {
        $id = MainModel::decryption($idEvento);

        $virada = DbModel::consultaSimples("SELECT DISTINCT oco.local_id FROM ocorrencias oco INNER JOIN eventos e ON e.id = oco.origem_ocorrencia_id WHERE e.id = '$id' AND oco.publicado = '1' AND oco.virada = '1'");

        if ($virada->rowCount() > 0) {
            $data_inicio = DbModel::consultaSimples("SELECT data_inicio FROM $tabela oco WHERE oco.origem_ocorrencia_id = '$id' AND oco.publicado = '1' ORDER BY data_inicio ASC LIMIT 0,1")->fetch(PDO::FETCH_OBJ)->data_inicio;
            $sql_posterior01 = "SELECT data_fim FROM ocorrencias oco WHERE oco.origem_ocorrencia_id = '$id' AND oco.publicado = '1' ORDER BY data_fim DESC LIMIT 0,1"; //quando existe data final
            $sql_posterior02 = "SELECT data_fim FROM ocorrencias oco WHERE oco.origem_ocorrencia_id = '$id' AND oco.publicado = '1' ORDER BY data_inicio DESC LIMIT 0,1"; //quando há muitas datas únicas

            $data_fim = DbModel::consultaSimples($sql_posterior01)->fetch(PDO::FETCH_OBJ)->data_fim;

            if (($data_fim != '0000-00-00') or ($data_fim != NULL)) {
                //se existe uma data final e que é diferente de NULO
                $dataFinal01 = $data_fim;
            }

            $dataFinal02 = DbModel::consultaSimples($sql_posterior02)->fetch(PDO::FETCH_OBJ)->data_fim;

            if (isset($dataFinal01)) {
                //se existe uma temporada, compara com a última data única
                if ($dataFinal01 > $dataFinal02) {
                    $dataFinal = $dataFinal01;
                } else {
                    $dataFinal = $dataFinal02;
                }
            } else {
                $dataFinal = $dataFinal02;
            }
            if ($data_inicio == $dataFinal) {
                return MainModel::validaData($data_inicio) . " DE ACORDO COM PROGRAMAÇÃO DO EVENTO NO PERÍODO DA VIRADA CULTURAL.";
            } else {
                return "de " . MainModel::validaData($data_inicio) . " à " . MainModel::validaData($dataFinal) . " DE ACORDO COM PROGRAMAÇÃO DO EVENTO NO PERÍODO DA VIRADA CULTURAL.";
            }
        } else {
            $data_inicio = DbModel::consultaSimples("SELECT data_inicio FROM ocorrencias oco WHERE oco.origem_ocorrencia_id = '$id' AND oco.publicado = '1' ORDER BY data_inicio ASC LIMIT 0,1")->fetch(PDO::FETCH_OBJ)->data_inicio;

            if ($data_inicio != NULL) {
                $sql_posterior01 = "SELECT data_fim FROM ocorrencias oco WHERE oco.origem_ocorrencia_id = '$id' AND oco.publicado = '1' ORDER BY data_fim DESC LIMIT 0,1"; //quando existe data final
                $sql_posterior02 = "SELECT data_fim FROM ocorrencias oco WHERE oco.origem_ocorrencia_id = '$id' AND oco.publicado = '1' ORDER BY data_inicio DESC LIMIT 0,1"; //quando há muitas datas únicas

                $data_fim = DbModel::consultaSimples($sql_posterior01)->fetch(PDO::FETCH_OBJ)->data_fim;
                if (($data_fim != '0000-00-00') or ($data_fim != NULL)) {
                    //se existe uma data final e que é diferente de NULO
                    $dataFinal01 = $data_fim;
                }

                $dataFinal02 = DbModel::consultaSimples($sql_posterior02)->fetch(PDO::FETCH_OBJ)->data_fim;
                if (isset($dataFinal01)) {
                    //se existe uma temporada, compara com a última data única
                    if ($dataFinal01 > $dataFinal02) {
                        $dataFinal = $dataFinal01;
                    } else {
                        $dataFinal = $dataFinal02;
                    }
                } else {
                    $dataFinal = $dataFinal02;
                }
                if ($data_inicio == $dataFinal) {
                    return exibirDataBr($data_inicio);
                } else {
                    return "de " . MainModel::validaData($data_inicio) . " à " . MainModel::validaData($dataFinal);
                }
            }
        }
        return false;
    }
}