<?php
include '../conexion.php';

if (isset($_GET['idReporte'])) {
    $idReporte = $_GET['idReporte'];

    // Obtener el reporte de la tabla reportes
    $sql = "SELECT * FROM reportes WHERE idReporte = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $idReporte);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $reporte = $result->fetch_assoc();

        // Insertar el reporte en la tabla reportes_revisados
        $sql_insert = "INSERT INTO reportes_revisados (idReporte, idUsuario, fecha, descripcion, imagen_url) 
                       VALUES (?, ?, ?, ?, ?)";
        $stmt_insert = $conn->prepare($sql_insert);
        $stmt_insert->bind_param("iisss", 
            $reporte['idReporte'], 
            $reporte['idUsuario'], 
            $reporte['fecha'], 
            $reporte['descripcion'], 
            $reporte['imagen_url']
        );

        if ($stmt_insert->execute()) {
            // Verificar si el reporte se insertó correctamente
            if ($stmt_insert->affected_rows > 0) {
                // Eliminar el reporte original de la tabla reportes
                $sql_delete = "DELETE FROM reportes WHERE idReporte = ?";
                $stmt_delete = $conn->prepare($sql_delete);
                $stmt_delete->bind_param("i", $idReporte);
                $stmt_delete->execute();

                if ($stmt_delete->affected_rows > 0) {
                    echo "Reporte revisado con éxito";
                } else {
                    echo "Error al eliminar el reporte";
                }
            } else {
                echo "Error al insertar el reporte en la tabla reportes_revisados";
            }
        } else {
            echo "Error al insertar en reportes_revisados: " . $stmt_insert->error;
        }
    } else {
        echo "Reporte no encontrado";
    }
} else {
    echo "No se recibió el ID del reporte";
}

$conn->close();
?>
