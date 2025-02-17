<!DOCTYPE html>
<html lang="en">
<?php 
include_once 'core/Config.php';
include_once 'core/Router.php';
include_once 'core/Controller.php';
?>
<head>
	<meta charset="UTF-8">
	<title>Oficina</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
	<link rel="stylesheet" href="assets/css/estilos.css">
</head>
<body style="background: #cecece;">
	<div class="container">
		<div style="width: 50%; margin: auto; margin-top: 10vh;">
			<form style="background: white;" id="login-form-admin">
				<h3 class="text-center" style="background: #b2292e; color: white; padding: 10px;">Acceso</h3>
				<div style="padding: 50px; padding-top: 30px;">
					<div class="form-group">
						<label for="ctrl-number">Nombre de usuario</label>
						<input type="text" class="form-control" id="username">
					</div>
					<div class="form-group">
						<label for="password">Contraseña</label>
						<input type="password" class="form-control" id="password">
					</div>
					<button type="submit" onclick="adminForm()" class="btn btn-success w-100">Entrar</button>
				</div>
			</form>
		</div>
	</div>

	<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/5.3.2/bootbox.min.js"></script>
	<script src="controllers/signin/script_login.js"></script>
</body>
</html>