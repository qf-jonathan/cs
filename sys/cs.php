<?php

if (!defined('SYSPATH'))
	exit('Acceso restringido');

require SYSPATH . 'core' . SEP . 'cs_base' . EXT;
require SYSPATH . 'core' . SEP . 'library' . EXT;
require SYSPATH . 'core' . SEP . 'config' . EXT;
require SYSPATH . 'core' . SEP . 'helper' . EXT;
require SYSPATH . 'core' . SEP . 'error' . EXT;
require SYSPATH . 'core' . SEP . 'view' . EXT;
require SYSPATH . 'core' . SEP . 'out' . EXT;
require SYSPATH . 'core' . SEP . 'db' . EXT;
require SYSPATH . 'core' . SEP . 'in' . EXT;

class CS {

	private $controller_path = '';
	private $controller = '';
	private $action = '';
	private $args = array();
	private $conf;

	public function __construct() {
		//carga la configuracion de sistema
		$this->conf = Config::load('config')->get_all();

		//verifica si esta definida una url de controlador y accion
		if (isset($_SERVER['PATH_INFO']) && $_SERVER['PATH_INFO'] !== '/') {

			if ($_SERVER['PATH_INFO'][0] !== '/')
				$_SERVER['PATH_INFO'] = '/' . $_SERVER['PATH_INFO'];

			//verifica si la url es valida
			if (!preg_match('/^(\/[a-z_0-9]+)+\/*$/', $_SERVER['PATH_INFO']))
				Error::set_404();

			//pone la direcciona base de los ccontroladores
			$path = APPPATH . 'class' . SEP . $this->conf->controller_path;

			if ($this->conf->controller_path == '')
				$path.=SEP;

			//recorre todos los segmentos de la url
			foreach (explode('/', $_SERVER['PATH_INFO']) as $segment) {

				//si el segmento no esta vacio
				if ($segment !== '') {

					//si no esta definido una direccion de controlador
					if ($this->controller_path === '') {
						$path.=$segment;

						//si existe el archivo del controlador
						if (file_exists($path . $this->conf->c_ext)) {
							$this->controller_path = $path . $this->conf->c_ext;
							$this->controller = $segment;
							//si no existe el archivo del controlador, pero si
							//si existe el directorio
						} else if (file_exists($path) && is_dir($path))
							$path.= SEP;
						//si no se encuentra el controlador ni el directorio
						else
							Error::set_404();
						//si el controlador esta definido y falta definir la accion
					} else if ($this->action === '')
						$this->action = $segment;
					//si estan definidos tanto el controlador como la accion
					else
						$this->args[] = $segment;
				}
			}

			//si no se define una accion para el controlador, ponemos la accion
			//por defecto
			if ($this->action === '')
				$this->action = $this->conf->default_action;

			//si no se define un controlador en la url
		} else {
			//asignamos la direccion del controlador de la url
			$this->controller_path = APPPATH . 'class' . SEP
					. $this->conf->controller_path . SEP .
					str_replace('/', SEP, $this->conf->default_controller) .
					$this->conf->c_ext;

			//si el archivo del controlador no existe
			if (!file_exists($this->controller_path))
				Error::set_404();

			//definimos el nombre del controlador
			$segments = explode('/', $this->conf->default_controller);
			$this->controller = end($segments);

			//definimos la accion y los argumentos por defecto
			$this->action = $this->conf->default_action;
			$this->args = $this->conf->default_args;
		}
	}

	public function run_app() {
		//verifica que la direccion del controlador haya sido
		//correctamente definido
		if ($this->controller_path === '')
			Error::set_404();

		//incluimos el archivo del controlador
		require_once $this->controller_path;

		//definimos el nombre de la clase del controlador asi como el nombre
		//de la accion
		$class = ucfirst($this->controller) . '_Controller';
		$method = $this->action . '_action';

		//verificamos la existencia de la clase
		if (!class_exists($class))
			Error::set_404();

		//verificamos la existencia de la accion
		if (!method_exists($class, $method))
			Error::set_404();

		//llamamos a la accion de la clases controlador
		call_user_func_array(array(new $class, $method), $this->args);
	}

}

//definimos una instancia de CodeStream y ejecutamos la aplicacion
$app = new CS;
$app->run_app();

/* end of sys/cs.php */
