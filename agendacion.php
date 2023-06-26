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
$fecha = isset($_GET['fecha']) ? $_GET['fecha'] : '';
$hora = isset($_GET['hora']) ? $_GET['hora'] : '';

?>

<!DOCTYPE html>
<html class="dark-mode" lang="es">
<head>
  <title>Agendar</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="estilos/estilos.css">
  <link rel="stylesheet" type="text/css" href="estilos/agendacion.css">
  <meta charset="UTF-8">
</head>

<style type="text/css">
  .custom-modal {
  width: 80%; /* Ajusta el ancho del modal según tus necesidades */
  max-height: 90vh; /* Ajusta la altura máxima del modal según tus necesidades */
}

.custom-modal .modal-content {
  height: 100%;
  overflow-y: auto; /* Agrega una barra de desplazamiento solo si es necesario */
}
</style>

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

<div class="container">
  <h3 class="center-align">Agenda tu turno</h3>

  <div class="carousel" id="barra-fechas"></div>

  <div class="row">
    <div class="col s12 m8 offset-m2">
      <div class="card-panel">
        <h4>Horarios Disponibles</h4>
       <h5 id="dia-seleccionado"><?php echo 'Fecha seleccionada: ' . $fecha; ?></h5>
        <div id="contenedor-horarios"></div>
      </div>
    </div>
  </div>
</div>

<!-- Modal de Agenda -->
<div id="modal-agenda" class="modal custom-modal">
  <div class="modal-content">
    <h4 class="black-text">Completa tu agenda</h4>
    <form class="container" id="agenda-form" method="POST">
      <div class="input-field">
        <input type="text" name="nombre" placeholder="Ingrese su nombre" required>
      </div>
      <div class="input-field">
        <input type="text" name="numero" placeholder="Ingrese su número" Required minlength="10" maxlength="10" >
      </div>
      <input type="text" class="modal-hora" name="hora" readonly>
      <input type="text" class="modal-fecha" name="fecha" readonly>
      <button id="toggle-select-1" type="button" class="waves-effect waves-green btn">Añadir corte de cabello</button> 
      <button id="toggle-select" type="button" class="waves-effect waves-green btn">Añadir corte de barba</button>
      <div id="select-cortes-container" class="input-field" style="display: none;">
    <select id="select-cortes" name="corte">
    <option value="" disabled selected></option>
    <?php
    include ('conexion.php');
    // Realiza una consulta a la tabla "cortes" para obtener los cortes y sus precios
    $consultaCortes = "SELECT id, nombre, precio FROM cortes Where id_categoria = 1";
    $resultadoCortes = mysqli_query($conexion, $consultaCortes);

    // Itera sobre los resultados y muestra cada corte como una opción en el select
    while ($corte = mysqli_fetch_assoc($resultadoCortes)) {
      echo '<option value="' . $corte['id'] . '">' . $corte['nombre'] . '</option>';
    }
    ?>
  </select>
  <label>Selecciona un corte de cabello</label>
</div>
      <div id="select-cortes-2-container" style="display: none;">
        <div class="input-field">
          <select id="select-cortes-2" name="corte2">
            <option value="" disabled selected></option>
            <?php
            // Obtener los cortes de la categoría 2
            $consultaCortes2 = "SELECT id, nombre, precio FROM cortes WHERE id_categoria = 2";
            $resultadoCortes2 = mysqli_query($conexion, $consultaCortes2);

            while ($corte2 = mysqli_fetch_assoc($resultadoCortes2)) {
              echo '<option value="' . $corte2['id'] . '">' . $corte2['nombre'] . '</option>';
            }
            ?>
          </select>
          <label>Selecciona un corte de barba</label>
        </div>
      </div><br>
  <label>Precio del corte</label>
  <input type="text" id="input-precio" name="precio" readonly>
      <input type="text" value="<?php echo $username; ?>" name="sesion" hidden>
    </form>
  </div>
  <div class="modal-footer">
    <a href="#" class="modal-close waves-effect waves-green btn-flat">Cerrar</a>
    <button type="submit" form="agenda-form" class="waves-effect waves-green btn">Agendar</button>
  </div>
</div>

<div id="modal-recibo" class="modal">
  <div class="modal-content black-text">
    <div id="recibo-content"></div>
  </div>
  <div class="modal-footer">
    <a href="perfil.php#tabla-reservas" class="modal-close waves-effect waves-green btn-flat">Cerrar</a>
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
  var dropdowns = document.querySelectorAll('.dropdown-trigger');
  var options = {
    alignment: 'right',
    coverTrigger: false
  };
  M.Dropdown.init(dropdowns, options);

  $('#preloader').fadeOut('fast', function() {
    $(this).remove();
  });

  var fechaSeleccionada = null;
    $('select').formSelect();

  // Escucha el evento de cambio en el select
var precioCorte1 = 0;
var precioCorte2 = 0;

function actualizarPrecio() {
  var precioTotal = precioCorte1 + precioCorte2;

  // Verifica si los precios son válidos
  if (!isNaN(precioTotal)) {
    $('#input-precio').val(precioTotal);
  } else {
    // En caso de que uno de los precios no sea válido, muestra un mensaje de error
    $('#input-precio').val('Error en los precios');
  }
}
$('#select-cortes').change(function() {
  var corteId = $(this).val();

  // Realiza una petición AJAX para obtener el precio del corte seleccionado
  $.ajax({
    url: 'obtener_precio_corte.php',
    type: 'POST',
    data: { corteId: corteId },
    dataType: 'json',
    success: function(response) {
      // Actualiza el valor de precioCorte1
      precioCorte1 = parseFloat(response.precio);

      // Actualiza el valor del input de precio
      actualizarPrecio();
    },
    error: function() {
      alert('Error al obtener el precio del corte.');
    }
  });
});

$('#select-cortes-2').change(function() {
  var corteId = $(this).val();

  // Realiza una petición AJAX para obtener el precio del corte seleccionado
  $.ajax({
    url: 'obtener_precio_corte.php',
    type: 'POST',
    data: { corteId: corteId },
    dataType: 'json',
    success: function(response) {
      // Actualiza el valor de precioCorte2
      precioCorte2 = parseFloat(response.precio);

      // Actualiza el valor del input de precio
      actualizarPrecio();
    },
    error: function() {
      alert('Error al obtener el precio del corte.');
    }
  });
});

const toggleSelect1Button = document.getElementById('toggle-select-1');
toggleSelect1Button.addEventListener('click', function() {
  const selectCortesContainer = document.getElementById('select-cortes-container');
  if (selectCortesContainer.style.display === 'none') {
    selectCortesContainer.style.display = 'block';
  } else {
    selectCortesContainer.style.display = 'none';
  }
});


const toggleSelectButton = document.getElementById('toggle-select');
  const selectCortes2Container = document.getElementById('select-cortes-2-container');

  toggleSelectButton.addEventListener('click', function() {
    if (selectCortes2Container.style.display === 'none') {
      selectCortes2Container.style.display = 'block';
    } else {
      selectCortes2Container.style.display = 'none';
    }
  });

  $('.sidenav').sidenav();

  var fechaActual = moment().format('YYYY-MM-DD');
  obtenerHorariosDisponibles(fechaActual);  
  if (fechaSeleccionada === fechaActual) {
    $('#dia-seleccionado').text('Horarios disponibles para el día ' + fechaSeleccionada);
  }

  var horaActual = moment().format('HH:mm');

  for (var i = 0; i < 8; i++) {
    var fechaMostrar = moment().add(i, 'days');
    var diaSemana = fechaMostrar.format('dddd');
    diaSemana = capitalize(diaSemana); // Poner la primera letra en mayúscula
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

      // Mostrar horarios disponibles para la fecha seleccionada
      obtenerHorariosDisponibles(fechaSeleccionada);
    });
  }

  $('.carousel').carousel();

  function capitalize(string) {
    return string.charAt(0).toUpperCase() + string.slice(1);
  }

  function obtenerHorariosDisponibles(fecha) {
    fechaSeleccionada = fecha;
    $.ajax({
      url: 'horarios.php',
      type: 'POST',
      data: { fecha: fecha },
      dataType: 'json',
      success: function(response) {
        mostrarHorarios(response, fecha);
      },
      error: function() {
        alert('Error al obtener los horarios disponibles.');
      }
    });
  }

  // Asignar evento click al botón para abrir el modal
  $(document).on('click', '.modal-trigger', function() {
    // Obtener los valores del formulario
    var hora = $(this).text();
    var fecha = $(this).parent().find('input[name="fecha"]').val();

    // Insertar los valores en el modal
    $('#modal-agenda').find('.modal-hora').text(hora);
    $('#modal-agenda').find('.modal-fecha').text(fecha);
    $('#modal-agenda').find('input[name="hora"]').val(hora);
    $('#modal-agenda').find('input[name="fecha"]').val(fecha);

    // Abrir el modal
    $('#modal-agenda').modal('open');
  });

  function mostrarHorarios(horarios, fechaSeleccionada) {
    $('#contenedor-horarios').empty();
    var filaActual = $('<div class="row">');

    for (var i = 0; i < horarios.length; i++) {
      var hora = horarios[i].hora;
      var estado = horarios[i].estado;
      var formatoHora = obtenerFormatoHora(hora); // Obtener el formato AM/PM

      var form = $('<form>');
      var inputHora = $('<input type="hidden" name="hora">').val(hora);
      var inputFecha = $('<input type="hidden" name="fecha">').val(fechaSeleccionada);
      var boton = $('<button class="waves-effect waves-light btn modal-trigger" type="button" data-target="modal-agenda">').text(formatoHora);

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

    // Inicializar el modal
    $('.modal').modal();
  }

  // Agregar evento submit al formulario
$('#agenda-form').on('submit', function(e) {
    e.preventDefault(); // Evitar que el formulario se envíe automáticamente

    // Obtener los valores del formulario
    var form = $(this); // Obtener el formulario actual
    var nombre = form.find('input[name="nombre"]').val();
    var numero = form.find('input[name="numero"]').val();
    var horaAmPm = form.find('input[name="hora"]').val(); // Obtener la hora en formato AM/PM
    var fecha = form.find('input[name="fecha"]').val();
    var sesion = form.find('input[name="sesion"]').val();
    var corte = form.find('#select-cortes').val();
    var corte2 = form.find('#select-cortes-2').val(); 
    var precio = form.find('input[name="precio"]').val();
    var fechaYHora = moment().format('YYYY-MM-DD  HH:mm:ss');
    var fechaFormato = moment().format('YYYY-MM-DD h:mm:ss A');
    var cortecab = $('#select-cortes option:selected').text();
    var cortebar = $('#select-cortes-2 option:selected').text();
    var corteTexto = '';
    if (cortecab !== '' && cortebar !== '') {
  corteTexto = cortecab + ' y ' + cortebar;
} else if (cortecab !== '') {
  corteTexto = cortecab;
} else if (cortebar !== '') {
  corteTexto = cortebar;
}


    // Convertir la hora de AM/PM a formato de 24 horas
    var hora24 = moment(horaAmPm, 'h:mm A').format('HH:mm');

    // Aquí se debe realizar la lógica de registro de la agenda
    // Puedes hacer una solicitud AJAX para enviar los datos al archivo PHP

    // Ejemplo de solicitud AJAX utilizando jQuery
    $.ajax({
      url: 'insertar_agenda.php',
      method: 'POST',
      data: {
        nombre: nombre,
        numero: numero,
        hora: hora24, // Enviar la hora en formato de 24 horas
        hora_am_pm: horaAmPm, // Enviar la hora en formato AM/PM
        fecha: fecha,
        sesion: sesion,
        corte: corte,
        corte2: corte2,
        precio: precio,
        fechaYHora:fechaYHora

      },
      success: function(response) {
        $('#modal-agenda').modal('close');
        // Mostrar la alerta Toast después de registrar la agenda
        M.toast({html: 'Agenda registrada exitosamente!', displayLength: 4000});

  var recibo = '<h4>¡Reserva realizada!</h4>' +
  '<div class="receipt-item">' +
  '<span>Nombre: </span>' +
  '<span>' + nombre + '</span>' +
  '</div>' +
  '<div class="receipt-item">' +
  '<span>Número: </span>' +
  '<span>' + numero + '</span>' +
  '</div>' +
  '<div class="receipt-item">' +
  '<span>Fecha: </span>' +
  '<span>' + fecha + '</span>' +
  '</div>' +
  '<div class="receipt-item">' +
  '<span>Hora: </span>' +
  '<span>' + horaAmPm + '</span>' +
  '</div>' +
  '<div class="receipt-item">' +
  '<span>Fecha de agendación: </span>' +
  '<span>' + fechaFormato + '</span>' +
  '</div>' +
  '<div class="receipt-item">' +
  '<span>Corte:  </span>' +
  '<span>' + corteTexto + '</span>' +
  '</div>' +
  '<div class="receipt-item">' +
  '<span>Precio: </span>' +
  '<span>$' + $('#input-precio').val() + '</span>' +
  '</div>' +
  '<div class="receipt-item">' +
  '<span>¡Gracias por reservar con nosotros!</span>' +
  '</div><br><br><br><br>' +
  '<div class="receipt-item">' +
  '</div>';


        // Insertar el recibo en el modal
        $('#recibo-content').html(recibo);

        // Abrir el modal del recibo
        $('#modal-recibo').modal('open');
      },
      error: function() {
        // Mostrar alerta de error
        M.toast({html: 'Error al agendar, vuelva a intentarlo', displayLength: 4000});

        // Redireccionar a la página de agendación
        window.location.href = 'agendacion.php';
      }
    });
  });

  function obtenerFormatoHora(hora) {
    var partesHora = hora.split(':');
    var horaNumerica = parseInt(partesHora[0]);
    var formatoHora = (horaNumerica < 12) ? 'AM' : 'PM';

    if (horaNumerica === 0) {
      horaNumerica = 12; // Convertir 0 AM a 12 AM
    } else if (horaNumerica > 12) {
      horaNumerica -= 12; // Convertir PM a formato de 12 horas
    }

    var horaFormateada = horaNumerica.toString().padStart(2, '0') + ':' + partesHora[1] + ' ' + formatoHora;
    return horaFormateada;
  }
});

</script>

</body>
</html> 