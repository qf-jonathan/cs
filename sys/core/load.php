<?php

class Load {

	static $_library = array();
	static $_helper = array();
	static $_config = array();

	public static function &library($__library) {
		if (isset(self::$_library[$__library]))
			return self::$_library[$__library];
	}

	public static function &helper($__helper) {
		if (isset(self::$_helper[$__helper]))
			return self::$_helper[$__helper];
	}

	public static function &config($__config) {
		$__config = strtolower($__config);
		
		//si la configuracion ya ha sido cargada la retorna de inmediato
		if (isset(self::$_config[$__config]))
			return self::$_config[$__config];
		
		//asigna la direccion del archivo de configuracion
		$file_name = APPPATH . 'config' . SEP . $__config . EXT;
		
		//si el archivo no existe finaliza la aplicacion
		if (!file_exists($file_name))
			exit('El archivo de configuracion "' . $__config . EXT . '" no existe');
		
		//incluye el archivo de configuracion
		require_once $file_name;
		
		//verifica si la configuracion esta corectamente definida
		if (!isset($$__config) OR !is_array($$__config))
			exit('El archivo de configuracion "' . $__config . EXT . '" no parece estar correctamente definido');
		
		//convierte el la configuracion a un objeto
		$$__config=(object)$$__config;
		
		//asigna y retorna la configuracion
		return self::$_config[$__config] = &$$__config;
	}

}

/* end of sys/core/load.php */
