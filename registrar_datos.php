<?php

include('conexion.php');
// Verificar si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $id = $_POST["id"];
    $nombre = $_POST["nombre"];
    $precio = $_POST["precio"];

    
    if (isset($_FILES["imagen"]) && $_FILES["imagen"]["error"] == UPLOAD_ERR_OK) {
        // Directorio de almacenamiento de las imágenes
        $directorio = "imagenes/";

        
        $nombreArchivo = $_FILES["imagen"]["name"];
        $extension = pathinfo($nombreArchivo, PATHINFO_EXTENSION);

        
        $nombreImagen = uniqid() . "." . $extension;

        
        move_uploaded_file($_FILES["imagen"]["tmp_name"], $directorio . $nombreImagen);
    } else {
        
        $nombreImagen = "imagen_default.jpg";
    }

    
 
   
    $sql = "INSERT INTO cortes (id, nombre, precio, imagen)
            VALUES ('$id', '$nombre', '$precio', '$nombreImagen')";
    $result=mysqli_query($conexion,$sql);
    
    if ($result) {
        echo "Los datos se insertaron correctamente.";
    } else {
        echo "Error al insertar los datos:";
    }

   
}
?>
