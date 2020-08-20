<?php

// Para saber si estamos en servidor local
define('IS_LOCAL' , in_array($_SERVER['REMOTE_ADDR'], ['127.0.0.1', '::1']));

// La URL de nuestro proyecto
define('URL'      , (IS_LOCAL ? 'http://127.0.0.1/sistema-inventario/' : 'LA URL DE SU SERVIDOR EN PRODUCCIÓN'));

// Rutas para carpetas
define('DS'       , DIRECTORY_SEPARATOR);
define('HOME'     , __DIR__.DS);
define('APP'      , HOME.'app'.DS);
define('CONTROLLERS'   , HOME.'controllers'.DS);
define('MODELS', HOME.'models'.DS);
define("BACKUPS", MODELS.'backups'.DS);
define('VENDOR', HOME.'vendor'.DS);
define('VIEWS', HOME.'views'.DS);
define("TEMPLATES", VIEWS.'templates'.DS);


// Para archivos que vayamos a incluir en header o footer (css o js)
//define('CSS'      , URL.'assets/css/');
//define('IMG'      , URL.'assets/img/');
//define('JS'       , URL.'assets/js/');



// Autoload Composer
//require_once VENDOR.'autoload.php';

// Cargar todas las funciones
//require_once APP.'functions.php';