<?php

class Config {

	private static $__loaded_config = array();
	private $__items = NULL;

	private function __construct(array &$__config) {
		$this->__items = (object) $__config;
	}

	public static function &load($__config) {
		//verifica si la fonfiguracion no ha sido ya cargada
		if (isset(self::$__loaded_config[$__config]))
			return self::$__loaded_config[$__config];

		//error si no existe el archivo
		if (!file_exists(APPPATH . 'config' . SEP . $__config . EXT))
			Error::set_no_file();

		//error si la variables de configuracion no existe o no es un array
		require_once APPPATH . 'config' . SEP . $__config . EXT;
		if (!isset($$__config) OR !is_array($$__config))
			Error::set_bad_file();

		//crea el objeto config
		$$__config = new Config($$__config);

		//retorna el objeto mientras lo guarda su referencia
		return self::$__loaded_config[$__config] = & $$__config;
	}

	public function item($__item) {
		return $this->__item->$$__item;
	}

	public function &get_all() {
		return $this->__items;
	}

}

/* end of config.php */