<?php date_default_timezone_set("America/Mexico_City"); ?>
<?php session_start();


?>
<!DOCTYPE html> 
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Administración</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
	<link rel="stylesheet" href="../../assets/css/bootstrap-select.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.css">
	<link rel="stylesheet" href="../../assets/css/estilos.css">
	<link rel="stylesheet" href="../../assets/css/sidebar.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
	<!-- <div class="loader">
	    <img src="../../assets/loading.gif" alt="Cargando...">
	</div> -->


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
						<span class="align:left" style="color: white; font-weight: bold; font-size: 20px;">Administración</span>
					</div>
				</div>
				<?php if ($_SESSION['type'] == 0 ): ?>	
							<li><a class="dropdown-item" href="../administracion/administracion.php">Administración</a></li>
							<?php endif; ?>
                            <?php if ($_SESSION['type'] == 1 || $_SESSION['type'] == 2): ?>
							<li><a class="dropdown-item" href="../areas/areas.php">Áreas</a></li>
							<?php endif; ?>
                            <?php if ($_SESSION['type'] == 1 || $_SESSION['type'] == 2): ?>
							<li><a class="dropdown-item" href="../alumnos/alumnos.php">Alumnos</a></li>
							<?php endif; ?>
							<?php if ($_SESSION['type'] == 1 || $_SESSION['type'] == 2): ?>
							<li><a class="dropdown-item" href="../tipo_usuarios/tipo_usuarios.php">Tipo de usuarios</a> </li>	
							<?php endif; ?>
                            <?php if ($_SESSION['type'] == 1 || $_SESSION['type'] == 2): ?>
							<li><a class="dropdown-item" href="../usuarios/usuarios.php">Usuarios</a> </li>							
							<?php endif; ?>
							<?php if ($_SESSION['type'] == 3): ?>
							<li><a class="dropdown-item" href="../liberacion_area/liberacion_area.php">Liberación del área</a></li>
							<?php endif; ?>
				<li><a class="dropdown-item " id="navbarDropdown1" href="../usuarios/cuenta.php" role="menu" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="ctrl-control  h5 text-white text-align-right" id="username" style="font-size: 13px;"><i class="fas fa-user" aria-hidden="true"></i>
							<?php
							echo $_SESSION['name'];
							?>
							<i class="fa-solid fa-caret-down"></i></a></span>
					<ul>
						
						<li><a id='btnLogout'><span class="ctrl-control  h6 text-white">Cerrar Sesión</span></a></li>
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
</nav>


	<div class="container mt-5">
	<div id="info"  class="d-none" style="text-align: center;" >  
	<span style="color: black; font-weight: bold; font-size: 16px; align:left; ">EXPEDIENTE DE ÁREAS</span><br>
	<br><br>
  			<div style="text-align: center; border-bottom: 3px solid #cecece; margin-bottom: 30px; margin-top: 30px">
				<nav class="navbar navbar-light ">
  				<!--<div class="nav nav-tabs" id="nav-tab" role="tablist">
    				<a class="nav-item nav-link active" id="nav-toSign-tab" data-toggle="tab" href="#nav-toSign" role="tab" aria-controls="nav-toSign" aria-selected="true">
						Creados  <span id="pf" class="badge badge-info">0</span>
  						<span class="sr-only">unread messages</span>
					</a>
					<a class="nav-item nav-link" id="nav-toSign2-tab" data-toggle="tab" href="#nav-toSign2" role="tab" aria-controls="nav-toSign2" aria-selected="false">
						Por firmar  <span id="pf2" class="badge badge-secondary">0</span>
  						<span class="sr-only">unread messages</span>
					</a>
    				<a class="nav-item nav-link" id="nav-Readytoship-tab" data-toggle="tab" href="#nav-Readytoship" role="tab" aria-controls="nav-Readytoship" aria-selected="false">
						Listos para Enviar  <span id="le" class="badge badge-warning">0</span>
  						<span class="sr-only">unread messages</span>
					</a>
					<a class="nav-item nav-link" id="nav-Review-tab" data-toggle="tab" href="#nav-Review" role="tab" aria-controls="nav-Review" aria-selected="false">
						En Revisión DGP  <span id="er" class="badge badge-warning">0</span>
  						<span class="sr-only">unread messages</span>
					</a>
					<a class="nav-item nav-link" id="nav-Rejected-tab" data-toggle="tab" href="#nav-Rejected" role="tab" aria-controls="nav-Rejected" aria-selected="false">
						Rechazados  <span id="re" class="badge badge-danger">0</span>
  						<span class="sr-only">unread messages</span>
					</a>
					<a class="nav-item nav-link" id="nav-Cast-tab" data-toggle="tab" href="#nav-Cast" role="tab" aria-controls="nav-Cast" aria-selected="false">
						Emitidos <span id="em" class="badge badge-success">0</span>
  						<span class="sr-only">unread messages</span>
					</a>					
  				</div> 
				  <button type='button' class='btn btn-outline-success'  id='btn-new-exam' onClick='newTitleData()'  >NUEVO USUARIO</button>-->
				</nav>
		    </div>





			<!--<div class="tab-content" id="nav-tabContent">
  				<div class="tab-pane fade show active" id="nav-toSign" role="tabpanel" aria-labelledby="nav-toSign-tab">
				  <div class="tab-pane fade show active" id="nav-titles" role="tabpanel" aria-labelledby="nav-titles-tab">
					<table class="table table-striped">
						<thead style="background: #691C32; color: white;">
							<tr>
								<th scope="col" style="text-align:center"># REGISTRO</th>
								<th scope="col" style="text-align:center">NOMBRE DEL ALUMNO</th>
								<th scope="col" style="text-align:center">PROGRAMA</th>
								<th scope="col" style="text-align:center">FECHA DE CAPTURA</th>
								<th scope="col" style="text-align:center"></th>
								<th scope="col" style="text-align:center"></th>
								<th scope="col" style="text-align:center"></th> 
							</tr>
						</thead>
						<tbody class="bg-white" id="table-titles"></tbody>
					</table>
	              </div>  
				  	<div id="alert1"  class="alert alert-danger text-center mt-3 animate__animated animate__fadeIn">
                  		<p>
							<i class="fa-solid fa-ban fa-2x"></i>
                  		</p>
                  		<h4 class="alert-heading">SIN REGISTROS</h4>
              	  	</div>      
				</div>
				<div class="tab-pane fade" id="nav-toSign2" role="tabpanel" aria-labelledby="nav-toSign2-tab">
				  <div class="tab-pane fade show active" id="nav-titles2" role="tabpanel" aria-labelledby="nav-titles2-tab">
					<table class="table table-striped">
						<thead style="background: #691C32; color: white;">
						<tr>
								<th scope="col" style="text-align:center"># REGISTRO</th>
								<th scope="col" style="text-align:center">NOMBRE DEL ALUMNO</th>
								<th scope="col" style="text-align:center">PROGRAMA</th>
								<th scope="col" style="text-align:center">FECHA DE CAPTURA</th> 
							</tr>
						</thead>
						<tbody class="bg-white" id="table-titles2"></tbody>
					</table>
	              </div>  
				  	<div id="alert6"  class="alert alert-danger text-center mt-3 animate__animated animate__fadeIn">
                  		<p>
							<i class="fa-solid fa-ban fa-2x"></i>
                  		</p>
                  		<h4 class="alert-heading">SIN REGISTROS</h4>
              	  	</div>      
				</div>
  				<div class="tab-pane fade" id="nav-Readytoship" role="tabpanel" aria-labelledby="nav-Readytoship-tab">
				  <div class="tab-pane fade show active" id="nav-titlesReadytoship" role="tabpanel" aria-labelledby="nav-titlesReadytoship-tab">
					<table class="table table-striped">
						<thead style="background: #691C32; color: white;">
							<tr>
							    <th scope="col" style="text-align:center"># REGISTRO</th>
								<th scope="col" style="text-align:center">NOMBRE DEL ALUMNO</th>
								<th scope="col" style="text-align:center">PROGRAMA</th>
								<th scope="col" style="text-align:center">FECHA DE CAPTURA</th>
								<th scope="col" style="text-align:center">FECHA DE FIRMA</th>
								<th scope="col" style="text-align:center">OPCIONES</th>
								<th scope="col" style="text-align:center"></th>
							</tr>
						</thead> 
						<tbody class="bg-white" id="table-titlesReadyToShip"></tbody>
					</table>
	              </div>  
				  	<div id="alert2"  class="alert alert-danger text-center mt-3 animate__animated animate__fadeIn">
                  		<p>
							<i class="fa-solid fa-ban fa-2x"></i>
                  		</p>
                  		<h4 class="alert-heading">SIN REGISTROS</h4> 
              	  	</div>       
				</div>
  				<div class="tab-pane fade" id="nav-Review" role="tabpanel" aria-labelledby="nav-Review-tab">
				  <div class="tab-pane fade show active" id="nav-titlesReview" role="tabpanel" aria-labelledby="nav-titlesReview-tab">
					<table class="table table-striped">
						<thead style="background: #691C32; color: white;">
							<tr>
								<th scope="col" style="text-align:center"># REGISTRO</th>
								<th scope="col" style="text-align:center">NOMBRE DEL ALUMNO</th>
								<th scope="col" style="text-align:center">PROGRAMA</th>
								<th scope="col" style="text-align:center">FECHA DE ENVÍO</th>
								<th scope="col" style="text-align:center">ÚLTIMA CONSULTA</th>
								<th scope="col" style="text-align:center">OPCIONES</th>
								<th scope="col" style="text-align:center"></th>
								
							</tr>
						</thead>
						<tbody class="bg-white" id="table-titlesReview"></tbody>
					</table>
	              </div>
				  	<div id="alert3"  class="alert alert-danger text-center mt-3 animate__animated animate__fadeIn">
                  		<p>
							<i class="fa-solid fa-ban fa-2x"></i>
                  		</p>
                  		<h4 class="alert-heading">SIN REGISTROS</h4>
              	  	</div>  
				</div>
				<div class="tab-pane fade" id="nav-Rejected" role="tabpanel" aria-labelledby="nav-Rejected-tab">
				<div class="tab-pane fade show active" id="nav-titlesRejected" role="tabpanel" aria-labelledby="nav-titlesRejected-tab">
					<table class="table table-striped">
						<thead style="background: #691C32; color: white;">
							<tr>
								<th scope="col" style="text-align:center"># REGISTRO</th>
								<th scope="col" style="text-align:center">NOMBRE DEL ALUMNO</th>
								<th scope="col" style="text-align:center">PROGRAMA</th>
								<th scope="col" style="text-align:center">FECHA DE CAPTURA</th>
								<th scope="col" style="text-align:center">FECHA DE RECHAZO</th>
								<th scope="col" style="text-align:center">OPCIONES</th>
								<th scope="col" style="text-align:center"></th>
								<th scope="col" style="text-align:center"></th>
								<th scope="col" style="text-align:center"></th> 
								
							</tr>
						</thead>
						<tbody class="bg-white" id="table-titlesRejected"></tbody>
					</table>
	              </div>
				  	<div id="alert4"  class="alert alert-danger text-center mt-3 animate__animated animate__fadeIn">
                  		<p>
							<i class="fa-solid fa-ban fa-2x"></i>
                  		</p>
                  		<h4 class="alert-heading">SIN REGISTROS</h4>
              	  	</div>  
				</div>
				<div class="tab-pane fade" id="nav-Cast" role="tabpanel" aria-labelledby="nav-Cast-tab">
				<div class="tab-pane fade show active" id="nav-titlesCast" role="tabpanel" aria-labelledby="nav-titlesCast-tab">
					<table class="table table-striped">
						<thead style="background: #691C32; color: white;">
							<tr>
								<th scope="col" style="text-align:center"># REGISTRO</th>
								<th scope="col" style="text-align:center">NOMBRE DEL ALUMNO</th>
								<th scope="col" style="text-align:center"></th>
								<th scope="col" style="text-align:center">PROGRAMA</th>
								<th scope="col" style="text-align:center">FECHA DE CAPTURA</th>
								<th scope="col" style="text-align:center">FECHA DE EMISIÓN</th>
								<th scope="col" style="text-align:center">OPCIONES</th>
								<th scope="col" style="text-align:center"></th>
								 <th scope="col" style="text-align:center"></th>  
							</tr> 
						</thead>
						<tbody class="bg-white" id="table-titlesCast"></tbody>
					</table>
	              </div>
				  	<div id="alert5"  class="alert alert-danger text-center mt-3 animate__animated animate__fadeIn">
                  		<p>
							<i class="fa-solid fa-ban fa-2x"></i>
                  		</p>
                  		<h4 class="alert-heading">SIN REGISTROS</h4>
              	  	</div>  
				</div>

			</div> Tab content de las tablas-->
  		
			



</div>
</div>

	<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
	<script src="../../assets/js/bootstrap-select.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/5.3.2/bootbox.min.js"></script>
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
   <script src="../../assets/js/sidebar.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/js/all.min.js" integrity="sha512-6PM0qYu5KExuNcKt5bURAoT6KCThUmHRewN3zUFNaoI6Di7XJPTMoT6K0nsagZKk2OB4L7E3q1uQKHNHd4stIQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
	<script src="../../controllers/signin/script_login.js"></script>
	<script src="../../controllers/administracion/script_administracion.js"></script>
</body>
</html>
<?php
 ?>


<!-- Modal -->
<div class="modal fade" id="modalUser" tabindex="-1" role="dialog" aria-labelledby="modalUserLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalUserLabel">Nuevo Usuario</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
		  <form id="myForm">
			<div class="form-group">
				<label for="type"><span class="text-danger">* </span>Tipo de usuario</label>
				<select name="type" id="type" class="form-control" onchange="cargaUser()">
					<option value="null" selected disabled>Seleccione una opción</option>
					<option value="1">Firmante</option>
					<option value="3">Capturista</option>
					<option value="5">Administrador</option>
				</select>
				<label for="type" style="display:none" id="typeu"><span class="text-danger">Debe seleccionar el tipo de usuario </span></label>
			</div>

			<div class="content" id="signer" style="display:none">
				<div class="row">
					<div class="col-12">
						<div class="form-group">
							<label for="name"><span class="text-danger">* </span>Nombre (s)</label>
							<input type="text" class="form-control" id="name">
							<label for="type" style="display:none" id="names"><span class="text-danger">Debe escribir el nombre de usuario </span></label>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-6">
						<div class="form-group">
							<label for="surname"><span class="text-danger">* </span>Apellido paterno</label>
							<input type="text" class="form-control" id="surname">
							<label for="type" style="display:none" id="surnames"><span class="text-danger">Debe escribir el apellido</span></label>
						</div>
					</div>
					<div class="col-6">
						<div class="form-group">
							<label for="second_surname"><span class="text-danger">* </span>Apellido materno</label>
							<input type="text" class="form-control" id="second_surname">
							<label for="type" style="display:none" id="second_surnames"><span class="text-danger">Debe escribir el apellido </span></label>
						</div>
    				</div>
				</div>
				<div class="row">
					<div class="col-6">
						<div class="form-group">
							<label for="curp"><span class="text-danger">* </span>Curp</label>
							<input type="text" class="form-control" id="curp">
							<label for="type" style="display:none" id="curps"><span class="text-danger">Debe escribir la curp </span></label>
							<label for="type" style="display:none" id="curpsV"><span class="text-danger">La CURP NO es válida </span></label>
						</div>
					</div>
					<div class="col-6">
						<div class="form-group">
							<label for="position"><span class="text-danger">* </span>Cargo</label>
							<select name="position" id="position" class="form-control">
								<option value="null" selected disabled>Seleccione una opción</option>
							</select>
							<label for="type" style="display:none" id="positions"><span class="text-danger">Debe seleccionar el cargo </span></label>
						</div>
    				</div>
				</div>
				<div class="row">
					<div class="col-12">
						<div class="form-group">
							<label for="certificate"><span class="text-danger">* </span>Certificado</label>
							<textarea class="form-control" id="certificate" rows="2"></textarea>
							<label for="type" style="display:none" id="certificates"><span class="text-danger">Debe escribir el certificado </span></label>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-12">
						<div class="form-group">
							<label for="id_certificate"><span class="text-danger">* </span>ID Certificado</label>
							<input type="text" class="form-control" id="id_certificate">
							<label for="type" style="display:none" id="id_certificates"><span class="text-danger">Debe escribir el ID certificado </span></label>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-12">
					<div class="form-group">
						<label for="name_user"><span class="text-danger">* </span>Nombre de usuario</label>
						<input type="text" class="form-control" id="name_user">
						<label for="type" style="display:none" id="nameu"><span class="text-danger">Debe escribir el nombre de usuario </span></label>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-12">
					<div class="form-group">
						<label for="psw"><span class="text-danger">* </span>Contraseña</label>
						<input type="password" class="form-control" id="psw">
						<label for="type" style="display:none" id="psws"><span class="text-danger">Debe escribir la contraseña </span></label>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-12">
					<div class="form-group">
						<label for="pswr"><span class="text-danger">* </span>Repita la contraseña</label>
						<input type="password" class="form-control" id="pswr">
						<label for="type" style="display:none" id="pswrs"><span class="text-danger">Debe repetir la contraseña </span></label>
						<label for="type" style="display:none" id="pswrsV"><span class="text-danger">La contraseña no coincide </span></label>
					</div>
				</div>
			</div>
		 </form>
      	</div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="resetForm()">Cancelar</button>
        <button type="button" class="btn btn-primary" onclick="createUser()">Guardar</button>
      </div>
    </div>
  </div>
</div>




<!--MODAL DE CONSULTA-->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
	  	<div class="container">
  			<div class="row">
    			<div class="col">
					<h5><span class="badge badge-warning" id="lote">Número de Lote :</span></h5>
    			</div>
    			<div class="col">
      				<h5><span class="badge badge-pill badge-light" id="loteR"></span></h5>
    			</div>
  			</div>

			<div class="row">
    			<div class="col">
					<h5><span class="badge badge-warning" id="status">Estado :</span></h5>
    			</div>
    			<div class="col">
      				<h5><span class="badge badge-pill badge-light" id="statusR"></span></h5>
    			</div>
  			</div>

			<div class="row">
    			<div class="col">
					<h5><span class="badge badge-warning" id="msg">Mensaje :</span></h5>
    			</div>
    			<div class="col">
      				<h5><span class="badge badge-pill badge-light" id="msgR"></span></h5>
    			</div>
  			</div>
	  	</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Aceptar</button>
      </div>
    </div>
  </div>
</div>







<div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
	  	<h5><span class="badge ">Motivos: </span></h5><br>
        <!--<h5><span class="badge badge-warning" id="details"></span></h5>-->
		<textarea readonly class="form-control" id="details"></textarea>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Aceptar</button>
      </div>
    </div>
  </div>
</div>






<!-- MODAL-DETAILS-->

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
	  
	  <h5>Datos personales</h5>
	  		<div class="row">
				<div class="col-sm-12 col-md-6 col-xl-4">
            		<label class="form-label text-bold">Nombre del Alumno: </label><br>
            		<input type="text" class="form-control form-control-sm" id="name1" readonly> 
      			</div>
				<div class="col-sm-12 col-md-6 col-xl-4">
            		<label class="form-label text-bold">CURP: </label><br>
            		<input type="text" class="form-control form-control-sm" id="curp1" readonly> 
      			</div> 
				<div class="col-sm-12 col-md-6 col-xl-4">
            		<label class="form-label text-bold">Correo: </label><br>
            		<input type="text" class="form-control form-control-sm" id="email" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" readonly> 
      			</div>      
            </div><!--row 1-->
			<div class="row">
				<div class="col-sm-12 col-md-6 col-xl-4">
            		<label class="form-label text-bold">Folio del Título: </label><br>
            		<input type="text" class="form-control form-control-sm" id="controlinvoice" readonly> 
      			</div>  
            </div><!--row 2-->
			<h5>Carrera de Egreso</h5>
			<div class="row">
				<div class="col-sm-12 col-md-6 col-xl-4">
            		<label class="form-label text-bold">Nombre de la Institución: </label><br>
            		<input type="text" class="form-control form-control-sm" id="name_i" readonly> 
      			</div>
				<div class="col-sm-12 col-md-6 col-xl-4">
            		<label class="form-label text-bold">Carrera o Programa: </label><br>
            		<input type="text" class="form-control form-control-sm" id="course_name" readonly> 
      			</div> 
				  <div class="col-sm-12 col-md-6 col-xl-4">
            		<label class="form-label text-bold">Autorización de reconocimiento: </label><br>
            		<input type="text" class="form-control form-control-sm" id="course_reconnaissanceauthorization" readonly> 
      			</div>  
				     
            </div><!--row 2-->
            <br>
			<div class="row">
				<div class="col-sm-12 col-md-6 col-xl-4">
            		<label class="form-label text-bold">Fecha Inicio de la Carrea: </label><br>
            		<input type="text" class="form-control form-control-sm" id="course_startdate"  readonly> 
      			</div> 
				<div class="col-sm-12 col-md-6 col-xl-4">
            		<label class="form-label text-bold">Fecha Término de la Carrera: </label><br>
            		<input type="text" class="form-control form-control-sm" id="course_finishdate" readonly> 
      			</div>
				 
            </div><!--row 2-->
            <br>
			<h5>Datos Expedición</h5>
			<div class="row">
				<div class="col-sm-12 col-md-6 col-xl-4">
            		<label class="form-label text-bold">Fecha de Expedición: </label><br>
            		<input type="text" class="form-control form-control-sm" id="expedition_date" readonly> 
      			</div>

				<div class="col-sm-12 col-md-6 col-xl-4">
            		<label class="form-label text-bold">Modalidad: </label><br>
            		<input type="text" class="form-control form-control-sm" id="expedition_degreemodality" readonly> 
      			</div> 

				<!-- ############################################################ CAMBIO 12/09/22 ###########################################-->
				<div class="col-sm-12 col-md-6 col-xl-4"  id="exam" style="display: none">
            		<label class="form-label text-bold">Fecha de Examen Profesional: </label><br>
            		<input type="text" class="form-control form-control-sm" id="expedition_dateprofessionalexam" readonly> 
      			</div> 

				  <div class="col-sm-12 col-md-6 col-xl-4"  id="exencion" style="display: none">
            		<label class="form-label text-bold">Fecha de Exención: </label><br>
            		<input type="text" class="form-control form-control-sm" id="exencion_date" readonly> 
      			</div> 
				<!-- ############################################################ CAMBIO 12/09/22 ###########################################-->

            </div><!--row 3-->
            <br>
			<div class="row">
				<div class="col-sm-12 col-md-6 col-xl-4">
            		<label class="form-label text-bold">Estado de Expedición: </label><br>
            		<input type="text" class="form-control form-control-sm" id="expedition_state" readonly> 
      			</div>  
				  <div class="col-sm-12 col-md-6 col-xl-4">
            		<label class="form-label text-bold">Servicio Social: </label><br>
            		<input type="text" class="form-control form-control-sm" id="expedition_socialservice" readonly> 
      			</div> 
				  <div class="col-sm-12 col-md-6 col-xl-4">
            		<label class="form-label text-bold">Fundamento Legal de Servicio Social: </label><br>
            		<input type="text" class="form-control form-control-sm" id="expedition_legalbasissocialservice" readonly> 
      			</div>    
            </div><!--row 4-->
            <br>
			<h5>Datos Antecedentes</h5>
			<div class="row">
				<div class="col-sm-12 col-md-6 col-xl-4">
            		<label class="form-label text-bold">Institución de Procedencia: </label><br>
            		<input type="text" class="form-control form-control-sm" id="antecedent_institutionorigin" readonly> 
      			</div>
				<div class="col-sm-12 col-md-6 col-xl-4">
            		<label class="form-label text-bold">Tipo de Estudio Antecedente: </label><br>
            		<input type="text" class="form-control form-control-sm" id="antecedent_typestudy" readonly> 
      			</div> 
				<div class="col-sm-12 col-md-6 col-xl-4">
            		<label class="form-label text-bold">Cédula Profesional: </label><br>
            		<input type="text" class="form-control form-control-sm" id="antecedent_document" readonly> 
      			</div>      
            </div><!--row 3-->
            <br>
			<div class="row">
				<div class="col-sm-12 col-md-6 col-xl-4">
            		<label class="form-label text-bold">Fecha de Terminación: </label><br>
            		<input type="text" class="form-control form-control-sm" id="antecedent_finishdate" readonly> 
      			</div>  
				  <div class="col-sm-12 col-md-6 col-xl-4">
            		<label class="form-label text-bold">Entidad Federativa: </label><br>
            		<input type="text" class="form-control form-control-sm" id="antecedent_state" readonly> 
      			  </div> 
				     
            </div>
		
	</div> 
      <div class="modal-footer">
	  <!-- <button type="button" class="btn btn-success" >Descargar</button> -->
        <button type="button" class="btn btn-primary" data-dismiss="modal">Aceptar</button>
      </div>
    </div>
  </div>
</div>







<!-- MODAL-DETAILS 2-->

<div class="modal fade" id="exampleModalCenter2" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle2" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalCenterTitle2"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
	  

	  <div class="container" id="xml" >
 		<div class="row">
    		<div class="col align-self-start">
    		</div>
    		<div class="col align-self-center">
				<a href='#' style="float: center;" onClick="generateXML()"><span  id="titledata"></span></a>
    		</div>
    		<div class="col align-self-end">
    		</div>
  		</div>
	   </div>
	   <div class="container" id="xml2" style="display:none">
 		<div class="row">
		 <input type="text" class="form-control form-control-sm" id="id_titledata" readonly>
  		</div>
	   </div>
		
      
	  <h5>Datos personales</h5>
	  		<div class="row">
				<div class="col-sm-12 col-md-6 col-xl-4">
            		<label class="form-label text-bold">Nombre del Alumno: </label><br>
            		<input type="text" class="form-control form-control-sm" id="name2" readonly> 
      			</div>
				<div class="col-sm-12 col-md-6 col-xl-4">
            		<label class="form-label text-bold">CURP: </label><br>
            		<input type="text" class="form-control form-control-sm" id="curp2" readonly> 
      			</div> 
				<div class="col-sm-12 col-md-6 col-xl-4">
            		<label class="form-label text-bold">Correo: </label><br>
            		<input type="text" class="form-control form-control-sm" id="email2" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" readonly> 
      			</div>      
            </div><!--row 1-->
			<div class="row">
				<div class="col-sm-12 col-md-6 col-xl-4">
            		<label class="form-label text-bold">Folio del Título: </label><br>
            		<input type="text" class="form-control form-control-sm" id="controlinvoice2" readonly> 
      			</div>  
            </div><!--row 2-->
			<h5>Carrera de Egreso</h5>
			<div class="row">
				<div class="col-sm-12 col-md-6 col-xl-4">
            		<label class="form-label text-bold">Nombre de la Institución: </label><br>
            		<input type="text" class="form-control form-control-sm" id="name_i2" readonly> 
      			</div>
				<div class="col-sm-12 col-md-6 col-xl-4">
            		<label class="form-label text-bold">Carrera o Programa: </label><br>
            		<input type="text" class="form-control form-control-sm" id="course_name2" readonly> 
      			</div> 
				  <div class="col-sm-12 col-md-6 col-xl-4">
            		<label class="form-label text-bold">Autorización de reconocimiento: </label><br>
            		<input type="text" class="form-control form-control-sm" id="course_reconnaissanceauthorization2" readonly> 
      			</div>  
				     
            </div><!--row 2-->
            <br>
			<div class="row">
				<div class="col-sm-12 col-md-6 col-xl-4">
            		<label class="form-label text-bold">Fecha Inicio de la Carrea: </label><br>
            		<input type="text" class="form-control form-control-sm" id="course_startdate2"  readonly> 
      			</div> 
				<div class="col-sm-12 col-md-6 col-xl-4">
            		<label class="form-label text-bold">Fecha Término de la Carrera: </label><br>
            		<input type="text" class="form-control form-control-sm" id="course_finishdate2" readonly> 
      			</div>
				 
            </div><!--row 2-->
            <br>
			<h5>Datos Expedición</h5>
			<div class="row">
				<div class="col-sm-12 col-md-6 col-xl-4">
            		<label class="form-label text-bold">Fecha de Expedición: </label><br>
            		<input type="text" class="form-control form-control-sm" id="expedition_date2" readonly> 
      			</div>

				<div class="col-sm-12 col-md-6 col-xl-4">
            		<label class="form-label text-bold">Modalidad: </label><br>
            		<input type="text" class="form-control form-control-sm" id="expedition_degreemodality2" readonly> 
      			</div> 
      			
				<!-- ############################################################ CAMBIO 12/09/22 ###########################################-->

				  <div class="col-sm-12 col-md-6 col-xl-4"  id="exam2" style="display: none">
            		<label class="form-label text-bold">Fecha de Examen Profesional: </label><br>
            		<input type="text" class="form-control form-control-sm" id="expedition_dateprofessionalexam2" readonly> 
      			</div> 
				  <div class="col-sm-12 col-md-6 col-xl-4"  id="exencion2" style="display: none">
            		<label class="form-label text-bold">Fecha de Exención: </label><br>
            		<input type="text" class="form-control form-control-sm" id="exencion_date2" readonly> 
      			</div> 
				<!-- ###################################################################################################################-->


				     

            </div><!--row 3-->
            <br>
			<div class="row">
				<div class="col-sm-12 col-md-6 col-xl-4">
            		<label class="form-label text-bold">Estado de Expedición: </label><br>
            		<input type="text" class="form-control form-control-sm" id="expedition_state2" readonly> 
      			</div>  
				  <div class="col-sm-12 col-md-6 col-xl-4">
            		<label class="form-label text-bold">Servicio Social: </label><br>
            		<input type="text" class="form-control form-control-sm" id="expedition_socialservice2" readonly> 
      			</div> 
				  <div class="col-sm-12 col-md-6 col-xl-4">
            		<label class="form-label text-bold">Fundamento Legal de Servicio Social: </label><br>
            		<input type="text" class="form-control form-control-sm" id="expedition_legalbasissocialservice2" readonly> 
      			</div>    
            </div><!--row 4-->
            <br>
			<h5>Datos Antecedentes</h5>
			<div class="row">
				<div class="col-sm-12 col-md-6 col-xl-4">
            		<label class="form-label text-bold">Institución de Procedencia: </label><br>
            		<input type="text" class="form-control form-control-sm" id="antecedent_institutionorigin2" readonly> 
      			</div>
				<div class="col-sm-12 col-md-6 col-xl-4">
            		<label class="form-label text-bold">Tipo de Estudio Antecedente: </label><br>
            		<input type="text" class="form-control form-control-sm" id="antecedent_typestudy2" readonly> 
      			</div> 
				<div class="col-sm-12 col-md-6 col-xl-4">
            		<label class="form-label text-bold">Cédula Profesional: </label><br>
            		<input type="text" class="form-control form-control-sm" id="antecedent_document2" readonly> 
      			</div>      
            </div><!--row 3-->
            <br>
			<div class="row">
				<div class="col-sm-12 col-md-6 col-xl-4">
            		<label class="form-label text-bold">Fecha de Terminación: </label><br>
            		<input type="text" class="form-control form-control-sm" id="antecedent_finishdate2" readonly> 
      			</div>  
				  <div class="col-sm-12 col-md-6 col-xl-4">
            		<label class="form-label text-bold">Entidad Federativa: </label><br>
            		<input type="text" class="form-control form-control-sm" id="antecedent_state2" readonly> 
      			  </div> 
				     
            </div>
		
	</div> 
      <div class="modal-footer">
	  <!-- <button type="button" class="btn btn-success" >Descargar</button> -->
        <button type="button" class="btn btn-primary" data-dismiss="modal">Aceptar</button>
      </div>
    </div>
  </div>
</div>

<!-- HISTÓRICO -->
<div class="modal fade" id="history" tabindex="-1" role="dialog" aria-labelledby="historyTitle" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title mr-2" id="historyTitle"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

	  <div class="container">
  		<div class="row">
    		<div class="col-sm">
				<h5>Folio<span class="badge badge-warning mr-5" id="folio"></span></h5>
    		</div>
    		<!-- <div class="col-sm-12 col-md-6 col-xl-4">
        		<label class="form-label text-bold">Servicio Social: </label><br>
        		<input type="text" class="form-control form-control-sm" id="expedition_socialservice2" readonly> 
  			</div>  -->
    		<div class="col-sm">
			<h5>Folio DGP <span class="badge badge-warning" id="loteS"></span></h5>
    		</div>
  		</div>
	  </div>
	  <div class="alert alert-info" role="alert" id="cons">
  		<h6 id="mensaje"></h6>
	  </div>
	  
	  
      <div class="modal-body">
	  
	  <table class="table table-striped">
					<thead style="background: #691C32; color: white;">
						<tr>
							<th scope="col" style="text-align:center">STATUS</th>
							<th scope="col" style="text-align:center">DESCRIPCIÓN</th>
							<th scope="col" style="text-align:center">FECHA</th>
						</tr>
					</thead>
					<tbody class="bg-white" id="tableHistory"></tbody>
				</table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success" data-dismiss="modal">Aceptar</button>
      </div>
    </div>
  </div>
</div>



<!-- RECHAZAR EMITIR MODAL -->

<div class="modal fade" id="rejectIssue" tabindex="-1" role="dialog" aria-labelledby="rejectIssueTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title mr-2" id="historyTitle">Emitir / Rechazar Título</h5> 
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
	  	

	  <div class="form-check">
  		<input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios1" value="1" checked>
  		<label class="form-check-label" for="exampleRadios1">
    		Emitir
  		</label>
	  </div>
      <div class="form-check">
  		<input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios2" value="2">
  		<label class="form-check-label" for="exampleRadios2">
    		Rechazar
  		</label>
	  </div>
  		
      </div>
      <div class="modal-footer">
	  	<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary">Aceptar</button>
      </div>
    </div>
  </div>
</div>
