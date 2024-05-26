<?php
session_start();
if (!isset($_SESSION['usuario']) || !isset($_SESSION['tipo']) || $_SESSION['tipo'] != "admin") {
    header("Location:index.php");
    exit;
} else {
    ?>
    <!DOCTYPE html>
    <html lang="es">

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

            .aniadirButton {
                width: 100vw;
                margin-top: 30px;
                max-width: 1000px;
                font-size: 1rem;
                padding: 5px;
                text-align: center;

                background: linear-gradient(rgba(132, 128, 204, 1), rgba(85, 162, 243, 0.8));
                color: white;
                font-weight: bolder;
                border-color: linear-gradient(rgba(132, 128, 204, 1), rgba(4, 1, 66, 1));
            }

            @import url('https://fonts.googleapis.com/css?family=Poppins&display=swap');

            * {
                box-sizing: border-box;
            }

            .modal-container2 button {
                background-color: #47a386;
                border: 0;
                border-radius: 5px;
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
                color: #fff;
                font-size: 14px;
                padding: 10px 25px;
            }

            .modal-container2 {
                display: flex;
                background-color: rgba(0, 0, 0, 0.3);
                align-items: center;
                justify-content: center;
                position: fixed;
                pointer-events: none;
                opacity: 0;
                top: 0;
                left: 0;
                height: 100vh;
                width: 100vw;
                transition: opacity 0.3s ease;
            }

            .show {
                pointer-events: auto;
                opacity: 1;
            }

            .modal2 {
                background-color: #fff;
                width: 600px;
                max-width: 100%;
                padding: 30px 50px;
                border-radius: 5px;
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
                text-align: center;
            }

            .modal2 h1 {
                margin: 0;
            }

            .modal2 p {
                opacity: 0.7;
                font-size: 14px;
            }

            .deleteButton {
                width: 90%;
                font-size: 1rem;
                padding: 5px;
                text-align: center;
                margin: 5px;
                background: linear-gradient(rgba(243, 90, 85, 0.8), rgba(255, 8, 0, 0.8));
                color: white;
                border-color: linear-gradient(rgba(132, 128, 204, 1), rgba(4, 1, 66, 1));
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
                background: linear-gradient(rgba(132, 128, 204, 1), rgba(4, 1, 66, 1));
                ;

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
                background: linear-gradient(rgba(132, 128, 204, 1), rgba(4, 1, 66, 1));
                ;
                width: 250px;
                background-color: #333;
                color: white;
                height: 100vh;
                position: fixed;
                z-index: 1;
                /* Ajustado para que esté sobre el contenido */
            }

            .barraLateral a {
                font-weight: bold;

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
                background: linear-gradient(rgba(132, 128, 204, 1), rgba(4, 1, 66, 1));
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

            #propietario,
            #comienzo, #reservas {
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

            .pistas-container,
            .resenia-container {
                display: flex;
                justify-content: center;
                /* Utilizamos flexbox */
                flex-wrap: wrap;
                /* Permite que los elementos se envuelvan en varias líneas si es necesario */
                /* justify-content: space-around; */
                /* Distribuye uniformemente los elementos a lo largo del contenedor */
                align-items: center;
                /* Centra verticalmente los elementos */
                gap: 10px;
                /* Espacio entre los elementos */
                height: 20px;
                /* Ajusta la altura automáticamente */
                width: 100%;
                padding-top: 80px;
               
                /* Ocupa todo el ancho disponible */
            }

            .pista,
            .resenia {
                padding: 20px;
                color: white;
                font-weight: bolder;
                border-radius: 8px;
                background: linear-gradient(rgba(104, 133, 208, 0.8), rgba(4, 1, 66, 1));
                ;
                height: 300px;
                text-align: center;
                /* Centra el contenido dentro de cada elemento */
                /* Añade margen para evitar que los elementos se peguen al contenedor */
                margin: 10px;
                /* Establece el ancho base de cada elemento para ocupar un tercio del contenedor */
                flex-basis: calc(33.33% - 100px);
                /* Restamos el espacio entre elementos para evitar desbordamiento */
            }

            table {
                width: 100vw;
                max-width: 1000px;
                border-collapse: collapse;
            }

            table,
            th,
            td {
                border: 1px solid black;
            }

            th,
            td {
                padding: 10px;
                text-align: left;
            }

            .pistas-container, #reservas {
                margin: 20px;
            }

            .pista:hover,
            .resenia:hover {
                background: linear-gradient(rgba(223, 92, 60, 0.8), rgba(4, 1, 66, 1));
                cursor: pointer;
            }

            .pista button,
            .resenia button {
                border-radius: 5px;
                border-style: none;
                width: 20%;
                background-color: red;
                font-weight: bold;
                /* Ajustar el ancho del botón al 100% del contenedor */
            }

            /* Ajuste para dispositivos con pantalla más pequeña */
            /* Ajuste para dispositivos con pantalla más pequeña */
            @media screen and (max-width: 768px) {

                .pista,
                .resenia {

                    flex-basis: calc(50% - 20px);
                    /* Para mostrar dos elementos por fila en pantallas más pequeñas */
                    padding: 10px;
                    /* Reducir el padding para dejar más espacio para el contenido */
                }

                .pistas-container, #reservas {
                    padding-top: 100px;
                    /* Reduce el espacio superior para dejar más espacio en pantallas pequeñas */
                    justify-content: center;
                    /* Alinea los elementos al principio del contenedor */
                }

                .pista button,
                .resenia button {
                    width: 50%;
                    /* Ajustar el ancho del botón al 100% del contenedor */
                }

            }
            #reservas, #contactos{
                margin-top: 110px;
            }
            .editButton{
                background-color: orangered;
                color:white;
                font-weight: bolder;
                width: 80px;
                border-radius: 5px;
                border-style: none;
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
            <a id="navPropietario" class="apartado" onclick="showContent('propietario')">Propietarios</a>
            <a id="navConsumidor" class="apartado" onclick="showContent('usuarios')">Usuarios</a>
            <a id="navReservas" class="apartado" onclick="showContent('reservas')">Reservas</a>
            <a id="navContactos" class="apartado" onclick="showContent('contactos')">Contactos</a>
            <a id="cerrarBoton" href="cerrarsesion.php">Salir</a>
        </div>
        <div class="contenido-Principal">
            <div id="comienzo">
                <img src="imagenes/Proyecto nuevo.png">
            </div>
            <div id="propietario" style="display:none"> </div>


            <div id="usuarios" class="pistas-container" style="display:none"> </div>

            <div id="modal_container2" class="modal-container2">
                <div class="modal2">
                    <h1>Datos</h1>
                    <form>
                        <div class="form-group">
                            <label for="Pueblo">Pueblo</label>
                            <input type="text" id="propietarioPueblo" name="Pueblo">
                        </div>
                        <div class="form-group">
                            <label for="nombre">Nombre</label>
                            <input type="text" id="propietarioNombre" name="nombre">
                        </div>
                        <div class="form-group">
                            <label for="primerApellido">Primer Apellido</label>
                            <input type="text" id="primerApellido" name="primerApellido">
                        </div>
                        <div class="form-group">
                            <label for="segundoApellido">Segundo Apellido</label>
                            <input type="text" id="segundoApellido" name="segundoApellido">
                        </div>
                        <div class="form-group">
                            <label for="correo">Correo</label>
                            <input type="email" id="propietariocorreo" name="correo">
                        </div>
                        <div class="form-group">
                            <label for="contrasenia">Contraseña</label>
                            <input type="password" id="propietariocontrasenia" name="contrasenia">
                        </div>
                        <div id="divError" style="color:red"></div>
                        <div class="form-group">
                            <button id="aniadirPropietario" type="button">Aceptar</button>
                        </div>
                    </form>
                    <button id="close">Cancelar</button>
                </div>
            </div>
        
        <div id="reservas" style="display:none">
            <h1>reservas</h1>
        </div>
        <div id="contactos" style="display:none">
            <h1>contactos</h1>
        </div>
        </div>

    </body>
    <script src="js/scriptPrincipal.js"></script>
    <script src="js/scriptAdministrador.js"></script>
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <?php
}
?>