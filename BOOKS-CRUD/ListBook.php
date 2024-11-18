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

// Consulta para obtener los usuarios
$query = "SELECT N_Cedula, nombre, email FROM usuarios";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Usuarios</title>
    <!-- Incluir CSS de Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="d-flex" id="wrapper">
    <!-- Sidebar -->
    <div class="bg-dark text-white" id="sidebar" style="width: 250px; height: 100vh; display: flex; flex-direction: column;">
        <div class="sidebar-heading text-center py-4" style="font-size: 18px; font-weight: bold;">Administración de Usuarios</div>
        <div class="list-group list-group-flush flex-grow-1">
            <a href="/Proyecto-JA/USUARIOS/Crud_Usuarios.html" class="list-group-item list-group-item-action bg-dark text-white">Generar Usuario</a>
            <a href="/Proyecto-JA/USUARIOS/listar.php" class="list-group-item list-group-item-action bg-dark text-white">Listar, Editar, Eliminar</a>
            
            <div class="mt-auto">
                <a href="#" class="list-group-item list-group-item-action bg-dark text-white" style="text-align: center;" onclick="confirmarCerrarSesion()">
                    Cerrar sesión
                </a>
            </div>
        </div>
    </div>

    <div class="container mt-5">
        <h2>Listado de Usuarios</h2>
        <div class="row">
            <?php
            // Verificar si hay resultados
            if ($result->num_rows > 0) {
                // Mostrar cada usuario en una tarjeta (card)
                while ($row = $result->fetch_assoc()) {
                    echo "
                    <div class='col-md-4 mb-4'>
                        <div class='card'>
                            <div class='card-body'>
                                <h5 class='card-title'>" . $row['nombre'] . "</h5>
                                <h6 class='card-subtitle mb-2 text-muted'>" . $row['N_Cedula'] . "</h6>
                                <p class='card-text'>" . $row['email'] . "</p>
                                <a href='editar_usuario.php?id=" . $row['N_Cedula'] . "' class='btn btn-warning btn-sm'>Editar</a>
                                <a href='eliminar_usuario.php?id=" . $row['N_Cedula'] . "' class='btn btn-danger btn-sm' onclick='return confirm(\"¿Estás seguro de eliminar este usuario?\")'>Eliminar</a>
                            </div>
                        </div>
                    </div>";
                }
            } else {
                echo "<p>No hay usuarios registrados.</p>";
            }
            ?>
        </div>
    </div>
</div>

<!-- Incluir JS de Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
