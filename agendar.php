<?php 
session_start();
$username = isset($_SESSION['username']) ? $_SESSION['username'] : '';
?>
<!DOCTYPE html>
<html>
<head>
  <title>Agendar</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
  <link rel="stylesheet" type="text/css" href="estilos/estilos.css">
  <link rel="stylesheet" type="text/css" href="estilos/agendar.css">
</head>
<body>

  <h1>Agende sus datos</h1>

  <form class="container" action="insertar_agenda.php" method="POST">
    <div class="input-field">
      <input type="text" name="nombre" placeholder="Ingrese su nombre" required>
    </div>
    <div class="input-field">
      <input type="text" name="numero" placeholder="Ingrese su número" minlength="10" maxlength="10" >
    </div>
    <input type="text" value="<?php echo $_POST['hora']; ?>" name="hora" readonly>
    <input type="text" value="<?php echo $_POST['fecha']; ?>" name="fecha" readonly>
    <input type="text" value="<?php echo $username; ?>" name="sesion" hidden>
    <button class="btn waves-effect waves-light" type="submit">Enviar</button>
  </form>

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
