<?php date_default_timezone_set("America/Mexico_City"); ?>
<?php session_start();
// Evita caché
header("Cache-Control: no-cache, must-revalidate");
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
// Validar si hay sesión iniciada
if (!isset($_SESSION['username'])) {
    header("Location: ../../index.php"); // o la ruta a tu login
    exit();
}

?>
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
    	<link rel="stylesheet" href="../../assets/css/navInaoe.css">

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>





<nav class="navbar navbar-expand-lg navbar-light bg-nav">

        <div class="row mx-md-n5">
            <div class="col px-md-5">
                <div>

                </div>
            </div>
            <div id="user" hidden><?php echo $_SESSION['name']; ?></div>
        </div>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <div class=""></div>
            <div id="wrapper">
                <div class="overlay"></div>

                <!-- Sidebar -->
                <nav class="navbar navbar-inverse fixed-top" id="sidebar-wrapper" role="navigation">
                    <ul class="nav sidebar-nav">
                        <div class="sidebar-header">
                            <div class="sidebar-brand">
                                <span class="align:left" style="color: white; font-weight: bold; font-size: 20px;">Alumnos</span>
                            </div>
                        </div>
                        <?php if ($_SESSION['type'] == 0 ): ?>	
							<li><a class="dropdown-item" href="../administracion/administracion.php">Administración</a></li>
							<?php endif; ?>
                            <?php if ($_SESSION['type'] == 1 || $_SESSION['type'] == 2): ?>
							<li><a class="dropdown-item" href="../programas_academicos/programas_academicos.php">Programas académicos</a> </li>							
							<?php endif; ?>
                            <?php if ($_SESSION['type'] == 1 || $_SESSION['type'] == 2): ?>
							<li><a class="dropdown-item" href="../areas/areas.php">Áreas</a></li>
							<?php endif; ?>
                            <?php if ($_SESSION['type'] == 1 || $_SESSION['type'] == 2): ?>
							<li><a class="dropdown-item" href="#">Alumnos</a></li>
							<?php endif; ?>
							<?php if ($_SESSION['type'] == 1): ?>
							<li><a class="dropdown-item" href="../tipo_usuarios/tipo_usuarios.php">Tipo de usuarios</a> </li>	
							<?php endif; ?>
                            <?php if ($_SESSION['type'] == 1 || $_SESSION['type'] == 2): ?>
							<li><a class="dropdown-item" href="../usuarios/usuarios.php">Usuarios</a> </li>							
							<?php endif; ?>
							<?php if ($_SESSION['type'] == 3): ?>
							<li><a class="dropdown-item" href="../liberacion_area/liberacion_area.php">Liberación del área</a></li>
							<?php endif; ?>
                        <li><a class="dropdown-item" id="navbarDropdown1" href="../usuarios/cuenta.php">
                                <span class="ctrl-control h5 text-align-right" id="username" style="font-size: 13px;">
                                    <i class="fas fa-user"></i>
                                    <?php echo $_SESSION['name']; ?>
                                    <i class="fa-solid fa-caret-down"></i>
                                </span>
                                </a>

                            <ul>
                            <li>
                            <a id="btnLogout" href="#">
                                <span class="ctrl-control h6">Cerrar Sesión</span>
                            </a>
                            </li>                            
                        </ul>
                        </li>
                    </ul>

                </nav>
                <!-- /#sidebar-wrapper -->

                <!-- Page Content -->

                <div id="page-content-wrapper">
                    <button type="button" class="hamburger animated fadeInLeft is-closed" data-toggle="offcanvas">
                        <span class="hamb-top"></span>
                        <span class="hamb-middle"></span>
                        <span class="hamb-bottom"></span>
                    </button>
                    <div class="container">

                    </div>

                </div>
                
                
            </div>
            
        </div>
        

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
                    <li><p class="text_inaoe">INAOE</p></li>
                </div>
               
            <div class="seccionesEstatus">
                <li><a>Alumnos registrados</a></li>
            </div>
            </div>
        </div>
    </nav>
<div class="container mt-5">
    <div id="info" class="d-none" style="text-align: center;">
        <span style="color: black; font-weight: bold; font-size: 16px; align:left; ">ALUMNOS REGISTRADOS</span><br>
        <br><br>
        <div style="text-align: center; border-bottom: 3px solid #cecece; margin-bottom: 30px; margin-top: 30px">
            <nav class="navbar navbar-light ">
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    <a class="nav-item nav-link active" id="nav-users-tab" data-toggle="tab" href="#nav-users" role="tab" aria-controls="nav-toSign" aria-selected="true">
                        Registros en sistema <span id="pf1" class="badge badge-info">0</span>
                        <span class="sr-only">unread messages</span>
                    </a>
                    <a class="nav-item nav-link" id="nav-inProgress-tab" data-toggle="tab" href="#nav-inProgress" role="tab" aria-controls="nav-inProgress" aria-selected="false">
                        En curso <span id="pf2" class="badge badge-warning">0</span>
                        <span class="sr-only">unread messages</span>
                    </a>
                    <a class="nav-item nav-link" id="nav-free-tab" data-toggle="tab" href="#nav-free" role="tab" aria-controls="nav-free" aria-selected="false">
                        Liberados <span id="pf3" class="badge badge-success">0</span>
                        <span class="sr-only">unread messages</span>
                    </a>
                    <a class="nav-item nav-link" id="nav-cancel-tab" data-toggle="tab" href="#nav-cancel" role="tab" aria-controls="nav-rejected" aria-selected="false">
                        Cancelados <span id="pf4" class="badge badge-danger">0</span>
                        <span class="sr-only">unread messages</span>
                    </a>
                </div>
                <button type='button' class='btn btn-outline-success' id='btn-new-student' onClick='newStudent()'>NUEVO ALUMNO</button>
            </nav>
        </div>

        <div class="tab-content" id="nav-tabContent">

            <div class="tab-pane fade show active" id="nav-users" role="tabpanel" aria-labelledby="nav-users-tab">
            <table class="table table-striped table-bordered">
                    <thead style="background: #691C32; color: white;">
                        <tr>
                            <th scope="col" style="text-align:center"># REGISTRO</th>
							<th scope="col" style="text-align:center">MATRÍCULA</th>
                            <th scope="col" style="text-align:center">NOMBRE DEL ALUMNO</th>
                            <th scope="col" style="text-align:center">CURSO</th>
                            <th scope="col" style="text-align:center">FECHA DE REGISTRO</th>
                            <th scope="col" style="text-align:center">ACTUALIZAR ALUMNO</th>
                            <th scope="col" style="text-align:center">ELIMINAR ALUMNO</th>
                            <th scope="col" style="text-align:center">TURNAR A FIRMA</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white" id="table-students"></tbody>
                </table>
                <div id="alert1" class="alert alert-danger text-center mt-3 animate__animated animate__fadeIn">
                    <p>
                        <i class="fa-solid fa-ban fa-2x"></i>
                    </p>
                    <h4 class="alert-heading">SIN REGISTROS</h4>
                </div>
            </div>

            <div class="tab-pane fade" id="nav-inProgress" role="tabpanel" aria-labelledby="nav-inProgress-tab">
            <table class="table table-striped table-bordered">
                    <thead style="background: #691C32; color: white;">
                        <tr>
                            <th scope="col" style="text-align:center"># REGISTRO</th>
							<th scope="col" style="text-align:center">MATRÍCULA</th>
                            <th scope="col" style="text-align:center">NOMBRE DEL ALUMNO</th>
                            <th scope="col" style="text-align:center">TOTAL DE ÁREAS LIBERADAS</th>
                            <th scope="col" style="text-align:center">FINALIZAR TRÁMITE</th>
                            <th scope="col" style="text-align:center">CANCELAR TRÁMITE</th>
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

            <div class="tab-pane fade" id="nav-free" role="tabpanel" aria-labelledby="nav-free-tab">
                <table class="table table-striped table-bordered">
                    <thead style="background: #691C32; color: white;">
                        <tr>
                            <th scope="col" style="text-align:center"># REGISTRO</th>
							<th scope="col" style="text-align:center">MATRÍCULA</th>
                            <th scope="col" style="text-align:center">NOMBRE DEL ALUMNO</th>                            
                            <th scope="col" style="text-align:center">FECHA DE LIBERACIÓN</th>
                            <th scope="col" style="text-align:center">FOLIO DE LIBERACIÓN</th>
                            <th scope="col" style="text-align:center">IMPRIMIR CONSTANCIA</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white" id="table-students-free"></tbody>
                </table>
                <div id="alert3" class="alert alert-danger text-center mt-3 animate__animated animate__fadeIn">
                    <p>
                        <i class="fa-solid fa-ban fa-2x"></i>
                    </p>
                    <h4 class="alert-heading">SIN REGISTROS</h4>
                </div>
            </div>

            <div class="tab-pane fade" id="nav-cancel" role="tabpanel" aria-labelledby="nav-cancel-tab">
                <table class="table table-striped table-bordered">
                    <thead style="background: #691C32; color: white;">
                        <tr>
                            <th scope="col" style="text-align:center"># REGISTRO</th>
							<th scope="col" style="text-align:center">MATRÍCULA</th>
                            <th scope="col" style="text-align:center">NOMBRE DEL ALUMNO</th>                            
                            <th scope="col" style="text-align:center">FECHA DE CANCELACIÓN</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white" id="table-students-cancel"></tbody>
                </table>
                <div id="alert4" class="alert alert-danger text-center mt-3 animate__animated animate__fadeIn">
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
	<script src="../../controller/signin/script_login.js"></script>
	<script src="../../controller/alumnos/script_alumnos.js"></script>




</body>
</html>
<?php
 ?>
<div class="modal fade" id="errorModal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-danger text-white">
        <h5 class="modal-title" id="errorModalLabel">Error</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body" id="errorModalBody">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" >Cerrar</button>
      </div>
    </div>
  </div>
</div>

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
</div>

<!-- Modal de detalles de estudiantes -->
<div class="modal fade" id="modalStudentDetails" tabindex="-1" role="dialog" aria-labelledby="modalStudentDetailsTitle" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="dialog">
    <div class="modal-content">
      <div class="modal-header" style="background: #691C32; color: white;">
        <h5 class="modal-title">Detalles del Alumno</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar" style="color: white;">
            <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">
        <table class="table table-bordered">
          <tbody>
            <tr>
              <th class="text-center" >Nombre Completo</th>
              <td id="student-fullname" class="text-center"></td>
            </tr>
            <tr>
              <th class="text-center">Número de Control</th>
              <td id="student-control-number" class="text-center"></td>
            </tr>
            <tr>
              <th class="text-center">Correo</th>
              <td id="student-email" class="text-center"></td>
            </tr>
            <tr>
              <th class="text-center">Institución</th>
              <td id="student-institucion" class="text-center"></td>
            </tr>
            <tr>
              <th class="text-center">Fecha de Conclusión</th>
              <td id="student-fecha-conclusion" class="text-center"></td>
            </tr>
            <tr>
              <th class="text-center">Programa Académico</th>
              <td id="student-programa-academico" class="text-center"></td>
            </tr>
          </tbody>
        </table>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Aceptar</button>
      </div>
    </div>
  </div>
</div>

