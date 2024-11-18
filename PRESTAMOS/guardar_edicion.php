<?php
// Verificar si el formulario fue enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Obtener los datos del formulario
    $id = $_POST['id'];
    $titulo = $_POST['titulo'];
    $fecha_prestamo = $_POST['fecha_prestamo'];
    $fecha_regreso = $_POST['fecha_regreso'];

    // Conectar a la base de datos
    $conn = new mysqli("localhost", "root", "", "yly_library");

    // Verificar la conexión
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    // Consulta para actualizar el préstamo en la base de datos
    $query = "UPDATE prestamos
              JOIN libros ON prestamos.id_libro = libros.codigo
              SET prestamos.fecha_prestamo = ?, prestamos.fecha_regreso = ?, libros.titulo = ?
              WHERE prestamos.id = ?";

    // Preparar la consulta
    if ($stmt = $conn->prepare($query)) {
        // Vincular los parámetros
        $stmt->bind_param("sssi", $fecha_prestamo, $fecha_regreso, $titulo, $id);

        // Ejecutar la consulta
        if ($stmt->execute()) {
            echo "Préstamo actualizado correctamente.";
            // Redirigir a la página de listado después de la actualización
            header("Location: listar.php");
            exit();
        } else {
            echo "Error al actualizar el préstamo: " . $stmt->error;
        }

        // Cerrar la declaración
        $stmt->close();
    }

    // Cerrar la conexión
    $conn->close();
}
?>
