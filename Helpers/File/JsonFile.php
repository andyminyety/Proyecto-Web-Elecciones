<?php 

class JsonFile{
    private $directory;
    private $name;
    
    function __construct($directory = 'PhpMyAdmin')
    {
        $this->directory = $directory;
        $this->name = 'Conexion';
    }

    public function getJSON() {
        
        $path = $this->directory . '/' . $this->name . '.json';
        $file = fopen($path, 'r');
        $fileDecode = fread($file, filesize($path));
        fclose($file);

        return json_decode($fileDecode);
    }
}

?>