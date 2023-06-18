<!DOCTYPE html>
<html>
<head>
    <title>Formulario para insertar datos</title>
    <!-- Agrega los enlaces a los archivos CSS de Materialize -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
</head>
<body>
    <div class="container">
        <h2>Insertar datos en la tabla "cortes"</h2>
        <form action="registrar_datos.php" method="POST" enctype="multipart/form-data">
            <div class="input-field">
                <input type="text" id="id" name="id" required>
                <label for="id">ID</label>
            </div>
            <div class="input-field">
                <input type="text" id="nombre" name="nombre" required>
                <label for="nombre">Nombre</label>
            </div>
            <div class="input-field">
                <input type="number" id="precio" name="precio" step="0.01" required>
                <label for="precio">Precio</label>
            </div>
            <div class="file-field input-field">
                <div class="btn">
                    <span>Imagen</span>
                    <input type="file" name="imagen" accept="image/*" required>
                </div>
                <div class="file-path-wrapper">
                    <input class="file-path validate" type="text">
                </div>
            </div>
            <button class="btn waves-effect waves-light" type="submit">Enviar</button>
        </form>
    </div>

    <!-- Agrega los enlaces a los archivos JavaScript de Materialize -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
</body>
</html>
