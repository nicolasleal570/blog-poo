<?php 

class Blog{

    private $_db,
            $_data;
    
    public function __construct($blog = null) {
        //INSTANCIA DE LA BASE DE DATOS
        $this->_db = DB::getInstance();

        if (!$blog) {
            //SI NO EXISTE EL POST...
            /* echo 'No existe el post'; */
        }else {
            $this->find($blog);
        }

    }

    /*-----------------*/
    /* CREANDO UN POST */
    /*-----------------*/
    public function create($fields = array()){
        if (!$this->_db->insert('posts', $fields)) {
            throw new Exception ('<p>Tuvimos un problema al montar tu post!</p>');
        }
    }

    /*-----------------------------*/
    /* BUSCAR UN POST YA EXISTENTE */
    /*-----------------------------*/
    public function find($blog = null){
        if ($blog) {
            if (is_numeric($blog)) {

                $data = $this->_db->get('posts', array('post_id', '=', $blog));

                if ($data->count()) {
                    //CONTIENE TODA LA DATA DEL USUARIO
                    $this->_data = $data->first();
                    return true;
                }
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

    /*-----------------------------*/
    /* RETORNA LA DATA DEL POST */
    /*-----------------------------*/
    public function data(){
        return $this->_data;
    }




}
