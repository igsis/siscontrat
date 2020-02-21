<?php
if ($pedidoAjax) {
    require_once "../models/MainModel.php";
} else {
    require_once "./models/MainModel.php";
}

class FomentoController extends MainModel
{
    public function listaFomentos()
    {
        $fomentos = DbModel::listaPublicado("fom_editais", null,true);
        foreach ($fomentos as $key => $fomento) {
            $tipo_contratacao = DbModel::getInfo('tipos_contratacoes', $fomento->tipo_contratacao_id, true)->fetchObject();
            $fomentos[$key]->tipo_contratacao = $tipo_contratacao->tipo_contratacao;
        }
        return $fomentos;
    }

    public function recuperaTipoContratacao($edital_id) {
        $tipo = gettype($edital_id);
        if ($tipo == "string") {
            $edital_id = MainModel::decryption($edital_id);
        }
        $sql = "SELECT tipo_contratacao_id FROM fom_editais WHERE id = '$edital_id'";
        return DbModel::consultaSimples($sql)->fetchColumn();
    }

    public function recuperaNomeEdital($edital_id) {
        $edital_id = MainModel::decryption($edital_id);
        $edital = DbModel::getInfo('fom_editais', $edital_id)->fetchObject();
        return $edital->titulo;
    }

    /**
     * @param string $dataAbertura
     * <p>Recebe a data de abertura do edital no padrão <strong><i>SQL</strong> - AAAA-MM-DD</i></p>
     * @param string $dataEncerramento
     * <p>Recebe a data de encerramento do edital no padrão <strong><i>SQL</strong> - AAAA-MM-DD</i></p>
     * @return bool
     * <p>Caso o edital esteja ativo, retorna <i>TRUE</i>. Caso não, retorna <i>FALSE</i></p>
     * @throws Exception
     */
    public function verificaFomentoAtivo($dataAbertura, $dataEncerramento) {
        $dataAtual = new DateTime();
        $dataAbertura = new DateTime($dataAbertura);
        $dataEncerramento = new DateTime($dataEncerramento);

        if (($dataAtual >= $dataAbertura) && ($dataAtual <= $dataEncerramento)) {
            return true;
        } else {
            return false;
        }
    }

    public function contadorFomento($tabela, $where)
    {
        return DbModel::consultaSimples("SELECT id FROM $tabela WHERE $where",true)->rowCount();
    }
}