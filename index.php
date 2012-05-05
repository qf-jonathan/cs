<?php

$app_path = 'app';
$sys_path = 'sys';

define('EXT', '.php');
define('SEP', DIRECTORY_SEPARATOR);
define('APPPATH', realpath($app_path) . SEP);
define('SYSPATH', realpath($sys_path) . SEP);

unset($app_path, $sys_path);

require_once SYSPATH . 'cs' . EXT;

/* end of index.php */
/* probando repositorio con c9.io */
