<?php 

class Config{
	
	public static function get($path = null){
		if ($path) {
			$config = $GLOBALS['config']; //METIENDO LA VARIABLE GLOBAL 'config' DENTRO DE UNA VARIABLE LOCAL
			$path = explode('/', $path);
			//print_r($path);

			//Extrayendo las direcciones de la variable global 'config'
			foreach ($path as $bit) { //Este loop se mete en todos los arreglos hasta llegar a la ultima configuracion
				if (isset($config[$bit])) { 
					$config = $config[$bit];
				}
			}

			return $config;
		}
		return false;
	}



}