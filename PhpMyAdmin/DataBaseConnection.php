<?php

class DataBaseConnection {

    public $db;
    private $json;

    function __construct($directory)
    {
        $this->json = new JsonFile ($directory,'connection');
        $read = $this->json->getJSON();
        $this->db = new mysqli($read->server,$read->user,$read->password,$read->database);

        if($this->db->connect_error) {

            exit('Error de Conexión en la Base de Datos');
        }
    }
}
?>