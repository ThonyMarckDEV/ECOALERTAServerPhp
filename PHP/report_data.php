<?php
// Incluir la conexión a la base de datos
include '../conexion.php';

// Inicializar la respuesta
$response = 'error';

// Verificar que todos los parámetros necesarios estén presentes
if (isset($_POST['idUsuario']) && isset($_POST['fecha']) && isset($_POST['descripcion']) && isset($_POST['imagen_url'])) {
    $idUsuario = $_POST['idUsuario'];
    $fecha = $_POST['fecha'];
    $descripcion = $_POST['descripcion'];
    $imagenUrl = $_POST['imagen_url'];  // URL de la imagen que ya fue subida al servidor

    // Insertar el nuevo reporte en la base de datos
    $stmt = $conn->prepare("INSERT INTO reportes (idUsuario, fecha, descripcion, imagen_url) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("isss", $idUsuario, $fecha, $descripcion, $imagenUrl);

    if ($stmt->execute()) {
        $response = 'success';
    } else {
        $response = 'Error al guardar el reporte: ' . $stmt->error;
    }
    $stmt->close();
} else {
    $response = 'Faltan parámetros';
}

echo $response;
$conn->close();
?>
