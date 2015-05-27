<?php 
//Incluyo las variables con los datos de la conexión.
require (dirname(__DIR__)."/inc/config.php");


//Class Modelo es la que va a realiza la conexión y se va a extender a todas las clases que hagan una conexión con la bd
class Modelo
{
    //$db guarda la conexión y se va a utilizar cada vez que se haga una conexión con la bd. En cualquier clase.
    //protected para que se pueda usar en todas las clases.
    protected $db;

    public function __construct(){

        if(!$this->db)
        {
            $this->db = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

            if ( $this->db->connect_errno ){
                echo "Fallo al conectar a MySQL: ". $this->db->connect_error;
                return;    
            }
            $this->db->set_charset(DB_CHARSET);
        }

    }
}

?>