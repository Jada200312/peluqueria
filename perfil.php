<?php
date_default_timezone_set('America/Bogota');
include('conexion.php');
session_start();
if (!isset($_SESSION['isLoggedIn']) || $_SESSION['isLoggedIn'] !== true) {
    header('Location: login.php');
    exit();
}

$username = isset($_SESSION['username']) ? $_SESSION['username'] : '';
$isLoggedIn = isset($_SESSION['isLoggedIn']) && $_SESSION['isLoggedIn'] === true;

// Consulta preparada para evitar inyección SQL
$sql = "SELECT * FROM historial_reservas WHERE id_usuario = ? ORDER BY fecha,hora ASC";
$stmt = mysqli_prepare($conexion, $sql);
mysqli_stmt_bind_param($stmt, "s", $username);
mysqli_stmt_execute($stmt);
$query = mysqli_stmt_get_result($stmt);

// Consulta preparada para obtener datos de usuario
$userDataQuery = mysqli_prepare($conexion, "SELECT * FROM usuarios WHERE usuario = ?");
mysqli_stmt_bind_param($userDataQuery, "s", $username);
mysqli_stmt_execute($userDataQuery);
$userDataResult = mysqli_stmt_get_result($userDataQuery);
$userData = mysqli_fetch_assoc($userDataResult);
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<title>Perfil</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="estilos/estilos.css">
  <link rel="stylesheet" type="text/css" href="estilos/perfil.css">
  <meta charset="UTF-8">
</head>
<body>
<nav>
  <div class="nav-wrapper">
    <a href="#" class="brand-logo">Peluquería</a>
    <a href="#" data-target="mobile-nav" class="sidenav-trigger"><i class="material-icons">menu</i></a>
    <ul id="nav-mobile" class="right hide-on-med-and-down">
      <?php if ($isLoggedIn) { ?>
        <li><a href="index.php"><span class="icon-container"><i class="material-icons">home</i></span>Inicio</a></li>
        <li><a href="cortes.php"><span class="icon-container"><i class="material-icons">grade</i></span>Cortes</a></li>
        <li><a href="agendacion.php"><span class="icon-container"><i class="material-icons">date_range</i></span>Agendar</a></li>
        <li>
          <a class="dropdown-trigger" href="#dropdown-menu" data-target="dropdown-menu">
            <span class="icon-container"><i class="material-icons">person</i></span>
            <?php echo $username; ?>
            <i class="material-icons right">arrow_drop_down</i>
          </a>
        </li>
      <?php } else { ?>
        <li><a href="index.php"><span class="icon-container"><i class="material-icons">home</i></span>Inicio</a></li>
        <li><a href="cortes.php"><span class="icon-container"><i class="material-icons">grade</i></span>Cortes</a></li>
        <li><a href="login.php"><span class="icon-container"><i class="material-icons">login</i></span>Iniciar sesión</a></li>
      <?php } ?>
    </ul>
  </div>
</nav>

<!-- Dropdown Structure -->
<ul id="dropdown-menu" class="dropdown-content" style="background-color: black;">
 <li><a href="perfil.php" class="white-text"><span class="icon-container"><i class="material-icons">account_circle</i></span>Perfil</a></li>
    <li><a href="salir.php" class="white-text"><span class="icon-container"><i class="material-icons">logout</i></span>Cerrar sesión</a></li>
</ul>

<ul class="sidenav" id="mobile-nav">
  <?php if ($isLoggedIn) { ?>
    <ul class='brand-logo center red-text' style="font-weight: bold;">
          <!-- Dropdown Trigger -->
          <li><span class="username center-align">¡Hola, <?php echo $username; ?>!</span></li>
        </ul>
    <li><a href="index.php"><span class="icon-container"><i class="material-icons">home</i></span>Inicio</a></li>
    <li><a href="cortes.php"><span class="icon-container"><i class="material-icons">grade</i></span>Cortes</a></li>
    <li><a href="agendacion.php"><span class="icon-container"><i class="material-icons">date_range</i></span>Agendar</a></li>
    <li><a href="perfil.php"><span class="icon-container"><i class="material-icons">account_circle</i></span>Perfil</a></li>
    <li><a href="salir.php"><span class="icon-container"><i class="material-icons">logout</i></span>Cerrar sesión</a></li>
  <?php } else { ?>
    <li><a href="index.php"><span class="icon-container"><i class="material-icons">home</i></span>Inicio</a></li>
    <li><a href="cortes.php"><span class="icon-container"><i class="material-icons">grade</i></span>Cortes</a></li>
    <li><a href="login.php"><span class="icon-container"><i class="material-icons">login</i></span>Iniciar sesión</a></li>
  <?php } ?>
</ul>
<div class="user-data-container">
	<h2>Mis datos</h2>
	<div class="user-data">
		<label>Usuario:</label>
		<span><?php echo $userData['usuario']; ?></span>
	</div>

	<div class="user-data">
		<label>Contraseña:</label>
		<span class="password"><?php echo "*******"; ?></span>
	</div>

	<div class="user-data">
		<label>Nombre:</label>
		<span><?php echo $userData['nombre']; ?></span>
	</div>

	<div class="user-data">
		<label>Celular:</label>
		<span><?php echo $userData['celular']; ?></span>
	</div>

	<button class="edit-button">Editar</button>
</div>

<div class="table-container">
  <hr>
  <h2 class="center">Historial de reservas</h2>
  <?php
  if (mysqli_num_rows($query) == 0) {
    echo '
      <tr>
        <td colspan="6">
          <strong><span style="font-size: 18px; text-align: center;">No tienes reservas</span></strong>
        </td>
      </tr>
    ';
  } else {
  ?>
  <div class="table-wrapper">
    <table class="responsive-table" id="tabla-reservas">
      <thead class="table-success table-striped">
        <tr>
          <th></th>
          <th>Id</th>
          <th>Fecha</th>
          <th>Hora</th>
          <th>Estado</th>
          <th>Servicios</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
<?php
$rowsPending = '';
$rowsExpired = '';

// Verificar si hay reservas
if (mysqli_num_rows($query) > 0) {
  while ($row = mysqli_fetch_array($query)) {
    $date = $row['fecha'];
    $time = $row['hora'];
    $dateTime = $date . ' ' . $time;
    $dateObj = DateTime::createFromFormat('Y-m-d H:i:s', $dateTime);
    $now = new DateTime();
    $class = $dateObj < $now ? 'expired' : 'pending';
    $status = $dateObj < $now ? 'Expirado' : 'Pendiente';

    // Convertir la hora a formato AM/PM
    $horaAmPm = date_format($dateObj, 'h:i A');

    // Obtener el mes en español
    $mesEspanol = obtenerMesEspanol(date('n', strtotime($date)));

    // Formatear la fecha en "d de {mes en español} - Y" (por ejemplo, "24 de junio - 2023")
    $fechaFormateada = date('j', strtotime($date)) . ' de ' . $mesEspanol . ' - ' . date('Y', strtotime($date));

    // Consultar los servicios realizados por la reserva actual
    $serviciosQuery = mysqli_query($conexion, "SELECT cortes.nombre FROM servicios_reserva 
      INNER JOIN cortes ON servicios_reserva.id_servicio = cortes.id 
      WHERE servicios_reserva.id_reserva = ".$row['id']);
    
    $servicios = array();
    while ($servicioRow = mysqli_fetch_array($serviciosQuery)) {
      $servicios[] = $servicioRow['nombre'];
    }
    $serviciosTexto = implode(', ', $servicios);

    $rowData = '
      <tr class="'.$class.'">
        <td></td>
        <td>'.$row['id'].'</td>
        <td>'.$fechaFormateada.'</td>
        <td>'.$horaAmPm.'</td> 
        <td>'.$status.'</td>
        <td>'.$serviciosTexto.'</td>
        <td>';

    if ($class === 'pending') {
      $rowData .= '<a href="eliminar_reserva.php?id='.$row['id'].'" class="btn btn-danger btn-sm" onclick="return confirm(\'¿Estás seguro de cancelar la reserva?\')">Cancelar reserva</a>';
    }

    $rowData .= '</td>
      </tr>';

    if ($class === 'pending') {
      $rowsPending .= $rowData;
    } else {
      $rowsExpired .= $rowData;
    }
  }

  echo $rowsPending . $rowsExpired;
} 
?>
</tbody>
</table>
</div>
<?php
}

// Función para obtener el nombre del mes en español
function obtenerMesEspanol($mes) {
  $meses = array(
    1 => 'Enero',
    2 => 'Febrero',
    3 => 'Marzo',
    4 => 'Abril',
    5 => 'Mayo',
    6 => 'Junio',
    7 => 'Julio',
    8 => 'Agosto',
    9 => 'Septiembre',
    10 => 'Octubre',
    11 => 'Noviembre',
    12 => 'Diciembre'
  );

  return $meses[$mes];
}
?>

</div>




 <hr><br><br>
<footer class="page-footer">
	<div class="container">
		<div class="row">
			<div class="col s12 l6">
				<h5 class="white-text">Peluquería</h5>
				<p class="grey-text text-lighten-4">Dirección de la peluquería</p>
			</div>
			<div class="col s12 l4 offset-l2">
				<h5 class="white-text">Enlaces</h5>
				<ul>
					<li><a class="grey-text text-lighten-3" href="#">Inicio</a></li>
					<li><a class="grey-text text-lighten-3" href="#">Cortes</a></li>
					<li><a class="grey-text text-lighten-3" href="#">Perfil</a></li>
				</ul>
			</div>
		</div>
	</div>
</footer>
	<div id="preloader">
	<div class="preloader-wrapper">
		<div class="spinner-layer spinner-blue">
			<div class="circle-clipper left">
				<div class="circle"></div>
			</div>
			<div class="gap-patch">
				<div class="circle"></div>
			</div>
			<div class="circle-clipper right">
				<div class="circle"></div>
			</div>
		</div>

		<div class="spinner-layer spinner-red">
			<div class="circle-clipper left">
				<div class="circle"></div>
			</div>
			<div class="gap-patch">
				<div class="circle"></div>
			</div>
			<div class="circle-clipper right">
				<div class="circle"></div>
			</div>
		</div>

		<div class="spinner-layer spinner-yellow">
			<div class="circle-clipper left">
				<div class="circle"></div>
			</div>
			<div class="gap-patch">
				<div class="circle"></div>
			</div>
			<div class="circle-clipper right">
				<div class="circle"></div>
			</div>
		</div>

		<div class="spinner-layer spinner-green">
			<div class="circle-clipper left">
				<div class="circle"></div>
			</div>
			<div class="gap-patch">
				<div class="circle"></div>
			</div>
			<div class="circle-clipper right">
				<div class="circle"></div>
			</div>
		</div>
	</div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
<script>
$(document).ready(function() {
	var dropdowns = document.querySelectorAll('.dropdown-trigger');
    var options = {
      alignment: 'right',
      coverTrigger: false
    };
    M.Dropdown.init(dropdowns, options);
	$('#preloader').fadeOut('fast', function() {
		$(this).remove();
	});
		$('.sidenav').sidenav();
		$('.edit-button').on('click', function() {
			// Lógica para editar los datos del usuario
			alert('Editar datos del usuario');
		});
		window.addEventListener('DOMContentLoaded', (event) => {
	const table = document.getElementById('reservations-table');
	const emptyMessage = document.getElementById('empty-message');
	
	// Verificar si la tabla está vacía
	if (table.rows.length === 1) {  // Se asume que la primera fila es el encabezado de la tabla
		emptyMessage.classList.remove('hidden');
	}
});

	});
</script>
</body>
</html>
