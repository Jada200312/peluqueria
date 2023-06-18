<?php  


session_start();


session_destroy();

echo "<script type='text/javascript'>
    
alert('Se cerró la sesión');
window.location.href = 'index.php';
</script>";



exit();






?>