<?php
session_start();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php"); // Redirigir al usuario a la página de inicio de sesión si no está autenticado
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Eliminar o Agregar Usuario</title>
    <!-- Estilos y contenido del archivo principal -->
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            width: 800px;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        h2 {
            margin-bottom: 20px;
            color: #333;
        }

        #usuarios-container {
            max-height: 400px; /* Limitamos la altura del contenedor */
            overflow-y: auto; /* Agregamos un scroll vertical */
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
        }

        th {
            background-color: #f2f2f2;
        }

        button {
            padding: 5px 10px;
            font-size: 14px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Añada un nuevo documento :</h2>
        <!-- Formulario para agregar nuevo usuario -->
        <form action="" method="post">
            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" required>
            <br><br>
            <label for="apellido">Apellido:</label>
            <input type="text" id="apellido" name="apellido" required>
            <br><br>
            <label for="documento">Tipo de Documento:</label>
            <select id="documento" name="tipo_documento">
                <option value="cedula">Cédula</option>
                <option value="licencia">Licencia</option>
                <option value="pasaporte">Pasaporte</option>
                <option value="otro">Otro Documento</option>
            </select>
            <br><br>
            <label for="numero_documento">Número de Documento:</label>
            <input type="text" id="numero_documento" name="numero_documento" required>
            <br><br>
            <label for="documento_en_sede">Documento en Sede:</label>
            <select id="documento_en_sede" name="documento_en_sede">
                <option value="si">Sí</option>
                <option value="no">No</option>
            </select>
            <br><br>
            <button type="submit" name="agregar">Agregar Usuario</button>
        </form>
    </div>

    <div class="container"> <!-- Contenedor para la tabla de usuarios existentes -->
        <h2>Usuarios existentes</h2>
        <div id="usuarios-container"> <!-- Contenedor con scroll -->
            <?php
            // Configuración de la conexión a la base de datos
            $servername = "localhost";
            $username = "radioweb_app2AD";
            $password = "t0LYZr7eKo0S";
            $dbname = "radioweb_App2";

            // Crear la conexión a la base de datos
            $conn = new mysqli($servername, $username, $password, $dbname);

            // Verificar la conexión
            if ($conn->connect_error) {
                die("Conexión fallida: " . $conn->connect_error);
            }

            // Si se ha enviado el formulario de agregar, agregar el nuevo usuario
            if (isset($_POST["agregar"])) {
                $nombre = $_POST['nombre'];
                $apellido = $_POST['apellido'];
                $numero_documento = $_POST['numero_documento'];
                $tipo_documento = $_POST['tipo_documento'];
                $documento_en_sede = $_POST['documento_en_sede'];

                // Preparar la consulta SQL para insertar el nuevo usuario
                $sql_insert = "INSERT INTO usuarios (nombre, apellido, numero_documento, tipo_documento, documento_en_sede) VALUES ('$nombre', '$apellido', '$numero_documento', '$tipo_documento', '$documento_en_sede')";

                if ($conn->query($sql_insert) === TRUE) {
                    echo "<p>Usuario agregado correctamente.</p>";
                    // Redireccionar al usuario después de agregar correctamente
                    header("Location: {$_SERVER['PHP_SELF']}");
                    exit();
                } else {
                    echo "Error al agregar usuario: " . $conn->error;
                }
            }

            // Construir la consulta SQL para seleccionar solo los usuarios activos
            $sql_select = "SELECT * FROM usuarios WHERE retirado = 0";
            $result = $conn->query($sql_select);

            // Verificar si hay errores en la consulta
            if (!$result) {
                echo "Error en la consulta: " . $conn->error;
            } else {
                // Mostrar resultados en una tabla si la consulta se ejecutó correctamente
                if ($result->num_rows > 0) {
                    echo "<table>";
                    echo "<tr><th>Nombre</th><th>Apellido</th><th>Número de Documento</th><th>Tipo de Documento</th><th>Documento en Sede</th><th>Acción</th></tr>";
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row["nombre"] . "</td>";
                        echo "<td>" . $row["apellido"] . "</td>";
                        echo "<td>" . $row["numero_documento"] . "</td>";
                        echo "<td>" . $row["tipo_documento"] . "</td>";
                        echo "<td>" . $row["documento_en_sede"] . "</td>";
                        echo "<td><form action='' method='post'><input type='hidden' name='id' value='" . $row["id"] . "'><button type='submit' name='retirado'>Retirado</button></form></td>";
                        echo "</tr>";
                    }
                    echo "</table>";
                } else {
                    echo "<p>No se encontraron usuarios.</p>";
                }
            }

            // Si se ha enviado el formulario de retiro, actualizar el estado del usuario
            if (isset($_POST["retirado"])) {
                $id = $_POST["id"];
                $sql_update = "UPDATE usuarios SET retirado = 1 WHERE id = $id"; // Marcar como retirado
                if ($conn->query($sql_update) === TRUE) {
                    echo "<p>Usuario retirado correctamente.</p>";
                } else {
                    echo "Error al retirar usuario: " . $conn->error;
                }
            }

            // Cerrar la conexión a la base de datos
            $conn->close();
            ?>
        </div>
    </div>
  
    <!--BootStarp 5 || pagination coding-->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
</body>
</html>
