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
            'edita',
            'evento_cadastro',
            'evento_lista',
            'finalizar',
            'fomento_edital',
            'informacoes_complementares_cadastro',
            'inicio',
            'lider',
            'lider_cadastro',
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
                /** @TODO: Encontrar forma para que a edição de conta retorne ao módulo correto */
                $menu = "./views/modulos/fomentos/include/menu.php";
            }
        } else {
            $menu = "./views/template/menuExemplo.php";
        }

        return $menu;
    }
}