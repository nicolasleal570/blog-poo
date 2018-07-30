<?php 

class Cookie{
    
    /*--------------------------------*/
    /* VALIDANDO SI EXISTE UNA COOKIE */
    /*--------------------------------*/
    public static function exists($name){
        return (isset($_COOKIE[$name])) ? true : false;
    }

    /*-------------------------------*/
    /* DEVUELVE UNA COOKIE EXISTENTE */
    /*-------------------------------*/
    public static function get($name){
        return $_COOKIE[$name];
    }

    /*--------------------*/
    /* CREANDO UNA COOKIE */
    /*--------------------*/
    public static function put($name, $value, $expiry){
        if (setcookie($name, $value, time() + $expiry, '/')) {
            return true;
        }

        return false; 
    }

    /*-----------------------*/
    /* ELIMININAR UNA COOKIE */
    /*-----------------------*/
    public static function delete($name){
        self::put($name, '', time() - 1);
    }


}
