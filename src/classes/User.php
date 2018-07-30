<?php

class User{
    
    private $_db,
            $_data,
            $_sessionName,
            $_cookieName,
            $isLoggedIn;

    /*-------------------------------*/
    /* CREANDO LA INSTANCIA DE LA DB */
    /*-------------------------------*/
    public function __construct($user = null) {
        $this->_db = DB::getInstance();

        $this->_sessionName = Config::get('session/session_name');
        $this->_cookieName = Config::get('remember/cookie_name');

        if (!$user) {
            if(Session::exists($this->_sessionName)) {
                $user = Session::get($this->_sessionName);

                if($this->find($user)) {
                    $this->isLoggedIn = true;
                } else {
                    //Logout
                }
            }
        } else {
            $this->find($user);
        }

        
    }

    /*------------------------------------------------*/
    /* ACTUALIZA LOS DATOS DEL PERFIL DE LOS USUARIOS CONECTADOS */
    /*------------------------------------------------*/
    public function update($fields = array(), $id = null){

        if (!$id && $this->isLoggedIn()) {
            $id = $this->data()->id;
        }

        //ERROR DB
        if (!$this->_db->update('users', $id, $fields)) {
            throw new Exception('Tuvimos un problema para actualizar tus datos!'); 
        }
    }

    
    /*--------------------------*/
    /* CREANDO UN NUEVO USUARIO */
    /*--------------------------*/
    public function create($fields = array()){
        if (!$this->_db->insert('users', $fields)) {
            throw new Exception('Tuvimos un problema al crear tu cuenta!');
        }
    }

    /*--------------------*/
    /* BUSCAR UN USUARIO  */
    /*--------------------*/
    public function find($user = null){
        if ($user) {
            $field = (is_numeric($user)) ? 'id' : 'username';
            
            $data = $this->_db->get('users', array($field, '=', $user));

            if ($data->count()) {
                //CONTIENE TODA LA DATA DEL USUARIO
                $this->_data = $data->first();
                return true;
            }
        }

        return false;
    }

    /*--------------------------------*/
    /* VALIDANDO EL LOGIN DEL USUARIO */
    /*--------------------------------*/
    public function login($username = null, $password = null, $remember = false){
        
        if (!$username && !$password && $this->exists()) {
            //LOG USER IN
            Session::put($this->_sessionName, $this->data()->id);
        } else {            
            $user = $this->find($username);
            
            if ($user) {
                //COMPROBANDO QUE LAS PASSWORDS COINCIDAN
                if ($this->data()->password === Hash::make($password, $this->data()->salt)) {
                    Session::put($this->_sessionName, $this->data()->id);

                    if ($remember) {
                        $hash = Hash::unique();
                        //REVISANDO SI YA ESTA ESE HASH EN LA DB
                        $hashCheck = $this->_db->get('users_session', array('user_id', '=', $this->data()->id));

                        if (!$hashCheck->count()) {
                            //INSERTANDO LOS DATOS EN LA DB 'users_session'
                            $this->_db->insert('users_session', array(
                                'user_id' => $this->data()->id,
                                'hash' => $hash
                            ));
                        } else {
                            $hash = $hashCheck->first()->hash;
                        }
                        
                        //CREANDO LA COOKIE PARA RECORDAR LA SESION
                        Cookie::put($this->_cookieName, $hash, Config::get('remember/cookie_expiry'));

                    }

                    return true;
                }
            }
        }

        return false;
    }

    /*--------------------------------------*/
    /* VALIDANDO EL PERMISO DE LOS USUARIOS */
    /*--------------------------------------*/
    public function hasPermission($key){
        //TRAYENDO EL TIPO DE PERMISO QUE TIENE EL USUARIO
        $group = $this->_db->get('groups', array('id', '=', $this->data()->type));
        
        
        if ($group->count()) {
            //FILA DE PERMISOS, TABLA 'groups'
            $permissions = json_decode($group->first()->permissions, true);
            
            if ($permissions[$key] == true) {
                return true;
            }
        }

        return false;
    }

    /*--------------------------------*/
    /* COMPRUEBA SI EL USUARIO EXISTE */
    /*--------------------------------*/
    public function exists(){
        return (!empty($this->_data)) ? true : false;
    }

    /*--------------------------------*/
    /* CERRANDO LA SESION DEL USUARIO */
    /*--------------------------------*/
    public function logout(){

        $this->_db->delete('users_session', array('user_id', '=', $this->data()->id));

        Session::delete($this->_sessionName);
        Cookie::delete($this->_cookieName);
    }

    /*-----------------------------*/
    /* RETORNA LA DATA DEL USUARIO */
    /*-----------------------------*/
    public function data(){
        return $this->_data;
    }

    public function isLoggedIn(){
        return $this->isLoggedIn;
    }


}