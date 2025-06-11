<?php date_default_timezone_set("America/Mexico_City"); ?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Validación de Proceso</title>
    <link rel="shortcut icon" href="src/favicon.png" type="image/x-icon">
    <link href="https://framework-gb.cdn.gob.mx/assets/styles/main.css" rel="stylesheet">
</head>
<nav class="navbar navbar-inverse sub-navbar navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#subenlaces">
                <span class="sr-only">Interruptor de Navegación</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">INAOE</a>
        </div>
        <div class="collapse navbar-collapse" id="subenlaces">
            <ul class="nav navbar-nav navbar-right">
                <li><a href="../../index.php">Inicio</a></li>
            </ul>
        </div>
    </div>
</nav> 
<body style="background-color: white;">
    <div class="container">
        <div class="col">
            <div id="app">
                <!-- Aquí insertas el componente NavBar <nav-researcher></nav-researcher> -->
            </div>
            <div style="padding-top: 8rem;">
                <h3>Validación de Estatus de Proceso</h3>
                <hr class="red">
            </div>
            <div style="display: flex; justify-content: center; padding: 4rem;">
                <div class="card" style="width: 80%;">
                    <div class="card-body">
                        <form class="form-horizontal" role="form" id="validationForm" novalidate>
                            <div class="form-group row">
                                <label for="email" class="col-sm-10 col-form-label">Correo electrónico</label>
                                <div class="col-sm-10">
                                    <input class="form-control" id="email" name="email" placeholder="Ingrese su correo electrónico" type="text" required>
                                </div>
                            </div>
                            <div class="form-group row mt-4">
                                <div class="col-sm-6 text-left">
                                    <button type="button" class="btn btn-default" onclick="window.location.href='../../index.php';">Salir</button>
                                </div>
                                <div class="col-sm-4 text-right">
                                    <button type="submit" class="btn btn-primary">Validar</button>
                                </div>
                            </div>
                        </form>

                        <div class="row">
                            <div class="col">
                                <div class="alert alert-danger mt-2" role="alert" id="alert_error" style="display:none">Error: Correo no encontrado.</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://framework-gb.cdn.gob.mx/gobmx.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../../controller/validacion_proceso/script_validacion.js"></script>

</body>

</html>
