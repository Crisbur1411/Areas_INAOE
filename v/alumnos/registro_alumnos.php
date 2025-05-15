<?php date_default_timezone_set("America/Mexico_City"); ?>
<?php session_start();

if (isset($_SESSION['user_name']))
{
	echo '<script>location.href = "#";</script>';
}
?>
<!DOCTYPE html> 
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Registro de alumnos</title>
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
                                <span class="align:left" style="color: white; font-weight: bold; font-size: 20px;">Registro alumnos</span>
                            </div>
                        </div>
                        <?php if ($_SESSION['type'] == 0 ): ?>	
							<li><a class="dropdown-item" href="../administracion/administracion.php">Administración</a></li>
							<?php endif; ?>
                            <?php if ($_SESSION['type'] == 1 || $_SESSION['type'] == 2): ?>
							<li><a class="dropdown-item" href="../areas/areas.php">Áreas</a></li>
							<?php endif; ?>
                            <?php if ($_SESSION['type'] == 1 || $_SESSION['type'] == 2): ?>
							<li><a class="dropdown-item" href="alumnos.php">Alumnos</a></li>
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
		<div id="new" style="text-align: center;"><br><br>
			<div style="text-align: center; border-bottom: 3px solid #cecece; margin-bottom: 30px;">
				<h3>Registro de un nuevo alumno</h3>				
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
						<div class="col-sm-4">
							<label for="control-number"><span class="text-danger">* </span>Matrícula</label>
							<input type="text" class="form-control" id="control-number">
						</div>	
						<div class="col-sm-8">
							<label for="email"><span class="text-danger">* </span>Correo electrónico personal</label>
							<input type="text" class="form-control" id="email">
						</div>																				
					</div>
				</div>	
				<div class="form-group">
					<div class="row">						
						<div class="col-sm-4">
							<label for="program-type"><span class="text-danger">* </span>Tipo de programa</label>
							<select name="program" id="program" class="form-control" onchange="courses();">
								<option value='null' selected disabled>Seleccione una opción</option>
								<option value="1">MAESTRÍA</option>
								<option value="2">DOCTORADO</option>
								<option value="3">EXTERNO LICENCIATURA</option>
								<option value="4">EXTERNO BACHILLERATO</option>
							</select>
						</div>	
						<div class="col-sm-8">
							<label for="courses"><span class="text-danger">* </span>Área de Adscripción</label>
							<select name="courses" id="course" class="form-control">
								<option value="null" selected disabled>Seleccione su área</option>
							</select>
						</div>															
					</div>
				</div>	
				<br><br>	
				<div class="form-group" align="center">
					<button type="button" class="btn btn-secondary w-20" id="cancel" onClick="history.go(-1);" >Cancelar</button>
					<button type="button" class="btn btn-success w-20" id="save-exam" onclick="saveStudent();">Guardar</button>
				</div>				
			</div>	
		</div>		
	</div>

<br><br><br><br><br><br><br><br>
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
	<script src="../../controllers/alumnos/script_registro_alumnos.js"></script>
	<script>		
		courses();
	</script>
</body>
</html>