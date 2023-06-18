<?php
session_start();

include('conexion.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $consulta = "SELECT contraseña FROM usuarios WHERE usuario = ?";
    $stmt = mysqli_prepare($conexion, $consulta);
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $resultado = mysqli_stmt_get_result($stmt);

    if ($resultado && mysqli_num_rows($resultado) > 0) {
        $fila = mysqli_fetch_assoc($resultado);
        $contrasenaEncriptada = $fila['contraseña'];

        if (password_verify($password, $contrasenaEncriptada)) {
            $_SESSION['isLoggedIn'] = true;
            $_SESSION['username'] = $username;

            echo "<script type='text/javascript'>
                alert('Inició sesión correctamente');
                window.location.href = 'index.php';
            </script>";
        } else {
            echo "<script type='text/javascript'>
                alert('Usuario o contraseña incorrectos');
                window.location.href = 'login.php';
            </script>";
        }
    } else {
        echo "<script type='text/javascript'>
            alert('Usuario o contraseña incorrectos');
            window.location.href = 'login.php';
        </script>";
    }
}
?>
