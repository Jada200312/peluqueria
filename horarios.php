<?php

include('conexion.php');


if (!$conexion) {
  die('Error de conexión: ' . mysqli_connect_error());
}


$fechaSeleccionada = $_POST['fecha'];


$horariosDisponibles = array();
$horaInicio = strtotime('09:00');
$horaFin = strtotime('17:30');

while ($horaInicio <= $horaFin) {
  $hora = date('H:i', $horaInicio);

  $query = "SELECT estado FROM horarios WHERE fecha = ? AND hora = ?";
      $stmt = mysqli_prepare($conexion, $query);
      mysqli_stmt_bind_param($stmt, 'ss', $fechaSeleccionada, $hora);
      mysqli_stmt_execute($stmt);
      $resultado = mysqli_stmt_get_result($stmt);

  if (!$resultado) {
    die('Error en la consulta: ' . mysqli_error($conexion));
  }

  if (mysqli_num_rows($resultado) > 0) {
    $fila = mysqli_fetch_assoc($resultado);
    $estado = $fila['estado'];

    if ($estado == 1) {
     
      $horariosDisponibles[] = array(
        'hora' => $hora,
        'estado' => true
      );
    } else {
      
      $horariosDisponibles[] = array(
        'hora' => $hora,
        'estado' => false
      );
    }
  } else {
    
    $horariosDisponibles[] = array(
      'hora' => $hora,
      'estado' => false
    );
  }

  $horaInicio += 1800; 
}


echo json_encode($horariosDisponibles);


mysqli_close($conexion);
?>
