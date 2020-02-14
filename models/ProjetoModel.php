<?php
if ($pedidoAjax) {
    require_once "../models/ValidacaoModel.php";
    require_once "../controllers/FomentoController.php";
} else {
    require_once "./models/ValidacaoModel.php";
    require_once "./controllers/FomentoController.php";
}


class ProjetoModel extends ValidacaoModel
{
    public function updatePjProjeto()
    {
        $idProjeto = MainModel::decryption($_SESSION['projeto_s']);
        $idPj = MainModel::decryption($_SESSION['origem_id_s']);
        $dados = [
            "pessoa_juridica_id" => $idPj
        ];
        $projeto = MainModel::update('fom_projetos', $dados, $idProjeto);
        if ($projeto) {
            return true;
        } else {
            return false;
        }
//        MainModel::updateEspecial("fom_projetos","$dados","id",$idProjeto);
    }

    protected function validaProjetoModal($idProjeto){
        $proj = DbModel::getInfo('fom_projetos',$idProjeto)->fetchObject();
        $naoObrigados = [
          'pessoa_fisica_id',
          'pessoa_juridica_id',
          'protocolo',
          'data_inscricao'
        ];

        $erros = ValidacaoModel::retornaMensagem($proj,$naoObrigados);

        if (isset($erros)){
            return $erros;
        } else {
            return false;
        }
    }

    protected function validaArquivosProjeto($projeto_id, $edital_id) {
        $tipo_contratacao_id = (new FomentoController)->recuperaTipoContratacao((int) $edital_id);
        $validaArquivos = ValidacaoModel::validaArquivosFomentos($projeto_id, $tipo_contratacao_id);
        if ($validaArquivos) {
            if (!isset($erros) || $erros == false) { $erros = []; }
            $erros = array_merge($erros, $validaArquivos);
        }

        if (isset($erros)){
            return $erros;
        } else {
            return false;
        }
    }

    private function validaPj($pessoa_juridica_id)
    {
        $pj = DbModel::getInfo('pessoa_juridicas', $pessoa_juridica_id)->fetchObject();
        $naoObrigatorios = [
            'ccm',
            'representante_legal2_id'
        ];

        $erros = ValidacaoModel::retornaMensagem($pj, $naoObrigatorios);

        $validaEndereco = ValidacaoModel::validaEndereco(2, $pessoa_juridica_id);
        $validaTelefone = ValidacaoModel::validaTelefone(2, $pessoa_juridica_id);

        if ($validaEndereco) {
            if (!isset($erros) || $erros == false) { $erros = []; }
            $erros = array_merge($erros, $validaEndereco);
        }
        if ($validaTelefone) {
            if (!isset($erros) || $erros == false) { $erros = []; }
            $erros = array_merge($erros, $validaTelefone);
        }


        if ($pj->representante_legal1_id != null){
            $representanteLegal1 = ValidacaoModel::validaRepresentante($pj->representante_legal1_id);
            if ($representanteLegal1) {
                if (!isset($erros) || $erros == false) { $erros = []; }
                $erros = array_merge($erros, $representanteLegal1);
            }
        }

        if ($pj->representante_legal2_id != null){
            $representanteLegal2 = ValidacaoModel::validaRepresentante($pj->representante_legal2_id);
            if ($representanteLegal2) {
                if (!isset($erros) || $erros == false) { $erros = []; }
                $erros = array_merge($erros, $representanteLegal2);
            }
        }

        if (isset($erros)){
            return $erros;
        } else {
            return false;
        }
    }

    protected function validaProponenteProjeto($projeto_id) {
        $projeto = DbModel::getInfo('fom_projetos', $projeto_id)->fetchObject();

        if ($projeto->pessoa_tipo_id == 1) {
            $proponente = DbModel::getInfo('pessoa_fisicas', $projeto->pessoa_fisica_id)->fetchObject();
        } else {
            $proponente = DbModel::getInfo('pessoa_juridicas', $projeto->pessoa_juridica_id)->fetchObject();
            $erros = self::validaPj($proponente->id);
        }

        return $erros;
    }
}