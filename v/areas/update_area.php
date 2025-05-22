<?php date_default_timezone_set("America/Mexico_City"); ?>
<?php session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Áreas</title>
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
                        <span class="align:left" style="color: white; font-weight: bold; font-size: 20px;">Update áreas</span>
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
</nav>


<div class="container mt-5">
        <div style="text-align: center;"><br><br>
            <div style="text-align: center; border-bottom: 3px solid #cecece; margin-bottom: 30px;">
                <h3>Editar área</h3>
            </div>
            <br>
            <div class="form-group">
                <div class="row">
                    <div class="col-sm-4">
                        <label for="nombreArea">Nombre del Área:</label>
                        <input type="text" class="form-control" id="nombreArea" name="nombreArea" placeholder="Ingrese el nombre del área" required>
                    </div>

                    <div class="col-sm-4">
                        <label for="detallesArea">Detalles del Área:</label>
                        <textarea class="form-control" id="detallesArea" name="detallesArea" placeholder="Ingrese los detalles del área" rows="1" required></textarea>
                    </div>

                    <div class="col-sm-4">
                        <label for="identificador">Identificador del Área:</label>
                        <input type="text" class="form-control" id="identificador" name="identificador" placeholder="ID del área" disabled>
                    </div>

                </div>
            </div>

            <div class="form-group">
                <div class="row">
                    <div class="col-sm-4">
                        <label for="imagen">Sello del Área:</label>
                        <br>
                        <a id="enlaceImagen" href="#" target="_blank">
                            <img id="imagenArea" src="#" class="img-fluid mb-2" alt="Imagen del área" style="max-width: 300px; width: 200px; height: 200px; ">
                        </a>
                    </div>

                    <div class="col-sm-4">
                        <label for="imagen">Remplzar imagen:</label>
                        <input type="file" class="form-control-file" id="imagen" name="imagen" accept="image/*">
                    </div>

                    <div class="col-sm-4">
                        <img id="previewImage" src="#" alt="Vista previa de la imagen" style="max-width: 100%; max-height: 200px;display: none;">
                    </div>

                </div>

            </div>
        </div>
        <div class="form-group" align="center">

            <button type="button" class="btn btn-secondary w-20" id="cancel" onClick="history.go(-1);">Cancelar</button>
            <button type="button" class="btn btn-success w-20" onclick="editArea()">Guardar</button>
        </div>

        </form>
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Script para Crud del Area -->
    <script src="../../controllers/areas/script_areas.js"></script>




</body>

</html>
<?php
?>