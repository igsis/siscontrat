<?php
    define('SERVER', "127.0.0.1");

    define('DB1', "siscontrat");
    define('USER1', "siscontrat", true);
    define('PASS1', "siscontrat!@#", true);

    define('DB2', "capac_new");
    define('USER2', "capacnew", true);
    define('PASS2', "c1a2p3a4c5", true);

    define('SGDB1', "mysql:host=".SERVER.";dbname=".DB1);
    define('SGDB2', "mysql:host=".SERVER.";dbname=".DB2);

    define('METHOD', 'AES-256-CBC', true);
    define('SECRET_KEY', 'S3cr3t', true);
    define('SECRET_IV', '123456', true);
