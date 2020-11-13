<?php
if ($pedidoAjax) {
    require_once "../models/PessoaFisicaModel.php";
} else {
    require_once "./models/PessoaFisicaModel.php";
}

class PessoaFisicaController extends PessoaFisicaModel
{
    public function inserePessoaFisica($pagina,$retornaId = false){

        $dadosLimpos = PessoaFisicaModel::limparStringPF($_POST);

        /* cadastro */
        $insere = DbModel::insert('pessoa_fisicas', $dadosLimpos['pf']);
        if ($insere->rowCount()>0) {
            $id = DbModel::connection()->lastInsertId();

            if(isset($dadosLimpos['bc'])){
                if (count($dadosLimpos['bc']) > 0) {
                    $dadosLimpos['bc']['pessoa_fisica_id'] = $id;
                    DbModel::insert('pf_bancos', $dadosLimpos['bc']);
                }
            }

            if (isset($dadosLimpos['en'])) {
                if (count($dadosLimpos['en']) > 0) {
                    $dadosLimpos['en']['pessoa_fisica_id'] = $id;
                    DbModel::insert('pf_enderecos', $dadosLimpos['en']);
                }
            }

            if (isset($dadosLimpos['dr'])) {
                if (count($dadosLimpos['dr']) > 0) {
                    $dadosLimpos['dr']['pessoa_fisica_id'] = $id;
                    DbModel::insert('drts', $dadosLimpos['dr']);
                }
            }

            if (isset($dadosLimpos['ni'])) {
                if (count($dadosLimpos['ni']) > 0) {
                    $dadosLimpos['ni']['pessoa_fisica_id'] = $id;
                    DbModel::insert('nits', $dadosLimpos['ni']);
                }
            }

            if (count($dadosLimpos['telefones'])>0){
                foreach ($dadosLimpos['telefones'] as $telefone){
                    $telefone['pessoa_fisica_id'] = $id;
                    DbModel::insert('pf_telefones', $telefone);
                }
            }

            if (isset($dadosLimpos['of'])){
                if (count($dadosLimpos['of']) > 0) {
                    $dadosLimpos['of']['pessoa_fisica_id'] = $id;
                    DbModel::insert('pf_oficinas', $dadosLimpos['of']);
                }
            }

            if (isset($dadosLimpos['dt'])){
                if (count($dadosLimpos['dt']) > 0) {
                    $dadosLimpos['dt']['pessoa_fisica_id'] = $id;
                    DbModel::insert('pf_detalhes', $dadosLimpos['dt']);
                }
            }

            // if ($_SESSION['modulo_s'] == 6 || $_SESSION['modulo_s'] == 7){ //formação ou jovem monitor
            //     $_SESSION['origem_id_s'] = MainModel::encryption($id);
            // }

            if($retornaId){
                return $id;
            } else{
                $alerta = [
                    'alerta' => 'sucesso',
                    'titulo' => 'Pessoa Física',
                    'texto' => 'Pessoa Física cadastrada com sucesso!',
                    'tipo' => 'success',
                    'location' => SERVERURL.$pagina.'&id='.MainModel::encryption($id)
                ];
                return MainModel::sweetAlert($alerta);
            }
        }
        else {
            $pagina = explode("/",$pagina);
            $alerta = [
                'alerta' => 'simples',
                'titulo' => 'Erro!',
                'texto' => 'Erro ao salvar!',
                'tipo' => 'error',
                'location' => SERVERURL.$pagina[0].'/proponente'
            ];
        }
        /* ./cadastro */
        return MainModel::sweetAlert($alerta);
    }

    /* edita */
    public function editaPessoaFisica($id,$pagina,$retornaId = false){
        $idDecryp = MainModel::decryption($_POST['id']);

        $dadosLimpos = PessoaFisicaModel::limparStringPF($_POST);

        $edita = DbModel::update('pessoa_fisicas', $dadosLimpos['pf'], $idDecryp);
        if ($edita) {

            if (isset($dadosLimpos['bc'])) {
                if (count($dadosLimpos['bc']) > 0) {
                    $banco_existe = DbModel::consultaSimples("SELECT * FROM pf_bancos WHERE pessoa_fisica_id = '$idDecryp'");
                    if ($banco_existe->rowCount() > 0) {
                        DbModel::updateEspecial('pf_bancos', $dadosLimpos['bc'], "pessoa_fisica_id", $idDecryp);
                    } else {
                        $dadosLimpos['bc']['pessoa_fisica_id'] = $idDecryp;
                        DbModel::insert('pf_bancos', $dadosLimpos['bc']);
                    }
                }
            }

            if (isset($dadosLimpos['en'])) {
                if (count($dadosLimpos['en']) > 0) {
                    $endereco_existe = DbModel::consultaSimples("SELECT * FROM pf_enderecos WHERE pessoa_fisica_id = '$idDecryp'");
                    if ($endereco_existe->rowCount() > 0) {
                        DbModel::updateEspecial('pf_enderecos', $dadosLimpos['en'], "pessoa_fisica_id", $idDecryp);
                    } else {
                        $dadosLimpos['en']['pessoa_fisica_id'] = $idDecryp;
                        DbModel::insert('pf_enderecos', $dadosLimpos['en']);
                    }
                }
            }

            if (count($dadosLimpos['telefones'])>0){
                $telefone_existe = DbModel::consultaSimples("SELECT * FROM pf_telefones WHERE pessoa_fisica_id = '$idDecryp'");

                if ($telefone_existe->rowCount()>0){
                    DbModel::deleteEspecial('pf_telefones', "pessoa_fisica_id",$idDecryp);
                }
                foreach ($dadosLimpos['telefones'] as $telefone){
                    $telefone['pessoa_fisica_id'] = $idDecryp;
                    DbModel::insert('pf_telefones', $telefone);
                }
            }

            if (isset($dadosLimpos['ni'])) {
                if (isset($dadosLimpos['ni'])) {
                    if (count($dadosLimpos['ni']) > 0) {
                        $nit_existe = DbModel::consultaSimples("SELECT * FROM nits WHERE pessoa_fisica_id = '$idDecryp'");
                        if ($nit_existe->rowCount() > 0) {
                            DbModel::updateEspecial('nits', $dadosLimpos['ni'], "pessoa_fisica_id", $idDecryp);
                        } else {
                            $dadosLimpos['ni']['pessoa_fisica_id'] = $idDecryp;
                            DbModel::insert('nits', $dadosLimpos['ni']);
                        }
                    }
                }
            }

            if (isset($dadosLimpos['dr'])) {
                if (count($dadosLimpos['dr']) > 0) {
                    $drt_existe = DbModel::consultaSimples("SELECT * FROM drts WHERE pessoa_fisica_id = '$idDecryp'");
                    if ($drt_existe->rowCount() > 0) {
                        DbModel::updateEspecial('drts', $dadosLimpos['dr'], "pessoa_fisica_id", $idDecryp);
                    } else {
                        $dadosLimpos['dr']['pessoa_fisica_id'] = $idDecryp;
                        DbModel::insert('drts', $dadosLimpos['dr']);
                    }
                }
            }

            if (isset($dadosLimpos['of'])){
                if (count($dadosLimpos['of']) > 0) {
                    $oficina_existe = DbModel::consultaSimples("SELECT * FROM pf_oficinas WHERE pessoa_fisica_id = '$idDecryp'");
                    if ($oficina_existe->rowCount() > 0) {
                        DbModel::updateEspecial('pf_oficinas', $dadosLimpos['of'], "pessoa_fisica_id", $idDecryp);
                    } else {
                        $dadosLimpos['of']['pessoa_fisica_id'] = $idDecryp;
                        DbModel::insert('pf_oficinas', $dadosLimpos['of']);
                    }
                }
            }

            if (isset($dadosLimpos['dt'])){
                if (count($dadosLimpos['dt']) > 0) {
                    $detalhe_existe = DbModel::consultaSimples("SELECT * FROM pf_detalhes WHERE pessoa_fisica_id = '$idDecryp'");
                    if ($detalhe_existe->rowCount() > 0) {
                        $dadosLimpos['dt']['trans'] = isset($dadosLimpos['dt']['trans']) ? $dadosLimpos['dt']['trans'] : 0;
                        $dadosLimpos['dt']['pcd'] = isset($dadosLimpos['dt']['pcd']) ? $dadosLimpos['dt']['pcd'] : 0;
                        DbModel::updateEspecial('pf_detalhes', $dadosLimpos['dt'], "pessoa_fisica_id", $idDecryp);
                    } else {
                        $dadosLimpos['dt']['pessoa_fisica_id'] = $idDecryp;
                        DbModel::insert('pf_detalhes', $dadosLimpos['dt']);
                    }
                }
            }

            // if ($_SESSION['modulo_s'] == 6 || $_SESSION['modulo_s'] == 7){ //formação ou jovem monitor
            //     $_SESSION['origem_id_s'] = $id;
            // }

            if($retornaId){
                return $idDecryp;
            } else{
                $alerta = [
                    'alerta' => 'sucesso',
                    'titulo' => 'Pessoa Física',
                    'texto' => 'Pessoa Física editada com sucesso!',
                    'tipo' => 'success',
                    'location' => SERVERURL.$pagina.'&id='.$id
                ];
                return MainModel::sweetAlert($alerta);
            }

        } else {
            $pagina = explode("/",$pagina);
            $alerta = [
                'alerta' => 'simples',
                'titulo' => 'Erro!',
                'texto' => 'Erro ao salvar!',
                'tipo' => 'error',
                'location' => SERVERURL.$pagina[0].'/proponente'
            ];
        }
        return MainModel::sweetAlert($alerta);
    }

    public function recuperaPessoaFisica($id, $capac = false) {
        $id = MainModel::decryption($id);
        $pf = DbModel::consultaSimples(
            "SELECT pf.*, pe.*, pb.*, po.*, d.*, n.*, n2.nacionalidade, b.banco, b.codigo, pd.*, e.descricao, r.nome as regiao, gi.grau_instrucao
            FROM pessoa_fisicas AS pf
            LEFT JOIN pf_enderecos pe on pf.id = pe.pessoa_fisica_id
            LEFT JOIN pf_bancos pb on pf.id = pb.pessoa_fisica_id
            LEFT JOIN pf_oficinas po on pf.id = po.pessoa_fisica_id
            LEFT JOIN drts d on pf.id = d.pessoa_fisica_id
            LEFT JOIN nits n on pf.id = n.pessoa_fisica_id
            LEFT JOIN nacionalidades n2 on pf.nacionalidade_id = n2.id
            LEFT JOIN bancos b on pb.banco_id = b.id
            LEFT JOIN pf_detalhes pd on pf.id = pd.pessoa_fisica_id
            LEFT JOIN etnias e on pd.etnia_id = e.id
            LEFT JOIN regiaos r on pd.regiao_id = r.id
            LEFT JOIN grau_instrucoes gi on pd.grau_instrucao_id = gi.id
            WHERE pf.id = '$id'", $capac);

        $pf = $pf->fetch(PDO::FETCH_ASSOC);
        $telefones = DbModel::consultaSimples("SELECT * FROM pf_telefones WHERE pessoa_fisica_id = '$id'", $capac)->fetchAll(PDO::FETCH_ASSOC);

        foreach ($telefones as $key => $telefone) {
            $pf['telefones']['tel_'.$key] = $telefone['telefone'];
        }
        return $pf;
    }

    public function recuperaPessoaFisicaCapac($id) {
        $id = MainModel::decryption($id);
        $pf = DbModel::consultaSimples(
            "SELECT pf.*, pe.*, pb.*, po.*, d.*, n.*, n2.nacionalidade, b.banco, b.codigo, pd.*, e.descricao, gi.grau_instrucao
            FROM pessoa_fisicas AS pf
            LEFT JOIN pf_enderecos pe on pf.id = pe.pessoa_fisica_id
            LEFT JOIN pf_bancos pb on pf.id = pb.pessoa_fisica_id
            LEFT JOIN pf_oficinas po on pf.id = po.pessoa_fisica_id
            LEFT JOIN drts d on pf.id = d.pessoa_fisica_id
            LEFT JOIN nits n on pf.id = n.pessoa_fisica_id
            LEFT JOIN nacionalidades n2 on pf.nacionalidade_id = n2.id
            LEFT JOIN bancos b on pb.banco_id = b.id
            LEFT JOIN pf_detalhes pd on pf.id = pd.pessoa_fisica_id
            LEFT JOIN etnias e on pd.etnia_id = e.id
            LEFT JOIN grau_instrucoes gi on pd.grau_instrucao_id = gi.id
            WHERE pf.id = '$id'", true);

        $pf = $pf->fetch(PDO::FETCH_ASSOC);
        $telefones = DbModel::consultaSimples("SELECT * FROM pf_telefones WHERE pessoa_fisica_id = '$id'", true)->fetchAll(PDO::FETCH_ASSOC);

        foreach ($telefones as $key => $telefone) {
            $pf['telefones']['tel_'.$key] = $telefone['telefone'];
        }
        return $pf;
    }


    public function recuperaPfDados($pessoafisica_id)
    {
        return DbModel::consultaSimples("SELECT pfd.rede_social, g.genero, s.subprefeitura, e.descricao, gi.grau_instrucao FROM `fom_pf_dados` AS pfd
            INNER JOIN generos g on pfd.genero_id = g.id
            INNER JOIN subprefeituras s on pfd.subprefeitura_id = s.id
            INNER JOIN etnias e on pfd.etnia_id = e.id
            INNER JOIN grau_instrucoes gi on pfd.grau_instrucao_id = gi.id
            WHERE pessoa_fisicas_id = '$pessoafisica_id'",true);
    }

    public function getCPF($cpf){
        $consulta_pf_cpf = DbModel::consultaSimples("SELECT id, cpf FROM pessoa_fisicas WHERE cpf = '$cpf'");
        return $consulta_pf_cpf;
    }

    public function getPassaporte($passaporte){
        $consulta_pf_pass = DbModel::consultaSimples("SELECT id, passaporte FROM pessoa_fisicas WHERE passaporte = '$passaporte'");
        return $consulta_pf_pass;
    }

    /**
     * @param int|string $pessoa_fisica_id
     * @param int $validacaoTipo <p>Deve conter o valor 1 para validação de pessoa física e 2 para validação de líder</p>
     * @param int|null $evento_id
     * @return array|bool
     */
    public function validaPf($pessoa_fisica_id, $validacaoTipo, $evento_id = null, $tipo_documentos = null){
        $tipo = gettype($pessoa_fisica_id);
        if ($tipo == "string") {
            $pessoa_fisica_id = MainModel::decryption($pessoa_fisica_id);
        }
        $pf = PessoaFisicaModel::validaPfModel($pessoa_fisica_id, $validacaoTipo, $evento_id,$tipo_documentos);
        return $pf;
    }

    public function listaPf ($capac = false) {
        return DbModel::consultaSimples('SELECT * FROM  pessoa_fisicas', $capac)->fetchAll(PDO::FETCH_OBJ);;
    }

    public function recuperaIdPfSis($id)
    {
        //função para pegar id de pf no sis baseado no cpf que vem do capac ao importar dados para contratação
        $cpf = DbModel::consultaSimples("SELECT * FROM pessoa_fisicas WHERE id = $id", true)->fetchObject()->cpf;
        $idPf = $this::getCpf($cpf)->fetchObject()->id; //sis
        return $idPf;
    }

    public function comparaPf($cpf){
        $pfSis = DbModel::consultaSimples("SELECT * FROM pessoa_fisicas WHERE cpf = '$cpf'")->fetchObject();
        $pfSisEndereco = DbModel::consultaSimples("SELECT * FROM pf_enderecos WHERE pessoa_fisica_id = $pfSis->id")->fetchObject();
        $pfSisDetalhes = DbModel::consultaSimples("SELECT * FROM pf_detalhes WHERE pessoa_fisica_id = $pfSis->id")->fetchObject();
        $pfSisTelefone = DbModel::consultaSimples("SELECT * FROM pf_telefones WHERE pessoa_fisica_id = $pfSis->id")->fetchObject();
        $pfSisBanco = DbModel::consultaSimples("SELECT * FROM pf_bancos WHERE pessoa_fisica_id = $pfSis->id")->fetchObject();

        $pfCapac = DbModel::consultaSimples("SELECT * FROM pessoa_fisicas WHERE cpf = '$cpf'", true)->fetchObject();
        $pfCapacEndereco = DbModel::consultaSimples("SELECT * FROM pf_enderecos WHERE pessoa_fisica_id = $pfCapac->id", true)->fetchObject();
        $pfCapacDetalhes = DbModel::consultaSimples("SELECT * FROM pf_detalhes WHERE pessoa_fisica_id = $pfCapac->id", true)->fetchObject();
        $pfCapacTelefone = DbModel::consultaSimples("SELECT * FROM pf_telefones WHERE pessoa_fisica_id = $pfCapac->id", true)->fetchObject();
        $pfCapacBanco = DbModel::consultaSimples("SELECT * FROM pf_bancos WHERE pessoa_fisica_id = $pfCapac->id", true)->fetchObject();

        //pessoa_fisicas
        if ($pfCapac->ultima_atualizacao > $pfSis->ultima_atualizacao){ //verificar se ultima atualização foi no sis
            if ($pfSis->nome != $pfCapac->nome) return false;
            if ($pfSis->nome_artistico != $pfCapac->nome_artistico) return false;
            if ($pfSis->rg != $pfCapac->rg) return false;
            if ($pfSis->cpf != $pfCapac->cpf) return false;
            if ($pfSis->ccm != $pfCapac->ccm) return false;
            if ($pfSis->data_nascimento != $pfCapac->data_nascimento) return false;
            if ($pfSis->nacionalidade_id != $pfCapac->nacionalidade_id) return false;
            if ($pfSis->email != $pfCapac->email) return false;

            //pfEndereco
            if($pfSisEndereco->logradouro != $pfCapacEndereco->logradouro) return false;
            if($pfSisEndereco->numero != $pfCapacEndereco->numero) return false;
            if($pfSisEndereco->complemento != $pfCapacEndereco->complemento ) return false;
            if($pfSisEndereco->bairro != $pfCapacEndereco->bairro) return false;
            if($pfSisEndereco->cidade != $pfCapacEndereco->cidade) return false;
            if($pfSisEndereco->uf != $pfCapacEndereco->uf) return false;
            if($pfSisEndereco->cep != $pfCapacEndereco->cep) return false;

            //pf_detalhes
            if($pfSisDetalhes->etnia_id != $pfCapacDetalhes->etnia_id) return false;
            if($pfSisDetalhes->grau_instrucao_id != $pfCapacDetalhes->grau_instrucao_id) return false;
            if($pfSisDetalhes->trans != $pfCapacDetalhes->trans) return false;
            if($pfSisDetalhes->pcd != $pfCapacDetalhes->pcd) return false;
            if($pfSisDetalhes->genero_id != $pfCapacDetalhes->genero_id) return false;

            //pf_telefone
            if($pfSisTelefone->telefone != $pfCapacTelefone->telefone) return false;

            //pf_bancos
            if($pfSisBanco->banco_id != $pfCapacBanco->banco_id) return false;
            if($pfSisBanco->agencia != $pfCapacBanco->agencia) return false;
            if($pfSisBanco->conta != $pfCapacBanco->conta) return false;

            return true;
        }
        return true;
    }
}