<?php 

class Votaciones {

    public $id_elecciones;
    public $id_candidato;
    public $id_partido;
    public $id_puesto;
    public $cedula;
    public $resultado;

    public function InizializeData(

        $id_elecciones,
        $id_candidato,
        $id_partido,
        $id_puesto,
        $cedula,
        $resultado
        
    ) {

        $this->id_elecciones = $id_elecciones;
        $this->id_candidato = $id_candidato;
        $this->id_partido = $id_partido;
        $this->id_puesto = $id_puesto;
        $this->cedula = $cedula;
        $this->resultado = $resultado;

    }
}