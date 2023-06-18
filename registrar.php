<!DOCTYPE html>
<html>
<head>
  <title>Registrar usuario</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
  <link rel="stylesheet" type="text/css" href="estilos/estilos.css">
  <link rel="stylesheet" type="text/css" href="estilos/registrar.css">
</head>
<body>
  <div class="container">
    <h3>Registrar usuario</h3>
    <form action="registrar_usuario.php" method="post">
      <div class="input-field">
        <input type="text" name="username" id="username" required minlength="4" maxlength="20" class="white-text">
        <label for="username">Nombre de usuario</label>
      </div>
      <div class="input-field">
        <input type="password" name="password" id="password" required minlength="6" maxlength="50" class="white-text">
        <label for="password">Contraseña</label>
      </div>
      <div class="input-field">
        <input type="text" name="nombre" id="nombre" required minlength="3" maxlength="50" class="white-text">
        <label for="nombre">Nombre</label>
      </div>
         <div class="input-field">
        <input type="text" name="celular" id="celular" required minlength="10" maxlength="10" class="white-text">
        <label for="celular">Celular</label>
      <button type="submit" class="btn waves-effect waves-light">Registrar</button>
    </form>
    <p>¿Ya tienes una cuenta? <a href="login.php">Inicia sesión aquí</a></p>
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
