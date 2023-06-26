<?php
session_start();
$isLoggedIn = isset($_SESSION['isLoggedIn']) && $_SESSION['isLoggedIn'] === true;
$username = isset($_SESSION['username']) ? $_SESSION['username'] : '';
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <title>Página Principal</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="estilos/estilos.css">
  <link rel="stylesheet" type="text/css" href="estilos/principal.css">
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


  <div class="carousel">
    <a class="carousel-item" href="#one!"><img src="https://e00-expansion.uecdn.es/assets/multimedia/imagenes/2022/05/19/16529549296005.jpg"></a>
    <a class="carousel-item" href="#two!"><img src="https://content.listisima.com/medio/2022/04/28/cortes-de-pelo-corto-hombre-con-tupe_491dfbb9_220428135229_990x990.webp"></a>
    <a class="carousel-item" href="#three!"><img src="https://static.wixstatic.com/media/4304a4_d7707815b8d940a0b237a7a0c488e563~mv2.webp"></a>
  </div>
  <hr>
  <div class="container">
    <div class="agendar-section">
      <h3>Agenda tu turno</h3>
      <div class="row">
        <p>Agenda tu turno en la peluquería y obtén un nuevo look espectacular. Elige entre los próximos 7 días para encontrar la fecha perfecta que se adapte a tu agenda.  ¡Agenda tu cita ahora!</p>
        <?php if ($isLoggedIn) { ?>
          <a href="agendacion.php" class="btn waves-effect waves-light"><span class="material-icons">
date_range
</span> Agendar</a>
        <?php } else { ?>
          <a href="login.php" class="btn waves-effect waves-light">Iniciar sesión</a>
        <?php } ?>
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
  $('.carousel').carousel();

});

  </script>
</body>
</html
