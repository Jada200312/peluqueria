<?php

include('conexion.php');

mysqli_select_db($conexion,$dbname);
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $nombre = $_POST['nombre'];
  $numero = $_POST['numero'];
  $hora = $_POST['hora'];
  $fecha = $_POST['fecha'];
  $estado = 1;
  $usuario = $_POST['sesion'];



$sql="INSERT INTO horarios VALUES(id,'$nombre','$numero','$fecha','$hora','$estado','$usuario')";
$result=mysqli_query($conexion,$sql);
$sql2="INSERT INTO historial_reservas VALUES(id,'$fecha','$hora','$usuario')";
$result2=mysqli_query($conexion,$sql2);




}

if ($result && $result2) {
  echo "<script type='text/javascript'>
    alert('Agendado con éxito');
    window.location.href = 'recibo.php?nombre=" . urlencode($nombre) . "&numero=" . urlencode($numero) . "&hora=" . urlencode($hora) . "&fecha=" . urlencode($fecha) . "';
  </script>";
} else {
  echo "<script type='text/javascript'>
    alert('Error al agendar, vuelva a intentarlo');
    window.location.href = 'agendación.php'
  </script>";
}

?>
