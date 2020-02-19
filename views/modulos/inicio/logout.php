<?php
$usuarioObj = new UsuarioController();
$usuarioObj->gravarLog("Fez Logout");
$usuarioObj->forcarFimSessao();