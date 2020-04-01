<?php
    define('SERVER', "127.0.0.1");

    define('DB1', "siscontrat");
    define('USER1', "root", true);
    define('PASS1', "", true);

    define('DB2', "capac_new");
    define('USER2', "root", true);
    define('PASS2', "", true);

    define('SGDB1', "mysql:host=".SERVER.";dbname=".DB1);
    define('SGDB2', "mysql:host=".SERVER.";dbname=".DB2);

    define('METHOD', 'AES-256-CBC', true);
    define('SECRET_KEY', 'S3cr3t', true);
    define('SECRET_IV', '123456', true);