<?php
// Incluir la conexión a la base de datos
include '../conexion.php';

try {
    // Consulta para obtener los reportes
    $sql = "SELECT idReporte, idUsuario, fecha, descripcion,referencia, imagen_url FROM reportes";  // Cambia "imagen" a "imagen_url"
    $result = $conn->query($sql);

    $reportes = array();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            // No necesitas convertir la imagen a Base64, solo devolver la URL
            $reporte = array(
                'idReporte' => $row['idReporte'],
                'idUsuario' => $row['idUsuario'],
                'fecha' => $row['fecha'],
                'descripcion' => $row['descripcion'],
                'referencia' => $row['referencia'],
                'imagen_url' => $row['imagen_url']  // Devuelve la URL de la imagen
            );
            array_push($reportes, $reporte);
        }
    }

    // Devolver los reportes en formato JSON
    echo json_encode($reportes);

} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}

$conn->close();
?>
