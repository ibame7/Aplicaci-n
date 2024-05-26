<?php
session_start();
?>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Reserva Y Juega</title>
    <link rel="icon" type="image/x-icon" href="imagenes/icono.ico" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="estilos/stylePrincipal.css">
    <style>
        * {
            max-width: 100vw;
            max-height: 100vh;
        }

        #resultados {
            width: 100vw;
            height: 100vh;
            align-content: center;
            justify-items: center;
            animation: changeBackground 35s infinite;
            overflow-y: auto;


        }

        @keyframes changeBackground {
            0% {
                background: linear-gradient(to bottom, rgba(0, 0, 0, 0.3) 0%, rgba(0, 0, 0, 0.7) 75%, #000 100%), url("imagenes/padel.jpeg");
                background-size: cover;
            }

            33.33% {
                background: linear-gradient(to bottom, rgba(0, 0, 0, 0.3) 0%, rgba(0, 0, 0, 0.7) 75%, #000 100%), url("imagenes/futbol.jpg");
                background-size: cover;
            }

            66.66% {
                background: linear-gradient(to bottom, rgba(0, 0, 0, 0.3) 0%, rgba(0, 0, 0, 0.7) 75%, #000 100%), url("imagenes/basket.jpeg");
                background-size: cover;
            }

            100% {
                background: linear-gradient(to bottom, rgba(0, 0, 0, 0.3) 0%, rgba(0, 0, 0, 0.7) 75%, #000 100%), url("imagenes/tenis.jpg");
                background-size: cover;
            }
        }

        .divError {
            width: 50vw;
            height: 50vh;
            position: relative;
            left: 24%;
            background-color: white;
            align-content: center;
            text-align: center;
            color: black;
            font-weight: bold;
            font-size: 1.8em;
            border-radius: 5px;
        }

        body {
            margin: 0;
            background-image: url("imagenes/basket.jpeg");
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            
        }

        .divInstalacion {
            width: 30%;
            height: 30%;
            flex: 0 0 calc(25% - 20px);
            max-width: calc(25% - 20px);
            box-sizing: border-box;
            margin-bottom: 20px;
        }

        #divInstalaciones {
            display: flex;
            flex-direction: row;
            flex-wrap: wrap;
            justify-content: center;
            gap: 60px;
        }

        .divInstalacion:hover {
            cursor: pointer;

        }

        #divFutbol {
            width: 100%;
            height: 230px;
            background-image: url(imagenes/pistas/futbol.png);
            background-size: contain;
            background-position: center;
            background-repeat: no-repeat;
        }

        #divBaloncesto {
            width: 100%;
            height: 230px;
            background-image: url(imagenes/pistas/baloncesto.png);
            background-size: contain;
            background-position: center;
            background-repeat: no-repeat;
        }

        h1 {
            text-align: center;
            font-weight: bolder;
            margin-bottom: 75px;
            font-size: 11rem;
            background: linear-gradient(rgba(183, 118, 208, 0.8), rgba(4, 1, 66, 1));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            text-fill-color: transparent;
        }

        #divBalonmano {
            width: 100%;
            height: 230px;
            background-image: url(imagenes/pistas/balonmano.png);
            background-size: contain;
            background-position: center;
            background-repeat: no-repeat;
        }

        #divTenis {
            width: 100%;
            height: 230px;
            background-image: url(imagenes/pistas/tenis.png);
            background-size: contain;
            background-position: center;
            background-repeat: no-repeat;
        }
       
        #divPadel {
            width: 100%;
            height: 230px;
            background-image: url(imagenes/pistas/padel.png);
            background-size: contain;
            background-position: center;
            background-repeat: no-repeat;
        }

        #divFutSal {
            width: 100%;
            height: 230px;
            background-image: url(imagenes/pistas/futsal.png);
            background-size: contain;
            background-position: center;
            background-repeat: no-repeat;
        }

        .divInstalacion {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            width: 100%;
            height: 100%;
            padding: 20px;
            /* Ajusta según sea necesario */
            text-align: center;
            overflow: hidden;
            /* Oculta cualquier desbordamiento */
        }

        .divInstalacion h3 {
            font-size: clamp(15px, 5vw, 27px);
            font-weight: bold;
            overflow-wrap: break-word;
            overflow: hidden;
            margin: 0;
            color:black;
        }

        .divInstalacion p {
            font-size: clamp(14px, 3vw, 24px);
            /* Ajusta el tamaño de la fuente de manera responsiva */
            margin: 10px 0 0 0;
            max-width: 100%;
            font-weight: bold;
            color:rgba(0, 0, 20, 1);

            
        }
        @media screen and (max-width: 1200px) {
            .divInstalacion h3  {
                font-size: clamp(10px, 5vw, 15px);

            }
            .divInstalacion p  {
                font-size: clamp(10px, 5vw, 15px);
            }
        }
        @media screen and (max-width: 768px) {
            .divInstalacion {
                flex: 0 0 calc(50% - 20px);
                max-width: calc(50% - 20px);
            }

            body {
                background-image: none;
            }

            #resultados {
                text-align: center;
                padding-top: 120px;
                background: linear-gradient(rgba(4, 1, 66, 1), rgba(183, 118, 208, 0.8));
                /* Cambia el fondo a blanco cuando la pantalla sea más pequeña que 768px */
            }

            h1 {
                margin-top: 25px;
                font-size: 4rem;
                background: white;
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                background-clip: text;
                text-fill-color: transparent;

            }

            #divInstalaciones {
                gap: 50px;
            }

            #resultados {
                animation: none;
                margin-top: ;
                /* Elimina la animación cuando la pantalla sea más pequeña que 768px */
            }
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNav">
        <div class="container px-4 px-lg-5">
            <a class="navbar-brand" href="index.php"><img src="imagenes/icono.ico" style="width:25%;"></a>
            <button class="navbar-toggler navbar-toggler-right" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false"
                aria-label="Toggle navigation">
                Menu
                <i class="fas fa-bars"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="municipios.php">Municipios</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="contacto.php">Contacto</a>
                    </li>
                    <li class="nav-item">
                        <?php if (isset($_SESSION['usuario']) && isset($_SESSION['tipo'])) {
                            if ($_SESSION['tipo'] == "consumidor") {
                                echo '<a class="nav-link" href="consumidor.php">', $_SESSION['usuario']['username'], '</a>';
                            } else if ($_SESSION['tipo'] == "propietario") {
                                echo '<a class="nav-link" href="propietario.php">', $_SESSION['usuario']['username'], '</a>';
                            } else if ($_SESSION['tipo'] == "admin") {
                                echo '<a class="nav-link" href="administrador.php">', $_SESSION['usuario']['username'], '</a>';

                            }
                        } else {
                            echo '<a class="nav-link" href="acceso.php">Acceso</a>';
                        } ?>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div id="resultados">
    </div>
    <section class="contact-section bg-black">
        <div class="container px-4 px-lg-5">
            <div class="row gx-4 gx-lg-5">
                <div class="col-md-4 mb-3 mb-md-0">
                    <div class="card py-4 h-100">
                        <div class="card-body text-center" id="faq"
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
<script src="js/scriptcadaMunicipio.js"></script>
<script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>