<?php
header('Content-Type: application/json');
header("Cache-Control: no-cache, must-revalidate");
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
session_start();

if (isset($_SESSION['usuario'])) {
    header("Location:index.php");
    exit;
}

$_POST = json_decode(file_get_contents('php://input'), true);

if (isset($_POST['nombre'], $_POST['user'], $_POST['apellido1'], $_POST['apellido2'], $_POST['contrasenia'], $_POST['confirmarContrasenia'], $_POST['correo']) &&
    !empty($_POST['nombre']) && !empty($_POST['user']) && !empty($_POST['apellido1']) && !empty($_POST['apellido2']) &&
    !empty($_POST['contrasenia']) && !empty($_POST['confirmarContrasenia']) && !empty($_POST['correo'])) {

    if (strlen($_POST['contrasenia']) < 4 || strlen($_POST['contrasenia']) > 10) {
        echo json_encode(['error' => 'La contraseña debe tener entre 4 y 10 caracteres']);
        exit;
    }

    if ($_POST['contrasenia'] !== $_POST['confirmarContrasenia']) {
        echo json_encode(['error' => 'Ambas contraseñas deben ser iguales']);
        exit;
    }

    $nombre = $_POST['nombre'];
    $usuario = $_POST['user'];
    $primerApellido = $_POST['apellido1'];
    $segundoApellido = $_POST['apellido2'];
    $correo = $_POST['correo'];
    $contrasenia = hash('sha256', $_POST['contrasenia']);

    try {
        $bd = new PDO('mysql:host=localhost;dbname=reservayjuega;charset=utf8', 'root', '');
    } catch (PDOException $e) {
        echo json_encode(['error' => 'Ha ocurrido un error al conectarse a la base de datos. Avisa al soporte técnico']);
        exit;
    }

    try {
        $bd->beginTransaction();

        $consulta = $bd->prepare("SELECT * FROM user WHERE username = :username");
        $consulta->execute(['username' => $usuario]);

        if ($consulta->rowCount() > 0) {
            echo json_encode(['error' => 'Usuario en uso']);
            $bd->rollBack();
            exit;
        }

        $correoRepetido = $bd->prepare("SELECT * FROM user WHERE correo = :correo");
        $correoRepetido->execute(['correo' => $correo]);

        if ($correoRepetido->rowCount() > 0) {
            echo json_encode(['error' => 'Correo electrónico en uso']);
            $bd->rollBack();
            exit;
        }

        $insercion = $bd->prepare("INSERT INTO user (username, nombre, apellido1, apellido2, correo, contrasenia) VALUES (:username, :nombre, :apellido1, :apellido2, :correo, :contrasenia)");
        $insercion->execute([
            'username' => $usuario,
            'nombre' => $nombre,
            'apellido1' => $primerApellido,
            'apellido2' => $segundoApellido,
            'correo' => $correo,
            'contrasenia' => $contrasenia
        ]);

        if ($insercion->rowCount() > 0) {
            $bd->commit();
            $_SESSION['usuario'] = ['username' => $usuario, 'nombre' => $nombre, 'apellido1' => $primerApellido, 'apellido2' => $segundoApellido, 'correo' => $correo];
            $_SESSION['tipo'] = "consumidor";

            $bd->exec("INSERT INTO consumidor (reservas_realizadas, consumidor) VALUES (0, '$usuario')");

            echo json_encode(['usuario' => $_SESSION['usuario'], 'tipoUsuario' => $_SESSION['tipo']]);
        } else {
            $bd->rollBack();
            echo json_encode(['error' => 'No se pudo registrar el usuario. Inténtelo de nuevo más tarde.']);
        }
    } catch (PDOException $e) {
        $bd->rollBack();
        echo json_encode(['error' => 'Ha ocurrido un error al procesar la solicitud. Avisa al soporte técnico']);
    }
} else {
    header("Location:index.php");
    exit;
}
