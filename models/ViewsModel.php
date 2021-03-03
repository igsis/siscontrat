<?php

class ViewsModel
{
    protected function verificaModulo ($mod) {
        $modulos = [
            "eventos",
            "formacao",
            "inicio",
            "jovemMonitor",
            "oficina",
            "pessoaFisica",
            "pessoaJurídica",
            "agendao",
            "fomentos",
            "administrativo",
        ];

        if (in_array($mod, $modulos)) {
            if (is_dir("./views/modulos/" . $mod)) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    protected function exibirViewModel($view, $modulo = "") {
        $whitelist = [
            'abertura_cadastro',
            'abertura_lista',
            'anexos',
            'anexos_lider',
            'anexos_proponente',
            'area_impressao',
            'arquivos_com_prod',
            'atracao_cadastro',
            'atracao_lista',
            'cadastro',
            'cargo_cadastro',
            'cargo_lista',
            'cargo_programa',
            'compara_capac',
            'complemento_oficina_cadastro',
            'concluir_pedido',
            'conclusao_busca',
            'coordenadoria_cadastro',
            'coordenadoria_lista',
            'dados_contratacao_cadastro',
            'dados_contratacao_lista',
            'dados_contratacao_lista_capac',
            'demais_anexos',
            'detalhes_contratacao',
            'detalhes_inscrito',
            'documento_cadastro',
            'documento_lista',
            'edita',
            'edital_anexos',
            'edital_anexos_cadastro',
            'edital_arquivado_lista',
            'edital_cadastro',
            'edital_lista',
            'empenho_cadastro',
            'evento_cadastro',
            'evento_lista',
            'exportar_inscritos_capac',
            'finalizar',
            'fomento_edital',
            'gerenciar_inscritos',
            'informacoes_complementares_cadastro',
            'inicio',
            'lider',
            'lider_cadastro',
            'linguagem_cadastro',
            'linguagem_lista',
            'listar_inscritos',
            'listar_inscritos',
            'login',
            'logout',
            'pagamento_busca',
            'pagamento_lista_parcelas',
            'pedido_contratacao_cadastro',
            'pedido_contratacao_lista',
            'pedido_edita_parcelas',
            'pedido_visualizar',
            'pesquisa_pf',
            'pf_cadastro',
            'pf_demais_anexos',
            'pf_lista',
            'pf_lista_capac',
            'pj_cadastro',
            'produtor_cadastro',
            'programa',
            'programa_cadastro',
            'programa_lista',
            'projeto_cadastro',
            'projeto_cadastro',
            'projeto_lista',
            'projeto_lista',
            'proponente',
            'proponente_lista',
            'recupera_senha',
            'representante',
            'representante_cadastro',
            'documento_lista',
            'documento_cadastro',
            'edital_anexos_cadastro',
            'mural',
            'categoria',
            'cadastra_categoria',
            'instituicoes',
            'instituicao_cadastro',
            'modulo',
            'cadastrar_modulo',
            'perfil',
            'perfil_cadastro',
            'aviso_cadastro',
            'verbas',
            'verbas_cadastro',
            'relacoes_juridicas',
            'cadastrar_relacoes',
            'usuarios',
            'cadastrar_usuarios',
            'resete_senha',
            'resumo_inscrito',
            'subprefeitura_cadastro',
            'subprefeitura_lista',
            'territorio_cadastro',
            'territorio_lista',
            'vigencia_cadastro',
            'vigencia_lista',
            "importar_capac"
        ];
        if (self::verificaModulo($modulo)) {
            if (in_array($view, $whitelist)) {
                if (is_file("./views/modulos/$modulo/$view.php")) {
                    $conteudo = "./views/modulos/$modulo/$view.php";
                } else {
                    $conteudo = "./views/modulos/$modulo/inicio.php";
                }
            } else {
                $conteudo = "./views/modulos/$modulo/inicio.php";
            }
        } elseif ($modulo == "login") {
            $conteudo = "login";
        } elseif ($modulo == "cadastro") {
            $conteudo = "cadastro";
        } elseif ($modulo == "index") {
            $conteudo = "login";
        } elseif ($modulo == "fomento_edital") {
            $conteudo = "fomento_edital";
        } elseif ($modulo == "recupera_senha") {
            $conteudo = "recupera_senha";
        } elseif ($modulo == "resete_senha") {
            $conteudo = "resete_senha";
        } else {
            $conteudo = "login";
        }

        return $conteudo;
    }

    protected function exibirMenuModel ($modulo) {
        if (self::verificaModulo($modulo)) {
            if (is_file("./views/modulos/$modulo/include/menu.php")) {
                $menu = "./views/modulos/$modulo/include/menu.php";
            } else {
                $menu = "./views/template/menuExemplo.php";
            }
        } else {
            $menu = "./views/template/menuExemplo.php";
        }

        return $menu;
    }

    protected function recuperaModulos($perfil_id) {
        $sqlModulos = "SELECT m.sigla, m.descricao, m.cor_id, m.sistema FROM modulo_perfis AS mp
                        INNER JOIN modulos AS m ON m.id = mp.modulo_id
                        WHERE mp.perfil_id = '$perfil_id'
                        ORDER BY 1";
        return (new DbModel)->consultaSimples($sqlModulos)->fetchAll(PDO::FETCH_OBJ);
    }
}