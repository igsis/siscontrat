<?php

if ($pedidoAjax) {
    require_once "../models/FormacaoModel.php";
    require_once "../controllers/PessoaFisicaController.php";
} else {
    require_once "./models/FormacaoModel.php";
    require_once "./controllers/PessoaFisicaController.php";
}

class FormacaoInscritoController extends FormacaoModel
{

    public function inserir($id, $novoImport = true, $pfSis_id = null)
    {

        if ($novoImport) {
            $pfCapac_id = MainModel::encryption(self::recuperar($id)->pessoa_fisica_id);

            $idPfInscrito = (new PessoaFisicaController)->importarPf($pfCapac_id, true);
            if (!$idPfInscrito) {
                $alerta = [
                    'alerta' => 'sucesso',
                    'titulo' => 'O CPF possui divergencias',
                    'texto' => 'O CPF selecionado já possui cadastro no Siscontrat, selecione os dados que deseja atualizar antes de completar a importação',
                    'tipo' => 'warning',
                    'location' => SERVERURL . "formacao/compara_capac&id=$pfCapac_id&capac=$id"
                ];
            } else {
                $alerta = [
                    'alerta' => 'sucesso',
                    'titulo' => 'Proponente Importado!',
                    'texto' => 'O CPF selecionado foi importado ao Siscontrat. Conclua o cadastro na próxima tela.',
                    'tipo' => 'success',
                    'location' => SERVERURL . "formacao/dados_contratacao_cadastro&capac=$id"
                ];
            }
        } else {
            $pf = (new PessoaFisicaController)->editaPessoaFisica($pfSis_id, "", true);

            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Proponente Importado!',
                'texto' => 'O CPF selecionado foi importado ao Siscontrat. Conclua o cadastro na próxima tela.',
                'tipo' => 'success',
                'location' => SERVERURL . "formacao/dados_contratacao_cadastro&capac=$id"
            ];
        }

        return MainModel::sweetAlert($alerta);
    }

    public function recuperar(string $id)
    {
        $id = $this->decryption($id);

        $sql = "SELECT 	fc.id, fc.protocolo, pf.nome, pf.rg, pf.passaporte, pf.ccm, pf.nome_artistico, pf.email,
                        pf.cpf, pf.data_nascimento, fc.ano, pf.nacionalidade_id, na.nacionalidade, fr.regiao,
                        fc.pessoa_fisica_id, pe.logradouro, pe.numero, pe.complemento, pe.bairro, pe.cidade,
                        fc.form_cargo_id, gi.grau_instrucao, pe.uf, pe.cep, e.descricao AS `etnia`, g.genero, 
                        ba.banco, pb.agencia, pb.conta, fc.programa_id, fc.regiao_preferencial_id, 
                        fc.linguagem_id, pb.banco_id, pd.grau_instrucao_id, pd.etnia_id, pd.genero_id,
                        fcd.form_cargo2_id, form_cargo3_id, nt.nit, dr.drt, fc.data_envio,                       
                        IF (pd.trans, 'Sim', 'Não') AS `trans`,
                        IF (pd.pcd, 'Sim', 'Não') AS `pcd`
             FROM form_cadastros fc
             LEFT JOIN pessoa_fisicas					pf  ON fc.pessoa_fisica_id = pf.id
             LEFT JOIN nits					            nt  ON nt.pessoa_fisica_id = pf.id
             LEFT JOIN drts					            dr  ON dr.pessoa_fisica_id = pf.id
             LEFT JOIN pf_enderecos						pe  ON pf.id = pe.pessoa_fisica_id 
             LEFT JOIN nacionalidades					na  ON pf.nacionalidade_id = na.id
             LEFT JOIN form_regioes_preferenciais	    fr  ON fc.regiao_preferencial_id = fr.id
             LEFT JOIN pf_detalhes						pd  ON pf.id = pd.pessoa_fisica_id
             LEFT JOIN pf_bancos                        pb  ON pf.id = pb.pessoa_fisica_id
             LEFT JOIN bancos                           ba  ON ba.id = pb.banco_id
             LEFT JOIN grau_instrucoes					gi  ON pd.grau_instrucao_id = gi.id
             LEFT JOIN etnias							e   ON e.id = pd.etnia_id
             LEFT JOIN generos							g   ON g.id = pd.genero_id
             LEFT JOIN form_cargos_adicionais           fcd ON fc.id = fcd.form_cadastro_id
             WHERE protocolo IS NOT NULL AND fc.id = {$id}";

        return $this->consultaSimples($sql, true)->fetchObject();
    }

    public function listarIncritos($dados)
    {
        $where = " ";
        if (count($dados)) {

            foreach ($dados as $key => $value) {
                if ($value != '') {
                    if ($key != 'data') {
                        $where .= " AND {$key} = {$value}";
                    } else {
                        if (count($value) == 2 && ($value[0] != '' && $value[1] != '')) {
                            $where .= " AND (fc.data_envio BETWEEN '{$value[0]}' AND '{$value[1]}') ";
                        } elseif (count($value) == 1){
                            if ($value[0] != ''){
                                $where .= " AND fc.data_envio = '{$value[0]}' ";
                            }
                            elseif ($value[1] != ''){
                                $where .= " AND fc.data_envio = '{$value[1]}' ";
                            }
                        }
                    }
                }
            }
        }

        $sql = "SELECT 	    fc.id, fc.protocolo, pf.nome, pf.cpf, fc.ano, fr.regiao, 
                            fc.form_cargo_id, fc.programa_id, 
                            fc.linguagem_id, e.descricao AS `etnia`, g.genero, 
                            IF (pd.trans, 'Sim', 'Não') AS `trans`,
                            IF (pd.pcd, 'Sim', 'Não') AS `pcd`
                 FROM form_cadastros fc
                 LEFT JOIN pessoa_fisicas					pf  ON fc.pessoa_fisica_id = pf.id
                 LEFT JOIN form_regioes_preferenciais	    fr  ON fc.regiao_preferencial_id = fr.id
                 LEFT JOIN pf_detalhes						pd  ON pf.id = pd.pessoa_fisica_id
                 LEFT JOIN etnias							e   ON e.id = pd.etnia_id
                 LEFT JOIN generos							g   ON g.id = pd.genero_id
                 WHERE protocolo IS NOT NULL AND `fc`.`publicado` = 1";

        $sql .= $where;

        return DbModel::consultaSimples($sql, true)->fetchAll(PDO::FETCH_OBJ);
    }

    public function recuperarArquivosCapac($id)
    {
        $sql = "SELECT fl.documento, far.arquivo
                FROM formacao_arquivos far
                LEFT JOIN formacao_lista_documentos AS fl ON far.formacao_lista_documento_id = fl.id
                WHERE far.publicado = 1 AND far.form_cadastro_id = {$id}";

        return $this->consultaSimples($sql)->fetchAll(PDO::FETCH_OBJ);
    }
}