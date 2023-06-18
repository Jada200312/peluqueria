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
$sql = "SELECT * FROM historial_reservas WHERE id_usuario = ? ORDER BY fecha ASC";
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
<html>
<head>
	<title>Perfil</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="estilos/estilos.css">
  <link rel="stylesheet" type="text/css" href="estilos/perfil.css">
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
				<li><a href="perfil.php"><span class="icon-container"><i class="material-icons">account_circle</i></span>Perfil</a></li>
				<li><a href="salir.php"><span class="icon-container"><i class="material-icons">logout</i></span>Cerrar sesión</a></li>
				<ul class='brand-logo center yellow-text'>
					<!-- Dropdown Trigger -->
					<li><span class="username center-align">¡Hola, <?php echo $username; ?>!</span></li>
				</ul>
			<?php } else { ?>
				<li><a href="index.php"><span class="icon-container"><i class="material-icons">home</i></span>Inicio</a></li>
				<li><a href="cortes.php"><span class="icon-container"><i class="material-icons">grade</i></span>Cortes</a></li>
				<li><a href="login.php"><span class="icon-container"><i class="material-icons">login</i></span>Iniciar sesión</a></li>
			<?php } ?>
		</ul>
	</div>
</nav>

<ul class="sidenav" id="mobile-nav">
	<?php if ($isLoggedIn) { ?>
		<li><a href="index.php"><span class="icon-container"><i class="material-icons">home</i></span>Inicio</a></li>
		<li><a href="cortes.php"><span class="icon-container"><i class="material-icons">grade</i></span>Cortes</a></li>
		<li><a href="perfil.php"><span class="icon-container"><i class="material-icons">account_circle</i></span>Perfil</a></li>
		<li><a href="salir.php"><span class="icon-container"><i class="material-icons">logout</i></span>Cerrar sesión</a></li>
		 <ul class='brand-logo center red-text' style="font-weight: bold;">
					<!-- Dropdown Trigger -->
					<li><span class="username center-align">¡Hola, <?php echo $username; ?>!</span></li>
				</ul>
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
    <table class="responsive-table">
      <thead class="table-success table-striped">
        <tr>
          <th></th>
          <th>Id</th>
          <th>Fecha</th>
          <th>Hora</th>
          <th>Estado</th>
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

            $rowData = '
              <tr class="'.$class.'">
                <td></td>
                <td>'.$row['id'].'</td>
                <td>'.$row['fecha'].'</td>
                <td>'.$row['hora'].'</td>
                <td>'.$status.'</td>
                <td>';

            if ($class === 'pending') {
              $rowData .= '<a href="eliminar_reserva.php?id='.$row['id'].'" class="btn btn-danger btn-sm">Cancelar reserva</a>';
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
