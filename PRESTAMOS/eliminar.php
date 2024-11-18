<?php
// Verificar si el ID se ha pasado por GET
if (isset($_GET['id'])) {
    $id_prestamo = $_GET['id'];

    // Conectar a la base de datos
    $conn = new mysqli("localhost", "root", "", "yly_library");

    // Verificar la conexión
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    // Consulta para eliminar el préstamo
    $query = "DELETE FROM prestamos WHERE id = ?";

    
    // Preparar y ejecutar la consulta
    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param("i", $id_prestamo); // "i" indica que es un parámetro entero
        $stmt->execute();

        // Redirigir después de eliminar
        header("Location: Listar.php");
        exit();
    } else {
        echo "Error al preparar la consulta.";
    }

    $conn->close();
} else {
    echo "ID no proporcionado.";
}
?>
