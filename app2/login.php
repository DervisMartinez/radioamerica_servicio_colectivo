<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST['usuario'];
    $clave = $_POST['clave'];

    // Verificar las credenciales de acceso
    if ($usuario === "(cree un usuario)" && $clave === "******") {
        // Credenciales válidas, crear sesión de usuario
        $_SESSION['usuario'] = $usuario;
        header("Location: archivo_protegido.php"); // Redirigir al archivo protegido
        exit();
    } else {
        $mensaje = "Usuario o contraseña incorrectos";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  	<!--Author-->
  	<meta name="author" content="Radio America">
    <title>Login</title>
    <!--=============== REMIXICONS ===============-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/3.5.0/remixicon.css" crossorigin="">

    <!--=============== CSS ===============-->
    <link rel="stylesheet" href="assets/css/fuentes.css">
</head>
<body>
    <div class="login">
        <img src="assets/img/FONDO.webp" alt="R.A LA ONDA DE LA ALEGRIA"  referrerpolicy="no-referrer" class="login__bg">

        <form action="" method="post" class="login__form">
            <h1 class="login__title">¡ Bienvenido !</h1>

            <div class="login__inputs">
                <div class="login__box">
                    <input type="text" name="usuario" placeholder="Usuario" class="login__input">
                    <i class="ri-mail-fill"></i>
                </div>

                <div class="login__box">
                    <input type="password" name="clave" placeholder="Contraseña" required class="login__input">
                    <i class="ri-lock-2-fill"></i>
                </div>
            </div>

            <button type="submit" class="login__button">Acceder</button>
        </form>

        <?php if (isset($mensaje)) echo "<p class='mensaje'>$mensaje</p>"; ?>
    </div>
  
  	<!--Link canonico de este inicio de sesion -->
    <link rel="canonical" href="https://radioamerica.com.ve/" />
          
</body>
</html>
