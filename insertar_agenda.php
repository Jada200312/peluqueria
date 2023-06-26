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
  $precio = $_POST['precio'];
  $corte1 = $_POST['corte'];
  $corte2 = $_POST['corte2'];
  $fechaAgendacion = $_POST['fechaYHora'];
  var_dump($_POST);


  $sql="INSERT INTO historial_reservas VALUES(null,'$nombre','$numero','$fecha','$hora','$fechaAgendacion','$precio','$usuario')";
  $result=mysqli_query($conexion,$sql);
  $historialReservaId = mysqli_insert_id($conexion);
  $sql2="INSERT INTO horarios VALUES(null,'$fecha','$hora','$estado','$usuario')";
  $result2=mysqli_query($conexion,$sql2);



  if (!empty($corte1) && !empty($corte2)) {
    $sql3 = "INSERT INTO servicios_reserva (id_reserva, id_servicio) VALUES ('$historialReservaId','$corte1')";
$result3 = mysqli_query($conexion, $sql3);
$sql4 = "INSERT INTO servicios_reserva (id_reserva, id_servicio) VALUES ('$historialReservaId','$corte2')";
$result4 = mysqli_query($conexion, $sql4);
  } else if (!empty($corte1)) {
    // Realizar una inserción con el campo corte1
    $sql3 = "INSERT INTO servicios_reserva VALUES('$historialReservaId','$corte1')";
    $result3 = mysqli_query($conexion, $sql3);
  } else if (!empty($corte2)) {
    // Realizar una inserción con el campo corte2
    $sql3 = "INSERT INTO servicios_reserva VALUES('$historialReservaId','$corte2')";
    $result3 = mysqli_query($conexion, $sql3);
  }

  if ($result && $result2) {
    echo json_encode(['success' => true]);
  } else {
    echo json_encode(['success' => false]);
  }


}

?>
