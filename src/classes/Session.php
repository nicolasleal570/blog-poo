<?php 

class Session{

    /*--------------------------------------------*/
    /* COMPRUEBA QUE LA VARIABLE DE SESION EXISTE */
    /*--------------------------------------------*/
    public static function exists($name){
        return (isset($_SESSION[$name])) ? true : false;
    }

    /*-------------------------------------------*/
    /* DEVUELVE UNA VARIABLE DE SESION EXISTENTE */
    /*-------------------------------------------*/
    public static function get($name){
        return $_SESSION[$name];
    }
    
    /*-------------------------------------------*/
    /* RETORNA EL VALOR DE LA VARIABLE DE SESION */
    /*-------------------------------------------*/
    public static function put($name, $value){
        return $_SESSION[$name] = $value;
    }

    /*--------------------------------*/
    /* ELIMINA UNA VARIABLE DE SESION */
    /*--------------------------------*/
    public static function delete($name){
        if (self::exists($name)) {
            unset($_SESSION[$name]);
        }
    }

    /*---------------------------------------------*/
    /* ENVIA MENSAJES DE CONFIRMACION AL INDEX.PHP */
    /*---------------------------------------------*/
    public static function flash($name, $string = ''){
        if (self::exists($name)) {
            $session = self::get($name);

            self::delete($name);
            return $session;
        }else{
            self::put($name, $string);
        }
    }



}
