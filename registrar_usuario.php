<?php
session_start();
include('conexion.php');

function buscaRepetido($username, $conexion)
{
    $username = mysqli_real_escape_string($conexion, $username);

    $sql = "SELECT * FROM usuarios WHERE usuario=?";
    $stmt = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) > 0) {
        return true;
    } else {
        return false;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $nombre = $_POST['nombre'];
    $celular = $_POST['celular'];

    if (buscaRepetido($username, $conexion)) {
        echo "<script type='text/javascript'>
                alert('Error, Usuario ya existente');
                window.location.href = 'registrar.php';
            </script>";
        exit();
    } else {
        $username = mysqli_real_escape_string($conexion, $username);
        $nombre = mysqli_real_escape_string($conexion, $nombre);
        $celular = mysqli_real_escape_string($conexion, $celular);

        // Encripta la contraseña
        $contrasenaEncriptada = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO usuarios (usuario, contraseña, nombre, celular) VALUES (?, ?, ?, ?)";
        $stmt = mysqli_prepare($conexion, $sql);
        mysqli_stmt_bind_param($stmt, "ssss", $username, $contrasenaEncriptada, $nombre, $celular);
        $result = mysqli_stmt_execute($stmt);

        if ($result) {
            echo "<script type='text/javascript'>
                alert('Usuario registrado con éxito');
                window.location.href = 'login.php';
            </script>";
            exit();
        } else {
            echo "<script type='text/javascript'>
                alert('Error al registrar el usuario');
                window.location.href = 'registrar.php';
            </script>";
            exit();
        }
    }
}
?>
