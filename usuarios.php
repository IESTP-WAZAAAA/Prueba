<?php
session_start();
if (!isset($_SESSION['usuario']) || $_SESSION['usuario'] === 'invitado') {
    header("Location: login.html");
    exit;
}

$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'jovenes';

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener todos los usuarios
$sql = "SELECT id, documento, nombres, apellidoPaterno, usuario, contraseña FROM personas";
$result = $conn->query($sql);
?>

<!doctype html>
<html lang="en-gb" class="no-js">
  <head>
    <meta charset="utf-8">
	<title>Portada de Administración</title>
    <meta name="author" content="">
    <meta name="keywords" content="">
    <meta name="description" content="">		
	
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
     <!--styles -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/font-awesome.css" rel="stylesheet">
    <link href="js/owl-carousel/owl.carousel.css" rel="stylesheet">
    <link href="js/owl-carousel/owl.theme.css" rel="stylesheet">
    <link href="js/owl-carousel/owl.transitions.css" rel="stylesheet">
    <link href="css/magnific-popup.css" rel="stylesheet">
    <link rel="shortcut icon" href="./images/icono.jpg" type="image/x-icon">
    <link rel="stylesheet" type="text/css" href="css/animate.css" />
    <link rel="stylesheet" href="css/etlinefont.css">
    <link href="css/style.css" type="text/css"  rel="stylesheet"/>
    <link rel="stylesheet" href="css/estilosnousuarios.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

	<body  data-spy="scroll" data-target="#main-menu">

  <!--Start Page loader -->
  <div id="pageloader">   
        <div class="loader">
          <img src="images/progress.gif" alt='loader' />
        </div>
   </div>
   <!--End Page loader -->
   
   <!--Start Navigation-->
		<header id="header">
				<div class="container">
					<div class="row">
						<div class="col-sm-12">
							<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#main-menu">
								<span class="sr-only">Toggle navigation</span>
								<span class="fa fa-bars"></span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
							</button>
                            <!--Start Logo -->
							<div class="logo-nav">
								<a href="#">
									<img src="images/logo.png" alt="Company logo" />
								</a>
							</div>
                            <!--End Logo -->
							<div class="clear-toggle"></div>
							<div id="main-menu" class="collapse scroll navbar-right">
								<ul class="nav">
                                <li> <a href="./administración.php">Consultas</a> </li>
                                <li> <a href="./usuarios.php">Usuarios</a> </li>
                                    <li><a href="./PHP/logout.php" class="logout-btn">Cerrar Sesión</a></li>

								</ul>
							</div>
						</div>
					</div>
				</div>
			</header>
    <!--End Navigation-->

		<!--start page-header -->
		<section id="page-header" class="parallax">
             <div class="overlay"></div>
			<div class="container">
				<h1>Panel de Administración</h1>
			</div>
		</section>
		<!--End page-header -->
        <div class="container">
        <h2>Lista de Usuarios</h2>
        
        <?php if ($result->num_rows > 0): ?>
            <div class="table-responsive">
                <table class="styled-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Documento</th>
                            <th>Nombres</th>
                            <th>Apellidos</th>
                            <th>Usuario</th>
                            <th>Contraseña</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo $row['documento']; ?></td>
                            <td><?php echo $row['nombres']; ?></td>
                            <td><?php echo $row['apellidoPaterno']; ?></td>
                            <td><?php echo $row['usuario']; ?></td>
                            <td><?php echo $row['contraseña']; ?></td>
                            <td>
                            <button class="delete-btn" onclick="eliminarUsuario(<?php echo $row['id']; ?>)"><i class="fas fa-trash-alt"></i> Eliminar</button>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="no-usuarios">
                <p>📌 <strong>Sin usuarios.</strong> No hay registros en este momento.</p>
            </div>
        <?php endif; ?>
    </div>
   <a href="#" class="scrollup"> <i class="fa fa-chevron-up"> </i> </a>

    <!--Plugins-->
	<script type="text/javascript" src="js/jquery-1.11.1.min.js"></script>
    <script type="text/javascript" src="js/bootstrap.min.js"></script> 
    <script type="text/javascript" src="js/owl-carousel/owl.carousel.js"></script>
    <script type="text/javascript" src="js/jquery.flexslider-min.js"></script>
    <script type="text/javascript" src="js/jquery.magnific-popup.min.js"></script>
    <script type="text/javascript" src="js/easing.js"></script>
    <script type="text/javascript" src="js/jquery.easypiechart.js"></script>
    <script type="text/javascript" src="js/jquery.appear.js"></script>
    <script type="text/javascript" src="js/jquery.parallax-1.1.3.js"></script>
    <script type="text/javascript" src="js/jquery.mixitup.min.js"></script>
    <script type="text/javascript" src="js/custom.js"></script>
    <script src="js/eliminarusuario.js"></script>
 </body>
</html>
<?php $conn->close(); ?>

