<?php
include('conexion.php');

// Verificar si se proporcionó un ID válido
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
  $id = $_GET['id'];

  // Preparar la consulta para eliminar la reserva en la tabla "historial_reservas"
  $sql = "DELETE FROM historial_reservas WHERE id = ?";
  $stmt = mysqli_prepare($conexion, $sql);
  mysqli_stmt_bind_param($stmt, "i", $id);
  $query = mysqli_stmt_execute($stmt);

  // Preparar la consulta para eliminar la reserva en la tabla "horarios"
  $sql2 = "DELETE FROM horarios WHERE id = ?";
  $stmt2 = mysqli_prepare($conexion, $sql2);
  mysqli_stmt_bind_param($stmt2, "i", $id);
  $query2 = mysqli_stmt_execute($stmt2);

  // Verificar si las consultas se ejecutaron correctamente
  if ($query && $query2) {
    header("Location: perfil.php");
    exit;
  } else {
    echo "Error al eliminar la reserva.";
  }
} else {
  echo "ID no válido.";
}
?>
