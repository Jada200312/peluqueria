<?php
include('conexion.php');
$corteId = $_POST['corteId'];
$consultaPrecio = "SELECT precio FROM cortes WHERE id = $corteId";
$resultadoPrecio = mysqli_query($conexion, $consultaPrecio);
$precio = mysqli_fetch_assoc($resultadoPrecio)['precio'];

// Devuelve el precio como respuesta en formato JSON
echo json_encode(['precio' => $precio]);
?>
