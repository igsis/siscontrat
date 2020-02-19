<?php
define('SERVERURL', "http://{$_SERVER['HTTP_HOST']}/siscontrat/");
define('SIS2URL', "http://{$_SERVER['HTTP_HOST']}siscontrat2/visual/index.php");
define('NOMESIS', "SisContrat");
date_default_timezone_set('America/Sao_Paulo');
ini_set('session.gc_maxlifetime', 60*60); // 60 minutos