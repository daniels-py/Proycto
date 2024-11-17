<?php
// Verificar si se enviaron los datos del formulario
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Establecer la conexión con la base de datos
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "yly_library";


    $conn = new mysqli($servername, $username, $password, $dbname);

    //Verificar la conexión
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    // Obtener los datos del formulario
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Consulta SQL para verificar las credenciales del usuario
    $sql = "SELECT * FROM usuarios WHERE nombre='$username' AND contraseña='$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Usuario autenticado
        $row = $result->fetch_assoc();
        $nombre = $row["nombre"];
        $tipoUsuario = $row["tipo_usuario"];
        if ($tipoUsuario == "Administrador") {
            echo 
            "<div class='fondo'>
            <img src='../Imágenes/logo.jpg' class='logo' alt='img'>
            <div class='message'>¡Bienvenido, $nombre! Eres Administrador.
            </div>
            <a class='boton' href='../index.html'>Ingresar</a>
            <a class='regreso' href='../Login/login.html'>Regresar</a>

            </div>";
        } else {
            echo 
            "<div class='fondo'>
            <div class='message'>¡Bienvenido, $nombre!
            </div>
            </div>";
        }
    } else {
        // Usuario no autenticado
        echo "<div class='message'>Nombre de usuario o contraseña incorrectos.</div>";
    }

    // Cerrar la conexión
    $conn->close();
}
echo "<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <title>Bienvenido¡¡</title>
    <link rel='icon' href='../Imagenes/avicola4.png' type='img/png'>
    <link rel='stylesheet' type='text/css' media='screen' href='../Login/procesar.css'>

</head>
<body>
    
</body>
</html>"
?>