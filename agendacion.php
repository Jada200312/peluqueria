<?php
session_start();
$isLoggedIn = isset($_SESSION['isLoggedIn']) && $_SESSION['isLoggedIn'] === true;
$username = isset($_SESSION['username']) ? $_SESSION['username'] : '';
date_default_timezone_set('America/Bogota');
if (!isset($_SESSION['isLoggedIn']) || $_SESSION['isLoggedIn'] !== true) {
    header('Location: login.php');
    exit();
}
$fechaActual = new DateTime();
$horaActual = $fechaActual->format('H:i');

?>

<!DOCTYPE html>
<html class="dark-mode">
<head>
  <title>Agendar</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="estilos/estilos.css">
  <link rel="stylesheet" type="text/css" href="estilos/agendacion.css">
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

<div class="container">
  <h3 class="center-align">Agenda tu turno</h3>

  <div class="carousel" id="barra-fechas"></div>

  <div class="row">
    <div class="col s12 m8 offset-m2">
      <div class="card-panel">
        <h4>Horarios Disponibles</h4>
        <h5 id="dia-seleccionado"></h5>
        <div id="contenedor-horarios"></div>
      </div>
    </div>
  </div>
</div>

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
          <li><a class="grey-text text-lighten-3" href="#">Reservas</a></li>
          <li><a class="grey-text text-lighten-3" href="#">Servicios</a></li>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment-with-locales.min.js"></script>
<script>
  moment.locale('es');
</script>

<script>
$(document).ready(function() {
  $('#preloader').fadeOut('fast', function() {
    $(this).remove();
  });
  var fechaSeleccionada = null;

  $('.sidenav').sidenav();

  var fechaActual = moment().format('YYYY-MM-DD');
  var horaActual = moment().format('HH:mm');

  for (var i = 0; i < 8; i++) {
    var fechaMostrar = moment().add(i, 'days');
    var diaSemana = fechaMostrar.format('dddd');
    diaSemana = capitalize(diaSemana); // Capitalizar la primera letra
    var fechaMostrarFormatted = fechaMostrar.format('dddd DD [de] MMMM YYYY');

    var tarjeta = $('<div class="carousel-item">');
    var contenidoTarjeta = $('<div class="card hoverable">');
    var contenidoTarjetaHTML = '<div class="card-content"><p class="card-day">' +
      fechaMostrarFormatted + '</p><span class="card-title" id="hidden">' + fechaMostrar.format('YYYY-MM-DD') + '</span></div>';
    contenidoTarjeta.html(contenidoTarjetaHTML);
    tarjeta.append(contenidoTarjeta);
    $('#barra-fechas').append(tarjeta);

    tarjeta.on('click', function() {
      $('.carousel-item').removeClass('active');
      $(this).addClass('active');

      fechaSeleccionada = $(this).find('.card-title').text();
      $('#dia-seleccionado').text('Horarios disponibles para el día ' + fechaSeleccionada);
      obtenerHorariosDisponibles(fechaSeleccionada);
    });
  }

  $('.carousel').carousel();

  function capitalize(string) {
    return string.charAt(0).toUpperCase() + string.slice(1);
  }

  function obtenerHorariosDisponibles(fecha) {
    $.ajax({
      url: 'horarios.php',
      type: 'POST',
      data: { fecha: fecha },
      dataType: 'json',
      success: function(response) {
        mostrarHorarios(response);
      },
      error: function() {
        alert('Error al obtener los horarios disponibles.');
      }
    });
  }

function mostrarHorarios(horarios) {
  $('#contenedor-horarios').empty();
  var filaActual = $('<div class="row">');

  for (var i = 0; i < horarios.length; i++) {
    var hora = horarios[i].hora;
    var estado = horarios[i].estado;

    var form = $('<form action="agendar.php" method="POST">');
    var inputHora = $('<input type="hidden" name="hora">').val(hora);
    var inputFecha = $('<input type="hidden" name="fecha">').val(fechaSeleccionada);
    var boton = $('<button class="waves-effect waves-light btn" type="submit">').text(hora);

    // Comprobar si la fecha y hora actual superan la fecha y hora del horario
    if (fechaSeleccionada === fechaActual && hora < horaActual) {
      boton.addClass('disabled');
    }

    if (estado) {
      boton.addClass('disabled');
    }

    form.append(inputHora);
    form.append(inputFecha);
    form.append(boton);

    var tarjeta = $('<div class="col s12 m6 l3">').append(form);
    filaActual.append(tarjeta);

    if ((i + 1) % 4 === 0) {
      $('#contenedor-horarios').append(filaActual);
      filaActual = $('<div class="row">');
    }
  }

  if (filaActual.children().length > 0) {
    $('#contenedor-horarios').append(filaActual);
  }

  // Aplicar clases de Materialize CSS para diseño responsive
  if ($(window).width() < 992) {
    $('#contenedor-horarios .row').addClass('flex-wrap');
    $('#contenedor-horarios .col').removeClass('s12').addClass('s6');
  } else {
    $('#contenedor-horarios .row').removeClass('flex-wrap');
    $('#contenedor-horarios .col').removeClass('s6').addClass('s12');
  }
}

});





</script>

</body>
</html> 