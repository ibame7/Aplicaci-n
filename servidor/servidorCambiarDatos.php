<?php
header('Content-Type: application/json');
header("Cache-Control: no-cache, must-revalidate");
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
session_start();

if (!isset($_SESSION['usuario']) || !isset($_SESSION['tipo']) || $_SESSION['tipo'] != "consumidor") {
    header("Location:index.php");
    exit;
}

$_POST = json_decode(file_get_contents('php://input'), true);
if (
    isset($_POST['nombre'], $_POST['username'], $_POST['apellido1'], $_POST['apellido2']) &&
    !empty($_POST['nombre']) && !empty($_POST['username']) && !empty($_POST['apellido1']) && !empty($_POST['apellido2'])
) {
    $nombre = $_POST['nombre'];
    $username = $_POST['username'];
    $primerApellido = $_POST['apellido1'];
    $segundoApellido = $_POST['apellido2'];

    try {
        $bd = new PDO('mysql:host=localhost;dbname=reservayjuega;charset=utf8', 'root', '');
    } catch (PDOException $e) {
        echo json_encode(['error' => 'Ha ocurrido un error al conectarse a la base de datos. Avisa al soporte técnico']);
        exit;
    }

    try {
        $bd->beginTransaction();
        if (isset($_POST['correo']) && !empty($_POST['correo'])) {
            $correo = $_POST['correo'];

            $correoRepetido = $bd->prepare("SELECT * FROM user WHERE correo = :correo");
            $correoRepetido->execute(['correo' => $correo]);

            if ($correoRepetido->rowCount() > 0) {
                echo json_encode(['error' => 'Correo electrónico en uso']);
                $bd->rollBack();
                exit;
            }
        

        $actualizacion = $bd->prepare("UPDATE user SET nombre = :nombre, apellido1 = :apellido1, apellido2 = :apellido2, correo = :correo WHERE username = :username");
        $actualizacion->execute([
            'nombre' => $nombre,
            'apellido1' => $primerApellido,
            'apellido2' => $segundoApellido,
            'correo' => $correo,
            'username' => $username
        ]);
        $_SESSION['usuario'] = ['username' => $username, 'nombre' => $nombre, 'apellido1' => $primerApellido, 'apellido2' => $segundoApellido, 'correo' => $correo];

    } else if (isset($_POST['correoIgual']) && !empty($_POST['correoIgual'])) {
        $actualizacion = $bd->prepare("UPDATE user SET nombre = :nombre, apellido1 = :apellido1, apellido2 = :apellido2 WHERE username = :username");
        $actualizacion->execute([
            'nombre' => $nombre,
            'apellido1' => $primerApellido,
            'apellido2' => $segundoApellido,
            'username' => $username
        ]);
        $_SESSION['usuario'] = ['username' => $username, 'nombre' => $nombre, 'apellido1' => $primerApellido, 'apellido2' => $segundoApellido, 'correo' => $_POST['correoIgual']];

    }
        if ($actualizacion->rowCount() > 0) {
            $bd->commit();
            echo json_encode(['ok' => 'ok']);
        } else {
            $bd->rollBack();
            echo json_encode(['error' => 'Error al editar el usuario']);
        }
    } catch (PDOException $e) {
        $bd->rollBack();
        echo json_encode(['error' => 'Ha ocurrido un error al procesar la solicitud. Avisa al soporte técnico']);
    }
} else if (isset($_POST['password'], $_POST['confirmPassword']) && !empty($_POST['confirmPassword']) && !empty($_POST['password'])) {
    $password = hash('sha256', $_POST['password']);
    $confirmPassword = hash('sha256', $_POST['confirmPassword']);
    $username = $_SESSION['usuario']['username'];
    if (
        strlen($_POST['password']) < 4 || strlen($_POST['password']) > 10 ||
        strlen($_POST['confirmPassword']) < 4 || strlen($_POST['confirmPassword']) > 10
    ) {
        echo json_encode(['error' => 'Las contraseñas deben tener entre 4 y 10 caracteres']);
        exit;
    }

    if ($password == $confirmPassword) {
        try {
            $bd = new PDO('mysql:host=localhost;dbname=reservayjuega;charset=utf8', 'root', '');
        } catch (PDOException $e) {
            echo json_encode(['error' => 'Ha ocurrido un error al conectarse a la base de datos. Avisa al soporte técnico']);
            exit;
        }

        try {
            $bd->beginTransaction();

            $actualizacion = $bd->prepare("UPDATE user SET contrasenia = :password WHERE username = :username");
            $actualizacion->execute([
                'password' => $password,
                'username' => $username
            ]);

            if ($actualizacion->rowCount() > 0) {
                $bd->commit();
                echo json_encode(['ok' => "ok"]);
            } else {
                $bd->rollBack();
                echo json_encode(['error' => 'Error al editar la contraseña']);
            }
        } catch (PDOException $e) {
            $bd->rollBack();
            echo json_encode(['error' => 'Ha ocurrido un error al procesar la solicitud. Avisa al soporte técnico']);
        }
    } else {
        echo json_encode(['error' => 'Ambas contraseñas deben ser iguales']);
    }
} else {
    echo json_encode(['error' => 'Error']);
}
