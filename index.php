<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Reserva Y Juega</title>
    <link rel="icon" type="image/x-icon" href="imagenes/icono.ico" />
    <link rel="stylesheet" href="estilos/stylePrincipal.css">
</head>

<body id="page-top">
    <nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNav">
        <div class="container px-4 px-lg-5">
            <a class="navbar-brand" href="#page-top"><img src="imagenes/icono.ico" style="width:25%;"></a>
            <button class="navbar-toggler navbar-toggler-right" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false"
                aria-label="Toggle navigation">
                Menu
                <i class="fas fa-bars"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="">Municipios</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="">Contacto</a>
                    </li>
                    <li class="nav-item">
                        <?php if (isset($_SESSION['usuario']) && isset($_SESSION['tipo'])) {
                            echo '<a class="nav-link" href="perfil.php">',$_SESSION['usuario']['username'],'</a>';
                        } else {
                            echo '<a class="nav-link" href="signup.php">Sign Up</a>';
                        } ?>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <header class="masthead">
        <div class="container px-4 px-lg-5 d-flex h-100 align-items-center justify-content-center">
            <div class="d-flex justify-content-center">
                <div class="text-center">
                    <h1 class="mx-auto my-0 text-uppercase">Reserva y Juega</h1>
                    <br>
                    <h2 class="text-white-50 mx-auto mt-2 mb-5">Reserva y Juega es una app para reservar instalaciones
                        deportivas</h2>
                    <a class="btn btn-primary" href="">Buscar instalación</a>
                </div>
            </div>
        </div>
    </header>
    <section class="about-section text-center" id="about">
        <div class="container px-4 px-lg-5">
            <div class="row gx-4 gx-lg-5 justify-content-center">
                <div class="col-lg-8">
                    <h2 class="text-white mb-4">¿Por qué Reserva Y Juega?</h2>
                    <p class="text-white-50">
                        Somos una nueva aplicación que pretende mejorar, facilitar y agilizar el proceso de alquiler de
                        instalaciones deportivas.
                        Nuestro objetivo es agilizar todo el proceso que a veces puede ser complicado. Con nuestra
                        plataforma, los usuarios pueden
                        encontrar fácilmente instalaciones disponibles, ver su disponibilidad y reservar en tan solo
                        unos pocos clics.
                    </p>
                </div>
            </div>
            <img class="img-fluid" src="imagenes/presenta.png" alt="..." />
        </div>
    </section>
    <section class="projects-section bg-light" id="projects">
        <div class="container px-4 px-lg-5">
            <div class="row gx-0 mb-4 mb-lg-5 align-items-center">
                <div class="col-xl-8 col-lg-7"><img class="img-fluid mb-3 mb-lg-0" src="imagenes/padel2.jpeg"
                        alt="..." /></div>
                <div class="col-xl-4 col-lg-5">
                    <div class="featured-text text-center text-lg-left">
                        <h4>LA LLAVE PARA PRACTICAR TU DEPORTE</h4>
                        <p class="text-black-50 mb-0">CON NUESTRA APLICACIÓN PUEDES:
                            <br>
                            · Reservar pistas online
                            <br>
                            · Reduce el número de llamadas de los usuarios para reservar
                            <br>
                            · Suprimir aglomeraciones para formalizar una reserva deportiva
                            <br>
                            · Despreocúpate de la apertura de puertas gracias al acceso a través de código QR.
                        </p>
                    </div>
                </div>
            </div>
            <div class="row gx-0 mb-5 mb-lg-0 justify-content-center">
                <div class="col-lg-6"><img class="img-fluid" src="imagenes/gente.png" alt="..." /></div>
                <div class="col-lg-6">
                    <div class="bg-black text-center h-100 project">
                        <div class="d-flex h-100">
                            <div class="project-text w-100 my-auto text-center text-lg-left">
                                <h4 class="text-white">MÁS DE 50 CENTROS DEPORTIVOS</h4>
                                <p class="mb-0 text-white-50">Más de 2 años gestionando las zonas deportivas de tu
                                    municipio.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row gx-0 justify-content-center">
                <div class="col-lg-6"><img class="img-fluid" src="imagenes/gente.png" alt="..." /></div>
                <div class="col-lg-6 order-lg-first">
                    <div class="bg-black text-center h-100 project">
                        <div class="d-flex h-100">
                            <div class="project-text w-100 my-auto text-center text-lg-right">
                                <h4 class="text-white">+ de 200 usuarios</h4>
                                <p class="mb-0 text-white-50">Ofrece todas tus actividades a través de
                                    <b>Reserva Y Juega</b>
                                    y aumenta el nº de asistentes
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="contact-section bg-black">
        <div class="container px-4 px-lg-5">
            <div class="row gx-4 gx-lg-5">
                <div class="col-md-4 mb-3 mb-md-0">
                    <div class="card py-4 h-100">
                        <div class="card-body text-center"
                            style="display: flex; flex-direction: column; justify-content: center;">
                            <i class="fas fa-map-marked-alt text-primary mb-2"></i>
                            <h4 class="text-uppercase m-0">Preguntas Frecuentes</h4>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3 mb-md-0">
                    <div class="card py-4 h-100">
                        <div class="card-body text-center">
                            <i class="fas fa-envelope text-primary mb-2"></i>
                            <h4 class="text-uppercase m-0">Email</h4>
                            <hr class="my-4 mx-auto" />
                            <div class="small text-black-50">
                                <a
                                    href="https://mail.google.com/mail/u/0/?tab=rm&ogbl#inbox">reservayjuega@gmail.com</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3 mb-md-0">
                    <div class="card py-4 h-100">
                        <div class="card-body text-center">
                            <i class="fas fa-mobile-alt text-primary mb-2"></i>
                            <h4 class="text-uppercase m-0">Teléfono</h4>
                            <hr class="my-4 mx-auto" />
                            <div class="small text-black-50">
                                <p>Whatsapp: +34 644 89 23 84</p>
                            </div>

                            <div class="small text-black-50">
                                <p>Teléfono: +34 955 654 432</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="social d-flex justify-content-center">
                <a class="mx-2" href="https://twitter.com/?lang=es">
                    <i class="fab fa-twitter"></i>
                </a>
                <a class="mx-2"
                    href="https://www.facebook.com/login/?next=https%3A%2F%2Fwww.facebook.com%2F%3Flocale%3Des_ES">
                    <i class="fab fa-facebook-f"></i>
                </a>
                <a class="mx-2" href="https://www.instagram.com/">
                    <i class="fab fa-instagram"></i>
                </a>
            </div>
        </div>
    </section>

    <footer class="footer bg-black small text-center text-white-50">
        <div class="container px-4 px-lg-5">Copyright &copy; Reserva Y Juega 2024</div>
    </footer>
</body>
<script src="js/scriptPrincipal.js"></script>
<script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>

</html>
</body>

</html>