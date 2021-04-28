<?php

class Layout {
    public $Menu;
    public $Tipo;
    public $Accion;
    public $Cerrar;
    public $Direccion;

    function __construct($Accion, $Tipo) {
        $this->Accion    = $Accion;
        $this->Direccion = ($this->Accion) ? "../../" : "";
        $this->Tipo      = $Tipo;
    }

    public function header() {
        $this->Cerrar = ($this->Tipo) ? $this->Direccion . "Electores/Login/Logout.php" : $this->Direccion . "Elecciones/Login/Logout.php";
        if($this->Tipo == false) {
            $this->Menu = <<<EOF

            <li class="nav-item">
                <a class="nav-link" href="{$this->Direccion}Elecciones/PuestoElectivo/PuestoElectivo.php">Puesto Electivo</a></a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{$this->Direccion}Elecciones/Candidatos/ListarCandidatos.php">Candidatos</a></a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{$this->Direccion}Elecciones/Partidos/Admin.php">Partidos</a></a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{$this->Direccion}Elecciones/Ciudadanos/Admin.php">Ciudadanos</a></a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{$this->Direccion}Elecciones/Elecciones/Admin.php">Elecciones</a></a>
            </li>

        EOF;
        } else {
            $this->Menu = "";
        }

        $header = <<<EOF
        
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Elecciones</title>
        
            <link rel="stylesheet" href="{$this->Direccion}assets/Css/style.css">
            <link rel="stylesheet" href="{$this->Direccion}assets/Css/Login.css">
            <link rel="stylesheet" href="{$this->Direccion}assets/Css/Inicio.css">
            <link rel="stylesheet" href="{$this->Direccion}assets/Css/bootstrap/bootstrap.min.css">
            <link rel="stylesheet" href="{$this->Direccion}assets/Css/toastr/toastr.min.css">  
            <script src="https://kit.fontawesome.com/597ca9d7c7.js" crossorigin="anonymous"></script>
            
        </head>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="{$this->Direccion}Elecciones/Login/Admin.php"><i class="fas fa-user-cog text-danger h4"></i> Administrador</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav mr-auto">
            <li class="nav-item">
              <a class="nav-link" href="{$this->Direccion}Electores/Login/Login.php">Inicio</a>
            </li>
            {$this->Menu}
          </ul>
          <a class="btn btn-outline-danger my-2 my-sm-0" href="{$this->Cerrar}">Cerrar sesión</a>
        </div>
      </nav>

      <main class="container">

    EOF;

        echo $header;
    }

    public function Footer() {

        $footer = <<<EOF
        
        </main>    
        <script src="{$this->Direccion}assets/Js/jquery/jquery-3.5.1.min.js"></script>
        <script src="{$this->Direccion}assets/Js/toastr/toastr.min.js"></script>

        <!-- JavaScript Bundle with Popper -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
    </body>
    </html>

    EOF;

        echo $footer;

    }
}

?>