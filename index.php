<!DOCTYPE html>
<html lang="en">
<?php 
include_once 'core/Config.php';
include_once 'core/Router.php';
include_once 'core/Controller.php'; 
session_start();
if(isset($_SESSION['user_name']))
{
	
}
else
{
	?>
<head>
	<meta charset="UTF-8">
	<title>Sistema de Libración de áreas</title>
	<link rel="stylesheet" href="assets/css/bootstrap.min.css">
	<link rel="stylesheet" href="assets/css/estilos.css">
	<link rel="stylesheet" href="./assets/css/navLogin.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
	<script src= "https://code.jquery.com/jquery-3.6.0.min.js"  integrity= "sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="  crossorigin="anonymous">
    </script>
</head>
<body >

<nav class="navbar">
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
                    <li><a href="https://www.inaoep.mx/">INAOE</a></li>
                </div>
               
            <div class="seccionesEstatus">
                <li><a href="view/validacion_proceso/validateProcess.php">Estatus de Solicitud</a></li>
				<li><a href="view/login_prestamo/login_prestamo.php">Realizar Préstamo</a></li>
				<li><a href="view/consulta_folio/consulta_folio_login.php">Consulta de Folio</a></li>
            </div>
            </div>
        </div>
    </nav>
<div class="containerLogin">
			<div style="width: 50%; margin: auto; margin-top: 10vh;">
				<form id="login-form" style="background-color: with; border: 2px solid black;">
					<h4 class="text-center" style="background:  with; color: black; padding: 10px;">Inicio de sesión</h4>

					<div align="center" style="padding-top: 10px;">
						<!--/<img src="assets/images/siste_4.png" style="max-width:100%;width: 300px; height:100px; align:center">-->
						<h4 style="color:black; padding-top: 10px">Sistema de Libración de áreas</h4>

					</div>

					<div style="padding: 10px; padding-top: 20px;">
						<div class="form-group">
							<div style="padding: 50px; padding-top: 20px;">
								<div class="input-group mb-3">
									<span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-user"></i></span>
									<input type="text" class="form-control" maxlength="50" id="username" placeholder="Nombre de usuario">
								</div>
								<div class="input-group mb-3">
									<span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-lock"></i></span>
									<input type="password" class="form-control" id="password" placeholder="Contraseña">
								</div>
								<!--<div class="form-group">
								<label for="password">Contraseña</label>
								<input type="password" class="form-control" id="password">
							</div>-->
							<div style="display:flex;  justify-content:center;">
							<button type="submit" style="display:flex;  justify-content:center; " class="btn btn-success w-20">ENTRAR</button>
							</div>
								
								<!--<button type="submit" class="btn btn-success w-100" disabled>PÁGINA EN MANTENIMIENTO</button>-->
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
<br><br><br>

<?php include './view/components/footer/footer.php'; ?>
<?php  
}
?>
	
	<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/5.3.2/bootbox.min.js"></script>
	<script src="controller/signin/script_login.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/js/all.min.js" integrity="sha512-6PM0qYu5KExuNcKt5bURAoT6KCThUmHRewN3zUFNaoI6Di7XJPTMoT6K0nsagZKk2OB4L7E3q1uQKHNHd4stIQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

	<!-- <script src="../../controller/signatureDocument/script_signature.js"></script> -->
	<script>
		$(document).ready(function() {
            function disableBack() {
                window.history.forward()
            }
            window.onload = disableBack();
            window.onpageshow = function(e) {
                if (e.persisted)
                    disableBack();
            }

                 
        });
	</script>
</body>
</html>