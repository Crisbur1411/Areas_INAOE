<?php date_default_timezone_set("America/Mexico_City"); ?>
<?php session_start();
?>
<!DOCTYPE html> 
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Usuarios</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
	<link rel="stylesheet" href="../../assets/css/bootstrap-select.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.css">
	<link rel="stylesheet" href="../../assets/css/estilos.css">
	<link rel="stylesheet" href="../../assets/css/sidebar.css">
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
                                <span class="align:left" style="color: white; font-weight: bold; font-size: 20px;">Usuarios</span>
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
		<span style="color: black; font-weight: bold; font-size: 16px; align:left; ">RESPONSABLES DE ÁREAS</span><br>
		<br><br>
  			<div style="text-align: center; border-bottom: 3px solid #cecece; margin-bottom: 30px; margin-top: 30px">
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
					<table class="table table-striped">
						<thead style="background: #611232; color: white;">
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
	              </div>  
                  
		</div>
	</div>

	<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
	<script src="../../assets/js/bootstrap-select.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/5.3.2/bootbox.min.js"></script>
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	<script src="../../assets/js/sidebar.js"></script>
   
	<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/js/all.min.js" integrity="sha512-6PM0qYu5KExuNcKt5bURAoT6KCThUmHRewN3zUFNaoI6Di7XJPTMoT6K0nsagZKk2OB4L7E3q1uQKHNHd4stIQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
	<script src="../../controllers/signin/script_login.js"></script>
	<script src="../../controllers/usuarios/script_usuarios.js"></script>
	<script src="../../controllers/usuarios/crud_usuarios/script_deleteUsuario.js"></script>
	<script src="../../controllers/usuarios/crud_usuarios/script_redirigir.js"></script>

</body>
</html>
<?php
 ?>