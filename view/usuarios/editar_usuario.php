	<?php date_default_timezone_set("America/Mexico_City"); ?>
	<?php session_start();

	// Validar sesión activa
if (!isset($_SESSION['username'])) {
    // Si no hay sesión iniciada, redirigir al index (login)
    header("Location: ../../index.php");
    exit();
}
	?>
	<!DOCTYPE html> 
	<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title>Registro de usuarios</title>
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
		<link rel="stylesheet" href="../../assets/css/bootstrap-select.min.css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.css">
		<link rel="stylesheet" href="../../assets/css/estilos.css">
		<link rel="stylesheet" href="../../assets/css/sidebar.css">
		<link rel="stylesheet" href="../../assets/css/navInaoe.css">
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
                                <span class="align:left" style="color: white; font-weight: bold; font-size: 20px;">Editar usuarios</span>
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
                                    <?php echo mb_strimwidth($_SESSION['name'], 0, 20, '...'); ?>
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
                <li><a>Actualizar usuario</a></li>
            </div>
            </div>
        </div>
    </nav>


		<div class="container mt-5">
			<div id="new" style="text-align: center;"><br><br>
				<div style="text-align: center; border-bottom: 3px solid #cecece; margin-bottom: 30px;">
					<h3>Registro de un nuevo usuario</h3>				
				</div>	
				<br>
				<div class="form-group">
					<div class="row">
							<div class="col-sm-4">
								<label for="name"><span class="text-danger">* </span>Nombre</label>
								<input type="text" class="form-control"  id="name" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
							</div>
							<div class="col-sm-4">
								<label for="surname"><span class="text-danger">* </span>Primer Apellido</label>
								<input type="text" class="form-control" id="surname" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
							</div>
							<div class="col-sm-4">
								<label for="second-surname"><span class="text-danger">* </span>Segundo Apellido</label>
								<input type="text" class="form-control" id="second_surname" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
							</div>					
						</div>
					</div>
					<div class="form-group">
						<div class="row">
							<div class="col-sm-8">
								<label for="email"><span class="text-danger">* </span>Correo electrónico personal</label>
								<input type="text" class="form-control" id="email">
							</div>		
							<div class="col-sm-4">
								<label for="type-users"><span class="text-danger">* </span>Tipo de usuario</label>
								<select name="type-users" id="type-users" class="form-control" >
									<option value="null" selected disabled>Seleccione un tipo</option>
								</select>
							</div>															
						</div>
					</div>	
					<div class="form-group">
						<div class="row">							
						
							<div class="col-sm-4">
								<label for="areas"><span class="text-danger">* </span>Área</label>
								<select name="areas" id="areas" class="form-control">
									<option value="null" selected disabled>Seleccione una área</option>
								</select>
							</div>															
						</div>
					</div>	
					<div class="col-sm-12">
						<label for="text"><span class="text-danger">* </span>El usuario y contraseña lo prodra modificar la persona correspondiente una vez que inicie sesión. </label>
					</div>
					<br><br>	
					<div class="form-group" align="center">
						<button type="button" class="btn btn-primary w-20" id="changePassword" onClick="changePassword();" >Cambiar Contraseña</button>
						<button class="btn btnCancel btn-lg active" type="button" onClick="history.go(-1);" >Cancelar</button>
						<button class="btn btnConfirm btn-lg active" type="button" id="save-exam" onclick="saveUserEdit();">Guardar</button>
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
		<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

		
		<script src="../../controller/signin/script_login.js"></script>
		<script src="../../controller/usuarios/script_usuarios.js"></script>


	
	</body>
	</html>