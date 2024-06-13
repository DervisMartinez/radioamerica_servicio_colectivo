<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--Author-->
  	<meta name="author" content="Radio America">
  	<!-- SEO -->
 	<meta name="description" content="Servicio Público que Presta R.A para toda la colectividad Carabobeña encuentra tus documentos o pertenencias en nuestras instalaciones">
  	<meta property="og:locale" content="es_ES">
  	<meta property="og:url" content="https://radioamerica.com.ve/">
 	<meta property="og:site_name" content="Radio America">
  	<meta property="article:modified_time" content="2024-04-25T14:31:26+00:00">
    <title>Búsqueda de Documento Extraviado en nuestras Oficinas</title>
    <style>
        body {
            font-family: Montserrat, sans-serif;
            background-color: #f0f0f0;
          	background:url(./FONDO.webp);
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
        	background: linear-gradient(50deg,
   			 rgba(113, 0, 0, 0.507)10%,
   			 rgba(255, 255, 255, 0.702)),
    		url(./rateam2.jpg);
    		background-position: center;
   			background-repeat: no-repeat;
    		background-size: cover;
    		padding: 100px;
    		width: 575px;
    		border-radius: 45px;
            overflow-x: auto; /* Agregamos la propiedad overflow-x para que sea scrollable en dispositivos pequeños */
        }

       /* Estilos para dispositivos de escritorio */
	h2 {
    color: #FFFFFF;
    font-size: 30px; /* Tamaño de fuente para dispositivos de escritorio */
    margin-bottom: 25px; /* Espaciado inferior para dispositivos de escritorio */
  	text-align:center;
		}	
     h3 ,td{
       color:#FFFFFF;
     }
      
     th{
       color:#000000;
     }
	      
    label{
     color:#FFFFFF;
    }
      
  	p{
    color:#FFFFFF;  /*Color del Copy y ajuste centrado*/
    text-align:center;
  	}
	
     button[type="submit"]{
       justify-content:center;
       align-items:center;
       cursor:pointer;
     } 
      
      
/* Estilos para dispositivos móviles */
@media(max-width: 600px) {
    h2 {
        color: #ffffff; /* Color de texto blanco para dispositivos móviles */
        font-size: 1.0 rem; /* Tamaño de fuente reducido para dispositivos móviles */
        margin-bottom: 15px; /* Espaciado inferior reducido para dispositivos móviles */
    }
}

		}

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #000000;
        }

        input[type="text"] {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
            margin-bottom: 10px;
          	border-radius: 10px;
        }

        button[type="submit"] {
            padding: 15px 20px;
            font-size: 16px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button[type="submit"]:hover {
            background-color: #0056b3;
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

        /* Estilos para el check de color verde */
        .check {
            color: #28a745; /* Color verde */
        }
      p {
    font-family: "Montserrat",sans-serif;
    font-weight: 500;
    font-size: 12.0 rem; /* Tamaño de fuente más pequeño */
}
    </style>
</head>
<body>
    <div class="container">
      
        <h2>Busca tu Documento Extraviado en nuestras Oficinas</h2>
        <form action="" method="post">
            <label for="numero_documento">Número de Documento:</label>
            <input type="text" id="numero_documento" name="numero_documento">
            <br>
            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre">
            <br>
            <label for="apellido">Apellido:</label>
            <input type="text" id="apellido" name="apellido">
            <br><br>
            <button type="submit" name="buscar">Buscar</button>
        </form>
      
        <p>© Radio América 2024 - Todos los derechos reservados - Realizado por TuFlash Producciones</p> <!-- Nuevo elemento <p> con el texto deseado -->
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

        // Si se ha enviado el formulario de búsqueda
        if (isset($_POST["buscar"])) {
            // Recibir los datos del formulario
            $numero_documento = $_POST['numero_documento'];
            $nombre = $_POST['nombre'];
            $apellido = $_POST['apellido'];

            // Construir la consulta SQL para buscar usuarios
            $sql = "SELECT * FROM usuarios WHERE";

            if (!empty($numero_documento)) {
                $sql .= " numero_documento = '$numero_documento' AND";
            }

            if (!empty($nombre)) {
                $sql .= " nombre LIKE '%$nombre%' AND";
            }

            if (!empty($apellido)) {
                $sql .= " apellido LIKE '%$apellido%' AND";
            }

            // Eliminar la última 'AND' de la consulta
            $sql = rtrim($sql, "AND");

            $result = $conn->query($sql);

            // Mostrar resultados en una tabla
            if ($result->num_rows > 0) {
                echo "<h3>Resultados de la búsqueda:</h3>";
                echo "<table>";
                echo "<tr><th>Nombre</th><th>Apellido</th><th>Número de Documento</th><th>Tipo de Documento</th><th>Documento en Sede</th></tr>";
              	echo "<h3>Retire sus documentos en el Horario comprendido de 9:00AM hasta la 4:00 PM";
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["nombre"] . "</td>";
                    echo "<td>" . $row["apellido"] . "</td>";
                    echo "<td>" . $row["numero_documento"] . "</td>";
                    echo "<td>" . $row["tipo_documento"] . "</td>";
                    echo "<td class='check'>✔</td>"; // Agregamos el check de color verde
                    echo "</tr>";
                }
                echo "</table>";
            } else {
                echo "<p>No se encontraron usuarios que coincidan con los criterios de búsqueda.</p>";
            }
        }

        // Cerrar la conexión a la base de datos
        $conn->close();
        ?>
    </div>
  <!--Link canonico de este buscador -->
  <link rel="canonical" href="https://radioamerica.com.ve/" />
</body>
</html>
