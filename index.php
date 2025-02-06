<?php
session_start();
if (isset($_SESSION['usuario']) && $_SESSION['usuario'] !== 'invitado') {
    $botonTexto = 'Cerrar Sesión';
    $botonEnlace = './PHP/logout.php';
} else {
    $botonTexto = 'Iniciar Sesión';
    $botonEnlace = './login.html';
}

$nombreUsuario = isset($_SESSION['nombres']) ? $_SESSION['nombres'] : "Usuario";

$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'jovenes';

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    echo json_encode(["status" => "error", "message" => "Conexión fallida: " . $conn->connect_error]);
    exit;
}

$esInvitado = !isset($_SESSION['usuario']) || $_SESSION['usuario'] === 'invitado';

$documento = $nombres = $apellidoPaterno = "";
$atributoDeshabilitado = "readonly";

if ($esInvitado) {
    $botonTexto = 'Iniciar Sesión';
    $botonEnlace = './login.html';
    $botonEnviarTexto = "Primero inicia sesión";
    $botonEnviarDeshabilitado = "readonly";
} else {
    $botonTexto = 'Cerrar Sesión';
    $botonEnlace = './PHP/logout.php';
    $botonEnviarTexto = "Enviar";
    $botonEnviarDeshabilitado = "";
}

$nombreUsuario = isset($_SESSION['nombres']) ? $_SESSION['nombres'] : "Usuario";

if (!$esInvitado) {
    $usuario = $_SESSION['usuario'];
    $stmt = $conn->prepare("SELECT documento, nombres, apellidoPaterno FROM personas WHERE usuario = ?");
    
    if ($stmt) {
        $stmt->bind_param("s", $usuario);
        $stmt->execute();
        $resultado = $stmt->get_result();

        if ($resultado->num_rows > 0) {
            $fila = $resultado->fetch_assoc();
            $documento = $fila['documento'];
            $nombres = $fila['nombres'];
            $apellidoPaterno = $fila['apellidoPaterno'];
            $atributoDeshabilitado = "readonly";
        }
        $stmt->close();
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en-gb" class="no-js">
<head>
    <meta charset="utf-8">
    <title>Jovenes Por Un Nuevo Mundo</title>
    <meta name="author" content="">
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/font-awesome.css" rel="stylesheet">
    <link href="js/owl-carousel/owl.carousel.css" rel="stylesheet">
    <link href="js/owl-carousel/owl.theme.css" rel="stylesheet">
    <link href="js/owl-carousel/owl.transitions.css" rel="stylesheet">
    <link href="css/magnific-popup.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/animate.css">
    <link rel="shortcut icon" href="./images/icono.jpg" type="image/x-icon">
    <link rel="stylesheet" href="css/etlinefont.css">
    <link href="css/style.css" type="text/css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<style>
    .btn-sesion {
    display: inline-block;
    padding: 12px 20px;
    font-size: 16px;
    font-weight: bold;
    color: white;
    background-color: #006DA4;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    transition: background 0.3s, transform 0.2s;
    }

    .btn-sesion:hover {
    background-color: #003553;
    transform: scale(1.05);
    }

    .btn-sesion:active {
    background-color: #032030; 
    transform: scale(0.95);
    }

    .btn {
        padding: 10px 20px;
        border: none;
        cursor: pointer;
        font-size: 16px;
        text-decoration: none;
        display: inline-block;
        margin-top: 10px;
    }
    .btn-green { background-color: #28a745; color: white; }
    .btn-red { background-color: #dc3545; color: white; }
    
</style>
<body data-spy="scroll" data-target="#main-menu">
    <!--Animación de carga -->
    <div id="pageloader">
        <div class="loader">
            <img src="images/progress.gif" alt='loader'/>
        </div>
    </div>
    <!--Fin de animación de carga -->
    <?php if (isset($_GET['bienvenido'])): ?>
        <script>
            alert("¡BIENVENID@, <?php echo $nombreUsuario; ?>");
        </script>
    <?php endif; ?>
    <!--Inicio de la navegación-->
    <header id="header">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                        data-target="#main-menu">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="fa fa-bars"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <!--Inicio del logo -->
                    <div class="logo-nav">
                        <a href="index.php">
                            <img src="images/logo.png" alt="Logo del voluntariado"/>
                        </a>
                    </div>
                    <!--Fin del logo -->
                    <!--Inicio de la navegación -->
                    <div class="clear-toggle"></div>
                    <div id="main-menu" class="collapse scroll navbar-right">
                        <ul class="nav">
                            <li><a href="#about">Nosotros</a></li>
                            <li><a href="#history">Historia</a></li>
                            <li><a href="#works">Nuestros Trabajos</a></li>
                            <li><a href="#services">Servicios</a></li>
                            <li><a href="#blog">Proyectos</a></li>
                            <li><a href="#contact">Contactos</a></li>
                            <button class="btn-sesion" onclick="window.location.href='<?php echo $botonEnlace; ?>'">
                                <?php echo $botonTexto; ?>
                            </button>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- Fin de la navegación-->
    <!-- Inicio del carrusel  -->
    <section id="home" class="home">
        <div class="slider-overlay"></div>
        <div class="flexslider">
            <ul class="slides scroll">
                <li class="first">
                    <div class="slider-text-wrapper">
                        <div class="container">
                            <div class="big">jOVENES POR UN NUEVO MUNDO </div>
                            <div class="small">Innovar, persistir y crecer para lograr el éxito</div>
                            <a href="#works" class="middle btn btn-white">Ver Más...</a>
                        </div>
                    </div>
                    <img src="./images/slider/1.jpg"/>
                </li>
                <li class="secondary">
                    <div class="slider-text-wrapper">
                        <div class="container">
                            <div class="big">jOVENES POR UN NUEVO MUNDO </div>
                            <div class="small">Convierte tus ideas en negocios con determinación</div>
                            <a href="#works" class=" middle btn btn-white">Ver Más...</a>
                        </div>
                    </div>
                    <img src="./images/slider/2.jpg"/>
                </li>
                <li class="third">
                    <div class="slider-text-wrapper">
                        <div class="container">
                            <div class="big">jOVENES POR UN NUEVO MUNDO</div>
                            <div class="small">Sueña, trabaja y avanza hacia tu propio destino</div>
                            <a href="#works" class="middle btn btn-white">Ver Más...</a>
                        </div>
                    </div>
                    <img src="./images/slider/3.jpg"/>
                </li>
            </ul>
        </div>
    </section>
    <br><br><br><br>
    <!-- Fin del carrusel  -->
    <div class="title-box text-center">
        <h2 class="title">Nuestros Valores</h2>
    </div>
    <!--Start Features-->
    <section id="about" class="section">
        <div class="container">
            <div class="row">
                <!-- Features Icon-->
                <div class="col-md-4">
                    <div class="features-icon-box">
                        <div class="features-icon">
                            <i class="fa fa-leaf"></i>
                        </div>
                        <div class="features-info">
                            <h4>Compromiso con el cambio</h4>
                            <p>Adoptamos una actitud proactiva hacia la innovación y la mejora continua, enfrentando los desafíos con determinación para alcanzar un impacto positivo.</p>
                        </div>
                    </div>
                </div>
                <!-- Features Icon-->
                <div class="col-md-4">
                    <div class="features-icon-box">
                        <div class="features-icon">
                            <i class="fa fa-paper-plane"></i>
                        </div>
                        <div class="features-info">
                            <h4>Trabajo en equipo</h4>
                            <p>Fomentamos un ambiente colaborativo donde el esfuerzo colectivo y el respeto mutuo generan resultados extraordinarios.</p>
                        </div>
                    </div>
                </div>
                <!-- Features Icon-->
                <div class="col-md-4">
                    <div class="features-icon-box">
                        <div class="features-icon">
                            <i class="fa fa-life-saver"></i>
                        </div>
                        <div class="features-info">
                            <h4>Transparencia</h4>
                            <p>Actuamos con honestidad y claridad en cada acción, promoviendo la confianza y la credibilidad en nuestras relaciones.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--End Features-->

    <!-- Start Facts-->
    <section id="facts" class="section parallax">
        <div class="overlay"></div>
        <div class="container">
            <div class="row">
                <!-- Start Item-->
                <div class="col-md-3 col-sm-6 facts-box margin-bottom-30">
                    <span><i class="icon-happy"></i></span>
                    <h3>76</h3>
                    <span>Clientes Satisfechos</span>
                </div>
                <!-- End Item-->

                <!-- Start Item-->
                <div class="col-md-3 col-sm-6 facts-box margin-bottom-30">
                    <span><i class="icon-presentation"></i></span>
                    <h3>6</h3>
                    <span>Proyectos</span>
                </div>
                <!-- End Item-->

                <!-- Start Item-->
                <div class="col-md-3 col-sm-6 facts-box margin-bottom-30">
                    <span><i class="icon-target"></i></span>
                    <h3>36</h3>
                    <span>Lugares Visitados</span>
                </div>
                <!-- End Item-->

                <!-- Start Item-->
                <div class="col-md-3 col-sm-6 facts-box margin-bottom-30">
                    <span><i class="icon-trophy"></i></span>
                    <h3>159</h3>
                    <span>Colaboradores</span>
                </div>
                <!-- End Item-->
            </div>
        </div>
    </section>
    <!--End Facts-->

    <!--Start Section-->
    <section class="section">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="content-tab-1">
                        <ul class="nav">
                            <li class="active">
                                <a aria-expanded="true" href="#tab-content-1" data-toggle="tab">
                                    <i class="fa fa-desktop"></i>
                                    <h4>Propositos</h4>
                                </a>
                                <div class="tab-arrow">
                                </div>
                            </li>
                            <li>
                                <a aria-expanded="true" href="#tab-content-2" data-toggle="tab">
                                    <i class="fa fa-cubes"></i>
                                    <h4>Nosotros</h4>
                                </a>
                                <div class="tab-arrow">
                                </div>
                            </li>
                            <li>
                                <a aria-expanded="true" href="#tab-content-3" data-toggle="tab">
                                    <i class="fa fa-institution"></i>
                                    <h4>Planes</h4>
                                </a>
                                <div class="tab-arrow">
                                </div>
                            </li>
                            <li>
                                <a aria-expanded="true" href="#tab-content-5" data-toggle="tab">
                                    <i class="fa fa-pie-chart"></i>
                                    <h4>Objetivos</h4>
                                </a>
                                <div class="tab-arrow">
                                </div>
                            </li>
                        </ul>
                        <div class="tab-content-main">
                            <div class="container">
                                <div class="tab-content">
                                    <div class="tab-pane active in" id="tab-content-1">
                                        <!-- Features Icon-->
                                        <div class="col-md-6 margin-bottom-30">
                                            <div class="tab1-features">
                                                <div class="icon"> <i class="fa fa-star-o"></i> </div>
                                                <div class="info">
                                                    <h4>Fomentar la Unidad Juvenil para el Progreso Social</h4>
                                                    <p>Crear un entorno donde los jóvenes colaboren en proyectos que
                                                        impulsen cambios positivos en la sociedad. </p>
                                                </div>
                                            </div>
                                            <div class="tab1-features">
                                                <div class="icon"> <i class="fa fa-codepen"></i> </div>
                                                <div class="info">
                                                    <h4>Promover el Liderazgo Juvenil en el Ámbito Empresarial</h4>
                                                    <p>Inspirar a los jóvenes a tomar roles activos en la comunidad
                                                        empresarial, impulsando iniciativas que beneficien tanto a las
                                                        empresas como a la sociedad.</p>
                                                </div>
                                            </div>
                                            <div class="tab1-features">
                                                <div class="icon"> <i class="fa fa-heart-o"></i></div>
                                                <div class="info">
                                                    <h4>Construir un Futuro Sostenible y Equitativo</h4>
                                                    <p>Motivar a los jóvenes a desarrollar acciones que promuevan la
                                                        justicia social, la equidad y la sostenibilidad como pilares
                                                        fundamentales para el bienestar colectivo.</p>
                                                </div>
                                            </div>
                                        </div>
                                        <!--End features Icon-->
                                        <!--  Inicio del carrusel-->
                                        <div class="col-md-6">
                                            <div class="tab-carousel">
                                                <div class="item"><img src="images/works/img4.jpg" alt=""></div>
                                                <div class="item"><img src="images/works/img5.jpg" alt=""></div>
                                                <div class="item"><img src="images/works/img6.jpg" alt=""></div>
                                            </div>
                                        </div>
                                        <!-- Fin del carrusel-->
                                    </div>
                                    <!-- End Tab content 1-->
                                    <!-- Start Tab content 2-->
                                    <div class="tab-pane" id="tab-content-2">
                                        <div class="col-md-4">
                                            <div class="tab2-services-box">
                                                <div class="media">
                                                    <img src="images/services1.jpg" alt="services" />
                                                </div>
                                                <div class="services-info">
                                                    <h4>Misión</h4>
                                                    <p>Promover la participación activa de jóvenes comprometidos con el
                                                        cambio social y empresarial, desarrollando sus habilidades
                                                        personales y profesionales a través de proyectos que beneficien
                                                        a las comunidades.</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="tab2-services-box">
                                                <div class="media">
                                                    <img src="images/services2.jpg" alt="services" />
                                                </div>
                                                <div class="services-info">
                                                    <h4>Visión</h4>
                                                    <p>Ser el grupo voluntario líder en el desarrollo de proyectos
                                                        social-empresarial que impacten positivamente en la comunidad,
                                                        potenciando el talento juvenil como motor de cambio.
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="tab2-services-box">
                                                <div class="media">
                                                    <img src="images/services3.jpg" alt="services" />
                                                </div>
                                                <div class="services-info">
                                                    <h4>Valores Estratégicos</h4>
                                                    <ul class="list">
                                                        <li>compromiso con el cambio.</li><br>
                                                        <li>Trabajo en equipo y cooperación.</li><br>
                                                        <li>Transparencia en todas las actividades.</li><br>
                                                        <li>Inclusión y diversidad.</li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="tab-content-3">
                                        <div class="features-tab3">
                                            <!--Start Features Left-->
                                            <div class="col-md-4">
                                                <div class="features-left m-bot-30">
                                                    <!--Features Item #1-->
                                                    <div class="features-item">
                                                        <div class="features-icon"> <i class="fa fa-pagelines"></i>
                                                        </div>
                                                        <div class="features-info">
                                                            <h4>Identificar y abordar problemáticas
                                                                sociales-empresariales</h4>
                                                            <p>Analizar las necesidades específicas de las comunidades
                                                                locales para diseñar soluciones que vinculen el
                                                                desarrollo empresarial con el impacto social</p>
                                                        </div>
                                                    </div>
                                                    <!--Features Item #2-->
                                                    <div class="features-item">
                                                        <div class="features-icon"> <i class="fa fa-trophy"></i> </div>
                                                        <div class="features-info">
                                                            <h4>Crear talleres y capacitaciones para emprendedores</h4>
                                                            <p>Diseñar y ofrecer programas de formación en gestión
                                                                empresarial, innovación, desarrollo de productos y
                                                                habilidades blandas</p>
                                                        </div>
                                                    </div>
                                                    <!--Features Item #3-->
                                                    <div class="features-item">
                                                        <div class="features-icon"> <i class="fa fa-tag"></i> </div>
                                                        <div class="features-info">
                                                            <h4>Formar un equipo de jóvenes voluntarios </h4>
                                                            <p>Reclutar y entrenar a jóvenes comprometidos en áreas
                                                                empresariales y sociales, promoviendo el liderazgo y la
                                                                acción comunitaria</p>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                            <!--End Features Left-->
                                            <!--Start Features Image-->
                                            <div class="col-md-4 hidden-xs m-bot-30">
                                                <img src="images/device.png" alt="Features Image" />
                                            </div>
                                            <!--End Features Image-->
                                            <!--Start Features Right-->
                                            <div class="col-md-4">
                                                <div class="features-right m-bot-30">
                                                    <!--Features Item #1-->
                                                    <div class="features-item">
                                                        <div class="features-icon"> <i class="fa fa-eyedropper"></i>
                                                        </div>
                                                        <div class="features-info">
                                                            <h4>Facilitar el acceso a recursos para emprendedores</h4>
                                                            <p>Proveer herramientas necesarias para que los
                                                                emprendedores optimicen sus proyectos y alcancen niveles
                                                                de éxito.</p>
                                                        </div>
                                                    </div>
                                                    <!--Features Item #2-->
                                                    <div class="features-item">
                                                        <div class="features-icon"> <i class="fa fa-search-plus"></i>
                                                        </div>
                                                        <div class="features-info">
                                                            <h4>Impulsar alianzas estratégicas con empresas</h4>
                                                            <p>Crear vínculos con empresas y entidades para generar
                                                                colaboraciones que potencien iniciativas sociales.</p>
                                                        </div>
                                                    </div>
                                                    <!--Features Item #3-->
                                                    <div class="features-item">
                                                        <div class="features-icon"> <i class="fa fa-send-o"></i> </div>
                                                        <div class="features-info">
                                                            <h4>Organizar ferias de emprendimiento</h4>
                                                            <p>Realizar eventos que den visibilidad a los proyectos de
                                                                emprendedores locales, permitan el intercambio de ideas
                                                                entre jóvenes.</p>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                            <!--End Features Right -->
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="tab-content-5">
                                        <div class="tab-content-5">
                                            <div class="col-md-6">
                                                <div class="core-features">
                                                    <p>Formar un grupo de jóvenes voluntarios que trabajen de manera
                                                        colaborativa en proyectos que busquen mejorar la sociedad y
                                                        comunidad empresarial.</p>
                                                    <p>Este grupo de voluntarios será clave en la ejecución de
                                                        iniciativas que impulsen el desarrollo local, fomenten la
                                                        participación activa en la mejora de la comunidad, y promuevan
                                                        la creación de soluciones que beneficien tanto a la sociedad
                                                        como al entorno empresarial.</p>
                                                    <ul class="list">
                                                        <li>Identificar y abordar problemáticas sociales-empresariales
                                                            locales.</li>
                                                        <li>Crear talleres y capacitaciones periódicas para
                                                            emprendedores en temas de gestión empresarial, innovación y
                                                            desarrollo de productos.</li>
                                                        <li>Formar un equipo de jóvenes voluntarios capacitados en temas
                                                            empresariales y sociales.</li>
                                                        <li>Facilitar el acceso a recursos y herramientas para
                                                            emprendedores que busquen mejorar sus proyectos.</li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="devices-image">
                                                    <img src="images/device-desktop.png" alt="" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--End Section-->
    <!--inicio de la sección de historia-->
    <section id="history" class="section parallax">
        <div class="overlay"></div>
        <div class="container">
            <div class="title-box text-center white">
                <h2 class="title">Historia</h2>
            </div>
            <!-- History Timeline -->
            <ul class="timeline list-unstyled">
                <li class="year">1</li>
                <!--History Item -->
                <li class="timeline-item">
                    <h4>Idea de responsabilidad social</h4>
                    <p>
                        En este año, el Lic. Amado Lopez tuvo una idea de fundar un voluntariado con un enfoque social-empresarial.
                    </p>
                    <span> 12 Agos. 2020</span>
                </li>
                <!-- End Item -->
                <!--History Item -->
                <li class="timeline-item">
                    <h4>Primera Convocatoria</h4>
                    <p>Se llevó a cabo la 1era Convocatoria para atraer a jóvenes voluntarios dispuestos a ayudar y orientar a emprendedores.</p>
                    <span> 18 Oct. 2023</span>
                </li>
                <!-- End Item -->
                <!-- History Year -->
                <li class="year">2</li>
                <!--History Item -->
                <li class="timeline-item">
                    <h4>Primera actividad de integranción</h4>
                    <p>Se realizó una bicicleteada al bosque Cañoncillo, en donde los jóvenes se conocieron y se integraron por primera vez.</p>
                    <span> 10 Dic. 2023</span>
                </li>
                <!-- End Item -->
                <!--History Item -->
                <li class="timeline-item">
                    <h4>Reactivación del voluntariado</h4>
                    <p>Después de un tiempo de pausa, "Jóvenes por un Nuevo Mundo" vuelve con más fuerza que nunca. Un grupo de jóvenes comprometidos con el cambio se une para impulsar proyectos con impacto social y empresarial.</p>
                    <span> 3 Ene.2025</span>
                </li>
                <!-- End Item -->
                <!--History Item -->
                <li class="timeline-item">
                    <h4>Inicio de actividades</h4>
                    <p>La jornada arranca con una charla inspiradora que motiva a los voluntarios a comprometerse con el cambio, seguida de asesoramientos personalizados para guiarlos en sus proyectos que ayudan a los emprendedores.</p>
                    <span> 7 Febr. 2025</span>
                </li>
                <!-- End Item -->
                <li class="clear"></li>
                <li class="end-icon fa fa-bookmark"></li>
            </ul>
            <!-- End History Timeline -->
        </div> 
    </section>
    <!--Fin de la sección de historia-->

    <!-- Inicio del portafoleo-->
    <section id="works" class="section">
        <!-- Filtering -->
        <div class="title-box text-center">
            <h2 class="title">Nuestros Trabajos</h2>
        </div>
        <div class=" col-md-12 text-center">
            <!-- Filtering -->
            <ul class="filtering">
                <li class="filter" data-filter="all">Todo</li>
                <li class="filter" data-filter="fashion">Eventos</li>
                <li class="filter" data-filter="event">Ambiental</li>
                <li class="filter" data-filter="wedding">social</li>
                <li class="filter" data-filter="corporate">Comunitario</li>
            </ul>
        </div>
        <div class="work-main">
            <!-- Work Grid -->
            <ul class="work-grid">
                <!-- Work Item -->
                <li class="work-item thumnail-img mix corporate">
                    <div class="work-image">
                        <img src="images/works/img1.jpg" alt="thumbnail">
                        <!--Hover link-->
                        <div class="hover-link">
                            <a href="single-work.html">
                                <i class="fa fa-link"></i>
                            </a>
                            <a href="images/works/img1.jpg" class="popup-image">
                                <i class="fa fa-plus"></i>
                            </a>
                        </div>
                        <!--End link-->
                        <!--Hover Caption-->
                        <div class="work-caption">
                            <h4>Project Title</h4>
                            <p>Photography</p>
                        </div>
                        <!--End Caption-->
                    </div> <!-- /.work-image-->
                </li>
                <!--End Work Item -->
                <!-- Work Item -->
                <li class="work-item thumnail-img mix fashion wedding">
                    <div class="work-image">
                        <img src="images/works/img2.jpg" alt="thumbnail">
                        <!--Hover link-->
                        <div class="hover-link">
                            <a href="single-work.html">
                                <i class="fa fa-link"></i>
                            </a>
                            <a href="images/works/img2.jpg" class="popup-image">
                                <i class="fa fa-plus"></i>
                            </a>
                        </div>
                        <!--End link-->
                        <!--Hover Caption-->
                        <div class="work-caption">
                            <h4>Project Title</h4>
                            <p>Photography</p>
                        </div>
                        <!--End Caption-->
                    </div>
                </li>
                <!--End Work Item -->
                <!-- Work Item -->
                <li class="work-item thumnail-img mix corporate">
                    <div class="work-image">
                        <img src="images/works/img3.jpg" alt="thumbnail">
                        <!--Hover link-->
                        <div class="hover-link">
                            <a href="single-work.html">
                                <i class="fa fa-link"></i>
                            </a>
                            <a href="images/works/img3.jpg" class="popup-image">
                                <i class="fa fa-plus"></i>
                            </a>
                        </div>
                        <!--End link-->
                        <!--Hover Caption-->
                        <div class="work-caption">
                            <h4>Project Title</h4>
                            <p>Photography</p>
                        </div>
                        <!--End Caption-->
                    </div> 
                </li>
                <!--End Work Item -->

                <!-- Work Item -->
                <li class="work-item thumnail-img mix corporate">
                    <div class="work-image">
                        <img src="images/works/img4.jpg" alt="thumbnail">
                        <!--Hover link-->
                        <div class="hover-link">
                            <a href="single-work.html">
                                <i class="fa fa-link"></i>
                            </a>

                            <a href="images/works/img4.jpg" class="popup-image">
                                <i class="fa fa-plus"></i>
                            </a>
                        </div>
                        <!--End link-->

                        <!--Hover Caption-->
                        <div class="work-caption">
                            <h4>Project Title</h4>
                            <p>Photography</p>
                        </div>
                        <!--End Caption-->
                    </div>
                </li>
                <!--End Work Item -->

                <!-- Work Item -->
                <li class="work-item thumnail-img mix fashion wedding">
                    <div class="work-image">
                        <img src="images/works/img5.jpg" alt="thumbnail">
                        <!--Hover link-->
                        <div class="hover-link">
                            <a href="single-work.html">
                                <i class="fa fa-link"></i>
                            </a>
                            <a href="images/works/img5.jpg" class="popup-image">
                                <i class="fa fa-plus"></i>
                            </a>
                        </div>
                        <!--End link-->
                        <!--Hover Caption-->
                        <div class="work-caption">
                            <h4>Project Title</h4>
                            <p>Photography</p>
                        </div>
                        <!--End Caption-->
                    </div> 
                </li>
                <!--End Work Item -->

                <!-- Work Item -->
                <li class="work-item thumnail-img mix event wedding">
                    <div class="work-image">
                        <img src="images/works/img6.jpg" alt="thumbnail">
                        <!--Hover link-->
                        <div class="hover-link">
                            <a href="single-work.html">
                                <i class="fa fa-link"></i>
                            </a>
                            <a href="images/works/img6.jpg" class="popup-image">
                                <i class="fa fa-plus"></i>
                            </a>
                        </div>
                        <!--End link-->
                        <!--Hover Caption-->
                        <div class="work-caption">
                            <h4>Project Title</h4>
                            <p>Photography</p>
                        </div>
                        <!--End Caption-->
                    </div>
                </li>
                <!--End Work Item -->

                <!-- Work Item -->
                <li class="work-item thumnail-img mix event">
                    <div class="work-image">
                        <img src="images/works/img7.jpg" alt="thumbnail">
                        <!--Hover link-->
                        <div class="hover-link">
                            <a href="single-work.html">
                                <i class="fa fa-link"></i>
                            </a>
                            <a href="images/works/img7.jpg" class="popup-image">
                                <i class="fa fa-plus"></i>
                            </a>
                        </div>
                        <!--End link-->
                        <!--Hover Caption-->
                        <div class="work-caption">
                            <h4>Project Title</h4>
                            <p>Photography</p>
                        </div>
                        <!--End Caption-->
                    </div> 
                </li>
                <!--End Work Item -->
                <!-- Work Item -->
                <li class="work-item thumnail-img mix corporate">
                    <div class="work-image">
                        <img src="images/works/img8.jpg" alt="thumbnail">
                        <!--Hover link-->
                        <div class="hover-link">
                            <a href="single-work.html">
                                <i class="fa fa-link"></i>
                            </a>
                            <a href="images/works/img8.jpg" class="popup-image">
                                <i class="fa fa-plus"></i>
                            </a>
                        </div>
                        <!--End link-->
                        <!--Hover Caption-->
                        <div class="work-caption">
                            <h4>Project Title</h4>
                            <p>Photography</p>
                        </div>
                        <!--End Caption-->
                    </div>
                </li>
                <!--End Work Item -->
                <!-- Work Item -->
                <li class="work-item thumnail-img mix event">
                    <div class="work-image">
                        <img src="images/works/img9.jpg" alt="thumbnail">
                        <!--Hover link-->
                        <div class="hover-link">
                            <a href="single-work.html">
                                <i class="fa fa-link"></i>
                            </a>
                            <a href="images/works/img9.jpg" class="popup-image">
                                <i class="fa fa-plus"></i>
                            </a>
                        </div>
                        <!--End link-->
                        <!--Hover Caption-->
                        <div class="work-caption">
                            <h4>Project Title</h4>
                            <p>Photography</p>
                        </div>
                        <!--End Caption-->
                    </div>
                </li>
                <!--End Work Item -->
                <!-- Work Item -->
                <li class="work-item thumnail-img mix wedding">
                    <div class="work-image">
                        <img src="images/works/img10.jpg" alt="thumbnail">
                        <!--Hover link-->
                        <div class="hover-link">
                            <a href="single-work.html">
                                <i class="fa fa-link"></i>
                            </a>
                            <a href="images/works/img10.jpg" class="popup-image">
                                <i class="fa fa-plus"></i>
                            </a>
                        </div>
                        <!--End link-->
                        <!--Hover Caption-->
                        <div class="work-caption">
                            <h4>Project Title</h4>
                            <p>Photography</p>
                        </div>
                        <!--End Caption-->

                    </div>
                </li>
                <!--End Work Item -->

                <!-- Work Item -->
                <li class="work-item thumnail-img mix fashion">
                    <div class="work-image">
                        <img src="images/works/img11.jpg" alt="thumbnail">

                        <!--Hover link-->
                        <div class="hover-link">
                            <a href="single-work.html">
                                <i class="fa fa-link"></i>
                            </a>

                            <a href="images/works/img11.jpg" class="popup-image">
                                <i class="fa fa-plus"></i>
                            </a>
                        </div>
                        <!--End link-->

                        <!--Hover Caption-->
                        <div class="work-caption">
                            <h4>Project Title</h4>
                            <p>Photography</p>
                        </div>
                        <!--End Caption-->
                    </div>
                </li>
                <!--End Work Item -->

                <!-- Work Item -->
                <li class="work-item thumnail-img mix corporate">
                    <div class="work-image">
                        <img src="images/works/img12.jpg" alt="thumbnail">

                        <!--Hover link-->
                        <div class="hover-link">
                            <a href="single-work.html">
                                <i class="fa fa-link"></i>
                            </a>

                            <a href="images/works/img12.jpg" class="popup-image">
                                <i class="fa fa-plus"></i>
                            </a>
                        </div>
                        <!--End link-->

                        <!--Hover Caption-->
                        <div class="work-caption">
                            <h4>Project Title</h4>
                            <p>Photography</p>
                        </div>
                        <!--End Caption-->

                    </div> 
                </li>
            </ul>
        </div>
    </section>
    <!-- Fin del contenedor de trabajos -->
    <br><br><br><br>

    <!--Start Call To Action-->
    <section id="cta" class="parallax">
        <div class="overlay"></div>
        <div class="container">
            <div class="row text-center">
                <h2>¿Estas listo para unirte a nuestro equipo?</h2>
                <a href="#contact" class="btn btn-green">Conctáctate con nosotros!</a>
            </div>
        </div>
    </section>
    <!--End Call To Action-->
    <br><br><br><br><br>
    <!--Start Skills-->
    <section id="skills" class="section parallax">
        <div class="overlay"></div>
        <div class="container">
            <div class="row">

                <div class="title-box text-center white">
                    <h2 class="title">Beneficios del voluntariado</h2>
                </div>
                <!--Skill #1-->
                <div class="col-sm-3 col-md-3 col-lg-3 pie-chart-main">
                    <span class="pie-chart " data-percent="85">
                        <span class="percent"></span>
                    </span>
                    <h4>Constantes capacitaciones</h4>
                    <p>Formación continua para mejorar habilidades.</p>
                </div>
                <!--Skill #2-->
                <div class="col-sm-3 col-md-3 col-lg-3 pie-chart-main">
                    <span class="pie-chart" data-percent="75">
                        <span class="percent"></span>
                    </span>
                    <h4>Mayor red de contactos y oportunidades</h4>
                    <p>Expande conexiones y opciones laborales.</p>
                </div>
                <!--Skill #3-->
                <div class="col-sm-3 col-md-3 col-lg-3 pie-chart-main">
                    <span class="pie-chart " data-percent="60">
                        <span class="percent"></span>
                    </span>
                    <h4>Participación en proyectos</h4>
                    <p>Involucramiento en iniciativas de impacto.</p>
                </div>
                <!--Skill #4-->
                <div class="col-sm-3 col-md-3 col-lg-3 pie-chart-main">
                    <span class="pie-chart" data-percent="95">
                        <span class="percent"></span>
                    </span>
                    <h4>Certificado de prácticas pre-profesionales</h4>
                    <p>Acredita experiencia y mejora empleabilidad.</p>
                </div>
            </div>
        </div>
    </section>
    <!--End Skills-->

    <!-- Inicio de la casa del emprendedor-->
    <section id="services" class="section">
        <div class="container">
            <div class="row">

                <div class="title-box text-center">
                    <h2 class="title">Servicios de la casa del Emprendedor</h2>
                </div>

                <!--Services Item-->
                <div class="col-md-4">
                    <div class="services-box">
                        <div class="services-icon"> <i class="icon-basket"></i> </div>
                        <div class="services-desc">
                            <h4>Asesorías personalizadas</h4>
                            <p>Sesiones de orientación adaptadas a las necesidades individuales para mejorar el aprendizaje y la toma de decisiones. </p>
                        </div>
                    </div>
                </div>
                <!--End services Item-->

                <!--Services Item-->
                <div class="col-md-4">
                    <div class="services-box">
                        <div class="services-icon"> <i class="icon-shield"></i> </div>
                        <div class="services-desc">
                            <h4>Talleres express </h4>
                            <p>Capacitaciones cortas y dinámicas enfocadas en adquirir habilidades prácticas en poco tiempo. </p>
                        </div>
                    </div>
                </div>
                <!--End services Item-->

                <!--Services Item-->
                <div class="col-md-4">
                    <div class="services-box">
                        <div class="services-icon"> <i class="icon-hotairballoon"></i> </div>
                        <div class="services-desc">
                            <h4>Actividades emprendedoras</h4>
                            <p>Iniciativas diseñadas para fomentar la creatividad, el liderazgo y el desarrollo de proyectos de negocio. </p>
                        </div>
                    </div>
                </div>
            </div>
        </div> 
    </section>
    <!-- Fin de los servicios-->

    <!-- Inicio de areas a cargo-->
    <section id="why-choose" class="section">
        <div class="container">
            <div class="row">
                <div class="title-box text-center">
                    <h2 class="title">Nuestras Áreas a Cargo</h2>
                </div>
                <!--start tabs-->
                <div class="col-md-6">
                    <div class="tabs tabs-main">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#one" data-toggle="tab">RR.HH</a></li>
                            <li><a href="#two" data-toggle="tab">RR.PP</a></li>
                            <li><a href="#three" data-toggle="tab">MARKETING</a></li>
                        </ul>
                        <div class="tab-content">
                            <!--Start Tab Item #1 -->
                            <div class="tab-pane in active" id="one">
                                <p>
                                    Gestionar de manera eficiente al equipo de voluntarios, fomentando su crecimiento
                                    personal y profesional a través de capacitaciones, mentorías y oportunidades de
                                    desarrollo. Además, asegurar un ambiente colaborativo, motivador y alineado con los
                                    valores del grupo, para promover la productividad y el compromiso en cada proyecto.
                                </p>
                            </div>
                            <!-- End Tab -->
                            <!--Start Tab Item #2 -->
                            <div class="tab-pane" id="two">
                                <p>
                                    Construir relaciones estratégicas sólidas y colaborativas con instituciones,
                                    empresas y medios de comunicación, con el objetivo de fortalecer la sostenibilidad
                                    del grupo a largo plazo. Estas alianzas permitirán incrementar los recursos, ampliar
                                    la visibilidad de los proyectos y generar un impacto más significativo en la
                                    comunidad.
                                </p>
                            </div>
                            <!-- End Tab -->
                            <!--Start Tab Item #3 -->
                            <div class="tab-pane" id="three">
                                <p>
                                    Posicionar al grupo y sus proyectos como referentes en su área, logrando un
                                    reconocimiento destacado en la comunidad. Incrementar la participación activa de
                                    voluntarios y establecer alianzas estratégicas con organizaciones y actores clave
                                    para potenciar el impacto de las iniciativas desarrolladas.
                                </p>
                            </div>
                            <!-- End Tab -->
                        </div>
                    </div>
                </div>
                <!-- End Tabs-->

                <!--Start Accordion-->
                <div class="col-md-6">
                    <div class="panel-group accordion-main" id="accordion">
                        <!--About accordion #1-->
                        <div class="panel">
                            <div class="panel-heading collapsed" data-toggle="collapse" data-parent="#accordion"
                                data-target="#collapseOne">
                                <h6 class="panel-title accordion-toggle">
                                    Photography
                                </h6>
                            </div>
                            <div id="collapseOne" class="panel-collapse collapse">
                                <div class="panel-body">
                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin non blandit nibh.
                                        Sed eget tortor tincidunt, auctor sem eget, mollis nisi. Pellentesque ipsum
                                        erat, facilisis ut venenatis eu, sodales vel dolor fusce diam ornare.
                                    </p>

                                </div>
                            </div>
                        </div>

                        <!--About accordion #2-->
                        <div class="panel">
                            <div class="panel-heading collapsed" data-toggle="collapse" data-parent="#accordion"
                                data-target="#collapseTwo">
                                <h6 class="panel-title accordion-toggle">
                                    Web Designing
                                </h6>
                            </div>
                            <div id="collapseTwo" class="panel-collapse collapse">
                                <div class="panel-body">
                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin non blandit nibh.
                                        Sed eget tortor tincidunt, auctor sem eget, mollis nisi. Pellentesque ipsum
                                        erat, facilisis ut venenatis eu, sodales vel dolor fusce diam ornare.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!--About accordion #3-->
                        <div class="panel">
                            <div class="panel-heading collapsed" data-toggle="collapse" data-parent="#accordion"
                                data-target="#collapseThree">
                                <h6 class="panel-title accordion-toggle">
                                    Web Development
                                </h6>
                            </div>
                            <div id="collapseThree" class="panel-collapse collapse">
                                <div class="panel-body">
                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin non blandit nibh.
                                        Sed eget tortor tincidunt, auctor sem eget, mollis nisi. Pellentesque ipsum
                                        erat, facilisis ut venenatis eu, sodales vel dolor fusce diam ornare.
                                    </p>

                                </div>
                            </div>
                        </div>

                        <!--About accordion #4-->
                        <div class="panel">
                            <div class="panel-heading collapsed" data-toggle="collapse" data-parent="#accordion"
                                data-target="#collapseFour">
                                <h6 class="panel-title accordion-toggle">
                                    Responsive Design
                                </h6>
                            </div>
                            <div id="collapseFour" class="panel-collapse collapse">
                                <div class="panel-body">
                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin non blandit nibh.
                                        Sed eget tortor tincidunt, auctor sem eget, mollis nisi. Pellentesque ipsum
                                        erat, facilisis ut venenatis eu, sodales vel dolor fusce diam ornare.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> 
    </section>
    <!-- Fin de Areas a cargo-->

    <!-- Inicio del video-->
    <section id="video" class="section parallax">
        <div class="overlay"></div>
        <div class="container">
            <div class="row">
                <div class="title-box text-center white">
                    <h2 class="title">Publicidad</h2>
                </div>
                <div class="col-md-6">
                    <div class="video-caption-main">
                        <!--Video caption #1-->
                        <div class="video-caption">
                            <div class="video-icon">
                                <i class="fa fa-briefcase"></i>
                            </div>
                            <div class="video-caption-info">
                                <h4>Take a look at this video to see how we work.</h4>
                                <p>Lorem ipsum dolor consectetur adipisicing incididunt eiusmod tempor incididunt
                                    laboredolore magna aliqua.</p>
                            </div>
                        </div>
                        <!--Video caption #2-->
                        <div class="video-caption">
                            <div class="video-icon">
                                <i class="fa fa-glass"></i>
                            </div>
                            <div class="video-caption-info">
                                <h4>The programming language of ios apps</h4>
                                <p>Lorem ipsum dolor consectetur adipisicing incididunt eiusmod tempor incididunt
                                    laboredolore magna aliqua.</p>
                            </div>
                        </div>
                        <!--Video caption #3-->
                        <div class="video-caption">
                            <div class="video-icon">
                                <i class="fa fa-rocket "></i>
                            </div>
                            <div class="video-caption-info">
                                <h4>Take a look at this video to see how we work.</h4>
                                <p>Lorem ipsum dolor consectetur adipisicing incididunt eiusmod tempor incididunt
                                    laboredolore magna aliqua.</p>
                            </div>
                        </div>

                    </div>
                </div>
                <!-- End Video caption-->
                <div class="col-md-6">
                    <div class="play-video">
                        <iframe
                            src="http://player.vimeo.com/video/115919099?title=0&amp;byline=0&amp;portrait=0&amp;color=fff"
                            allowfullscreen></iframe>
                    </div>
                </div>
            </div> 
        </div>
    </section>
    <!--Fin del video video-->

    <!-- Inicio del blog-->
    <section id="blog" class="section">
        <div class="container">
            <div class="row">

                <div class="title-box text-center">
                    <h2 class="title">Nuestros Blogs</h2>
                </div>

                <!-- Start Blog item #1-->
                <div class="col-md-4">
                    <div class="blog-post">
                        <div class="post-media">
                            <img src="images/blog/blog3.jpg" alt="">
                        </div>
                        <div class="post-desc">
                            <h4>consectetur adipisicing Inventore</h4>
                            <h5>12 May, 2015 / 5 Comments</h5>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Inventore, dolorum, fugiat,
                                eligendi magni quibusdam iure cupiditate ex voluptas unde</p>
                            <a href="blog.html" class="btn btn-gray-border">Read More</a>
                        </div>
                    </div>
                </div>

                <!-- Start Blog item #2-->
                <div class="col-md-4">
                    <div class="blog-post">
                        <div class="post-media">
                            <img src="images/blog/blog2.jpg" alt="">
                        </div>
                        <div class="post-desc">
                            <h4>consectetur adipisicing Inventore</h4>
                            <h5>12 May, 2015 / 3 Comments</h5>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Inventore, dolorum, fugiat,
                                eligendi magni quibusdam iure cupiditate ex voluptas unde</p>
                            <a href="blog.html" class="btn btn-gray-border">Read More</a>
                        </div>
                    </div>
                </div>

                <!-- Start Blog item #3-->
                <div class="col-md-4">
                    <div class="blog-post">
                        <div class="post-media">
                            <img src="images/blog/blog3.jpg" alt="">
                        </div>
                        <div class="post-desc">
                            <h4>consectetur adipisicing Inventore</h4>
                            <h5>12 May, 2015 / 11 Comments</h5>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Inventore, dolorum, fugiat,
                                eligendi magni quibusdam iure cupiditate ex voluptas unde</p>
                            <a href="blog.html" class="btn btn-gray-border">Read More</a>
                        </div>
                    </div>
                </div>

            </div>
        </div> 
    </section>
    <!-- Fin del blog-->
    <!--Start clients-->
    <section id="clients" class="section">
        <div class="container">
            <div class="row">
                <div class="title-box text-center">
                    <h2 class="title">Patrocinadores</h2>
                </div>
                <div class="clients-carousel">
                    <!-- Patrocinador N°01-->
                    <div class="item">
                        <a href="#">
                            <figure>
                                <img src="images/clients-logo/client1.png" alt="" />
                            </figure>
                        </a>
                    </div>
                    <!-- Clients Logo Item-->
                    <div class="item">
                        <a href="#">
                            <figure>
                                <img src="images/clients-logo/cliente6.png" alt="" />
                            </figure>
                        </a>
                    </div>
                    <!-- Clients Logo Item-->
                    <div class="item">
                        <a href="#">
                            <figure>
                                <img src="images/clients-logo/client3.png" alt="" />
                            </figure>
                        </a>
                    </div>
                    <!-- Clients Logo Item-->
                    <div class="item">
                        <a href="#">
                            <figure>
                                <img src="images/clients-logo/client4.png" alt="" />
                            </figure>
                        </a>
                    </div>
                    <!-- Clients Logo Item-->
                    <div class="item">
                        <a href="#">
                            <figure>
                                <img src="images/clients-logo/client2.png" alt="" />
                            </figure>
                        </a>
                    </div>
                    <!-- Clients Logo Item-->
                    <div class="item">
                        <a href="#">
                            <figure>
                                <img src="images/clients-logo/client5.png" alt="" />
                            </figure>
                        </a>
                    </div>
                    <!-- Clients Logo Item-->
                    <div class="item">
                        <a href="#">
                            <figure>
                                <img src="images/clients-logo/client4.png" alt="" />
                            </figure>
                        </a>
                    </div>
                    <!-- Clients Logo Item-->
                    <div class="item">
                        <a href="#">
                            <figure>
                                <img src="images/clients-logo/client1.png" alt="" />
                            </figure>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--End clients-->
    <!-- Inicio de contactos-->
    <section id="contact" class="section parallax">
        <div class="overlay"></div>
        <div class="container">
            <div class="row">
                <div class="title-box text-center white">
                    <h2 class="title">Contactos</h2>
                </div>
            </div>
            <!--Inicio de contactos-->
            <div class="col-md-8 col-md-offset-2 contact-form">
                <div class="contact-info text-center">
                    <p>📞 944 688 913</p>
                    <p>🏰​ Jr. Gamarra 432, 4to piso (Entra por la notaría León de la Cruz y sube directo por las escaleras) </p>
                    <p>📧​ jovenesporunnuevomundo@gmail.com</p>
                </div>
                <form action="" method="post">
                    <div class="row">
                        <div class="col-md-4">
                            <input type="text" name="documento" class="form-control" id="documento" value="<?php echo $documento; ?>" placeholder="DNI" <?php echo $atributoDeshabilitado; ?> required>
                        </div>
                        <div class="col-md-4">
                            <input class="form-control" id="nombres" name="nombres" value="<?php echo $nombres; ?>" placeholder="Nombres" type="text" <?php echo $atributoDeshabilitado; ?> required>
                        </div>
                        <div class="col-md-4">
                            <input class="form-control" id="apellidoPaterno" name="apellidoPaterno" value="<?php echo $apellidoPaterno; ?>" placeholder="Apellidos" type="text" <?php echo $atributoDeshabilitado; ?> required>
                        </div>
                        <div class="col-md-4">
                            <input type="email" class="form-control" id="email" name="email" placeholder="Correo Electrónico" required>
                        </div>
                        <div class="col-md-4">
                            <input type="text" class="form-control" id="telefono" name="telefono" placeholder="Teléfono" required>
                        </div>
                        <div class="col-md-12">
                            <textarea class="form-control" id="mensaje" rows="7" placeholder="Escribe tu mensaje" required></textarea>
                        </div>
                        <div class="col-md-12 text-right">
                        <button type="submit" class="btn btn-green" <?php echo $botonEnviarDeshabilitado; ?>>
                            <?php echo $botonEnviarTexto; ?>
                        </button>
                    </div>
                    </div>
                </form>
    <script>
        // Bloquear todos los campos si el usuario es invitado
        let esInvitado = <?php echo json_encode($esInvitado); ?>;
        if (esInvitado) {
            document.querySelectorAll("input, textarea").forEach(elemento => {
                elemento.setAttribute("readonly", "readonly");
                elemento.classList.add("redonly");
            });
        }
    </script>
            </div>
        </div> 
    </section>
    <!--Inicio de pie de pagina-->
    <footer>
        <div class="container">
            <div class="row">
                <!-- Incio de copyright-->
                <div class="col-md-6 col-sm-6 col-xs-6">
                    <div class="copyright">
                        <p>Copyright © 2025 Todos los derechos reservados: <a href="https://www.facebook.com/profile.php?id=100082972283962&locale=es_LA"> Jhon Lozada Huamán</a>
                        </p>
                    </div>
                </div>
                <!-- Fin del copyright-->

                <!-- Iconos de redes sociales-->
                <div class="col-md-6 col-sm-6 col-xs-6">
                    <div class="social-icons">
                        <ul>
                        <li><a class="facebook" href="https://www.facebook.com/share/1BcGSGbqQF/ "><i class="fab fa-facebook"></i></a></li>
                        <li><a class="instagram" href="https://www.instagram.com/jovenes_por_un_nuevo_mundo?igsh=MWEyZnlpc3Z2NjJqOA== "><i class="fab fa-instagram"></i></a></li>
                        <li><a class="tiktok" href="https://www.tiktok.com/@jovenesporunnuevomundo?_t=ZM-8tJHOF7mDcE&_r=1 "><i class="fab fa-tiktok"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div> 
        </div> 
    </footer>
    <!-- Fin del pie de página-->
    <a href="https://api.whatsapp.com/send?phone=51944688913&text=Hola,%20Necesito%20informaci%C3%B3n..."
        target="_blank" class="float"> <i class="fa-brands fa-whatsapp"></i></a>
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
</body>
</html>