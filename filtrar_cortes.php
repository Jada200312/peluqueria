<?php
include('conexion.php');

$categoria = $_POST['categoria'];

$sql = "SELECT id, nombre, precio, imagen FROM cortes";

if ($categoria != 'todos') {
  // Agregar la condición WHERE para filtrar por categoría
  $sql .= " WHERE id_categoria = '$categoria'";
}

$result = mysqli_query($conexion, $sql);

if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    echo "<div class='col s12 m6 l4'>
            <div class='card black-text'>
                <div class='card-image'>
                    <img src='imagenes/" . $row["imagen"] . "' alt='" . $row["nombre"] . "'class='responsive-img'>
                </div>
                <div class='card-content'>
                    <span class='card-title'>" . $row["nombre"] . "</span>
                </div>
                <div class='card-action'>
                    <a href='#' class='center-align'>Ver precios</a>
                </div>
            </div>
          </div>";
  }
} else {
  echo "No se encontraron registros.";
}

mysqli_close($conexion);
?>
