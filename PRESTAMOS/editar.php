<?php
// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "yly_library";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Verificar si se pasa un id_prestamo por la URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Realizar la consulta para obtener el préstamo por id
    $query = "SELECT prestamos.id, libros.titulo, prestamos.fecha_prestamo, prestamos.fecha_regreso
              FROM prestamos
              JOIN libros ON prestamos.id_libro = libros.codigo
              WHERE prestamos.id = ?";
    
    if ($stmt = $conn->prepare($query)) {
        // Vincular los parámetros
        $stmt->bind_param("i", $id);
        
        // Ejecutar la consulta
        $stmt->execute();
        
        // Obtener el resultado
        $result = $stmt->get_result();
        
        // Verificar si se encontraron resultados
        if ($result->num_rows > 0) {
            // Obtener los datos de la consulta
            $row = $result->fetch_assoc();
        } else {
            // Si no se encuentra el préstamo
            echo "No se encontró el préstamo con ese ID.";
            exit;
        }
    } else {
        echo "Error en la consulta: " . $conn->error;
        exit;
    }
} else {
    echo "No se ha proporcionado un ID de préstamo.";
    exit;
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Préstamo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h2>Editar Préstamo</h2>
    <form action="guardar_edicion.php" method="POST">
        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">

        <div class="form-group">
            <label for="titulo">Título</label>
            <input type="text" class="form-control" name="titulo" value="<?php echo $row['titulo']; ?>" required>
        </div>
        <div class="form-group">
            <label for="fecha_prestamo">Fecha de Préstamo</label>
            <input type="datetime-local" class="form-control" name="fecha_prestamo" value="<?php echo $row['fecha_prestamo']; ?>" required>
        </div>
        <div class="form-group">
            <label for="fecha_regreso">Fecha de Devolución</label>
            <input type="datetime-local" class="form-control" name="fecha_regreso" value="<?php echo $row['fecha_regreso']; ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.min.js"></script>

</body>
</html>
