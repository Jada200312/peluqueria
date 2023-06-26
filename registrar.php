<!DOCTYPE html>
<html lang="es">
<head>
  <title>Registrar usuario</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
  <link rel="stylesheet" type="text/css" href="estilos/estilos.css">
  <link rel="stylesheet" type="text/css" href="estilos/registrar.css">
  <meta charset="UTF-8">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
  <script>
    $(document).ready(function() {
      $('#preloader').fadeOut('fast', function() {
        $(this).remove();
      });
    });

    function checkUsernameAvailability(username) {
  if (username.length < 6) {
    $('#username-message').text('El nombre de usuario debe tener al menos 6 caracteres');
    return;
  }

  $.ajax({
    url: 'verificar_disponibilidad.php',
    type: 'POST',
    data: { username: username },
    success: function(response) {
      if (response === 'available') {
        $('#username-message').text('El nombre de usuario está disponible');
      } else {
        $('#username-message').text('El nombre de usuario no está disponible');
      }
    },
    error: function(xhr, status, error) {
      console.log(error);
    }
  });
}
  </script>
</head>
<body>
  <div class="container">
    <h3>Registrar usuario</h3>
    <form action="registrar_usuario.php" method="post" id="registration-form">
      <div class="input-field">
        <input type="text" name="username" id="username" required minlength="4" maxlength="20" class="white-text" oninput="checkUsernameAvailability(this.value)" autocomplete="off">
        <label for="username">Nombre de usuario</label>
        <p id="username-message"></p>
      </div>
      <div class="input-field">
        <input type="password" name="password" id="password" required minlength="6" maxlength="50" class="white-text" autocomplete="off">
        <label for="password">Contraseña</label>
      </div>
      <div class="input-field">
        <input type="text" name="nombre" id="nombre" required minlength="3" maxlength="50" class="white-text" autocomplete="off">
        <label for="nombre">Nombre</label>
      </div>
      <div class="input-field">
        <input type="text" name="celular" id="celular" required minlength="10" maxlength="10" class="white-text" autocomplete="off">
        <label for="celular">Celular</label>
      </div>
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
</body>
</html>
