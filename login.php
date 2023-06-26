<!DOCTYPE html>
<html lang="es">
<head>
  <title>Iniciar sesión</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
  <link rel="stylesheet" type="text/css" href="estilos/estilos.css">
  <link rel="stylesheet" type="text/css" href="estilos/login.css">
  <meta charset="UTF-8">
</head>
<body>
  <div class="container">
    <h3>Iniciar sesión</h3>
    <form action="validar.php" method="post">
      <div class="input-field">
        <input type="text" name="username" id="username" required class="white-text">
        <label for="username">Nombre de usuario</label>
      </div>
      <div class="input-field">
        <input type="password" name="password" id="password" required class="white-text">
        <label for="password">Contraseña</label>
      </div>
      <button type="submit" class="btn waves-effect waves-light">Iniciar sesión</button>
    </form>
    <p>¿No tienes una cuenta? <a href="registrar.php">Regístrate aquí</a></p>
    <a href="index.php" class="btn waves-effect waves-light blue">Atrás</a>
  </div>

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
    });
  </script>
</body>
</html>
