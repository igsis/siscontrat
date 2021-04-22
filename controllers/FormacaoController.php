<?php
if ($pedidoAjax) {
    require_once "../models/FormacaoModel.php";
    //require_once "../controllers/PedidoController.php";
    require_once "../controllers/PessoaFisicaController.php";
} else {
    require_once "./models/FormacaoModel.php";
    //require_once "./controllers/PedidoController.php";
    require_once "./controllers/PessoaFisicaController.php";
}

class FormacaoController extends FormacaoModel
{
    /*
     * retorna objeto
     */
    /**
     * @param int|string $contratacao_id
     * @return string
     */
    public function retornaObjetoFormacao($contratacao_id): string
    {
        if (gettype($contratacao_id == "string")) {
            $contratacao_id = MainModel::decryption($contratacao_id);
        }
        $cstObjeto = DbModel::consultaSimples("SELECT fc.programa_id, p.programa, l.linguagem, p.edital, fcargo.cargo 
            FROM programas AS p 
            INNER JOIN formacao_contratacoes AS fc ON p.id = fc.programa_id
            INNER JOIN formacao_cargos AS fcargo ON fc.form_cargo_id = fcargo.id
            INNER JOIN linguagens l ON fc.linguagem_id = l.id
            WHERE fc.id = $contratacao_id AND fc.publicado = 1")->fetchObject();
        if ($cstObjeto) {
            if ($cstObjeto->programa_id == 1) {
                $texto['programa'] = "VOCACIONAL";
            } else {
                $texto['programa'] = "DE INICIAÇÃO ARTÍSTICA";
            }

            $objeto = "CONTRATAÇÃO COMO $cstObjeto->cargo de $cstObjeto->linguagem DO PROGRAMA {$texto['programa']} - {date('Y')} NOS TERMOS DO $cstObjeto->edital - PROGRAMAS DA SUPERVISÃO DE FORMAÇÃO CULTURAL.";
            $encoding = 'UTF-8';
            return mb_convert_case($objeto, MB_CASE_UPPER, $encoding);
        }
        return "";
    }

    public function listaPedidos($ano = 0, $pedido = 0)
    {
        $whereAno = "";
        if ($ano) {
            $whereAno = "AND fc.ano = {$ano}";
        }

        $whereStatusPedido = "";
        if ($pedido) {
            if ($pedido == 2) {
                $whereStatusPedido = "AND p.status_pedido_id = 2";
            } else {
                $whereStatusPedido = "AND p.status_pedido_id != 2";
            }
        }

        $sql = "SELECT   p.id, p.origem_id,fc.protocolo, fc.ano,
                         p.numero_processo,fc.num_processo_pagto, 
                         pf.id AS 'pessoa_fisica_id', pf.nome, ns.nome_social, pf.cpf, pf.passaporte, v.verba, 
                         ps.`status`, fc.form_status_id 
            FROM pedidos p 
            LEFT JOIN pedido_status ps ON p.status_pedido_id = ps.id
            INNER JOIN formacao_contratacoes fc ON fc.id = p.origem_id 
            INNER JOIN pessoa_fisicas pf ON fc.pessoa_fisica_id = pf.id                
            LEFT JOIN pf_nome_social ns ON pf.id = ns.pessoa_fisica_id                
            INNER JOIN verbas v on p.verba_id = v.id 
            INNER JOIN formacao_status fs on fc.form_status_id = fs.id
            WHERE p.publicado = 1 AND p.origem_tipo_id = 2 {$whereAno} {$whereStatusPedido}";

        return DbModel::consultaSimples($sql)->fetchAll(PDO::FETCH_OBJ);
    }

    public function anosPedido()
    {
        $sql = "SELECT MIN(ano) AS min, MAX(ano) AS max                                              
            FROM pedidos p                                                           
            INNER JOIN formacao_contratacoes fc ON fc.id = p.origem_id               
            INNER JOIN pessoa_fisicas pf ON fc.pessoa_fisica_id = pf.id              
            INNER JOIN verbas v on p.verba_id = v.id                                 
            INNER JOIN formacao_status fs on fc.form_status_id = fs.id               
            WHERE fc.form_status_id != 5 AND p.publicado = 1 AND p.origem_tipo_id = 2";
        return DbModel::consultaSimples($sql)->fetchObject();
    }

    //retorna uma string ou um objeto com todos os locais que o pedido possui
    public function retornaLocaisFormacao($contratacao_id, $obj = 0, $decryption = 0)
    {
        if ($decryption != 0) {
            $contratacao_id = MainModel::decryption($contratacao_id);
        }
        $locais = "";
        $locaisArrays = DbModel::consultaSimples("SELECT l.id, l.local FROM formacao_locais AS fl INNER JOIN locais AS l ON fl.local_id = l.id WHERE form_pre_pedido_id = $contratacao_id")->fetchAll();
        if ($obj != 0):
            return $locaisArrays;
        else:
            foreach ($locaisArrays as $locaisArray) {
                $locais = $locais . $locaisArray['local'] . '; ';
            }
            return substr($locais, 0, -2);
        endif;
    }

    public function retornaDadosParcelas($contratacao_id, $decryption = 0, $unica = 0, $parcela_id = NULL)
    {
        if ($decryption != 0) {
            $contratacao_id = MainModel::decryption($contratacao_id);
        }

        if ($unica != 0 && $parcela_id != NULL):
            return DbModel::consultaSimples("SELECT fp.* FROM formacao_parcelas AS fp INNER JOIN formacao_contratacoes AS fc ON fc.form_vigencia_id = fp.formacao_vigencia_id WHERE fc.id = $contratacao_id AND fp.publicado = 1 AND fp.id = $parcela_id")->fetchObject();
        else:
            return DbModel::consultaSimples("SELECT fp.* FROM formacao_parcelas AS fp INNER JOIN formacao_contratacoes AS fc ON fc.form_vigencia_id = fp.formacao_vigencia_id WHERE fc.id = $contratacao_id AND fp.publicado = 1")->fetchAll(PDO::FETCH_OBJ);
        endif;
    }

    public function retornaCargaHoraria($contratacao_id, $decryption = 0)
    {
        if ($decryption != 0) {
            $contratacao_id = MainModel::decryption($contratacao_id);
        }

        $carga = 0;
        $consultaParcelas = DbModel::consultaSimples("SELECT fp.carga_horaria FROM formacao_parcelas AS fp INNER JOIN formacao_contratacoes AS fc ON fc.form_vigencia_id = fp.formacao_vigencia_id WHERE fc.id = $contratacao_id AND fp.publicado = 1")->fetchAll();
        foreach ($consultaParcelas as $consultaParcela) {
            $carga = $carga + $consultaParcela['carga_horaria'];
        }
        return $carga;
    }

    public function retornaPeriodoFormacao($contratacao_id, $decryption = 0, $unico = 0, $parcela_id = NULL)
    {
        if ($decryption != 0) {
            $contratacao_id = MainModel::decryption($contratacao_id);
        }

        if ($unico != 0 && $parcela_id != NULL) {
            $testaDataInicio = DbModel::consultaSimples("SELECT fp.data_inicio FROM formacao_parcelas AS fp INNER JOIN formacao_contratacoes AS fc ON fc.form_vigencia_id = fp.formacao_vigencia_id WHERE fc.id = $contratacao_id AND fp.publicado = 1 AND fp.id = $parcela_id");
            if ($testaDataInicio->rowCount() > 0) {
                $data_inicio = $testaDataInicio->fetchObject()->data_inicio;
                $data_fim = DbModel::consultaSimples("SELECT fp.data_fim FROM formacao_parcelas AS fp INNER JOIN formacao_contratacoes AS fc ON fc.form_vigencia_id = fp.formacao_vigencia_id WHERE fc.id = $contratacao_id AND fp.publicado = 1 AND fp.id = $parcela_id")->fetchObject()->data_fim;
                return "de " . MainModel::dataParaBR($data_inicio) . " à " . MainModel::dataParaBR($data_fim);
            } else {
                return "(Parcelas não cadastradas)";
            }
        } else {
            $testaDataInicio = DbModel::consultaSimples("SELECT fp.data_inicio FROM formacao_parcelas AS fp INNER JOIN formacao_contratacoes AS fc ON fc.form_vigencia_id = fp.formacao_vigencia_id WHERE fc.id = $contratacao_id AND fp.publicado = 1 ORDER BY fp.data_inicio ASC LIMIT 0,1");
            if ($testaDataInicio->rowCount() > 0) {
                $data_inicio = $testaDataInicio->fetchObject()->data_inicio;
                $data_fim = DbModel::consultaSimples("SELECT fp.data_fim FROM formacao_parcelas AS fp INNER JOIN formacao_contratacoes AS fc ON fc.form_vigencia_id = fp.formacao_vigencia_id WHERE fc.id = $contratacao_id AND fp.publicado = 1 ORDER BY fp.data_fim DESC LIMIT 0,1")->fetchObject()->data_fim;
                /*if ($data_inicio == $data_fim || $data_fim == "0000-00-00") {
                    return MainModel::dataParaBR($data_inicio);
                } else {
                    return "de " . MainModel::dataParaBR($data_inicio) . " à " . MainModel::dataParaBR($data_fim);
                }*/
                return "de " . MainModel::dataParaBR($data_inicio) . " à " . MainModel::dataParaBR($data_fim);
            } else {
                return "(Parcelas não cadastradas)";
            }
        }

    }

//    dados contratacao

    public function listaDadosContratacaoCapac($ano = 0)
    {

        $whereAno = "";
        if ($ano) {
            $whereAno = " AND fc.ano = {$ano}";
        }

        $sqlFormacao = "SELECT fc.*, pf.id AS 'pf_id', pf.nome, pf.cpf FROM form_cadastros fc
                        INNER JOIN pessoa_fisicas pf on fc.pessoa_fisica_id = pf.id
                        WHERE fc.protocolo IS NOT NULL AND fc.publicado = 1 {$whereAno}";

        $formacoes = MainModel::consultaSimples($sqlFormacao, true)->fetchAll(PDO::FETCH_OBJ);

        foreach ($formacoes as $key => $formacao) {
            $formacoes[$key]->cargo = MainModel::getInfo('formacao_cargos', $formacao->form_cargo_id)->fetchObject()->cargo;
            $formacoes[$key]->programa = MainModel::getInfo('programas', $formacao->programa_id)->fetchObject()->programa;
            $formacoes[$key]->linguagem = MainModel::getInfo('linguagens', $formacao->linguagem_id)->fetchObject()->linguagem;
        }
        return $formacoes;
    }

    // protocolo
    public function chegaProtocolo($protocolo)
    {
        $protocolo = DbModel::consultaSimples("SELECT * FROM formacao_contratacoes WHERE protocolo = '$protocolo'")->rowCount();
        return $protocolo > 0 ? true : false;
    }

    public function recuperaDadosContratacaoCapac($capac_id)
    {
        $capac_id = MainModel::decryption($capac_id);
        return DbModel::getInfo('form_cadastros', $capac_id, true)->fetchObject();
    }

    public function recuperaAnoVigente()
    {
        return DbModel::consultaSimples("SELECT MAX(ano_referencia) as ano_vigente FROM capac_new.form_aberturas WHERE publicado != 0", true)->fetchObject();
    }

    public function recuperaIdContratacao($protocoloCapac)
    {
        $idContratacao = DbModel::consultaSimples("SELECT * FROM formacao_contratacoes WHERE protocolo = '$protocoloCapac'")->fetchObject()->id; //sis
        return MainModel::encryption($idContratacao);
    }


    /*
     * apagar a partir daqui
     */
    /*public function recuperaPedido($pedido_id, $excel = 0, $ano = 0)
    {
        if ($excel != 0 && $ano != 0):
            $sql = "SELECT p.numero_processo, fc.protocolo, fc.programa_id, pf.id, pf.nome, pro.programa, c.cargo AS 'funcao', c.justificativa AS 'cargo_justificativa', l.linguagem, pf.email, s.status
                                                      FROM pedidos AS p
                                                      INNER JOIN pessoa_fisicas AS pf ON p.pessoa_fisica_id = pf.id
                                                      INNER JOIN formacao_contratacoes AS fc ON fc.id = p.origem_id
                                                      INNER JOIN programas AS pro ON fc.programa_id = pro.id
                                                      INNER JOIN formacao_cargos AS c ON fc.form_cargo_id = c.id
                                                      INNER JOIN linguagens AS l ON fc.linguagem_id = l.id
                                                      INNER JOIN formacao_status AS s ON fc.form_status_id = s.id
                                                      WHERE fc.form_status_id != 5 AND p.publicado = 1 AND p.origem_tipo_id = 2 AND fc.ano = $ano";
            return DbModel::consultaSimples($sql)->fetchAll(PDO::FETCH_OBJ);
        else:
            if (gettype($pedido_id) == "string") {
                $pedido_id = MainModel::decryption($pedido_id);
            }
            return DbModel::consultaSimples("SELECT p.id, p.origem_id, p.valor_total, p.data_kit_pagamento, p.numero_processo, p.numero_parcelas, p.pessoa_fisica_id, p.valor_total, p.numero_processo_mae,
                                                            p.forma_pagamento, p.justificativa AS 'cargo_justificativa', p.observacao, p.verba_id, s.status, fc.protocolo, pf.nome, c.cargo, fc.programa_id, l.linguagem, fis.nome_completo as fiscal_nome, fis.rf_rg as fiscal_rf, sup.nome_completo as suplente_nome, sup.rf_rg as suplente_rf
                                                  FROM pedidos AS p
                                                  INNER JOIN pedido_status AS s ON s.id = p.status_pedido_id
                                                  INNER JOIN formacao_contratacoes AS fc ON fc.id = p.origem_id
                                                  INNER JOIN linguagens AS l ON fc.linguagem_id = l.id
                                                  INNER JOIN pessoa_fisicas AS pf ON pf.id = p.pessoa_fisica_id
                                                  INNER JOIN formacao_cargos AS c ON fc.form_cargo_id = c.id
                                                    LEFT JOIN usuarios fis on fc.fiscal_id = fis.id
                                                    LEFT JOIN usuarios sup on fc.suplente_id = sup.id
                                                  WHERE p.id = $pedido_id AND p.publicado = 1 AND p.origem_tipo_id = 2")->fetchObject();
        endif;

    }*/
    /*public function listaPF()
    {
        return parent::getPF();
    }*/
    /*public function listaRegiaoPrefencial()
    {
        return parent::getRegiaoPreferencial();
    }*/
    /*public function recuperaTelInscrito($pesquisa_fisica_id, $obj = 0)
    {
        $tel = "";

        $telArrays = DbModel::consultaSimples("SELECT telefone FROM pf_telefones WHERE pessoa_fisica_id = $pesquisa_fisica_id", true)->fetchAll(PDO::FETCH_ASSOC);
        if ($obj != NULL):
            return $telArrays;
        else:
            foreach ($telArrays as $telArrays) {
                $tel = $tel . $telArrays['telefone'] . '/ ';
            }
            return substr($tel, 0, -2);
        endif;
    }*/
    /*public function recuperaContratacao($contratacao_id, $decription = 0)
    {
        if ($decription != 0) {
            $contratacao_id = MainModel::decryption($contratacao_id);
        }
        $sql = "SELECT fc.id, pro.programa, pro.edital, pro.verba_id AS 'programa_verba_id', fc.protocolo, fc.pessoa_fisica_id, pf.nome AS 'nome_pf', c.cargo, c.justificativa as cargo_justificativa, l.linguagem, cor.coordenadoria, fiscal.nome_completo AS 'fiscal', suplente.nome_completo AS 'suplente', vb.verba, fc.form_vigencia_id
                FROM formacao_contratacoes AS fc
                INNER JOIN programas AS pro ON pro.id = fc.programa_id
                INNER JOIN formacao_cargos AS c ON c.id = fc.form_cargo_id
                INNER JOIN linguagens AS l ON l.id = fc.linguagem_id
                INNER JOIN coordenadorias AS cor ON cor.id = fc.coordenadoria_id
                INNER JOIN pessoa_fisicas AS pf ON pf.id = fc.pessoa_fisica_id
                INNER JOIN verbas AS vb ON vb.id = pro.verba_id
                LEFT JOIN usuarios AS fiscal ON fiscal.id = fc.fiscal_id
                LEFT JOIN usuarios AS suplente ON suplente.id = fc.suplente_id
                WHERE fc.id = {$contratacao_id} AND fc.publicado = 1";

        return DbModel::consultaSimples($sql)->fetchObject();
    }*/
    /*public function editarParcela($post)
{
    unset($post['_method']);
    $pedido_id = MainModel::decryption($post['pedido_id']);
    unset($post['pedido_id']);
    $parcelas = DbModel::consultaSimples("SELECT * FROM parcelas WHERE pedido_id = $pedido_id AND publicado = 1")->fetchAll(PDO::FETCH_ASSOC);
    if (count($parcelas) > 0) {
        foreach ($parcelas as $parcela) {
            DbModel::consultaSimples("UPDATE parcela_complementos SET publicado = '0' WHERE parcela_id = '{$parcela['id']}'");
            DbModel::consultaSimples("UPDATE parcelas SET publicado = '0' WHERE pedido_id = $pedido_id AND numero_parcelas = '{$parcela['numero_parcelas']}'");
        }

    }

    //insere as parcelas dentro da tabela parcelas e parcelas_complementos
    for ($i = 0; $i < count($post['numero_parcelas']); $i++):
        $arrayParcela = [
            'pedido_id' => $pedido_id,
            'numero_parcelas' => $i + 1,
            'valor' => $post['valor'][$i],
            'data_pagamento' => $post['data_pagamento'][$i],
            'publicado' => '1',
        ];
        $insertParcelas = DbModel::insert('parcelas', $arrayParcela);
        if ($insertParcelas && DbModel::connection()->errorCode() == 0):
            $arrayParcelaComplementos = [
                'parcela_id' => DbModel::connection()->lastInsertId(),
                'data_inicio' => $post['data_inicio'][$i],
                'data_fim' => $post['data_fim'][$i],
                'carga_horaria' => $post['carga_horaria'][$i],
                'publicado' => '1',
            ];
            DbModel::insert('parcela_complementos', $arrayParcelaComplementos);
        endif;
    endfor;

    if (DbModel::connection()->errorCode() == 0) {
        $dadosParcelas = DbModel::consultaSimples("SELECT * FROM parcelas WHERE pedido_id = $pedido_id AND publicado = 1")->fetchAll(PDO::FETCH_OBJ);
        $formaCompleta = "";
        for ($i = 0; $i < count($dadosParcelas); $i++) :
            $forma = $i + 1 . "º parcela R$ " . MainModel::dinheiroParaBr($dadosParcelas[$i]->valor) . ". Entrega de documentos a partir de " . MainModel::dataParaBR($dadosParcelas[$i]->data_pagamento) . ".\n";
            $formaCompleta = $formaCompleta . $forma;
        endfor;

        $formaCompleta = $formaCompleta . "\nA liquidação de cada parcela se dará em 3 (três) dias úteis após a data de confirmação da correta execução do(s) serviço(s).";
        DbModel::consultaSimples("UPDATE pedidos SET forma_pagamento = '$formaCompleta' WHERE id = $pedido_id AND origem_tipo_id = 2");

        $alerta = [
            'alerta' => 'sucesso',
            'titulo' => 'Parcelas Atualizadas!',
            'texto' => 'Parcelas atualizadas com sucesso!',
            'tipo' => 'success',
            'location' => SERVERURL . 'formacao/pedido_contratacao_cadastro&pedido_id=' . MainModel::encryption($pedido_id)
        ];
    } else {
        $alerta = [
            'alerta' => 'simples',
            'titulo' => 'Oops! Algo deu errado!',
            'texto' => 'Falha ao salvar os dados no servidor, tente novamente mais tarde',
            'tipo' => 'error'
        ];
    }
    return MainModel::sweetAlert($alerta);
}*/
    /*public function recuperaDetalhesContratacao($contratacao_id)
    {
        $contratacao_id = MainModel::decryption($contratacao_id);
        //var_dump($contratacao_id);
        return DbModel::consultaSimples("SELECT f.id,
                                                f.ano,
                                                f.chamado,
                                                cla.classificacao_indicativa,
                                                t.territorio,
                                                c.coordenadoria,
                                                s.subprefeitura,
                                                prog.programa,
                                                l.linguagem,
                                                proj.projeto,
                                                fc.cargo,
                                                fv.ano AS 'vigencia',
                                                f.observacao,
                                                fiscal.nome_completo AS 'fiscal',
                                                suplente.nome_completo AS 'suplente',
                                                f.num_processo_pagto AS 'numpgt'
                                        FROM formacao_contratacoes AS f
                                        INNER JOIN classificacao_indicativas AS cla ON f.classificacao = cla.id
                                        INNER JOIN territorios AS t ON f.territorio_id = t.id
                                        INNER JOIN coordenadorias AS c ON f.coordenadoria_id = c.id
                                        INNER JOIN subprefeituras AS s ON f.subprefeitura_id = s.id
                                        INNER JOIN programas AS prog ON f.programa_id = prog.id
                                        INNER JOIN linguagens AS l ON f.linguagem_id = l.id
                                        INNER JOIN projetos AS proj ON f.projeto_id = proj.id
                                        INNER JOIN formacao_cargos fc ON f.form_cargo_id = fc.id
                                        INNER JOIN formacao_vigencias fv ON f.form_vigencia_id = fv.id
                                        INNER JOIN usuarios AS fiscal ON f.fiscal_id = fiscal.id
                                        LEFT JOIN usuarios AS suplente ON f.suplente_id = suplente.id
                                        WHERE f.id = $contratacao_id AND f.publicado = 1 ")->fetchObject();
    }*/
    /*public function recuperaDadosContratacao($contratacao_id)
    {
        $contratacao_id = MainModel::decryption($contratacao_id);
        return DbModel::getInfo('formacao_contratacoes', $contratacao_id)->fetchObject();
    }*/
    //    public function insereInscrito($id)
//    {
//        $inscrito = $this->recuperaInscrito($id);
//
//        $phones = $this->recuperaTelInscrito($inscrito->id, 1);
//
//        //Tabela pessoa_fisicas
//        $pessoaFisica = [];
//        $pessoaFisica['nome'] = $inscrito->nome;
//        $pessoaFisica['nome_artistico'] = $inscrito->nome_artistico;
//        $pessoaFisica['rg'] = $inscrito->rg;
//        $pessoaFisica['passaporte'] = $inscrito->passaporte;
//        $pessoaFisica['cpf'] = $inscrito->cpf;
//        $pessoaFisica['ccm'] = $inscrito->ccm;
//        $pessoaFisica['data_nascimento'] = $inscrito->data_nascimento;
//        $pessoaFisica['nacionalidade_id'] = $inscrito->nacionalidade_id;
//        $pessoaFisica['email'] = $inscrito->email;
//
//        //Tabela pf_detalhes
//        $pfDetalhes = [];
//        $pfDetalhes['etnia_id'] = $inscrito->etnia_id;
//        $pfDetalhes['genero_id'] = $inscrito->genero_id;
//        $pfDetalhes['regiao_id'] = $inscrito->regiao_preferencial_id;
//        $pfDetalhes['grau_instrucao_id'] = $inscrito->grau_instrucao_id;
//        $pfDetalhes['curriculo'] = '';
//        $pfDetalhes['trans'] = $inscrito->trans == 'Sim' ? 1 : 0;
//        $pfDetalhes['pcd'] = $inscrito->pcd == 'Sim' ? 1 : 0;
//
//        //Tabela pf_enderecos
//        $pfEndereco = [];
//        $pfEndereco['logradouro'] = $inscrito->logradouro;
//        $pfEndereco['numero'] = $inscrito->numero;
//        $pfEndereco['complemento'] = $inscrito->complemento;
//        $pfEndereco['bairro'] = $inscrito->bairro;
//        $pfEndereco['cidade'] = $inscrito->cidade;
//        $pfEndereco['uf'] = $inscrito->uf;
//        $pfEndereco['cep'] = $inscrito->cep;
//
//        //Tabela pf_bancos
//        $pfBanco = [];
//        $pfBanco['banco_id'] = $inscrito->banco_id;
//        $pfBanco['agencia'] = $inscrito->agencia;
//        $pfBanco['conta'] = $inscrito->conta;
//
//        try {
//            $insertPf = DbModel::insert('pessoa_fisicas', $pessoaFisica);
//            if ($insertPf || DbModel::connection()->errorCode() == 0) {
//                $pessoaFisica_id = DbModel::connection()->lastInsertId();
//                $pfDetalhes['pessoa_fisica_id'] = $pessoaFisica_id;
//                $pfEndereco['pessoa_fisica_id'] = $pessoaFisica_id;
//                $pfBanco['pessoa_fisica_id'] = $pessoaFisica_id;
//
//
//                $insertDetalhes = DbModel::insert('pf_detalhes', $pfDetalhes);
//                if ($insertDetalhes || DbModel::connection()->errorCode() == 0) {
//                    $insertEndereco = DbModel::insert('pf_enderecos', $pfEndereco);
//                    if ($insertEndereco || DbModel::connection()->errorCode() == 0) {
//                        $insertBanco = DbModel::insert('pf_bancos', $pfBanco);
//                        if ($insertBanco || DbModel::connection()->errorCode() == 0) {
//                            foreach ($phones as $phone) {
//                                $pfPhone = [];
//                                $pfPhone['pessoa_fisica_id'] = $pessoaFisica_id;
//                                $pfPhone['telefone'] = $phone['telefone'];
//
//                                DbModel::insert('pf_telefones', $pfPhone);
//                            }
//                            if (DbModel::connection()->errorCode() == 0) {
//                                $alerta = [
//                                    'alerta' => 'sucesso',
//                                    'titulo' => 'Importação de inscrito',
//                                    'texto' => 'Importação de inscrito realizada com sucesso!',
//                                    'tipo' => 'success',
//                                    'location' => SERVERURL . 'formacao/resumo_inscrito&id=' . $id
//                                ];
//                                return MainModel::sweetAlert($alerta);
//                            }
//                        }
//                    }
//                }
//            }
//        } catch (Exception $e) {
//            $alerta = [
//                'alerta' => 'simples',
//                'titulo' => 'Erro!',
//                'texto' => 'Erro ao importar!<br>' . $e->getMessage() . '!',
//                'tipo' => 'error',
//                'location' => SERVERURL . 'formacao/resumo_inscrito&id=' . $id
//            ];
//            return MainModel::sweetAlert($alerta);
//        }
//    }


}


