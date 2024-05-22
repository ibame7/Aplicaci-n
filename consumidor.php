<?php
session_start();
if (!isset($_SESSION['usuario']) || !isset($_SESSION['tipo']) || $_SESSION['tipo'] != "consumidor") {
    header("Location:index.php");
    exit;
} else {
    ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Perfil</title>
        <link rel="icon" type="image/x-icon" href="imagenes/icono.ico">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="estilos/stylePrincipal.css">
        <style>
            * {
                max-width: 100vw;
                max-height: 100vh;
                margin: 0;
                padding: 0;
                box-sizing: border-box;
            }

            .modal {
                display: none;
                position: fixed;
                z-index: 1;
                left: 0;
                top: 0;
                width: 100%;
                height: 100%;
                overflow: auto;
                background-color: rgba(0, 0, 0, 0.5);
            }

            .modal-content {
                background-color: #fefefe;
                margin: 15% auto;
                padding: 20px;
                border: 1px solid #888;
                width: 80%;
                max-width: 400px;
            }

            .close {
                color: #aaa;
                float: right;
                font-size: 28px;
                font-weight: bold;
            }

            .close:hover,
            .close:focus {
                color: black;
                text-decoration: none;
                cursor: pointer;
            }

            .barraLateral {
                width: 250px;
                background-color: #333;
                color: white;
                height: 100vh;
                position: fixed;
                z-index: 1;
                /* Ajustado para que esté sobre el contenido */
            }

            .barraLateral a {
                display: block;
                color: white;
                padding: 16px;
                text-decoration: none;
            }

            .barraLateral a:hover {
                background-color: #575757;
                cursor: pointer;
            }

            .contenido-Principal {
                margin-left: 250px;
                padding: 20px;
                flex-grow: 1;
            }

            .cabecera {
                padding: 10px;
                background: #333;
                color: white;
                text-align: center;
            }

            body {
                margin: 0;
            }

            .form-group {
                margin-bottom: 15px;
                text-align: left;
            }

            .form-group label {
                display: block;
                margin-bottom: 5px;
            }

            .form-group input {
                width: 100%;
                padding: 8px;
                box-sizing: border-box;
            }

            .form-group button {
                padding: 10px 15px;
                background-color: #333;
                color: white;
                border: none;
                cursor: pointer;
            }

            .form-group button:hover {
                background-color: #575757;
            }

            #perfil {
                max-width: 70vw;
                margin: auto;
                /* Centra horizontalmente */
                margin-top: 100px;
                /* Agrega un margen superior para dejar espacio para el navbar */
            }

            @media screen and (max-width: 800px) {
                .contenido-Principal {
                    margin-left: 0;
                    padding: 20px;
                    flex-grow: 1;
                }

                .navbar-vertical {
                    display: block;
                    position: fixed;
                    top: 50%;
                    left: 50%;
                    transform: translate(-50%, -50%);
                    z-index: 1;
                }
            }

            @media screen and (max-width: 1700px) {
                .cabecera h2 {
                    display: none;
                }

            }

            @media screen and (max-width: 990px) {
                .barraLateral {
                    width: 100%;
                    /* Ancho completo */
                    height: auto;
                    /* Altura automática */
                    position: relative;
                    top: 12vh;
                    /* Quita el posicionamiento fijo */
                }

                .barraLateral .cabecera {
                    display: none;
                    /* Oculta la cabecera en el modo horizontal */
                }

                .barraLateral a {
                    display: inline-block;
                    /* Muestra los enlaces en línea */
                    width: 20%;
                    /* Ajusta el ancho de cada enlace */
                    text-align: center;
                    align-content: center;
                    /* Centra el texto */
                }
            }

            @media screen and (max-width: 375px) {
                .barraLateral {
                    width: 100%;
                    /* Ancho completo */
                    height: auto;
                    /* Altura automática */
                    position: relative;
                    top: 20vh;
                    margin-bottom: 12px;
                    /* Quita el posicionamiento fijo */
                }

                .barraLateral .cabecera {
                    display: none;
                    /* Oculta la cabecera en el modo horizontal */
                }

                .barraLateral a {
                    display: inline-block;
                    /* Muestra los enlaces en línea */
                    width: 20%;
                    /* Ajusta el ancho de cada enlace */
                    text-align: center;
                    align-content: center;
                    /* Centra el texto */
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
        <div class="barraLateral">
            <div class="cabecera">
                <h2>Menú</h2>
            </div>
            <a id="perfilBoton" class="apartado" onclick="showContent('perfil')">Perfil</a>
            <a id="reservasBoton" class="apartado" onclick="showContent('reservas')">Reservas</a>
            <a id="reseniasBoton" class="apartado" onclick="showContent('resenias')">Reseñas</a>
            <a id="cerrarBoton" href="cerrarsesion.php">Salir</a>
        </div>
        <div id="changePasswordModal" class="modal" style="display:none">
            <div class="modal-content">
                <span class="close">&times;</span>
                <h2>Cambiar Contraseña</h2>
                <label for="currentPassword">Contraseña Actual:</label>
                <input type="password" id="currentPassword">
                <label for="newPassword">Nueva Contraseña:</label>
                <input type="password" id="newPassword">
                <button id="confirmChange">Confirmar Cambio</button>
            </div>
        </div>
        <div class="contenido-Principal">
            <div id="perfil" style="display:block">
                <h2>Modificar Perfil</h2>
                <form>
                    <div class="form-group">
                        <label for="usuario">Nombre de Usuario</label>
                        <input type="text" id="username" name="usuario">
                    </div>
                    <div class="form-group">
                        <label for="nombre">Nombre</label>
                        <input type="text" id="nombre" name="nombre">
                    </div>
                    <div class="form-group">
                        <label for="apellido1">Primer Apellido</label>
                        <input type="text" id="apellido1" name="apellido1">
                    </div>
                    <div class="form-group">
                        <label for="apellido2">Segundo Apellido</label>
                        <input type="text" id="apellido2" name="apellido2">
                    </div>
                    <div class="form-group">
                        <label for="email">Correo Electrónico</label>
                        <input type="email" id="email" name="email">
                    </div>

                    <div class="form-group">
                        <p id="error" style="color:red"></p>
                    </div>
                    <div class="form-group">
                        <button id="cambioDatos" type="button">Cambiar Datos</button>
                    </div>
                </form>
                <form>
                    <div class="form-group">
                        <label for="password">Nueva contraseña:</label>
                        <input type="password" id="password" name="password">
                    </div>
                    <div class="form-group">
                        <label for="confirmPassword">Repetir contraseña:</label>
                        <input type="password" id="confirmPassword" name="confirmPassword">
                    </div>
                    <div class="form-group">
                        <p id="error" style="color:red"></p>
                    </div>
                    <div class="form-group">
                        <button id="cambioContrasenia" type="button">Cambiar Contraseña</button>
                    </div>
                </form>

            </div>

            <div id="reservas" style="display:none">
                <h1>reservas</h1>
            </div>

            <div id="resenias" style="display:none">
                <h1>resenias</h1>
            </div>
        </div>

    </body>
    <script src="js/scriptPrincipal.js"></script>
    <script src="js/scriptConsumidor.js"></script>
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <?php
}
?>