<?php date_default_timezone_set("America/Mexico_City"); ?>



<!DOCTYPE html> 
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Alumnos</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
	<link rel="stylesheet" href="../../assets/css/bootstrap-select.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.css">
	<link rel="stylesheet" href="../../assets/css/estilos.css">
    <link rel="stylesheet" href="../../assets/css/sidebar.css">
        <link rel="stylesheet" href="../../assets/css/navNavegation.css">
        

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>


<nav class="navbarNavegation">
        <div class="container-fluid">
            <div class="contNav">
                <div class="contGob">
                    <a class="navbar-brand" href="https://www.gob.mx/"><img
                        src="https://framework-gb.cdn.gob.mx/landing/img/logoheader.svg" width="110" height="35"
                        alt="PÃƒÂ¡gina de inicio, Gobierno de MÃƒÂ©xico"></a>
                </div>
               
            <div class="secciones">
                <li><a href="https://www.gob.mx/tramites">Trámites</a></li>
                <li><a href="https://www.gob.mx/gobierno">Gobierno</a></li>
                <a href="https://www.gob.mx/busqueda"><span class="sr-only">Búsqueda</span><i class="fa fa-search" style="color: white;"></i></a>
            </div>
            </div>
        </div>
    </nav>
	<nav class="navbarINAOE">
        <div class="container-fluid">
            <div class="contNav">
                <div class="seccionesINAOE">
                    <li><a href="https://www.inaoep.mx/">INAOEP</a></li>
                </div>
               
            <div class="seccionesEstatus">
                <li><a href="../../index.php">Inicio</a></li>
            </div>
            </div>
        </div>
    </nav>
<div class="container mt-5">
    <div id="info" class="d-block" style="text-align: center;">
        <span style="color: black; font-weight: bold; font-size: 16px;">PROCESO DE LIBERACIÓN</span><br>
        <br><br>
        <div style="text-align: center; border-bottom: 3px solid #cecece; margin-bottom: 30px; margin-top: 30px">
            <nav class="navbar navbar-light ">
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    <span class="gov-style-label">
                    Proceso
                    </span>

                </div>
            </nav>
        </div>

        <div class="tab-content" id="nav-tabContent">

            <div class="tab-pane fade show active" id="nav-inProgress" role="tabpanel" aria-labelledby="nav-inProgress-tab">
                <table class="table table-striped table-bordered">
                    <thead style="background: #691C32; color: white;">
                        <tr>
                            <th scope="col" style="text-align:center"># REGISTRO</th>
                            <th scope="col" style="text-align:center">NOMBRE DEL ALUMNO</th>
                            <th scope="col" style="text-align:center">CORREO</th>
                            <th scope="col" style="text-align:center">MATRÍCULA</th>
                            <th scope="col" style="text-align:center">TOTAL DE ÁREAS LIBERADAS</th>
                            <th scope="col" style="text-align:center">DETALLES</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white" id="table-students-in-progress"></tbody>
                </table>
                <div id="alert2" class="alert alert-danger text-center mt-3 animate__animated animate__fadeIn">
                    <p>
                        <i class="fa-solid fa-ban fa-2x"></i>
                    </p>
                    <h4 class="alert-heading">SIN REGISTROS</h4>
                </div>
            </div>

        </div>
    </div>
</div>



<br><br>
	<?php include '../components/footer/footer.php'; ?>

	
	<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
	<script src="../../assets/js/bootstrap-select.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/5.3.2/bootbox.min.js"></script>
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../../assets/js/sidebar.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/js/all.min.js" integrity="sha512-6PM0qYu5KExuNcKt5bURAoT6KCThUmHRewN3zUFNaoI6Di7XJPTMoT6K0nsagZKk2OB4L7E3q1uQKHNHd4stIQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
	<script src="../../controllers/signin/script_login.js"></script>
	<script src="../../controllers/validacion_proceso/script_validacion.js"></script>
</body>
</html>
<?php
 ?>

<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalCenterTitle"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row"> 
            <div class="col-1">
                <b>ALUMNO:</b>
            </div>
            <div class="col-9">
                <h5 id="title-name-student"></h5>
            </div>
        </div>
        <br>
    <div class="row" aria-labelledby="nav-titlesCast-tab">
		<table class="table table-striped table-bordered">
			<thead style="background: #691C32; color: white;">
				<tr>
					<th scope="col" style="text-align:center">ÁREA</th>
					<th scope="col" style="text-align:center">FECHA DE LIBERACIÓN</th>
					<th scope="col" style="text-align:center">DESCRIPCIÓN</th>
				</tr>
			</thead>
			<tbody class="bg-gray" id="table-modal-info-areas">
				<!-- Aquí se llenarán las filas con JavaScript -->
			</tbody>
		</table>
	</div>

      <div class="modal-footer">
	  <!-- <button type="button" class="btn btn-success" >Descargar</button> -->
        <button type="button" class="btn btn-primary" data-dismiss="modal">Aceptar</button>
      </div>
    </div>
  </div>
</div>

