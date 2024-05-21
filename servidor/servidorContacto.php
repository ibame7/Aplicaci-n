<?php
header('Content-Type: application/json');
header("Cache-Control: no-cache, must-revalidate");
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");

$_POST = json_decode(file_get_contents('php://input'), true);

if (isset($_POST['nombre'], $_POST['correo'], $_POST['telefono'], $_POST['mensaje']) &&
    !empty($_POST['nombre']) && !empty($_POST['correo']) && !empty($_POST['telefono']) && !empty($_POST['mensaje'])) {

    $id=random_int(1, 99999);
    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];
    $telefono = $_POST['telefono'];
    $mensaje = $_POST['mensaje'];
    
    try {
        $bd = new PDO('mysql:host=localhost;dbname=reservayjuega;charset=utf8', 'root', '');
    } catch (PDOException $e) {
        echo json_encode(['error' => 'Ha ocurrido un error al conectarse a la base de datos. Avisa al soporte técnico']);
        exit;
    }

    try {
        $bd->beginTransaction();        

        $insercion = $bd->prepare("INSERT INTO contacto VALUES (:id,:nombre,:correo,:telefono,:mensaje)");
        $insercion->execute([
            'id'=>$id,
            'nombre' => $nombre,
            'correo' => $correo,
            'telefono' => $telefono,
            'mensaje' => $mensaje,
        ]);

        if ($insercion->rowCount() > 0) {
            $bd->commit();
            echo json_encode(['mensaje' => 'Petición con id '.$id.' creada correctamente']);
        } else {
            $bd->rollBack();
            echo json_encode(['error' => 'No se pudo crear la petición de contacto. Inténtelo de nuevo más tarde.']);
        }
    } catch (PDOException $e) {
        $bd->rollBack();
        echo json_encode(['error' => 'No se pudo crear la petición de contacto. Inténtelo de nuevo más tarde.']);
    }
}else{
    echo json_encode(['error' => 'Ha ocurrido un error al procesar la solicitud. Avisa al soporte técnico']);
}
