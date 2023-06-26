<?php
include('conexion.php');
$username = $_POST['username'];
$sql = "SELECT usuario FROM usuarios WHERE usuario = '$username'";
$result = $conexion->query($sql);

// Comprobar el resultado de la consulta
if ($result->num_rows > 0) {
    // El nombre de usuario ya existe en la base de datos
    echo 'not available';
} else {
    // El nombre de usuario está disponible
    echo 'available';
}

// Cerrar la conexión a la base de datos
$conexion->close();

?>