<?php date_default_timezone_set("America/Mexico_City"); ?>
<?php session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Inicio de Sesion Estudiantes</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../assets/css/bootstrap-select.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.css">
    <link rel="stylesheet" href="../../assets/css/estilos.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>


<div class="container mt-5">

		<div id="info"  class="d-none" style="text-align: center;"> 
		
			<div class="logoContainer">
				<div class="logo">
					<img src="../../assets/images/CONAHCYT.png" alt="">
				</div>

				<div class="logo2">
					<img src="../../assets/images/logo_inaoe.jpg" alt="">
				</div>

			</div>
		<span style="color: black; font-weight: bold; font-size: 16px; align:left; ">Informacion areas Liberadas</span><br>
		<br><br>
  			<div style="text-align: center; border-bottom: 3px solid #cecece; margin-bottom: 30px; margin-top: 30px">
				<nav class="navbar navbar-light ">
  				<div class="nav nav-tabs" id="nav-tab" role="tablist">
    				<a class="nav-item nav-link active" id="nav-users-tab" data-toggle="tab" href="#nav-users" role="tab" aria-controls="nav-toSign" aria-selected="true">
						Registros en sistema <span id="pf" class="badge badge-info">0</span>
  						<span class="sr-only">unread messages</span>
					</a>									
  				</div> 
				</nav>
		    </div>

			<div class="tab-content" id="nav-tabContent">
  				<div class="tab-pane fade show active" id="nav-areas" role="tabpanel" aria-labelledby="nav-areas-tab">
				  <div class="tab-pane fade show active" id="nav-areas" role="tabpanel" aria-labelledby="nav-areas-tab">
					<table class="table table-striped">
						<thead style="background: #611232; color: white;">
							<tr>
								<!-- <th scope="col" style="text-align:center"># REGISTRO</th>
								<th scope="col" style="text-align:center">IDENTIFICADOR</th> -->
								<th scope="col" style="text-align:center">NOMBRE DEL ÁREA</th>
								<th scope="col" style="text-align:center">DETALLES</th>
								<th scope="col" style="text-align:center"></th>
							</tr>
						</thead>
						<tbody class="bg-white" id="table-areas"></tbody>
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
   
	<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/js/all.min.js" integrity="sha512-6PM0qYu5KExuNcKt5bURAoT6KCThUmHRewN3zUFNaoI6Di7XJPTMoT6K0nsagZKk2OB4L7E3q1uQKHNHd4stIQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <!-- Script para Crud del Area -->
    <script src="../../controllers/notificacion_avanze/crud_avanze/script_get_areas.js"></script>

</body>

</html>
<?php
?>