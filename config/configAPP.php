<?php
    define('SERVER', "127.0.0.1");
    define('DB', "siscontrat");
    define('USER', "root", true);
    define('PASS', "", true);

    define('SGDB', "mysql:host=".SERVER.";dbname=".DB);

    define('METHOD', 'AES-256-CBC', true);
    define('SECRET_KEY', 'S3cr3t', true);
    define('SECRET_IV', '123456', true);
