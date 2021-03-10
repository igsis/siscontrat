<?php
define('SERVERURL', "http://{$_SERVER['HTTP_HOST']}/siscontrat/");
define('SIS2URL', "http://{$_SERVER['HTTP_HOST']}/siscontrat2/visual/index.php");
define('CAPACURL', "http://{$_SERVER['HTTP_HOST']}/capac/");
define('NOMESIS', "SisContrat");
define('SMTP', 'no.replay@teste.com');
define('SENHASMTP', 'senha');
date_default_timezone_set('America/Fortaleza');
ini_set('session.gc_maxlifetime', 60*60); // 60 minutos