<?php

$config = array(
	/* controlador, accion y argumentos por defecto */
	'default_controller'=>	'hola/hola',
	'default_action'	=>	'index',
	'default_args'		=>	array('hola','jonathan'),
	
        /* directorio de controladores y modelos */
	'controller_path'	=>  'controller',
	'model_path'		=>  'controller',
	'view_path'			=>  '',
    
	/* extension de controladores, modelos y vistas */
	'c_ext'				=>	'.controller.php',
	'm_ext'				=>	'.model.php',
	'v_ext'				=>	'.view.php',
	
	/* site url base and index file */
	'base_url'			=>	'http://localhost/cs',
	'index'				=>	'index.php',
);

/* end of app/config/conf.php */
