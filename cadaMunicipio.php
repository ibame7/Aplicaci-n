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

        #resultados h1 {
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
            text-align: center;
            overflow: hidden;
        }

        .divInstalacion h3 {
            font-size: clamp(15px, 5vw, 27px);
            font-weight: bold;
            overflow-wrap: break-word;
            overflow: hidden;
            margin: 0;
            color: black;
        }

        .divInstalacion p {
            font-size: clamp(14px, 3vw, 24px);
            margin: 10px 0 0 0;
            max-width: 100%;
            font-weight: bold;
            color: rgba(0, 0, 20, 1);
        }

        @media screen and (max-width: 1200px) {
            .divInstalacion h3 {
                font-size: clamp(10px, 5vw, 15px);
            }

            .divInstalacion p {
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
            }

            #resultados h1 {
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
            }
        }

        /* Estilos específicos del modal */
        .modal-dialog {
            max-width: 90%;
        }

        .modal-contents {
            padding: 20px;
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .modal-title {
            font-size: 1.5rem;
        }

        .calendar {
            display: flex;
            flex-direction: column;
        }

        .calendar label {
            margin: 10px 0 5px 0;
            font-weight: bold;
        }

        .calendar input,
        .calendar select {
            padding: 10px;
            font-size: 1rem;
        }

        .open-modal-btn {
            background: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background 0.3s;
        }

        .open-modal-btn:hover {
            background: #45a049;
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
            justify-content: center;
            align-items: center;
        }

        .modal-contents {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 90%;
            max-width: 400px;
            text-align: center;
            position: relative;
        }

        .close-btn {
            position: absolute;
            top: 10px;
            right: 20px;
            font-size: 24px;
            cursor: pointer;
        }

        .date-picker,
        .time-picker {
            margin-bottom: 20px;
        }

        .date-picker input,
        .time-picker select {
            width: calc(100% - 40px);
            padding: 10px;
            margin: 10px 20px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        .submit-btn {
            background: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background 0.3s;
        }

        .submit-btn:hover {
            background: #45a049;
        }

        @media (max-width: 600px) {
            .modal-contents {
                padding: 15px;
            }

            .date-picker input,
            .time-picker select {
                width: calc(100% - 30px);
                margin: 10px 15px;
            }

            .submit-btn {
                width: calc(100% - 30px);
                margin: 10px 15px;
            }
        }

        .disabled {
            pointer-events: none;
            opacity: 0.4;
            /* O el valor que desees para que parezca "deshabilitado" */
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
    <!-- --------------------------- -->
    <div id="reservationModal" class="modal">
        <div class="modal-contents">
            <span id="closeModalBtn" class="close-btn">&times;</span>
            <h1>Reserva tu Pista</h1>
            <form id="reservationForm">
                <div class="date-picker">
                    <label for="date">Selecciona la Fecha:</label>
                    <input type="date" id="date" name="date" min="<?php echo date('Y-m-d'); ?>"
                        max="<?php echo date('Y-m-d', strtotime('+1 month')); ?>" required>
                </div>
                <div class="time-picker">
                    <label for="time">Selecciona la Hora:</label>
                    <select id="time" name="time" required>
                        <option value="">Selecciona la Hora</option>
                        <option value="10:00">10:00 a 11:00</option>
                        <option value="11:00">11:00 a 12:00</option>
                        <option value="12:00">12:00 a 13:00</option>
                        <option value="13:00">13:00 a 14:00</option>

                        <option value="16:00">16:00 a 17:00</option>
                        <option value="17:00">17:00 a 18:00</option>
                        <option value="18:00">18:00 a 19:00</option>
                        <option value="19:00">19:00 a 20:00</option>
                        <option value="20:00">20:00 a 21:00</option>
                        <option value="21:00">21:00 a 22:00</option>
                    </select>
                </div>
                <div id="error" style="color:red"></div>
                <button type="submit" class="submit-btn">Reservar</button>
            </form>
        </div>

        <!-- --------------------------- -->




        <!-- Scripts -->
        <script src="js/scriptPrincipal.js"></script>
        <script src="js/scriptcadaMunicipio.js"></script>
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>