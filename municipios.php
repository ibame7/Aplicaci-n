<?php
session_start();
?>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Reserva Y Juega</title>
    <link rel="icon" type="image/x-icon" href="imagenes/icono.ico" />
    <link rel="stylesheet" href="estilos/stylePrincipal.css">
    <style>
    </style>
</head>
<body>
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
<div id="municipios"></div>
</body>
<footer class="footer bg-black small text-center text-white-50">
    <div class="container px-4 px-lg-5">Copyright &copy; Reserva Y Juega 2024</div>
</footer>
<script src="js/scriptMunicipios.js"></script>
<script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>