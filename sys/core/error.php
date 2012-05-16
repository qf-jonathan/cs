<?php

class Error {

	public static function set_404($msg = '') {
		//TODO: definir errores HTML
		exit('No se encuentra la pagina solicitada');
	}

	public static function set_no_file($msg = '') {
		//TODO: definir errores de archivo inexistente
		exit('No se encuentra el archivo solicitado');
	}
	
	public static function set_bad_file($msg=''){
		//TODO: definir errores de archivos erroneos
		exit('No se encuentra el archivo solicitado');
	}

}

/* end of sys/core/error.php */
