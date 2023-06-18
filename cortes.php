<?php
  session_start();
  $isLoggedIn = isset($_SESSION['isLoggedIn']) && $_SESSION['isLoggedIn'] === true;
  $username = isset($_SESSION['username']) ? $_SESSION['username'] : '';
?>
  <!DOCTYPE html>
  <html>
  <head>
      <title>Lista de Cortes</title>
      <!-- Agrega los enlaces a los archivos CSS de Materialize -->
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
      <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
      <link rel="stylesheet" type="text/css" href="estilos/estilos.css">
      <link rel="stylesheet" type="text/css" href="estilos/cortes">
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
          <h2>Lista de Cortes</h2>

          <div class="row">

          <?php
         include('conexion.php');
              $sql = "SELECT id, nombre, precio, imagen FROM cortes";
              $result=mysqli_query($conexion,$sql);

          // Verificar si se encontraron registros
          if ($result->num_rows > 0) {
              // Recorrer los resultados y mostrar cada fila en forma de carta
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

     
          ?>

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
    $('#preloader').fadeOut('fast', function() {
      $(this).remove();
    });

    $('.sidenav').sidenav();
  });

    </script>
  </body>
  </html>
