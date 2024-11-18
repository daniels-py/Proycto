<?php
// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "yly_library";

// Crear la conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Consulta para obtener los préstamos
$query = "SELECT 
        prestamos.id, 
        prestamos.fecha_prestamo, 
        prestamos.fecha_regreso,
        libros.titulo AS libro_titulo, 
        usuarios.N_Cedula AS id_usuario
    FROM prestamos
    JOIN libros ON prestamos.id_libro = libros.codigo
    JOIN usuarios ON prestamos.id_usuario = usuarios.N_Cedula
";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Préstamos</title>
    <!-- Incluir CSS de Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="d-flex" id="wrapper">
    <!-- Sidebar -->
    <div class="bg-dark text-white" id="sidebar" style="width: 250px; height: 100vh; display: flex; flex-direction: column;">
        <div class="sidebar-heading text-center py-4" style="font-size: 18px; font-weight: bold;">Administracion de Libros</div>
        <div class="list-group list-group-flush flex-grow-1">
            <a href="/Proyecto-JA/PRESTAMOS/Crud_Prestamos.html" class="list-group-item list-group-item-action bg-dark text-white">Generar Prestamo </a>
            <a href="/Proyecto-JA/PRESTAMOS/listar.php" class="list-group-item list-group-item-action bg-dark text-white">Listar Eliminar Editar </a>
            

            <div class="mt-auto">
            <a href="#" class="list-group-item list-group-item-action bg-dark text-white" style="text-align: center;" onclick="confirmarCerrarSesion()">
                Cerrar sesión
            </a>
        </div>
        </div>

</div>

<div class="container mt-5">
    <h2>Listado de Préstamos</h2>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">titulo</th>
                <th scope="col">Usuario</th>
                <th scope="col">Fecha de Préstamo</th>
                <th scope="col">Fecha de Devolución</th>
                <th scope="col">Acciones</th>
                
            </tr>
        </thead>
        <tbody>
            <?php
            // Verificar si hay resultados
            if ($result->num_rows > 0) {
                // Mostrar cada fila de préstamo
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    
                    echo "<td>" . $row['libro_titulo'] . "</td>";
                    echo "<td>" . $row['id_usuario'] . "</td>";
                    echo "<td>" . $row['fecha_prestamo'] . "</td>";
                    echo "<td>" . $row['fecha_regreso'] . "</td>";
                    echo "<td>
                            <a href='editar.php?id=" . $row['id'] . "' class='btn btn-warning btn-sm'>Editar</a>
                            <a href='eliminar.php?id=" . $row['id'] . "' class='btn btn-danger btn-sm' onclick='return confirm(\"¿Estás seguro de eliminar este préstamo?\")'>Eliminar</a>
                          </td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='5'>No hay préstamos registrados.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<!-- Incluir JS de Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    const menuToggle = document.getElementById('menu-toggle');
    const sidebar = document.getElementById('sidebar');
    menuToggle.addEventListener('click', () => {
        sidebar.classList.toggle('collapse');
    });
</script>

<script>
    function confirmarCerrarSesion() {
    Swal.fire({
        title: '¿Estás seguro?',
        text: "¿Quieres cerrar sesión?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, cerrar sesión',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            // Redirigir a la página de cerrar sesión
            window.location.href = "/Proyecto-JA/index.html";
        }
    });
}
</script>
</body>
</html>

<?php
// Cerrar la conexión
$conn->close();
?>
