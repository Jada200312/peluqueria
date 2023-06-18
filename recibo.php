<!DOCTYPE html>
<html>
<head>
  <title>Recibo de Reserva</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
  <style>
    body {
      background-color: #f5f5f5;
      color: #333;
      padding: 20px;
    }
    
    .container {
      max-width: 600px;
      margin: 0 auto;
      background-color: #fff;
      padding: 20px;
      border-radius: 5px;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
    }
    
    h1 {
      text-align: center;
      margin-bottom: 40px;
    }
    
    .receipt-item {
      display: flex;
      justify-content: space-between;
      margin-bottom: 10px;
    }
 
  </style>
</head>
<body>
  <div class="container">
    <h1>¡Reserva realizada!</h1>

    <div class="receipt-item">
      <span>Nombre:</span>
      <span><?php echo $_GET['nombre']; ?></span>
    </div>

    <div class="receipt-item">
      <span>Número:</span>
      <span><?php echo $_GET['numero']; ?></span>
    </div>

    <div class="receipt-item">
      <span>Fecha:</span>
      <span><?php echo $_GET['fecha']; ?></span>
    </div>

    <div class="receipt-item">
      <span>Hora:</span>
      <span><?php echo $_GET['hora']; ?></span>
    </div>


    <div class="receipt-item">
      <span>¡Gracias por reservar con nosotros!</span>
    </div><br><br><br><br>
     <div class="receipt-item">
      <a href="index.php">Volver al inicio</a>
    </div>
    
  </div>



  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
</body>
</html>
