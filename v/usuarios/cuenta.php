<?php date_default_timezone_set("America/Mexico_City"); ?>
<?php session_start();
?>
<!DOCTYPE html> 
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Mi cuenta</title>
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
                                <span class="align:left" style="color: white; font-weight: bold; font-size: 20px;">Cuenta</span>
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
							<li><a class="dropdown-item" href="../alumnos/alumnos.php">Alumnos</a></li>
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
                    <li><p class="text_inaoe">INAOEP</p></li>
                </div>
               
            <div class="seccionesEstatus">
                <li><a>Información de usuario</a></li>
            </div>
            </div>
        </div>
    </nav>

	<div class="container mt-5">
		<div id="info"  class="d-none" style="text-align: center;" >  
		<span style="color: black; font-weight: bold; font-size: 16px; align:left; ">MI CUENTA</span><br>
		<br><br>
  			<!--<div style="text-align: center; border-bottom: 3px solid #cecece; margin-bottom: 30px; margin-top: 30px">
				<nav class="navbar navbar-light ">
  				<div class="nav nav-tabs" id="nav-tab" role="tablist">
    				<a class="nav-item nav-link active" id="nav-users-tab" data-toggle="tab" href="#nav-users" role="tab" aria-controls="nav-toSign" aria-selected="true">
						Registros en sistema <span id="pf" class="badge badge-info">0</span>
  						<span class="sr-only">unread messages</span>
					</a>									
  				</div> 
				  <button type='button' class='btn btn-outline-success'  id='btn-new-user' onClick='newUser()'>NUEVO USUARIO</button>
				</nav>
		    </div>

			<div class="tab-content" id="nav-tabContent">
  				<div class="tab-pane fade show active" id="nav-users" role="tabpanel" aria-labelledby="nav-users-tab">
				  <div class="tab-pane fade show active" id="nav-users" role="tabpanel" aria-labelledby="nav-users-tab">
					<table class="table table-striped table-bordered">
						<thead style="background: #2967B2; color: white;">
							<tr>
								<th scope="col" style="text-align:center"># REGISTRO</th>
								<th scope="col" style="text-align:center">NOMBRE DEL USUARIO</th>
								<th scope="col" style="text-align:center">ÁREA</th>
								<th scope="col" style="text-align:center">TIPO DE USUARIO</th>
								<th scope="col" style="text-align:center">FECHA DE REGISTRO</th>
								<th scope="col" style="text-align:center"></th>
								<th scope="col" style="text-align:center"></th>
							</tr>
						</thead>
						<tbody class="bg-white" id="table-users"></tbody>
					</table>
	              </div>  -->

				<!--desarrollado por bryam el 29/03/2024 en esta sección se muestra los datos del usuario-->
			<div id="user_id" data-id="<?php echo $_SESSION['id_user']; ?>" style="display: none;"></div>
			<table class="table table-striped table-bordered">
				<thead style="background: #691C32; color: white;">
					<tr>
						<th scope="col" style="text-align:center">Nombre completo</th>
						<th scope="col" style="text-align:center">Area</th>
						<th scope="col" style="text-align:center">Tipo de usuario</th>
						<th scope="col" style="text-align:center">Fecha de registro</th>
						<th scope="col" style="text-align:center">Correo</th>
						<th scope="col" style="text-align:center">Contraseña</th>

					</tr>
				</thead>
				<tbody class="bg-white" id="table-areas">
					<tr>
						<td id="full_name"></td>
						<td id="area"></td>
						<td id="userNme"></td>
						<td id="fechaRegistro"></td>
						<td id="correo"></td>
						<td>
							<span >**********</span>
							<button type='button' class='btn btn-secondary btn-sm' id='btn-edit' title='Click para editar la contraseña' onclick='showModal()'><i class="fas fa-edit"></i></button>
						</td>

					</tr>
				</tbody>
			</table>

			<!-- desarrollado por bryam el 01/04/2024 el modal campos para poner la contraseña de la sesion actual, la nueva contraseña y repetir la contraseña  -->

			<div class="modal fade" id="modalEdit" tabindex="-1" role="dialog" aria-labelledby="modalEditarLabel" aria-hidden="true">
				<div class="modal-dialog modal-dialog-centered" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="modalEditarLabel">Editar credenciales</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body" style="display: flex; flex-direction: column; justify-content: center; align-items: center;">
						<span >Contraseña actual *</span>
							<input type="password" id="currentPassword">
							<span></span>
							<span >Nueva contraseña *</span>
							<input type="password" id="newPassword">
							<span></span>
							<span >Repetir contraseña *</span>
							<input type="password" id="confirmPassword">
						</div>
						<div class="modal-footer">
						<button type="button" class="btn btn-primary" onclick="saveChanges(<?php echo $_SESSION['id_user']; ?>)">Guardar</button>
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
						</div>
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
	<script src="../../controllers/usuarios/script_usuarios.js"></script>
</body>
</html>
<?php
 ?>