<?php date_default_timezone_set("America/Mexico_City"); ?>



<!DOCTYPE html> 
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Consulta de Folio</title>
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
                    <li><a>INAOE</a></li>
                </div>
               
            <div class="seccionesEstatus">
                <li><a href="../../index.php">Inicio</a></li>
            </div>
            </div>
        </div>
    </nav>
<div class="container mt-5">
    <div id="info" class="d-block" style="text-align: center;">
        <span style="color: black; font-weight: bold; font-size: 16px;">CONSULTA DE FOLIO DE LIBERACIÓN</span><br>
        <br><br>
        <div style="text-align: center; border-bottom: 3px solid #cecece; margin-bottom: 30px; margin-top: 30px">
            <nav class="navbar navbar-light ">
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    <span class="gov-style-label">
                    DETALLES DE LIBERACIÓN
                    </span>

                </div>
            </nav>
        </div>
        <div class="tab-content" id="nav-tabContent">

            <div class="tab-pane fade show active" id="nav-free" role="tabpanel" aria-labelledby="nav-free-tab">
                <table class="table table-striped table-bordered">
                    <thead style="background: #691C32; color: white;">
                        <tr>
                            <th scope="col" style="text-align:center"># REGISTRO</th>
                            <th scope="col" style="text-align:center">NOMBRE DEL ALUMNO</th>
                            <th scope="col" style="text-align:center">DETALLES</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white" id="table-students-free"></tbody>
                </table>
                <div id="alert2" class="alert alert-danger text-center mt-3 animate__animated animate__fadeIn">
                    <p>
                        <i class="fa-solid fa-ban fa-2x"></i>
                    </p>
                    <h4 class="alert-heading">SIN REGISTROS DE LIBERACIÓN</h4>
                </div>
            </div>

        </div>
    </div>
</div>


<div class="modal fade" id="modalStudentDetails" tabindex="-1" role="dialog" aria-labelledby="modalStudentDetailsTitle" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="dialog">
    <div class="modal-content">
      <div class="modal-header" style="background: #691C32; color: white;">
        <h5 class="modal-title w-100 text-center">Verificación de Registro de Liberación</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar" style="color: white;">
            <span aria-hidden="true">&times;</span>
        </button>
      </div>


      <div class="modal-body">
        <table class="table table-bordered">
          <tbody>
            <tr>
                <th class="text-center">Nombre Completo</th>
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
                <td id="student-fecha-conclusion"  class="text-center"></td>
            </tr>
            <tr>
                <th class="text-center">Programa Académico</th>
                <td id="student-programa-academico"  class="text-center"></td>
            </tr>
            <tr>
                <th class="text-center">Estado</th>
                <td id="student-status" class="text-center align-middle"></td>
            </tr>
            <tr>
                <th class="text-center">Folio</th>
                <td id="student-folio" class="text-center"></td>
            </tr>
            <tr>
                <th class="text-center">Imprimir Constancia</th>
                <td class="text-center"><button class="btn btnConfirm btn-lg active" type="button" id="save-exam" onclick="openConstanciaPDF()">Generar Constancia</button></td>
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
	<script src="../../controller/consulta_folio/script_consulta_folio.js"></script>
</body>
</html>
<?php
 ?>





