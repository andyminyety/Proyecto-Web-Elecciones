<?php 

interface IDataBase {

    function getActive();
    function getInactive();
    function getById($id);
    function Add($entity);
    function Habilitar($id);
    function Deshabilitar($id);
    function Edit($entity);
}

?>