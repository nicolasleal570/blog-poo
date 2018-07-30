<?php 

class Hash{
    
    /*-----------------------------------------------*/
    /* CREA UNA NUEVA STRING CON LA SALT CONCATENADA */
    /*-----------------------------------------------*/
    public static function make($string, $salt = ''){
        return hash('sha256', $string . $salt);
    }

    /*---------------------*/
    /* CREA UNA NUEVA SALT */
    /*---------------------*/
    public static function salt($length){
        return mcrypt_create_iv($length); //PHP 5.0
        //return random_bytes($length); //PHP 7.0
    }

    /*-----------------*/
    /* RETORNA EL HASH */
    /*-----------------*/
    public static function unique(){
        return self::make(uniqid());
    }


}
