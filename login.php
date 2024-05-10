<?php
header('Content-Type: application/json'); // Esta línea indica que la respuesta es JSON
header("Cache-Control: no-cache, must-revalidate"); // Esta línea ayuda a que la respuesta no se incluya en caché
// Fecha caducada
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); 

// Obtener los datos del POST
$username = $_POST["username"];
$password = $_POST["password"];

// Conexión a la base de datos
$bd = new PDO('mysql:host=localhost;dbname=reservayjuega;charset=utf8', 'root', '');

// Consulta preparada para obtener el usuario por nombre de usuario y contraseña
$consulta = $bd->prepare("SELECT * FROM user WHERE username = :username AND contrasenia = :password");
$consulta->execute(['username' => $username,'password' => $password]);


// Verificar si se encontró un usuario con las credenciales proporcionadas
if ($usuario= $consulta->fetchAll(PDO::FETCH_ASSOC)) {
    // Devolver los datos del usuario en formato JSON
    echo json_encode($usuario);
} else {
    // Devolver un mensaje de error si no se encontró ningún usuario
    echo json_encode(['error' => 'Usuario o contraseña incorrectos','usuario'=>$username,'contrasenia'=>$password]);
}
