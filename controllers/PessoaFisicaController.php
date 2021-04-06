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

            if (isset($dadosLimpos['ns'])){
                if (count($dadosLimpos['ns']) > 0) {
                    $dadosLimpos['ns']['pessoa_fisica_id'] = $id;
                    DbModel::insert('pf_nome_social', $dadosLimpos['ns']);
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

        $dadosLimpos['pf']['ultima_atualizacao'] = date('Y-m-d H:i:s');

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

            if (isset($dadosLimpos['telefones'])) {
                if (count($dadosLimpos['telefones']) > 0) {
                    $telefone_existe = DbModel::consultaSimples("SELECT * FROM pf_telefones WHERE pessoa_fisica_id = '$idDecryp'");

                    if ($telefone_existe->rowCount() > 0) {
                        DbModel::deleteEspecial('pf_telefones', "pessoa_fisica_id", $idDecryp);
                    }
                    foreach ($dadosLimpos['telefones'] as $telefone) {
                        $telefone['pessoa_fisica_id'] = $idDecryp;
                        DbModel::insert('pf_telefones', $telefone);
                    }
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

            if (isset($dadosLimpos['ns'])) {
                if (count($dadosLimpos['ns']) > 0) {
                    $nome_social_existe = DbModel::consultaSimples("SELECT * FROM pf_nome_social WHERE pessoa_fisica_id = '$idDecryp'");
                    if ($nome_social_existe->rowCount() > 0) {
                        DbModel::updateEspecial('pf_nome_social', $dadosLimpos['ns'], "pessoa_fisica_id", $idDecryp);
                    } else {
                        $dadosLimpos['ns']['pessoa_fisica_id'] = $idDecryp;
                        DbModel::insert('pf_nome_social', $dadosLimpos['ns']);
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
            "SELECT pf.*, pe.*, pb.*, d.*, n.*, n2.nacionalidade, b.banco, b.codigo, pd.*, e.descricao, gi.grau_instrucao, ns.nome_social 
            FROM pessoa_fisicas AS pf
            LEFT JOIN pf_enderecos pe on pf.id = pe.pessoa_fisica_id
            LEFT JOIN pf_bancos pb on pf.id = pb.pessoa_fisica_id
            LEFT JOIN drts d on pf.id = d.pessoa_fisica_id
            LEFT JOIN nits n on pf.id = n.pessoa_fisica_id
            LEFT JOIN nacionalidades n2 on pf.nacionalidade_id = n2.id
            LEFT JOIN bancos b on pb.banco_id = b.id
            LEFT JOIN pf_detalhes pd on pf.id = pd.pessoa_fisica_id
            LEFT JOIN etnias e on pd.etnia_id = e.id
            LEFT JOIN grau_instrucoes gi on pd.grau_instrucao_id = gi.id
            LEFT JOIN pf_nome_social ns on pf.id = ns.pessoa_fisica_id
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

    public function recuperaPfDados($pessoafisica_id, $capac = true)
    {
        return DbModel::consultaSimples("SELECT pfd.rede_social, g.genero, s.subprefeitura, e.descricao, gi.grau_instrucao FROM `fom_pf_dados` AS pfd
            INNER JOIN generos g on pfd.genero_id = g.id
            INNER JOIN subprefeituras s on pfd.subprefeitura_id = s.id
            INNER JOIN etnias e on pfd.etnia_id = e.id
            INNER JOIN grau_instrucoes gi on pfd.grau_instrucao_id = gi.id
            WHERE pessoa_fisicas_id = '$pessoafisica_id'", $capac);
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
        $pf = PessoaFisicaModel::validaPfModverificaDivergenciael($pessoa_fisica_id, $validacaoTipo, $evento_id,$tipo_documentos);
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

    public function importarPf($id, $bool = false)
    {
        $idDecryp = MainModel::decryption($id);

        $sqlBase = "SELECT
                        pf.id,
                        pf.nome AS 'pf_nome',
                        pf.nome_artistico AS 'pf_nome_artistico',
                        pf.rg AS 'pf_rg',
                        pf.passaporte AS 'pf_passaporte',
                        pf.cpf AS 'pf_cpf',
                        pf.ccm AS 'pf_ccm',
                        pf.data_nascimento AS 'pf_data_nascimento',
                        pf.nacionalidade_id AS 'pf_nacionalidade_id',
                        pf.email AS 'pf_email',
                        pf.ultima_atualizacao AS 'pf_ultima_atualizacao',
                        pe.logradouro AS 'en_logradouro',
                        pe.numero AS 'en_numero',
                        pe.complemento AS 'en_complemento',
                        pe.bairro AS 'en_bairro',
                        pe.cidade AS 'en_cidade',
                        pe.uf AS 'en_uf',
                        pe.cep AS 'en_cep',
                        pd.etnia_id AS 'dt_etnia_id',
                        pd.genero_id AS 'dt_genero_id',
                        pd.grau_instrucao_id AS 'dt_grau_instrucao_id',
                        pd.trans AS 'dt_trans',
                        pd.pcd AS 'dt_pcd',
                        d.drt AS 'dr_drt',
                        n.nit AS 'ni_nit'
                    FROM pessoa_fisicas AS pf
                    LEFT JOIN pf_enderecos AS pe on pf.id = pe.pessoa_fisica_id
                    LEFT JOIN pf_bancos AS pb on pf.id = pb.pessoa_fisica_id
                    LEFT JOIN pf_detalhes AS pd on pf.id = pd.pessoa_fisica_id
                    LEFT JOIN drts AS d on pf.id = d.pessoa_fisica_id
                    LEFT JOIN nits AS n on pf.id = n.pessoa_fisica_id";

        $sqlCapac = $sqlBase." WHERE pf.id = '$idDecryp'";

        $pfCapac = DbModel::consultaSimples($sqlCapac, true)->fetch(PDO::FETCH_ASSOC);

        $telefones = DbModel::consultaSimples("SELECT * FROM pf_telefones WHERE pessoa_fisica_id = '$idDecryp'", true)->fetchAll(PDO::FETCH_ASSOC);

        foreach ($telefones as $key => $telefone) {
            $pfCapac['te_telefone_'.$key] = $telefone['telefone'];
        }

        DbModel::killConn();

        $sqlSis = $sqlBase." WHERE pf.cpf = '{$pfCapac['pf_cpf']}'";
        $queryPfSis = DbModel::consultaSimples($sqlSis);

        if ($queryPfSis->rowCount()) {
            $pfSis = $queryPfSis->fetch(PDO::FETCH_ASSOC);

            $telefones = DbModel::consultaSimples("SELECT * FROM pf_telefones WHERE pessoa_fisica_id = '{$pfSis['id']}'")->fetchAll(PDO::FETCH_ASSOC);

            foreach ($telefones as $key => $telefone) {
                $pfSis['te_telefone_'.$key] = $telefone['telefone'];
            }

            if (parent::verificaDivergencia($pfCapac, $pfSis, true)) {
                if ($bool) {
                    return false;
                }
                $alerta = [
                    'alerta' => 'sucesso',
                    'titulo' => 'O CPF possui divergencias',
                    'texto' => 'O CPF selecionado já possui cadastro no Siscontrat, selecione os dados que deseja atualizar antes de completar a importação',
                    'tipo' => 'warning',
                    'location' => SERVERURL . 'formacao/compara_capac&id=' . $id
                ];
            } else {
                if ($bool) {
                    return $pfSis['id'];
                }
                $alerta = [
                    'alerta' => 'sucesso',
                    'titulo' => 'Pessoa Física Importada',
                    'texto' => 'A pessoa física selecionada foi importada com sucesso!',
                    'tipo' => 'success',
                    'location' => SERVERURL . 'formacao/pf_cadastro&id=' . MainModel::encryption($pfSis['id']) . '&import=1'
                ];
            }
        } else {
            unset($pfCapac['id']);
            $pfCapac['pf_ultima_atualizacao'] = date('Y-m-d H:i:s');
            $_POST = $pfCapac;
            $insert = self::inserePessoaFisica("", true);
            if ($insert) {
                $id = $insert;
                if ($bool) {
                    return $id;
                }
                $alerta = [
                    'alerta' => 'sucesso',
                    'titulo' => 'Pessoa Física Importada',
                    'texto' => 'A pessoa física selecionada foi importada com sucesso!',
                    'tipo' => 'success',
                    'location' => SERVERURL . 'formacao/pf_cadastro&id=' . MainModel::encryption($id) . '&import=1'
                ];
            }
        }

        return MainModel::sweetAlert($alerta);
    }

    public function comparaPf($id)
    {
        $id = MainModel::decryption($id);
        $dados = [];

        $sqlBase = "SELECT
                        pf.id,
                        pf.nome AS 'pf_nome',
                        pf.nome_artistico AS 'pf_nome_artistico',
                        pf.rg AS 'pf_rg',
                        pf.passaporte AS 'pf_passaporte',
                        pf.cpf AS 'pf_cpf',
                        pf.ccm AS 'pf_ccm',
                        pf.data_nascimento AS 'pf_data_nascimento',
                        pf.nacionalidade_id AS 'pf_nacionalidade_id',
                        pf.email AS 'pf_email',
                        pf.ultima_atualizacao AS 'pf_ultima_atualizacao',
                        pe.logradouro AS 'en_logradouro',
                        pe.numero AS 'en_numero',
                        pe.complemento AS 'en_complemento',
                        pe.bairro AS 'en_bairro',
                        pe.cidade AS 'en_cidade',
                        pe.uf AS 'en_uf',
                        pe.cep AS 'en_cep',
                        pd.etnia_id AS 'dt_etnia_id',
                        pd.genero_id AS 'dt_genero_id',
                        pd.grau_instrucao_id AS 'dt_grau_instrucao_id',
                        pd.trans AS 'dt_trans',
                        pd.pcd AS 'dt_pcd',
                        d.drt AS 'dr_drt',
                        n.nit AS 'ni_nit'
                    FROM pessoa_fisicas AS pf
                    LEFT JOIN pf_enderecos AS pe on pf.id = pe.pessoa_fisica_id
                    LEFT JOIN pf_bancos AS pb on pf.id = pb.pessoa_fisica_id
                    LEFT JOIN pf_detalhes AS pd on pf.id = pd.pessoa_fisica_id
                    LEFT JOIN drts AS d on pf.id = d.pessoa_fisica_id
                    LEFT JOIN nits AS n on pf.id = n.pessoa_fisica_id";

        $sqlCapac = $sqlBase." WHERE pf.id = '$id'";

        $pfCapac = DbModel::consultaSimples($sqlCapac, true)->fetch(PDO::FETCH_ASSOC);

        $telefones = DbModel::consultaSimples("SELECT * FROM pf_telefones WHERE pessoa_fisica_id = '$id'", true)->fetchAll(PDO::FETCH_ASSOC);

        foreach ($telefones as $key => $telefone) {
            $pfCapac['te_telefone_'.$key] = $telefone['telefone'];
        }

        DbModel::killConn();

        $sqlSis = $sqlBase." WHERE pf.cpf = '{$pfCapac['pf_cpf']}'";
        $pfSis = DbModel::consultaSimples($sqlSis)->fetch(PDO::FETCH_ASSOC);

        $telefones = DbModel::consultaSimples("SELECT * FROM pf_telefones WHERE pessoa_fisica_id = '{$pfSis['id']}'")->fetchAll(PDO::FETCH_ASSOC);

        foreach ($telefones as $key => $telefone) {
            $pfSis['te_telefone_'.$key] = $telefone['telefone'];
        }

        /** @var array|bool $dadosDivergentes */
        $dadosDivergentes = parent::verificaDivergencia($pfCapac, $pfSis);

        if ($dadosDivergentes) {
            foreach ($dadosDivergentes as $dado) {
                $dados['dadosCapac'][$dado] = $pfCapac[$dado];
                $dados['dadosSis'][$dado] = $pfSis[$dado] ?? "";
            }
        }

        $dados['pf_nome'] = $pfCapac['pf_nome'];
        $dados['pf_cpf'] = $pfCapac['pf_cpf'];
        $dados['id'] = $pfSis['id'];
        $dados['dadosCapac']['pf_ultima_atualizacao'] = $pfCapac['pf_ultima_atualizacao'];
        $dados['dadosSis']['pf_ultima_atualizacao'] = $pfSis['pf_ultima_atualizacao'];

        return $dados;
    }

    /**
     * <p>Função utilizada no arquivo <i>compara_capac.php</i> para retornar o dado de um determinado ID</p>
     * @param $key
     * @param $valor
     * @param bool $append
     */
    public function recuperaDadoPorId($key, $valor, $append = true)
    {
        $camposIds = ['pf_nacionalidade_id', 'dt_etnia_id', 'dt_genero_id', 'dt_grau_instrucao_id', 'dt_trans', 'dt_pcd',];
        if (in_array($key, $camposIds)) {
            switch ($key) {
                case 'pf_nacionalidade_id':
                    $dado = DbModel::getInfo('nacionalidades', $valor)->fetchObject()->nacionalidade;
                    break;
                case 'dt_etnia_id':
                    $dado = DbModel::getInfo('etnias', $valor)->fetchObject()->descricao;
                    break;
                case 'dt_genero_id':
                    $dado = DbModel::getInfo('generos', $valor)->fetchObject()->genero;
                    break;
                case 'dt_grau_instrucao_id':
                    $dado = DbModel::getInfo('grau_instrucoes', $valor)->fetchObject()->grau_instrucao;
                    break;
                case 'dt_trans':
                    $dado = $valor == 1 ? "Sim" : "Não";
                    break;
                case 'dt_pcd':
                    $dado = $valor == 1 ? "Sim" : "Não";
                    break;
                default:
                    break;
            }
            if ($append) { ?>
                <div class="input-group-append">
                    <span class="input-group-text "><?= "$valor = $dado" ?></span>
                </div>
            <?php } else { ?>
                <div class="input-group-prepend">
                    <span class="input-group-text "><?= "$valor = $dado" ?></span>
                </div>
            <?php }
        }
    }
}