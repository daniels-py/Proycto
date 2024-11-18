<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Establecer la conexión con la base de datos
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "yly_library";

    $conn = new mysqli($servername, $username, $password, $dbname);

    // Verificar si la conexión fue exitosa
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    // Obtener los datos del formulario
    $id_libro = $_POST['id_libro'];
    $id_usuario = $_POST['id_usuario'];
    $titulo_libro = $_POST['titulo_libro'];
    $fecha_prestamo = $_POST['fecha_prestamo'];
    $fecha_devolucion = $_POST['fecha_devolucion'];

    // Insertar el préstamo en la base de datos
    $sql = "INSERT INTO prestamos (id_libro, id_usuario, titulo_libro, fecha_prestamo, fecha_regreso)
            VALUES (?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iisss", $id_libro, $id_usuario, $titulo_libro, $fecha_prestamo, $fecha_devolucion);
    
    if ($stmt->execute()) {
        // Mostrar el mensaje con SweetAlert
        echo "
        <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
        <script>
            Swal.fire({
                title: '¡Éxito!',
                text: 'Préstamo registrado exitosamente.',
                icon: 'success',
                confirmButtonText: 'Aceptar'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = 'listar.php';
                }
            });
        </script>";
    } else {
        // Mostrar el error con SweetAlert
        echo "
        <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
        <script>
            Swal.fire({
                title: 'Error',
                text: 'No se pudo registrar el préstamo: " . $stmt->error . "',
                icon: 'error',
                confirmButtonText: 'Aceptar'
            });
        </script>";
    }

    $stmt->close();
    $conn->close();
}
?>
