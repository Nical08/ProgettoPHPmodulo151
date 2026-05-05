<?php

define('URL', 'http://localhost:8080/ProgettoPHPmodulo151/applications/');
// Su server esterno: define('URL', 'https://151.labosamt.ch/nome_cognome/applications/');

define('DB_HOST', 'localhost');
define('DB_NAME', 'progetto_php');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_CHARSET', 'utf8mb4');

define('SITE_NAME', 'Gestione Negozio Riparazioni');

spl_autoload_register(function ($class) {
    $paths = [
        'application/models/',
    ];
    foreach ($paths as $path) {
        $file = $path . $class . '.php';
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});

session_start();
