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
            'anexos',
            'anexos_lider',
            'anexos_proponente',
            'arquivos_com_prod',
            'atracao_cadastro',
            'atracao_lista',
            'cadastro',
            'complemento_oficina_cadastro',
            'demais_anexos',
            'detalhes_inscrito',
            'edita',
            'edital_anexos',
            'edital_arquivado_lista',
            'edital_cadastro',
            'edital_lista',
            'evento_cadastro',
            'evento_lista',
            'finalizar',
            'fomento_edital',
            'gerenciar_inscritos',
            'informacoes_complementares_cadastro',
            'inicio',
            'lider',
            'lider_cadastro',
            'listar_inscritos',
            'login',
            'logout',
            'pf_cadastro',
            'pj_cadastro',
            'produtor_cadastro',
            'programa',
            'projeto_cadastro',
            'projeto_lista',
            'proponente',
            'proponente_lista',
            'representante',
            'representante_cadastro',
            'mural',
            'categoria',
            'cadastra_categoria',
            'edita_categoria',
            'perfil',
            'aviso_cadastro',
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