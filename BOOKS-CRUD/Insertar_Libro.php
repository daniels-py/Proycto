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
    $codigo = $_POST['codigo'];
    $titulo = $_POST['titulo'];
    $autor = $_POST['autor'];
    $editorial = $_POST['editorial'];
    $genero = $_POST['genero'];
    $categoria_id = $_POST['categoria_id'];

    // Insertar el libro en la base de datos
    $sql = "INSERT INTO libros (codigo, titulo, autor, editorial, genero, categoria_id)
            VALUES (?, ?, ?, ?, ?, ?)";

    // Preparar y ejecutar la consulta
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("issssi", $codigo, $titulo, $autor, $editorial, $genero, $categoria_id);

        if ($stmt->execute()) {
            // Mostrar el mensaje con SweetAlert
            echo "
            <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
            <script>
                Swal.fire({
                    title: '¡Éxito!',
                    text: 'Libro registrado exitosamente.',
                    icon: 'success',
                    confirmButtonText: 'Aceptar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = 'listar.php'; // Redirigir a la página de listado de libros
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
                    text: 'No se pudo registrar el libro: " . $stmt->error . "',
                    icon: 'error',
                    confirmButtonText: 'Aceptar'
                });
            </script>";
        }

        $stmt->close();
    } else {
        echo "Error en la consulta: " . $conn->error;
    }

    $conn->close();
}
?>
